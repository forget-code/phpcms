<?php
/**
 * 管理员后台会员模块设置
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);

class member_setting extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('module_model');	
	}

	/**
	 * member list
	 */
	function manage() {
		if(isset($_POST['dosubmit'])) {
			$member_setting = array2string($_POST['info']);
			
			$this->db->update(array('module'=>'member', 'setting'=>$member_setting), array('module'=>'member'));
			setcache('member_setting', $_POST['info']);
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$show_scroll = true;
			$member_setting = $this->db->get_one(array('module'=>'member'), 'setting');
			$member_setting = string2array($member_setting['setting']);
			
			include $this->admin_tpl('member_setting');
		}

	}

}
?>