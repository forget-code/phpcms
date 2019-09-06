<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script language='JavaScript' type='text/JavaScript'>
function CheckForm(){
  if(document.myform.channelname.value==''){
    ShowTabs(0);
    alert('请输入频道名称！');
    document.myform.channelname.focus();
    return false;
  }
  document.myform.templateid.value = template.document.template.templateid.value;
}

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

<script language="javascript">
     var i=<?=$i?>;
	 var k=i;
     function AddItem()
     { 
        i++;
		if(i>50)
		{
			alert("参数过多！");
			return;
		}
        document.all.setting.innerHTML+="<div id='setting"+i+"'><table cellpadding='0' cellspacing='0' border='0' width='100%'><tr align='center'><td class='tablerow' width='5%'>"+i+"</td><td class='tablerow' width='12%'><input name='myvariable[]' type='text' id='myvariable[]' size='12' maxlength='50'></td><td class='tablerow' width='34%'><textarea id='myvalue[]' name='myvalue[]' rows='3' cols='40'></textarea></td><td class='tablerow' width='25%'><textarea id='mynote[]' name='mynote[]' rows='3' cols='30'></textarea></td><td class='tablerow' width='15%'><input type='button' value=' 删除 ' name='del' onClick=\"DelItem('setting"+i+"');\"></td><td class='tablerow' width='5%'></td></tr></table></div>";
     }
	 function DelItem(myid)
	 {
		 i--;
		 setidval(myid,'');
	 }
	function ResetItem()
    { 
		document.all.setting.innerHTML= old;
		i=k;
    }
</script>

<body onload="old = document.all.setting.innerHTML;<?php if(!$channeltype){ ?>HideTabTitle('none');<?php } ?>">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<form name="myform" method="post" action="?file=channel&action=edit&channelid=<?=$channelid?>&save=1" onSubmit='return CheckForm();'>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本信息</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>权限设置</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>上传选项</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>生成方式</td>
<td id='TabTitle4' class='title1' onclick='ShowTabs(4)'>自定义参数</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">

  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
    <tr>
      <td width='25%' class='tablerow'><strong>频道名称</strong></td>
      <td class='tablerow'><input name='channel[channelname]' type='text' id='channelname' size='40' maxlength='50' value='<?=$channelname?>'></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>频道图片</strong></td>
      <td class='tablerow'><input name='channel[channelpic]' type='text' id='channelpic' size='40' maxlength='50' value='<?=$channelpic?>'> <input type="button" value=" 上传 " onclick="javascript:openwinx('?mod=phpcms&file=uppic&channelid=<?=$channelid?>&uploadtext=channelpic&width=100&height=100','upload','350','200')"></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>频道说明</strong><br></td>
      <td class='tablerow'><input name='channel[introduce]' type='text' id='introduce' size='40' maxlength='255' value='<?=$introduce?>'></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>频道关键词</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><input name='channel[meta_keywords]' type='text' id='meta_keywords' size='40' maxlength='30' value='<?=$meta_keywords?>'></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>频道内容描述</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><input name='channel[meta_description]' type='text' id='meta_description' size='40' maxlength='30' value='<?=$meta_description?>'></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>频道类型</strong><br>请慎重选择，频道一旦添加后就不能再更改频道类型。</td>
      <td class='tablerow'>
   <input name='channel[channeltype]' id='channeltype' type='radio' value='1' <?php if($channeltype){ ?>checked <?php }else{ ?>disabled <?php } ?> onClick="channelsetting.style.display=''"><font color=blue><b>系统内部频道</b></font><br>&nbsp;&nbsp;&nbsp;&nbsp;系统内部频道指的是在本系统现有功能模块（新闻、文章、图片等）基础上添加新的频道，新频道具备和所使用功能模块完全相同的功能。例如，添加一个名为“新闻”的新频道，新频道使用“文章”模块的功能，则新添加的“新闻”频道具有原文章频道的所有功能。
      <table id='channelsetting' width='100%' border='0' cellpadding='2' cellspacing='1' style='display:<?php if(!$channeltype){ ?>none<?php }?>'>
	  <tr>
	  <td width='200' class='tablerow'><strong>频道使用的功能模型：</strong></td>
	  <td>
	  <select name='channel[module]' id='module' disabled>
	  <?php foreach($modules as $m){ ?>
	  <option value='<?=$m['module']?>' <?php if($m['module']==$module){ ?>selected <?php } ?>><?=$m['modulename']?></option>
      <?php } ?>
	  </select>
	  &nbsp;&nbsp;<font color=red>请慎重选择，添加后就不能修改此项。</font></td>
	  </tr>
        <tr>
		<td width='200' class='tablerow'><strong>频道目录：</strong><br>
		<font color='#FF0000'>只能是英文</font>	<font color='#0000FF'>样例：</font>news、soft</td>
		<td><input name='channel[channeldir]' type='text' id='channeldir' size='20' maxlength='50' value='<?=$channeldir?>' disabled>  <font color='#FF0000'>*&nbsp;&nbsp;请慎重录入，添加后就不能修改此项。</font></td>
		</tr>
        <tr>
		<td width='200' class='tablerow'><strong>绑定域名：</strong><br>
		<font color='#FF0000'>如果不绑定则请不要填写</font><br></td>
		<td><input name='channel[channeldomain]' type='text' id='channeldomain' size='20' maxlength='50' value='<?=$channeldomain?>'> 例如：http://soft.phpcms.cn</td>
		</tr>
      </table> 
<br><br>
<input name='channel[channeltype]' id='channeltype' type='radio' value='0' <?php if(!$channeltype){ ?>checked <?php }else{ ?>disabled <?php } ?> onClick="channelsetting.style.display='none'"><font color=blue><b>外部频道</b></font><br>&nbsp;&nbsp;&nbsp;&nbsp;外部频道指链接到本系统以外的地址中。当此频道准备链接到网站中的其他系统时，请使用这种方式。<br>&nbsp;&nbsp;&nbsp;&nbsp;
链接地址：<input name='channel[linkurl]' type='text' id='linkurl' size='40' maxlength='200' value='<?=$linkurl?>' <?php if($channeltype){ ?>readonly<?php }?>> <?php if(!$channeltype){ ?><?=$page_select?><?php } ?>
	  </td>
    </tr>
	<tr>
      <td width='25%' class='tablerow'><strong>频道的默认风格</strong></td>
      <td class='tablerow'>
<?=$skinid?>
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>频道首页的默认模板</strong></td>
      <td class='tablerow'>
	  	<input type="hidden" id="templateid" name="channel[templateid]" value="<?=$templateid?>">
        <iframe id="template" src="?mod=phpcms&file=template&action=showselect&name=templateid&type=index&templateid=<?=$templateid?>&module=<?=$module?>" border="0" vspace="0" hspace="0" marginwidth="0" marginheight="0" framespacing="0" frameborder="0" scrolling="no" width="250" height="22"></iframe>
	  </td>
    </tr>
  </tbody>

  <tbody id='Tabs1' style='display:none'>
      <th colspan=2>权限设置</th>
    <tr>
      <td width='30%' class='tablerow'><strong>频道权限：</strong><br><font color='red'>频道权限为继承关系，当频道设为“认证频道”时，其下的栏目设为“开放栏目”也无效。相反，如果频道设为“开放频道”，其下的栏目可以自由设置权限。</font></td>
      <td class='tablerow'>
     <table>
     <tr><td width='80' valign='top'><input type='radio' name='channel[channelpurview]' value='0'  <?php if($channelpurview==0){ ?>checked <?php } ?>>开放频道</td>
	 <td>任何人（包括游客）可以浏览此频道下的信息。可以在栏目设置中再指定具体的权限。</td></tr>
     <tr><td width='80' valign='top'><input type='radio' name='channel[channelpurview]' value='1' <?php if($channelpurview==1){ ?>checked <?php } ?>>认证频道</td>
	 <td>游客不能浏览，并在下面指定允许浏览的会员组。如果频道设置为认证频道，则此频道的“生成HTML”选项只能设为“不生成HTML”。</td></tr>
     </table>
      </td>
    </tr>
    <tr>
	<td class='tablerow'><strong>允许浏览此频道的会员组：</strong><br>如果频道权限设置为“认证频道”，请在此设置允许浏览此频道的会员组</td>
	<td class='tablerow'>
<?=$arrgroupid_browse?>
	</td>
	</tr>
    <tr>
      <td width='200' class='tablerow'><strong>无权限浏览信息时的提示信息：</strong><br>支持HTML代码，可使用类似{$_groupid}格式的变量</td>
      <td class='tablerow'><textarea name='channel[purview_message]' cols='70' rows='5'><?=$purview_message?></textarea></td>
    </tr>
    <tr>
      <td width='200' class='tablerow'><strong>信息需要扣点数时的提示信息：</strong><br>支持HTML代码，可使用类似{$readpoint}格式的变量</td>
      <td class='tablerow'><textarea name='channel[point_message]' cols='70' rows='5'><?=$point_message?></textarea></td>
    </tr>
    <tr>
      <td width='200' class='tablerow'><strong>是否允许投稿</strong></td>
      <td class='tablerow'>
	  <input name='channel[enablecontribute]' type='radio' value='1' <?php if($enablecontribute==1){ ?>checked <?php } ?>>是
	  <input name='channel[enablecontribute]' type='radio' value='0' <?php if($enablecontribute==0){ ?>checked <?php } ?>>否
	  </td>
    </tr>
    <tr>
	<td width='200' class='tablerow'><strong>投稿是否需要审核</strong><br>设定为需要审核时，如果某组会员有“发表信息不需审核”的特权，则此会员组不受此限。</td>
	<td class='tablerow'>
	<input name='channel[enablecheck]' type='radio' value='1' <?php if($enablecheck==1){ ?>checked <?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>需要审核员进行审核</font><br>
	<input name='channel[enablecheck]' type='radio' value='0' <?php if($enablecheck==0){ ?>checked <?php } ?>>否&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>在本频道发表信息不需要管理员审核</font><br>
	</td>
	</tr>
    <tr>
      <td width='200' class='tablerow'><strong>退稿时站内短信/Email通知内容：</strong><br>不支持HTML代码</td>
      <td class='tablerow'><textarea name='channel[emailofreject]' cols='70' rows='5'><?=$emailofreject?></textarea></td>
    </tr>
    <tr>
      <td width='200' class='tablerow'><strong>稿件被采用时站内短信/Email通知内容：</strong><br>不支持HTML代码</td>
      <td class='tablerow'><textarea name='channel[emailofpassed]' cols='70' rows='5'><?=$emailofpassed?></textarea></td>
    </tr>
  </tbody>

  <tbody id='Tabs2' style='display:none'>
      <th colspan=2>上传选项</th>
	    <tr>
      <td width='25%' class='tablerow'><strong>是否允许在本频道上传文件</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='channel[enableupload]' value='1' <?php if($enableupload==1){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='channel[enableupload]' value='0' <?php if($enableupload==0){ ?>checked <?php } ?>> 否
     </td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>上传文件的保存目录</strong></td>
      <td class='tablerow'><input name='channel[uploaddir]' type='text' id='uploaddir' value='<?=$uploaddir?>' size='40' maxlength='20'> </td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>允许上传的最大文件大小</strong></td>
      <td class='tablerow'><input name='channel[maxfilesize]' type='text' id='maxfilesize' value='<?=$maxfilesize?>' size='40' maxlength='20'> Byte</td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>允许上传的文件类型</strong></td>
      <td class='tablerow'>
<input name='channel[uploadfiletype]' type='text' id='uploadfiletype' value='<?=$uploadfiletype?>' size='60' maxlength='200'>
	  </td>
	</tr>
  </tbody>

    <tbody id='Tabs3' style='display:none'>
      <th colspan=2>生成方式</th>
	    <tr>
      <td width='25%' class='tablerow'><strong>生成HTML方式</strong></td>
      <td class='tablerow'>
<input type='radio' name='channel[htmlcreatetype]' value='0' <?php if($htmlcreatetype==0){ ?>checked <?php } ?>>不生成&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>如果你觉得生成html很麻烦，可以选择此项</font><br>
<input type='radio' name='channel[htmlcreatetype]' value='1' <?php if($htmlcreatetype==1){ ?>checked <?php } ?>>全部生成&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>此方式在生成后将最节省系统资源，但当信息量大时，生成过程将比较长。</font><br>
<input type='radio' name='channel[htmlcreatetype]' value='2' <?php if($htmlcreatetype==2){ ?>checked <?php } ?>>首页和内容页为HTML，栏目和专题页为php<br>
<input type='radio' name='channel[htmlcreatetype]' value='3' <?php if($htmlcreatetype==3){ ?>checked <?php } ?>>首页、内容页、栏目和专题的首页为HTML，其他页为php <font color='red'><b>推荐</b></font>，选择此项就不需要手动更新网页
	 </td>
    </tr>
	<tr>
      <td width='25%' class='tablerow'><strong>URL静态化</strong><br>构造静态化URL有利于搜索优化，但是会略微增加服务器负担</td>
      <td class='tablerow'>
<input type='radio' name='channel[urltype]' value='0' <?php if($urltype==0){ ?>checked <?php } ?>>不进行url静态化<br>
<input type='radio' name='channel[urltype]' value='1' <?php if($urltype==1){ ?>checked <?php } ?>>构造的URL类似于 ./list.php?catid-1/page-5.html&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'></font><br>
<input type='radio' name='channel[urltype]' value='2' <?php if($urltype==2){ ?>checked <?php } ?>>构造的URL类似于 ./list-1-5.html（需要服务器支持Apache的Mod_Rewrite功能）<br>
	 </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>生成文件的扩展名</b></td>
      <td class="tablerow">
<input name="channel[fileext]" type="text" size="8" id="fileext" value="<?=$fileext?>"> 请选择 
<select name="ext" id="ext" onchange="javascript:myform.fileext.value=myform.ext.value">
<option value='htm' <?php if($fileext=='htm'){ ?>selected<?php } ?>>htm</option>
<option value='html' <?php if($fileext=='html'){ ?>selected<?php } ?>>html</option>
<option value='shtm' <?php if($fileext=='shtm'){ ?>selected<?php } ?>>shtm</option>
<option value='shtml' <?php if($fileext=='shtml'){ ?>selected<?php } ?>>shtml</option>
</select>
	  </td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>栏目列表文件的生成方式</strong></td>
      <td class='tablerow'>
文件前缀：<input name='channel[listfilepre]' type='text' id='listfilepre' value='<?=$listfilepre?>' size='40' maxlength='50'><br>
<input name='channel[listfiletype]' type='radio' value='0' <?php if($listfiletype==0){ ?>checked <?php } ?>>列表文件分目录保存在所属栏目的文件夹中<br>&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>例：news/it/net/index.html（栏目首页）<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;news/it/net/List_2.html（第二页）</font><br>
<input name='channel[listfiletype]' type='radio' value='1' <?php if($listfiletype==1){ ?>checked <?php } ?>>列表文件统一保存在指定的“List”文件夹中<br>&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>例：news/list/List_236.html（栏目首页）<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;news/list/List_236_2.html（第二页）</font><br>
<input name='channel[listfiletype]' type='radio' value='2' <?php if($listfiletype==2){ ?>checked <?php } ?>>列表文件统一保存在频道文件夹中<br>&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>例：news/List_236.html（栏目首页）<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;news/List_236_2.html（第二页）</font><br>
</td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>内容页文件的生成方式</strong></td>
      <td class='tablerow'>
	  文件前缀：<input name='channel[contentfilepre]' type='text' id='contentfilepre' value='<?=$contentfilepre?>' size='40' maxlength='50'><br>
<input type='radio' name='channel[contentfiletype]' value='0' <?php if($contentfiletype==0){ ?>checked <?php } ?>> 频道/年份/月日/文件（先按年份，再按日期分，每日一个目录）<br>&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>例：news/2006/0401/163.html</font><br>
<input type='radio' name='channel[contentfiletype]' value='1' <?php if($contentfiletype==1){ ?>checked <?php } ?>> 频道/大类/小类/月份/文件（栏目分级，再按月份保存）<br>&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>例：news/it/net/200408/1368.html</font><br>
<input type='radio' name='channel[contentfiletype]' value='2' <?php if($contentfiletype==2){ ?>checked <?php } ?>> 频道/html/文件（直接放在指定的“HTML”文件夹中）<br>&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>例：news/HTML/1368.html</font><br>
<input type='radio' name='channel[contentfiletype]' value='3' <?php if($contentfiletype==3){ ?>checked <?php } ?>> 频道/文件（直接放在频道目录中）<br>&nbsp;&nbsp;&nbsp;&nbsp;<font color='blue'>例：news/1368.html</font><br>

</td>
    </tr>
  </tbody>
 
   <tbody id='Tabs4' style='display:none'>
      <th colspan=6>自定义参数</th>
    <tr align='center'>
<td width="5%" class="tablerowhighlight">序号</td>
<td width="12%" class="tablerowhighlight">参数名</td>
<td width="34%" class="tablerowhighlight">参数值</td>
<td width="25%" class="tablerowhighlight">参数说明</td>
<td width="15%" class="tablerowhighlight">变量名</td>
<td width="5%" class="tablerowhighlight">删除</td>
	  </tr>
<tr align="center" bgColor='#F1F3F5'>
<td colspan=6>
<div id="setting">
<?php 
if(is_array($settings)){
	$k=1;
	foreach($settings as $id => $setting){
?>
<div id="setting<?=$k?>">
     <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr align='center'> 
            <td class="tablerow" width="5%"><?=$k?></td>
            <td class="tablerow" width="12%">
			<?=$setting['variable']?>
			<input name="myvariable[<?=$setting['variable']?>]" type="hidden" id="myvariable[<?=$setting['variable']?>]" size="12" maxlength="50" value="<?=$setting['variable']?>" readonly>
			</td>
            <td class="tablerow" width="34%"><textarea id="myvalue[<?=$setting['variable']?>]" name="myvalue[<?=$setting['variable']?>]" rows="3" cols="40"><?=$setting['value']?></textarea></td>
            <td class="tablerow" width="25%" align="left" >
			<?=$setting['note']?>
			<input name="mynote[<?=$setting['variable']?>]" type="hidden" id="mynote[<?=$setting['variable']?>]" size="12" maxlength="50" value="<?=$setting['note']?>">
	        </td>
			<td class="tablerow" width="15%">$_PHPCMS['<?=$setting['variable']?>']</td>
			<td class="tablerow" width="5%">
			<input type="checkbox" value="<?=$setting['variable']?>" name="delete[<?=$setting['variable']?>]">
	        </td>
          </tr>
      </table>
</div>
<?php 
	$k++;
	}
}
?>
</div>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<input type="button" value="增加参数" name="add" onClick="AddItem();">
    <input type="button" value="重置参数" name="reset" onClick="ResetItem();">
	</td>
  </tr>
</table>
</td>
</tr>
  </tbody>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<input type="submit" name="Submit" value="保存设置">
	</td>
  </tr>
</table>
</form>
</body>
</html>