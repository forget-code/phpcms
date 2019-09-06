<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script language="javascript">
var tid=0;
function GotoPageByNext(style)
{
if(style=="Pre")
 document.getElementById('turl').location("<?php echo "?mod=".$mod."&file=jobmgr&jobid=".$jobid."&action=turl&tid=\"+(--tid)+\""; ?>");
else if(style=="Next")
 document.getElementById('turl').location("<?php echo "?mod=".$mod."&file=jobmgr&jobid=".$jobid."&action=turl&tid=\"+(++tid)+\""; ?>");
else if(style=="Manual")
{
tid=0;
window.location="<?php echo "?mod=".$mod."&file=jobmgr&jobid=".$jobid."&action=testspider&tid=\"+(++tid)+\""; ?>";
}
else if(style=="Auto")
{
tid=0;
window.location="<?php echo "?mod=".$mod."&file=jobmgr&jobid=".$jobid."&action=testspider&auto=true&tid=\"+(++tid)+\""; ?>";
}
}

function TestContentById(urlSerial)
{
	var curl=document.getElementById('url'+urlSerial).href;
	document.getElementById("tcontent").location('?mod=spider&file=jobmgr&jobid=<?=$jobid?>&action=turl&pageurl='+encodeURIComponent(curl)+'&testcontent=true');
	document.getElementById("ContentArea").style.display="none";
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
<table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="table_form" >
  <tr>
    <td width="60%" align="center" valign="top" class="tablerow break"><table width="94%"  border="0"  class="table_form">
      <tr>
        <td align="center"><strong>网址采集测试</strong></td>
      </tr>
      <tr>
        <td><table width="100%"  border="0"  class="tableborder">
          <tr>
            <td align="center"><input type='button'  value='手动模式' onClick='GotoPageByNext("Manual")'>:<? if(isset($auto)&&$auto==true) echo "×";else echo "√"; ?></td>
            <td align="center">
			<? if(isset($auto)&&$auto==true)
			 echo "<input type='button'  value='上一页' disabled>";
			 else echo "<input type='button'  value='上一页' onClick='GotoPageByNext(\"Pre\")'>"; ?></td>
            <td align="center"><? if(isset($auto)&&$auto==true)
			 echo "<input type='button'  value='下一页' disabled>";
			 else echo "<input type='button'  value='下一页' onClick='GotoPageByNext(\"Next\")'>"; ?></td>
            <td align="center"><input type='button'  value='自动模式' onClick='GotoPageByNext("Auto")'>:<? if(isset($auto)&&$auto==true) echo "√";else echo "×"; ?></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td><?php
         setMtirFrame("turl");
         if(isset($auto) && $auto==true)
         loadMtirPage('turl',"?mod=".$mod."&file=jobmgr&jobid=".$jobid."&action=turl&tid='+tid+++'","采集网址正在进行中......<br>无页面刷新，10秒钟更新一页......",10000);
         else loadMtirPage('turl',"?mod=".$mod."&file=jobmgr&jobid=".$jobid."&action=turl&tid='+tid+++'","采集网址正在进行中......<br>",0);
         ?></td>
      </tr>
    </table>	  </td>
    <td align="center" valign="top" class="tablerow"><table width="94%"  border="0"  class="tableborder">
      <tr>
        <td align="center"><strong>内容规则测试</strong></td>
      </tr>
      <tr>
        <td align="center"><textarea cols="60" rows="27" id='ContentArea'>请在左边选择测试页再分析内容规则...</textarea><?php
         setMtirFrame("tcontent");?></td>
      </tr>
    </table></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" border="0" align=center class="table_info" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	该页用于测试网址采集和页面规则正确性，页面10s自动装载一次无刷新操作！
	</td>
  </tr>
</table>
</body>
</html>
