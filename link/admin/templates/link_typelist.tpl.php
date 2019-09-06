<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding='2' cellspacing='0' border='0' align='center' class='tableBorder'>

  <tr>
    <td align="left">
	分类列表：</br>	
	<?php 
	$i = 1;
	foreach($TYPE as $typeid=>$v)
	{
		if($i > 10) break;
		echo "<a href='?mod=".$mod."&file=".$file."&action=manage&typeid=".$v['typeid']."'>".$v['name']."</a> | ";
		$i++;
	}
	?>
	</td>
	</tr>
</table>
<BR>
</body>
</html>