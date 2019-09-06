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
  if(document.myform.cattype[0].checked==true){
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
	for (var i = 1; i < 4; i++)
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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<form name="myform" method="post" action="?file=category&action=add&save=1&channelid=<?=$channelid?>" onSubmit='return CheckForm();'>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本信息</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>显示控制</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>权限设置</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>收费设置</td>
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
      <td class='tablerow'><input name='category[catname]' type='text' id='catname' size='40' maxlength='50'>  <font color="red">*</font></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>栏目图片</strong></td>
      <td class='tablerow'><input name='category[catpic]' type='text' id='catpic' size='40' maxlength='50'> <input type="button" value=" 上传 " onclick="javascript:openwinx('?mod=phpcms&file=uppic&channelid=<?=$channelid?>&uploadtext=catpic&width=100&height=100','upload','350','200')"></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>栏目说明</strong><br></td>
      <td class='tablerow'><input name='category[introduce]' type='text' id='introduce' size='40' maxlength='255'></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>打开方式</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='category[target]' value='_self' checked> 在原窗口打开&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='category[target]' value='_blank'> 在新窗口打开
	  </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>Meta Keywords（栏目关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='category[meta_keywords]' cols='60' rows='2' id='meta_keywords'></textarea></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>Meta Description（栏目描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='category[meta_description]' cols='60' rows='2' id='meta_description'></textarea></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>栏目类型</strong><br><font color=red>请慎重选择，栏目一旦添加后就不能再更改栏目类型。</font></td>
      <td class='tablerow'>
        <input id='cattype' name='category[cattype]' type='radio' value='1' checked onclick="HideTabTitle('',1)">
        <font color=blue><b>内部栏目</b></font>&nbsp;&nbsp;内部栏目具有详细的参数设置。可以添加子栏目和信息。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;内部栏目的目录名：<input name='category[catdir]' id='catdir' type='text' size='20' maxlength='20'> <font color='#FF0000'>目录名只能由英文字母和数字组成</font><br><br>
		<input id='cattype' name='category[cattype]' type='radio' value='0' onclick="HideTabTitle('none')">
		<font color=blue><b>外部栏目</b></font>&nbsp;&nbsp;外部栏目指链接到本系统以外的地址中。当此栏目准备链接到网站中的其他系统时，请使用这种方式。不能在外部栏目中添加信息，也不能添加子栏目。<br>
		&nbsp;&nbsp;&nbsp;&nbsp;外部栏目的链接地址：<input name='category[linkurl]' id='linkurl' type='text' value='http://www.phpcms.cn' size='30' maxlength='200'> <?=$page_select?>
		</td>
    </tr>
  </tbody>

  <tbody id='Tabs1' style='display:none'>
    <th colspan=2>显示控制</th>
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
	  <input type='radio' name='category[showonmenu]' value='1' checked> 是&nbsp;&nbsp;
	  <input type='radio' name='category[showonmenu]' value='0'> 否&nbsp;&nbsp;
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
	  <input type='radio' name='category[enableadd]' value='1'> 是&nbsp;&nbsp;
	  <input type='radio' name='category[enableadd]' value='0' checked> 否&nbsp;&nbsp;  
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>是否启用此栏目的防止复制、防盗链功能</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='category[enableprotect]' value='1'> 是&nbsp;&nbsp;
	  <input type='radio' name='category[enableprotect]' value='0' checked> 否&nbsp;&nbsp;  
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>子栏目在此栏目页显示的信息数</strong></td>
      <td class='tablerow'>
	  <select name='category[showchilditems]' id='showchilditems' style="width:60px">
	  <?php for($i=1;$i<21;$i++){ ?>
	  <option value='<?=$i?>' <?php if($i==10){ ?>selected <?php } ?>><?=$i?></option>
	  <?php } ?>
	  </select>
	    </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>列表页每页显示的信息数</strong></td>
      <td class='tablerow'>
	  <select name='category[maxperpage]' id='maxperpage' style="width:60px">
	  <?php for($i=5;$i<101;$i++){ ?>
	  <option value='<?=$i?>' <?php if($i==20){ ?>selected <?php } ?>><?=$i?></option>
	  <?php } ?>
	  </select>
	    </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>此栏目下的信息列表的排序方式</strong></td>
      <td class='tablerow'>
	  <select name='category[itemordertype]' id='itemordertype' style="width:120px">
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
	  <input type='radio' name='category[itemtarget]' value='1' checked> 在新窗口打开&nbsp;&nbsp;
	  <input type='radio' name='category[itemtarget]' value='0'> 在原窗口打开&nbsp;&nbsp;  
	  </td>
    </tr>
  </tbody>

  <tbody id='Tabs2' style='display:none'>
      <th colspan=2>权限设置</th>
    <tr>
      <td width='30%' class='tablerow'><strong>栏目权限</strong><br><font color='red'>栏目权限为继承关系，当栏目设为“认证栏目”时，其下的栏目设为“开放栏目”也无效。相反，如果栏目设为“开放栏目”，其下的栏目可以自由设置权限。</font></td>
      <td class='tablerow'>
     <table>
     <tr><td width='80' valign='top'><input type='radio' name='category[catpurview]' value='0' checked>开放栏目</td>
	 <td>任何人（包括游客）可以浏览此栏目下的信息。可以在栏目设置中再指定具体的权限。</td></tr>
     <tr><td width='80' valign='top'><input type='radio' name='category[catpurview]' value='1'>认证栏目</td>
	 <td>游客不能浏览，并在下面指定允许浏览的会员组。如果栏目设置为认证栏目，则此栏目的“生成HTML”选项只能设为“不生成HTML”。</td></tr>
     </table>
      </td>
    </tr>
    <tr>
	<td class='tablerow'><strong>允许浏览此栏目的用户组</strong><br>如果栏目权限设置为“认证栏目”，请在此设置允许浏览此栏目的会员组</td>
	<td class='tablerow'>
    <?=$arrgroupid_browse?>
	</td>
	</tr>
    <tr>
	<td class='tablerow'><strong>允许查看此栏目信息的用户组</strong><br>如果栏目权限设置为“认证栏目”，请在此设置允许浏览此栏目的会员组</td>
	<td class='tablerow'>
    <?=$arrgroupid_view?>
	</td>
	</tr>
    <tr>
	<td class='tablerow'><strong>允许在此栏目发表信息的用户组</strong></td>
	<td class='tablerow'>
    <?=$arrgroupid_add?>
	</td>
	</tr>
  </tbody>
  <tbody id='Tabs3' style='display:none'>
      <th colspan=2>收费设置</th>
    <tr>
      <td width='300' class='tablerow'><strong>积分奖励</strong><br>会员在此栏目发表信息时可以得到的积分</td>
      <td class='tablerow'>会员在此栏目每发表一条信息，可以得到 <input name='category[creditget]' type='text' value='1' size='4' maxlength='4' style='text-align:center'> 分积分</td>
    </tr>
    <tr>
      <td width='300' class='tablerow'><strong>默认收费点数</strong><br>会员在此栏目下查看信息时，该信息默认的收费点券数</td>
      <td class='tablerow'><input name='category[defaultpoint]' type='text' value='0' size='4' maxlength='4' style='text-align:center'> 点</td>
    </tr>
    <tr>
      <td width='300' class='tablerow'><strong>默认重复收费</strong><br>会员在此栏目下查看信息时，该信息默认的重复收费方式</td>
      <td class='tablerow'>
        <input name='category[defaultchargetype]' type='radio' value='0' checked>不重复收费<br>
        <input name='category[defaultchargetype]' type='radio' value='1'>每阅读一次就重复收费一次（建议不要使用）</td>
    </tr>
  </tbody>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><input type="submit" name="Submit" value="保存设置"></td>
  </tr>
</table>
</form>
</body>
</html>