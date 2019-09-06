<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>
  答案详细信息
</caption>
	<tr>
		<th class="align_left" width="10%">问题：</th>	
		<td class="align_left"><?=$info['title']?></td>	
	</tr>
		<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
		   <td>回答：</td>
		   <td><?=$info['message']?></td>
		</tr>
</tbody>
</table>

</body>
</html>