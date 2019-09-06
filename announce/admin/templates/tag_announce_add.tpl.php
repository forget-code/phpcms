<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script type="text/javascript">
function doCheck(){
	if($('#tagname').val()==''){
		alert('标签名称不能为空');
		$('#tagname').focus();
		return false;
	}
	return true;
}

var i = 3;
function var_add()
{
	var data = '<div id="var'+i+'"><span style="width:150px"><input name="tag_config[var_description]['+i+']" type="text" size="18"></span><span style="width:100px"><input name="tag_config[var_name]['+i+']" type="text" size="10"> => </span><span style="width:120px"><input name="tag_config[var_value]['+i+']" type="text" size="15"></span> <span> <a href="###" onclick="var_del('+i+')">删除</a></span></div>';
	$('#var_define').append(data);
	i++;
	return true;
}

function var_del(i)
{
	$('#var'+i).remove();
	return true;
}

$().ready(function() {
	  $('form').checkForm(1);
	});
</script>
<form name="myform" method="get" action="?" onSubmit="return doCheck();">
<table class="table_form" cellspacing="1" cellpadding="0">
   <caption>添加标签</caption>  
   <input name="mod" id="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" id="action" type="hidden" value="<?=$action?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input type="hidden" name="isadd" value="1">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="forward" type="hidden" value="<?=$forward?>">
    <tr> 
      <td><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td width="75%">
	  <input name="tagname" id="tagname" type="text" size="20" value="<?=$tagname?>" require="true" datatype="require|ajax" url="?mod=<?=$mod?>&file=<?=$file?>&action=checktag" msg="标签名称必填|"><br/>
	  </td>
    </tr>
    <tr>
      <td><b>标签说明</b><br/>例如：首页显示公告，10条</td>
      <td><input name="tag_config[introduce]" id="introduce" type="text" size="50" ></td>
    </tr>
    <tr>
      <td><b>是否分页</b></td>
      <td><input type="radio" name="tag_config[page]" value="1"> 是&nbsp;&nbsp;
          <input type="radio" name="tag_config[page]" value="0" checked="checked"> 否<br>
      </td>
    </tr>
	<tr>
      <td><b>每页显示公告数</b></td>
      <td><input name="tag_config[announcenum]" type="text" size="5" value="10"> </td>
    </tr>
	<tr> 
      <td><b>时间显示格式</b></td>
      <td>
		<select name="tag_config[datetype]">
		<option value="0">不显示时间</option>
		<option value="1">格式：2008-01-11</option>
		<option value="2">格式：01-11</option>
		<option value="3">格式：2008/01/11</option>
		<option value="4">格式：2008.01.11</option>
		<option value="5">格式：2008-01-11 21:24:19</option>
		<option value="6">格式：2008-01-11 21:24</option>
		</select>
      </td>
    </tr>
    <tr> 
      <td><b>此标签调用的模板</b></td>
      <td>
<?=form::select_template('announce', 'tag_config[template]', 'template', $template, '','tag_announce')?>&nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="location.href='?mod=phpcms&file=template&action=edit&template='+ $('#template').val()+'&module=<?=$mod?>&forward=<?=urlencode(URL)?>'"> 【注:只能修改非默认模板】
      </td>
    </tr>
	<tr> 
      <td><b>自定义变量</b>（<a href="###" onClick="javascript:var_add();">+</a>）</td>
      <td>
	  <div id="var_define">
	  <div id="var_define_head"><span style="width:150px"><b>变量描述</b></span><span style="width:100px"><b>变量名</b></span><span style="width:150px"><b>变量值</b></span></div>
	  <div id="var1"><span style="width:150px"><input name="tag_config[var_description][1]" type="text" size="18" value="链接样式"></span><span style="width:100px"><input name="tag_config[var_name][1]" type="text" size="10" value="class"> => </span><span style="width:120px"><input name="tag_config[var_value][1]" type="text" size="15" value="url"></span><span> <a href="###" onClick="var_del(1)">删除</a><span></div>
	  <div id="var2"><span style="width:150px"><input name="tag_config[var_description][2]" type="text" size="18" value="打开窗口"></span><span style="width:100px"><input name="tag_config[var_name][2]" type="text" size="10" value="target"> => </span><span style="width:120px"><input name="tag_config[var_value][2]" type="text" size="15" value="_blank"></span><span> <a href="###" onClick="var_del(2)">删除</a><span></div>
	  </div>
	  </td>
    </tr>
    <tr> 
      <td></td>
      <td>
         <input type="submit" name="dosubmit" value=" 保存 " onClick="$('#action').val('add');">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onClick="$('#action').val('preview');$('#mod').val('announce')">  
          <input type="reset" name="reset" value=" 重置 "> </td>
    </tr>  
</table>
</form>
</body>
</html>