<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
<form action="" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>修改证书</caption>
<tr>
<th width="20%"><strong>证书名称</strong></th>
<td><input type="text" name="name" size="30" value="<?=$info['name']?>" require="true" datatype="limit" min="3" max="80" msg='证书名称必须为3到80位'></td>
</tr>
<tr>
<th width="20%"><strong>发证机构</strong></th>
<td><input type="text" name="organization" size="30" value="<?=$info['organization']?>" require="true" datatype="limit" min="3" max="80" msg='发证机构必须为3到80位'></td>
</tr>
<tr>
<th width="20%"><strong>证书图片</strong></th>
<td><input type="text" name="thumb" id="thumb" size="50" value="<?=$info['thumb']?>" require="true" datatype="limit" min="5" msg='请上传证书'>  <input type="button" name="upload" id="upload" value="上传图片" style="width:60px" onclick="javascript:openwinx('<?=PHPCMS_PATH?>yp/upload.php?uploadtext=thumb','upload','450','350')"/></td>
</tr>
<tr>
<th width="20%"><strong>生效日期</strong></th>
<td><input type="text" name="effecttime" id="effecttime" size="15" value="<?=$info['effecttime']?>" require="true" datatype="limit" min="3" msg='请填写生效日期'></td>
</tr>
<tr>
<th width="20%"><strong>截至日期</strong></th>
<td><input type="text" name="endtime" id="endtime" size="15" value="<?=$info['endtime']?>" require="true" datatype="limit" min="3" msg='请填写截至日期'></td>
</tr>
<tr> 
<td></td>
<td> 
<input type="hidden" name="id" value="<?=$id?>"> 
<input type="hidden" name="forward" value="<?=$forward?>"> 
<input type="submit" name="dosubmit" value=" 确定修改 "> 
</td>
</tr>
</table>
</form>
</body>
</html>
<SCRIPT LANGUAGE="JavaScript">
<!--
$().ready(function() {
  $('form').checkForm(1);
});
//-->
</SCRIPT>