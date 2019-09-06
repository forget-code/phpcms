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
<form name="myform" method="post" action="?" target="tag_post">
<input name="mod" type="hidden" value="<?=$mod?>">
<input name="file" type="hidden" value="<?=$file?>">
<input name="action" id="action" type="hidden" value="update">
<input name="module" type="hidden" value="<?=$module?>">
<input name="type" type="hidden" value="<?=$type?>">
<input name="ajax" type="hidden" value="<?=$ajax?>">
<input name="forward" type="hidden" value="<?=$forward?>">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>修改<?=$types[$type]?>标签</caption>
    <tr> 
      <th width="20%"><font color="red">*</font> <strong>标签名称</strong></th>
      <td>
	  <input name="tagname" id="tagname" type="text" size="30" value="<?=$tagname?>" readonly><br/>
	  </td>
    </tr>
    <tr> 
      <th><strong>标签说明</strong></th>
      <td><input name="tag_config[introduce]" id="introduce" type="text" size="60" value="<?=$introduce?>"/></td>
    </tr>
    <tr> 
      <th><strong>调用方式</strong></th>
      <td>
	  <input type="radio" name="tag_config[mode]" value="0" onClick="$('#mode1').hide();$('#mode0').show();" <?=$mode ? '' : 'checked'?> /> 通过设置标签参数调用<br/>
	  <input type="radio" name="tag_config[mode]" value="1" onClick="$('#mode1').show();$('#mode0').hide();" <?=$mode ? 'checked' : ''?> /> 通过自定义SQL调用
	  </td>
    </tr>
	 <tr id="mode1" style="display:<?=$mode ? '' : 'none'?>"> 
	  <th><strong>自定义SQL</strong></th>
	  <td><input type="text" name="tag_config[sql]" id="sql" size="60" value="<?=$sql?>"/></td>
	</tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><strong>选择内容模型</strong></td>
    </tr>
    <tr> 
      <th><strong>选择内容模型</strong></th>
      <td>
<?=form::select_model('modelid', 'modelid', '不限', $modelid, 'onchange="javascript:document.myform.action.value=\'edit\';document.myform.submit()"')?>
	  </td>
    </tr>
<tbody id="mode0">
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><strong>数据读取字段</strong></td>
    </tr>
    <tr> 
      <th><strong>读取字段</strong></th>
      <td>
<?=form::checkbox($fields, 'tag_config[selectfields]', 'selectfields', $selectfields, 5, '', '', 100)?>
	  </td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><strong>数据调用条件</strong></td>
    </tr>
 <?php 
 foreach($forminfos as $field=>$info)
 {
 ?>
	<tr> 
      <th><strong><?=$info['name']?></strong><br />
	  常用变量：<a href="###" onClick="javascript:if($('#<?=$field?>').val() == '$<?=$field?>'){$('#<?=$field?>').val('')}else{$('#<?=$field?>').val('$<?=$field?>')}" style="color:blue">$<?=$field?></a>
	  </th>
      <td><?=$info['form']?> </td>
    </tr>
<?php 
}
?>
    <tr> 
      <th><strong>排序方式</strong></th>
      <td><?=form::select($orderfields, 'tag_config[orderby]', 'orderby', $orderby, 1)?></td>
    </tr>
</tbody>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><strong>数据显示方式</strong></td>
    </tr>
    <tr> 
      <th><strong>分页显示</strong></th>
      <td><input type="radio" name="tag_config[page]" value="$page" <?=($page=='$page' ? 'checked' : '')?> />是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0"  <?=($page=='$page' ? '' : 'checked')?>>否</td>
    </tr>
    <tr> 
      <th><strong>调用条数</strong></th>
      <td><input type="text" name="tag_config[number]" size="10" value="<?=$number?>"> 条</td>
    </tr>
    <tr> 
      <th><strong>标签模板</strong></th>
      <td><?=form::select_template($module, 'tag_config[template]', 'template', $template, 'style="width:250px"', 'tag_content')?>&nbsp;<input type="button" value="修改模板" title="修改模板" onClick="$('#template_edit').show();$('#template_data').load('?mod=phpcms&file=template&action=data_ajax&module=<?=$module?>&template='+$('#template').val())"></td>
    </tr>
    <tr id="template_edit" style="display:none"> 
      <th><strong>模板代码</strong></th>
      <td><textarea name="template_data" id="template_data" style="width:100%;height:120px;"></textarea></td>
    </tr>
    <tr> 
      <th><strong>自定义变量</strong>（<a href="###" onClick="javascript:var_add();" style="color:red">+</a>）</th>
      <td>
	  <div id="var_define">
	  <div id="var_define_head"><span style="width:150px"><strong>变量描述</strong></span><span style="width:100px"><strong>变量名</strong></span><span style="width:150px"><strong>变量值</strong></span></div>
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
<iframe name="tag_post" id="tag_post" frameborder="0" src="" style="height:0;width:0;"></iframe>
</body>
</html>