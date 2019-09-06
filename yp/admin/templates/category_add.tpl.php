<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script language='JavaScript' type='text/JavaScript'>
function HideTabTitle(displayValue,tempType)
{
	for (var i = 1; i < 5; i++)
	{
		var tt=document.getElementById("TabTitle"+i);
		if(tempType==0&&i==2)
		{
			tt.style.display='none';
		}
		else
		{
			tt.style.display=displayValue;
		}
	}
}
</script>
<script type="text/javascript" src="images/js/validator.js"></script>
<body>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>" >
<table cellpadding="0" cellspacing="1" class="table_form" id='Tabs0' style='display:'>
   <caption>添加栏目</caption>
  <tr>
  <th width="25%"><strong>上级栏目</strong></th>
  <td>
  <?=form::select_category($mod, 0, 'category[parentid]', 'parentid', '无（作为一级栏目）', $catid)?>  <font color="red">*</font>
  </td>
  </tr>

    <tr>
      <th><strong>栏目名称</strong></th>
      <td><input name='category[catname]' type='text' id='catname' size='40' maxlength='50' require="true" datatype="limit|ajax" min="1" max="50" url="?mod=yp&file=category&action=checkname&parentid=<?=$catid?>" msg="字符长度范围必须为1到50位|" msgid="msgid1"> <?=form::style('category[style]','')?>  <font color="red">*</font><span id ="msgid1"/></td>
    </tr>
    <tr>
      <th><strong>栏目图片</strong></th>
      <td><input name='category[image]' type='text' id='image' size='40' maxlength='50'> <?=file_select('image', $catid, 1)?></td>
    </tr>
    <tr>
      <th><strong>栏目介绍</strong><br></th>
      <td><textarea name='category[description]' id='description' cols='60' rows='4'></textarea></td>
    </tr>
    <tr>
      <th width='30%'><strong>META Title（栏目标题）</strong><br/>针对搜索引擎设置的标题</th>
      <td><input name='setting[meta_title]' type='text' id='meta_title' size='60' maxlength='60'></td>
    </tr>
    <tr>
      <th width='30%'><strong>META Keywords（栏目关键词）</strong><br/>针对搜索引擎设置的关键词</th>
      <td><textarea name='setting[meta_keywords]' cols='60' rows='3' id='meta_keywords'></textarea></td>
    </tr>
    <tr>
      <th width='30%'><strong>META Description（栏目描述）</strong><br/>针对搜索引擎设置的网页描述</th>
      <td><textarea name='setting[meta_description]' cols='60' rows='3' id='meta_description'></textarea></td>
    </tr>
</table>

<table height="25" cellpadding="0" cellspacing="1">
  <tr>
     <td width='30%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>