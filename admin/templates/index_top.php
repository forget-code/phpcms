<?php include admintpl('header');?>

<body leftmargin="20" topmargin="0" rightmargin="0" buttommargin="0" style="BACKGROUND-COLOR: #4466ee;color:#ffffff">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="20" align="center">
<?php 
if(is_array($_CHANNEL)){
	foreach($_CHANNEL as $channel){
		if($channel['channeltype']){
		if($_grade==0 || in_array($channel['channelid'],$_purview_channel)){
?>
&nbsp;□ <a href="?mod=<?=$channel['module']?>&file=index&action=left&channelid=<?=$channel['channelid']?>" target="left"><font color="#ffffff"><?=$channel['channelname']?></font></a>
<?php 
		}
        }
	}
}
?><?php if($_grade==0){?>| <a href="?mod=phpcms&file=index&action=left" target="left"><font color="#ffffff">系统设置</font></a> <?php } ?>| <a href="<?=PHPCMS_PATH?>" target="_blank"><font color="yellow">网站首页</font></a> | <a href="javascript:parent.location.href='?mod=phpcms&file=logout'"><font color="yellow">退出</font></a> 
</td>
</tr>
</table>
</body>
</html>