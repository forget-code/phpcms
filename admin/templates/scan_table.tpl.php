<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<form action="?mod=phpcms&file=safe&action=replace" method="POST">
<table width="95%" cellpadding="0" class="table_list" cellspacing="1">
 <caption>扫描报表</caption>
<tr>
<th style="width:30px;">选择</th>
<th>文件地址</th>
<th style="text-align:center;width:100px;">特征函数次数</th>
<th style="text-align:center;width:100px;">特征函数</th>
<th style="text-align:center;width:100px;">特征代码次数</th>
<th style="text-align:center;width:100px;">特征代码</th>
<th style="text-align:center;width:100px;">Zend encoded</th>
<th style="text-align:center;width:100px;">操作</th>
</tr>
<?php foreach ($file_list as $key=>$val):?>
<tr>
<td><input type="checkbox" name="id[]" id="che" boxid="che" value="<?=$key?>"></td>
<td>
<?=$key?>
</td>
<td style="text-align:center;"><?php if(isset($val['func'])){echo count($val['func']);}else{echo '0';}?></td>
<td style="text-align:center;"><?php if(isset($val['func'])){
	foreach ($val['func'] as $keys=>$vals)
	{
		$d[$keys] = strtolower($vals[1]);
	}
	$d = array_unique($d);
	foreach ($d as $vals)
	{
		echo "<font color='red'>".$vals."</font>  ";
	}
}?></td>
<td style="text-align:center;"><?php if(isset($val['code'])){echo count($val['code']);}else{echo '0';}?></td>
<td style="text-align:center;"><?php if(isset($val['code'])){
	foreach ($val['code'] as $keys=>$vals)
	{
		$d[$keys] = strtolower($vals[1]);
	}
	$d = array_unique($d);
	foreach ($d as $vals)
	{
		echo "<font color='red'>".htmlentities($vals)."</font>  ";
	}
}?></td>
<td style="text-align:center;"><?php if(isset($val['zend'])){echo '<font color=\'red\'>Yes</font>';}else{echo 'No';}?></td>
<td style="text-align:center;"><a href="?mod=phpcms&file=safe&action=see_code&files=<?=urlencode($key)?>">查看</a> | <a href="?mod=phpcms&file=safe&action=del_file&files=<?=urlencode($key)?>" onclick="return confirm('您确定要删除<?=$key?>吗？\n删除后不可恢复哟！')">删除</a></td>
</tr>
<?php endforeach;?>
<tr>
<td colspan="8"> <a href="javascript:checkall('che');">全选</a> | <a href="javascript:checkall('che');">取消</a> <input type="submit" value="批量替换"></td>
</tr>
</table>
</form>
</body>
</html>