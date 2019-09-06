<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body <?php if($type<2){ ?>onLoad="is_ie();$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=<?=$ishtml?>&type=category&category_urlruleid=<?=$category_urlruleid?>');$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=show_urlrule&ishtml=<?=$content_ishtml?>&type=show&show_urlruleid=<?=$show_urlruleid?>');"<?php } ?> >

<?php if($type == 0){ ?>

<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>">
<input type="hidden" name="category[type]" value="<?=$type?>">
<div class="tag_menu" style="width:99%;margin-top:10px;">
	<ul>
		<li><a onClick="ShowTabs(0)" id="TabTitle0" href="###" class="selected">基本信息</a></li>
		<li><a onClick="ShowTabs(2)" id="TabTitle2" href="###">权限设置</a></li>
		<li><a onClick="ShowTabs(3)" id="TabTitle3" href="###">收费设置</a></li>
		<li><a onClick="ShowTabs(4)" id="TabTitle4" href="###">扩展设置</a></li>
		<li><a onClick="ShowTabs(5)" id="TabTitle5" href="###">生成HTML</a></li>
	</ul>
</div>
<table cellpadding="2" cellspacing="1" class="table_form">
  <tbody id='Tabs0' style='display:'>
  <tr>
  <th width='30%'><font color="red">*</font> <strong>上级栏目</strong></th>
  <td>
<?=form::select_category('phpcms', 0, 'category[parentid]', 'parentid', '无（作为一级栏目）', $parentid,'',2)?>
  </td>
  </tr>
     <tr>
      <th><strong>绑定模型</strong></th>
      <td>
	  <?php if(($items =$cat->count($catid))){ ?>
           <input type="hidden" name="category[modelid]" value="<?=$modelid?>"> <?=$MODEL[$modelid]['name']?>（由于<?=$catname?>栏目存在<?=$items?>条信息，不能更改模型）
	  <?php }else{ ?>
	       <?=form::select_model('category[modelid]', 'modelid', '', $modelid)?>
	  <?php } ?>
	  </td>
    </tr>
    <tr>
      <th><font color="red">*</font> <strong>栏目名称</strong></th>
      <td><input name='category[catname]' type='text' id='catname' value='<?=$catname?>' size='40' maxlength='50' require="true" datatype="limit" min="1" max="50" msg="字符长度范围必须为1到50位" msgid="msgid1"> <?=form::style('category[style]',  $style)?><span id="msgid1"/></td>
    </tr>
    <tr>
      <th><font color="red">*</font> <strong>栏目目录</strong></th>
      <td><input name='category[catdir]' type='text' id='catdir' value='<?=$catdir?>' size='20' maxlength='50' require="true" datatype="limit" min="1" max="50" msg="字符长度范围必须为1到50位"></td>
    </tr>
    <tr>
      <th><strong>栏目图片</strong></th>
      <td><input name='category[image]' type='text' id='image' value='<?=$image?>' size='40' maxlength='50'> <?=file_select('image', $catid, 1)?></td>
    </tr>
    <tr>
      <th><strong>栏目介绍</strong><br></th>
      <td><textarea name='category[description]' id='description' style="width:90%;height:50px"><?=$description?></textarea></td>
    </tr>
     <tr>
      <th><strong>工作流方案</strong></th>
      <td><?=form::select(cache_read('workflow.php'), 'setting[workflowid]', 'workflowid', $workflowid)?>  <a href="?mod=phpcms&file=workflow&forward=<?=urlencode(URL)?>">管理工作流方案</a></td>
    </tr>
	<tr>
      <th width='30%'><strong>在导航栏显示</strong></th>
      <td>
	  <input type='radio' name='category[ismenu]' value='1' <?php if($ismenu){ ?>checked <?php } ?> > 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='category[ismenu]' value='0' <?php if(!$ismenu){ ?>checked <?php } ?> > 否
	  </td>
    </tr>
    <tr>
      <th><strong>绑定域名：</strong><br>如果不绑定则请不要填写</th>
      <td>
		<?php if($MODEL[$modelid]['ishtml']) {?>
      <input name='category[url]' type='text' id='domain' value='<?php if(preg_match('/:\/\//',$url) && substr_count($url, '/')==2) echo $url;?>' size='60' maxlength='60'> 例如：http://soft.phpcms.cn
		<?php } else echo "当前栏目绑定的模型为不生成静态，需要绑定二级域名，<a href='?mod=phpcms&file=model&action=edit&modelid=".$modelid."'>请点击这里设置</a>";?>
      </td>
    </tr>
    <tr>
      <th width='30%'><strong>META Title（栏目标题）</strong><br/>针对搜索引擎设置的标题</th>
      <td><input name='setting[meta_title]' type='text' id='meta_title' value='<?=$meta_title?>' size='60' maxlength='60'></td>
    </tr>
    <tr>
      <th width='30%'><strong>META Keywords（栏目关键词）</strong><br/>针对搜索引擎设置的关键词</th>
      <td><textarea name='setting[meta_keywords]' id='meta_keywords' style="width:90%;height:40px"><?=$meta_keywords?></textarea></td>
    </tr>
    <tr>
      <th width='30%'><strong>META Description（栏目描述）</strong><br/>针对搜索引擎设置的网页描述</th>
      <td><textarea name='setting[meta_description]' id='meta_description' style="width:90%;height:50px"><?=$meta_description?></textarea></td>
    </tr>
  </tbody>

  <tbody id='Tabs2' style='display:none'>
    <tr>
      <td valign="top">
		  <table cellpadding="2" cellspacing="1" class="table_list">
		      <caption>会员组权限</caption>
			  <tr>
				  <th>会员组名</th><th>浏览列表</th><th>查看内容</th><th>录入</th>
			  </tr>
		  <input type="hidden" name="priv_groupid[]" value="-99">
		  <?php foreach($GROUP as $groupid=>$name)
		  {
          ?>
			  <tr>
				  <td><?=$name?></td>
				  <td><input type="checkbox" name="priv_groupid[]" value="browse,<?=$groupid?>" <?=$priv_group->check('catid', $catid, 'browse', $groupid) ? 'checked' : ''?>></td>
				  <td><input type="checkbox" name="priv_groupid[]" value="view,<?=$groupid?>" <?=$priv_group->check('catid', $catid, 'view', $groupid) ? 'checked' : ''?>></td>
				  <td><input type="checkbox" name="priv_groupid[]" value="input,<?=$groupid?>" <?=$priv_group->check('catid', $catid, 'input', $groupid) ? 'checked' : ''?>></td>
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
				  <td><input type="checkbox" name="priv_roleid[]" <?=($roleid==1||$roleid==2)?'disabled checked':''?> value="view,<?=$roleid?>" <?=$priv_role->check('catid', $catid, 'view', $roleid) ? 'checked' : ''?>></td>
				  <td><input type="checkbox" name="priv_roleid[]" <?=($roleid==1||$roleid==2)?'disabled checked':''?> value="add,<?=$roleid?>" <?=$priv_role->check('catid', $catid, 'add', $roleid) ? 'checked' : ''?>></td>
				  <td><input type="checkbox" name="priv_roleid[]" <?=($roleid==1||$roleid==2)?'disabled checked':''?> value="edit,<?=$roleid?>" <?=$priv_role->check('catid', $catid, 'edit', $roleid) ? 'checked' : ''?>></td>
				  <td><input type="checkbox" name="priv_roleid[]" <?=($roleid==1||$roleid==2)?'disabled checked':''?> value="check,<?=$roleid?>" <?=$priv_role->check('catid', $catid, 'check', $roleid) ? 'checked' : ''?>></td>
				  <td><input type="checkbox" name="priv_roleid[]" <?=($roleid==1||$roleid==2)?'disabled checked':''?> value="listorder,<?=$roleid?>" <?=$priv_role->check('catid', $catid, 'listorder', $roleid) ? 'checked' : ''?>></td>
				  <td><input type="checkbox" name="priv_roleid[]" <?=($roleid==1||$roleid==2)?'disabled checked':''?> value="cancel,<?=$roleid?>" <?=$priv_role->check('catid', $catid, 'cancel', $roleid) ? 'checked' : ''?>></td>
				  <td><input type="checkbox" name="priv_roleid[]" <?=($roleid==1||$roleid==2)?'disabled checked':''?> value="manage,<?=$roleid?>" <?=$priv_role->check('catid', $catid, 'manage', $roleid) ? 'checked' : ''?>></td>
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
      <td><input name='setting[presentpoint]' type='text' value='<?=$presentpoint?>' size='4' maxlength='4' style='text-align:center'> 点</td>
    </tr>
    <tr>
      <th><strong>默认收费点数</strong><br>会员在此栏目下查看信息时，该信息默认的收费点数</th>
      <td><input name='setting[defaultchargepoint]' type='text' value='<?=$defaultchargepoint?>' size='4' maxlength='4' style='text-align:center'> 点</td>
    </tr>
    <tr>
      <th><strong>重复收费设置</strong></th>
      <td>
	    <input name='setting[repeatchargedays]' type='text' value='<?=$repeatchargedays?>' size='4' maxlength='4' style='text-align:center'> 天内不重复收费&nbsp;&nbsp;
        <font color="red">0 表示每阅读一次就重复收费一次（建议不要使用）</font></td>
    </tr>
  </tbody>
   <tbody id='Tabs4' style='display:none'>
    <tr>
      <th width='30%'><strong>栏目首页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template_category]', 'template_category', $template_category, '','category')?></td>
    </tr>
    <tr>
      <th><strong>栏目列表页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template_list]', 'template_list', $template_list, '','list')?></td>
    </tr>
    <tr>
      <th><strong>内容页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template_show]', 'template_show', $template_show, '','show')?></td>
    </tr>
	<tr>
      <th><strong>打印页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template_print]', 'template_print', $template_print, '','print')?></td>
    </tr>
	<tr>
      <th width='30%'><strong>允许上传附件的类型</strong></th>
      <td><input type="text" name="setting[upload_allowext]" value='<?=$upload_allowext?>' size='40'> </td>
    </tr> 
	<tr>
      <th width='30%'><strong>允许上传文件的大小</strong></th>
      <td><input type="text" name="setting[upload_maxsize]" value='<?=$upload_maxsize?>' size='15' maxlength='10'> Bytes</td>
    </tr> 
	<tr>
      <th width='30%'><strong>是否启用缩略图</strong></th>
      <td><label><input type="radio" name="setting[thumb_enable]" value=1 <?php if($thumb_enable==1) {?>checked<?php } ?>> 是</label> <label><input type="radio" name="setting[thumb_enable]" value=0 <?php if($thumb_enable==0) {?>checked<?php } ?>> 否</label></td>
    </tr> 
	<tr>
      <th width='30%'><strong>缩略图大小</strong></th>
      <td><input name='setting[thumb_width]' type='text' id='thumb_width' value='<?=$thumb_width?>' size='5' maxlength='5'> X <input name='setting[thumb_height]' type='text' id='thumb_height' value='<?=$thumb_height?>' size='5' maxlength='5'> px </td>
    </tr>
	<tr>
      <th width='30%'><strong>是否启用水印</strong></th>
      <td><label><input type="radio" name="setting[watermark_enable]" value=1 <?php if($watermark_enable==1) {?>checked<?php } ?>> 是</label> <label><input type="radio" name="setting[watermark_enable]" value=0 <?php if($watermark_enable==0) {?>checked<?php } ?>> 否</label> <span style="color:#ff0000">水印的详细设置遵照网站配置下的附件设置里的设置。如果<a href='?mod=phpcms&file=setting&tab=4'>修改</a>将全站生效。</span></td>
    </tr>
	<tr>
      <th width='30%'><strong>以上设置是否应用到子栏目及信息</strong></th>
      <td><label><input type="radio" name="createtype_application" value=1> 是</label> <label><input type="radio" name="createtype_application" value=0> 否</label> <span style="color:#ff0000">选择“是”权限、收费、扩展设置将应用到子栏目上，内容模板将应用到信息上。</span></td>
    </tr>
		
  </tbody>
   <tbody id='Tabs5' style='display:none'>
	<tr>
      <th width='30%'><strong>栏目生成Html</strong></th>
      <td>
	  <input type='radio' name='setting[ishtml]' value='1' <?php if($ishtml){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=1&type=category&category_urlruleid=<?=$category_urlruleid?>');"> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0' <?php if(!$ishtml){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=0&type=category&category_urlruleid=<?=$category_urlruleid?>');"> 否
	  </td>
    </tr>
	<tr>
      <th width='30%'><strong>内容页生成Html</strong></th>
      <td>
	  <input type='radio' name='setting[content_ishtml]' value='1' <?php if(!isset($content_ishtml) || $content_ishtml){ ?>checked <?php } ?> onClick="$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=show_urlrule&ishtml=1&type=show&show_urlruleid=<?=$show_urlruleid?>');"> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[content_ishtml]' value='0' <?php if(isset($content_ishtml) && !$content_ishtml){ ?>checked <?php } ?> onClick="$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=show_urlrule&ishtml=0&type=show&show_urlruleid=<?=$show_urlruleid?>');"> 否
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
  </tbody>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='30%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>

<?php }elseif($type == 1){ ?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>">
<input type="hidden" name="category[type]" value="<?=$type?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>修改单网页</caption>
  <th width='30%'><strong>上级栏目</strong></th>
  <td>
<?=form::select_category('phpcms', 0, 'category[parentid]', 'parentid', '无（作为一级栏目）', $parentid,'',2)?>  <font color="red">*</font>
  </td>
  </tr>
    <tr>
      <th><strong>单网页名称</strong></th>
      <td><input name='category[catname]' type='text' id='catname' value='<?=$catname?>' size='40' maxlength='50' require="true" datatype="require" msg="单网页名称不能为空"> <?=form::style('category[style]', $style)?>  <font color="red">*</font></td>
    </tr>
    <tr>
      <th><strong>单网页英文名</strong></th>
      <td><input name='category[catdir]' type='text' id='catdir' value='<?=$catdir?>' size='20' maxlength='50' require="true" datatype="require" msg="单网页英文名不能为空">  <font color="red">*</font></td>
    </tr>
    <tr>
      <th><strong>单网页图片</strong></th>
      <td><input name='category[image]' type='text' id='image' value='<?=$image?>' size='40' maxlength='50'> <?=file_select('image', $catid, 1)?></td>
    </tr>
    <tr>
      <th width='30%'><strong>单网页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template]', 'template', $template, '','page')?></td>
    </tr>
	<tr>
      <th width='30%'><strong>是否生成Html</strong></th>
      <td>
	  <input type='radio' name='setting[ishtml]' value='1' <?php if($ishtml){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=1&category_urlruleid=<?=$category_urlruleid?>');"> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0' <?php if(!$ishtml){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=0&category_urlruleid=<?=$category_urlruleid?>');"> 否
	  </td>
    </tr>
	<tr>
      <th width='30%'><strong>是否在导航栏显示</strong></th>
      <td>
	  <input type='radio' name='category[ismenu]' value='1' <?php if($ismenu){ ?>checked <?php } ?> > 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='category[ismenu]' value='0' <?php if(!$ismenu){ ?>checked <?php } ?> > 否
	  </td>
    </tr>
	<tr>
      <th><strong>栏目页URL规则</strong></th>
      <td><div id="div_category_urlruleid"></div></td>
    </tr>
    <tr>
      <th width='30%'><strong>修改权限</strong></th>
      <td><?=form::checkbox($ROLE, 'priv_roleid', 'priv_roleid', $priv_roleids)?></td>
    </tr>
    <tr>
      <th width='30%'><strong>查看权限</strong></th>
      <td><?=form::checkbox($GROUP, 'priv_groupid', 'priv_groupid', $priv_groupids)?></td>
    </tr>
    <tr>
      <th width='30%'><strong>META Title（单网页标题）</strong><br/>针对搜索引擎设置的标题</th>
      <td><input name='setting[meta_title]' type='text' id='meta_title' value='<?=$meta_title?>' size='60' maxlength='60'></th>
    </tr>
    <tr>
      <th width='30%'><strong>META Keywords（单网页关键词）</strong><br/>针对搜索引擎设置的关键词</th>
      <td><textarea name='setting[meta_keywords]' cols='100' rows='7' id='meta_keywords'><?=$meta_keywords?></textarea></td>
    </tr>
    <tr>
      <th width='30%'><strong>META Description（单网页描述）</strong><br/>针对搜索引擎设置的网页描述</th>
      <td><textarea name='setting[meta_description]' cols='100' rows='7' id='meta_description'><?=$meta_description?></textarea></td>
    </tr>
  <tr>
     <td width='30%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>

<?php }elseif($type == 2){ ?>

<script language='JavaScript' type='text/JavaScript'>
function CheckForm(){
	if(document.myform.catname.value==''){
		alert('请输入链接名称！');
		document.myform.catname.focus();
		return false;
	}
	if(document.myform.url.value==''){
		alert('请输入链接地址！');
		document.myform.url.focus();
		return false;
	}
}
</script>

<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>" onSubmit='return CheckForm();'>
<input type="hidden" name="category[type]" value="<?=$type?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>修改外部链接</caption>
  <tr>
  <th width='25%'><strong>上级栏目</strong></th>
  <td>
<?=form::select_category('phpcms', 0, 'category[parentid]', 'parentid', '无（作为一级栏目）', $parentid,'',2)?>  <font color="red">*</font>
  </td>
  </tr>
    <tr>
      <th><strong>链接名称</strong></th>
      <td><input name='category[catname]' type='text' id='catname' value="<?=$catname?>" size='40' maxlength='50'> <?=form::style('category[style]', $style)?>  <font color="red">*</font></td>
    </tr>
    <tr>
      <th><strong>链接图片</strong></th>
      <td><input name='category[image]' type='text' id='image' value="<?=$image?>" size='40' maxlength='50'> <?=file_select('image', $catid, 1)?></td>
    </tr>
	<tr>
      <th width='30%'><strong>在导航栏显示</strong></th>
      <td>
	  <input type='radio' name='category[ismenu]' value='1' <?php if($ismenu){ ?>checked <?php } ?> > 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='category[ismenu]' value='0' <?php if(!$ismenu){ ?>checked <?php } ?> > 否
	  </td>
    </tr>
	<tr>
      <th><strong>链接地址</strong></th>
      <td><input name='category[url]' type='text' id='url' size='60' maxlength='100' value="<?=$url?>" require="true" datatype="require" msg="链接地址不能为空">  <font color="red">*</font></td>
    </tr>
	<tr>
     <td width='30%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>

<?php }?>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>