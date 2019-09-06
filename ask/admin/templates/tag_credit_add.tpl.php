<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript">
function doCheck()
{
	if($('#tagname').val()=='')
	{
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
<form name="myform" method="post" action="?">
<table cellpadding="0" cellspacing="1" class="table_form">
<tbody>
 <caption>添加标签</caption>
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" id="action" value="update">
   <input name="function" type="hidden" value="<?=$function?>">
   <input type="hidden" name="isadd" value="1">
    <tr> 
      <td width="30%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td>
	  <input name="tagname" id="tagname" type="text" size="30" value="" require="true" datatype="require|ajax" url="?mod=<?=$mod?>&file=<?=$file?>&action=checktag" msg="标签名称必填|"><br/>
	  </td>
    </tr>
    <tr> 
      <td><b>标签说明</b><br/>例如：首页最新推荐产品，10篇</td>
      <td><input name="tag_config[introduce]" id="introduce" type="text" size="60" value="<?=$introduce?>"/></td>
    </tr>
    <tr> 
      <td><b>标签调用方式</b></td>
      <td>
	  <input type="radio" name="tag_config[mode]" value="0" onClick="$('#mode1').hide();$('#mode0').show();" <?=$mode ? '' : 'checked'?> /> 通过设置标签参数调用<br/>
	  <input type="radio" name="tag_config[mode]" value="1" onClick="$('#mode1').show();$('#mode0').hide();" <?=$mode ? 'checked' : ''?> /> 通过自定义SQL调用
	  </td>
    </tr>
	 <tr id="mode1" style="display:none"> 
	  <td><b>自定义SQL</b></td>
	  <td><input type="text" name="tag_config[sql]" id="sql" size="60" value="<?=$sql?>"/></td>
	</tr>
	</tbody>
	<tbody id="mode0" style="display:auto">
	<tr> 
		<td class="tablerowhighlight" colspan=2 align="center"><b>数据调用条件</b></td>
	</tr>
	
	<tr> 
		<td><b>排行榜类型</b></td>
		<td>
		<select name="tag_config[flag]" style="width:85px">
		<option value='0'>总积分排行榜</option>
		<option value='1'>月积分排行榜</option>
		<option value='2'>周积分排行榜</option>
		</select>
		</td>
	</tr>
</tbody>
<tbody>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>数据显示方式</b></td>
    </tr>
    <tr> 
      <td><b>分页显示</b></td>
      <td><input type="radio" name="tag_config[page]" value="$page" >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td><b>调用条数</b></td>
      <td><input type="text" name="tag_config[number]" size="10" value="10"> 条</td>
    </tr>
    <tr>
      <td><b>标签模板</b></td>
      <td><?=form::select_template('ask', 'tag_config[template]', 'template', 'tag_credit', '','tag_credit')?>&nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="location.href='?mod=phpcms&file=template&action=edit&template='+ $('#template').val()+'&module=<?=$mod?>&forward=<?=urlencode(URL)?>'"></td>
    </tr>
    <tr> 
      <td><b>自定义变量</b>（<a href="###" onclick="javascript:var_add();">+</a>）</td>
      <td>
	  <div id="var_define">
	  <div id="var_define_head"><span style="width:150px"><b>变量描述</b></span><span style="width:100px"><b>变量名</b></span><span style="width:150px"><b>变量值</b></span></div>
	  <div id="var1"><span style="width:150px"><input name="tag_config[var_description][1]" type="text" size="18" value="链接样式"></span><span style="width:100px"><input name="tag_config[var_name][1]" type="text" size="10" value="class"> => </span><span style="width:120px"><input name="tag_config[var_value][1]" type="text" size="15" value="url"></span><span> <a href="###" onclick="var_del(1)">删除</a><span></div>
	  <div id="var2"><span style="width:150px"><input name="tag_config[var_description][2]" type="text" size="18" value="打开窗口"></span><span style="width:100px"><input name="tag_config[var_name][2]" type="text" size="10" value="target"> => </span><span style="width:120px"><input name="tag_config[var_value][2]" type="text" size="15" value="_blank"></span><span> <a href="###" onclick="var_del(2)">删除</a><span></div>
	  </div>
	  </td>
    </tr>
<tr>
      <td></td>
      <td>
<input type="submit" name="dosubmit" value=" 保存 " onClick="$('#action').val('update');">
&nbsp;
<input type="submit" name="preview" value=" 预览 " onClick="$('#action').val('preview');">
     </td>
    </tr>
</tbody>
</table>
  </form>
</body>
</html>