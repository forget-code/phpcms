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

<table cellpadding="0" cellspacing="1" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?" >
<table cellpadding="0" cellspacing="1" class="table_form">
<tbody>
  <caption>添加标签</caption>
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" id="action" type="hidden" value="update">
   <input name="module" id="module" type="hidden" value="ask">
   <input name="function" id="function" type="hidden" value="ask">
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
		<td width="30%"><b>栏目</b><br />
		常用变量表示：<a href="###" onClick="javascript:$('#catid').val('$catid')" style="color:blue">$catid</a>
		</td>
		<td>
		<input type="text" name="tag_config[catid]" id="catid" value="0" size="10">
		<?php echo form::select_category('ask', 0, 'category[parentid]', 'parentid', '不限',0, 'onchange="myform.catid.value=this.value;"');?>
		</td>
	</tr>
	<tr> 
		<td width="25%"><b>发布人</b><br />
		常用变量表示：<a href="###" onClick="javascript:$('#userid').val('$userid')" style="color:blue">$userid</a>
		</td>
	<td><input type="text" name="tag_config[userid]" id="userid" value="" size="10" class="" />  </td>
	</tr>
	<tr> 
		<td><b>问题类别</b></td>
		<td>
		<input type="" name="tag_config[flag]" id="flag" value="-1" size="5"/>
		<select name="select_flag" onchange="if($('#flag').val()){$('#flag').val(this.value);}else{$('#flag').val(this.value);}" style="width:85px">
		<option value='-1'>全部问题</option>
		<option value='1'>投票中问题</option>
		<option value='2'>高分问题</option>
		<option value='3'>推荐问题</option>
		</select>
		</td>
	</tr>
	<tr> 
	<td><b>状态</b></td>
	<td>
	<input type="radio" name="tag_config[status]" value="-1" checked>全部通过问题 
	<input type="radio" name="tag_config[status]" value="3">待解决 
	<input type="radio" name="tag_config[status]" value="1">待审核 
	<input type="radio" name="tag_config[status]" value="5">已解决 
	<input type="radio" name="tag_config[status]" value="6">已关闭
	</td>
	</tr>
	<tr> 
	<td><b>排序方式</b></td>
	<td>
	<?=form::select($orderfields, 'tag_config[orderby]', 'orderby','', 1)?>
	</td>
	</tr>
	</tbody>
<tbody>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>数据显示方式</b></td>
    </tr>
    <tr> 
      <td width="30%"><b>分页显示</b></td>
      <td><input type="radio" name="tag_config[page]" value="$page" >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td><b>调用条数</b></td>
      <td><input type="text" name="tag_config[number]" size="10" value="10"> 条</td>
    </tr>
    <tr> 
      <td><b>标签模板</b></td>
      <td><?=form::select_template('ask', 'tag_config[template]', 'template', 'tag_ask', '','tag_ask')?>&nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="location.href='?mod=phpcms&file=template&action=edit&template='+ $('#template').val()+'&module=<?=$mod?>&forward=<?=urlencode(URL)?>'"></td>
    </tr>
    <tr> 
      <td><b>自定义变量</b>（<a href="###" onclick="javascript:var_add();">+</a>）</td>
      <td>
	  <div id="var_define">
	  <div id="var_define_head"><span style="width:150px"><b>变量描述</b></span><span style="width:100px"><b>变量名</b></span><span style="width:150px"><b>变量值</b></span></div>
	  <div id="var1"><span style="width:150px"><input name="tag_config[var_description][1]" type="text" size="18" value="链接样式"></span><span style="width:100px"><input name="tag_config[var_name][1]" type="text" size="10" value="class"> => </span><span style="width:120px"><input name="tag_config[var_value][1]" type="text" size="15" value="url"></span><span> <a href="###" onclick="var_del(1)">删除</a><span></div>
	  <div id="var2"><span style="width:150px"><input name="tag_config[var_description][2]" type="text" size="18" value="打开窗口"></span><span style="width:100px"><input name="tag_config[var_name][2]" type="text" size="10" value="target"> => </span><span style="width:120px"><input name="tag_config[var_value][2]" type="text" size="15" value="_blank"></span><span> <a href="###" onclick="var_del(2)">删除</a><span></div>
	  <div id="var3"><span style="width:150px"><input name="tag_config[var_description][3]" type="text" size="18" value="是否显示栏目名称"></span><span style="width:100px"><input name="tag_config[var_name][3]" type="text" size="10" value="showcatname"> => </span><span style="width:120px"><input name="tag_config[var_value][3]" type="text" size="15" value="1"></span><span> <a href="###" onclick="var_del(3)">删除</a><span></div>
	  <div id="var4"><span style="width:150px"><input name="tag_config[var_description][4]" type="text" size="18" value="标题字符数"></span><span style="width:100px"><input name="tag_config[var_name][4]" type="text" size="10" value="titlelen"> => </span><span style="width:120px"><input name="tag_config[var_value][4]" type="text" size="15" value="46"></span><span> <a href="###" onclick="var_del(4)">删除</a><span></div>
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