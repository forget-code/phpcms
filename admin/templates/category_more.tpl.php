<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body <?php if($type==1){ ?>onload="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=<?=$PHPCMS['ishtml']?>&category_urlruleid=0')"<?php } ?> >
<?php if(!isset($type)){ ?>
<form name="myform" method="post" action="?">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>">
   <input name="forward" type="hidden" value="<?=$forward?>">
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>批量添加栏目</caption>
  <tr>
    <th><font color="red">*</font>  <strong>上级栏目</strong></th>
    <td><?=form::select_category('phpcms', 0, 'parentid', 'parentid', '无（作为一级栏目）', $parentid, '', 1)?></td>
  </tr>
  <tr>
    <th><strong>栏目类型</strong></th>
    <td><input type="radio" name="type" value="0" checked >内部栏目（可绑定内容模型，并支持在栏目下建立子栏目或发布信息）<br/></td>
  </tr>
  <tr>
    <th><strong>绑定模型</strong></td>
    <td><?=form::select_model('modelid', 'modelid', '', $modelid, '')?></td>
  </tr>
  <tr>
    <th><strong>批量生成栏目数</strong></td>
    <td><input type="text" name="num" size="5" value="5"/></td>
  </tr>
  <tr>
	<th></th>
	<td><input type="submit" name="next" value=" 下一步 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
<?php }elseif($type == 0){ ?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<input type="hidden" name="category[type]" value="<?=$type?>">
<input name="forward" type="hidden" value="<?=$forward?>">
<table cellpadding="2" cellspacing="1" class="table_form">
<caption>基本信息</caption>
<tr>
  <th width='30%'><strong>上级栏目</strong></th>
  <td><input type="hidden" name="category[parentid]" value="<?=$parentid?>"> <?=$parentid ? $CATEGORY[$parentid]['catname'] : '无'?></td>
</tr>
<tr>
  <th><strong>绑定模型</strong></th>
  <td><input type="hidden" name="category[modelid]" value="<?=$modelid?>"> <?=$MODEL[$modelid]['name']?></td>
</tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>批量添加栏目</caption>
<tr>
    <th width="15%">栏目名称</th>
    <th width="15%">栏目目录</th>
    <th>工作流方案</th>
    <th width="10%">在导航栏显示</th>
    <th title="META Title 针对搜索引擎设置的标题">栏目标题</th>
    <th width="15%">栏目关键词</th>
    <th width="15%">栏目描述</th>
</tr>
<?php
    $num = intval($num) ? intval($num) :10;
    for($i=0; $i<$num; $i++)
    {
?>
<tr>
    <td class="align_c"><input name='category[catname][<?=$i?>]' type='text' id='catname' size='15' maxlength='20' require="false" datatype="limit|ajax" min="1" max="50" url="?mod=phpcms&file=category&action=checkname&parentid=<?=$parentid?>" msg="字符长度范围必须为1到50位|"  mode="2"></td>
    <td class="align_c"><input name='category[catdir][<?=$i?>]' type='text' id='catdir' size='15' maxlength='50' require="false" datatype="limit|ajax" min="1" max="50" url="?mod=phpcms&file=category&action=checkdir&parentid=<?=$parentid?>" msg="字符长度范围必须为1到50位|"  mode="2"></td>
    <td><?=form::select(cache_read('workflow.php'), "setting[workflowid][$i]", 'workflowid', $MODEL[$modelid]['workflowid'])?></td>
	<td class="align_c"><select size="1" id="workflowid" name="category[ismenu][<?=$i?>]">
    <option value="1" selected>是</option>
    <option value="0">否</option>
    </select></td>
    <td class="align_c"><input name='setting[meta_title][<?=$i?>]' type='text' id='meta_title' size='20' maxlength='20' title="META Title 针对搜索引擎设置的标题"></td>
    <td><textarea name='setting[meta_keywords][<?=$i?>]' id='meta_keywords' style="width:100%;height:50px"></textarea></td>
    <td><textarea name='setting[meta_description][<?=$i?>]' id='meta_description' style="width:100%;height:50px"></textarea></td>
</tr>
<?php }?>
</table>
<div class="tag_menu" style="width:99%;margin-top:10px;">
<ul>
  <li><a href="#" id='TabTitle0' onclick='ShowTabs(0)'>权限设置</a></li>
  <li><a href="#" id='TabTitle3' onclick='ShowTabs(3)'>收费设置</a></li>
  <li><a href="#" id='TabTitle4' onclick='ShowTabs(4)'>模板设置</a></li>
</ul>
</div>
<table cellpadding="0" cellspacing="1" class="table_form">
<tbody id='Tabs0' >
    <tr>
      <td valign="top">
		  <table cellpadding="0" cellspacing="1" class="table_list">
		      <caption>会员组权限</caption>
			  <tr>
				  <th>会员组名</th><th>浏览</th><th>查看</th><th>录入</th>
			  </tr>
		  <?php foreach($GROUP as $groupid=>$name)
		  {
          ?>
			  <tr>
				  <td><?=$name?></td>
				  <td><input type="checkbox" name="priv_groupid[]" value="browse,<?=$groupid?>"></td>
				  <td><input type="checkbox" name="priv_groupid[]" value="view,<?=$groupid?>"></td>
				  <td><input type="checkbox" name="priv_groupid[]" value="input,<?=$groupid?>"></td>
			  </tr>
		  <?php
		  }
		  ?>
		  </table>
	  </td>
      <td valign="top">
		  <table cellpadding="0" cellspacing="1" class="table_list">
		  <caption>角色权限</caption>
			  <tr>
				  <th>角色名称</th><th>查看</th><th>录入</th><th>编辑</th><th>审核</th><th>排序</th><th>删除</th><th>信息管理</th>
			  </tr>
		  <?php foreach($ROLE as $roleid=>$name)
		  {
          ?>
			  <tr>
				  <td><?=$name?></td>
				  <td><input type="checkbox" name="priv_roleid[]" value="view,<?=$roleid?>"></td>
				  <td><input type="checkbox" name="priv_roleid[]" value="add,<?=$roleid?>"></td>
				  <td><input type="checkbox" name="priv_roleid[]" value="edit,<?=$roleid?>"></td>
				  <td><input type="checkbox" name="priv_roleid[]" value="check,<?=$roleid?>"></td>
				  <td><input type="checkbox" name="priv_roleid[]" value="listorder,<?=$roleid?>"></td>
				  <td><input type="checkbox" name="priv_roleid[]" value="cancel,<?=$roleid?>"></td>
				  <td><input type="checkbox" name="priv_roleid[]" value="manage,<?=$roleid?>"></td>
			  </tr>
		  <?php
		  }
		  ?>
		  </table>
	  </td>
    </tr>
  </tbody>
  <tbody id='Tabs3' style='display:none'>
    <tr>
      <th width='30%'><strong>投稿奖励</strong><br>会员在此栏目发表信息时可以得到的点数</th>
      <td><input name='setting[presentpoint]' type='text' value='1' size='4' maxlength='4' style='text-align:center'> 点</td>
    </tr>
    <tr>
      <th><strong>默认收费点数</strong><br>会员在此栏目下查看信息时，该信息默认的收费点数</th>
      <td><input name='setting[defaultchargepoint]' type='text' value='0' size='4' maxlength='4' style='text-align:center'> 点</td>
    </tr>
    <tr>
      <th><strong>重复收费设置</strong></th>
      <td>
	    <input name='setting[repeatchargedays]' type='text' value='1' size='4' maxlength='4' style='text-align:center'> 天内不重复收费&nbsp;&nbsp;
        <font color="red">0 表示每阅读一次就重复收费一次（建议不要使用）</font></td>
    </tr>
  </tbody>
   <tbody id='Tabs4' style='display:none'>
    <tr>
      <th width='30%'><strong>栏目页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template_category]', 'template_category', $MODEL[$modelid]['template_category'], '','category')?></td>
    </tr>
    <tr>
      <th><strong>列表页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template_list]', 'template_list', $MODEL[$modelid]['template_list'], '','list')?></td>
    </tr>
    <tr>
      <th><strong>内容页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template_show]', 'template_show', $MODEL[$modelid]['template_show'], '','show')?></td>
    </tr>
    <tr>
      <th><strong>打印页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template_print]', 'template_print', $MODEL[$modelid]['template_print'], '','print')?></td>
    </tr>
  </tbody>
  </table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <th width='20%'></th>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
<? }?>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm();
	});
//-->
</script>