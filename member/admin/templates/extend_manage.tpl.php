<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="search" action="" method="get">
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="<?=$file?>">
<input type="hidden" name="action" value="<?=$action?>">
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>扩展组会员管理</caption>
    <tr>
		<td>会员组：
		<a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage'>全部</a>
		<?php 
		foreach($GROUP as $k=>$v)
		{
			if($k < 7) continue;
			echo "<a href='?mod=$mod&file=$file&action=manage&groupid=$k'>$v</a> ";
		} 
		?>
		</td>
	</tr>
    <tr>
		<td>最近加入与过期：
		<a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=join&time=today'>今日加入</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=join&time=yesterday'>昨日加入</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=join&time=week'>本周加入</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=join&time=month'>本月加入</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=expire&time=today'>今日过期</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=expire&time=week'>本周过期</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=expire&time=month'>本月过期</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&type=expire&time=all'>全部过期</a>
		</td>
	</tr>
    <tr>
		<td>会员查询：
<select name="groupid">
<option value=''>不限会员组</option>
<?php 
foreach($GROUP as $k=>$v)
{
	if($k < 7) continue;
	echo "<option value='$k'>$v</option>";
} 
?>
</select>
用户名：<input type="username" name="username" value="<?=$username?>" size="12">
加入日期：<?=form::date('startdate_start', $startdate_start)?>~ <?=form::date('startdate_end', $startdate_end)?>
过期日期：<?=form::date('enddate_start', $enddate_start)?>~ <?=form::date('enddate_end', $enddate_end)?>
<input type="submit" name="dosubmit" value="查询">
		</td>
	</tr>
</table>
</form>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption><?=$groupid ? $GROUP[$groupid] : ''?> 会员列表</caption>
<tr>
<th width="15%">用户名</th>
<th width="15%">会员组</td>
<th width="12%">价格</th>
<th width="10%">总金额</th>
<th width="8%">期限</th>
<th width="10%">起始日期</th>
<th width="10%">截止日期</th>
<th width="*">管理操作</th>
</tr>
<?php 
if(is_array($data))
{
  foreach($data as $r){
	  $username = username($r['userid']);
	  $is_expired = $extend->expired($r['enddate']);
?>
<tr>
<td class="align_c"><a href="<?=member_view_url($r['userid'])?>"><?=$username?></a></td>
<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&groupid=<?=$r['groupid']?>"><?=$GROUP[$r['groupid']]?></a></td>
<td class="align_c"><?=$r['price']?>元/<?=$extend->unit($r['unit'])?></td>
<td class="align_c"><?=$r['amount']?>元</td>
<td class="align_c"><?=$r['number']?><?=$extend->unit($r['unit'])?></td>
<td class="align_c"><?=$r['startdate']?></td>
<td class="align_c">
<?php if($is_expired){ ?>
<font color="red"><?=$r['enddate']?></font>
<?php }else{ ?>
<?=$r['enddate']?>
<?php } ?>
</td>
<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=disable&userid=<?=$r['userid']?>&groupid=<?=$r['groupid']?>&disabled=<?=$r['disabled'] ? 0 : 1?>"><?=$r['disabled'] ? '<font color="red">启用</font>' : '禁用'?></a> | <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&userid=<?=$r['userid']?>&groupid=<?=$r['groupid']?>&forward='+escape('<?=URL?>'), '确认删除会员“<?=$username?>”吗？')">删除</a></td>
</tr>
<?php } 
}
?>
</table>
<div id="pages"><?=$extend->pages?></div>
</body>
</html>