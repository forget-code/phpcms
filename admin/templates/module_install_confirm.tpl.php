<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&installdir=<?=$module?>&confirminstall=1" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
<tr>
    <caption>第二步：确认模块信息</caption> 
    <tr> 
      <th><strong>模块名称</strong></th>
      <td>
        <?=$modulename?>
     </td>
    </tr>
      <tr> 
      <th><strong>模块简介</strong></th>
      <td><?=$introduce?></td>
    </tr>
	<tr> 
	<th><strong>模块作者</strong></th>
	<td>
	<?=$author?>
	</td>
	</tr>
	<tr> 
      <th><strong>E-mail</strong></th>
      <td>
	  <?=$authoremail?>
    </td>
    </tr>
	<tr> 
      <th><strong>作者主页</strong></th>
      <td>
	  <a href="<?=$authorsite?>" target="_blank"><?=$authorsite?></a>
    </td>
    </tr>
    <tr> 
      <td></td>
      <td>
	  <input type="hidden" name="installdir" value="<?=$installdir?>"> 
	  <input type="submit" name="submit" value=" 确认安装 "> 
      &nbsp; <input type="button" name="cancel" value=" 取消安装 " onClick="window.location='?mod=<?=$mod?>&file=module'">
		</td>
    </tr>
</table>
</form>
</body>
</html>