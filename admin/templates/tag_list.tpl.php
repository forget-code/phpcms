<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>phpcms网站管理系统网站管理 - Power by PHPCMS 2008</title>
<link href="admin/skin/system.css" rel="stylesheet" type="text/css">
<script type="text/javaScript" src="images/js/common.js"></script>
<script type="text/javaScript" src="images/js/admin.js"></script>
<script type="text/javaScript" src="images/js/jquery.min.js"></script>
<script type="text/javaScript" src="images/js/css.js"></script>
</head>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>标签列表</caption>
    <tr>
    	<th><strong>标签名称</strong></th>
    	<th><strong>所属模块</strong></th>
        <th><strong>管理</strong></th>
    </tr>
	<?php foreach($array as $k=>$v) { ?>
	<tr>
  		<td><?=$v[tagname]?></td>
        <td><?=$v[module]?></td>
        <td><a href="?mod=<?=$v[module]?>&file=tag&action=preview&module=<?=$v[module]?>&tagname=<?=urlencode($v[tagname])?>">预览</a>|
        <a href="?mod=<?=$v[module]?>&file=tag&action=edit&module=<?=$v[module]?>&tagname=<?=urlencode($v[tagname])?>">编辑</a>|
        <a href="?mod=<?=$v[module]?>&file=tag&action=delete&module=<?=$v[module]?>&tagname=<?=urlencode($v[tagname])?>">删除</a></td>
    </tr>
    <?php } ?>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>未建立标签列表</caption>
    <tr>
    	<th><strong>标签名称</strong></th>
    </tr>
	<?php foreach($un_tag as $k=>$v) { ?>
	<tr>
  		<td><?=$v[tagname]?></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>