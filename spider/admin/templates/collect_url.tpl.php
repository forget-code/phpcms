<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script language="javascript">
var currenturlid=0;
var totalurlcount=0;
var totalurlnorepeatcount=0;
function GotoPageByNext(style,totalcount,norepeatcount)
{
totalurlcount=totalcount;
totalurlnorepeatcount=norepeatcount;
if(style=="Pre")
 document.getElementById('currenturl').location("<?php echo "?mod=".$mod."&file=collect&jobid=".$jobid."&action=collecturl&singleurl=true&totalurlcount=\"+totalurlcount+\"&totalurlnorepeatcount=\"+totalurlnorepeatcount+\"&currenturlid=\"+(--currenturlid)+\""; ?>");
else if(style=="Next")
 document.getElementById('currenturl').location("<?php echo "?mod=".$mod."&file=collect&jobid=".$jobid."&action=collecturl&totalurlcount=\"+totalurlcount+\"&totalurlnorepeatcount=\"+totalurlnorepeatcount+\"&singleurl=true&auto=".$auto."&currenturlid=\"+(++currenturlid)+\""; ?>");
else if(style=="Manual")
{
currenturlid=0;
window.location="<?php echo "?mod=".$mod."&file=collect&action=collecturl&jobid=".$jobid."&currenturlid=\"+(++currenturlid)+\""; ?>";
}
else if(style=="Auto")
{
currenturlid=0;
window.location="<?php echo "?mod=".$mod."&file=collect&action=collecturl&jobid=".$jobid."&auto=true&currenturlid=\"+(++currenturlid)+\""; ?>";
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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" border="0" align=center cellpadding="2" cellspacing="1" class="tableBorder" >
  <tr>
    <td align=center class="submenu">网址采集</td>
  </tr>
  <tr>
    <td align="center" valign="top" class="tablerow break"><table width="94%"  border="0"  class="tableborder">
      <tr>
        <td align="center"><strong>网址采集过程中页面内自动循环，建议不要关闭浏览器....</strong></td>
      </tr>
      <tr>
        <td><table width="98%"  border="0"  class="tableborder">
          <tr>
            <td width="25%" align="center"><input name="button" type='button' onClick='GotoPageByNext("Auto",0,0)'  value='自动模式'>:
              <? if(isset($auto)&&$auto==true) echo "√";else echo "×"; ?></td>
            <td width="25%" align="center"><input name="button2" type='button' onClick='GotoPageByNext("Manual",0,0)'  value='手动模式'>:
			  <? if(isset($auto)&&$auto==true) echo "×";else echo "√"; ?></td>
            <td width="25%" align="center"><? if(isset($auto)&&$auto==true) echo "<input type='button'  value='上一页' disabled>";
			 else echo "<input type='button'  value='上一页' onClick='GotoPageByNext(\"Pre\",'+totalurlcount+','+totalurlnorepeatcount+')'>"; ?></td>
            <td width="25%" align="center"><? if(isset($auto)&&$auto==true) echo "<input type='button'  value='下一页' disabled>";
			 else echo "<input type='button'  value='下一页' onClick='GotoPageByNext(\"Next\",'+totalurlcount+','+totalurlnorepeatcount+')'>"; ?></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td><?php
         setMtirFrame("currenturl");
         loadMtirPage('currenturl',"?mod=".$mod."&file=collect&jobid=".$jobid."&action=collecturl&singleurl=true&auto=true&currenturlid=0","采集网址正在进行中.......<br><br>如果采集需要编码转换，而服务器不支持mb_string或iconv，转换将需要一段时间......<br>",0);
         ?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
