<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language="javascript">
function GetThreadFormPage(threadid,dourl)
{
 var obj='threadForm'+threadid;
 document.getElementById(obj).location(dourl);
}
var finishedthread=0;
function ShowFinishedInfo() //每调用一次表明完成了一个进程
{
	finishedthread++;
	if(finishedthread>=<?=$threadnumber?>)
	{
	document.getElementById("dinfo").style.display="block";
	document.getElementById("contenttable").style.display="none";	
	}
}
</script>
<style type="text/css">
<!--
.break {
    height:23px;
	word-break:break-all;
	overflow:hidden;
}
-->
</style>
<body>
<DIV id="dinfo" style='Z-INDEX: 100; margin-top:100px;display:none' align="center">
<table width='260'  cellspacing=0 cellpadding=0 bgcolor='#FFffff' style='border:1px solid #c0c0c0;'>
<tr>
<td>
	<table cellspacing=1 cellpadding=2 border=0 align=center class="tableBorder">
	<tr>
	<td style='font-size:13px;' align=center><b>完成提示</b><br></td>
	</tr>
	<tr>
	<td style='font-size:13px;line-height:120%;'>
	所有任务全部完成!<br>
	您可以选择:<br>
	1、发布文章内容 <a href='?mod=<?=$mod?>&file=collect&action=outcontent&jobid=<?=$jobid?>&step=1&channelid=1'><font color='blue'>发布内容</font></a><br/>
	2、审核文章内容 <a href='?mod=<?=$mod?>&file=collect&action=manage'><font color='blue'>查看所有</font></a><br/>
	</td>
	</tr>
	<tr>
	<td style='font-size:12px;line-height:200%'>
	<div align='right' style='CURSOR: hand' onclick="document.getElementById('dinfo').style.display='none';">关 闭</div>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>
</DIV>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="tableBorder" id="contenttable">
  <tr>
    <td align=center class="submenu">内容采集</td>
  </tr>
  <tr>
    <td align="center" valign="top" class="tablerow break"><table width="94%"  border="0"  class="tableborder">
       <tr>
        <td><table width="98%"  border="0"  class="tableborder">
          <tr>
            <td width="64%" align="center"><strong>当前任务: <?=$ms->CJob->Job['JobName'];?>
            </strong></td>
            <td width="36%" align="center">需采集文章总数：<?=$totalnum?>  线程数:<?=$threadnumber?> 单线程请求连接数：<?=$ms->CJob->Job['ThreadRequest'];?> 间隔时间：<?=$ms->CJob->Job['ThreadSleep'];?></td>
            </tr>
        </table>
        </td>
      </tr>
     <tr><td height='20'>如果采集的站点与当前服务器编码不一致，需要编码转换，而服务器不支持mb_string或iconv扩展，转换将需要一段时间......<br>
     如果因网络或服务器意外出现采集停止的情况，请直接刷新该页面，采集器将续采，不影响已采集结果。</td></tr>
      
	  <?php if($threadnumber<1) $threadnumber=1; 
	  for($serial=0;$serial<=$threadnumber;$serial++){
	  echo  "<tr><td height='40'><table border='0' align=left cellpadding='0' cellspacing='0'><tr ";
	   if($serial==$threadnumber) echo " style=\"display:none\"";
	  echo "><td width='120'>&nbsp;&nbsp;<font color='red'>线程".($serial+1)."后台运行中</font>:</td><td>";
	  setMtirFrame("threadForm".$serial);
	  echo "</td></tr></table></td></tr>";
	   }
       loadMultiPage("threadForm",$fromArr,"1、线程初始化...<br>2、分配线程任务.......<br>3、各线程开始执行任务.........",0);      
      ?>	
    </table></td>
  </tr>
</table>
</body>
</html>