<?php

/*
	[UCenter] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: note.php 868 2008-12-11 09:18:10Z zhaoxiongfei $
*/

!defined('IN_UC') && exit('Access Denied');

define('UC_NOTE_REPEAT', 5);	//note 通知重复次数
define('UC_NOTE_TIMEOUT', 15);	//note 通知超时时间(秒)
define('UC_NOTE_GC', 10000);	//note 过期通知的回收概率，该值越大，概率越低

define('API_RETURN_FAILED', '-1');

class notemodel {

	var $db;
	var $base;
	var $apps;
	var $operations = array();
	var $notetype = 'HTTP';//note HTTP|INCLUDE

	function __construct(&$base) {
		$this->notemodel($base);
	}

	function notemodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
		$this->apps = $this->base->cache('apps');
		/** note
		 * 1. 操作的名称，如：删除用户，测试连通，删除好友，取TAG数据，更新客户端缓存
		 * 2. 调用的应用的接口参数，拼接规则为 APP_URL/api/uc.php?action=test&ids=1,2,3
		 * 3. 回调的模块名称
		 * 4. 回调的模块方法（$appid, $content）
		 */
		$this->operations = array(
			'test'=>array('', 'action=test'),
			'deleteuser'=>array('', 'action=deleteuser'),
			'renameuser'=>array('', 'action=renameuser'),
			'deletefriend'=>array('', 'action=deletefriend'),
			'gettag'=>array('', 'action=gettag', 'tag', 'updatedata'),
			'getcreditsettings'=>array('', 'action=getcreditsettings'),
			'getcredit'=>array('', 'action=getcredit'),
			'updatecreditsettings'=>array('', 'action=updatecreditsettings'),
			'updateclient'=>array('', 'action=updateclient'),
			'updatepw'=>array('', 'action=updatepw'),
			'updatebadwords'=>array('', 'action=updatebadwords'),
			'updatehosts'=>array('', 'action=updatehosts'),
			'updateapps'=>array('', 'action=updateapps'),
			'updatecredit'=>array('', 'action=updatecredit'),
		);
	}

	/**
	 * 统计通知的总条数
	 *
	 * @return int
	 */
	function get_total_num($all = TRUE) {
	}

	/**
	 * Enter 得到通知列表
	 *
	 * @param int $page
	 * @param int$ppp
	 * @param int $totalnum
	 * @return array 结果集
	 */
	function get_list($page, $ppp, $totalnum, $all = TRUE) {
	}

	/**
	 * 删除通知
	 *
	 * @param string/array $ids
	 * @return 受影响的行数
	 */
	function delete_note($ids) {
	}

	/**
	 * 添加通知列表
	 *
	 * @param string 操作
	 * @param string getdata
	 * @param string postdata
	 * @param array appids 指定通知的 APPID
	 * @param int pri 优先级，值越大表示越高
	 * @return int 插入的ID
	 */
	function add($operation, $getdata='', $postdata='', $appids=array(), $pri = 0) {
		$extra = $varextra = '';
		$appadd = $varadd = array();
		foreach((array)$this->apps as $appid => $app) {
			$appid = $app['appid'];
			if($appid == intval($appid)) {
				if($appids && !in_array($appid, $appids)) {
					$appadd[] = 'app'.$appid."='1'";
				} else {
					$varadd[] = "('noteexists{$appid}', '1')";
				}
			}
		}
		if($appadd) {
			$extra = implode(',', $appadd);
			$extra = $extra ? ', '.$extra : '';
		}
		if($varadd) {
			$varextra = implode(', ', $varadd);
			$varextra = $varextra ? ', '.$varextra : '';
		}

		$getdata = addslashes($getdata);
		$postdata = addslashes($postdata);
		$this->db->query("INSERT INTO ".UC_DBTABLEPRE."notelist SET getdata='$getdata', operation='$operation', pri='$pri', postdata='$postdata'$extra");
		$insert_id = $this->db->insert_id();
		$insert_id && $this->db->query("REPLACE INTO ".UC_DBTABLEPRE."vars (name, value) VALUES ('noteexists', '1')$varextra");
		return $insert_id;
	}

	function send() {
		register_shutdown_function(array($this, '_send'));
	}

	function _send() {
		//note 判断是否有通知

		//note 如果内存表记录不存在，那么可能 mysql 被重启，需要再次判断通知是否存在

		//note 查看是否有通知
		$note = $this->_get_note();
		if(empty($note)) {
			//note 标示为不需要通知
			$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."vars SET name='noteexists".UC_APPID."', value='0'");
			return NULL;
		}

		//note mysql只发送自己的通知
		$this->sendone(UC_APPID, 0, $note);

		//note 垃圾清理
		$this->_gc();
	}

	function sendone($appid, $noteid = 0, $note = '') {
		require_once UC_ROOT.'./lib/xml.class.php';
		$return = FALSE;
		$app = $this->apps[$appid];
		if($noteid) {
			$note = $this->_get_note_by_id($noteid);
		}
		$this->base->load('misc');
		$url = $this->get_url_code($note['operation'], $note['getdata'], $appid);
		$apifilename = isset($app['apifilename']) && $app['apifilename'] ? $app['apifilename'] : 'uc.php';
		if($app['extra']['apppath'] && @include $app['extra']['apppath'].'./api/'.$apifilename) {
			$uc_note = new uc_note();
			$method = $note['operation'];
			if(is_string($method) && !empty($method)) {
				parse_str($note['getdata'], $note['getdata']);
				if(get_magic_quotes_gpc()) {
					$note['getdata'] = $this->base->dstripslashes($note['getdata']);
				}
				$note['postdata'] = xml_unserialize($note['postdata']);
				$response = $uc_note->$method($note['getdata'], $note['postdata']);
			}
			unset($uc_note);
		} else {
			$note['postdata'] = str_replace(array("\n", "\r"), '', $note['postdata']);
			$response = trim($_ENV['misc']->dfopen2($url, 0, $note['postdata'], '', 1, $app['ip'], UC_NOTE_TIMEOUT, TRUE));
		}

		$returnsucceed = $response != '' && ($response == 1 || is_array(xml_unserialize($response)));//note 当确实返回为1的时候才认为是通知成功

		$closedsqladd = $this->_close_note($note, $this->apps, $returnsucceed, $appid) ? ",closed='1'" : '';//

		if($returnsucceed) {
			if($this->operations[$note['operation']][2]) {
				$this->base->load($this->operations[$note['operation']][2]);
				$func = $this->operations[$note['operation']][3];
				$_ENV[$this->operations[$note['operation']][2]]->$func($appid, $response);
			}
			$this->db->query("UPDATE ".UC_DBTABLEPRE."notelist SET app$appid='1', totalnum=totalnum+1, succeednum=succeednum+1, dateline='{$this->base->time}' $closedsqladd WHERE noteid='$note[noteid]'", 'SILENT');
			$return = TRUE;
		} else {
			$this->db->query("UPDATE ".UC_DBTABLEPRE."notelist SET app$appid = app$appid-'1', totalnum=totalnum+1, dateline='{$this->base->time}' $closedsqladd WHERE noteid='$note[noteid]'", 'SILENT');
			$return = FALSE;
		}
		return $return;
	}

	function _get_note() {
		$app_field = 'app'.UC_APPID;
		$data = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."notelist WHERE closed='0' AND $app_field<'1' AND $app_field>'-".UC_NOTE_REPEAT."' LIMIT 1");
		return $data;
	}

	function _gc() {
		rand(0, UC_NOTE_GC) == 0 && $this->db->query("DELETE FROM ".UC_DBTABLEPRE."notelist WHERE closed='1'");
	}

	//note 判断是否需要关闭通知
	function _close_note($note, $apps, $returnsucceed, $appid) {
		$note['app'.$appid] = $returnsucceed ? 1 : $note['app'.$appid] - 1;
		$appcount = count($apps);
		foreach($apps as $key => $app) {
			$appstatus = $note['app'.$app['appid']];
			if(!$app['recvnote'] || $appstatus == 1 || $appstatus <= -UC_NOTE_REPEAT) {
				$appcount--;
			}
		}
		if($appcount < 1) {
			return TRUE;
			//$closedsqladd = ",closed='1'";
		}
	}

	function _get_note_by_id($noteid) {
		$data = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."notelist WHERE noteid='$noteid'");
		return $data;
	}

	function get_url_code($operation, $getdata, $appid) {
		$app = $this->apps[$appid];
		$authkey = UC_KEY;
		$url = $app['url'];
		$apifilename = isset($app['apifilename']) && $app['apifilename'] ? $app['apifilename'] : 'uc.php';
		$action = $this->operations[$operation][1];
		$code = urlencode($this->base->authcode("$action&".($getdata ? "$getdata&" : '')."time=".$this->base->time, 'ENCODE', $authkey));
		return $url."/api/$apifilename?code=$code";
	}

}

?>