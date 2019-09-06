<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript">
	window.onload=function(){
	var h = 25;
	parent.document.getElementById('uploads').height = h;
}
var _FileNum = 1;
function _AddInputFile(Field)
{
    _FileNum++;
	var fileTag = "<div id='file_"+_FileNum+"'><input type='file' name='"+Field+"["+_FileNum+"]' size='20' onchange='javascript:_AddInputFile(\""+Field+"\");parenth(1)'> <input type='text' name='"+Field+"_description["+_FileNum+"]' size='20' title='名称'> <input type='button' value='删除' name='Del' onClick='DelInputFile("+_FileNum+");parenth(0);'></div>";
	var fileObj = document.createElement("div");
	fileObj.id = 'file_'+_FileNum;
	fileObj.innerHTML = fileTag;
	document.getElementById("file_div").appendChild(fileObj);
}

function parenth(flag) {
	var h = $('#height').val();
	h = parseInt(h);
	if(flag) {
		h += 20;
	} else {
		h -= 20;
	}
	parent.document.getElementById('uploads').height = h;
	$('#height').val(h);
}
</script>
<table width="100%" cellpadding="0" cellspacing="0"  height="100%">
  <tr>
    <td>
		<table cellpadding="0" cellspacing="0" width="100%">
		<form name="upload" method="post" action="?mod=phpcms&file=downfiles&&dosubmit=1" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?=UPLOAD_MAXSIZE?>" />
		<input type="hidden" name="height" id="height" value="25">
		<tr>
		<td width="400">
		<div id='file_uploaded'>
		<div id="file_div">
			<div id="file_1"><input type="file" name="uploadfile[1]" size="20" onchange="javascript:_AddInputFile('uploadfile');parenth(1);"> <input type="text" name="file_description[1]" size="20" title="名称"> <input type="button" value="删除" name="Del" onClick="DelInputFile(1);parenth(0);"></div>
		</div>
		</div>
		</td>
		<td valign="top">
		<input type="submit" value=" 上传 "  onclick="this.value='正在上传...';"></td></form>
		</td>
		</tr>
		</table>
	</td>
  </tr>

</table>
</body>
</html>