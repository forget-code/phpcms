<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript">
function checkform()
{
	if($F('fromemail')!='' && !Common.isemail($F('fromemail')))
	{
		alert('您的发送email不为空且地址非法，请重新填写！');
		//$('fromemail').focus();
		return false;
	}
}
</script>
<script type="text/javascript" src="<?=PHPCMS_PATH?>fckeditor/fckeditor.js"></script>
<body>
<?=$menu?>
<form id="formsend" name="formsend" method="post" action="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>" onSubmit="return checkform();">
  <table border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="2">手动发送邮件接口</th>
    </tr>
    <tr>
      <td width="16%" valign="top"  class='tablerow'>
          <table width="100%" height="100%"  border="0">
            <tr>
              <td valign="top">发送到: </td>
            </tr>
            <tr>
              <td valign="bottom"><a href="#" onClick="if($('trmaxnum').style.display=='none') {$('trmaxnum').style.display='block';$('trfromemail').style.display='block';} else {$('trmaxnum').style.display='none';$('trfromemail').style.display='none';}"><font color="blue">打开/关闭高级选项</font></a></td>
            </tr>
      </table></td>
    <td width="1024" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13%"><input name='type' type='radio' id='type1' onClick="addresssingle.style.display='block';addressmulti.style.display='none';addresssimilar.style.display='none';" value='1'  <?php if($type==1) echo "checked";?> >
单收件人</td>
        <td width="13%"><input name='type' id='type2' type='radio' value='2'  onClick="addresssingle.style.display='none';addressmulti.style.display='block';addresssimilar.style.display='none';" <?php if($type==2) echo "checked";?> >
多收件人</td>
        <td width="74%"><input name='type' id='type3' type='radio' value='3'  onClick="addresssingle.style.display='none';addressmulti.style.display='none';addresssimilar.style.display='block';" <?php if($type==3) echo "checked";?> >
从文本邮件列表中读取email地址</td>
      </tr>
      <tr id="addresssingle" <?php if($type==1) echo "style='display:block;'"; else echo "style='display:none;'";?>>
        <td colspan="3">Email地址:
          <input name='SingleEmail' type='text' id='SingleEmail' value="<?php if(isset($email)) echo $email; else echo '@';?>" size='50'>
          <br></td>
        </tr>
      <tr id="addressmulti"  <?php if($type==2) echo "style='display:block;'"; else echo "style='display:none;'";?>>
        <td colspan="3"><table width="98%"  border="0">
          <tr>
            <td width="80">Email地址：</td>
            <td width="40%"><textarea name="MultiEmail" id="MultiEmail" cols="60" rows="6" ></textarea> <br></td>
            <td width="*">(一行一个）</td>
          </tr>
        </table></td>
        </tr>
      <tr id="addresssimilar"  <?php if($type==3) echo "style='display:block;'"; else echo "style='display:none;'";?>>
        <td colspan="3"><br>使用服务器上邮件列表：<select name="maillistfile" id="maillistfile">
	  <?php
	  foreach($mailfiles as $i=>$mailfile) 
	  { 
	  	  
		  $selected = ($mailfile==$filename) ? " selected " : "";
	  ?>
	  <option value="<?php echo $mailfile; ?>" <?php echo $selected; ?> ><?php echo $mailfile; ?></option>
	  <?php 
	  } 
	  ?>
	  </select>
          <br></td>
      </tr>
    </table></td>
    </tr>
	<tr id='trmaxnum' style="display:none;">
      <td class="tablerow">每轮最大发送邮件数</td>
      <td class="tablerow"><input name="maxnum" type="text" id="maxnum" value="<?=$MOD['maxnum']?>" size="10" maxlength="5" /></td>
    </tr>
    <tr  id='trfromemail' style="display:none;">
      <td class="tablerow">发件人</td>
      <td class="tablerow"><input name="fromemail" type="text" id="fromemail" value="<?php if(isset($fromemail)) echo $fromemail;?>" size="24" maxlength="200" />
      &nbsp;可留空，使用smtp服务器发送时不可修改，否则失败</td>
    </tr>
    <tr>
      <td class="tablerow">标题</td>
      <td class="tablerow">
	  <input name="title" type="text" value="<?php if(isset($title)) echo $title;?>" id="title" size="62" onclick="javascript:subject.select();"/>	  </td>
    </tr>
    <tr>
      <td valign="top" class="tablerow">邮件内容</td>
      <td class="tablerow"><textarea name="content" cols="80" rows="16" id="content"><?php if(isset($content)) echo $content;?>
      </textarea><?=editor('content','phpcms',600,400)?>
	  </td>
    </tr>
    <tr>
	  <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="dosubmit" id="dosubmit" value="  发 送  " />
	    <input name="Reset" type="reset" id="Reset" value="  清 除  " /></td>
    </tr>
  </table>
</form>

</body>
</html>
