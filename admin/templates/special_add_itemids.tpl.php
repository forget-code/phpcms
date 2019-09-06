<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>请选择专题</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>" method="post" name="myform">
   <input name="forward" type="hidden" id="forward" value="<?=$forward?>">
   <input name="itemids" type="hidden" id="itemids" value="<?=$itemids?>">
	<tr> 
      <td class="tablerow" width="20%">专题名称：</td>
      <td class="tablerow"><?=special_select($channelid, 'specialid', '请选择专题')?> &nbsp;&nbsp;<input type="submit" name="dosubmit" value=" 确定 "> </td>
    </tr>
  </form>
</table>
</body>
</html>