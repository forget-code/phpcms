<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<form action="" method="post" name="myform" >
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=7>询盘留言查看</th>
<?php if($title) { ?>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td width="10%">询价对象：</td>
<td width="40%"><?=$title?></td>
<td width="10%">留言页面：</td>
<td width="40%"><a href="<?=$linkurl?>" target="_blank"><?=$linkurl?></a></td>
</tr>
<?php } ?>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td width="10%">姓名：</td>
<td width="40%"><?=$username?></td>
<td width="10%">公司传真：</td>
<td width="40%"><?=$fax?></td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td >联系电话：</td>
<td ><?=$telephone?></td>
<td >QQ：</td>
<td ><?=$qq?></td>
</td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td >所在单位：</td>
<td ><?=$unit?></td>
<td >MSN：</td>
<td ><?=$msn?></td>
</td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td >Email：</td>
<td colspan="3"><?=$email?></td>
</td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td >留言内容：</td>
<td colspan="3"><?=$content?></td>
</td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'> </td>
  </tr>
</table>

</body>
</html>
