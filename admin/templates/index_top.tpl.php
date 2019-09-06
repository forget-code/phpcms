<?php include admintpl('header');?>
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
<td height="30" width="170" align="center"><a href="<?=PHPCMS_PATH?>" target="_blank"><span style="font-weight:bold;font-size:25px;color:#FFFFFF;text-decoration:none;margin:2px;">PHPCMS</span></a></td>
<td>
<table border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<?=menu('phpcms','admin_top')?>
</tr>
</table>

</td>
</tr>
</table>
</body>
</html>