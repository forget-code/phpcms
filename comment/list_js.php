<?php
define('SHOWJS', 1);
require './include/common.inc.php';
require MOD_ROOT.'/include/tag.func.php';

if(!$itemid || !$keyid || (!array_key_exists($keyid, $MODULE) && !array_key_exists($keyid, $CHANNEL))) showmessage($LANG['illegal_operation']);

$commentnum = intval($commentnum);
$commentnum = $commentnum>0 ? $commentnum : 10;
$ordertype = $ordertype==1 ? 1 : 0;
$data = '';
$enabledkey = explode(',', $MOD['enabledkey']);
$enabledkey = array_filter($enabledkey);
if(in_array($keyid,$enabledkey))
{
	comment_list(0, $keyid, $itemid, 0, $commentnum, $ordertype, $title);
	include template('comment', 'comment_submit');
}
$CONFIG['phpcache'] = 0;
phpcache(1);
?>