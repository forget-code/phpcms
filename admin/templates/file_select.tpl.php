<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<base target='_self'>
<body leftmargin='2' topmargin='0' marginwidth='0' marginheight='0'>
    <form name='myform' method='Post' action='?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&parentdir=<?=$parentdir?>&currentdir=<?=$currentdir?>&realdir=<?=$realdir?>'>
<Script Language="JavaScript">
function reSort(which)
{
document.myform.sortby.value = which;
document.myform.submit();
}
</Script>
<br>
<table width='100%' border='0' cellspacing='0' cellpadding='0' >
<tr>
<td>当前目录：./<?=$thisdir?></td>
<td align='right'>
<?php if($currentdir){ ?>
<a href='?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&type=<?=$type?>&parentdir=<?=$backparentdir?>&currentdir=<?=$parentdir?>&realdir=<?=$realdir?>'>↑返回上级目录</a>
<?php } ?>
</td>
</tr>
</table>
  <table width="100%" align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan="4">文件选择</th>
    <tr>
    <td height='18' class="tablerowhighlight" >&nbsp;&nbsp;文件名&nbsp;&nbsp;</td>
    <td width='55' class="tablerowhighlight" align="center">大小</td>
    <td width='80' class="tablerowhighlight" >&nbsp;类型&nbsp;&nbsp;</td>
    <td width='140' class="tablerowhighlight" align="center">上次修改时间&nbsp;&nbsp;</td>
    </tr>
<?php
if(is_array($listdirs))
{
	foreach($listdirs as $ldir)
	{
?>
<tr onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgcolor="#F1F3F5">
<td align='left' height='20'><img src='images/ext/dir.gif'>
<a href='?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&type=<?=$type?>&parentdir=<?=$currentdir?>&currentdir=<?=$ldir['path']?>&realdir=<?=$realdir?>'><?=$ldir['name']?></a></td>
 <td align='right'><?=$ldir['size']?>&nbsp;</td>
 <td>&nbsp;<?=$ldir['type']?></td>
 <td><?=$ldir['mtime']?></td>
</tr>
<?php
       }
}
?>

<?php
if(is_array($listfiles))
{
	foreach($listfiles as $lfile)
	{
?>
<tr onMouseOut="this.style.backgroundColor='#F1F3F5';hideTooltip('dHTMLADPreview');" onMouseOver="this.style.backgroundColor='#BFDFFF';ShowADPreview('<?=$lfile['preview']?>');" bgcolor="#F1F3F5">
<td align='left' height='20'><?php if($type!="thumb"){ ?><img src='<?=PHPCMS_PATH?>images/ext/<?=$lfile['ext']?>.gif' width='24' height='24'><?php } ?><a href='#' onClick="window.returnValue='<?=$lfile['path']?>|<?=$lfile['size']?>|<?=PHPCMS_PATH?>|<?=$lfile['ext']?>.gif';window.close();"><?=$lfile['name']?></a>
| <a href="<?=$PHPCMS['siteurl']?>corpandresize/ui.php?<?php echo $PHPCMS['siteurl'].$lfile['path'];?>"><strong>剪切图片</strong></a></td>
 <td><?=$lfile['size']?>&nbsp;K</td>
 <td>&nbsp;<?=$lfile['type']?></td>
 <td><?=$lfile['mtime']?></td>
</tr>
<?php
       }
}
?>
    </table>
<input type='hidden' name='priorsort' value='0'>
<input type='hidden' name='sortby' value='-1'>
<div id=dHTMLADPreview style='Z-INDEX: 1000; LEFT: 0px; VISIBILITY: hidden; WIDTH: 10px; POSITION: absolute; TOP: 0px; HEIGHT: 10px'></DIV><SCRIPT language = 'JavaScript'>
<!--
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
//-->
</SCRIPT>
    </form>
<table cellpadding='0' cellspacing='0' border='0' width='100%' height='10'>
<tr>
<td ></td>
</tr>
</table>
</body>
</html>