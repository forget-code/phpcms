<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
 	<caption>增添API</caption>
	<tr>
    	<th width="20%"><strong>名称：</strong></th>
        <td><?=form::text('info[name]', 'name', '', 'text', 15, '', 'require="true" datatype="limit" min="1" max="20" msg="名称必须为1到20个字"')?></td>
    </tr>
    <tr>
    	<th ><strong>所属模型：</strong></th>
        <td><?=form::select_module('info[module]', 'module', '', '', '')?></td>
	</tr> 
    <tr>
    	<th><strong>API的url位置：</strong></th>
        <td><?=form::text('info[url]', 'url', 'api/', 'text', 35)?></td>
    </tr>
	<tr>
		<td></td>
			<input type="hidden" name="action" value="<?=$action?>">
		<td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
<table cellpadding="0" cellspacing="1" class="table_info">
	<caption>注意事项</caption>
	<tr>
		<td>1,请在“API的url位置：”处填写具体的文件路径，比如：api/space.api.php</td>
	</tr>
</table>
</body>
</html>
<script language="javascript">
<!--	
$('#module').change(function (){
		$.post('?', {mod:'<?=$mod?>', file:'<?=$file?>', action:"modulepath",name:$('#module').val()}, function(data, txtstatus){
			$('#url').val(data + 'api/');
		});
	});

$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>