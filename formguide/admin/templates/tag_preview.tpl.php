<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align="center">表单向导标签预览：（如果预览无错误，可以直接将该标签插入到相应html即可使用）</td>
  </tr>
  <tr>
    <td class="tablerow"><?=$preview?>
	<?php //eval($eval); ?>
	</td>
  </tr>
<tr>
<td align="right" class="tablerow"><a href="javascript:history.back();"><font color="red">返 回 上 一 步</font></a>&nbsp;</td>
</tr>
</table>
</body>
</html>