<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">企业招聘首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&job=manage">审核招聘</a>  </td>
	</td>
  </tr>
</table>
<form action="" method="post" name="myform" >
<BR>
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=9>审核招聘</th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="120" class="tablerowhighlight">所属岗位</td>
<td class="tablerowhighlight">职位名称</td>
<td width="100" class="tablerowhighlight">招聘单位</td>
<td width="40" class="tablerowhighlight">性质</td>
<td width="40" class="tablerowhighlight">学历</td>
<td width="40" class="tablerowhighlight">点击</td>
<td width="70" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($jobs)) foreach($jobs AS $job) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' ondblclick="$('job_<?=$job['jobid']; ?>').checked = ($('job_<?=$job['jobid']; ?>').checked ? false : true);">

<td><input name="jobid[]" type="checkbox" value="<?=$job['jobid']?>" id="job_<?=$job['jobid']?>"></td>
<td><?=$job['jobid']?></td>
<td><?=$job['station']?></td>

<td align="left"><a href="<?=$job['linkurl']?>" target="_blank" ><span style="<?=$job['style']?>"><?=$job['title']?></span></a>
<?php if($job['status']==5) { ?> <font color="blue">荐</font><?php } ?>
</td>

<td><a href="<?=$job['domain']?>" target="_blank" alt="信息发布企业：<?=$job['companyname']?>&#10;&nbsp;&nbsp;作者：<font color='#ff0000'><?=$job['username']?></font>&nbsp;&nbsp;添加时间：<font color='#ff0000'><?=$job['addtime']?></font>&#10;&nbsp;&nbsp;编辑：<?=$job['editor']?>&nbsp;&nbsp;编辑时间：<?=$job['edittime']?> &#10;&nbsp;&nbsp;审核：<font color='#006600'><?=$job['checker']?></font>&nbsp;&nbsp;审核时间：<font color='#006600'><?=$job['checktime']?></font>"><?=$job['unit']?></a></td>
<td><?=$job['worktype']?></td>
<td><?=$job['degree']?></td>
<td><?=$job['hits']?></td>
<td>
<input name='listorder[<?=$job['jobid']?>]' type='hidden' value='' />
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&jobid=<?=$job['jobid']?>&companyid=<?=$job['companyid']?>" title="编辑招聘">编辑</a>
</td>
</tr>
<? } ?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1">
   <tr>
    <td width="100"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
	<input type='submit' value='通过审核' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=3'">
	<input type='submit' value='删除招聘' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=-1'">
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
	<select name="srchtype">
	<option value="0" <?if(!$srchtype){?>selected<?}?>>按职位名称</option>
	<option value="1" <?if($srchtype){?>selected<?}?>>按招聘单位</option>
	</select>
	<input name='keyword' type='text' size='20' value='<?if(isset($keyword)){echo $keyword;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<?php echo $station_select; ?>
	<select name="ordertype">
	<option value="0" <?if($ordertype==0){?>selected<?}?>>按招聘ID降序</option>
	<option value="1" <?if($ordertype==1){?>selected<?}?>>按招聘ID升序</option>
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
