<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$fields = array('settleexpendamount','totalpayamount','visits','registers','regtime');
$field = in_array($ordertype, $fields) ? $ordertype : 'settleexpendamount';
$orderby = "ORDER BY u.$field DESC";

$passed = isset($passed) ? $passed : 1;
$sql = " AND u.passed=$passed";
if($username) $sql = " AND u.username='$username'";

$pagesize = $PHPCMS['pagesize'];
if(!isset($page)) $page = 1;
$offset = ($page-1)*$pagesize;

$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_UNION." WHERE passed=$passed");
$pages = phppages($r['number'], $page, $pagesize);

$users = array();
$result = $db->query("SELECT u.*,m.truename,m.homepage,m.telephone,m.mobile,m.alipay,m.qq,m.address,m.postid FROM ".TABLE_UNION." u,".TABLE_MEMBER_INFO." m WHERE u.userid=m.userid $sql $orderby LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	if(strpos($r['homepage'], 'http://') === FALSE) $r['homepage'] = 'http://'.$r['homepage'];
	$r['regdate'] = date('Y-m-d', $r['regtime']);
	$r['settleamount'] = $r['settleexpendamount']*$r['profitmargin']/100;
	$users[] = $r;
}

include admintpl('union');
?>