<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>文件上传</th>
  </tr>
	<form name="upload" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uploadtext=<?=$uploadtext?>&action=<?=$action?>" enctype="multipart/form-data">
  <tr>
     <td class="tablerow" height="30">
	         <input type="hidden" name="save" value="1">
             <input type="file" name="uploadfile" size="15">
             <input type="hidden" name="type" value="<?=$type?>">
             <input type="hidden" name="rename" value="<?=$rename?>">
			 <input type="hidden" name="oldaid">
             <input type="hidden" name="oldname">
             <input type="hidden" name="MAX_FILE_SIZE" value="<?=$maxfilesize?>"> 
             <input type="submit" name="submit" value=" 上传 ">
			 </td>
   </tr>
  <tr>
     <td class="tablerow">
<script>
if(window.opener.myform.<?=$uploadtext?>.value!="")
{
	upload.oldname.value = window.opener.myform.<?=$uploadtext?>.value;
	upload.oldaid.value = window.opener.myform.<?=$uploadtext?>_aid.value;
}
</script>
			 </td>
   </tr>
	</form>
</table>

</body>
</html>