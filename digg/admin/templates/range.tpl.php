<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
 <caption>Digg 统计排行</caption>
  <tr>
    <th>选择栏目</th>
    <th>排行方式</th>
  </tr>
  <tr>
    <td class="align_c"><?=form::select_category('phpcms', 0, 'catid', '', '不限栏目', $catid, 'onchange="redirect(\'?mod=digg&file=range&range='.$range.'&catid=\'+this.value)"',1)?></td>
    <td class="align_c"><input type="radio" name="range" value="" <?=$range == '' ? 'checked' : ''?> onclick="redirect('?mod=digg&file=range&catid=<?=$catid?>&range='+this.value)"/> 总排行 <input type="radio" name="range" value="day" <?=$range == 'day' ? 'checked' : ''?>  onclick="redirect('?mod=digg&file=range&catid=<?=$catid?>&range='+this.value)"/> 今日排行 <input type="radio" name="range" value="week" <?=$range == 'week' ? 'checked' : ''?> onclick="redirect('?mod=digg&file=range&catid=<?=$catid?>&range='+this.value)"/> 本周排行 <input type="radio" name="range" value="month" <?=$range == 'month' ? 'checked' : ''?> onclick="redirect('?mod=digg&file=range&catid=<?=$catid?>&range='+this.value)"/> 本月排行</td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td width="70%" valign="top">
<table cellpadding="0" cellspacing="1" class="table_list">
 <caption>总关注度排行</caption>
  <tr>
    <th>标题</th>
    <th width="12%">栏目</th>
    <th width="12%">录入</th>
    <th width="18%">发布时间</th>
    <th width="8%">顶</th>
    <th width="8%">踩</th>
  </tr>
<?php
$result = get("select * from phpcms_digg d left join phpcms_content c on d.contentid=c.contentid where c.status=99 $where order by $orderby desc", 20, $page);
foreach($result['data'] as $k=>$r)
{
?>
   <tr>
    <td class="align_l"><a href="<?=$r['url']?>"><span class="<?=$r['style']?>"><?=$r['title']?></span></a></td>
    <td class="align_c"><a href="<?=$CATEGORY[$r['catid']]['url']?>"><?=$CATEGORY[$r['catid']]['catname']?></a></td>
    <td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$r['userid']?>"><?=$r['username']?></a></td>
    <td class="align_c"><?=date('Y-m-d H:i', $r['inputtime'])?></td>
    <td class="align_c"><?=$r['supports']?></td>
    <td class="align_c"><?=$r['againsts']?></td>
  </tr>
<?php
}
?>
</table>
<div id="pages"><?=$result['pages']?></div>
	</td>
    <td valign="top">
<table cellpadding="0" cellspacing="1" class="table_list">
 <caption>今日关注度排行</caption>
<?php
$data = get("select * from phpcms_digg d left join phpcms_content c on d.contentid=c.contentid where c.status=99 $where order by d.supports_day desc", 10);
foreach($data as $k=>$r)
{
?>
  <tr>
    <td width="20%" class="align_c"><?=$r['supports']?></td>
    <td><a href="<?=$r['url']?>" class="<?=$r['style']?>"><?=str_cut($r['title'], 30)?></a></td>
  </tr>
<?php
}
?>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
 <caption>本周关注度排行</caption>
<?php
$data = get("select * from phpcms_digg d left join phpcms_content c on d.contentid=c.contentid where c.status=99 $where order by d.supports_week desc", 10);
foreach($data as $k=>$r)
{
?>
  <tr>
    <td width="20%" class="align_c"><?=$r['supports']?></td>
    <td><a href="<?=$r['url']?>" class="<?=$r['style']?>"><?=str_cut($r['title'], 30)?></a></td>
  </tr>
<?php
}
?>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
 <caption>本月关注度排行</caption>
<?php
$data = get("select * from phpcms_digg d left join phpcms_content c on d.contentid=c.contentid where c.status=99 $where order by d.supports_month desc", 10);
foreach($data as $k=>$r)
{
?>
  <tr>
    <td width="20%" class="align_c"><?=$r['supports']?></td>
    <td><a href="<?=$r['url']?>" class="<?=$r['style']?>"><?=str_cut($r['title'], 30)?></a></td>
  </tr>
<?php
}
?>
</table>
	</td>
  </tr>
</table>
</body>
</html>