<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>管理信息</caption>
  <tr>
    <td><a href='?mod=yp&file=template' >公司模板管理</a> | <a href='?mod=yp&file=template&action=add' ><font color="#ff0000">添加模板风格</font></a></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="table_list">
    <caption>公司模板设置</caption>
 <tr align="center">
<td width="7%" class="tablerowhighlight">默认</td>
<td width="11%" class="tablerowhighlight">中文名</td>
<td width="15%" class="tablerowhighlight">模板类型</td>
<td width="60%" class="tablerowhighlight">使用权限</td>
</tr>
<?=$string?>
</table>


<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>