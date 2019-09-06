<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=4>合并栏目</th>
  </tr>
<form method="post" action="?mod=yp&file=category&action=join&channelid=<?=$channelid?>">
<tr align="center"><td colspan=2 class="tablerowhighlight">源栏目的文章全部转入目标栏目，同时删除源栏目和其子栏目</td></tr>
<tr>
<td class="tablerow" width="45%" align="right">源栏目</td>
<td class="tablerow" width="55%">
<?=$category_source?>
</td>
</tr>
<tr><td class="tablerow" width="40%" align="right">目标栏目</td>
<td class="tablerow" width="60%">
<?=$category_target?>
</td></tr>
<tr align="center"><td class="tablerow" colspan=2 ><input type="submit" name="dosubmit" value=" 合并 "></td></tr>
</form>
</table>
</body>
</html>