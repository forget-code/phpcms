<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
pc_base::load_app_class('admin', 'admin', 0);
class comment_admin extends admin {
	private $comment_setting_db,$comment_data_db,$comment_db,$siteid;
	function __construct() {
		parent::__construct();
		$this->comment_setting_db = pc_base::load_model('comment_setting_model');
		$this->comment_data_db = pc_base::load_model('comment_data_model');
		$this->comment_db = pc_base::load_model('comment_model');
		$this->siteid = $this->get_siteid();
	}
	
	public function init() {
		$data = $this->comment_setting_db->get_one(array('siteid'=>$this->siteid));
		if (isset($_POST['dosubmit'])) {
			$guest = isset($_POST['guest']) && intval($_POST['guest']) ? intval($_POST['guest']) : 0;
			$check = isset($_POST['check']) && intval($_POST['check']) ? intval($_POST['check']) : 0;
			$code = isset($_POST['code']) && intval($_POST['code']) ? intval($_POST['code']) : 0;
			$add_point = isset($_POST['add_point']) && abs(intval($_POST['add_point'])) ? intval($_POST['add_point']) : 0;
			$del_point = isset($_POST['del_point']) && abs(intval($_POST['del_point'])) ? intval($_POST['del_point']) : 0;
			$sql = array('guest'=>$guest, 'check'=>$check, 'code'=>$code, 'add_point'=>$add_point, 'del_point'=>$del_point);
			if ($data) {
				$this->comment_setting_db->update($sql, array('siteid'=>$this->siteid));
			} else {
				$sql['siteid'] = $this->siteid;
				$this->comment_setting_db->insert($sql);
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$show_header = true;
			include $this->admin_tpl('comment_setting');
		}
	}
	
	public function lists() {
		$show_header = true;
		$commentid =  isset($_GET['commentid']) && trim($_GET['commentid']) ? trim($_GET['commentid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$hot =  isset($_GET['hot']) && intval($_GET['hot']) ? intval($_GET['hot']) : 0;
		$comment = $this->comment_db->get_one(array('commentid'=>$commentid, 'siteid'=>$this->siteid));
		if (empty($comment)) {
			$forward = isset($_GET['show_center_id']) ? 'blank' : HTTP_REFERER;
			showmessage(L('no_comment'), $forward);
		}
		pc_base::load_app_func('global');
		pc_base::load_sys_class('format','', 0);
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pagesize = 20;
		$offset = ($page-1)*$pagesize;
		$this->comment_data_db->table_name($comment['tableid']);
		$desc = 'id desc';
		if (!empty($hot)) {
			$desc = 'support desc, id desc';
		}
		$list = $this->comment_data_db->select(array('commentid'=>$commentid, 'siteid'=>$this->siteid, 'status'=>1), '*', $offset.','.$pagesize, $desc);
		$pages = pages($comment['total'], $page, $pagesize);
		include $this->admin_tpl('comment_data_list');
	}
}