<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body onLoad="is_ie();$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=<?=$PHPCMS['ishtml']?>&type=category&category_urlruleid=0');$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=<?=$PHPCMS['ishtml']?>&type=show&show_urlruleid=0');">
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&modelid=<?=$modelid?>" method="post" name="myform" enctype="multipart/form-data">
  <caption>导入模型</caption>
	<tr> 
      <th width="30%"><strong>内容模型名称</strong></th>
      <td><?=form::text('info[name]', 'name', '', 'text', 30)?><font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>内容模型描述</strong></th>
      <td><?=form::textarea('info[description]', 'description', '', 4, 40)?></td>
    </tr>
	<tr> 
      <th><strong>项目名称</strong></th>
      <td><input type="text" name="info[itemname]" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>项目单位</strong></th>
      <td><input type="text" name="info[itemunit]" size="30"> <font color="red">*</font></td>
    </tr>
	<tr>
	  <th><strong>表名</strong></th>
	  <td><?=DB_PRE?>c_<?=form::text('info[tablename]', 'tablename', '', 'text', 30)?><font color="red">*</font></td>
	</tr>
	<tr>
      <th><strong>工作流方案</strong></th>
      <td><?=form::select(cache_read('workflow.php'), 'info[workflowid]', 'workflowid', $workflowid)?></td>
    </tr>
	<tr> 
      <th><strong>栏目页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template_category]', 'template_category','category','','category')?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>列表页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template_list]', 'template_list','list','','list')?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>内容页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template_show]', 'template_show','show','','show')?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>打印页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template_print]', 'template_print','print','','print')?> <font color="red">*</font></td>
    </tr>
	<tr>
      <th width='30%'><strong>生成Html</strong></th>
      <td>
	  <input type='radio' name='info[ishtml]' value='1' <?php if($PHPCMS['ishtml']){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=1&type=category&category_urlruleid=<?=$category_urlruleid?>');$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=1&type=show&show_urlruleid=<?=$show_urlruleid?>');"> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='info[ishtml]' value='0' <?php if(!$PHPCMS['ishtml']){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=0&type=category&category_urlruleid=<?=$category_urlruleid?>');$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=0&type=show&show_urlruleid=<?=$show_urlruleid?>');"> 否
	  </td>
    </tr>
	<tr>
      <th><strong>栏目页URL规则</strong></th>
      <td><div id="div_category_urlruleid"></div></td>
    </tr>
	<tr>
      <th><strong>内容页URL规则</strong></th>
      <td><div id="div_show_urlruleid"></div></td>
    </tr>
	<tr>
	   <th><strong>上传模型：</strong></th>
	   <td><?=form::text('modelfile', 'modelfile', '', 'file', 30)?></td>
	</tr>
    <tr>
	  <td></td>
      <td>
      <div class="button_box">
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
      </div>
	  </td>
    </tr>
	</form>
</table>
</body>
</html>