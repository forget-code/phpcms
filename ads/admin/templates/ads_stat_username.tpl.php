<table cellpadding="0" cellspacing="1" class="table_list">
	<tr>
		<th>用户账号</th>
		<th><?=$pv?'浏览':'点击'?>次数</th>
	</tr>
	<?php foreach($states[$pv] as $i => $stat) {?>
		<tr>			
			<td><?=$stat['username']?></td>
			<td><?=$stat['num']?></td>
		</tr>
	<?php } ?>
</table>