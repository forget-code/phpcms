<?php
require './include/common.inc.php';
if(isset($_GET['dosubmit']))
{
	if(!$_userid) exit("alert('你还没有登陆，请先登录')");
	include MOD_ROOT.'include/collect.class.php';
	$c = new collect();
	if(strpos($referer,'.html')===false) $referer = $referer.'&id='.$id;
	$c->add($userid,$title,$referer);
	if($returnid)
	{
		echo "document.getElementById(\"$returnid\").innerHTML = \"<font color='red'>添加成功</font>\"";
	}
	else
	{
		echo "alert('添加成功');";
	}
}
else
{
	$referer = urlencode($_GET['referer']);
	$_GET['title'] = filter_xss($_GET['title']);
	$_GET['callback_js'] = filter_xss($_GET['callback_js']);
	$_GET['userid'] = intval($_GET['userid']);
?>
function favorite(title,referer,returnid,callback_js,userid)
{
	document.getElementById(callback_js).src = "<?=$PHPCMS['siteurl']?>yp/collect.php?dosubmit=1&userid="+userid+"&title="+title+"&returnid="+returnid+"&referer="+referer;
}
<?php
if($_GET['returnid'])
{
	?>
document.write('<img src="yp/images/cellect.gif" align="absmiddle"  onclick="favorite(\'<?=$_GET['title']?>\',\'<?=$referer?>\',\'<?=$_GET['returnid']?>\',\'<?=$_GET['callback_js']?>\',\'<?=$_GET['userid']?>\')" style="cursor: pointer;">');
<?php
}
else
{
?>
document.write('<a href="javascript:favorite(\'<?=$_GET['title']?>\',\'<?=$referer?>\',\'<?=$_GET['returnid']?>\',\'<?=$_GET['callback_js']?>\',\'<?=$_GET['userid']?>\',1)" class="btn_02 white">收藏此信息</a>');
<?php
}
}
?>