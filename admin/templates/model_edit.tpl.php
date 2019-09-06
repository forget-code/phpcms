<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>

<body onLoad="is_ie();$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=<?=$ishtml?>&type=category&category_urlruleid=<?=$category_urlruleid?>');$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=<?=$ishtml?>&type=show&show_urlruleid=<?=$show_urlruleid?>');">
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&modelid=<?=$modelid?>" method="post" name="myform">
    <caption>修改内容模型</caption>
	<tr> 
      <th width="300"><strong>内容模型名称</strong></th>
      <td><input type="text" name="info[name]" value="<?=$name?>" size="30" require="true" datatype="limit" min="1" max="50"  msg="字符长度范围必须为1到50位"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>内容模型描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:43px;width:208px;"><?=$description?></textarea></td>
    </tr>
	<tr> 
      <th><strong>项目名称</strong></th>
      <td><input type="text" name="info[itemname]" value="<?=$itemname?>" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>项目单位</strong></th>
      <td><input type="text" name="info[itemunit]" value="<?=$itemunit?>" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>数据表名</strong></th>
      <td><?=DB_PRE?>c_<input type="text" name="info[tablename]" value="<?=$tablename?>" size="15" readonly></td>
    </tr>
     <tr>
      <th><strong>工作流方案</strong></th>
      <td><?=form::select(cache_read('workflow.php'), 'info[workflowid]', 'workflowid', $workflowid)?>  <a href="?mod=phpcms&file=workflow&forward=<?=urlencode(URL)?>">管理工作流方案</a></td>
    </tr>
	<tr> 
      <th><strong>栏目页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template_category]', 'template_category', $template_category, 'require="true" datatype="limit" msg="请选择栏目页模板"', 'category')?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>列表页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template_list]', 'template_list', $template_list,'require="true" datatype="limit" msg="请选择列表页模板"','list')?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>内容页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template_show]', 'template_show', $template_show,'require="true" datatype="limit" msg="请选择内容页模板"','show')?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>打印页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template_print]', 'template_print', $template_print,'','print')?> <font color="red">*</font></td>
    </tr>
	<tr>
      <th><strong>生成Html</strong></th>
      <td>
	  <input type='radio' name='info[ishtml]' value='1' <?php if($ishtml){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=1&type=category&category_urlruleid=<?=$category_urlruleid?>');$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=1&type=show&show_urlruleid=<?=$show_urlruleid?>');"> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='info[ishtml]' value='0' <?php if(!$ishtml){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=0&type=category&category_urlruleid=<?=$category_urlruleid?>');$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=0&type=show&show_urlruleid=<?=$show_urlruleid?>');"> 否
	  </td>
    </tr>
	<tr>
      <th><strong>栏目页URL规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=phpcms&filename=category&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td><div id="div_category_urlruleid"></div></td>
    </tr>
	<tr>
      <th><strong>内容页URL规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=phpcms&filename=show&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td><div id="div_show_urlruleid"></div></td>
    </tr>
	<tr> 
      <th><strong>启用全站搜索</strong></th>
      <td>
	  <input type='radio' name='info[enablesearch]' value='1' <?=$enablesearch ? 'checked' : ''?> /> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='info[enablesearch]' value='0' <?=$enablesearch ? '' : 'checked'?> /> 否
	  </td>
    </tr>
	<tr> 
      <th><strong>前台发布信息是否需要审核</strong></th>
      <td>
	  <input type='radio' name='info[ischeck]' value='1' <?=$ischeck ? 'checked' : ''?> /> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='info[ischeck]' value='0' <?=$ischeck ? '' : 'checked'?> /> 否
	  </td>
    </tr>
	<tr> 
      <th><strong>发布、编辑信息时更新相关信息</strong></th>
      <td>
	  <input type='radio' name='info[isrelated]' value='1' <?=$isrelated ? 'checked' : ''?> /> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='info[isrelated]' value='0' <?=$isrelated ? '' : 'checked'?> /> 否 
	  （建议在信息量很大时，频繁添加和编辑信息时禁用此项）
	  </td>
    </tr>
    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="ishtml" value="<?=$ishtml?>"> 
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
	</form>
</table>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>