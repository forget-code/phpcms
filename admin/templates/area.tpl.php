<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>地区管理</caption>

<tr>
<th width="8%"><strong>排序</strong></th>
<th width="8%"><strong>ID</strong></th>
<th><strong>地区名称</strong></th>
<th width="30%"><strong>管理操作</strong></th>
</tr>
<?=$areas?>
</table>
    <div class="button_box">
        <input name="submit" type="submit" size="4" value=" 更新排序 ">
    </div>
</form>
</body>
</html>