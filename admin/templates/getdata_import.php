<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=import" enctype="multipart/form-data">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>配置文件导入</th>
  </tr>
    <tr>
	<td class="tablerow"> </td>
    <td class="tablerow">
	   导入配置文件：<input name="upload" type="file" size="20"> 
       <input type="hidden" name="MAX_FILE_SIZE" value="2048000"> 
       <input type="submit" name="Submit" value=" 导入 "></td>
  </tr>
    <tr>
	<td class="tablerow"> </td>
    <td class="tablerow">配置文件必须以.php为后缀，导入之前请自行确认该配置文件是安全的</td>
  </tr>
</table>
</form>
</body>
</html>