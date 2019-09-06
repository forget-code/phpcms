<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>模块配置</caption>
	<tr>
      <td width='35%' class='tablerow'><strong>TITLE（企业黄页标题）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='setting[seo_title]' cols='60' rows='2' id='seo_title'><?=$seo_title?></textarea></td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>Meta Keywords（网页关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='setting[seo_keywords]' cols='60' rows='2' id='seo_keywords'><?=$seo_keywords?></textarea></td>
    </tr>
    <tr>
      <td width='35%' class='tablerow'><strong>Meta Description（网页描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='setting[seo_description]' cols='60' rows='2' id='seo_description'><?=$seo_description?></textarea></td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>会员组图片设置</strong></td>
      <td class='tablerow'>
<table cellpadding="0" cellspacing="1" class="table_list">
<tr>
<th>会员组名称</th><th>图片地址</th>
</tr>
<?php
foreach($GROUP AS $groupid=>$value)
{
?>
<tr>
<td width="105"><?=$value?></td>
<td><input type="text" name="setting[groupimg][<?=$groupid?>]" value="<?=$groupimg[$groupid]?>" style="width:100%"></td>
</tr>
<?php
}
?>
</table>
</td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>商务中心目录地址</strong></td>
      <td class='tablerow'><input name='setting[businessdir]' type='text' id='businessdir' value='<?=$businessdir?>' size='40' maxlength='50'></td>
    </tr>
    </tr>
    <tr>
      <td width='35%' class='tablerow'><strong>页面缓存设置</strong></td>
      <td class='tablerow'>
黄页首页：<input name='setting[cache_index]' type='text' id='autoupdate'  value='<?=$cache_index?>' size='8' maxlength='8'> 秒 
	（最佳保持在600 ~ 3600）  <BR> 列表　页：<input name='setting[cache_list]' type='text' id='autoupdate'  value='<?=$cache_list?>' size='8' maxlength='8'> 秒  （最佳保持在1200 ~ 3600）
	  <BR> 内容　页：<input name='setting[cache_show]' type='text' id='autoupdate'  value='<?=$cache_show?>' size='8' maxlength='8'> 秒  （最佳保持在3600 ~ 9600）
	  </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>注册企业是否需要审核</strong>
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[ischeck]' value='1'  <?php if($ischeck){ ?>checked='checked' <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ischeck]' value='0'  <?php if(!$ischeck){ ?>checked='checked' <?php } ?>> 否
     </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>是否开启伪静态</strong>
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enable_rewrite]' value='1'  <?php if($enable_rewrite){ ?>checked='checked' <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enable_rewrite]' value='0'  <?php if(!$enable_rewrite){ ?>checked='checked' <?php } ?>> 否
     </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>允许查看个人会员求职联系方式的会员组</strong></td>
      <td class='tablerow'>
		<?php foreach($GROUP as $groupid=>$name) { ?>
		<input type="checkbox" name="setting[priv_roleid][]" <?php if(in_array($groupid,$priv_roleid))echo "checked='checked'"; ?> value="<?=$groupid?>" /> <?=$name?>
		<?php } ?>
	  </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>允许发布“新闻”的会员组</strong></td>
      <td class='tablerow'>
	  <?php foreach($GROUP as $groupid=>$name) { ?>
		<input type="checkbox" name="setting[allow_add_news][]" <?php if(in_array($groupid,$allow_add_news))echo "checked='checked'"; ?> value="<?=$groupid?>" /> <?=$name?>
		<?php } ?>
	  </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>允许发布“产品”的会员组</strong></td>
      <td class='tablerow'>
	  <?php foreach($GROUP as $groupid=>$name) { ?>
		<input type="checkbox" name="setting[allow_add_product][]" <?php if(in_array($groupid,$allow_add_product))echo "checked='checked'"; ?> value="<?=$groupid?>" /> <?=$name?>
		<?php } ?>
	  </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>允许发布“商机”的会员组</strong></td>
      <td class='tablerow'>
	  <?php foreach($GROUP as $groupid=>$name) { ?>
		<input type="checkbox" name="setting[allow_add_buy][]" <?php if(in_array($groupid,$allow_add_buy))echo "checked='checked'"; ?> value="<?=$groupid?>" /> <?=$name?>
		<?php } ?>
	  </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>允许发布“招聘”的会员组</strong></td>
      <td class='tablerow'>
	  <?php foreach($GROUP as $groupid=>$name) { ?>
		<input type="checkbox" name="setting[allow_add_job][]" <?php if(in_array($groupid,$allow_add_job))echo "checked='checked'"; ?> value="<?=$groupid?>" /> <?=$name?>
		<?php } ?>
	  </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>允许使用“我的访问者”的会员组</strong></td>
      <td class='tablerow'>
	  <?php foreach($GROUP as $groupid=>$name) { ?>
		<input type="checkbox" name="setting[allow_add_stat][]" <?php if(in_array($groupid,$allow_add_stat))echo "checked='checked'"; ?> value="<?=$groupid?>" /> <?=$name?>
		<?php } ?>
	  </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>允许添加“资质证书”的会员组</strong></td>
      <td class='tablerow'>
	  <?php foreach($GROUP as $groupid=>$name) { ?>
		<input type="checkbox" name="setting[allow_add_cert][]" <?php if(in_array($groupid,$allow_add_cert))echo "checked='checked'"; ?> value="<?=$groupid?>" /> <?=$name?>
		<?php } ?>
	  </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>允许添加“标注地图”的会员组</strong></td>
      <td class='tablerow'>
	  <?php foreach($GROUP as $groupid=>$name) { ?>
		<input type="checkbox" name="setting[allow_add_map][]" <?php if(in_array($groupid,$allow_add_map))echo "checked='checked'"; ?> value="<?=$groupid?>" /> <?=$name?>
		<?php } ?>
	  </td>
    </tr>
	<tr>
      <td width='35%' class='tablerow'><strong>那些会员组发布信息“不需要”审核</strong><BR>在企业后台发布</td>
      <td class='tablerow'>
    <?php foreach($GROUP as $groupid=>$name) { ?>
		<input type="checkbox" name="setting[add_check][]" <?php if(in_array($groupid,$add_check))echo "checked='checked'"; ?> value="<?=$groupid?>" /> <?=$name?>
		<?php } ?>
	  </td>
    </tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='35%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>