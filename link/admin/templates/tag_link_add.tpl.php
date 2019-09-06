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
</script>
<?=$menu?>
<table class="table_form" cellspacing="1" cellpadding="0">
<caption>标签管理</caption>
  <tr>
    <td><strong>管理选项：</strong>
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>">管理标签</a></td>
  </tr>
</table>

<form name="myform" method="get" action="?" onSubmit="return doCheck();">
<table class="table_form" cellspacing="1" cellpadding="0">
  <caption>添加标签</caption>
   <input name="mod" id="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" id="action" type="hidden" value="<?=$action?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="forward" type="hidden" value="<?=$forward?>">
    <tr> 
      <th><strong>标签名称</strong><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</th>
      <td width="75%">
	  <input name="tagname" id="tagname" type="text" size="20" value="">
	  </td>
    </tr>
    <tr> 
      <th><strong>标签说明例</strong><br/>如：首页推荐链接，10条</th>
      <td><input name="tag_config[introduce]" id="introduce" type="text" size="50" ></td>
    </tr>
    <tr> 
      <th><strong>链接类型</strong></th>
      <td><input type="radio" name="tag_config[linktype]" value="0" checked="checked"> 文字链接&nbsp;&nbsp;
                            <input type="radio" name="tag_config[linktype]" value="1" > Logo链接<br>
      </td>
    </tr>
    <tr> 
      <th><strong>所属分类</strong></th>
      <td><input name="tag_config[typeid]" type="text" size="15" id="typeid" value="0" >&nbsp;<?=form::select_type('link', 'typeids','',"请选择...",'','onchange="$(\'#typeid\').val(this.value);"')?>【为0则调用所有】</td>
    </tr>
    <tr> 
      <th><strong>是否推荐</strong></th>
      <td><input type="radio" name="tag_config[elite]" value="0" checked="checked"> 不推荐&nbsp;&nbsp;
                            <input type="radio" name="tag_config[elite]" value="1" > 推荐<br></td>
    </tr>
    <tr> 
      <th><strong>每页显示链接数</strong></th>
      <td ><input name="tag_config[linknum]" type="text" size="5" value="20"> </td>
    </tr>
    <tr> 
      <th><strong>此标签调用的模板</strong></th>
      <td >
<?=form::select_template('link', 'tag_config[template]', 'template', $template, '','tag_link')?>&nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="location.href='?mod=phpcms&file=template&action=edit&template='+ $('#template').val()+'&module=<?=$mod?>&forward=<?=urlencode(URL)?>'"> 【注:只能修改非默认模板】
      </td>
    </tr>
	    <tr> 
      <th><strong>自定义变量</strong>（<a href="###" onClick="javascript:var_add();">+</a>）</th>
      <td>
	  <div id="var_define">
	  <div id="var_define_head"><span style="width:150px"><strong>变量描述</strong></span><span style="width:100px"><strong>变量名</strong></span><span style="width:150px"><strong>变量值</strong></span></div>
	  <div id="var1"><span style="width:150px"><input name="tag_config[var_description][1]" type="text" size="18" value="每行显示链接列数"></span><span style="width:100px"><input name="tag_config[var_name][1]" type="text" size="10" value="rownum"> => </span><span style="width:120px"><input name="tag_config[var_value][1]" type="text" size="15" value="10"></span><span> <a href="###" onClick="var_del(1)">删除</a><span></div>
	  <div id="var2"><span style="width:150px"><input name="tag_config[var_description][2]" type="text" size="18" value="是否显示点击次数"></span><span style="width:100px"><input name="tag_config[var_name][2]" type="text" size="10" value="showhits"> => </span><span style="width:120px"><input name="tag_config[var_value][2]" type="text" size="15" value="是"></span><span> <a href="###" onClick="var_del(2)">删除</a><span></div>
	  </div>
	  </td>
    </tr>
    <tr> 
      <td></td>
      <td>
         <input type="submit" name="dosubmit" value=" 保存 " onClick="$('#action').val('add');">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onClick="$('#action').val('preview');$('#mod').val('link');">  
          <input type="reset" name="reset" value=" 重置 "> </td>
    </tr> 
</table>
 </form>
</body>
</html>