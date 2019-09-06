<?php include admintpl('header');?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">图片首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&job=check&channelid=<?=$channelid?>">审核图片</a> &gt;&gt;  图片预览 &gt;&gt; <a href="<?=$linkurl?>" target="_blank"><?=$title?></a></td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2">图片预览</th>
  </tr>
  <tr>
    <td class="tablerow" width="15%"><b>栏目</b></td>
	<td class="tablerow"><?=$catname?></td>
  </tr>
  <tr>
    <td class="tablerow" width="15%"><b>标题</b></td>
	<td class="tablerow"><?=$title?></td>
  </tr>
  <tr>
    <td class="tablerow"><b>发布日期</b></td>
    <td class="tablerow"><?=$adddate?></td>
  </tr>

  <tr>
    <td class="tablerow"><b>标题图片</b></td>
    <td class="tablerow"><a href="<?=$thumb?>" target="_blank" onmouseover="ShowADPreview('<img src=<?=$thumb?> border=0>');"><?=$thumb?></a></td>
  </tr>
  <tr>
    <td class="tablerow"><b>简介</b></td>
    <td class="tablerow"><?=$introduce?></td>
  </tr>
   <tr>
    <td class="tablerow"><b>图片地址</b></td>
    <td class="tablerow">
	<? if(is_array($pictureurls))  foreach($pictureurls AS $p) { ?>

	<a href="<?=$p['src']?>" target="_blank" onmouseover="ShowADPreview('<img src=<?=$p['src']?> border=0>');"><?=$p['src']?> <?=$p['alt']?></a><br/>

	<? } ?>
	</td>
  </tr>
    <?php if(is_array($fields)) foreach($fields as $f) {?>
    <tr>
    <td class="tablerow"><b><?=$f['title']?></b></td>
    <td class="tablerow"><?=$f['value']?></td>
  </tr>
  <?php } ?>
<td align="right" class="tablerow" colspan="2"><a href="javascript:history.go(-1);"><font color="red">返 回 上 一 步</font></a>&nbsp;</td>
</tr>
</table>
<div id=dHTMLADPreview style='Z-INDEX: 1000; LEFT: 0px; VISIBILITY: hidden; WIDTH: 10px; POSITION: absolute; TOP: 0px; HEIGHT: 10px'></DIV>
<script type="text/javascript">
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
</script>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center></td>
  </tr>
</table>
</form>
</body>
</html>
