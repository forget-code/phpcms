<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script language="JavaScript">
  <!--
  //检验文本框中内容是否超长
    function checktextarealength(val, max_length) {
        var str_area=document.forms[0].elements[val].value;
        if (str_area!=null&&str_area.length > max_length && document.myform.fieldtype.value!=2){
            alert("文本文字超长，最多可输入" + max_length +"个字符，请重新输入！");
            document.forms[0].elements[val].focus();
            return false;
        }
        return true;
    }
    function fieldcheckform(FieldTypeValue){
        if(FieldTypeValue=='3'){
            trOptions.style.display='';
            document.myform.defaultvalue.rows=1;
        }else if(FieldTypeValue=='2'){
            trOptions.style.display='none';
            document.myform.defaultvalue.rows=10;
        }else{
            trOptions.style.display='none';
            document.myform.defaultvalue.rows=1;
        }
    }
    -->
  </script>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>自定义字段添加</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=field&action=add&channelid=<?=$channelid?>" method="post" name="myform">
    <tr> 
      <td class="tablerow" width="30%"><strong>字段名称</strong></td>
      <td class="tablerow">
          <input size=20 name="fieldname" type="text" maxlength='20' value="my_">
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>字段标题</strong></td>
      <td class="tablerow">
	  <input size=50 name="title" type="text">
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
<select name='fieldtype' onchange="javascript:fieldcheckform(this.options[this.selectedIndex].value)">
<option value='1' selected>单行文本</option>
<option value='2'>多行文本</option>
<option value='3'>下拉列表</option>
<option value='4'>数字</option>
<option value='5'>日期</option>
</select>
	 </td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>默认值</strong></td>
      <td class='tablerow'>
<textarea name='defaultvalue' rows='1' cols='50' onkeypress="javascript:checktextarealength('defaultvalue',30);"></textarea>
	  </td>
    </tr>
    <tr id='trOptions' style='display:none'>
      <td  class='tablerow'><strong>列表项目：</strong><br>每一行为一个列表项目</td>
      <td class='tablerow'><textarea name='options' cols='40' rows='3' id='options'></textarea></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>是否必填</strong></td>
      <td class='tablerow'>
		 <input type='radio' name='enablenull' value='0'> 是 
		 <input type='radio' name='enablenull' value='1' checked> 否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>是否作为搜索条件</strong></td>
      <td class="tablerow">
		 <input type='radio' name='enablesearch' value='1'> 是 
		 <input type='radio' name='enablesearch' value='0' checked> 否
    </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="Submit" name="submit" value=" 确定 "> 
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>