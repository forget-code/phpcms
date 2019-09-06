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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th><?=$username?>的备注</th>
  </tr>
  <form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=note&userid=<?=$userid?>&save=1">
     <tr> 
      <td height="25" align="center" class="tablerow" >请在下面记录该会员的备注信息（只有管理员才能看到）</td>
    </tr>
   <tr> 
      <td height="40" align="center" class="tablerow" ><textarea name="note" cols="100" rows="16"><?=$note?></textarea></td>
    </tr>
   <tr> 
      <td height="40" align="center" class="tablerow" > <input type="submit" name="submit" value=" 修改 "></td>
    </tr>
  </form>
</table>
</body>
</html>