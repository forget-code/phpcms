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

$().ready(function() {
	  $('form').checkForm(1);
	});
</script>
<body>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="table_info" >
  <caption>标签管理</caption>
  <tr>
    <td><strong>管理选项：</strong><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&module=<?=$module?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&module=<?=$module?>">管理标签</a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="1" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>复制标签</caption>
  <form name="myform" method="get" action="?" >
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" id="action" value="update">
   <input type="hidden" name="isadd" value="1">
   <input name="module" type="hidden" value="<?=$module?>">
    <tr> 
      <td width="30%"><strong>标签名称</strong><font color="red">*</font><br />可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td>
	  <input name="tagname" id="tagname" type="text" size="30" value="" require="true" datatype="require|ajax" url="?mod=<?=$mod?>&file=<?=$file?>&action=checktag" msg="标签名称必填|"><br />
	  </td>
    </tr>
    <tr>
      <td><strong>标签说明</strong><br/>例如：首页最新推荐产品，10篇</td>
      <td><input name="tag_config[introduce]" id="introduce" type="text" size="60" value="<?=$introduce?>"/></td>
    </tr>
    <tr> 
      <td><strong>标签调用方式</strong></td>
      <td>
	  <input type="radio" name="tag_config[mode]" value="0" onClick="$('#mode1').hide();$('#mode0').show();" <?=$mode ? '' : 'checked'?> /> 通过设置标签参数调用<br/>
	  <input type="radio" name="tag_config[mode]" value="1" onClick="$('#mode1').show();$('#mode0').hide();" <?=$mode ? 'checked' : ''?> /> 通过自定义SQL调用
	  </td>
    </tr>
	 <tr id="mode1" style="display:none"> 
	  <td><strong>自定义SQL</strong></td>
	  <td><input type="text" name="tag_config[sql]" id="sql" style="width:100%"  value="<?=$sql?>"/></td>
	</tr>
    <tr> 
      <td colspan=2 align="center"><strong>选择会员模型</strong></td>
    </tr>
    <tr> 
      <td><strong>会员模型</strong><br/>请选择会员模型</td>
      <td>
<?=form::select_member_model('modelid', 'modelid', '请选择', $modelid, 'onchange="javascript:document.myform.action.value=\'edit\';document.myform.submit()"')?>
	  </td>
    </tr>
<?php if($modelid){ ?>
<tbody id="mode0" style="display:block">
    <tr> 
      <td colspan=2 align="center"><strong>数据读取字段</strong></td>
    </tr>
    <tr> 
      <td><strong>读取字段</strong><br/>请选择要读取的数据表字段</td>
      <td>
<?=form::checkbox($fields, 'tag_config[selectfields]', 'selectfields', $selectfields, 5, '', '', 100)?>
	  </td>
    </tr>
    <tr> 
      <td colspan=2 align="center"><strong>数据调用条件</strong></td>
    </tr>
 <?php 
 foreach($forminfos as $field=>$info)
 {
 ?>
	<tr> 
      <td width="25%"><strong><?=$info['name']?></strong><br />
	  常用变量表示：<a href="###" onClick="javascript:if($('#<?=$field?>').val() == '$<?=$field?>'){$('#<?=$field?>').val('')}else{$('#<?=$field?>').val('$<?=$field?>')}" style="color:blue">$<?=$field?></a>
	  </td>
      <td><?=$info['form']?> </td>
    </tr>
<?php 
}
?>
    <tr> 
      <td><strong>排序方式</strong></td>
      <td><?=form::select($orderfields, 'tag_config[orderby]', 'orderby', $orderby, 1)?></td>
    </tr>
</tbody>

    <tr> 
      <td colspan=2 align="center"><strong>数据显示方式</strong></td>
    </tr>
    <tr> 
      <td><strong>分页显示</strong></td>
      <td><input type="radio" name="tag_config[page]" value="$page" <?=($page) ? 'checked' : ''?> />是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0"  <?=(!$page) ? 'checked' : ''?>>否</td>
    </tr>
    <tr> 
      <td><strong>调用条数</strong></td>
      <td><input type="text" name="tag_config[number]" size="10" value="<?=$number?>"> 条</td>
    </tr>
    <tr> 
      <td><strong>标签模板</strong></td>
      <td><?=form::select_template($module, 'tag_config[template]', 'template', $template, '', 'tag_')?>&nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="location.href='?mod=phpcms&file=template&action=edit&template='+ $('#template').val()+'&module=<?=$mod?>&forward=<?=urlencode(URL)?>'"></td>
    </tr>
    <tr> 
      <td><strong>自定义变量</strong>（<a href="###" onClick="javascript:var_add();">+</a>）</td>
      <td>
	  <div id="var_define">
	  <div id="var_define_head"><span style="width:150px"><strong>变量描述</strong></span><span style="width:100px"><strong>变量名</strong></span><span style="width:150px"><strong>变量值</strong></span></div>
	  <div id="var1"><span style="width:150px"><input name="tag_config[var_description][1]" type="text" size="18" value="链接样式"></span><span style="width:100px"><input name="tag_config[var_name][1]" type="text" size="10" value="class"> => </span><span style="width:120px"><input name="tag_config[var_value][1]" type="text" size="15" value="url"></span><span> <a href="###" onClick="var_del(1)">删除</a><span></div>
	  <div id="var2"><span style="width:150px"><input name="tag_config[var_description][2]" type="text" size="18" value="打开窗口"></span><span style="width:100px"><input name="tag_config[var_name][2]" type="text" size="10" value="target"> => </span><span style="width:120px"><input name="tag_config[var_value][2]" type="text" size="15" value="_blank"></span><span> <a href="###" onClick="var_del(2)">删除</a><span></div>
	  </div>
	  </td>
    </tr>
<?php } ?>
    <tr>
      <td></td>
      <td>
<input type="submit" name="dosubmit" class="button_style" value=" 保存 " onClick="$('#action').val('update');">
&nbsp;
<input type="submit" name="preview" class="button_style" value=" 预览 " onClick="$('#action').val('preview');$('#mod').val('phpcms');">
     </td>
    </tr>
  </form>
</table>
</body>
</html>
<script language="javascript">
	var mode = <?=$mode?>;
	if(mode)
	{
		$('#mode1').show();
	}
</script>