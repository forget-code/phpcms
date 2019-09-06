<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption><?=$name?> 模块</caption>
	<tr> 
      <th width="15%"><strong>模块名称</strong></th>
      <td><?=$name?></td>
    </tr>
	<tr> 
      <th><strong>模块目录</strong></th>
      <td><?=$module?></td>
    </tr>
	<tr> 
      <th><strong>核心模块</strong></th>
      <td><?=$iscore ? '是' : '否'?></td>
    </tr>
	<tr> 
      <th><strong>版本号</strong></th>
      <td><?=$version?></td>
    </tr>
	<tr> 
      <th><strong>作者</strong></th>
      <td><?=$author?></td>
    </tr>
	<tr> 
      <th><strong>E-mail</strong></th>
      <td><a href="?mod=mail&file=send&email=<?=$email?>"><?=$email?></a></td>
    </tr>
	<tr> 
      <th><strong>网站地址</strong></th>
      <td><a href="<?=$site?>" target="_blank"><?=$site?></a></td>
    </tr>
	<tr> 
      <th><strong>功能说明</strong></th>
      <td><?=$introduce?></td>
    </tr>
	<tr> 
      <th><strong>许可协议</strong></th>
      <td><?=$license?></td>
    </tr>
	<tr> 
      <th><strong>发布日期</strong></th>
      <td><?=$publishdate?></td>
    </tr>
	<tr> 
      <th><strong>安装日期</strong></th>
      <td><?=$installdate?></td>
    </tr>
	<tr> 
      <th><strong>更新日期</strong></th>
      <td><?=$updatedate?></td>
    </tr>
</table>
</body>
</html>