<?php include admintpl('header'); ?>

<script type="text/javascript" src="<?=PHPCMS_PATH?>fckeditor/fckeditor.js"></script>
<script type="text/javascript">
	var editorBasePath = '<?=PHPCMS_PATH?>fckeditor/';
	var ChannelId = 0 ;
</script>

<script type="text/javascript">
window.onload = function()
{
	var oFCKeditor = new FCKeditor('mbody') ;
	oFCKeditor.BasePath	= editorBasePath ;
	oFCKeditor.ReplaceTextarea() ;
}
</script>

<?php echo $menu; ?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	选择Email列表文件，填写要发送邮件的标题和内容，点发送即可。
	</td>
  </tr>
</table>
<br />
<form id="formsend" name="formsend" method="post" action="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=send&submit=1">
  <table border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="2">Email文件列表</th>
    </tr>
	<?php

	  if(is_array($mailfiles))
	  {
	  ?>
    <tr>
      <td class="tablerow">选择邮件列表文件</td>
      <td class="tablerow">
	  <select name="mail" id="mail">
	  <?php
	  foreach($mailfiles as $i=>$mailfile) 
	  { 
		  $selected = ($mailfile==$mail || $mailfile==$filename) ? "selected" : "";
	  ?>
	  <option value="<?php echo $mailfile; ?>" <?php echo $selected; ?> ><?php echo $mailfile; ?></option>
	  <?php 
	  } 
	  ?>
	  </select>  
	  </td>
    </tr>
  	<?php
	  }
	  ?>
    <tr>
      <td class="tablerow">发送方式</td>
      <td class="tablerow">
	  <input type="radio" name="msendtype"  value="smtp" <?php if( !$msendtype || $msendtype=='smtp') echo 'checked="checked"'; ?> />
	  SMTP方式 (<a href="?file=setting" title="在邮件设置中设置SMTP参数" >设置SMTP参数</a>)
      <input type="radio" name="msendtype" value="mail" <?php if((strtoupper(substr(PHP_OS, 0, 3))!='WIN') || $msendtype=='mail') echo 'checked="checked"'; ?> />Mail函数(非Windows)	  </td>
    </tr>
    <tr>
      <td class="tablerow">每轮发送数</td>
      <td class="tablerow">
	  <input name="mnum" type="text" id="mnum" value="<?php if($mnum) echo $mnum; else echo 10; ?>" size="10" maxlength="5" />
	 &nbsp; 建议设置为 100 左右	  </td>
    </tr>
    <tr>
      <td class="tablerow">邮件标题</td>
      <td class="tablerow">
	  <input name="msubject" type="text" id="msubject" value="<?php echo $msubject;?>" size="62" onclick="javascript:msubject.select();"/>	  </td>
    </tr>
    <tr>
      <td class="tablerow">邮件格式</td>
      <td class="tablerow">
	  <input name="mformat" type="radio" value="HTML" <?php if(!$mformat ||$mformat=='HTML') echo 'checked="checked"'; ?> />
      超文本(HTML)&nbsp; <input type="radio" name="mformat" value="TXT" <?php if($mformat=='TXT') echo 'checked="checked"'; ?> />
      纯文本(TXT)</td>
    </tr>
    <tr>
      <td class="tablerow">邮件内容</td>
      <td class="tablerow">
	  <textarea name="mbody" id="mbody" style="display:none"><?php if($mbody) echo $mbody; else echo '在此输入邮件内容'; ?></textarea>
	  </td>
    </tr>
    <tr>
      <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="Submit" id="Submit" value="  发 送  " />
        <input type="reset" name="Reset" id="Reset" value="  清 除  " /></td>
    </tr>
  </table>
</form>

</body>
</html>
