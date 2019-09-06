<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header1');
?>
<script language='JavaScript'>
function ShowOutHidden()
{
	var obj = document.getElementById("outhiddentable");
	var objimg = document.getElementById("outhiddenimg");
	if(obj.style.display=="none")
	{
		obj.style.display = "block";
		objimg.src="<?=PHPCMS_PATH?>images/icon/open.gif";
	}
	else
	{
		obj.style.display="none";
		objimg.src="<?=PHPCMS_PATH?>images/icon/close.gif";
	}
}
</script>
<style type="text/css">
<!--
.style1 {color: #0000FF}
-->
</style>
<body>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<form method="post" name="myform">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1"  class="table_form">
<caption>数据发布:  建立标签与数据库对应关系</caption>
<tr align="center">
<td class="tablerowhighlight">数据库字段</td>
<td width="30%" class="tablerowhighlight">数据库字段说明</td>
<td width="40%" class="tablerowhighlight">标签字段（采集填充结果）</td>
</tr>
<tr align="center">
<td colspan="3"><div align="left" class="style1">所属内容模型：<?=$modelname?>&nbsp;&nbsp;&nbsp;&nbsp;发布栏目：<?=$job_CatName?></div></td>
</tr>
<?php 
//$expArray = array('contentid');
foreach($dbFields as $fieldName => $fieldRow)
{
	if(in_array($fieldName,array('contentid'))) continue;
?>
<tr align="center"  onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#ffffff'>
<td><?=$fieldName?></td>
<td><?=$fieldRow['name']?><?
if($fieldRow['minlength'] || $fieldRow['pattern']){
		echo '(<font color=red align=right>*</font>)';
}
?></td>
<td><?php
$findtag = false;
$haveSelect = true;
foreach($rule['publish'] as $index=>$item)
{
	if($item==$fieldName)
	{
		echo '<input style="width:220px;height:20px;z-index:99;" value="[标签:'.$index.']" name="publish['.$item.']" id="publish['.$item.']" >';
		$findtag = true;
		break;
	}
}
if(!$findtag)
{
	if($fieldName =='catid')
	{
		$haveSelect = false;
		$val = $job_CatId;
		echo '<input style="width:220px;height:20px;" value="'.$job_CatId.'" name="publish['.$fieldName.']" readonly>';
	}elseif($fieldName =='inputtime' ||$fieldName =='updatetime' )
	{
		echo '<input style="width:220px;height:20px;" value="'.$options['system_time'].'" name="publish['.$fieldName.']" readonly>';
	}elseif($fieldName =='userid')
	{
		echo '<input style="width:220px;height:20px;" value="'.$options['current_user'].'" name="publish['.$fieldName.']" readonly>';
	}elseif($fieldName =='titleintact')
	{
		echo '<input style="width:220px;height:20px;" value="[标签:标题]" name="publish['.$fieldName.']" readonly>';
	}elseif($fieldName =='thumb'&&$job_SpiderRule!='')
	{
		echo '<input style="width:220px;height:20px;" value="[标签:缩略图]" name="publish['.$fieldName.']" readonly>';
	}
	else
	{
		$matchtag = false;
		foreach($options as $op)
		{
			if(strpos($op,$fieldRow['name'])>0)
			{
				$matchtag = true;
				echo '<input style="width:220px;height:20px;z-index:99;" value="'.$op.'" name="publish['.$fieldName.']" id="publish['.$fieldName.']" >';
				break;
			}
		}
		if(!$matchtag)echo '<input style="width:220px;height:20px;" value="" name="publish['.$fieldName.']" >';
	}
}
if($haveSelect)
{
?><span style="position:absolute;margin:1px 1px 1px -6px"><select style="margin-left:-202px;width:220px;" id="uinSelector<?=$fieldName?>" onchange="document.getElementById('publish[<?=$fieldName?>]').value=value;"><?=$option?></select></span>
<?
}
?>
</td>
</tr>
<?php
}
?>
</table>
<table cellpadding="2" cellspacing="1"  class="table_form">
<tr align="center">
<td colspan="3" class="tablerowhighlight">附加点击信息</td>
</tr>
<tr align="center">
<td>hits</td>
<td width="30%" >总点击数</td>
<td width="40%" ><input style="width:220px;height:20px;" value="[随机数:0至1000]" name="att[hits]" ></td>
</tr>
<tr align="center">
<td>hits_day</td>
<td>本日点击数</td>
<td><input style="width:220px;height:20px;" value="[随机数:0至1000]" name="att[hits_day]" ></td>
</tr>
<tr align="center">
<td>hits_week</td>
<td>本周点击数</td>
<td><input style="width:220px;height:20px;" value="[随机数:0至1000]" name="att[hits_week]" ></td>
</tr>
<tr align="center">
<td>hits_month</td>
<td>本月点击数</td>
<td><input style="width:220px;height:20px;" value="[随机数:0至1000]" name="att[hits_month]" ></td>
</tr>
<tr>
<td colspan=2 align="right"><b>每轮发布记录数</b></td>
<td  align="left"><input style="width:220px;height:20px;" value="50" name="publimit" ></td>
</tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0" class="table_form">
  <tr>
  <td width="400">
  <input type="hidden" name="art[catid]" value="<?=$job_CatId?>">
  <input type="checkbox" name="ckset[ckdeletepre]" id="ckdeletepre" value="1" checked>发布成功后删除采集内容
  <input type="checkbox" name="ckset[ckbacksort]" id="ckbacksort" value="1" checked>倒序发布
  <input type="checkbox" name="ckset[ishtml]" id="ckcktitle" value="1" checked>生成html(发布速度慢!)
  </td>
    <td align="center">
<input type="submit" name="submit" value="发布内容" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=spideradd&jobid=<?=$jobid?>'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr></form>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" border="0" align=center class="table_info" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	  <p>采集内容发布功能，请注意对照数据字段对照关系</p>    </td>
  </tr>
</table>
</body>
</html>