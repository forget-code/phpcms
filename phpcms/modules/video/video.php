<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

/**
 * 
 * ------------------------------------------
 * video video class
 * ------------------------------------------
 * 
 * 视频库管理扩展下的视频管理控制器  控制视频添加、修改、删除及从ku6导入视频等
 * 用户在配置好ku6vms账户后才能使用该模块。
 * 在此扩展下对视频的所有操作通过接口同步到ku6vms下面
 * 
 * @package 	PHPCMS V9.1.16
 * @author		chenxuewang
 * @copyright	CopyRight (c) 2006-2012 上海盛大网络发展有限公司
 * 
 */
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global', 'video');


class video extends admin {
	
	public $db,$module_db;
	
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('video_store_model');
		$this->module_db = pc_base::load_model('module_model');
		$this->userid = $_SESSION['userid'];
		pc_base::load_app_class('ku6api', 'video', 0);
		pc_base::load_app_class('v', 'video', 0);
		$this->v =  new v($this->db);
		
		//获取短信平台配置信息
		$this->setting = getcache('video');
		if(empty($this->setting) && ROUTE_A!='setting') {
			showmessage(L('video_setting_not_succfull'), 'index.php?m=video&c=video&a=setting&meunid='.$_GET['meunid']);
		}
		$this->ku6api = new ku6api($this->setting['sn'], $this->setting['skey']);
	}
	
	/**
	 * 
	 * 视频列表
	 */
	public function init() {
		$where = '1';
		$page = $_GET['page'];
		$pagesize = 20;
		if (isset($_GET['type'])) {
			if ($_GET['type']==1) {
				$where .= ' AND `videoid`=\''.$_GET['q'].'\'';
			} else {
				$where .= " AND `title` LIKE '%".$_GET['q']."%'";
			}
		}
		if (isset($_GET['start_time'])) {
			$where .= ' AND `addtime`>=\''.strtotime($_GET['start_time']).'\'';
		}
		if (isset($_GET['end_time'])) {
			$where .= ' AND `addtime`<=\''.strtotime($_GET['end_time']).'\'';
		}
		if (isset($_GET['status'])) {
			$status = intval($_GET['status']);
			$where .= ' AND `status`=\''.$status.'\'';
		}
		$infos = $this->db->listinfo($where, 'videoid DESC', $page, $pagesize);
		$pages = $this->db->pages;
		include $this->admin_tpl('video_list');		
	}
	
	/**
	 * 
	 * 视频添加方法
	 */
	public function add() {
		if ($_POST['dosubmit']) {
			//首先处理，提交过来的数据
			$data['vid'] = $_POST['vid'];
			if (!$data['vid']) showmessage(L('failed_you_video_uploading'), 'index.php?m=video&c=video&a=add');
			$data['title'] = isset($_POST['title']) && trim($_POST['title']) ? trim($_POST['title']) : showmessage(L('video_title_not_empty'), 'index.php?m=video&c=video&a=add&meunid='.$_GET['meunid']);
			$data['description'] = trim($_POST['description']);
			$data['keywords'] = trim(strip_tags($_POST['keywords']));
			//其次向vms post数据，并取得返回值
			$get_data = $this->ku6api->vms_add($data);
			if (!$get_data) {
				showmessage($this->ku6api->error_msg);
			}
			$data['vid'] = $get_data['vid'];
			$data['addtime'] = SYS_TIME;
			$videoid = $this->v->add($data);
			if ($videoid) {
				showmessage(L('operation_success'), 'index.php?m=video&c=video&a=init&meunid='.$_GET['meunid']);
			} else {
				showmessage(L('operation_failure'), 'index.php?m=video&c=video&a=add&meunid='.$_GET['meunid']);
			}
		} else {
			if(!$this->ku6api->testapi()) {
				showmessage(L('vms_sn_skey_error'),'?m=video&c=video&a=setting&menuid='.$_GET['menuid']);
			}
			$flash_info = $this->ku6api->flashuploadparam();
			$show_validator = true;
			include $this->admin_tpl('video_add');
		}
	}
	
	/**
	 * function edit
	 * 视频编辑控制器
	 */
	public function edit() {
		$vid = intval($_GET['vid']);
		if (!$vid) showmessage(L('illegal_parameters'));
		if (isset($_POST['dosubmit'])) {
			//首先处理，提交过来的数据
			$data['vid'] = $_POST['vid'];
			if (!$data['vid']) showmessage(L('failed_you_video_uploading'), 'index.php?m=video&c=video&a=add');
			$data['title'] = isset($_POST['title']) && trim($_POST['title']) ? trim($_POST['title']) : showmessage(L('video_title_not_empty'), 'index.php?m=video&c=video&a=add&meunid='.$_GET['meunid']);
			$data['description'] = trim($_POST['description']);
			$data['keywords'] = trim(strip_tags($_POST['keywords']));
			//其次向vms post数据，并取得返回值
			if ($this->ku6api->vms_edit($data)) {
				$return = $this->v->edit($data, $vid);
				if ($return) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=init');
				else showmessage(L('operation_failure'), 'index.php?m=video&c=video&a=edit&vid='.$vid.'&menuid='.$_GET['menuid']);
			} else {
				showmessage($this->ku6api->error_msg, 'index.php?m=video&c=video&a=edit&vid='.$vid.'&menuid='.$_GET['menuid']);
			}
		} else {
			$show_validator = true;
			$info = $this->db->get_one(array('videoid'=>$vid));
			include $this->admin_tpl('video_edit');
		}
	}
	
	/**
	 * function delete
	 * 删除视频控制器
	 */
	public function delete() {
		$vid = $_GET['vid'];
		$r = $this->db->get_one(array('videoid'=>$vid), 'vid');
		if (!$r) showmessage(L('video_not_exist_or_deleted'));
		if (!$this->ku6api->delete_v($r['vid'])) showmessage(L('operation_failure'), 'index.php?m=video&c=video&a=init&meunid='.$_GET['meunid']);
		$this->v->del_video($vid);	
		showmessage(L('success_next_update_content'), 'index.php?m=video&c=video&a=public_update_content&vid='.$vid.'&meunid='.$_GET['meunid']);
	}
	
	/**
	 * Function UPDATE_CONTENT
	 * 更新与此视频关联的内容模型
	 * @param int $vid 视频库videoid字段
	 */
	public function public_update_content() {
		$videoid = intval($_GET['vid']);
		$video_content_db = pc_base::load_model('video_content_model');
		$meunid = intval($_GET['meunid']);
		$pagesize = 10;
		$result = $video_content_db->select(array('videoid'=>$videoid), '*', $pagesize);
		if (!$result || empty($result)) {
			showmessage(L('update_complete'), 'index.php?m=video&c=video&a=init&meunid='.$meunid);
		}
		//加载更新html类
		$html = pc_base::load_app_class('html', 'content');
		$content_db = pc_base::load_model('content_model');
		$url = pc_base::load_app_class('url', 'content');
		foreach ($result as $rs) {
			$modelid = intval($rs['modelid']);
			$contentid = intval($rs['contentid']);
			$video_content_db->delete(array('videoid'=>$videoid, 'contentid'=>$contentid, 'modelid'=>$modelid));
			$content_db->set_model($modelid);
			$table_name = $content_db->table_name;
			$r1 = $content_db->get_one(array('id'=>$contentid));
			if ($this->ishtml($r1['catid'])) {
				$content_db->table_name = $table_name.'_data';
				$r2 = $content_db->get_one(array('id'=>$contentid));
				$r = array_merge($r1, $r2);unset($r1, $r2);
				if($r['upgrade']) {
					$urls[1] = $r['url'];
				} else {
					$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
				}
				$html->show($urls[1], $r, 0, 'edit');
			} else {
				continue;
			}
		}
		showmessage(L('part_update_complete'), 'index.php?m=video&c=video&a=public_update_content&vid='.$videoid.'&meunid='.$meunid);
	}
	
	/**
	 * Function ISHTML
	 * 判断内容是否需要生成静态
	 * @param int $catid 栏目id
	 */
	private function ishtml($catid = 0) {
		static $ishtml, $catid_siteid;
		if (!$ishtml[$catid]) {
			if (!$catid_siteid) {
				$catid_siteid = getcache('category_content', 'commons');
			} else {
				$siteid = $catid_siteid[$catid];
			}
			$siteid = $catid_siteid[$catid];
			$categorys = getcache('category_content_'.$siteid, 'commons');
			$ishtml[$catid] = $categorys[$catid]['content_ishtml'];
		}
		return $ishtml[$catid];
	}
	
	/**
	 * 
	 * 配置视频参数。包括身份识别码、加密密钥、调用方案编号等信息
	 */
	public function setting() {
		if(isset($_POST['dosubmit'])) {
			$setting = array2string($_POST['setting']);
			setcache('video', $_POST['setting']);
			$this->ku6api->ku6api_skey = $_POST['setting']['skey'];
			$this->ku6api->ku6api_sn = $_POST['setting']['sn'];
			$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
			if(!$this->ku6api->testapi()) {
				showmessage(L('vms_sn_skey_error'),HTTP_REFERER);
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$show_pc_hash = '';
			$v_model_categorys = $this->ku6api->get_categorys(true, $this->setting['catid']);
			$category_list = '<select name="setting[catid]" id="catid"><option value="0">'.L('please_choose_catid').'</option>'.$v_model_categorys.'</select>';
			include $this->admin_tpl('video_setting');
		}
	}
	
	/**
	 * function get_pos 获取推荐位
	 * 根据栏目获取推荐位id，并生成form的select形式
	 */
	public function public_get_pos () {
		$catid = intval($_GET['catid']);
		if (!$catid) exit(0);
		$position = getcache('position','commons');
		if(empty($position)) exit;
		$category = pc_base::load_model('category_model');
		$info = $category->get_one(array('catid'=>$catid), 'modelid, arrchildid');
		if (!$info) exit(0);
		$modelid = $info['modelid'];
		$array = array();
		foreach($position as $_key=>$_value) {
			if($_value['modelid'] && ($_value['modelid'] !=  $modelid) || ($_value['catid'] && strpos(','.$info['arrchildid'].',',','.$catid.',')===false)) continue;
			$array[$_key] = $_value['name'];
		}
		$data = form::select($array, '', 'name="sub[posid]"', L('please_select'));
		exit($data);
	}
	
	/**
	 * Function subscribe_list 获取订阅列表
	 * 获取订阅列表
	 */
	public function subscribe_list() {
		if (isset($_POST['dosubmit'])) {
			if (is_array($_POST['sub']) && !empty($_POST['sub'])) {
				$sub = $_POST['sub'];
				if (!$sub['channelid'] || !$sub['catid']) showmessage(L('please_choose_catid_and_channel'));
				$sub['catid'] = intval($sub['catid']);
				$sub['posid'] = intval($sub['posid']);
				$result = $this->ku6api->subscribe($sub);
				if (!$result) showmessage(L('subscribe_set_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
				else showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list');
			} else {
				showmessage(L('please_choose_catid_and_channel'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
			}
		} else {
			if(!$this->ku6api->testapi()) {
				showmessage(L('vms_sn_skey_error'),'?m=video&c=video&a=setting&menuid='.$_GET['menuid']);
			}
			//获取用户订阅信息
			$v_model_categorys = $this->ku6api->get_categorys(true);
			$category_list = '<select name="sub[catid]" id="catid" onchange="select_pos(this)"><option value="0">'.L('please_choose_catid').'</option>'.$v_model_categorys.'</select>';
			$siteid = get_siteid();
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$ku6_channels = $this->ku6api->get_subscribetype();
			$subscribes = $this->ku6api->get_subscribe();
			$position = getcache('position','commons');
			
			include $this->admin_tpl('subscribe_list');
		}
	}
	
	/**
	 * Function Sub_DEl 删除订阅
	 * 用户删除订阅方法
	 */
	public function sub_del() {
		$id = intval($_GET['id']);
		if (!$id) showmessage(L('illegal_parameters'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		if ($this->ku6api->sub_del($id)) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		else showmessage(L('delete_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
	}
	
	/**
	 * Function video2content 视频库中视频
	 * 用户选择在视频中选择已上传的视频加入到视频字段或编辑器中
	 */
	public function video2content () {
		$page = max(intval($_GET['page']), 1);
		$pagesize = 8;
		$where = '`status` = 21';
		if (isset($_GET['name']) && !empty($_GET['name'])) {
			$title = safe_replace($_GET['name']);
			$where .= " AND `title` LIKE '%$title%'";
		}
		if (isset($_GET['starttime']) && !empty($_GET['starttime'])) {
			$addtime = strtotime($_GET['starttime']);
			$where .= " AND `addtime`>='$addtime'";
		}
		if (isset($_GET['endtime']) && !empty($_GET['endtime'])) {
			$endtime = strtotime($_GET['endtime']);
			$where .= " AND `addtime` <= '$endtime'";
		}
		$show_header = 1;
		$infos = $this->db->listinfo($where, '`videoid` DESC', $page, $pagesize, '', 5);
		$pages = $this->db->pages;
		include $this->admin_tpl('album_list');
	}
	
	/**
	 * 设置swfupload上传的json格式cookie
	 */
	public function swfupload_json() {
		$arr['id'] = intval($_GET['id']);
		$arr['src'] = trim($_GET['src']);
		$arr['title'] = urlencode($_GET['title']);
		$json_str = json_encode($arr);
		$att_arr_exist = param::get_cookie('att_json');
		$att_arr_exist_tmp = explode('||', $att_arr_exist);
		if(is_array($att_arr_exist_tmp) && in_array($json_str, $att_arr_exist_tmp)) {
			return true;
		} else {
			$json_str = $att_arr_exist ? $att_arr_exist.'||'.$json_str : $json_str;
			param::set_cookie('att_json',$json_str);
			return true;			
		}
	}
	
	/**
	 * 删除swfupload上传的json格式cookie
	 */	
	public function swfupload_json_del() {
		$arr['aid'] = intval($_GET['aid']);
		$arr['src'] = trim($_GET['src']);
		$arr['filename'] = urlencode($_GET['filename']);
		$json_str = json_encode($arr);
		$att_arr_exist = param::get_cookie('att_json');
		$att_arr_exist = str_replace(array($json_str,'||||'), array('','||'), $att_arr_exist);
		$att_arr_exist = preg_replace('/^\|\|||\|\|$/i', '', $att_arr_exist);
		param::set_cookie('att_json',$att_arr_exist);
	}	
}

?>