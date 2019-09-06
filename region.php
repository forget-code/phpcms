<?php 
require "common.php"; 

$country = "中华人民共和国";
$province = $province ? $province : '北京市';
$city = $city ? $city : "海淀区";

$provinces = $citys = array();

$result = $db->query("SELECT province FROM ".TABLE_PROVINCE." WHERE country='$country' ORDER BY provinceid");
while($r = $db->fetch_array($result))
{
	$provinces[] = $r['province'];
}

$result = $db->query("SELECT DISTINCT city FROM ".TABLE_CITY." WHERE province='$province' ORDER BY cityid");
while($r = $db->fetch_array($result))
{
	$citys[] = $r['city'];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
<style type="text/css">
<!--
td{
	FONT-FAMILY: "宋体";
	FONT-SIZE: 9pt;
}
SELECT {
	BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; FONT-SIZE: 12px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px
}
-->
</style>
</head>
<body>
<table width="100%"  border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
<form name="regionform" id="regionform" action="region.php" method="post">
<tr>
<td align="right" class="tablerow">省/市/自治区：</td>
<td class="tablerow">
<select name="province" id="province" onChange="document.regionform.submit();">
<?php 
foreach($provinces as $p)
{
	$selected = $p == $province ? "selected" : "";
    echo "<option value='".$p."' ".$selected.">".$p."</option>\n";
}
?>
</select>
</td>
</tr>
<tr>
<td align="right" class="tablerow">
市/县/区：
</td>
<td class="tablerow">
<select name="city" id="city">
<?php 
foreach($citys as $c)
{
	$selected = $c == $city ? "selected" : "";
    echo "<option value='".$c."' ".$selected.">".$c."</option>\n";
}
?>
</select>
</td>
</tr>
</form>
</table>
</body>
</html>