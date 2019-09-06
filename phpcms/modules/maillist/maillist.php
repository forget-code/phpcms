<?php
/**
 * Description:
 * 
 * Encoding:    GBK
 * Created on:  2012-4-16-下午5:48:04
 * Author:      kangyun
 * Email:       KangYun.Yun@Snda.Com
 */

defined ( 'IN_PHPCMS' ) or exit ( 'No permission resources.' );
pc_base::load_app_class ( 'admin', 'admin', 0 );

class maillist extends admin {
	
	private $_request_uri = 'http://o.sdo.com/';
	private $_request_actions = array ('isPtExists.ext', 'createPtAndCode.ext', 'cmsapi.ext' );
	private $groups = array();
	private $_charset = '';
	
	function __construct() {
		$charset = pc_base::load_config('database', 'default');
		$this->_charset = $charset['charset'];
		
		pc_base::load_app_func ( 'global' );
		parent::__construct ();
		$this->db = pc_base::load_model ( 'maillist_model' );
		$this->domain = SITE_URL;
		$this->maillist = $this->db->get_one ();
		if (isset ( $this->maillist ['domain'] ) && ! empty ( $this->maillist ['domain'] )) {
			$this->domain = $this->maillist ['domain'];
		}
		$action = $_GET ['a'];
		$menuid = $_GET ['menuid'];
		if (empty ( $this->maillist ) && in_array ( $action, array ('send_setting', 'user_mgr', 'maillist_mgr' ) )) {
			 showMessage(L('first_create_maillist'), '?m=maillist&c=maillist&a=maillist_create&menuid=' . $menuid);
		}
		
		/**
		 * 同步
		 */
		if (!empty ($this->maillist['code']) && !empty ($this->maillist['sdid']) && !empty ($this->maillist['group_addr'])) {
			$menu = pc_base::load_model('menu_model');
			$menu->update(array('display' => '0'), "name='maillist_create'");
			$params = array(
					'action' => 'get_group',
					'domain' => $this->domain,
					'code' => $this->maillist['code'],
					'sdid' => $this->maillist['sdid'],
					'group_addr' => $this->maillist['group_addr']
			);
			$hash = md5(join('', $params) . 'o.sdo');
			$maillist = $this->api($params, $hash, 2, false);
			$this->groups = $maillist;
			
			if ($maillist['group']['status'] == 0) {
				$bind = array(
						'sdid' => $maillist['sdid'],
						'group_name' => $maillist['group']['name'],
						'group_addr' => $maillist['group']['groupAddress'] . '@o.sdo.com',
						'rss_url' => $maillist['group']['rss'],
						'rss_enabled' => $maillist['group']['rssEnable'],
						'rss_rate' => $maillist['group']['rssRate'],
						'rss_number' => $maillist['group']['rssNumber'],
						'descs' => $maillist['group']['description'],
						'email' => $maillist['group']['ownerEmail'],
						'is_activate' => $maillist['group']['status'] == 0 ? 1 : 0
				);
				if ('utf8' != strtolower($this->_charset)) {
					$bind['group_name'] = iconv("UTF-8", $this->_charset, $maillist['group']['name']);
					$bind['descs'] = iconv("UTF-8", $this->_charset, $maillist['group']['description']);
				}

				$this->db->update($bind, 'sdid = '. $this->maillist ['sdid'] );
			
			}
		}
	
	}
	
	function init() {
		$groups = $this->groups;
		
		/*
		 * 获取活动信息
		 */
		
		$params = array ('action' => 'get_activities', 'domain' => $this->domain );
		$hash = md5 ( join ( '', $params ) . 'o.sdo' );
		$data = $this->api ( $params, $hash, 2, false );
		// print_r($data);
		include $this->admin_tpl ( 'init' );
	}
	
	/**
	 * 创建用户
	 */
	function maillist_create() {
		if ($_SERVER ['REQUEST_METHOD'] != 'POST') {
			$menuid = $_GET ['menuid'];
			$pc_hash = $_SESSION ['pc_hash'];
			
			include $this->admin_tpl ( 'create' );
			return;
		}
		
		$act = $_POST ['act'];
		if (! in_array ( $act, array ('check_email', 'create', 'check_addr', 'repeat_send_email', 'activate' ) )) {
			return;
		}
		
		$group_name = trim($_POST ['group_name']);
		$group_addr = $_POST ['group_addr'] . '@o.sdo.com';
		$email = $_POST ['email'];
		$descs = trim($_POST ['descs']);
		$password = $_POST ['pwd'];
		$password2 = $_POST ['pwd2'];
		
		if ('check_email' == $act) {
			$params = array ('email' => $email, 'domain' => $this->domain );
			$hash = md5 ( $email . $this->domain . "o.sdo" );
			$data = $this->api ( $params, $hash, 0 );
			$result = json_decode ( $data, true );
			if (empty ( $result )) {
				die ( json_encode ( array ('status' => false, 'message' => L ( 'sys_error' ) ) ) );
			}
			die ( $data );
		} elseif ('activate' == $act) {
			$params = array ('action' => 'get_group', 'domain' => $this->domain,
					'code' => $this->maillist['code'],
					'sdid' => $this->maillist['sdid'],
					'group_addr' => $this->maillist['group_addr']
					);
			$hash = md5(join('', $params) . 'o.sdo');
			$data = $this->api($params, $hash);
			$result = json_decode($data, true);
			$res = array('status' => false, 'message' => L('activate_fail'));
			if ($result['group']['status'] == 0) {
				$bind = array('is_activate' => 1);
				$this->db->update($bind, 'sdid = ' . $this->maillist['sdid']);
				$res = array('status' => true, 'message' => L('activate_succ'));
				$menu = pc_base::load_model('menu_model');
				$menu->update(array('display' => '0'), "name='maillist_create'");
			}
			die(json_encode($res));
			
		} elseif ('repeat_send_email' == $act) {
			$params = array ('email' => $email, 'domain' => $this->domain );
			$hash = md5 ( $email . $this->domain . "o.sdo" );
			$data = $this->api ( $params, $hash, 0 );
			$result = json_decode ( $data, true );
			$sdid = $result['sdid'];
			$code = $result['code'];
			$params = array(
					'action' => 'resend_activation',
					'domain' => $this->domain,
					'sdid' => $sdid,
					'group_addr' => $this->maillist['group_addr']
					);
			
			$hash = md5(join('', $params) . 'o.sdo');
			$params['code'] = $code;
			$data = $this->api($params, $hash);
			die($data);
		} elseif ('create' == $act) {
			$params = array ('email' => $email, 'domain' => $this->domain );
			$hash = md5 ( $email . $this->domain . "o.sdo" );
			$data = $this->api ( $params, $hash, 0 );
			$result = json_decode ( $data, true );
			if (empty ( $result )) {
				die ( json_encode ( array ('status' => false, 'message' => L ( 'sys_error' ) ) ) );
			}
			
			/*
			 * 不存在，则创建
			 */
			if (! isset ( $result ['sdid'] )) {
				$params = array ('email' => $email, 'domain' => $this->domain, 'password' => base64_encode ( base64_encode ( $password ) ) );
				$hash = md5 ( $this->domain . $email . $password . 'o.sdo' );
				$data = $this->api ( $params, $hash, 1 );
				$result = json_decode ( $data, true );
				if (! $result ['status']) {
					die ( $data );
				}
			}
			$sdid = $result ['sdid'];
			$code = $result ['code'];
			
			/*
			 * 检测组地址是否存在
			 */
			$params = array ('action' => 'is_addr_has', 'group_addr' => $group_addr, 'sdid' => $sdid, 'domain' => $this->domain );
			$hash = md5 ( join ( '', $params ) . 'com.o.sdo' );
			$params ['code'] = $code;
			$data = $this->api ( $params, $hash);
			$result = json_decode($data, true);
			if (!$result['status']) {
				die($data);
			}
			/* 创建组 */
	        $params = array(
	            'action'        => 'create',
	            'code'          => $code,
	            'domain'        => $this->domain,
	            'sdid'          => $sdid,
	        	'group_name'    => $group_name,
	        	'desc'          => $descs,
	            'group_addr'    => $group_addr,
	            'cat_id'        => 46,
	            'cat_sub'       => -1,
	            'email'         => $email,
	            'privacy'       => 0,
	            'level'         => 0,
	            'audit'         => 0,
	        );
	        $md5_action = $params['action'] . $params['group_addr'] . $params['domain'] . 'sdo.o.com';
	        $hash = md5($md5_action);
	        $data = $this->api($params, $hash);
	        $result = json_decode($data, true);
	        if ($result['message'] == 'err.group_exists') {
	        	$result['message'] = L('group_addr_has_tips');
	        }
	        if (!$result['status']) {
	        	die(json_encode($result));
	        }
	        $params = array(
	        		'code' => $code,
	        		'domain' => $this->domain,
	        		'sdid' => $sdid,
	        		'group_addr' => $group_addr,
	        		'email' => $email,
	        		'group_name' => (strtolower($this->_charset) != 'utf8') ? iconv("UTF-8", $this->_charset, urldecode($group_name)) : urldecode($group_name),
	        		'descs'       => (strtolower($this->_charset) != 'utf8') ? iconv("UTF-8", $this->_charset, urldecode($descs)) : urldecode($descs),
	        		'wzz' => $result['wzz']
	       	);
	        $this->db->delete('1=1');
	        if ($this->db->insert($params)) {
	        	die(json_encode(array('status' => true)));
	        }
	        die(json_encode(array('status' => false, 'message' => L('create_maillist_fail'))));
		} elseif ('check_addr' == $act) {
			$params = array ('action' => 'is_addr_has', 'group_addr' => $group_addr, 'domain' => $this->domain );
			$hash = md5 ( join ( '', $params ) . 'com.o.sdo' );
			die ( $this->api ( $params, $hash ) );
		}
	}
	
	/**
	 * 发送设置
	 */
	function send_setting() {
		if ($_SERVER ['REQUEST_METHOD'] != 'POST') {
				if (isset ($_GET['back_msg']) && isset($_GET['url'])) {
					$back_msg = str_replace("\\", "", $_GET['back_msg']);
					$url = base64_decode($_GET['url']);
					file_put_contents("/tmp/maillist_log.txt", date('Y-m-d H:i:s') . "\nback_msg" . $back_msg . "\n", FILE_APPEND);
					$result = json_decode($back_msg, true);
					if ($result['status']) {
						showMessage(L('update_succ'), $url, 3000);
					}
					showMessage(L('update_fail'), $url, 3000);
				}
			
			
			$menuid = $_GET ['menuid'];
			$pc_hash = $_SESSION ['pc_hash'];
			$row = $this->maillist;
			$row['rss_array'] = $this->groups['rss_array'];
			$post_url = $this->_request_uri . $this->_request_actions[2];
			$params = array(
					'action' => 'update_rss',
					'domain' => $this->domain,
					'code' => $this->maillist['code'],
					'sdid' => $this->maillist['sdid'],
					'group_addr' => $this->maillist['group_addr']
			);
			$hash = md5(join('', $params) . 'o.sdo');
			$app_url = pc_base::load_config('system', 'app_path');
			$pos_url = $app_url . 'index.php?m=maillist&c=maillist&a=send_setting&menuid=' . $menuid . '&pc_hash=' . $pc_hash;
			$en_url = base64_encode($pos_url);
			include $this->admin_tpl ( 'rss' );
			return;
		}
		
		$act = $_POST ['act'];
		if ('get_rss_item' == $act) {
			$params = array(
					'action' => 'get_rss',
					'domain' => $this->domain,
					'code' => $this->maillist['code'],
					'sdid' => $this->maillist['sdid'],
					'group_addr' => $this->maillist['group_addr']
			);
			$hash = md5(join('', $params) . 'o.sdo');
			$cat_id = (int)$_POST['cat_id'];
			$params['rss_type'] = $cat_id;
			$result = $this->api($params, $hash);
			die($result);
		} 
	}
	
	/**
	 * 用户发送统计
	 */
	function user_mgr() {
			if (isset ($_GET['back_msg']) && isset($_GET['url'])) {
				$back_msg = str_replace("\\", "", $_GET['back_msg']);
				$url = base64_decode($_GET['url']);
				$result = json_decode($back_msg, true);
				if ($result['status']) {
					showMessage(substr($result['message'], 0, 60) . '...', $url, 3000);
				}
				showMessage(L('update_fail'), $url, 3000);
			}
			
			$menuid = $_GET ['menuid'];
			$pc_hash = $_SESSION ['pc_hash'];			
			$post_url = $this->_request_uri . $this->_request_actions[2];
			$params = array(
					'action' => 'brief_info',
					'domain' => $this->domain,
					'code' => $this->maillist['code'],
					'sdid' => $this->maillist['sdid'],
					'group_addr' => $this->maillist['group_addr']
					);
			$hash = md5(join('', $params) . 'o.sdo');
			$data = $this->api($params, $hash);
			$row = json_decode($data, true);
			if (empty ($row)) {
				$row ['brief_info'] = array();
			}
			$rows = $this->maillist;
			$params['action'] = 'batch_insert';
			$hash = md5(join('', $params) . 'o.sdo');
			$app_url = pc_base::load_config('system', 'app_path');
			$pos_url = $app_url . 'index.php?m=maillist&c=maillist&a=user_mgr&menuid=' . $menuid . '&pc_hash=' . $pc_hash;
			$en_url = base64_encode($pos_url);

			include $this->admin_tpl ( 'user_mgr' );
			return;
	}
	
	/**
	 * 邮件组管理
	 */
	function maillist_mgr() {
		if ($_SERVER ['REQUEST_METHOD'] != 'POST') {
			$menuid = $_GET ['menuid'];
			$pc_hash = $_SESSION ['pc_hash'];
			$row = $this->maillist;
			include $this->admin_tpl ( 'edit' );
			return;
		}
		
		$menuid = $_POST['menuid'];
		$group_name = $_POST['group_name'];
		$descs = $_POST['descs'];
		$params = array(
            'action'        => 'update',
			'code'			=> $this->maillist['code'],
			'group_addr'	=> $this->maillist['group_addr'],
			'domain'		=> $this->domain,			
            'group_name'    => urlencode((strtolower($this->_charset) != 'utf8') ? iconv($this->_charset, "UTF-8", $group_name) : $group_name),    
            'desc'          => urlencode((strtolower($this->_charset) != 'utf8') ? iconv($this->_charset, "UTF-8", $descs) : $descs),
        );
		$hash = md5($params['action'] . $params['code'] . $this->domain . 'o.com');
		$result =$this->api($params, $hash, 2, false);
		if ($result['status']) {
			$bind = array(
					'group_name' => $group_name,
					'descs' => $descs		
			);
			$this->db->update($bind, "sdid='" . $this->maillist['sdid'] . "'");
			showMessage(L('update_succ'), '?m=maillist&c=maillist&a=maillist_mgr&menuid=' . $menuid);
		} else {
			showMessage(L('update_fail'), '?m=maillist&c=maillist&a=maillist_mgr&menuid=' . $menuid);
		}
		
	}

		/**
	 * api请求
	 *
	 * @param $params array
	 *       	 请求参数
	 * @param $hash string
	 *       	 hash
	 * @return string
	 */
	private function api(array $params, $hash, $api = 2, $return_json = true) {
		ini_set ( 'arg_separator.output', '&' );
		$api_url = $this->_request_uri . $this->_request_actions[$api];
		$params ['hash'] = $hash;
		$param = http_build_query ( $params );
		$url = $api_url . '?' . $param;
		$result = file_get_contents ( $url );
		$data = json_decode ( $result, true );
		$error = array ('status' => false, 'message' => L ( 'sys_error' ) );
		if (empty ( $data ) && !$return_json) {
			return $error;
		} elseif (empty ($data) && $return_json) {
			return json_encode ( $error );
		}
		if (! $return_json) {
			return $data;
		}
		return $result;
	}

}
?>
