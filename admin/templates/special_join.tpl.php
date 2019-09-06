<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=4>合并专题</th>
  </tr>
<form method="post" action="?mod=phpcms&file=special&action=join&channelid=<?=$channelid?>">
<tr align="center"><td colspan=2 class="tablerowhighlight">专题合并 - 源专题的文章全部转入目标专题，同时删除源专题</td></tr>
<tr>
<td class="tablerow" width="45%" align="right">源专题</td>
<td class="tablerow" width="55%">
<select name="sourcespecialid">
<option value="0"> - 无 - </option>
<?php 
if(is_array($specials)){
	foreach($specials as $special){
?>
<option value='<?=$special[specialid]?>'><?=$special[specialname]?></option>
<?php 
	}
}
?>
</select>
</td>
</tr>
<tr><td class="tablerow" width="40%" align="right">目标专题</td>
<td class="tablerow" width="60%">
<select name="targetspecialid">
<option value="0" selected="selected"> - 无 - </option>
<?php 
if(is_array($specials)){
	foreach($specials as $special){
?>
<option value='<?=$special[specialid]?>'><?=$special[specialname]?></option>
<?php 
	}
}
?>
</select>
</td></tr>
<tr align="center"><td class="tablerow" colspan=2 ><input type="submit" name="submit" value=" 合并 "></td></tr>
</form>
</table>
</body>
</html>