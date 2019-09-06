<?php include admintpl('header');?>

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

<?=$menu?>

<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>&articleid=<?=$articleid?>&submit=1&referer=<?=$referer?>" method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>文章退稿</th>
  </tr>
    <tr> 
      <td class="tablerow">文章标题</td>
      <td class="tablerow"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&catid=<?=$article[catid]?>&articleid=<?=$articleid?>" target="_blank" title="预览文章"><?=$article[title]?>（预览）</a></td>
    </tr>
    <tr> 
      <td class="tablerow">所属栏目</td>
      <td class="tablerow"><?=$_CAT[$article[catid]][catname]?></td>
    </tr>
	<tr> 
      <td class="tablerow">会员名称</td>
      <td class="tablerow"><?=$article[username]?><input name='username' type='hidden' value='<?=$article[username]?>'> </td>
    </tr>
    <tr> 
      <td class="tablerow">短信通知</td>
      <td width="90%" class="tablerow">
	  <input name='ifpm' type='radio' id='ifpm' value='1'checked> 是
	  <input name='ifpm' type='radio' id='ifpm' value='0'> 否
	  <input name='ifemail' type='checkbox' id='ifemail' value='1' checked> 同时发送到该会员电子邮箱
	  </td>
    </tr>
    <tr> 
      <td class="tablerow">短信标题</td>
      <td class="tablerow"><input name="title" type="text" id="title" size="60" value="很抱歉!您提交的文章《<?=$article[title]?>》被退回！"></td>
    </tr>
    <tr> 
      <td class="tablerow">短信内容 </td>
      <td class="tablerow">
        <textarea name="content" style="display:none"><?=$_CHA['emailofreject']?></textarea>
    </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
	  	<input type="hidden" name="referer" value="<?=$referer?>" >
        <input type="submit" name="Submit" value=" 确定 " > &nbsp;
        <input type="reset" name="Reset" value=" 清除 ">
     </td>
    </tr>
  </form>
</table>
</body>
</html>