<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class copyfrom extends admin {
	private $db;
	public $siteid;
	function __construct() {
		$this->db = pc_base::load_model('copyfrom_model');
		pc_base::load_sys_class('form', '', 0);
		parent::__construct();
		$this->siteid = $this->get_siteid();
	}
	
	public function init () {
		$datas = array();
		$datas = $this->db->listinfo(array('siteid'=>$this->siteid),'listorder ASC',$_GET['page']);
		$pages = $this->db->pages;

		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=copyfrom&a=add\', title:\''.L('add_copyfrom').'\', width:\'580\', height:\'240\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_copyfrom'));
		$this->public_cache();
		include $this->admin_tpl('copyfrom_list');
	}
	public function add() {
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['siteid'] = $this->siteid;
			if(empty($_POST['info']['sitename'])) showmessage(L('input').L('copyfrom_name'));
			$this->db->insert($_POST['info']);
			showmessage(L('add_success'), '', '', 'add');
		} else {
			$show_header = $show_validator = '';
			
			include $this->admin_tpl('copyfrom_add');
		}
	}
	public function edit() {
		if(isset($_POST['dosubmit'])) {
			$id = intval($_POST['id']);
			$this->db->update($_POST['info'],array('id'=>$id));
			showmessage(L('update_success'), '', '', 'edit');
		} else {
			$show_header = $show_validator = '';
			$id = intval($_GET['id']);
			$r = $this->db->get_one(array('id'=>$id));
			extract($r);
			include $this->admin_tpl('copyfrom_edit');
		}
	}
	public function delete() {
		$_GET['id'] = intval($_GET['id']);
		$this->db->delete(array('id'=>$_GET['id']));
		exit('1');
	}
	
	/**
	 * 排序
	 */
	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'));
		}
	}

	/**
	 * 生成缓存
	 */
	public function public_cache() {
		$infos = $this->db->select('','*','','listorder DESC','','id');
		setcache('copyfrom', $infos, 'admin');
		return true;
 	}
}
?>