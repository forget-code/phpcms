<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>排序管理</caption>
  <tr>
    <th width="60">排序</th>
    <th width="40">ID</th>
    <th>标题</th>
	 <th width="60">排序</th>
    <th width="40">ID</th>
    <th>标题</th>
  </tr>
<?php
if(is_array($infos)){
$cols = 0;
	foreach($infos as $info){
if($cols%2==0) echo "<tr>";
?>
<td style="text-align:center"><input type="text" name="info[<?=$info['id']?>]" value="<?=$info['listorder']?>" size="5"></td>
<td style="text-align:center"><?=$info['id']?></td>
<td style="text-align:left"> <?=$info['title']?></td></td>
<?php
if($cols%2==1) echo "</tr>";
$cols++;
	}
}
?>
</table>
<div class="button_box"><input type="submit" value=" 更新排序 " size="4" name="dosubmit"/></div>
</form>
</body>
</html>