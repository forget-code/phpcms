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

<body <?php if($islink){ ?>onload="HideTabTitle('none')" <?php } ?>>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&catid=<?=$catid?>" onSubmit='return CheckForm();'>
<input name='category[module]' type='hidden' id='module' value='<?=$mod?>'>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本设置</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>详细设置</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>生成方式</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">

  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
  <tr>
  <td width='30%' class='tablerow'><strong>所属栏目</strong></td>
  <td class='tablerow'>
<?=$parentid?>
  <font color="red">*</font>
  </td>
  </tr>
    <tr>
      <td class='tablerow'><strong>栏目名称</strong></td>
      <td class='tablerow'><input name='category[catname]' type='text' id='catname' size='40' maxlength='50' value='<?=$catname?>'>  <?=style_edit('category[style]',$style)?></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>栏目图片</strong></td>
      <td class='tablerow'><input name='category[catpic]' type='text' id='catpic' size='40' maxlength='50' value='<?=$catpic?>'> <input type="button" value=" 上传 " onClick="javascript:openwinx('?mod=phpcms&file=uppic&uploadtext=catpic&width=100&height=100','upload','350','200')"></td>
    </tr>
    <tr>
      <td width='30%' class='tablerow'><strong>关联商品类型</strong><br>Tips:在该分类发布商品时默认选中该商品类型，以增加商品属性</td>
      <td class='tablerow'><?=$producttypeselect?></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>栏目说明</strong><br></td>
      <td class='tablerow'><textarea name='category[introduce]' cols='60' rows='4' id='introduce'><?=$introduce?></textarea> <?=editor('introduce','introduce',400,200)?></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>栏目类型：</strong><br><font color=red>请慎重选择，栏目一旦添加后就不能再更改栏目类型。</font></td>
      <td class='tablerow'>
        <input name='category[islink]' id='islink' type='radio' value='0' <?php if(!$islink){ ?> checked <?php }else{ ?>disabled <?php } ?> onClick="HideTabTitle('',1)">
        <font color=blue><b>内部栏目</b></font>&nbsp;&nbsp;内部栏目具有详细的参数设置。可以添加子栏目和信息。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;内部栏目的目录名：<input name='category[catdir]' id='catdir' type='text' size='20' maxlength='20' value='<?=$catdir?>' readonly> <font color='#FF0000'>注意，目录名只能是英文</font><br><br>
		<input name='category[islink]' id='islink' type='radio' value='1' <?php if($islink){ ?> checked <?php }else{ ?>disabled <?php } ?> onClick="HideTabTitle('none')">
		<font color=blue><b>外部栏目</b></font>&nbsp;&nbsp;外部栏目指链接到本系统以外的地址中。当此栏目准备链接到网站中的其他系统时，请使用这种方式。不能在外部栏目中添加信息，也不能添加子栏目。<br>
		&nbsp;&nbsp;&nbsp;&nbsp;外部栏目的链接地址：<input name='category[linkurl]' type='text' id='linkurl' size='40' maxlength='200' <?php if(!$islink){ ?>disabled <?php }else{ ?>value='<?=$linkurl?>' <?php } ?>>
		</td>
    </tr>
  </tbody>

  <tbody id='Tabs1' style='display:none'>
    <th colspan=2>显示控制</th>
    <tr>
      <td width='30%' class='tablerow'><strong>SEO Title（栏目标题）</strong><br>针对搜索引擎设置的标题</td>
      <td class='tablerow'><input name='setting[seo_title]' type='text' id='seo_title' size='50' maxlength='50' value='<?=$seo_title?>'></td>
    </tr>
    <tr>
      <td width='30%' class='tablerow'><strong>SEO Keywords（栏目关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='setting[seo_keywords]' cols='60' rows='3' id='seo_keywords'><?=$seo_keywords?></textarea></td>
    </tr>
    <tr>
      <td width='30%' class='tablerow'><strong>SEO Description（栏目描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='setting[seo_description]' cols='60' rows='3' id='seo_description'><?=$seo_description?></textarea></td>
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
      <td width='25%' class='tablerow'><strong>栏目下的内容页默认风格</strong></td>
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
      <td class='tablerow'><strong>是否在顶部导航栏显示</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='category[ismenu]' value='1' <?php if($ismenu){ ?> checked <?php } ?>> 是&nbsp;&nbsp;
	  <input type='radio' name='category[ismenu]' value='0' <?php if(!$ismenu){ ?> checked <?php } ?>> 否&nbsp;&nbsp;
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>是否在父栏目的分类列表处显示</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='category[islist]' value='1' <?php if($islist){ ?> checked <?php } ?>> 是&nbsp;&nbsp;
	  <input type='radio' name='category[islist]' value='0' <?php if(!$islist){ ?> checked <?php } ?>> 否&nbsp;&nbsp;  
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>有子栏目时是否可以在此栏目添加信息</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableadd]' value='1' <?php if($enableadd){ ?> checked <?php } ?>> 是&nbsp;&nbsp;
	  <input type='radio' name='setting[enableadd]' value='0' <?php if(!$enableadd){ ?> checked <?php } ?>> 否&nbsp;&nbsp;  
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>是否启用此栏目的防止复制、防盗链功能</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableprotect]' value='1' <?php if($enableprotect){ ?> checked <?php } ?>> 是&nbsp;&nbsp;
	  <input type='radio' name='setting[enableprotect]' value='0' <?php if(!$enableprotect){ ?> checked <?php } ?>> 否&nbsp;&nbsp;  
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>子栏目在此栏目页显示的信息数</strong></td>
      <td class='tablerow'>
	  <select name='setting[showchilditems]' id='showchilditems' style="width:60px">
	  <?php for($i=1;$i<21;$i++){ ?>
	  <option value='<?=$i?>' <?php if($i==$showchilditems){ ?>selected <?php } ?>><?=$i?></option>
	  <?php } ?>
	  </select>
	    </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>列表页每页显示的信息数</strong></td>
      <td class='tablerow'>
	  <select name='setting[maxperpage]' id='maxperpage' style="width:60px">
	  <?php for($i=5;$i<101;$i++){ ?>
	  <option value='<?=$i?>' <?php if($i==$maxperpage){ ?>selected <?php } ?>><?=$i?></option>
	  <?php } ?>
	  </select>
	    </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>此栏目下的信息列表的排序方式</strong></td>
      <td class='tablerow'>
	  <select name='setting[itemordertype]' id='itemordertype' style="width:120px">
<option value='1' <?php if($itemordertype==1){ ?>selected <?php } ?>>信息ID（降序）</option>
<option value='2' <?php if($itemordertype==2){ ?>selected <?php } ?>>信息ID（升序）</option>
<option value='3' <?php if($itemordertype==3){ ?>selected <?php } ?>>更新时间（降序）</option>
<option value='4' <?php if($itemordertype==4){ ?>selected <?php } ?>>更新时间（升序）</option>
<option value='5' <?php if($itemordertype==5){ ?>selected <?php } ?>>点击次数（降序）</option>
<option value='6' <?php if($itemordertype==6){ ?>selected <?php } ?>>点击次数（升序）</option>
	  </select>
	    </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>此栏目下的信息打开方式</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[itemtarget]' value='1' <?php if($itemtarget==1){ ?>checked <?php } ?>> 在新窗口打开&nbsp;&nbsp;
	  <input type='radio' name='setting[itemtarget]' value='0' <?php if($itemtarget==0){ ?>checked <?php } ?>> 在原窗口打开&nbsp;&nbsp;  
	  </td>
    </tr>
  </tbody>
    <tbody id='Tabs2' style='display:none'>
      <th colspan=2>生成方式</th>  
  <tr>
      <td class='tablerow' width='30%'><strong>栏目信息列表是否生成html</strong></td>
      <td class='tablerow'>
      <input type='radio' name='category[ishtml]' value='1' <?php if($ishtml==1){ ?>checked <?php } ?> onclick="$('cat_html').style.display='block';$('cat_html_htmldir').style.display='block';$('cat_html_prefix').style.display='block';$('cat_php').style.display='none';"> 是
      <input type='radio' name='category[ishtml]' value='0' <?php if($ishtml==0){ ?>checked <?php } ?> onclick="$('cat_html').style.display='none';$('cat_html_htmldir').style.display='none';$('cat_html_prefix').style.display='none';$('cat_php').style.display='block';"> 否 
	  </td>
    </tr>
	<tr id="cat_html_htmldir" style='display:<?php if($ishtml==1){ ?>block<?php }else{ ?>none<?php } ?>'> 
      <td class="tablerow"><strong>栏目信息列表页html存放目录</strong></td>
      <td class="tablerow"><input name='category[htmldir]' type='text' id='htmldir' value='<?=$htmldir?>' size='15' maxlength='50'> 仅在栏目信息列页表生成html时有效</td>
    </tr>
	<tr id="cat_html_prefix" style='display:<?php if($ishtml==1){ ?>block<?php }else{ ?>none<?php } ?>'> 
      <td class="tablerow"><strong>栏目信息列表页html前缀</strong></td>
      <td class="tablerow"><input name='category[prefix]' type='text' id='prefix' value='<?=$prefix?>' size='15' maxlength='50'> 仅在栏目信息列页表生成html时有效</td>
    </tr>    
	<tr id="cat_html" style='display:<?php if($ishtml==1){ ?>block<?php }else{ ?>none<?php } ?>'>
      <td class='tablerow'><strong>栏目列表分页url规则(生成html)</strong></td>
      <td class='tablerow'>
	  <?=$cat_html_urlrule?> <strong>Tips:</strong>url规则如果不选择，则自动继承频道规则设置
	 </td>
    </tr>
	<tr id="cat_php" style='display:<?php if($ishtml==0){ ?>block<?php }else{ ?>none<?php } ?>'>
      <td class='tablerow'><strong>栏目列表分页url规则(不生成html)</strong></td>
      <td class='tablerow'>
	  <?=$cat_php_urlrule?>
	 </td>
    </tr>
	<tr> 
      <td class="tablerow"><strong>内容页html存放目录</strong></td>
      <td class="tablerow"><input name='category[item_htmldir]' type='text' id='item_htmldir' value='<?=$item_htmldir?>' size='15' maxlength='50'> 仅在内容页生成html时有效</td>
    </tr>
	<tr> 
      <td class="tablerow"><strong>内容页html前缀</strong></td>
      <td class="tablerow"><input name='category[item_prefix]' type='text' id='item_prefix' value='<?=$item_prefix?>' size='15' maxlength='50'> 仅在内容页生成html时有效</td>
    </tr>
	<tr>
      <td class='tablerow'><strong>内容分页url规则(生成html)</strong></td>
      <td class='tablerow'>
	  <?=$item_html_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>内容分页url规则(不生成html)</strong></td>
      <td class='tablerow'>
	  <?=$item_php_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>把以上设置应用到子栏目和信息</strong></td>
      <td class='tablerow'><input type="radio" name="createtype_application" value="1" /> 是 <input type="radio" name="createtype_application" value="0" checked /> 否</td>
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