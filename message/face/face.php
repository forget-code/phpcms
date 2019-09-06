<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta name="Robots" content="none">
<title>Smiles</title>
<style type="text/css">
<!--
body {margin:2px;background-color:#ececec;}
img {cursor:pointer;}
div {padding-left:5px;text-align:left;font-weight:bold;color:#0000ff;}
table {background-color:#ffffff;}
-->
</style>
</head><noscript><iframe src="*.html"></iframe></noscript>
<body oncontextmenu="window.event.returnValue=false;">
<?php
$dir = dirname(__FILE__);
if ($handle = @opendir($dir)) {
	$face = array();
	while (($file = readdir($handle)) !== false) {
		if ($file != "." && $file != "..") {
			$extName = strtolower(substr($file, -3));
			if ($extName == "gif") {
				$face[] = $file;
			}
		}
	}
	closedir($handle);
}
if (is_array($face) && count($face) > 0) {
	echo "<table width='100%' height='100%' border='1' bordercolor='#000066' cellpadding='3' cellspacing='0' align='center'><tbody>";
	$cols = floor(sqrt(count($face)));
	$tdWidth = floor(100 / $cols);
	for ($i = 0; $i < count($face); $i++) {
		if ($i % $cols == 0) {
			echo "<tr>";
		}
		echo "<td width='{$tdWidth}%' align='center' valign='middle'><img src='./{$face[$i]}' border='0' align='absmiddle'></td>";
		if ($i % $cols == $cols - 1 || $i == count($face) - 1) {
			echo "</tr>";
		}
	}
	echo "</tbody></table>";
} else {
	echo "Not Exists";
}
echo "</body></html>";
?>
<script src="./face.js" language="javascript" type="text/javascript"></script>