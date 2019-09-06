<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
 <caption><?=$M['name']?>模块配置</caption>
	<tr>
      <th width="30%"><strong>标题截取长度：</strong></th>
      <td><input type='text' name='setting[titlelen]' id='titlelen' value='<?=$titlelen?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>摘要截取长度：</strong></th>
      <td><input type='text' name='setting[descriptionlen]' id='descriptionlen' value='<?=$descriptionlen?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
		<th><strong>启用全文检索：</strong></th>
		<td>
			<input name='setting[fulltextenble]' type='radio' id='url' value='1' <?php if($fulltextenble) echo 'checked'; ?>>是&nbsp;
			<input name='setting[fulltextenble]' type='radio' id='url' value='0' <?php if(!$fulltextenble) echo 'checked'; ?>>否
		</td>
	</tr>
	<tr>
      <th><strong>模块URL地址：</strong></th>
      <td><input name='setting[url]' type='text' id='url' value='<?=$url?>' size='40' maxlength='50'></td>
    </tr>
	<tr>
      <th></th>
      <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
    </tr>
</table>
</form>
</body>
</html>