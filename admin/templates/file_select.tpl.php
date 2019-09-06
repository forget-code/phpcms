<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<base target='_self'>
<body leftmargin='2' topmargin='0' marginwidth='0' marginheight='0'>
    <form name='myform' method='Post' action='?mod=<?=$mod?>&file=<?=$file?>&catid=<?=$catid?>&parentdir=<?=$parentdir?>&currentdir=<?=$currentdir?>&realdir=<?=$realdir?>&isimage=<?=$isimage?>'>
<Script Language="JavaScript">
function reSort(which)
{
	document.myform.sortby.value = which;
	document.myform.submit();
}
</Script>
<script language = 'javascript'>
<!--
var tipTimer;
function com_event(evt)
{
	evt=evt?evt:(window.event?window.event:null);
	return evt;
}

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
function showTooltip(object, event, tipContent, backcolor, bordercolor, textcolor, displaytime)
{
   window.clearTimeout(tipTimer);
   if (document.all) {
       locateObject(object).style.top=document.body.scrollTop+event.clientY+20;
       locateObject(object).innerHTML='<table style="font-family:宋体; font-size: 9pt; border: '+bordercolor+'; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; background-color: '+backcolor+'" width="10" border="0" cellspacing="0" cellpadding="0"><tr><td nowrap><font style="font-family:宋体; font-size: 9pt; color: '+textcolor+'">'+unescape(tipContent)+'</font></td></tr></table> ';
       if ((event.x + locateObject(object).clientWidth) > (document.body.clientWidth + document.body.scrollLeft)) {
           locateObject(object).style.left = (document.body.clientWidth + document.body.scrollLeft) - locateObject(object).clientWidth-10;
       } else {
           locateObject(object).style.left=document.body.scrollLeft+event.clientX;
       }
       locateObject(object).style.visibility='visible';
       tipTimer=window.setTimeout("hideTooltip('"+object+"')", displaytime);
       return true;
   } else if (document.layers) {
       locateObject(object).document.write('<table width="10" border="0" cellspacing="1" cellpadding="1"><tr bgcolor="'+bordercolor+'"><td><table width="10" border="0" cellspacing="0" cellpadding="0"><tr bgcolor="'+backcolor+'"><td nowrap><font style="font-family:宋体; font-size: 9pt; color: '+textcolor+'">'+unescape(tipContent)+'</font></td></tr></table></td></tr></table>')
       locateObject(object).document.close()
       locateObject(object).top=event.y+20;
       if ((event.x + locateObject(object).clip.width) > (window.pageXOffset + window.innerWidth)) {
           locateObject(object).left = window.innerWidth - locateObject(object).clip.width-10;
       } else {
           locateObject(object).left=event.x;
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
</script>
<br>
<table width='100%' border='0' cellspacing='0' cellpadding='0' >
<tr>
<td>当前目录：./<?=$currentdir?></td>
<td align='right'>
<?php if($currentdir){ ?>
<a href='?mod=<?=$mod?>&file=<?=$file?>&catid=<?=$catid?>&type=<?=$type?>&parentdir=<?=$backparentdir?>&currentdir=<?=$parentdir?>&realdir=<?=$realdir?>&isimage=<?=$isimage?>'>↑返回上级目录</a>
<?php } ?>
</td>
</tr>
</table>
  <table cellpadding="0" cellspacing="1" class="table_list">
  <caption>文件选择</caption>
    <tr>
    <th class="align_c">文件名</th>
    <th>大小</th>
   <?php if(is_array($listfiles) && !empty($listfiles)) echo "<th>尺寸</th>";?>
    <th class="align_c">类型</th>
    <th>上次修改时间</th>
    </tr>
<?php
if(is_array($listdirs))
{
	foreach($listdirs as $ldir)
	{
?>
<tr>
<td align='left' height='20'><img src='images/ext/dir.gif'>
<a href='?mod=<?=$mod?>&file=<?=$file?>&catid=<?=$catid?>&type=<?=$type?>&parentdir=<?=$currentdir?>&currentdir=<?=$ldir['path']?>&realdir=<?=$realdir?>&isimage=<?=$isimage?>'><?=$ldir['name']?></a></td>
 <td width='55' class="align_c"><?=$ldir['size']?>&nbsp;</td>
 <td class="align_c">&nbsp;<?=$ldir['type']?></td>
 <td width='140' class="align_c"><?=$ldir['mtime']?></td>
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
<tr>
<td align='left' height='20'><?php if($type!="thumb"){ ?><img src='images/ext/<?=$lfile['ext']?>.gif' width='24' height='24'><?php } ?><a href='#' onClick="window.returnValue='<?=$lfile['path']?>|<?=$lfile['size']?>';window.close();"><?=$lfile['name']?></a></td>
 <td width='60' class="align_c"><?=$lfile['size']?>&nbsp;K</td>
  <?php if(is_array($listfiles)) echo "<td width='60' class='align_c'>$lfile[imagesize]</td>";?>
 <td width='180' class="align_c">&nbsp;<?=$lfile['type']?></td>
 <td width='140' class="align_c"><?=$lfile['mtime']?></td>
</tr>
<?php
       }
}
?>
    </table>
<input type='hidden' name='priorsort' value='0'>
<input type='hidden' name='sortby' value='-1'>
<div id='dHTMLADPreview' style='Z-INDEX: 1000; LEFT: 0px; VISIBILITY: hidden; WIDTH: 10px; POSITION: absolute; TOP: 0px; HEIGHT: 10px'></div>
</form>
<table cellpadding='0' cellspacing='0' border='0' width='100%' height='10'>
<tr>
<td></td>
</tr>
</table>
</body>
</html>