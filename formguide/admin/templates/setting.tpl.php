<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan=2>表单向导模块配置-基本信息</th>	 
	<tr>
      <td  class='tablerow'><strong>当表单中类型上传文件时文件的保存目录</strong></td>
      <td class='tablerow'><input name='setting[uploaddir]' type='text' id='uploaddir' value='<?=$uploaddir?>' size='20' maxlength='50'></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>允许上传的最大文件大小</strong></td>
      <td class='tablerow'><input name='setting[maxfilesize]' type='text' id='maxfilesize' value='<?=$maxfilesize?>' size='20' maxlength='50'> Byte</td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>允许上传的文件类型</strong></td>
      <td class='tablerow'>
<input name='setting[uploadfiletype]' type='text' id='uploadtype' value='<?=$uploadfiletype?>' size='60' maxlength='200'>
	  </td>
	</tr>
	<tr>
      <td  class='tablerow'><strong>同一表单是否允许同一IP多次提交</strong></td>
      <td class='tablerow'><input type='radio' name='setting[allowmultisubmit]' value='1'  <?php if($allowmultisubmit){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[allowmultisubmit]' value='0'  <?php if(!$allowmultisubmit){ ?>checked <?php } ?>> 否
	  </td>
	</tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>