<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script language="JavaScript">
<!--
function typechange(val) {
    if(val == 'varchar') {
        document.myform.size.value = '250';
	}
	else if(val == 'int') {
        document.myform.size.value = '10';
	}
	else if(val == 'date') {
        document.myform.size.value = '';
	}
	else if(val == 'text') {
        document.myform.size.value = '10000';
	}
	else if(val == 'mediumtext') {
        document.myform.size.value = '100000';
	}
	else if(val == 'longtext') {
        document.myform.size.value = '1000000';
	}
}
function checktextarealength(val, max_length) {
	var str_area=document.forms[0].elements[val].value;
	if (str_area!=null && str_area.length > max_length && document.myform.type.value!='text' && document.myform.type.value!='mediumtext' && document.myform.type.value!='longtext'){
		alert("文本文字超长，最多可输入" + max_length +"个字符，请重新输入！");
		document.forms[0].elements[val].focus();
		return false;
	}
	return true;
}
function formtypechange(val){
	if(val=='select'){
		trOptions.style.display='';
		document.myform.defaultvalue.rows=1;
	}else if(val=='text'){
		trOptions.style.display='none';
		document.myform.defaultvalue.rows=1;
	}else if(val=='textarea'){
		trOptions.style.display='none';
		document.myform.defaultvalue.rows=10;
	}else if(val=='radio'){
		trOptions.style.display='';
	}else if(val=='checkbox'){
		trOptions.style.display='';
	}else{
		trOptions.style.display='none';
		document.myform.defaultvalue.rows=1;
	}
}
-->
</script>

<body onload="formtypechange(myform.formtype.value)">
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>自定义字段修改</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>&fieldid=<?=$fieldid?>&tablename=<?=$tablename?>" method="post" name="myform">
    <tr> 
      <td class="tablerow" width="30%"><strong>字段名称</strong></td>
      <td class="tablerow">
          <input size=20 name="name" type="text" maxlength='20' value="<?=$name?>" disabled>
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>字段标题</strong></td>
      <td class="tablerow">
	  <input size=50 name="title" type="text" value="<?=$title?>">
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>字段说明</strong></td>
      <td class="tablerow">
<textarea name='note' rows='3' cols='50'><?=$note?></textarea>
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>字段类型</strong></td>
      <td class="tablerow">
<select name="type" onchange="javascript:typechange(this.value)">
<option value='varchar' <?php if($type == 'varchar') echo 'selected';?>>字符串(Varchar)</option>
<option value='int' <?php if($type == 'int') echo 'selected';?>>整数(Int)</option>
<option value='date' <?php if($type == 'date') echo 'selected';?>>日期(Date)</option>
<option value='text' <?php if($type == 'text') echo 'selected';?>>一般文本(Text)</option>
<option value='mediumtext' <?php if($type == 'mediumtext') echo 'selected';?>>中型文本(Mediumtext)</option>
<option value='longtext' <?php if($type == 'longtext') echo 'selected';?>>大型文本(Longtext)</option>
</select>
	 </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>字段长度</strong></td>
      <td class="tablerow">
	  <input name="size" type="text" size="12" value="<?=$size?>"> 字节
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>表单类型</strong></td>
      <td class="tablerow">
<select name="formtype" onchange="javascript:formtypechange(this.value)">
<option value='text' <?php if($formtype == 'text') echo 'selected';?>>单行文本(text)</option>
<option value='textarea' <?php if($formtype == 'textarea') echo 'selected';?>>多行文本(textarea)</option>
<option value='select' <?php if($formtype == 'select') echo 'selected';?>>下拉框(select)</option>
<option value='radio' <?php if($formtype == 'radio') echo 'selected';?>>单选框(radio)</option>
<option value='checkbox' <?php if($formtype == 'checkbox') echo 'selected';?>>多选框(checkbox)</option>
<option value='password' <?php if($formtype == 'password') echo 'selected';?>>密码框(password)</option>
<option value='hidden' <?php if($formtype == 'hidden') echo 'selected';?>>隐藏域(hidden)</option>
</select>
	 </td>
    </tr>
    <tr>
      <td class='tablerow'><strong>默认值</strong></td>
      <td class='tablerow'>
          <textarea name='defaultvalue' rows='1' cols='50' onkeypress="javascript:checktextarealength('defaultvalue',30);"><?=$defaultvalue?></textarea>
	  </td>
    </tr>
    <tr id='trOptions' style='display:<?=(in_array($formtype, array('select','radio','checkbox')) ? 'block' : 'none')?>'>
      <td  class='tablerow'><strong>表单选项：</strong><br>每行一个</td>
      <td class='tablerow'><textarea name='options' cols='40' rows='5' id='options'><?=$options?></textarea></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>表单输入辅助工具</strong></td>
      <td class="tablerow">
<select name="inputtool">
<option value=''>无</option>
<option value='dateselect' <?php if($inputtool == 'dateselect') echo 'selected';?>>日期选择</option>
<option value='fileupload' <?php if($inputtool == 'fileupload') echo 'selected';?>>文件上传</option>
<option value='imageupload' <?php if($inputtool == 'imageupload') echo 'selected';?>>图片上传</option>
<option value='editor' <?php if($inputtool == 'editor') echo 'selected';?>>可视化编辑器</option>
</select>
	 </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>表单输入限制</strong></td>
      <td class="tablerow">
<select name="inputlimit">
<option value='' <?php if($inputlimit == '') echo 'selected';?>>无限制</option>
<option value='notnull' <?php if($inputlimit == 'notnull') echo 'selected';?>>不能为空</option>
<option value='numeric' <?php if($inputlimit == 'numeric') echo 'selected';?>>限数字</option>
<option value='letter' <?php if($inputlimit == 'letter') echo 'selected';?>>限字母</option>
<option value='numeric_letter' <?php if($inputlimit == 'numeric_letter') echo 'selected';?>>限数字或字母</option>
<option value='email' <?php if($inputlimit == 'email') echo 'selected';?>>限E-mail地址</option>
<option value='date' <?php if($inputlimit == 'date') echo 'selected';?>>限日期格式</option>
<option value='unique' <?php if($inputlimit == 'unique') echo 'selected';?>>值唯一</option>
</select>
	 </td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>允许输入html代码</strong></td>
      <td class='tablerow'>
		 <input type='radio' name='enablehtml' value='1' <?php if($enablehtml) echo 'checked';?>> 是
		 <input type='radio' name='enablehtml' value='0' <?php if(!$enablehtml) echo 'checked';?>> 否
	  </td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>在列表页显示</strong></td>
      <td class='tablerow'>
		 <input type='radio' name='enablelist' value='1' <?php if($enablelist) echo 'checked';?>> 是
		 <input type='radio' name='enablelist' value='0' <?php if(!$enablelist) echo 'checked';?>> 否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>作为搜索条件</strong></td>
      <td class="tablerow">
		 <input type='radio' name='enablesearch' value='1' <?php if($enablesearch){ ?>checked<?php } ?>> 是 
		 <input type='radio' name='enablesearch' value='0' <?php if(!$enablesearch){ ?>checked<?php } ?>> 否
    </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="Submit" name="dosubmit" value=" 确定 "> 
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>