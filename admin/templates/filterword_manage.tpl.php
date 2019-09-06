<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>非法信息屏蔽日志管理操作</caption>
  <tr>
     <td align="center" width="40%">
	 <form method="get" action="?">
	 IP：<input name="ip" type="text" id="ip" size="15" value="<?php echo $ip;?>"> &nbsp;
	 <select name="year">
	 <?php for($i=2008; $i<=$curyear; $i++){ 
	         echo "<option value='$i' ".($i==$year ? 'selected' : '').">$i</option>\n";
	       } 
	 ?>
	 </select>年
	 <select name="month">
	 <option value=""></option>
	 <?php for($i=1; $i<=12; $i++){ 
		     $v = $i >9 ? $i : '0'.$i;
	         echo "<option value='$v'".($i==$month ? 'selected' : '').">$i</option>\n";
	       } 
	 ?>
	 </select>月 <input type="submit" name="dosubmit" value=" 查询 ">
	 <input type="hidden" name="mod" value="<?=$mod?>">
	 <input type="hidden" name="file" value="<?=$file?>">
	 <input type="hidden" name="action" value="<?=$action?>">
	 </form>
	 </td>
     <td align="center" width="30%">
	 <form method="get" action="?">
	 <select name="year">
	 <?php for($i=2008; $i<=$curyear; $i++){ 
	         echo "<option value='$i' ".($i==$curyear ? 'selected' : '').">$i</option>\n";
	       } 
	 ?>
	 </select>年
	 <select name="month">
	 <?php for($i=1; $i<=12; $i++){ 
		     $v = $i >9 ? $i : '0'.$i;
	         echo "<option value='$v'".($i==$curmonth ? 'selected' : '').">$i</option>\n";
	       } 
	 ?>
	 </select>月 <input type="submit" name="dosubmit" value=" 下载 ">
	 <input type="hidden" name="mod" value="<?=$mod?>">
	 <input type="hidden" name="file" value="<?=$file?>">
	 <input type="hidden" name="action" value="download">
	 </form>
	 </td>
     <td align="center" width="30%">
	 <form method="get" action="?">
	 <select name="year">
	 <?php for($i=2008; $i<=$curyear; $i++){ 
	         echo "<option value='$i' ".($i==$curyear ? 'selected' : '').">$i</option>\n";
	       } 
	 ?>
	 </select>年
	 <select name="month">
	 <option value=""></option>
	 <?php for($i=1; $i<=12; $i++){ 
		     $v = $i >9 ? $i : '0'.$i;
	         echo "<option value='$v'".($i==$curmonth ? 'selected' : '').">$i</option>\n";
	       } 
	 ?>
	 </select>月 <input type="submit" name="dosubmit" value=" 删除 ">
	 <input type="hidden" name="mod" value="<?=$mod?>">
	 <input type="hidden" name="file" value="<?=$file?>">
	 <input type="hidden" name="action" value="delete">
	 </form>
	 </td>
  </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>非法信息屏蔽日志</caption>
    <tr>
        <th><strong>非法词语</strong></th>
        <th><strong>原词</strong></th>
        <th><strong>发布时间</strong></th>
        <th><strong>IP</strong></th>
    </tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td><?=$info[2]?></td>
<td><?=$info[3]?></td>
<td class="align_c"><?=date('Y-m-d H:i:s', $info[0])?></td>
<td class="align_c"><a href="http://www.phpcms.cn/ip.php?ip=<?=$info[1]?>" target="_blank"><?=$info[1]?></a></td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>