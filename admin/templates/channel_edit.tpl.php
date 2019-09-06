<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script  type='text/javaScript'>
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
	for (var i = 1; i < 4; i++)
	{
		var tt=$("TabTitle"+i);
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

function indextpl(module,templateid)
{
    var url = "<?=$PHP_SELF?>";
    var pars = "mod=phpcms&file=template&action=showselect&name=channel[templateid]&type=index&templateid="+templateid+"&module="+module;
	var myAjax = new Ajax.Updater(
					'templateid',
					url,
					{
					method: 'get',
					parameters: pars
					}
	             ); 
}
</script>

<body onload="indextpl(myform.module.value, '<?=$templateid?>');<?php if($islink){ ?>HideTabTitle('none');<?php } ?>">
<?=$menu?>
<form name="myform" method="post" action="?file=channel&action=edit&channelid=<?=$channelid?>" onSubmit='return CheckForm();'>
<input name='channel[channelid]' type='hidden' value='<?=$channelid?>'>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本信息</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>权限设置</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>上传选项</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>生成方式</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">

  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
    <tr>
      <td width='25%' class='tablerow'><strong>频道名称</strong></td>
      <td class='tablerow'><input name='channel[channelname]' type='text' id='channelname' size='40' maxlength='50' value='<?=$channelname?>'>  <?=style_edit('channel[style]',$style)?></td>
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
      <td class='tablerow'><input name='channel[seo_keywords]' type='text' id='seo_keywords' size='40' maxlength='255' value='<?=$seo_keywords?>'></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>频道内容描述</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><input name='channel[seo_description]' type='text' id='seo_description' size='40' maxlength='255' value='<?=$seo_description?>'></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>频道类型</strong><br>请慎重选择，频道一旦添加后就不能再更改频道类型。</td>
      <td class='tablerow'>
   <input name='channel[islink]' id='islink' type='radio' value='0' <?php if(!$islink){ ?>checked <?php }else{ ?>disabled <?php } ?> onClick="channelsetting.style.display=''"><font color=blue><b>系统内部频道</b></font><br>&nbsp;&nbsp;&nbsp;&nbsp;系统内部频道指的是在本系统现有功能模块（新闻、文章、图片等）基础上添加新的频道，新频道具备和所使用功能模块完全相同的功能。例如，添加一个名为“新闻”的新频道，新频道使用“文章”模块的功能，则新添加的“新闻”频道具有原文章频道的所有功能。
      <table id='channelsetting' width='100%' border='0' cellpadding='2' cellspacing='1' style='display:<?php if($islink){ ?>none<?php }?>'>
	  <tr>
	  <td width='200' class='tablerow'><strong>频道使用的功能模型：</strong></td>
	  <td>
	  <select name='channel[module]' id='module' disabled>
	  <?php foreach($modules as $m){ ?>
	  <option value='<?=$m['module']?>' <?php if($m['module']==$module){ ?>selected <?php } ?>><?=$m['name']?></option>
      <?php } ?>
	  </select>
	  &nbsp;&nbsp;<font color=red>请慎重选择，添加后就不能修改此项。</font></td>
	  </tr>
        <tr>
		<td width='200' class='tablerow'><strong>频道目录：</strong><br>
		<font color='#FF0000'>只能是英文</font>	<font color='#0000FF'>样例：</font>news、soft</td>
		<td><input name='channel[channeldir]' type='text' id='channeldir' size='20' maxlength='50' value='<?=$channeldir?>' readonly>  <font color='#FF0000'>*&nbsp;&nbsp;请慎重录入，添加后就不能修改此项。</font></td>
		</tr>
        <tr>
		<td width='200' class='tablerow'><strong>绑定域名：</strong><br>
		<font color='#FF0000'>如果不绑定则请不要填写</font><br></td>
		<td><input name='channel[channeldomain]' type='text' id='channeldomain' size='20' maxlength='50' value='<?=$channeldomain?>'> 例如：http://soft.phpcms.cn</td>
		</tr>
      </table> 
<br><br>
<input name='channel[islink]' id='islink' type='radio' value='1' <?php if($islink){ ?>checked <?php }else{ ?>disabled <?php } ?> onClick="channelsetting.style.display='none'"><font color=blue><b>外部频道</b></font><br>&nbsp;&nbsp;&nbsp;&nbsp;外部频道指链接到本系统以外的地址中。当此频道准备链接到网站中的其他系统时，请使用这种方式。<br>&nbsp;&nbsp;&nbsp;&nbsp;
链接地址：<input name='channel[linkurl]' type='text' id='linkurl' size='40' maxlength='200' <?php if(!$islink){?>readonly<?php }else{ ?>value='<?=$linkurl?>'<?php }?>> <?php if($islink){ ?><?=$page_select?><?php } ?>
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
	  	<span id="templateid"></span>
	  </td>
    </tr>
  </tbody>

  <tbody id='Tabs1' style='display:none'>
      <th colspan=2>权限设置</th>
    <tr>
      <td width='30%' class='tablerow'><strong>频道权限：</strong><br><font color='red'>频道权限为继承关系，当频道设为“认证频道”时，其下的栏目设为“开放栏目”也无效。相反，如果频道设为“开放频道”，其下的栏目可以自由设置权限。</font></td>
      <td class='tablerow'>
     <table>
     <tr><td width='80' valign='top'><input type='radio' name='channel[enablepurview]' value='0'  <?php if($enablepurview==0){ ?>checked <?php } ?>>开放频道</td>
	 <td>任何人（包括游客）可以浏览此频道下的信息。可以在栏目设置中再指定具体的权限。</td></tr>
     <tr><td width='80' valign='top'><input type='radio' name='channel[enablepurview]' value='1' <?php if($enablepurview==1){ ?>checked <?php } ?>>认证频道</td>
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
      <td width='30%' class='tablerow'><strong>频道首页是否生成html</strong></td>
      <td class='tablerow'>
      <input type='radio' name='channel[ishtml]' value='1' <?php if($ishtml==1){ ?>checked <?php } ?>> 是
      <input type='radio' name='channel[ishtml]' value='0' <?php if($ishtml==0){ ?>checked <?php } ?>> 否
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>栏目列表分页url规则(生成html)</strong></td>
      <td class='tablerow'>
	  <?=$cat_html_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>内容分页url规则(生成html)</strong></td>
      <td class='tablerow'>
	  <?=$item_html_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>专题页url规则(生成html)</strong></td>
      <td class='tablerow'>
	  <?=$special_html_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>栏目列表分页url规则(不生成html)</strong></td>
      <td class='tablerow'>
	  <?=$cat_php_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>内容分页url规则(不生成html)</strong></td>
      <td class='tablerow'>
	  <?=$item_php_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>专题页url规则(不生成html)</strong></td>
      <td class='tablerow'>
	  <?=$special_php_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>把以上设置应用到栏目、专题和信息</strong></td>
      <td class='tablerow'><input type="radio" name="createtype_application" value="1" /> 是 <input type="radio" name="createtype_application" value="0" checked /> 否</td>
    </tr>
  </tbody>
 </table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<input type="submit" name="dosubmit" value="保存设置">
	</td>
  </tr>
</table>
</form>
</body>
</html>