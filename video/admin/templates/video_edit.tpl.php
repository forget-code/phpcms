<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/form.js"></script>
<style>
<!--
#uploadp{background-color: #FFFFFF; border:#666666 1px solid; height: 21px; line-height:21px;  width: 238px; margin: 0px 0px 0px 25px; padding:1px;text-align: center;overflow:hidden;font-size:14px;}
#e{float:left; margin-top:0px;background-color: #83BAEC;text-align:right; height:20px; line-height:20px; color:#fff;font-size:14px;}
-->
</style>
<body>
<?=$menu?>
<div class="tag_menu" style="width:99%;margin-top:10px;">
<ul>
  <li><a href="###" id='TabTitle0' onclick='ShowTabs(0)' class="selected">基本信息</a></li>
  <li><a href="###" id='TabTitle1' onclick='ShowTabs(1)'>高级设置</a></li>
</ul></div>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&vid=<?=$vid?>" method="post" name="myform" enctype="multipart/form-data">
<div id="Tabs0" style="display:">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>修改基本信息</caption>
 <?php
 foreach($forminfos['base'] as $field=>$info)
 {
 ?>
	<tr>
      <th width="20%"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <strong><?=$info['name']?></strong><br />
	  <?=$info['tips']?>
	  </th>
      <td><?=$info['form']?></td>
    </tr>
<?php
}
?>
<tr>
      <th width="20%"><strong>状态</strong><br />
	  </th>
      <td>
	  <?php if($allow_manage){ ?>
	  <label><input type="radio" name="status" value="99" checked/> 发布</label>
	  <?php } ?>
	  <label><input type="radio" name="status" value="3" <?=$allow_manage ? '' : 'checked'?>> 审核</label>
	  <label><input type="radio" name="status" value="2"> 草稿</label>
	  </td>
    </tr>
    <tr>
      <td></td>
      <td>
	  <input type="hidden" name="forward" value="<?=$forward?>">
	  <input type="submit" name="dosubmit" value=" 确定 ">
	  &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
</table>
</div>
<div id='Tabs1' style='display:none'>
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>修改高级设置</caption>
  <?php
	if(is_array($forminfos['senior']))
	{
	 foreach($forminfos['senior'] as $field=>$info)
	 {
	 ?>
		<tr>
		  <th width="20%"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <strong><?=$info['name']?></strong> <br />
		  <?=$info['tips']?>
		  </th>
		  <td><?=$info['form']?> </td>
		</tr>
	<?php
	} }
?>
    <tr>
      <td></td>
      <td>
	  <input type="hidden" name="catid" value="<?=$catid?>">
	  <input type="hidden" name="forward" value="<?=$forward?>">
	  <input type="submit" name="dosubmit" value=" 确定 ">
	  &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
</table>
</div>
</form>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
function check_catid(catid)
{
	$.get('?mod=video&file=video&action=check_catid&catid='+catid,function(data)
	{
		if(data=='1') {
			$('#catiderror').html("<span tag='err' class='no'>父栏目不允许发布视频，请选择子栏目</span>");
			document.getElementById('catid').options[0].selected=true;
		}
	});
}
//-->
</script>
</body>
</html>