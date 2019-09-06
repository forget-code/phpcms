<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="table_list">
  <caption>基本信息</caption>
    <tr align="center">
		<th>选中</th>
		<th>ID</th>
		<th>API名称</th>
		<th>URL</th>
		<th>模板</th>
		<th>修改</th>
        <th>删除</th>
	</tr>
    <?php
		if(is_array($api_info))
		{
			foreach ($api_info as $info)
			{
	?>
    <tr align="center">
    	<td><input type="checkbox" name="arr_apiid[]" value="<?=$info['apiid']?>"></td>
    	<td><?=$info['apiid']?></td>
        <td><?=$info['name']?></td>
        <td><?=$info['url']?></td>
        <td><?=$info['template']?></td>
        <td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&apiid=<?=$info['apiid']?>" title="修改">修改</a></td>
        <td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&apiid=<?=$info['apiid']?>" title="删除">删除</a></td>
    </tr>
    <?php
			}
		}
	?>  
    <tr>
     <td colspan="7"><input type="submit" name="dosubmit" class="button_style" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" class="button_style" value=" 重置 "></td>
  </tr>
</table>
<div class="pages"><?=$pages?></div>
</form>
</body>
</html>