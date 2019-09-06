<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table class="table_form" cellspacing="1" cellpadding="0">
<caption><?=$M['name']?>模块配置</caption>
	<tr>
      <th><strong>Meta Keywords（网页关键词）</strong><br>针对搜索引擎设置的关键词</th>
      <td><textarea name='setting[seo_keywords]' cols='60' rows='2' id='seo_keywords'><?=$seo_keywords?></textarea></td>
    </tr>
    <tr>
      <th><strong>Meta Description（网页描述）</strong><br>针对搜索引擎设置的网页描述</th>
      <td><textarea name='setting[seo_description]' cols='60' rows='2' id='seo_description'><?=$seo_description?></textarea></td>
    </tr>
    <tr>
      <th><strong>模块绑定域名</strong></td></th>
      <td><input name='setting[url]' type='text' id='url' value='<?=$url?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <th><strong>每页显示留言个数</strong></td></th>
      <td><input name='setting[pagesize]' type='text' id='pagesize' value='<?=$pagesize?>' size='10' maxlength='50'></td>
    </tr>
	 <tr>
      <th><strong>留言最大字符数</strong></td></th>
      <td><input name='setting[maxcontent]' type='text' id='maxcontent' value='<?=$maxcontent?>' size='10' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>是否开启验证码</strong></th>
      <td>
	  <input type='radio' name='setting[enablecheckcode]' value='1'  <?php if($enablecheckcode){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablecheckcode]' value='0'  <?php if(!$enablecheckcode){ ?>checked <?php } ?>> 否
     </td>
    </tr>
	 <tr>
      <th><strong>是否在前台显示留言</strong></th>
      <td>
	  <input type='radio' name='setting[show]' value='1'  <?php if($show){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[show]' value='0'  <?php if(!$show){ ?>checked <?php } ?>> 否
     </td>
    </tr>
	<tr>
      <th><strong>是否允许游客留言</strong></th>
      <td>
	  <input type='radio' name='setting[enableTourist]' value='1'  <?php if($enableTourist){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableTourist]' value='0'  <?php if(!$enableTourist){ ?>checked <?php } ?>> 否
     </td>
    </tr>
	<tr>
      <th><strong>留言是否需要审核</strong></th>
      <td>
	  <input type='radio' name='setting[checkpass]' value='1'  <?php if($checkpass){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[checkpass]' value='0'  <?php if(!$checkpass){ ?>checked <?php } ?>> 否
     </td>
    </tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="1">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>