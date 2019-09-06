<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
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
<table cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=10><a href="?mod=<?=$mod?>&file=<?=$file?>&action=outcontent"><font color="white">发布内容</font></a></th>
<tr align="center">
<td colspan="10" class="tablerowhighlight">第二步:  建立标签与数据库对应关系</td>
</tr>
<tr align="center">
<td class="tablerowhighlight">原数据库字段</td>
<td width="30%" class="tablerowhighlight">数据库字段说明</td>
<td width="40%" class="tablerowhighlight">标签字段（采集填充结果）</td>
</tr>
<tr align="center">
<td colspan="3" onmouseout="this.style.backgroundColor='#F1F1F2'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F2F3'><div align="left" class="style1">数据表：<?=$content_table?></div></td>
</tr>
<?php for($i=0;$i<count($article_data);$i++)
{
?>
<tr align="center"  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$article_data[$i]['Field']?></td>
<td><?=$article_data[$i]['Description']?></td>
<td><?=$article_data[$i]['Label']?></td>
</tr>
<?php
}
?>
<tr align="center">
<td colspan="3" onmouseout="this.style.backgroundColor='#F1F2F3'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F2F3'><div align="left" class="style1">数据表：<?=$title_table?></div></td>
</tr>
<?php for($i=0;$i<count($out);$i++)
{
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$out[$i]['Field']?></td>
<td><?=$out[$i]['Description']?></td>
<td  align="center" ><?=$out[$i]['Label']?></td>
</tr>
<?php }
?>
<tr>
<td class="tablerowhighlight" colspan="3"><strong>文章自定义字段</strong></td>
</tr>
<?php
 for($i=0;$i<count($fieldManual);$i++)
{?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$fieldManual[$i]['fieldname']?></td>
<td><?=$fieldManual[$i]['title']?></td>
<td  align="center" ><?=$fieldManual[$i]['label']?></td>
</tr>
<?php }
?>

<tr style="cursor:hand" onClick="ShowOutHidden();">
<td class="tablerowhighlight" colspan="3"><img src="<?=PHPCMS_PATH?>images/icon/open.gif" width="18" height="18" id="outhiddenimg">
		  <strong>[点击打开/隐藏] 更多字段高级设置</strong></td>
</tr>
<tr align="center">
<td colspan="3">

<table cellpadding="0" cellspacing="1" border="0" width="100%"  class="tableborder" id="outhiddentable" style="display:none";>
  <tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
    <td colspan="3">&nbsp;</td>
  </tr>  
  <?php for($i=0;$i<count($outhidden);$i++)
{
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$outhidden[$i]['Field']?></td>
<td  width="30%" ><?=$outhidden[$i]['Description']?></td>
<td  align="center"  width="40%" ><?=$outhidden[$i]['Label']?></td>
</tr>
<?php } ?>
  <tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
    <td  colspan="3">&nbsp;</td>
  </tr>
</table>


</td>
</tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td width="316">
  <input type="hidden" name="art[channelid]" value="<?=$channelid?>">
  <input type="hidden" name="art[catid]" value="<?=$catid?>">
  <input type="button" name="resetdefault" value="恢复默认" onClick="window.location='?mod=<?=$mod?>&file=collect&action=outcontent&jobid=<?=$jobid?>&step=2&resetdefault=1&channelid=<?=$channelid?>&catid=<?=$catid?>'">
  <input type="checkbox" name="ckset[ckdeletepre]" id="ckdeletepre" value="0">发布成功后删除原采集内容
  <input type="checkbox" name="ckset[ckbacksort]" id="ckbacksort" value="1" checked>倒序发布
  </td>
    <td align="center">
<input type="submit" name="submit" value="发布内容" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=spideradd&jobid=<?=$jobid?>'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td align="right"  width="130">
<input type="checkbox" name="ckset[cksaveset]" id="cksaveset" value="1" checked>发布时保存当前配置</td>
  </tr></form>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center></td>
  </tr>
</table>
<?=$selectvalue?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	  <p>这里是采集内容（未入库）的列表，您可以删除不需要发布入库的文章，尚未采集的文章在同样可以查看（查看的过程中系统将自动进行采集）</p>    </td>
  </tr>
</table>
</body>
</html>