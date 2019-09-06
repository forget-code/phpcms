<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(isset($submit))
{
	if(!$att['att_name']) showmessage($LANG['attribute_name_not_null']);
	if(!in_array($att['att_type'],array(0,1,2))) showmessage($LANG['select_property_type']);
	if(!$att['pro_id']) showmessage($LANG['product_property_type_not_null']);

	$sql="UPDATE ".TABLE_PRODUCT_ATT.
		" SET att_name='".$att['att_name']."',att_type='".$att['att_type']."',pro_id='".$att['pro_id']."',att_values='".$att['att_values']."' ".
		"WHERE att_id=".$att_id;	
	$result=$db->query($sql);	
	showmessage($LANG['operation_success_record_modified'],"?mod=$mod&file=$file&action=manage&pro_id=$att[pro_id]");
}
if(empty($att_id)) showmessage($LANG['illegal_parameters']);
$att = $db->get_one("SELECT * FROM ".TABLE_PRODUCT_ATT." where att_id = $att_id limit 1");
$res=$db->query("SELECT pro_id,pro_name FROM ".TABLE_PRODUCT_PROPERTY." Order by pro_id desc");
$property_select="<select name='att[pro_id]' id='propro_id'><option  value='0'>".$LANG['select_product_property']."</option>";
while($r=$db->fetch_array($res))
{
	$property_select.="<option value=".$r['pro_id'];
	if($att['pro_id']==$r['pro_id'])
	{
		$property_select.=" selected ";
	}
	$property_select.=" >".$r['pro_name']."</option>";
}
$property_select.="</select>";
	
$att=new_htmlspecialchars($att);

if (count($att)<1) showmessage($LANG['cannot_find_record_return'],$referer);

include admintpl("attribute_edit");
?> 