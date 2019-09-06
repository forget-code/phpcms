<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">促销信息首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&job=manage">促销管理</a>  </td>
    <td class="tablerow" align="right"><?php echo $category_jump; ?>
	</td>
  </tr>
</table>
<form action="" method="post" name="myform" >
<BR>
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=8>促销信息管理</th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="40" class="tablerowhighlight">排序</td>
<td width="150" class="tablerowhighlight">所属栏目</td>
<td class="tablerowhighlight">标题</td>
<td class="tablerowhighlight">企业名称</td>
<td width="40" class="tablerowhighlight">点击</td>
<td width="70" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($products)) foreach($products AS $product) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' ondblclick="$('product_<?=$product['productid']; ?>').checked = ($('product_<?=$product['productid']; ?>').checked ? false : true);">

<td><input name="productid[]" type="checkbox" value="<?=$product['productid']?>" id="product_<?=$product['productid']?>"></td>
<td><?=$product['productid']?></td>
<td><input name='listorder[<?=$product['productid']?>]' type='input' value='<?=$product['listorder']?>' size="3" /></td>
<td><a href="<?=$MOD['linkurl']?><?=$TRADE[$product['catid']]['linkurl']?>" target="_blank"><?=$TRADE[$product['catid']]['tradename']?></a></td>

<td align="left"><a href="<?=$product['linkurl']?>" target="_blank"><span style="<?=$product['style']?>"><?=$product['title']?></span></a>
<?php if($product['thumb']) { ?> <font color="blue">[图]</font><?php } ?>
<?php if($product['status']==5) { ?> <font color="blue"><I>荐</I></font><?php } ?>
</td>

<td><a href="<?=$product['domain']?>" target="_blank" alt="作者：<font color='#ff0000'><?=$product['username']?></font>&nbsp;&nbsp;添加时间：<font color='#ff0000'><?=$product['addtime']?></font>&#10;&nbsp;&nbsp;编辑：<?=$product['editor']?>&nbsp;&nbsp;编辑时间：<?=$product['edittime']?> &#10;&nbsp;&nbsp;审核：<font color='#006600'><?=$product['checker']?></font>&nbsp;&nbsp;审核时间：<font color='#006600'><?=$product['checktime']?></font>"><?=$product['companyname']?></a></td>
<td><?=$product['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&productid=<?=$product['productid']?>&companyid=<?=$product['companyid']?>" title="编辑产品">编辑</a>
</td>
</tr>
<? } ?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1">
   <tr>
    <td width="100"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
	<input type='submit' value='更新排序' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listorder'" >
	<input type='submit' value='生成静态' onClick="document.myform.action='?mod=<?=$mod?>&file=createhtml_company&job=<?=$file?>&action=showhtml'">
	<input type='submit' value='更新地址' onClick="document.myform.action='?mod=<?=$mod?>&file=updateurls&action=sales'">
	<input type='submit' value='推荐促销' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=5'">
	<input type='submit' value='取消促销' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=3'">
	<input type='submit' value='删除促销' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=-1'">
</td>
  </tr>
</table>
</form>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>
<br />
<table width="100%" cellpadding="0" cellspacing="0" class="tableborder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow" align="center">
	<input name='mod' type='hidden' value='<?=$mod?>'>
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='catid' type='hidden' value='<?=$catid?>'>
	<input name='keyword' type='text' size='20' value='<?if(isset($keyword)){echo $keyword;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<?php echo $category_select; ?>
	<select name="ordertype">
	<option value="0" <?if($ordertype==0){?>selected<?}?>>按产品ID降序</option>
	<option value="1" <?if($ordertype==1){?>selected<?}?>>按产品ID升序</option>
	<option value="2" <?if($ordertype==2){?>selected<?}?>>按更新时间降序</option>
	<option value="3" <?if($ordertype==3){?>selected<?}?>>按更新时间升序</option>
	<option value="4" <?if($ordertype==4){?>selected<?}?>>按浏览次数降序</option>
	<option value="5" <?if($ordertype==5){?>selected<?}?>>按浏览次数升序</option>
	</select>&nbsp;
	<input name='pagesize' type='text' size='3' value='<?if(isset($pagesize)){echo $pagesize;}?>' title="每页显示的数据数目,最大值为500" maxlength="3"> 条数据/页
	<input type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>

<SCRIPT LANGUAGE="JavaScript">
<!--
tPopWait=20;
showPopStep=10;
popOpacity=85;

sPop=null;
curShow=null;
tFadeOut=null;
tFadeIn=null;
tFadeWaiting=null;

document.write("<style type='text/css'id='defaultPopStyle'>");
document.write(".cPopText { font-family: Verdana, Tahoma; background-color: #F7F7F7; border: 1px #000000 solid; font-size: 11px; padding-right: 4px; padding-left: 4px; height: 20px; padding-top: 2px; padding-bottom: 2px; filter: Alpha(Opacity=0)}");

document.write("</style>");
document.write("<div id='popLayer' style='position:absolute;z-index:1000;' class='cPopText'></div>");


function showPopupText(){
var o=event.srcElement;
MouseX=event.x;
MouseY=event.y;
if(o.alt!=null && o.alt!="") { o.pop=o.alt;o.alt="" }
if(o.title!=null && o.title!=""){ o.pop=o.title;o.title="" }
if(o.pop) { o.pop=o.pop.replace("\n","<br>"); o.pop=o.pop.replace("\n","<br>"); }
if(o.pop!=sPop) {
sPop=o.pop;
clearTimeout(curShow);
clearTimeout(tFadeOut);
clearTimeout(tFadeIn);
clearTimeout(tFadeWaiting);	
if(sPop==null || sPop=="") {
popLayer.innerHTML="";
popLayer.style.filter="Alpha()";
popLayer.filters.Alpha.opacity=0;	
} else {
if(o.dyclass!=null) popStyle=o.dyclass 
else popStyle="cPopText";
curShow=setTimeout("showIt()",tPopWait);
}
}
}

function showIt() {
popLayer.className=popStyle;
popLayer.innerHTML='<BR>&nbsp;&nbsp;'+sPop+'&nbsp;&nbsp;<BR><BR>';
popWidth=popLayer.clientWidth;
popHeight=popLayer.clientHeight;
if(MouseX+12+popWidth>document.body.clientWidth) popLeftAdjust=-popWidth-24
else popLeftAdjust=0;
if(MouseY+12+popHeight>document.body.clientHeight) popTopAdjust=-popHeight-24
else popTopAdjust=0;
popLayer.style.left=MouseX+12+document.body.scrollLeft+popLeftAdjust;
popLayer.style.top=MouseY+12+document.body.scrollTop+popTopAdjust;
popLayer.style.filter="Alpha(Opacity=0)";
fadeOut();
}

function fadeOut(){
if(popLayer.filters.Alpha.opacity<popOpacity) {
popLayer.filters.Alpha.opacity+=showPopStep;
tFadeOut=setTimeout("fadeOut()",1);
}
}

document.onmouseover=showPopupText;	
//-->
</SCRIPT>
</body>
</html>
