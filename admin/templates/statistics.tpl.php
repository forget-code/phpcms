<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<table width="95%" cellpadding="0" cellspacing="1" class="table_list">
<caption>按角色查看</caption>
<tr>
<td>
<?php foreach ($roel as $val):?>
<a href="?mod=phpcms&file=statistics&roles=<?php echo $val['roleid']?>"><?php echo $val['name']?></a>
<?php endforeach;?>
</td>
</tr>
</table>
<table width="95%" cellpadding="0" cellspacing="1" class="table_list">
<caption>稿件统计</caption>
    <tr>
        <th>管理员</th>
        <th>角色</th>
        <th>今天</th>
        <th>昨天</th>
        <th>本周</th>
        <th>本月</th>
        <th>详情</th>
    </tr>
<?php foreach ($admin_list as $key=>$val):?>
<tr>
<td><a href="<?=member_view_url($val['userid'])?>"><?php echo $val['username']?></a></td>
<td><?php $roles = explode('<br />', $val['roles']);
foreach ($roles as $key=>$v)
{
	if($v)
	{
		echo "<a href='?mod=phpcms&file=statistics&roles=".$val['roleids'][$key]."'>$v</a> ";
	}
}
?></td>
<td class="align_c"><?php echo $statistics->day($val['userid'])?></td>
<td class="align_c"><?php echo $statistics->yesterday($val['userid'])?></td>
<td class="align_c"><?php echo $statistics->week($val['userid'])?></td>
<td class="align_c"> <?php echo $statistics->month($val['userid'])?></td>
<td class="align_c"><a href="?mod=phpcms&file=<?=$file?>&action=show_users&userid=<?=$val['userid']?>">统计报表</a></td>
</tr>
<?php endforeach;?>
</table>