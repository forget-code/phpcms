<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
 	<caption>修改API</caption>
	<tr>
    	<th>名称：</th>
        <td><?=form::text('info[name]', 'name', $name, 'text', 15, '', 'require="true" datatype="limit" min="1" max="20" msg="名称必须为1到20个字"')?></td>
    </tr>
    <tr>
    	<th width="20%">所属模型：</th>
        <td><?=form::select_module('info[module]', 'module', '', $module, '')?></td>
	</tr>   
    <tr>
    	<th>API的url位置：</th>
        <td><?=form::text('info[url]', 'url', $url, $type = 'text', $size = 35)?></td>
    </tr>
  	<tr align="center">
    	<td>
     <input type="hidden" name="forward" value="<?=$forward?>">
     <input type="hidden" name="action" value="<?=$action?>">
     <input type="hidden" name="info[apiid]" value="<?=$apiid?>">
     </td>
	 <td>
     	<input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 ">
     </td>
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