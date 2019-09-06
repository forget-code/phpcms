<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script language="javascript" type="text/javascript">
<!--
function checkform()
{
	if(document.getElementById("uploadfile").value=='') { alert("请选择要上传的文件！"); return false;}
}
//-->
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td ></td>
  </tr>
</table>
<form name="upload" method="post" 
action="?mod=<?= $mod?>&file=upload&url=<?=$url?>&extid=<?=$extid?>&action=upload" enctype="multipart/form-data" onSubmit="return checkform();">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>文件上传</th>
  </tr>
  <tr>
     <td class="tablerow" height="30">
             选择：<input name="uploadfile" type="file" id="uploadfile" size="20" />
             <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_CHA['maxfilesize']; ?>" /> 
             <input type="hidden" name="channelid" value="<?php echo $channelid; ?>" />
             <input type="submit" name="submit" value=" 上传 ">
			 </td>
   </tr>
</table>
</form>

</body>
</html>