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
  <caption>添加栏目</caption>
  <tr>
  <th><font color="red">*</font>  <strong>上级栏目</strong></th>
  <td>
<?=form::select_category('phpcms', 0, 'parentid', 'parentid', '无（作为一级栏目）', $catid,'',2)?>
  </td>
  </tr>
     <tr>
      <th><strong>栏目类型</strong></th>
      <td>
	  <input type="radio" name="type" value="0" checked onClick="$('#model').show()">内部栏目（可绑定内容模型，并支持在栏目下建立子栏目或发布信息）<br/>
	  <input type="radio" name="type" value="1" onClick="$('#model').hide()">单网页（可更新单网页内容，但是不能在栏目下建立子栏目或发布信息）<br/>
	  <input type="radio" name="type" value="2" onClick="$('#model').hide()">外部链接（可建立一个链接并指向任意网址）<br/>
	  </td>
    </tr>
<tbody id="model" style="display:'block'">
     <tr>
      <th><strong>绑定模型</strong></td>
      <td><?=form::select_model('modelid', 'modelid', '', $modelid, '')?> <a href="?mod=phpcms&file=model&action=manage">管理模型</a></td>
    </tr>
</tbody>
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
<div class="tag_menu" style="width:99%;margin-top:10px;">
<ul>
  <li><a href="#" id='TabTitle0' onclick='ShowTabs(0)' class="selected">基本信息</a></li>
  <li><a href="#" id='TabTitle2' onclick='ShowTabs(2)'>权限设置</a></li>
  <li><a href="#" id='TabTitle3' onclick='ShowTabs(3)'>收费设置</a></li>
  <li><a href="#" id='TabTitle4' onclick='ShowTabs(4)'>模板设置</a></li>
</ul></div>
<table cellpadding="2" cellspacing="1" class="table_form">
  <tbody id='Tabs0' style='display:'>
  <tr>
  <th width='30%'><strong>上级栏目</strong></th>
  <td>
  <input type="hidden" name="category[parentid]" value="<?=$parentid?>"> <?=$parentid ? $CATEGORY[$parentid]['catname'] : '无'?>
  </td>
  </tr>
     <tr>
      <th><strong>绑定模型</strong></th>
      <td>
  <input type="hidden" name="category[modelid]" value="<?=$modelid?>"> <?=$MODEL[$modelid]['name']?>
	  </td>
    </tr>
    <tr>
      <th><font color="red">*</font> <strong>栏目名称</strong></th>
      <td><input name='category[catname]' type='text' id='catname' size='40' maxlength='50' require="true" datatype="limit|ajax" min="1" max="50" url="?mod=phpcms&file=category&action=checkname&parentid=<?=$parentid?>" msg="字符长度范围必须为1到50位|" msgid="msgid1"> <?=form::style('category[style]','')?><span id="msgid1"></span></td>
    </tr>
    <tr>
      <th><font color="red">*</font> <strong>栏目目录</strong></th>
      <td><input name='category[catdir]' type='text' id='catdir' size='20' maxlength='50' require="true" datatype="limit|ajax" min="1" max="50" url="?mod=phpcms&file=category&action=checkdir&parentid=<?=$parentid?>" msg="字符长度范围必须为1到50位|"></td>
    </tr>
    <tr>
      <th><strong>栏目图片</strong></th>
      <td><input name='category[image]' type='text' id='image' size='40' maxlength='50'> <?=file_select('image', $catid, 1)?></td>
    </tr>
    <tr>
      <th><strong>栏目介绍</strong><br></th>
      <td><textarea name='category[description]' id='description' style="width:90%;height:50px"></textarea></td>
    </tr>
     <tr>
      <th><strong>工作流方案</strong></th>
      <td><?=form::select(cache_read('workflow.php'), 'setting[workflowid]', 'workflowid', $MODEL[$modelid]['workflowid'])?>  <a href="?mod=phpcms&file=workflow&forward=<?=urlencode(URL)?>">管理工作流方案</a></td>
    </tr>
	<tr>
      <th width='30%'><strong>在导航栏显示</strong></th>
      <td>
	  <input type='radio' name='category[ismenu]' value='1' checked> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='category[ismenu]' value='0'> 否
	  </td>
    </tr>
	<?php if($parentid==0) { ?>
    <tr>
      <th><strong>绑定域名：</strong><br>如果不绑定则请不要填写</th>
      <td>
		<?php if(!$MODELE[$modelid][ishtml]) {?>
      <input name='category[url]' type='text' id='domain' value='' size='60' maxlength='60'> 例如：http://soft.phpcms.cn
		<?php } else echo "当前栏目绑定的模型为不生成静态，需要绑定二级域名，<a href='?mod=phpcms&file=model&action=edit&modelid=".$modelid."'>请点击这里设置</a>";?>
      </td>
    </tr>
    <?php } ?>
    <tr>
      <th><strong>META Title（栏目标题）</strong><br/>针对搜索引擎设置的标题</th>
      <td><input name='setting[meta_title]' type='text' id='meta_title' size='60' maxlength='60'></td>
    </tr>
    <tr>
      <th><strong>META Keywords（栏目关键词）</strong><br/>针对搜索引擎设置的关键词</th>
      <td><textarea name='setting[meta_keywords]' id='meta_keywords' style="width:90%;height:40px"></textarea></td>
    </tr>
    <tr>
      <th><strong>META Description（栏目描述）</strong><br/>针对搜索引擎设置的网页描述</th>
      <td><textarea name='setting[meta_description]' id='meta_description' style="width:90%;height:50px"></textarea></td>
    </tr>
  </tbody>

  <tbody id='Tabs2' style='display:none'>
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
     <th width='30%'></th>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>

<?php }elseif($type == 1){ ?>

<script language='JavaScript' type='text/JavaScript'>
function CheckForm(){
	if(document.myform.catname.value==''){
		alert('请输入单网页名称！');
		document.myform.catname.focus();
		return false;
	}
	if(document.myform.catdir.value==''){
		alert('请输入单网页英文名！');
		document.myform.catdir.focus();
		return false;
	}
}
</script>

<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" onSubmit='return CheckForm();'>
<input name="forward" type="hidden" value="<?=$forward?>">
<input type="hidden" name="category[type]" value="<?=$type?>">
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>添加单网页</caption>
  <tr>
  <th width='25%'><strong>上级栏目</strong></th>
  <td>
  <input type="hidden" name="category[parentid]" value="<?=$parentid?>"> <?=$parentid ? $CATEGORY[$parentid]['catname'] : '无'?>
  </td>
  </tr>
    <tr>
      <th><strong>单网页名称</strong></th>
      <td><input name='category[catname]' type='text' id='catname' size='40' maxlength='50'> <?=form::style('category[style]','')?>  <font color="red">*</font></td>
    </tr>
    <tr>
      <th><strong>单网页英文名</strong></th>
      <td><input name='category[catdir]' type='text' id='catdir' size='20' maxlength='50'>  <font color="red">*</font></td>
    </tr>
    <tr>
      <th><strong>单网页图片</strong></th>
      <td><input name='category[image]' type='text' id='image' size='40' maxlength='50'> <?=file_select('image', $catid, 1)?></td>
    </tr>
    <tr>
      <th><strong>单网页模板</strong></th>
      <td><?=form::select_template('phpcms', 'setting[template]', 'template', 'page', '','page')?></td>
    </tr>
	<tr>
      <th><strong>是否生成Html</strong></th>
      <td>
	  <input type='radio' name='setting[ishtml]' value='1' <?php if($PHPCMS['ishtml']){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=1&category_urlruleid=0');"> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0' <?php if(!$PHPCMS['ishtml']){ ?>checked <?php } ?> onClick="$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=0&category_urlruleid=0');"> 否
	  </td>
    </tr>
	<tr>
      <th width='30%'><strong>是否在导航栏显示</strong></th>
      <td>
	  <input type='radio' name='category[ismenu]' value='1'> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='category[ismenu]' value='0' checked> 否
	  </td>
    </tr>
	<tr>
      <th><strong>栏目页URL规则</strong></th>
      <td><div id="div_category_urlruleid"></div></td>
    </tr>
    <tr>
      <th><strong>修改权限</strong></th>
      <td><?=form::checkbox($ROLE, 'priv_roleid', 'priv_roleid', '')?></td>
    </tr>
    <tr>
      <th><strong>查看权限</strong></th>
      <td><?=form::checkbox($GROUP, 'priv_groupid', 'priv_groupid', '')?></td>
    </tr>
    <tr>
      <th><strong>META Title（单网页标题）</strong><br/>针对搜索引擎设置的标题</th>
      <td><input name='setting[meta_title]' type='text' id='meta_title' size='60' maxlength='60'></td>
    </tr>
    <tr>
      <th><strong>META Keywords（单网页关键词）</strong><br/>针对搜索引擎设置的关键词</th>
      <td><textarea name='setting[meta_keywords]' cols='100' rows='7' id='meta_keywords'></textarea></td>
    </tr>
    <tr>
      <th><strong>META Description（单网页描述）</strong><br/>针对搜索引擎设置的网页描述</th>
      <td><textarea name='setting[meta_description]' cols='100' rows='7' id='meta_description'></textarea></td>
    </tr>
  <tr>
     <th></th>
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

<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" onSubmit='return CheckForm();'>
<input name="forward" type="hidden" value="<?=$forward?>">
<input type="hidden" name="category[type]" value="<?=$type?>">
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>添加外部链接</caption>
  <tr>
  <th width='25%'><strong>上级栏目</strong></th>
  <td>
  <input type="hidden" name="category[parentid]" value="<?=$parentid?>"> <?=$parentid ? $CATEGORY[$parentid]['catname'] : '无'?>
  </td>
  </tr>
    <tr>
      <th><strong>链接名称</strong></th>
      <td><input name='category[catname]' type='text' id='catname' size='40' maxlength='50'> <?=form::style('category[style]','')?>  <font color="red">*</font></td>
    </tr>
    <tr>
      <th><strong>链接图片</strong></th>
      <td><input name='category[image]' type='text' id='image' size='40' maxlength='50'> <?=file_select('image', $catid, 1)?></td>
    </tr>
	<tr>
      <th width='30%'><strong>在导航栏显示</strong></th>
      <td>
	  <input type='radio' name='category[ismenu]' value='1'  > 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='category[ismenu]' value='0' checked > 否
	  </td>
    </tr>
    <tr>
      <th><strong>链接地址</strong></th>
      <td><input name='category[url]' type='text' id='url' size='60' maxlength='100'>  <font color="red">*</font></td>
    </tr>
  <tr>
     <th width='30%'></th>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
<?php } ?>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>