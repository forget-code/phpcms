<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>基本信息</caption>
    <tr align="center">
		<th width="5%"><strong>选中</strong></th>
        <th width="5%"><strong>排序</strong></th>
		<th width="5%"><strong>ID</strong></th>
		<th width="15%"><strong>API名称</strong></th>
		<th><strong>URL</strong></th>
		<th width="20%"><strong>相关操作</strong></th>
	</tr>
    <?php
		if(is_array($api_info))
		{
			foreach ($api_info as $info)
			{
	?>
    <tr>
    	<td class="align_c"><input type="checkbox" id="checkbox" name="apiid[]" value="<?=$info['apiid']?>"></td>
    	<td class="align_c"><input type="text" name="listorders[<?=$info['apiid']?>]" value="<?=$info['listorder']?>" size="3"></td>
        <td class="align_c"><?=$info['apiid']?></td>
        <td class="align_c"><?=$info['name']?></td>
        <td class="align_c"><?=$info['url']?></td>
        <td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&apiid=<?=$info['apiid']?>" title="修改">修改</a> | <a href="#" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&apiid=<?=$info['apiid']?>', '是否删除该API')" title="删除">删除</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=disable&apiid=<?=$info['apiid']?>&val=<?=($info['disable']) ? 0 : 1 ?>"><?=($info['disable']) ? '启用' : '禁止' ?></a></td>
    </tr>
    <?php
			}
		}
	?> 
	</table> 
      <div class="button_box">
	 <input type="button" value=" 全选 " onClick="checkall()">
	 <input type="button" onClick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listorder&forward=<?=urlencode(URL)?>';myform.submit();" value=" 排序 ">
     <input type="button" onClick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&forward=<?=urlencode(URL)?>';myform.submit();" value=" 删除 ">
     </div>
<div id="pages"><?=$pages?></div>
</form>
</body>
</html>