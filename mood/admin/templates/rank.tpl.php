<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<table width="100%" cellpadding="0" cellspacing="1" class="table_list">
<caption>按方案浏览</caption>
	<tr>
		<td class="align_left">
		<?php
		$string = '';
		foreach($arraymood AS $k=>$v)
		{
			if($moodid == $v['moodid'])
			{
				$string .= "<a href='?mod=$mod&file=$file&moodid=$v[moodid]'><b>$v[name]</b></a> | ";
			}
			else
			{
				$string .= "<a href='?mod=$mod&file=$file&moodid=$v[moodid]'>$v[name]</a> | ";
			}
		}
		echo substr($string,0,-2);
		?>
		</td>
	</tr>
</table>

<table cellpadding="0" cellspacing="1" class="table_info">
  <tr>
    <td><input type="radio" name="range" value="" <?=$range == '' ? 'checked' : ''?> onclick="redirect('?mod=mood&file=rank&range='+this.value)"/> 总排行 <input type="radio" name="range" value="1" <?=$range == 1 ? 'checked' : ''?>  onclick="redirect('?mod=mood&file=rank&range='+this.value)"/> 今日排行 <input type="radio" name="range" value="7" <?=$range == 7 ? 'checked' : ''?> onclick="redirect('?mod=mood&file=rank&range='+this.value)"/> 本周排行 <input type="radio" name="range" value="30" <?=$range == 30 ? 'checked' : ''?> onclick="redirect('?mod=mood&file=rank&range='+this.value)"/> 本月排行</td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" class="table_list">
<caption>心情排行</caption>
	<tr>
		<th width="10%">总指数</th>
		<th >标题</th>
		<?php
		for($i=1;$i<=$number;$i++)
		{
			$f = 'm'.$i;
			$f = explode('|',$$f);
			echo "<th>".$f[0]."</th>";
		}
		?>
	</tr>
<?php
foreach($infos AS $info)
{
?>
	<tr>
		<td class="align_c"><?=$info['total']?></td>
		<td class="align_l" width="300"><a href="<?=$info['url']?>" target="_blank"><?=$info['title']?></a></td>
		<?php
		for($i=1;$i<=$number;$i++)
		{
			$f = 'n'.$i;
			echo "<td class=\"align_c\">".$info[$f]."</td>";
		}
		?>
	</tr>
<?php
}
?>
</table>
<div id="pages"><?=$rank->pages?></div>
</body>
</html>