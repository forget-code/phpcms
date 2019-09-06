<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<style>
body{margin:0;}
</style>
<body>
<script>
var tID=0;
function Tabs(ID){
  var tTabTitle=$("TabTitle"+tID);
  var TabTitle=$("TabTitle"+ID);
  if(ID!=tID){
    tTabTitle.className='Tab1';
    TabTitle.className='Tab2';
    tID=ID;
  }
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#799AE1">
<th colspan="2">&nbsp;</th>
<tr>
<td height="30" width="170" align="center"><a href="<?=$INDEX?>" target="_blank"><span style="font-weight:bold;font-size:20px;color:#FFFFFF;text-decoration:none;margin:2px;">管理中心</span></a></td>
<td>
<table border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='Tab2' onclick='Tabs(0)'>
<a href="?file=index&action=manage" title="" target="left" style="">面板首页</a>
</td>

</tr>
</table>
</td>
</tr>
</table>
</body>
</html>