<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script type="text/javascript" src="<?=PHPCMS_PATH?>fckeditor/fckeditor.js"></script>
<script type="text/javascript">
	var editorBasePath = '<?=PHPCMS_PATH?>fckeditor/';
	var ChannelId = <?=$channelid?> ;
</script>

<script type="text/javascript">
window.onload = function()
{
	var oFCKeditor = new FCKeditor('reply') ;
	oFCKeditor.BasePath	= editorBasePath ;
	oFCKeditor.ReplaceTextarea() ;
}
</script>

<body>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center> 留言搜索 </td>
  </tr>
<form method="post" name="search">
  <tr>
    <td class="tablerow">
	&nbsp;<a href="?mod=guestbook&file=guestbook&action=manage&channelid=<?=$channelid?>"><b>管理首页</b></a>&nbsp;
	<b>显示选项：</b> <input name='passed' type='radio' value='1' onclick="location='?mod=guestbook&file=guestbook&action=manage&passed=1&channelid=<?=$channelid?>'" <? if($passed==1) { ?>checked<? } ?>><a href='?mod=guestbook&file=guestbook&action=manage&passed=1&channelid=<?=$channelid?>'>已审核的留言</a>&nbsp;<input name='passed' type='radio' value='0' onclick="location='?mod=guestbook&file=guestbook&action=manage&passed=0&channelid=<?=$channelid?>'" <? if(!$passed) { ?>checked<? } ?>><a href='?mod=guestbook&file=guestbook&action=manage&passed=0&channelid=<?=$channelid?>'>未审核的留言</a>&nbsp;<input name='channelid' type='hidden' value='<?=$channelid?>'>
	关键字：<input name='keyword' type='text' size='20' value='<?=$keyword?>'>&nbsp;
     <input type="radio" name="srchtype" value="0" <?if(!$srchtype){?>checked<?}?>> 标题 	
	<input type="radio" name="srchtype" value="1" <?if($srchtype==1){?>checked<?}?>> 内容	
	<input type="radio" name="srchtype" value="2" <?if($srchtype==2){?>checked<?}?>> 会员
	<input name='submit' type='submit' value='留言搜索'></td>
  </tr>
</form>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>


<script language=JavaScript>

// 表单提交检测
function doCheck(){


}

</script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>回复留言</th>
  </tr>
   <form action="?mod=guestbook&file=guestbook&action=reply&gid=<?=$guestbook[gid]?>&submit=1" method="post" name="myform" onsubmit="return doCheck();">
    <tr> 
      <td class="tablerowhighlight" colspan=2>标题：<?=$guestbook[title]?> --- [<?=$guestbook[addtime]?>]</td>
   </td>
    <tr> 
      <td class="tablerow" width="30%">
      <img src="<?=PHPCMS_PATH?>images/guestbook/face/<?=$guestbook[head]?>.gif" width="80" height="90"><br>
     名称：<a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($guestbook[username])?>" target="_blank"><?=$guestbook[username]?></a><br>
     QQ：<a href="http://wpa.qq.com/msgrd?V=1&Uin=<?=$guestbook[qq]?>&Site=localhost&Menu=yes" target="_blank"><?=$guestbook[qq]?></a><br>
     E-mail：<a href="mailto:<?=$guestbook[email]?>"><?=$guestbook[email]?></a><br>
     主 页：<a href="<?=$guestbook[homepage]?>" target="_blank"><?=$guestbook[homepage]?></a><br>
     IP：<?=$guestbook[ip]?> - <?=$gip[country]?>
      </td>
      <td class="tablerow" valign="top">
<?=$guestbook[content]?><p>
<? if($guestbook[reply]) { ?>
<table cellpadding="10" cellspacing="1" border="0" width="96%" bgcolor="#dddddd">
  <tr>
    <td bgcolor="#efefef"><font color=red><b>管理员[<?=$guestbook[replyer]?>]于<?=$guestbook[replytime]?>回复：</b></font><br>
          <?=$guestbook[reply]?>
</td>
  </tr>
</table>
<? } ?>
     </td>
    </tr>
    <tr> 
      <td class="tablerow">回复内容：</td>
      <td class="tablerow">
        <textarea name="reply" style="display:none"><?=$guestbook[reply]?></textarea>
   </td>
    </tr>
    <tr>
         <td class="tablerow">隐藏：</td>
         <td class="tablerow"><input type='radio' name='hidden' value='1' <?php if($guestbook[hidden]){?>checked<?php }?>> 是 <input type='radio' name='hidden' value='0' <?php if(!$guestbook[hidden]){?>checked<?php }?>> 否</td>
   </tr>
    <tr>
         <td class="tablerow">批准：</td>
         <td class="tablerow"><input type='radio' name='passed' value='1' checked> 是 <input type='radio' name='passed' value='0'> 否</td>
   </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="submit" name="Submit" value=" 确定 "> 
        &nbsp; <input type="reset" name="Reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>
