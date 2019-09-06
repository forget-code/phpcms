<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script language='JavaScript' type='text/JavaScript'>
function CheckForm(){
  if(document.myform.catname.value==''){
    ShowTabs(0);
    alert('请输入栏目名称！');
    document.myform.catname.focus();
    return false;
  }
  if(document.myform.islink[0].checked==true){
    if(document.myform.catdir.value==''){
      ShowTabs(0);
      alert('请输入栏目目录！');
      document.myform.catdir.focus();
      return false;
    }
  }
  else{
    if(document.myform.linkurl.value==''){
      ShowTabs(0);
      alert('请输入栏目的链接地址！');
      document.myform.linkurl.focus();
      return false;
    }
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

<body>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add" onSubmit='return CheckForm();'>
<input name='category[module]' type='hidden' id='module' value='<?=$mod?>'>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本设置</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>详细设置</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
  <tr>
  <td width='30%' class='tablerow'><strong>所属栏目</strong></td>
  <td class='tablerow'>
<?=$parentid?>  <font color="red">*</font>
  </td>
  </tr>
    <tr>
      <td class='tablerow'><strong>栏目名称</strong></td>
      <td class='tablerow'><input name='category[catname]' type='text' id='catname' size='40' maxlength='50'>  <?=style_edit('category[style]','')?></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>栏目图片</strong></td>
      <td class='tablerow'><input name='category[catpic]' type='text' id='catpic' size='40' maxlength='50'> <input type="button" value=" 上传 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=catpic&width=100&height=100','upload','350','200')"></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>栏目介绍</strong><br></td>
      <td class='tablerow'><textarea name='category[introduce]' cols='60' rows='4' id='introduce'></textarea> <?=editor('introduce','introduce',400,200)?></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>栏目类型</strong><br><font color=red>请慎重选择，栏目一旦添加后就不能再更改栏目类型。</font></td>
      <td class='tablerow'>
        <input id='islink' name='category[islink]' type='radio' value='0' checked onclick="HideTabTitle('',1)">
        <font color=blue><b>内部栏目</b></font>&nbsp;&nbsp;内部栏目具有详细的参数设置，可以添加子栏目和信息。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;目录名：<input name='category[catdir]' id='catdir' type='text' size='20' maxlength='20'> <font color='#FF0000'>只能由英文字母和数字组成</font><br><br>
		<input id='islink' name='category[islink]' type='radio' value='1' onclick="HideTabTitle('none')">
		<font color=blue><b>外部栏目</b></font>&nbsp;&nbsp;外部栏目指链接到本系统以外的网址，不能添加子栏目和信息。<br>
		&nbsp;&nbsp;&nbsp;&nbsp;链接地址：<input name='category[linkurl]' id='linkurl' type='text' value='http://www.phpcms.cn' size='30' maxlength='200'> <?=$page_select?>
		</td>
    </tr>
  </tbody>

  <tbody id='Tabs1' style='display:none'>
    <th colspan=2>详细设置</th>
    <tr>
      <td width='30%' class='tablerow'><strong>SEO Title（栏目标题）</strong><br>针对搜索引擎设置的标题</td>
      <td class='tablerow'><input name='setting[seo_title]' type='text' id='seo_title' size='50' maxlength='50'></td>
    </tr>
    <tr>
      <td width='30%' class='tablerow'><strong>SEO Keywords（栏目关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='setting[seo_keywords]' cols='60' rows='3' id='seo_keywords'></textarea></td>
    </tr>
    <tr>
      <td width='30%' class='tablerow'><strong>SEO Description（栏目描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='setting[seo_description]' cols='60' rows='3' id='seo_description'></textarea></td>
    </tr>
	<tr>
      <td width='30%' class='tablerow'><strong>栏目风格</strong></td>
      <td class='tablerow'>
<?=$skinid?>
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>栏目首页模板</strong></td>
      <td class='tablerow'>
<?=$templateid?>
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>栏目信息列表模板</strong></td>
      <td class='tablerow'>
<?=$listtemplateid?>
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>栏目下的内容页默认风格</strong></td>
      <td class='tablerow'>
<?=$defaultitemskin?>
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>栏目下的内容页默认模板</strong></td>
      <td class='tablerow'>
<?=$defaultitemtemplate?>
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>是否在导航菜单里显示</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='category[ismenu]' value='1' checked> 是&nbsp;&nbsp;
	  <input type='radio' name='category[ismenu]' value='0'> 否&nbsp;&nbsp;
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>是否在父栏目的分类列表处显示</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='category[islist]' value='1' checked> 是&nbsp;&nbsp;
	  <input type='radio' name='category[islist]' value='0'> 否&nbsp;&nbsp;  
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>有子栏目时是否可以在此栏目添加信息</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableadd]' value='1'> 是&nbsp;&nbsp;
	  <input type='radio' name='setting[enableadd]' value='0' checked> 否&nbsp;&nbsp;  
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>是否启用此栏目的防止复制、防盗链功能</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableprotect]' value='1'> 是&nbsp;&nbsp;
	  <input type='radio' name='setting[enableprotect]' value='0' checked> 否&nbsp;&nbsp;  
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>子栏目在此栏目页显示的信息数</strong></td>
      <td class='tablerow'>
	  <select name='setting[showchilditems]' id='showchilditems' style="width:60px">
	  <?php for($i=1;$i<21;$i++){ ?>
	  <option value='<?=$i?>' <?php if($i==10){ ?>selected <?php } ?>><?=$i?></option>
	  <?php } ?>
	  </select>
	    </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>列表页每页显示的信息数</strong></td>
      <td class='tablerow'>
	  <select name='setting[maxperpage]' id='maxperpage' style="width:60px">
	  <?php for($i=5;$i<101;$i++){ ?>
	  <option value='<?=$i?>' <?php if($i==20){ ?>selected <?php } ?>><?=$i?></option>
	  <?php } ?>
	  </select>
	    </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>此栏目下的信息列表的排序方式</strong></td>
      <td class='tablerow'>
	  <select name='setting[itemordertype]' id='itemordertype' style="width:120px">
<option value='1' selected>信息ID（降序）</option>
<option value='2'>信息ID（升序）</option>
<option value='3'>更新时间（降序）</option>
<option value='4'>更新时间（升序）</option>
<option value='5'>点击次数（降序）</option>
<option value='6'>点击次数（升序）</option>
	  </select>
	    </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>此栏目下的信息打开方式</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[itemtarget]' value='1' checked> 在新窗口打开&nbsp;&nbsp;
	  <input type='radio' name='setting[itemtarget]' value='0'> 在原窗口打开&nbsp;&nbsp;  
	  </td>
    </tr>
  </tbody>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='30%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>