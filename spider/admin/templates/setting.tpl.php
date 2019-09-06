<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption><?=$M['name']?>模块配置</caption>
    <tr>
      <th><strong>调试输出信息</strong></th>
      <td><input name='setting[Debug]' type='radio' value="1" <?php if($Debug) echo "checked";?>> 是 <input name='setting[Debug]' type='radio' value="0" <?php if(!$Debug) echo "checked";?>> 否</td>
  	</tr>
    <tr>
      <th><strong>网址防重复采集</strong></th>
      <td><input name='setting[CacheUrlTag]' type='radio' value="1" <?php if($CacheUrlTag) echo "checked";?>> 是 <input name='setting[CacheUrlTag]' type='radio' value="0" <?php if(!$CacheUrlTag) echo "checked";?>> 否</td>
  	</tr>
    <tr>
      <th><strong>标题防重复发布</strong></th>
      <td><input name='setting[CacheTitleTag]' type='radio' value="1" <?php if($CacheTitleTag) echo "checked";?>> 是 <input name='setting[CacheTitleTag]' type='radio' value="0" <?php if(!$CacheTitleTag) echo "checked";?>> 否</td>
  	</tr>
    <tr>
      <th><strong>标题最大长度限制</strong></th>
      <td><input name='setting[titleLength]' type='text' id='titleLength' value='<?=$titleLength?>' size='5' maxlength='4'> 字符数(phpcms模型默认限制80)</td>
  	</tr>
    <tr>
      <th><strong>从内容的前N个字符提取关键词</strong></th>
      <td><input name='setting[keywordContentLenght]' type='text' id='keywordContentLenght' value='<?=$keywordContentLenght?>' size='5' maxlength='4'>一个汉字字符长度为2</td>
  	</tr>
    <tr>
      <th><strong>单篇文章提取关键词数</strong></th>
      <td><input name='setting[keywordNumber]' type='text' id='keywordNumber' value='<?=$keywordNumber?>' size='5' maxlength='4'>要小于发布模型中关键词数限制</td>
  	</tr>
    <tr>
      <th><strong>提取关键词最小长度</strong></th>
      <td><input name='setting[keywordStrLength]' type='text' id='keywordStrLength' value='<?=$keywordStrLength?>' size='5' maxlength='4'>一个汉字字符长度为2</td>
  	</tr>
    <tr>
      <th><strong>提取关键词最大长度</strong></th>
      <td><input name='setting[keywordStrMaxLength]' type='text' id='keywordStrMaxLength' value='<?=$keywordStrMaxLength?>' size='5' maxlength='4'>一个汉字字符长度为2</td>
  	</tr>
    <tr>
      <th><strong>提取关键词时屏蔽字符串</strong><br>多个字符串以|间隔</th>
      <td><textarea name='setting[keywordFilter]' cols=60 rows=5><?=$keywordFilter?></textarea></td>
  	</tr>
    <tr>
      <th><strong>自动提取摘要长度</strong></th>
      <td><input name='setting[descriptionLength]' type='text' id='descriptionLength' value='<?=$descriptionLength?>' size='5' maxlength='4'> 字符数</td>
  	</tr>
    <tr>
      <th></th>
      <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  	</tr>
</table>
</form>
</body>
</html>