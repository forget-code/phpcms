<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>

<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>联动菜单ID选择</caption>
<tr>
<th width="30"><strong>ID</strong></th>
<th width="100"><strong>联动菜单名称</strong></th>
<th width="*"><strong>描述</strong></th>
<th width="*"><strong>选定</strong></th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><?=$info['linkageid']?></td>
<td class="align_c"><span style=""><?=$info['name']?></span></td>
<td class="align_c"><?=$info['description']?></td>
<td class="align_c"><input  TYPE="button" value="选择" onclick="select_linkageid(<?=$info['linkageid']?>)"/></td>
</tr>
<?php 
	}
}
?>
</table>
<script language='javascript'>
function select_linkageid(id)
{
	$(window.opener.document).find("form[@name='myform'] #linageid").val(id);
	window.close();
}
</script>
</body>
</html>
