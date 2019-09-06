<?php
/**
 * 会员前台投稿操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('foreground');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class content extends foreground {
	private $times_db;
	function __construct() {
		parent::__construct();
	}
	public function publish() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist');
		
		//判断会员组是否允许投稿
		if(!$grouplist[$memberinfo['groupid']]['allowpost']) {
			showmessage(L('member_group').L('publish_deny'), HTTP_REFERER);
		}

		//判断每日投稿数
		$this->content_check_db = pc_base::load_model('content_check_model');
		$todaytime = strtotime(date('y-m-d',SYS_TIME));
		$allowpostnum = $this->content_check_db->count("`inputtime` > $todaytime");
		if($grouplist[$memberinfo['groupid']]['allowpostnum'] > 0 && $allowpostnum >= $grouplist[$memberinfo['groupid']]['allowpostnum']) {
			showmessage(L('allowpostnum_deny').$grouplist[$memberinfo['groupid']]['allowpostnum'], HTTP_REFERER);
		}
		
		$siteids = getcache('category_content', 'commons');
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			$catid = intval($_POST['info']['catid']);
			$siteid = $siteids[$catid];
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$category = $CATEGORYS[$catid];
			$modelid = $category['modelid'];
			$this->content_db = pc_base::load_model('content_model');
			$this->content_db->set_model($modelid);
			$table_name = $this->content_db->table_name;
			$fields_sys = $this->content_db->get_fields();
			$this->content_db->table_name = $table_name.'_data';
			
			$fields_attr = $this->content_db->get_fields();
			$fields = array_merge($fields_sys,$fields_attr);
			$fields = array_keys($fields);
			$info = array();
			foreach($_POST['info'] as $_k=>$_v) {
				if(in_array($_k, $fields)) $info[$_k] = $_v;
			}
			$post_fields = array_keys($_POST['info']);
			$post_fields = array_intersect_assoc($fields,$post_fields);
			$setting = string2array($category['setting']);
			if($setting['presentpoint'] < 0 && $memberinfo['point'] < abs($setting['presentpoint']))
			showmessage(L('points_less_than',array('point'=>$memberinfo['point'],'need_point'=>abs($setting['presentpoint']))),APP_PATH.'index.php?m=pay&c=deposit&a=pay&exchange=point',3000);
			
			//判断会员组投稿是否需要审核
			if($grouplist[$memberinfo['groupid']]['allowpostverify'] || !$setting['workflowid']) {
				$info['status'] = 99;
			} else {
				$info['status'] = 1;
			}
			$info['username'] = $memberinfo['username'];
			$this->content_db->siteid = $siteid;

			$id = $this->content_db->add_content($info);
			//检查投稿奖励或扣除积分
			$flag = $catid.'_'.$id;
			if($setting['presentpoint']>0) {
				pc_base::load_app_class('receipts','pay',0);
				receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
			} else {
				pc_base::load_app_class('spend','pay',0);
				spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
			}
			//缓存结果
			$model_cache = getcache('model','commons');
			$infos = array();
			foreach ($model_cache as $modelid=>$model) {
				if($model['siteid']==$siteid) {
					$datas = array();
					$this->content_db->set_model($modelid);
					$datas = $this->content_db->select(array('username'=>$memberinfo['username'],'sysadd'=>0),'id,catid,title,url,username,sysadd,inputtime,status',100,'id DESC');
					if($datas) $infos = array_merge($infos,$datas);
				}
			}
			setcache('member_'.$memberinfo['userid'].'_'.$siteid, $infos,'content');
			//缓存结果 END
			if($info['status']==99) {
				showmessage(L('contributors_success'), APP_PATH.'index.php?m=member&c=content&a=published');
			} else {
				showmessage(L('contributors_checked'), APP_PATH.'index.php?m=member&c=content&a=published');
			}
			
		} else {		
			$show_header = $show_dialog = $show_validator = '';
			$temp_language = L('news','','content');
			$sitelist = getcache('sitelist','commons');
			if(!isset($_GET['siteid']) && count($sitelist)>1) {
				include template('member', 'content_publish_select_model');
				exit;
			}
			//设置cookie 在附件添加处调用
			param::set_cookie('module', 'content');
			$siteid = intval($_GET['siteid']);
			if(!$siteid) $siteid = 1;
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			foreach ($CATEGORYS as $catid=>$cat) {
				if($cat['siteid']==$siteid && $cat['child']==0 && $cat['type']==0) break;
			}
			$catid = $_GET['catid'] ? intval($_GET['catid']) : $catid;
			$category = $CATEGORYS[$catid];
			if($category['siteid']!=$siteid) showmessage(L('site_no_category'),'?m=member&c=content&a=publish');
			$setting = string2array($category['setting']);

			if($setting['presentpoint'] < 0 && $memberinfo['point'] < abs($setting['presentpoint']))
			showmessage(L('points_less_than',array('point'=>$memberinfo['point'],'need_point'=>abs($setting['presentpoint']))),APP_PATH.'index.php?m=pay&c=deposit&a=pay&exchange=point',3000);
			if($category['type']!=0) showmessage(L('illegal_operation'));
			$modelid = $category['modelid'];
	
			require CACHE_MODEL_PATH.'content_form.class.php';
			$content_form = new content_form($modelid, $catid, $CATEGORYS);
			$forminfos_data = $content_form->get();
			$forminfos = array();
			foreach($forminfos_data as $_fk=>$_fv) {
				if($_fv['isomnipotent']) continue;
				if($_fv['formtype']=='omnipotent') {
					foreach($forminfos_data as $_fm=>$_fm_value) {
						if($_fm_value['isomnipotent']) {
							$_fv['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$_fv['form']);
						}
					}
				}
				$forminfos[$_fk] = $_fv;
			}
			$formValidator = $content_form->formValidator;
			//去掉栏目id
			unset($forminfos['catid']);
			
			
			$workflowid = $setting['workflowid'];
			header("Cache-control: private");
			include template('member', 'content_publish');
		}
	}
	
	public function published() {
		$memberinfo = $this->memberinfo;
		$sitelist = getcache('sitelist','commons');
		if(!isset($_GET['siteid']) && count($sitelist)>1) {
			include template('member', 'content_publish_select_model');
			exit;
		}
		$_username = $this->memberinfo['username'];
		$_userid = $this->memberinfo['userid'];
		$siteid = intval($_GET['siteid']);
		if(!$siteid) $siteid = 1;
		$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
		$siteurl = siteurl($siteid);
		$pagesize = 20;
		$page = max(intval($_GET['page']),1);
		$workflows = getcache('workflow_'.$siteid,'commons');	
		$this->content_check_db = pc_base::load_model('content_check_model');
		$infos = $this->content_check_db->listinfo(array('username'=>$_username, 'siteid'=>$siteid),'inputtime DESC',$page);
		$datas = array();
		foreach($infos as $_v) {
			$arr_checkid = explode('-',$_v['checkid']);
			$_v['id'] = $arr_checkid[1];
			$_v['url'] = $_v['status']==99 ? go($_v['catid'],$_v['id']) : APP_PATH.'index.php?m=content&c=index&a=show&catid='.$_v['catid'].'&id='.$_v['id'];
			if(!isset($setting[$_v['catid']])) $setting[$_v['catid']] = string2array($CATEGORYS[$_v['catid']]['setting']);
			$workflowid = $setting[$_v['catid']]['workflowid'];
			$_v['flag'] = $workflows[$workflowid]['flag'];
			$datas[] = $_v;
		}
		$pages = $this->content_check_db->pages;
		include template('member', 'content_published');	
	}
	/**
	 * 编辑内容
	 */
	public function edit() {
	$_username = $this->memberinfo['username'];
	if(isset($_POST['dosubmit'])) {
		$catid = $_POST['info']['catid'] = intval($_POST['info']['catid']);
		$CATEGORYS = getcache('category_content', 'commons');
		$category = $CATEGORYS[$catid];
		if($category['type']==0) {
			$id = intval($_POST['id']);
			$catid = $_POST['info']['catid'] = intval($_POST['info']['catid']);
			$this->content_db = pc_base::load_model('content_model');
			$modelid = $category['modelid'];
			$this->content_db->set_model($modelid);
			//判断会员组投稿是否需要审核
			$memberinfo = $this->memberinfo;
			$grouplist = getcache('grouplist');
			$setting = string2array($category['setting']);
			if(!$grouplist[$memberinfo['groupid']]['allowpostverify'] || $setting['workflowid']) {
				$_POST['info']['status'] = 1;
			}
			//echo $_POST['info']['status'];exit;
			$this->content_db->edit_content($_POST['info'],$id);
			$forward = $_POST['forward'];
			showmessage(L('update_success'),$forward);
		}
	} else {
		$show_header = $show_dialog = $show_validator = '';
		$temp_language = L('news','','content');
		//设置cookie 在附件添加处调用
		param::set_cookie('module', 'content');
		$id = intval($_GET['id']);
		if(isset($_GET['catid']) && $_GET['catid']) {
			$catid = $_GET['catid'] = intval($_GET['catid']);
			param::set_cookie('catid', $catid);
			$CATEGORYS = getcache('category_content', 'commons');
			$category = $CATEGORYS[$catid];
			if($category['type']==0) {
				$modelid = $category['modelid'];
				$this->model = getcache('model', 'commons');
				$this->content_db = pc_base::load_model('content_model');
				$this->content_db->set_model($modelid);
	
				$this->content_db->table_name = $this->content_db->db_tablepre.$this->model[$modelid]['tablename'];
				$r = $this->content_db->get_one(array('id'=>$id,'username'=>$_username,'sysadd'=>0));
	
				if(!$r) showmessage(L('illegal_operation'));
				if($r['status']==99) showmessage(L('has_been_verified'));
				$this->content_db->table_name = $this->content_db->table_name.'_data';
				$r2 = $this->content_db->get_one(array('id'=>$id));
				$data = array_merge($r,$r2);
	
				require CACHE_MODEL_PATH.'content_form.class.php';
				$content_form = new content_form($modelid,$catid,$CATEGORYS);
	
				$forminfos_data = $content_form->get($data);
				$forminfos = array();
				foreach($forminfos_data as $_fk=>$_fv) {
					if($_fv['isomnipotent']) continue;
					if($_fv['formtype']=='omnipotent') {
						foreach($forminfos_data as $_fm=>$_fm_value) {
							if($_fm_value['isomnipotent']) {
								$_fv['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$_fv['form']);
							}
						}
					}
					$forminfos[$_fk] = $_fv;
				}
				$formValidator = $content_form->formValidator;
			
				include template('member', 'content_publish');
			}
		}
		header("Cache-control: private");
	}
	}
	/**
	 * 初始化phpsso
	 * about phpsso, include client and client configure
	 * @return string phpsso_api_url phpsso地址
	 */
	private function _init_phpsso() {
		pc_base::load_app_class('client', '', 0);
		define('APPID', pc_base::load_config('system', 'phpsso_appid'));
		$phpsso_api_url = pc_base::load_config('system', 'phpsso_api_url');
		$phpsso_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
		$this->client = new client($phpsso_api_url, $phpsso_auth_key);
		return $phpsso_api_url;
	}
	
}
?>