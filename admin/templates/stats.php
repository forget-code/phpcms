<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>

<table cellpadding="2" cellspacing="1" class="tableborder">
<tr>
  <th colspan=9>[<?=$_CHA['channelname']?>]频道统计报表</th>
</tr>
<tr>
  <td class="tablerow" colspan=9>栏目数：<font color="red"><?=$total_catnumber?></font> （内：<?=$catnumber1?>，外：<?=$catnumber0?>）&nbsp;&nbsp;专题数：<font color="red"><?=$specialnumber?></font>&nbsp;&nbsp;信息总数：<font color="red"><?=$allitem?></font> [已发布：<?=$allitem1?>（今日：<?=$today_number1?> 昨日：<?=$yesterday_number1?> 本月：<?=$month_number1?>），未发布：<?=$allitem0?>（今日：<?=$today_number0?> 昨日：<?=$yesterday_number0?> 本月：<?=$month_number0?>）]</td>
</tr>
<tr align="center">
  <td class="tablerowhighlight" colspan=9>统计查询</td>
</tr>
<form name="search" action="?" method="get">
<tr>
  <td colspan=9 align="center" class="tablerow" height="50">
  <input name='mod' type='hidden' value='<?=$mod?>'>
  <input name='file' type='hidden' value='<?=$file?>'>
  <input name='action' type='hidden' value='<?=$action?>'>
  <input name='channelid' type='hidden' value='<?=$channelid?>'>
  用户名：<input name='username' type='text' size='20' value='<?=$username?>'>&nbsp;&nbsp;&nbsp;&nbsp;发布时间：<input name='adddate' type='text' size='20' value='<?=$adddate?>'>&nbsp;&nbsp;<input name='search' type='submit' value=' 查询 '>
  </td>
</tr>
</form>
<tr>
  <td colspan=9 class="tablerow">
  <b>统计查询说明：</b><br/>
  1、如果输入用户名，则可以对该用户的信息发布情况进行统计；如果用户名留空，则表示不限定用户名。<br/>
  2、如果发布时间格式可以是 <font color="red"><?=date("Y")?></font> 、<font color="red"><?=date("Y-m")?></font> 或 <font color="red"><?=date("Y-m-d")?></font>，可以分别按年、月、日的进行统计；如果发布时间留空，则表示不限定发布时间。<br/>
  3、下面将按照栏目和专题分别显示详细统计情况，<font color="blue">百分比是当前条件下相对于已发布总数的</font>。
  </td>
</tr>
<tr>
  <td colspan=9 class="tablerow">
  <b>总体统计情况：</b><br/>  已发布数：<font color="red"><?=$status3s?></font>（精华：<?=$elites?>，置顶：<?=$ontops?>）&nbsp;&nbsp;&nbsp;未发布数：<font color="red"><?=$unpublished?></font>（待审核：<?=$status1s?>，草稿：<?=$status0s?>，退稿：<?=$status2s?>，回收站：<?=$recycles?>）
  </td>
</tr>
<tr align="center">
<td class="tablerowhighlight" width="20%">栏目名称</td>
<td class="tablerowhighlight" width="11%">总数 <?=$totals?></td>
<td class="tablerowhighlight" width="13%">已发布 <?=$status3s?></td>
<td class="tablerowhighlight" width="9%">精华 <?=$elites?></td>
<td class="tablerowhighlight" width="9%">置顶 <?=$ontops?></td>
<td class="tablerowhighlight" width="10%">待审核 <?=$status1s?></td>
<td class="tablerowhighlight" width="9%">草稿 <?=$status0s?></td>
<td class="tablerowhighlight" width="9%">退稿 <?=$status2s?></td>
<td class="tablerowhighlight" width="10%">回收站 <?=$recycles?></td>
</tr>
<?=$categorys?>
<tr align="center">
<td class="tablerowhighlight">专题名称</td>
<td class="tablerowhighlight">总数</td>
<td class="tablerowhighlight">已发布</td>
<td class="tablerowhighlight">精华</td>
<td class="tablerowhighlight">置顶</td>
<td class="tablerowhighlight">待审核</td>
<td class="tablerowhighlight">草稿</td>
<td class="tablerowhighlight">退稿</td>
<td class="tablerowhighlight">回收站</td>
</tr>
<?php 
if(is_array($specials)){
	foreach($specials as $special){
?>
<tr align="center" onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5'>
<td align="left"><a href='<?=$special['url']?>' target='_blank'><?=$special['name']?></a></td>
<td><?=$special['total_number']?></td>
<td><?=$special['status3_number']?></td>
<td><?=$special['elite_number']?></td>
<td><?=$special['ontop_number']?></td>
<td><?=$special['status1_number']?></td>
<td><?=$special['status0_number']?></td>
<td><?=$special['status2_number']?></td>
<td><?=$special['recycle_number']?></td>
</tr>
<?php 
	}
}
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><input name="print" type="button" value="打印统计报表" onclick="javascript:window.print();"></td>
  </tr>
</table>
</body>
</html>