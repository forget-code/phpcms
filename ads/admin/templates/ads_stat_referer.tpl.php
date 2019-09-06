<table cellpadding="0" cellspacing="1" class="table_list">
	<tr>
		<th>引用页面</th>
		<th><?=$pv?'浏览':'点击'?>次数</th>
	</tr>
	<?php foreach($states[$pv] as $i => $stat) {?>
		<tr>			
			<td><?=$stat['referer']?></td>
			<td><?=$stat['num']?></td>
		</tr>
	<?php } ?>
</table>