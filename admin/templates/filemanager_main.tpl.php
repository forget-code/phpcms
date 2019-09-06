<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<SCRIPT  type="text/javascript">
 function checkform(obj)
{
	if($(obj).value == "")
	{
		alert('内容为空，请填写');
		$(obj).focus();
		return false;
	}
	else return true;
}
</SCRIPT>
<SCRIPT  type="text/javascript">
var tipTimer;
function locateObject(n, d)
{
   var p,i,x;
   if (!d) d=document;
   if ((p=n.indexOf('?')) > 0 && parent.frames.length)
   {d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
   if (!(x=d[n])&&d.all) x=d.all[n]; 
   for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
   for (i=0;!x&&d.layers&&i<d.layers.length;i++) x=locateObject(n,d.layers[i].document); return x;
}
function ShowADPreview(ADContent)
{
  showTooltip('dHTMLADPreview',event, ADContent, '#ffffff','#000000','#000000','6000')
}
function showTooltip(object, e, tipContent, backcolor, bordercolor, textcolor, displaytime)
{
   window.clearTimeout(tipTimer)
   if (document.all) {
       locateObject(object).style.top=document.body.scrollTop+event.clientY+20
       locateObject(object).innerHTML='<table style="font-family:宋体; font-size: 9pt; border: '+bordercolor+'; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; background-color: '+backcolor+'" width="10" border="0" cellspacing="0" cellpadding="0"><tr><td nowrap><font style="font-family:宋体; font-size: 9pt; color: '+textcolor+'">'+unescape(tipContent)+'</font></td></tr></table> '
       if ((e.x + locateObject(object).clientWidth) > (document.body.clientWidth + document.body.scrollLeft)) {
           locateObject(object).style.left = (document.body.clientWidth + document.body.scrollLeft) - locateObject(object).clientWidth-10;
       } else {
           locateObject(object).style.left=document.body.scrollLeft+event.clientX
       }
       locateObject(object).style.visibility='visible';
       tipTimer=window.setTimeout("hideTooltip('"+object+"')", displaytime);
       return true;
   } else if (document.layers) {
       locateObject(object).document.write('<table width="10" border="0" cellspacing="1" cellpadding="1"><tr bgcolor="'+bordercolor+'"><td><table width="10" border="0" cellspacing="0" cellpadding="0"><tr bgcolor="'+backcolor+'"><td nowrap><font style="font-family:宋体; font-size: 9pt; color: '+textcolor+'">'+unescape(tipContent)+'</font></td></tr></table></td></tr></table>')
       locateObject(object).document.close()
       locateObject(object).top=e.y+20
       if ((e.x + locateObject(object).clip.width) > (window.pageXOffset + window.innerWidth)) {
           locateObject(object).left = window.innerWidth - locateObject(object).clip.width-10;
       } else {
           locateObject(object).left=e.x;
       }
       locateObject(object).visibility='show';
       tipTimer=window.setTimeout("hideTooltip('"+object+"')", displaytime);
       return true;
   } else {
       return true;
   }
}
function hideTooltip(object) {
    if (document.all) {
        locateObject(object).style.visibility = 'hidden';
        locateObject(object).style.left = 1;
        locateObject(object).style.top = 1;
        return false;
    } else {
        if (document.layers) {
            locateObject(object).visibility = 'hide';
            locateObject(object).left = 1;
            locateObject(object).top = 1;
            return false;
        } else {
            return true;
        }
    }
}
    </script>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
  <tr>
  <form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&currentdir=<?=$currentdir?>&dir=<?=$dir?>&action=newdir" onSubmit="return checkform('newdir');">
    <td>新目录：<input type="text" name="newdir" value="" id="newdir" size="16"> <input type="submit" name="dosubmit" value="确定"></td>
  </form>
  <form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&currentdir=<?=$currentdir?>&dir=<?=$dir?>&action=main" onSubmit="return checkform('newchangedir');">
    <td>转到目录：<input type="text" name="newchangedir" value="<?=$dir?>" id="newchangedir" size="25"> 
	<input type="submit" name="dosubmit" value="确定">
    相对路径以 <a href="#" onClick="javascript:$('#newchangedir').value='./';$('#newchangedir').focus();" title="添加./到转到目录"><font color="Blue">./</font></a> 开头，绝对路径以<a href="#" onClick="javascript:$('#newchangedir').val('<?=$rootpath?>');$('#newchangedir').focus();" title="添加<?=$rootpath?>到转到目录"><font color="Blue"><?=$rootpath?></font></a>开头&nbsp;&nbsp;&nbsp;<a href="?mod=<?=$mod?>&file=<?=$file?>&currentdir=<?=urlencode($currentdir)?>&dir=<?=urlencode($dir)?>&action=multiupload" title="同时上传多个文件到当前目录：<?=$currentdir?>"><strong><font color="Blue">多文件上传</font></strong></a></form></td>
  </tr>
  <tr>
  <form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=newfile"  onsubmit="return checkform('newfile');">
  <input type="hidden" name="currentdir" value="<?=$currentdir?>">
    <input type="hidden" name="dir" value="<?=$dir?>">
    <td>新文件：<input type="text" name="newfile" value="" id="newfile" size="16"> <input type="submit" name="dosubmit" value="确定"></td>
    </form>
    <form method="post" name="myform" enctype="multipart/form-data" action="?mod=<?=$mod?>&file=<?=$file?>&currentdir=<?=$currentdir?>&dir=<?=$dir?>&action=uploadfile">
    <td colspan="2">
    上传文件：<input type="file" name="uploadfile" id="uploadfile" size="12"> &nbsp;&nbsp;
    覆盖已有<input type="checkbox" name="overfile"> &nbsp;
    新文件名：<input type="text" name="newname" value="" id="newname" size="10">(留空保持不变)&nbsp;&nbsp;
    <input type="hidden" name="currentdir" value="<?=$currentdir?>">
    <input type="hidden" name="dir" value="<?=$dir?>">
    <input type="submit" name="dosubmit" value="上传"> </td>
    </form>
  </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption style="text-align:left;padding-left:10px">当前目录：<?=$currentdir?>&nbsp;&nbsp;<?=$writeable?></caption>
  <tr>
    <th colspan="8" class="align_l">&nbsp;&nbsp;<a href="?mod=<?=$mod?>&file=<?=$file?>&dir=<?=$dir?>../"><img src="images/filemanager/parent.gif" />返回上级目录</a>
    &nbsp;&nbsp;&nbsp;&nbsp;<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main"><img src="admin/skin/images/pos.gif" /> 返回主目录</a>
    </th>
</tr>
    <tr>
        <th><strong>名称</strong></th>
        <th width="8%"><strong>大小</strong></th>
        <th width="20%"><strong>创建时间</strong></th>
        <th width="20%"><strong>修改时间</strong></th>
        <th width="5%"><strong>属性</strong></th>
        <th width="20%"><strong>管理操作</strong></th>
    </tr>
<?php
foreach ($dirs as $dirrow)
{
?>
  <tr>
    <td>&nbsp;&nbsp;<img src="images/filemanager/folder.gif" /> <a href="?mod=<?=$mod?>&file=<?=$file?>&dir=<?=$dir.$dirrow['name']?>/" title="进入该文件夹"><?=$dirrow['name']?></a></td>
	<td class="align_c"><?=$dirrow['size']?></td>
	<td class="align_c"><?=$dirrow['createtime']?></td>
	<td class="align_c"><?=$dirrow['modifytime']?></td>
	<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=chmod&fname=<?=urlencode($currentdir)?>/<?=$dirrow['name']?>&isdir=1&dir=<?=$dir?>" title="点击更改目录属性"><?=$dirrow['dirperm']?></a></td>
	<td class="align_c">
	<?php if(isset($zip)){?><a href="javascript:if(confirm('确认压缩该文件夹吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=zipdir&fname=<?=urlencode($currentdir)?>/<?=$dirrow['name']?>/&isdir=1&dir=<?=$dir?>'">压缩</a> <?php } ?>
	<a href="javascript:if(confirm('确认要删除目录：<?=$dirrow['name']?> 吗？删除此目录后其子目录及文件均会删除，请确认')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&fname=<?=urlencode($currentdir)?>/<?=$dirrow['name']?>/&isdir=1&dir=<?=$dir?>'">删除</a>
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=rename&fname=<?=urlencode($currentdir)?>/<?=$dirrow['name']?>&isdir=1&dir=<?=$dir?>">改名</a>
	</td>
</tr>
<?php
}
?>
  <tr>
    <tdcolspan="8"><img height="1" src="images/dot.gif" width="100%"></td>
</tr>
<?php
foreach ($files as $filerow)
{
?>
  <tr  class="mout" onMouseOver="this.className='mover';ShowADPreview('<?=$filerow['preview']?>');" onMouseOut="this.className='mout';hideTooltip('dHTMLADPreview');">
	<td style="text-align:left"><img src="<?php echo 'images/ext/'.$filerow['fileext'].'.gif';?>" width="24" height="20" title="<?=$filetype[$filerow['fileext']]?>" /> <a href="<?=$filerow['filepath'];?>" target="_blank"><?=$filerow['name']?></a></td>
	<td class="align_c"><?=$filerow['size']?> KB</td>
	<td class="align_c"><?=$filerow['createtime']?></td>
	<td class="align_c"><?=$filerow['modifytime']?></td>
	<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=chmod&fname=<?=urlencode($currentdir)?>/<?=urlencode($filerow['name'])?>&isdir=0&dir=<?=$dir?>" title="点击更改该文件属性"><?=$filerow['fileperm']?></a></td>
	<td class="align_c">
	 <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&fname=<?=urlencode($currentdir)?>/<?=urlencode($filerow['name'])?>&dir=<?=$dir?>">编辑</a> 
	 <a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&fname=<?=urlencode($currentdir)?>/<?=urlencode($filerow['name'])?>">下载</a>
	 <a href="javascript:if(confirm('确认要删除<?=$filerow['name']?>吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&fname=<?=urlencode($currentdir)?>/<?=urlencode($filerow['name'])?>&isdir=0&dir=<?=$dir?>'">删除</a>
	 <a href="?mod=<?=$mod?>&file=<?=$file?>&action=rename&fname=<?=urlencode($currentdir)?>/<?=urlencode($filerow['name'])?>&isdir=0&dir=<?=$dir?>">改名</a>
	 </td>
</tr>
<?php
}
?>
  <tr>
    <tdcolspan="8">&nbsp;共<?=$dirnum?>个目录，<?=$fnum?>个文件</td>
</tr>
</table>
</body>
</html>