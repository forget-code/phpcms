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

<body onload="fieldcheckform(myform.fieldtype.value)">
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
    <th colspan=2>自定义字段修改</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=field&action=edit&channelid=<?=$channelid?>&fieldid=<?=$fieldid?>" method="post" name="myform">
    <tr> 
      <td class="tablerow" width="30%"><strong>字段名称</strong></td>
      <td class="tablerow">
          <input size=20 name="fieldname" type="text" maxlength='20' value="<?=$fieldname?>" disabled>
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
<select name='fieldtype' disabled>
<option value='1' <?php if($fieldtype==1){ ?>selected <?php } ?>>单行文本</option>
<option value='2' <?php if($fieldtype==2){ ?>selected <?php } ?>>多行文本</option>
<option value='3' <?php if($fieldtype==3){ ?>selected <?php } ?>>下拉列表</option>
<option value='4' <?php if($fieldtype==4){ ?>selected <?php } ?>>数字</option>
<option value='5' <?php if($fieldtype==5){ ?>selected <?php } ?>>日期</option>
</select>
	 </td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>默认值</strong></td>
      <td class='tablerow'>
<textarea name='defaultvalue' rows='1' cols='50' onkeypress="javascript:checktextarealength('defaultvalue',30);"><?=$defaultvalue?></textarea>
	  </td>
    </tr>
    <tr id='trOptions' style='display:none'>
      <td  class='tablerow'><strong>列表项目：</strong><br>每一行为一个列表项目</td>
      <td class='tablerow'><textarea name='options' cols='40' rows='3' id='options'><?=$options?></textarea></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>是否必填</strong></td>
      <td class='tablerow'>
		 <input type='radio' name='enablenull' value='0' <?php if($enablenull==0){ ?>checked<?php } ?>> 是 
		 <input type='radio' name='enablenull' value='1' <?php if($enablenull==1){ ?>checked<?php } ?>> 否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>是否作为搜索条件</strong></td>
      <td class="tablerow">
		 <input type='radio' name='enablesearch' value='1' <?php if($enablesearch==1){ ?>checked<?php } ?>> 是 
		 <input type='radio' name='enablesearch' value='0' <?php if($enablesearch==0){ ?>checked<?php } ?>> 否
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