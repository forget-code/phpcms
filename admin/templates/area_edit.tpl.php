<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script language='JavaScript' type='text/JavaScript'>
function CheckForm(){
  if(document.myform.areaname.value==''){
    ShowTabs(0);
    alert('请输入地区名称！');
    document.myform.areaname.focus();
    return false;
  }
}
function HideTabTitle(displayValue,tempType)
{
	for (var i = 1; i < 2; i++)
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
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&areaid=<?=$areaid?>&keyid=<?=$keyid?>" onSubmit='return CheckForm();'>
<input name='area[keyid]' type='hidden' id='keyid' value='<?=$keyid?>'>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan=2>基本信息</th>
  <tr>
  <td width='30%' class='tablerow'><strong>所属地区</strong></td>
  <td class='tablerow'>
<?=$parentid?>
  <font color="red">*</font>
  </td>
  </tr>
    <tr>
      <td class='tablerow'><strong>地区名称</strong></td>
      <td class='tablerow'><input name='area[areaname]' type='text' id='areaname' size='40' maxlength='50' value='<?=$areaname?>'>  <?=style_edit('area[style]',$style)?></td>
    </tr>

    <tr>
      <td width='30%' class='tablerow'><strong>SEO Title（地区标题）</strong><br>针对搜索引擎设置的标题</td>
      <td class='tablerow'><input name='setting[seo_title]' type='text' id='seo_title' size='50' maxlength='50' value='<?=$seo_title?>'></td>
    </tr>
    <tr>
      <td width='30%' class='tablerow'><strong>SEO Keywords（地区关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='setting[seo_keywords]' cols='60' rows='3' id='seo_keywords'><?=$seo_keywords?></textarea></td>
    </tr>
    <tr>
      <td width='30%' class='tablerow'><strong>SEO Description（地区描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='setting[seo_description]' cols='60' rows='3' id='seo_description'><?=$seo_description?></textarea></td>
    </tr>
	<tr>
      <td width='30%' class='tablerow'><strong>地区风格</strong></td>
      <td class='tablerow'>
<?=$skinid?>
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>地区首页模板</strong></td>
      <td class='tablerow'>
<?=$templateid?>
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>地区信息列表模板</strong></td>
      <td class='tablerow'>
<?=$listtemplateid?>
	  </td>
    </tr>
	  
	<tr>
      <td class='tablerow'><strong>地区列表分页url规则(不生成html)</strong></td>
      <td class='tablerow'>
	  <?=$area_urlrule?>
	 </td>
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
</body>
</html>