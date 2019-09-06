<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>" enctype="multipart/form-data">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>配置文件导入</th>
  </tr>
    <tr>
	<td class="tablerow"> </td>
    <td class="tablerow">
	   导入配置文件：<input name="uploadfile" type="file" size="20"> 
       <input type="hidden" name="MAX_FILE_SIZE" value="2048000"> 
       <input type="submit" name="dosubmit" value=" 导入 "></td>
  </tr>
    <tr>
	<td class="tablerow"> </td>
    <td class="tablerow">配置文件必须以.txt为后缀，导入之前请自行确认该配置文件是安全的</td>
  </tr>
</table>
</form>
</body>
</html>