<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan=2>基本信息</th>
  <tr>
      <td width='40%' class='tablerow'><strong>产品栏目是否生成html</strong>
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[ishtml]' value='1'  <?php if($ishtml){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0'  <?php if(!$ishtml){ ?>checked <?php } ?>> 否
     </td>
    </tr>
    <tr>
      <td class='tablerow'><strong>产品栏目列表分页url规则(生成html)</strong></td>
      <td class='tablerow'>
	  <?=$cat_html_urlrule?>
	 </td>
    </tr>

	<tr>
      <td class='tablerow'><strong>产品栏目列表分页url规则(不生成html)</strong></td>
      <td class='tablerow'>
	  <?=$cat_php_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>把以上设置应用到产品子栏目</strong></td>
      <td class='tablerow'><input type="radio" name="createtype_application" value="1" /> 是 <input type="radio" name="createtype_application" value="0" checked /> 否</td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>TITLE（企业黄页标题）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='setting[seo_title]' cols='60' rows='2' id='seo_title'><?=$seo_title?></textarea></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>Meta Keywords（网页关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='setting[seo_keywords]' cols='60' rows='2' id='seo_keywords'><?=$seo_keywords?></textarea></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>Meta Description（网页描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='setting[seo_description]' cols='60' rows='2' id='seo_description'><?=$seo_description?></textarea></td>
    </tr>
    
	<tr>
      <td width='40%' class='tablerow'><strong>经营模式</strong></td>
      <td class='tablerow'><input name='setting[pattern]' type='text' id='pattern' value='<?=$pattern?>' size='40' maxlength='50'></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>企业性质</strong><br>一行一个性质</td>
      <td class='tablerow'><textarea name='setting[type]' cols='30' rows='8' id='type'><?=$type?></textarea></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>招聘岗位分类</strong><br>一行一个分类</td>
      <td class='tablerow'><textarea name='setting[station]' cols='30' rows='8' id='station'><?=$station?></textarea></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>模块绑定域名</strong><br>最后不带反斜线'/'</td></td>
      <td class='tablerow'><input name='setting[moduledomain]' type='text' id='moduledomain' value='<?=$moduledomain?>' size='40' maxlength='50'></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>是否开启二级域名模式</strong>
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableSecondDomain]' value='1'  <?php if($enableSecondDomain){ ?>checked <?php } ?> onclick="$('showSecondDomain').style.display='block'"> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableSecondDomain]' value='0'  <?php if(!$enableSecondDomain){ ?>checked <?php } ?> onclick="$('showSecondDomain').style.display='none'"> 否
     </td>

	<tr id="showSecondDomain" style="display=<?php if(!$enableSecondDomain){ ?>'none'<?php } ?>">
      <td width='40%' class='tablerow'><strong>二级域名</strong></td>
      <td class='tablerow'><input name='setting[secondDomain]' type='text' id='secondDomain' value='<?=$secondDomain?>' size='40' maxlength='50'> 如： domain.com</td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>附件目录</strong></td>
      <td class='tablerow'><input name='setting[uploaddir]' type='text' id='uploaddir' value='<?=$uploaddir?>' size='40' maxlength='50'></td>
    </tr>
	<tr >
      <td width='40%' class='tablerow'><strong>允许上传的最大文件大小</strong></td>
      <td class='tablerow'><input name='setting[maxfilesize]' type='text' id='maxfilesize' value='<?=$maxfilesize?>' size='40' maxlength='50'></td>
    </tr>

    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>自动更新周期</strong><br>更新黄页频道首页、新闻首页、产品页、人才招聘、产品库等</td>
      <td class='tablerow'><input name='setting[autoupdate]' type='text' id='autoupdate'  value='<?=$autoupdate?>' size='8' maxlength='8'> 秒 </td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>注册企业是否需要审核</strong>
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[ischeck]' value='1'  <?php if($ischeck){ ?>checked='checked' <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ischeck]' value='0'  <?php if(!$ischeck){ ?>checked='checked' <?php } ?>> 否
     </td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>允许查看个人会员求职联系方式的会员组</strong></td>
      <td class='tablerow'>
     <?=$arrgroupidview_apply?>
	  </td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>那些会员组发布信息不需要审核</strong><BR>在企业后台发布</td>
      <td class='tablerow'>
     <?=$arrgroupidview_post?>
	  </td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>企业后台公告管理</strong></td>
      <td class='tablerow'>
		<textarea name="setting[notice]" id="notice" cols="100" rows="25"><?=$notice?></textarea> <?=editor("notice", 'basic','80%','200')?>
	  </td>
    </tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>