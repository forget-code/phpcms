<?php include admintpl('header'); ?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>fckeditor/fckeditor.js"></script>
<script type="text/javascript">
	var editorBasePath = '<?=PHPCMS_PATH?>fckeditor/';
	var ChannelId = 0 ;
</script>

<script type="text/javascript">
window.onload = function()
{
	var oFCKeditor = new FCKeditor('body') ;
	oFCKeditor.BasePath	= editorBasePath ;
	oFCKeditor.ReplaceTextarea() ;
}
</script>
<?php echo $menu; ?>
<br />
<form id="formsend" name="formsend" method="post" action="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=sendmail&submit=1">
  <table border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="2">发送邮件</th>
    </tr>
    <tr>
      <td class="tablerow">发送方式</td>
      <td class="tablerow">
	  <input type="radio" name="sendtype"  value="smtp" <?php if( !$sendtype || $sendtype=='smtp') echo 'checked="checked"'; ?> />
	  SMTP方式 (<a href="?file=setting" title="在邮件设置中设置SMTP参数" >设置SMTP参数</a>)
      <input type="radio" name="sendtype" value="mail" <?php if((strtoupper(substr(PHP_OS, 0, 3))!='WIN') || $sendtype=='mail') echo 'checked="checked"'; ?> />Mail函数(非Windows)	  </td>
    </tr>
    <tr>
      <td class="tablerow">收件人</td>
      <td class="tablerow"><input name="to" type="text" id="to" size="40" maxlength="200" /></td>
    </tr>
    <tr>
      <td class="tablerow">发件人</td>
      <td class="tablerow"><input name="from" type="text" id="from" value="<?php if($mfrom) echo $mfrom; ?>" size="40" maxlength="200" /></td>
    </tr>
    <tr>
      <td class="tablerow">标题</td>
      <td class="tablerow">
	  <input name="subject" type="text" id="subject" value="<?php if($subject) echo $subject; ?>" size="62" onclick="javascript:subject.select();"/>	  </td>
    </tr>
    <tr>
      <td class="tablerow">邮件格式</td>
      <td class="tablerow">
	  <input name="format" type="radio" value="HTML" <?php if(!$format || strtoupper($format)=='HTML') echo 'checked="checked"'; ?> />
      超文本(HTML)&nbsp; <input type="radio" name="format" value="TXT" <?php if(strtoupper($format)=='TXT') echo 'checked="checked"'; ?> />
      纯文本(TXT)</td>
    </tr>
    <tr>
      <td class="tablerow">邮件内容</td>
      <td class="tablerow">
	  <textarea name="body" id="body" style="display:none"><?php if($body) echo $body; ?></textarea>
	  </td>
    </tr>
    <tr>
	  <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="Submit" id="Submit" value="  发 送  " />
	    <input name="Reset" type="reset" id="Reset" value="  清 除  " />	  </td>
    </tr>
  </table>
</form>

</body>
</html>
