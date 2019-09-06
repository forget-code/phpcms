<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form id="formsend" name="formsend" method="post" action="?mod=<?=$mod?>&file=<?=$file?>" >
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>发送邮件</caption>
  <tr>
    <th width="25%"><strong>发送到</strong></th>
    <td width="75%">&nbsp;&nbsp;<input name="type" type="radio" id="reg_username" value="1" size="15" <?php if($type==1) echo "checked";?>  onClick="$('#addresssingle').show();$('#addressmulti').hide();$('#addresssimilar').hide(); $('#trmaxnum').hide();"/>
      单人&nbsp;&nbsp;&nbsp;&nbsp;<input name="type" type="radio" id="reg_username" value="2" size="15" <?php if($type==2) echo "checked";?> onClick="$('#addresssingle').hide();$('#addressmulti').show();$('#addresssimilar').hide();$('#trmaxnum').show();"/>
      多人&nbsp;&nbsp;&nbsp;&nbsp;<input name="type" type="radio" id="reg_username" value="3" size="15" <?php if($type==3) echo "checked";?> onClick="$('#addresssingle').hide();$('#addressmulti').hide();$('#addresssimilar').show();$('#trmaxnum').show();"/>
      邮件列表群发</td>
  </tr>


  <tr id="addresssingle" <?php if($type==1) echo "style='display:;'"; else echo "style='display:none;'";?>>
        <th><strong>E-mail</strong></th>
          <td><input name='SingleEmail' type='text' id='SingleEmail' value="<?php if(isset($email)) echo $email; else echo '@';?>" size='50'  />
          <input name='forward' type='hidden' value="<?=$forward?>" />
          </td>
   </tr>
   <tr id="addressmulti"  <?php if($type==2) echo "style='display:;'"; else echo "style='display:none;'";?>>
	<th><strong>E-mail</strong></th>
	<td><textarea name="MultiEmail" id="MultiEmail" cols="60" rows="6" ></textarea></td>
  </tr>
  <tr id="addresssimilar"  <?php if($type==3) echo "style='display:;'"; else echo "style='display:none;'";?>>
     <th><strong>使用服务器上邮件列表</strong></th>
	 <td>
	 <select name="maillistfile" id="maillistfile" >
	  <?php
	  foreach($mailfiles as $i=>$mailfile)
	  {

		  $selected = ($mailfile==$filename) ? " selected " : "";
	  ?>
	  <option value="<?php echo $mailfile; ?>" <?php echo $selected; ?> ><?php echo $mailfile; ?></option>
	  <?php
	  }
	  ?>
	  </select> <a href="?mod=mail&file=importmail&action=choice&forward=<?=urlencode(URL)?>">获取邮件列表</a></td>
  </tr>
 <tr id='trmaxnum' style="display:none;">
   <th><strong>每轮最大发送邮件数</strong></th>
  <td><input name="maxnum" type="text" id="maxnum" value="<?=$M['maxnum']?>" size="10" maxlength="5" />
  &nbsp;可留空</td>
 </tr>
 <tr>
      <th><strong>标题</strong></td>
      <td>
	  <input name="title" type="text" value="<?php if(isset($title)) echo $title;?>" id="title" size="62"  require="true" msg="标题不能为空"  />	  </td>
    </tr>
	<tr >
      <th><strong>发件人</strong></td>
      <td><input name="fromemail" type="text" id="fromemail" value="<?php if(isset($fromemail)) echo $fromemail;?>" size="24" maxlength="200" />
      &nbsp;可留空，使用smtp服务器发送时不可修改，否则失败</td>
    </tr>
    <tr>
      <th><strong>邮件内容</strong></td>
      <td><textarea name="content" cols="80" rows="16" id="content"><?php if(isset($content)) echo $content;?>
      </textarea><?=form::editor('content','introduce','100%',400)?>
	  </td>
    </tr>
  <tr>
    <th>&nbsp;</th>
    <td><input name="dosubmit" type="submit" value="确定" />
      &nbsp;
      <input name="" type="reset" value="重置" /></td>
  </tr>
</table></form></body></html>
