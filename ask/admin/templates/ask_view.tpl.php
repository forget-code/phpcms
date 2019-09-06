<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="table_form">
	 <caption>
  提问详细信息
  </caption
	<tr>
		<td width="80" >问题：</td>	
		<td align="left" ><?=$info['title']?></td>	
	</tr>
		<tr>
		   <td align="center">追加问题：</td>
		   <td align="left">&nbsp;<?=$info['message']?></td>
		</tr>
</tbody>
</table>

</body>
</html>