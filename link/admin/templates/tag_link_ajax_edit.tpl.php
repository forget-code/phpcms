<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script type="text/javascript">
var i = <?=count($var_name)?> + 1;
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

<form name="myform" method="get" action="?" target="tag_post">
<table class="table_form" cellspacing="1" cellpadding="0">
   <caption> 修改标签</caption>  
   <input name="mod" id="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" id="action" type="hidden" value="<?=$action?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="forward" type="hidden" value="<?=$forward?>"> 
   <input name="ajax" type="hidden" value="<?=$ajax?>">
   <input name="tagname" type="hidden" value="<?=$tagname?>">
   <tr> 
      <th><strong>标签名称</strong><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</th>
      <td width="75%"><input type="text" size="20" value="<?=$tagname?>" disabled title="标签名称不可再修改" /></td>
    </tr>
    <tr> 
      <th><strong>标签说明</strong><br/>例如：首页推荐链接，10条</th>
      <td ><input name="tag_config[introduce]" id="introduce" type="text" size="50" value="<?=$tag_config['introduce']?>" /></td>
    </tr>   
    <tr> 
      <th><strong>链接类型</strong></th>
      <td><input type="radio" name="tag_config[linktype]" value="0" <?php if(!$tag_config['linktype']) echo 'checked="checked"';?> /> 文字链接&nbsp;&nbsp;
                            <input type="radio" name="tag_config[linktype]" value="1" <?php if($tag_config['linktype']) echo 'checked="checked"';?>> Logo链接
      </td>
    </tr>
    <tr> 
      <th><strong>所属分类</strong></th>
      <td><input name="tag_config[typeid]" type="text" size="15" id="typeid" value="0" >&nbsp;<?=form::select_type('link', 'typeids','',"请选择...","$typeid",'onchange="$(\'#typeid\').val(this.value);"')?>【为0则调用所有】</td>
    </tr>
    <tr> 
	    <tr> 
      <th><strong>是否推荐</strong></th>
      <td><input type="radio" name="tag_config[elite]" value="0" <?php if(!$tag_config['elite']) echo 'checked="checked"';?> > 不推荐&nbsp;&nbsp;
                            <input type="radio" name="tag_config[elite]" value="1" <?php if($tag_config['elite']) echo 'checked="checked"';?>> 推荐<br></td>
    </tr>
      <th><strong>每页显示链接数</strong></th>
      <td><input name="tag_config[linknum]" type="text" size="5" value="<?=$tag_config['linknum']?>" > </td>
    </tr>
    <tr> 
      <th><strong>此标签调用的模板</strong></th>
      <td>
<?=form::select_template('link', 'tag_config[template]', 'template', $template, '','tag_link')?>&nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="$('#template_edit').show();$('#template_data').load('?mod=phpcms&file=template&action=data_ajax&module=<?=$module?>&template='+$('#template').val())"> 【注:只能修改非默认模板】
      </td>
    </tr>
	<tr id="template_edit" style="display:none"> 
      <th><strong>模板代码</strong></th>
      <td><textarea name="template_data" id="template_data" style="width:100%;height:120px;"></textarea></td>
    </tr>
    <tr> 
      <th><strong>自定义变量</strong>（<a href="###" onClick="javascript:var_add();">+</a>）</th>
      <td>
	  <div id="var_define">
	  <div id="var_define_head"><span style="width:150px"><strong>变量描述</strong></span><span style="width:100px"><strong>变量名</strong></span><span style="width:150px"><strong>变量值</strong></span></div>
	  <?php foreach($var_name as $k=>$v)
	  {
	  ?>
	  <div id="var<?=$k?>"><span style="width:150px"><input name="tag_config[var_description][<?=$k?>]" type="text" size="18" value="<?=$var_description[$k]?>"></span><span style="width:100px"><input name="tag_config[var_name][<?=$k?>]" type="text" size="10" value="<?=$var_name[$k]?>"> => </span><span style="width:120px"><input name="tag_config[var_value][<?=$k?>]" type="text" size="15" value="<?=$var_value[$k]?>"></span><span> <a href="###" onClick="var_del(<?=$k?>)">删除</a><span></div>
      <?php 
	  } 
	  ?>
	  </div>
	  </td>
    </tr>
    <tr> 
      <td></td>
      <td>
         <input type="submit" name="dosubmit" value=" 保存 " onClick="$('#action').val('edit');">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onClick="$('#action').val('preview');$('#mod').val('link');">  &nbsp; 
    </tr>  
</table>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$('#typeid').val($('#typeids').val()); 
//-->
</SCRIPT>
</body>
<iframe name="tag_post" id="tag_post" frameborder="0" src="" style="height:0;width:0;"></iframe>
</html>