<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header','phpcms');

?>
<?=$menu?>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
<body>
  <table width="101%" border="0" align="center" cellpadding="2" cellspacing="1"  class="tableborder">
  
    <tr bgcolor="#E4EDF9">
      <td height="23"><div align="center"><strong>名称</strong></div></td>
      <td height="23"><div align="center"><strong>
        大小
      </strong></div></td>
      <td height="23"><div align="center"><strong>修改时间</strong></div></td>
      <td height="23"><div align="center"><strong>创建时间</strong></div></td>
      <td width="107" height="23"><div align="center"><strong>管理</strong></div></td>
    </tr>
     <?php if($errorfile) foreach($errorfile as $list){
	 $filename=substr($list,0,-33);
	 $strlen=strlen(PHPCMS_ROOT);
	 $filename_l=substr($filename,$strlen);
	 ?>
    <tr  onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" >
      <td width="364" height="23" ><?=$filename_l?></td>
      <td height="23" ><?=filesize($filename)/1000?>KB</td>
      <td height="23" ><span class="STYLE1">
      <?=date('Y-m-d h:i',filemtime($filename))?></span></td>
      <td height="23" ><?=date('Y-m-d h:i',filectime($filename))?></td>
      <td height="23" ><a href="?mod=phpcms&file=filemanager&action=edit&fname=<?=$filename?>&dir=<?=dirname($filename).'/'?>">编辑</a></td>
    </tr>
    <?php }?>
    <tr>
      <td width="364" height="23" >&nbsp;</td>
      <td width="106" height="23" ><label></label></td>
      <td width="192" height="23" >&nbsp;</td>
      <td width="210" height="23" >&nbsp;</td>
      <td height="23" >&nbsp;</td>
    </tr>
  </table>
<p>&nbsp;</p>
</body>
</html>