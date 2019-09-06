<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/card.class.php';
$card = new card();
switch($action)
{
	case 'list':
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$pagesize	= $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
		$condition = array();
		if(!empty($status))
		{
			if ('used' == $status)
			{
				$condition[] = "status = '1' " ;
			}
			else
			{
				$condition[] = "status = '0' " ;
			}
		}
		$cards = $card->get_list( $condition, $page, $pagesize );
		$pages = $cards['pages'];
		include admin_tpl('card_view');
	break;
	case 'add':
		if ($dosubmit)
		{
		   if($card->add($ptypeid, $cardnum, $carlength, $prefix,$endtime)) showmessage($LANG['operation_success'], '?mod=pay&file=card&action=list');
		}
		else
		{
			$cardtype = card_type();
			include admin_tpl('card_detail');
		}
	break;
	case 'delete':
		if($card->drop( $id )) showmessage($LANG['operation_success'], "?mod=pay&file=card&action=list");
	break;
}
?>
