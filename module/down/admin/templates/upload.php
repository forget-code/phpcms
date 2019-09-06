<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" width="100%">
<form name="upload" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uploadtext=<?=$uploadtext?>&action=<?=$action?>" enctype="multipart/form-data">
  <tr>
     <td class="tablerow" height="50">
	         <input type="hidden" name="save" value="1">
			 说明：<input type="text" name="note" size="20">
             <input type="file" name="uploadfile" size="15">
             <input type="hidden" name="MAX_FILE_SIZE" value="<?=$maxfilesize?>"> 
             <input type="submit" name="submit" value=" 上传 ">
			 </td>
   </tr>
	</form>
</table>
</body>
</html>