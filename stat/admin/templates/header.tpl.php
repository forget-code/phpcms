<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$CONFIG['charset']; ?>">
<title><?php echo $PHPCMS['sitename']; ?>网站管理 - Power by PHPCMS <?php echo PHPCMS_VERSION; ?></title>
<link href="<?php echo PHPCMS_PATH; ?>admin/skin/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="<?php echo PHPCMS_PATH; ?>include/js/common.js"></script>
<script language="JavaScript" src="<?php echo PHPCMS_PATH; ?>include/js/prototype.js"></script>
<style type="text/css">
.trbg1 {
	background-color:#F1F3F5;
}
.trbg2 {
	background-color:#BFDFFF;
}
</style>
</head>
<body>
<?php
echo $menu;
echo "<div style='text-align:left'>当前位置：$curpos</div>";
?>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<thead>
		<tr>
			<th colspan="7"><?php echo $title; ?></th>
		</tr>
	</thead>