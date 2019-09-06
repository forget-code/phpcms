<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<table cellpadding="0" cellspacing="1" class="table_list">
<tr>
<td  class="align_c"><a href="?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&type=1">按所属地域排序</a></td><td  class="align_c"><a href="?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&type=2">按访问IP排序</a></td><td  class="align_c"><a href="?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&type=3">用户名排序</a></td>
<td  class="align_c">
<input name='range' type='radio' value='' onclick="redirect('?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&type=<?=$type?>&range='+this.value)" <?php if($range=='') echo "checked";?>> 全部
<input name='range' type='radio' value='1' onclick="redirect('?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&type=<?=$type?>&range='+this.value)" <?php if($range=='1') echo "checked";?>> 今日
<input name='range' type='radio' value='2' onclick="redirect('?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&type=<?=$type?>&range='+this.value)" <?php if($range=='2') echo "checked";?>> 昨日
<input name='range' type='radio' value='7' onclick="redirect('?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&type=<?=$type?>&range='+this.value)" <?php if($range=='7') echo "checked";?>> 一周
<input name='range' type='radio' value='14' onclick="redirect('?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&type=<?=$type?>&range='+this.value)" <?php if($range=='14') echo "checked";?>> 两周
<input name='range' type='radio' value='30' onclick="redirect('?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&type=<?=$type?>&range='+this.value)" <?php if($range=='30') echo "checked";?>> 一月
</td>
</tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
  <tr>
	<caption>广告统计</caption>
  </tr>
  <tr>
    <th>广告展示统计</th>
    <th>广告点击统计</th>
  </tr>
  <tr>
    <td valign="top"><table cellpadding="0" cellspacing="1" class="table_list">
  <?php if($type==1) {?>
<tr>
<th>所属地域</th>
<th>展示次数</th>
</tr>
<?php foreach($states[1] as $i => $stat) {?>
<tr>
<td><?=$stat['area']?></td>
<td><?=$stat['num']?></td>
</tr>
<? } } elseif($type==3) {?>
<tr>
<th>用户名</th>
<th>展示次数</th>
</tr>
<?php foreach($states[1] as $i => $stat) {?>
<td><?=$stat['username']?></td>
<td><?=$stat['num']?></td>
</tr>
<? } } else {?>
<tr> 
      <th>浏览ip</th>
	  <th>所属地域</th>
      <th>展示时间</th>
	  <th>展示次数</th>
    </tr>
	<?php foreach($states[1] as $i => $stat) {?>
	<tr> 
      <td><?=$stat['ip']?></td>
	  <td class="align_c"><?=$stat['area']?></td>
      <td class="align_c"><?=date('Y-m-d H:i:s', $stat['clicktime'])?></td>
	  <td class="align_c"><?=$stat[num]?></td>
    </tr>
	<? } } ?>
</table>
</td>
    <td valign="top"><table cellpadding="0" cellspacing="1" class="table_list">
  <?php if($type==1) {?>
<tr>
<th>所属地域</th>
<th>点击次数</th>
</tr>
<?php foreach($states[0] as $i =>$stat) {?>
<tr>
<td class="align_c"><?=$stat['area']?></td>
<td class="align_c"><?=$stat['num']?></td>
</tr>
<?php } } elseif($type==3) {?>
<tr>
<th>用户名</th>
<th>点击次数</th>
<?php foreach($states[0] as $i =>$stat) {?>
<tr>
<td class="align_c"><?=$stat['username']?></td>
<td class="align_c"><?=$stat['num']?></td>
</tr>
<?php } } else {?> 
<tr> 
      <th>点击ip</th>
	  <th>所属地域</th>
      <th>点击时间</th>
	  <th>点击次数</th>
    </tr>
	<?php foreach($states[0] as $i =>$stat) {?>
	<tr> 
      <td><?=$stat['ip']?></td>
	  <td class="align_c"><?=$stat['area']?></td>
      <td class="align_c"><?=date('Y-m-d H:i:s', $stat['clicktime'])?></td>
	  <td class="align_c"><?=$stat['num']?></td>
    </tr>
	<?php } }?>
</table></td>
  </tr>
</table>
</body>
</html>