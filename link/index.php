<?php 
require './include/common.inc.php';
require './include/tag.func.php';
$head['title'] = $MOD['name'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
$enablecheckcode = $MOD['enablecheckcode'];
$logo = $PHP_SITEURL.$PHPCMS['logo'];
$sitename = $PHPCMS['sitename'];
$sql = "SELECT * FROM ".TABLE_TYPE." WHERE keyid = 'link' ORDER BY listorder ASC ";
$query = $db->query($sql);
$TYPE = array();
while($r = $db->fetch_array($query))
{
	$TYPE[] = $r;
}
$linktype_select = '';
$linktype_select .= '<option value="0" >'.$LANG['choose_type'].'</option>';
$tname = array();
foreach($TYPE as $typeid=>$v)
{
	$linktype_select.="<option value=\"".$v['typeid']."\" >".$v['name']."</option>";
	$tname[] = $v;
}
$templateid = 'index';
include template($mod, $templateid);

?>
