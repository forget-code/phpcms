<?php 
defined('IN_PHPCMS') or exit('Access Denied');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8'charset']?>">
<meta name="generator" content="Phpcms <?=$PHPCMS['version']?>">
<link href="<?=PHPCMS_PATH?>favicon.ico" rel="shortcut icon">
<link href="<?=$skindir?>/style.css" rel="stylesheet" type="text/css">
<link href="<?=PHPCMS_PATH?>admin/skin/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="<?=PHPCMS_PATH?>data/js/config.js"></script>
<script language="javascript" src="<?=PHPCMS_PATH?>include/js/common.js"></script>
<script language="javascript" src="<?=PHPCMS_PATH?>include/js/prototype.js"></script>
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="80%">
	<tr>
		<td>
<table cellpadding="2" cellspacing="1" border="0" class="tableBorder">
  <tr>
    <th>{tag_<?=$tagname?>} 标签预览</th>
  </tr>
  <tr>
    <td class="tablerow">
	<?php eval($eval); ?>
	</td>
  </tr>
<tr>
<td align="center" class="tablerow">
<input type="button" value="返回上一步" onclick="javascript:history.back();">
<?php if($job == 'edittemplate'){ ?>
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="编辑标签" onclick="javascript:window.location='?mod=phpcms&file=tag&action=quickoperate&operate=edit&job=edittemplate&tagname=<?=urlencode($tagname)?>';">
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="关闭窗口" onclick="javascript:window.close();">
<?php } ?>
</td>
</tr>
</table>
		</td>
	</tr>
</table>
</body>
</html>