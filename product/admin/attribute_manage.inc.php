<?php
defined('IN_PHPCMS') or exit('Access Denied');


$pro_id=intval($pro_id);
if($pro_id==0) header("Location:?mod=$mod&file=property&action=manage");
$page = isset($page) ? intval($page) : 1;
$offset=($page-1)*$PHPCMS['pagesize'];
$result=$db->query("SELECT count(*) as num FROM ".TABLE_PRODUCT_ATT." WHERE pro_id=$pro_id");
$r=$db->fetch_array($result);
$number=$r['num'];
$pages = phppages($number,$page,$PHPCMS['pagesize']);

$query	="SELECT pro_name".
		" FROM ".TABLE_PRODUCT_PROPERTY.
		" WHERE pro_id=".$pro_id;	
$r=$db->get_one($query);
$pro_name = $r['pro_name'];

$query ="SELECT * ".
		"FROM ".TABLE_PRODUCT_ATT.
		" WHERE pro_id=$pro_id  order by listorder desc limit $offset,".$PHPCMS['pagesize'];

$result=$db->query($query);
$atts = array();
while($r=$db->fetch_array($result))
{
	$r['pro_name'] = $pro_name;
	$atts[]=$r;
}
$atttype=array($LANG['single_line_text'],$LANG['from_list_of_options'],$LANG['multiple_line_text']);

include admintpl('attribute_manage');
?> 