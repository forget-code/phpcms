<?php

/*
	[UCenter] (C)2001-2008 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: pm.php 12126 2008-01-11 09:40:32Z heyond $
*/

!defined('IN_UC') && exit('Access Denied');

class pmcontrol extends base {

	function pmcontrol() {
		$this->base();
		$this->load('user');
		$this->load('pm');
	}

	function oncheck_newpm($arr) {
		@extract($arr, EXTR_SKIP);//uid
		$this->user['uid'] = intval($uid);
		return $_ENV['pm']->check_newpm($this->user['uid']);
	}

	function onsendpm($arr) {
		@extract($arr, EXTR_SKIP);//fromuid, msgto, subject, message, replypmid, isusername
		if($fromuid) {
			$user = $_ENV['user']->get_user_by_uid($fromuid);
			$user = uc_addslashes($user, 1);
			if(!$user) {
				return 0;
			}
			$this->user['uid'] = $user['uid'];
			$this->user['username'] = $user['username'];
		} else {
			$this->user['uid'] = 0;
			$this->user['username'] = '';
			$replypmid = 0;
		}
		if($replypmid) {
			$isusername = 1;
			$pms = $_ENV['pm']->get_pm_by_pmid($this->user['uid'], $replypmid);
			if($pms[0]['msgfromid'] == $this->user['uid']) {
				$user = $_ENV['user']->get_user_by_uid($pms[0]['msgtoid']);
				$msgto = $user['username'];
			} else {
				$msgto = $pms[0]['msgfrom'];
			}
		}

		$msgto = array_unique(explode(',', $msgto));
		$isusername && $msgto = $_ENV['user']->name2id($msgto);
		$blackls = $_ENV['pm']->get_blackls($this->user['uid'], $msgto);
		$lastpmid = 0;
		foreach($msgto as $uid) {
			if(!$fromuid || !in_array('{ALL}', $blackls[$uid])) {
				$blackls[$uid] = $_ENV['user']->name2id($blackls[$uid]);
				if(!$fromuid || isset($blackls[$uid]) && !in_array($this->user['uid'], $blackls[$uid])) {
					$lastpmid = $_ENV['pm']->sendpm($subject, $message, $this->user, $uid, $replypmid);
				}
			}
		}
		return $lastpmid;
	}

	function ondelete($arr) {
		@extract($arr, EXTR_SKIP);//$uid, $folder, $pmids
		$this->user['uid'] = intval($uid);
		return $_ENV['pm']->deletepm($this->user['uid'], $folder, $pmids);
	}

	function onignore($arr) {
		@extract($arr, EXTR_SKIP);//$uid
		$this->user['uid'] = intval($uid);
		$_ENV['pm']->set_ignore($this->user['uid']);
	}

 	function onls($arr) {
 		@extract($arr, EXTR_SKIP);//uid, page, pagesize, folder, filter, msglen
 		$folder = in_array($folder, array('newbox', 'inbox', 'outbox')) ? $folder : 'inbox';
 		$filter = $filter ? (in_array($filter, array('newpm', 'systempm', 'announcepm')) ? $filter : '') : '';
 		$this->user['uid'] = intval($uid);
 		$pmnum = $_ENV['pm']->get_num($this->user['uid'], $folder, $filter);
 		if($pagesize > 0) {
	 		$pms = $_ENV['pm']->get_pm_list($this->user['uid'], $pmnum, $folder, $filter, $this->page_get_start($page, $pagesize, $pmnum), $pagesize);
	 		if(is_array($pms) && !empty($pms)) {
				foreach($pms as $key => $pm) {
					if($msglen) {
						$pms[$key]['message']{0} == "\t" && $pms[$key]['message'] = substr($pms[$key]['message'], 1);
						$pms[$key]['message'] = $_ENV['pm']->removecode($pms[$key]['message'], $msglen);
					} else {
						unset($pms[$key]['message']);
					}
					unset($pms[$key]['folder']);
				}
			}
			$result['data'] = $pms;
		}
		$result['count'] = $pmnum;
 		return $result;
 	}

 	function onviewnode($arr) {
 		@extract($arr, EXTR_SKIP);//uid, pmid, type
 		$this->user['uid'] = intval($uid);
		$pmid = $_ENV['pm']->pmintval($pmid);
 		$pm = $_ENV['pm']->get_pmnode_by_pmid($this->user['uid'], $pmid, $type);
 	 	if($pm) {
 	 		require_once UC_ROOT.'lib/uccode.class.php';
			$this->uccode = new uccode();
			$pm['message'] = $this->uccode->complie($pm['message']);
			return $pm;
		}
 	}

 	function onview($arr) {
 		@extract($arr, EXTR_SKIP);//uid, pmid
 		$this->user['uid'] = intval($uid);
		$pmid = $_ENV['pm']->pmintval($pmid);
 		$pms = $_ENV['pm']->get_pm_by_pmid($this->user['uid'], $pmid);
 	 	require_once UC_ROOT.'lib/uccode.class.php';
		$this->uccode = new uccode();
		foreach($pms as $key => $pm) {
			$pms[$key]['message'] = $this->uccode->complie($pms[$key]['message']);
			!$status && $status = $pm['msgtoid'] && $pm['new'];
		}
		$status && $_ENV['pm']->set_pm_status($this->user['uid'], $pmid);
		return $pms;
 	}

 	function onblackls_get($arr) {
 		@extract($arr, EXTR_SKIP);//uid
 		$this->user['uid'] = intval($uid);
 		return $_ENV['pm']->get_blackls($this->user['uid']);
 	}

 	function onblackls_set($arr) {
 		@extract($arr, EXTR_SKIP);//uid, blackls
 		$this->user['uid'] = intval($uid);
 		return $_ENV['pm']->set_blackls($this->user['uid'], $blackls);
 	}

}

?>