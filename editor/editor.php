<script type="text/javascript">
var PHPCMS_PATH = '<?php echo PHPCMS_PATH;?>';
var editorWidth = <?php echo $width;?>;
var editorHeight = <?php echo $height;?>;
var editorCss = '<?php echo $editorCss;?>';
var editorKeyid = '<?php echo $editorKeyid;?>';
var editorCharset = '<?php echo $CONFIG['charset'];?>';
var editorCid = '<?php echo $textareaid;?>';
var isIE = (document.all && window.ActiveXObject && !window.opera) ? true : false;
</script>

<link rel="stylesheet" type="text/css" href="<?php echo PHPCMS_PATH;?>editor/css/default.css">

<table cellspacing="0" cellpadding="2" class="tb">
<tbody id="ToolBar" oncontextmenu="return false">
<tr>
<td>
<img src="<?PHP echo PHPCMS_PATH;?>editor/images/new.gif" alt="新建" onclick="doNew()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/save.gif" alt="保存" onclick="FormatText('SaveAs')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/print.gif" alt="打印" onclick="FormatText('print')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/printpreview.gif" alt="打印预览" onclick="Preview()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/replace.gif" alt="查找替换" onclick="doReplace()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/undo.gif" alt="撤消" onclick="FormatText('undo')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/redo.gif" alt="恢复" onclick="FormatText('redo')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/selectall.gif" alt="全部选择" onclick="FormatText('selectall')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" >

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/unselect.gif" alt="取消选择" onclick="FormatText('unselect')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" >

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/cut.gif" alt="剪切" onclick="FormatText('cut')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" > 

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/copy.gif" alt="复制" onclick="FormatText('copy')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" >

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/paste.gif" alt="粘贴" onclick="FormatText('paste')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" >

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/delete.gif" alt="删除" onclick="FormatText('delete')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" >

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/clear.gif" alt="删除文字格式" onclick="FormatText('RemoveFormat')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/help.gif" alt="帮助" onclick="doHelp()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />
</td>
</tr>
<tr>
<td>
<select onchange="FormatText('fontname', this.value);" class="select" style="width:60px;">
<option selected>字体</option>
<option value="宋体">宋体</option>
<option value="楷体_GB2312">楷体</option>
<option value="新宋体">新宋体</option>
<option value="黑体">黑体</option>
<option value="隶书">隶书</option>
<option value="幼圆">幼圆</option>
<option value="Arial">Arial</option>
<option value="Tahoma">Tahoma</option>
<option value="Verdana">Verdana</option>
</select>

<select onChange="FormatText('fontsize',this.value);" class="select" style="width:50px;">
<option class="heading" selected>字号</option> 
<option value="7">一号</option> 
<option value="6">二号</option> 
<option value="5">三号</option>  
<option value="4">四号</option>  
<option value="3">五号</option>  
<option value="2">六号</option>  
<option value="1">七号</option>
</select>
<img src="<?PHP echo PHPCMS_PATH;?>editor/images/forecolor.gif" alt="文字颜色" onclick="FormatText('forecolor', PickColor())" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/backcolor.gif" alt="背景颜色" onclick="FormatText('backcolor', PickColor())" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/bold.gif" alt="粗体" onclick="FormatText('bold', '')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" /> 

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/italic.gif" alt="斜体" onclick="FormatText('italic', '')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/underline.gif" alt="下划线" onclick="FormatText('underline', '')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" /> 

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/Aleft.gif" onclick="FormatText('Justifyleft', '')" alt="左对齐"  onmouseover="this.className='ov';" onmouseout="this.className='ot';" /> 

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/Acenter.gif" alt="居中" onclick="FormatText('JustifyCenter', '')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" /> 

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/Aright.gif" alt="右对齐"  onclick="FormatText('JustifyRight', '')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" /> 

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/list.gif" alt="插入项目符号" onclick="FormatText('InsertUnorderedList', '')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/num.gif" alt="插入编号" onclick="FormatText('insertorderedlist', '')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />
</td>
</tr>
<tr>
<td>

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/url.gif" alt="插入超级链接" onclick="link()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/nourl.gif" alt="取消超级链接" onclick="FormatText('unLink')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/br.gif" alt="插入换行" onclick="Insert('<br/>')"  onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/paragraph.gif" alt="插入段落" onclick="Insert('<p>&nbsp;</p>')"  onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/line.gif" alt="插入普通水平线" onclick="FormatText('InsertHorizontalRule', '')"  onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/hr.gif" alt="插入特殊水平线" onclick="hr()"  onmouseover="this.className='ov';" onmouseout="this.className='ot';" /> 

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/fieldset.gif" alt="插入栏目框" onclick="fieldset()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/quote.gif" alt="插入引用" onclick="doQuote()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/marquee.gif" alt="插入滚动字幕" onclick="FormatText('InsertMarquee')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/iframe.gif" alt="插入网页" onclick="iframe()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/table.gif" alt="插入表格" onclick="table()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/flash.gif" alt="插入FLASH动画" onclick="swf()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/mv.gif" alt="插入媒体文件" onclick="mv()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/img.gif" alt="插入图片" onclick="pic()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />

<img src="<?PHP echo PHPCMS_PATH;?>editor/images/upfile.gif" alt="插入附件" onclick="att()" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />
<?php
if($CHA['module'] == 'article') { ?>
<img src="<?PHP echo PHPCMS_PATH;?>editor/images/addnext.gif" alt="插入分页符[next]" onclick="cc_Insert('[next]')" onmouseover="this.className='ov';" onmouseout="this.className='ot';" />
<?php
}
if($PHPCMS['cc_uid']) echo '<object width="86" height="22"><param name="wmode" value="transparent" /><param name="allowScriptAccess" value="always" /><param name="movie" value="http://union.bokecc.com/flash/plugin_'.$PHPCMS['cc_style'].'.swf?userID='.$PHPCMS['cc_uid'].'&type=Phpcms" /><embed src="http://union.bokecc.com/flash/plugin_'.$PHPCMS['cc_style'].'.swf?userID='.$PHPCMS['cc_uid'].'&type=Phpcms" type="application/x-shockwave-flash" width="86" height="22" allowScriptAccess="always"></embed></object>';
?>
</td>
</tr>
</tbody>
<tr>
<td>
<script type="text/javascript">
document.write ('<iframe id="EditorAREA" width="'+editorWidth+'" height="'+editorHeight+'"></iframe>')
var editor;
editor = $("EditorAREA").contentWindow;
editor.document.designMode = 'On';
editor.document.contentEditable = true;
editor.document.open();
editor.document.writeln('<html>');
editor.document.writeln('<http-equiv="Content-Type" content="text/html; charset='+editorCharset+'">');
editor.document.writeln('<link rel="stylesheet" type="text/css" href="<?php echo PHPCMS_PATH;?>editor/css/style.css">');
editor.document.writeln('<link rel="stylesheet" type="text/css" href="<?php echo PHPCMS_PATH;?>editor/css/editor.css">');
editor.document.writeln('<body>');
editor.document.writeln('</body>');
editor.document.writeln('</html>');
editor.document.close();
function setMode()
{
	if ($('Mode_Img').src.indexOf('design.gif') == -1) 
	{
		$('Mode_Img').src = '<?PHP echo PHPCMS_PATH;?>editor/images/design.gif';
		if(isIE)
		{
			editor.document.body.innerText=editor.document.body.innerHTML;
		}
		else
		{
			editor.document.body.textContent=editor.document.body.innerHTML;
		}
		$('ToolBar').style.display = 'none';
		$('EditorAREA').height = Number($('EditorAREA').height)+78;
	} 
	else
	{
		$('Mode_Img').src = '<?PHP echo PHPCMS_PATH;?>editor/images/code.gif';
		editor.document.body.innerHTML= isIE ? editor.document.body.innerText : editor.document.body.textContent;
		$('ToolBar').style.display = '';
		$('EditorAREA').height = Number($('EditorAREA').height)-78;
	}
	editor.focus();
}
$(editorCid).style.display = 'none';
if(isIE)
{
	document.myform.attachEvent("onsubmit", getData);
	editor.document.body.innerHTML = $(editorCid).value;
	editor.focus();
}
else
{
	//document.myform.addEventListener("submit", getData, false);
	setInterval("getData()",1000);
	$('ToolBar').style.display = 'none';
	window.onload = function()
	{
		editor.document.body.innerHTML = $(editorCid).value ? $(editorCid).value : '';
	}
}

function getData()
{
	try{ $(editorCid).value=editor.document.body.innerHTML; } catch(e){}
	if(isIE) clipboardData.setData('text', editor.document.body.innerHTML);
}
</script>
<script type="text/javascript" src="<?php echo PHPCMS_PATH;?>editor/js/pickcolor.js"></script>
<script type="text/javascript" src="<?php echo PHPCMS_PATH;?>editor/js/editor.js"></script>
</td>
</tr>
<tr oncontextmenu="return false">
<td valign="top">
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td onclick="setMode();" style="cursor:pointer;" width="60"><img src="<?PHP echo PHPCMS_PATH;?>editor/images/code.gif" valign="absmiddle" id="Mode_Img" /></td>
	<td onclick="Preview();" style="cursor:pointer;" width="60"><img src="<?PHP echo PHPCMS_PATH;?>editor/images/preview.gif" valign="absmiddle" alt="预览" /></td>

	<td align="right">
	<img src="<?PHP echo PHPCMS_PATH;?>editor/images/left.gif" style="cursor:e-resize;" alt="向左缩小" onclick="Zoom('left');" />
	<img src="<?PHP echo PHPCMS_PATH;?>editor/images/up.gif" style="cursor:n-resize;" alt="向上缩小" onclick="Zoom('up');" />
	<img src="<?PHP echo PHPCMS_PATH;?>editor/images/down.gif" style="cursor:n-resize;" alt="向下增大" onclick="Zoom('down');" />
	<img src="<?PHP echo PHPCMS_PATH;?>editor/images/right.gif" style="cursor:e-resize;" alt="向右增大" onclick="Zoom('right');" />
	</td>
	</tr>
	</table>
</td>
</tr>
</table>