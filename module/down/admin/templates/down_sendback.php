<?php
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
	var oFCKeditor = new FCKeditor('content') ;
	oFCKeditor.BasePath	= editorBasePath ;
	oFCKeditor.ReplaceTextarea() ;
}
</script>

<body>
<?php echo $downmenu; ?>

<script language="javascript" type="text/javascript">
<!--
// 表单提交检测
function doCheck(){

if (myform.title.value=="") {
	alert("请输入标题！");
	document.myform.title.focus();
	return false;
	}
}
</script>


<form action="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=<?php echo $action; ?>&channelid=<?php echo $channelid; ?>&downid=<?php echo $downid; ?>&submit=1>" method="post" name="myform" onSubmit="return doCheck();">
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2"><?php echo $headtitle; ?></th>
  </tr>
    <tr> 
      <td class="tablerow">标题</td>
      <td class="tablerow"><?php echo $down['title']; ?></td>
    </tr>
    <tr> 
      <td class="tablerow">所属栏目</td>
      <td class="tablerow"><?php echo $_CAT[$down['catid']]['catname']; ?></td>
    </tr>
	<tr> 
      <td class="tablerow">会员名称</td>
      <td class="tablerow"><?php echo $down['username']; ?>
	  <input name="username" type="hidden" value="<?php echo $down['username']; ?>" />
	  </td>
    </tr>
    <tr> 
      <td class="tablerow">短信通知</td>
      <td class="tablerow">
	  <input name="ifpm" type="radio" id="ifpm" value="1" checked="checked" /> 是
	  <input name="ifpm" type="radio" id="ifpm" value="0" /> 否
	  <input name="ifemail" type="checkbox" id="ifemail" value="1" />同时发送到该会员电子邮箱
	  </td>
    </tr>
    <tr> 
      <td class="tablerow">短信标题</td>
      <td class="tablerow"><input name="title" type="text" id="title" size="60" value="抱歉！您提交的信息《<?php echo $down['title']; ?>》被退回。"></td>
    </tr>
    <tr> 
      <td class="tablerow">短信内容 </td>
      <td class="tablerow">
        <textarea name="content" style="display:none"><?=htmlspecialchars($_CHA['emailofreject'])?></textarea>
</td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
	  	 <input type="hidden" name="referer" value="<?=$referer?>" >
        <input type="submit" name="Submit" value=" 确定 " /> &nbsp;
        <input type="reset" name="Reset" value=" 清除 " />
     </td>
    </tr>
  </table>
</form>

</body>
</html>