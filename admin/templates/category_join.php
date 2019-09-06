<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=4>合并栏目</th>
  </tr>
<form method="post" action="?mod=phpcms&file=category&action=join&channelid=<?=$channelid?>">
<tr align="center"><td colspan=2 class="tablerowhighlight">源栏目的文章全部转入目标栏目，同时删除源栏目和其子栏目</td></tr>
<tr>
<td class="tablerow" width="45%" align="right">源栏目</td>
<td class="tablerow" width="55%">
<select name="sourcecatid">
<option value="0"> - 无 - </option>
<?=$cat_option?>
</select>
</td>
</tr>
<tr><td class="tablerow" width="40%" align="right">目标栏目</td>
<td class="tablerow" width="60%">
<select name="targetcatid">
<option value="0" selected="selected"> - 无 - </option>
<?=$cat_option?>
</select>
</td></tr>
<tr align="center"><td class="tablerow" colspan=2 ><input type="submit" name="submit" value=" 合并 "></td></tr>
</form>
</table>
</body>
</html>