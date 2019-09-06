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
	if (str_area!=null&&str_area.length > max_length && document.myform.fieldtype.value!=2){
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

<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>自定义字段添加</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=field&action=add&channelid=<?=$channelid?>&tablename=<?=$tablename?>" method="post" name="myform">
    <tr> 
      <td class="tablerow" width="30%"><strong>字段名</strong></td>
      <td class="tablerow">
          <input name="name" type="text" size="20" maxlength="20" value="my_">
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>字段标题</strong></td>
      <td class="tablerow">
	  <input name="title" type="text" size="50">
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>字段说明</strong></td>
      <td class="tablerow">
      <textarea name='note' rows='3' cols='50'></textarea>
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>字段类型</strong></td>
      <td class="tablerow">
<select name="type" onchange="javascript:typechange(this.value)">
<option value='varchar' selected>字符串(Varchar)</option>
<option value='int'>整数(Int)</option>
<option value='date'>日期(Date)</option>
<option value='text'>一般文本(Text)</option>
<option value='mediumtext'>中型文本(Mediumtext)</option>
<option value='longtext'>大型文本(Longtext)</option>
</select>
	 </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>字段长度</strong></td>
      <td class="tablerow">
	  <input name="size" type="text" size="12" value="250"> 字节
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>表单类型</strong></td>
      <td class="tablerow">
<select name="formtype" onchange="javascript:formtypechange(this.value)">
<option value='text' selected>单行文本(text)</option>
<option value='textarea'>多行文本(textarea)</option>
<option value='select'>下拉框(select)</option>
<option value='radio'>单选框(radio)</option>
<option value='checkbox'>多选框(checkbox)</option>
<option value='password'>密码框(password)</option>
<option value='hidden'>隐藏域(hidden)</option>
</select>
	 </td>
    </tr>
    <tr>
      <td class='tablerow'><strong>默认值</strong></td>
      <td class='tablerow'>
          <textarea name='defaultvalue' rows='1' cols='50' onkeypress="javascript:checktextarealength('defaultvalue',30);"></textarea>
	  </td>
    </tr>
    <tr id='trOptions' style='display:none'>
      <td  class='tablerow'><strong>表单选项：</strong><br>每行一个</td>
      <td class='tablerow'><textarea name='options' cols='40' rows='5' id='options'>选项一|选项值一
选项二|选项值二
选项三|选项值三</textarea></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>表单输入辅助工具</strong></td>
      <td class="tablerow">
<select name="inputtool">
<option value=''>无</option>
<option value='dateselect'>日期选择</option>
<option value='fileupload'>文件上传</option>
<option value='imageupload'>图片上传</option>
<option value='editor'>可视化编辑器</option>
</select>
	 </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>表单输入限制</strong></td>
      <td class="tablerow">
<select name="inputlimit">
<option value=''>无限制</option>
<option value='notnull'>不能为空</option>
<option value='numeric'>限数字</option>
<option value='letter'>限字母</option>
<option value='numeric_letter'>限数字或字母</option>
<option value='email'>限E-mail地址</option>
<option value='date'>限日期格式</option>
<option value='unique'>值唯一</option>
</select>
	 </td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>允许输入html代码</strong></td>
      <td class='tablerow'>
		 <input type='radio' name='enablehtml' value='1' checked> 是
		 <input type='radio' name='enablehtml' value='0'> 否
	  </td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>在列表页显示</strong></td>
      <td class='tablerow'>
		 <input type='radio' name='enablelist' value='1' checked> 是
		 <input type='radio' name='enablelist' value='0'> 否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>作为搜索条件</strong></td>
      <td class="tablerow">
		 <input type='radio' name='enablesearch' value='1'> 是 
		 <input type='radio' name='enablesearch' value='0' checked> 否
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