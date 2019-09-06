<?php
defined('IN_PHPCMS') or exit('Access Denied');
$head['title'] = $MOD['name'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
$enablecheckcode = $MOD['enablecheckcode'];
$logo = $PHP_SITEURL.$PHPCMS['logo'];
$sitename = $PHPCMS['sitename'];
require_once PHPCMS_ROOT."/link/include/tag.func.php";
$sql = "SELECT * FROM ".TABLE_TYPE." WHERE keyid = 'link' ORDER BY listorder ASC ";
$query = $db->query($sql);
$TYPE = array();
while($r = $db->fetch_array($query))
{
	$TYPE[] = $r;
}
$linktype_select = '';
$linktype_select .= '<option value="0" >'.$LANG['select_type'].'</option>';
$tname = array();
foreach($TYPE as $typeid=>$v)
{
	$linktype_select.="<option value=\"".$v['typeid']."\" >".$v['name']."</option>";
	$tname[] = $v;
}
createhtml("index");
createhtml("category_list");
showmessage($LANG['update_success']);
?>