<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script type="text/javascript">
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
<?=$menu?>
  <table class="table_form" cellspacing="1" cellpadding="0">
	<caption> 管理标签 </caption>
  <tr>
    <td><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>">管理标签</a></td>
  </tr>
</table>

<form name="myform" method="get" action="?">
<table class="table_form" cellspacing="1" cellpadding="0">
   <caption> 修改标签</caption>
   <input name="mod" id="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" id="action" type="hidden" value="<?=$action?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="forward" type="hidden" value="<?=$forward?>">
   <input name="tagname" type="hidden" value="<?=$tagname?>">
   <tr>
      <td><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td width="75%">
	  <input type="text" size="20" value="<?=$tagname?>" disabled title="标签名称不可再修改" />
	  </td>
    </tr>
    <tr>
      <td><b>标签说明</b><br/>例如：首页推荐链接，10条</td>
      <td><input name="tag_config[introduce]" id="introduce" type="text" size="50" ></td>
    </tr>
	<tr>
      <td><b>每页显示链接数</b></td>
      <td><input name="tag_config[guestbooknum]" type="text" size="5" value="10"> </td>
    </tr>
    <tr>
      <td><b>是否分页</b></td>
      <td><input type="radio" name="tag_config[page]" value="1"> 是&nbsp;&nbsp;
          <input type="radio" name="tag_config[page]" value="0" checked="checked"> 否<br>
      </td>
    </tr>

    <tr>
      <td><b>此标签调用的模板</b></td>
      <td>
<?=form::select_template('guestbook', 'tag_config[template]', 'template', $template, '','tag_guestbook')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onClick="window.location='?mod=phpcms&file=template&action=edit&template='+myform.template.value+'&module=guestbook&forward=<?=urlencode(URL)?>'"> 【注:只能修改非默认模板】
      </td>
    </tr>
	<tr>
      <td><b>自定义变量</b>（<a href="###" onClick="javascript:var_add();">+</a>）</td>
      <td>
	  <div id="var_define">
	  <div id="var_define_head"><span style="width:150px"><b>变量描述</b></span><span style="width:100px"><b>变量名</b></span><span style="width:150px"><b>变量值</b></span></div>
	  <?php foreach($var_name as $k=>$v)
	  {
	  ?>
	  <div id="var<?=$k?>"><span style="width:150px"><input name="tag_config[var_description][<?=$k?>]" type="text" size="18" value="<?=$var_description[$k]?>"></span><span style="width:100px"><input name="tag_config[var_name][<?=$k?>]" type="text" size="10" value="<?=$var_name[$k]?>"> => </span><span style="width:120px"><input name="tag_config[var_value][<?=$k?>]" type="text" size="15" value="<?=$var_value[$k]?>"></span><span> <a href="###" onClick="var_del(1)">删除</a><span></div>
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
         <input type="submit" name="dopreview" value=" 预览 " onClick="$('#action').val('preview');$('#mod').val('guestbook');">  &nbsp;
         <input type="reset" name="reset" value=" 重置 "> </td>
    </tr>
</table>
</form>
</body>
</html>