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
var i = <?=array_search(end($var_name),$var_name)?> + 1;
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
</script>
<body>
<form name="myform" method="post" action="?" >
<input name="mod" type="hidden" value="<?=$mod?>">
<input name="file" type="hidden" value="<?=$file?>">
<input name="action" id="action" type="hidden" value="update">
<input name="module" type="hidden" value="<?=$module?>">
<input name="type" type="hidden" value="<?=$type?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>复制标签</caption>
    <tr> 
      <th width="30%"><strong>标签名称</strong><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</th>
      <td>
	  <input name="tagname" id="tagname" type="text" size="30" ><br/>
	  </td>
    </tr>
    <tr> 
      <th><strong>标签说明</strong><br/>例如：首页最新推荐产品，10篇</th>
      <td><input name="tag_config[introduce]" id="introduce" type="text" size="60" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>数据调用条件</b></td>
    </tr>
	<tr> 
      <th><strong>所属类别ID</strong><br />
	  常用变量表示：<a href="###" onClick="javascript:$('#typeid').val('$typeid')" style="color:blue">$typeid</a>
	  </th>
      <td><input type="text" name="tag_config[typeid]" id="typeid" size="15" value="<?=$typeid?>"> <?=form::select_type('special', 'set_typeid', 'set_typeid', '请选择', $typeid, 'onchange="$(\'#typeid\').val(this.value)"')?></td>
    </tr>
	<tr> 
       <th><strong>是否推荐</strong></th>
      <td><input type="radio" name="tag_config[elite]" id="elite" value="1" <?=$elite ? 'checked' : ''?> /> 是 <input type="radio" name="tag_config[elite]" id="elite" value="0"  <?=$elite ? '' : 'checked'?> /> 否</td>
    </tr> 
    <tr> 
      <th><strong>排序方式</strong></th>
      <td>
		<select name="tag_config[orderby]" id="orderby">
		    <option value="specialid ASC" <?=$orderby=='specialid ASC' ? 'selected' : ''?>>ID 升序</option>
			<option value="specialid DESC" <?=$orderby=='specialid DESC' ? 'selected' : ''?>>ID 降序</option>
			<option value="listorder ASC,specialid DESC" <?=$orderby=='listorder ASC,specialid DESC' ? 'selected' : ''?>>排序 升序</option>
			<option value="listorder DESC,specialid DESC" <?=$orderby=='listorder DESC,specialid DESC' ? 'selected' : ''?>>排序 降序</option>
		</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>数据显示方式</b></td>
    </tr>
    <tr> 
      <th><strong>分页显示</strong></th>
      <td  ><input type="radio" name="tag_config[page]" value="$page" <?=$page ? 'checked' : ''?> />是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0"  <?=$page ? '' : 'checked'?> />否</td>
    </tr>
    <tr> 
      <th><strong>调用条数</strong></th>
      <td><input type="text" name="tag_config[number]" size="10" value="<?=$number?>"> 条</td>
    </tr>
    <tr> 
      <th><strong>标签模板</strong></th>
      <td><?=form::select_template($module, 'tag_config[template]', 'template', $template, '', 'tag_special')?>&nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="location.href='?mod=phpcms&file=template&action=edit&template='+ $('#template').val()+'&module=<?=$mod?>&forward=<?=urlencode(URL)?>'"></td>
    </tr>
    <tr> 
      <th><strong>自定义变量</strong>（<a href="###" onClick="javascript:var_add();">+</a>）</th>
      <td>
	  <div id="var_define">
	  <div id="var_define_head"><span style="width:150px"><b>变量描述</b></span><span style="width:100px"><b>变量名</b></span><span style="width:150px"><b>变量值</b></span></div>
	  <?php 
	  foreach($var_name as $k=>$v)
	  {
	  ?>
	  <div id="var<?=$k?>"><span style="width:150px"><input name="tag_config[var_description][<?=$k?>]" type="text" size="18" value="<?=$var_description[$k]?>"></span><span style="width:100px"><input name="tag_config[var_name][<?=$k?>]" type="text" size="10" value="<?=$v?>"> => </span><span style="width:120px"><input name="tag_config[var_value][<?=$k?>]" type="text" size="15" value="<?=$var_value[$k]?>"></span><span> <a href="###" onClick="var_del(<?=$k?>)">删除</a><span></div>
	  <?php 
	  }
	  ?>
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
</table>
</form>
</body>
</html>