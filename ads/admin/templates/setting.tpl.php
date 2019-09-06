<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption><?=$M['name']?>模块配置</caption>
 	<tr>
      <th><strong>是否统计广告点击次数</strong></th>
      <td>
	  <input type='radio' name='setting[enableadsclick]' value='1'  <?php if($enableadsclick){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableadsclick]' value='0'  <?php if(!$enableadsclick){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <th><strong>每页显示广告位数</strong></th>
      <td><input name='setting[pagesize]' type='text' id='pagesize' value='<?=$pagesize?>' size='12' maxlength='50'> &nbsp;&nbsp;&nbsp;&nbsp; 
	 </td>
    </tr>
	<tr>
      <th><strong>允许上传的文件类型</strong></th>
      <td><input name='setting[ext]' type='text' id='ext' value='<?=$ext?>' size='50' maxlength='70'> &nbsp;&nbsp;&nbsp;&nbsp; 
	 </td>
    </tr>
	<tr>
      <th><strong>允许上传的文件大小</strong></th>
      <td><input name='setting[maxsize]' type='text' id='maxsize' value='<?=$maxsize?>' size='12'>&nbsp;&nbsp;b &nbsp;&nbsp;&nbsp;&nbsp; 
	 </td>
    </tr>
	<tr>
      <th><strong>html和js存放目录</strong></th>
      <td>./data/<input name='setting[htmldir]' type='text' id='htmldir' value='<?=$htmldir?>' size='12' maxlength='50'>/ &nbsp;&nbsp;&nbsp;&nbsp; 修改广告html存放目录名可以防止广告被客户端浏览器屏蔽
	 </td>
    </tr>
    <tr>
      <th><strong>模块绑定域名</strong></th>
      <td><input name='setting[url]' type='text' id='moduledomain' value='<?=$url?>' size='40' maxlength='50'></td>
    </tr>
</table>
<table width="100%" height="40" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>