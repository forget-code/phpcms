<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	if(!$att['att_name']) showmessage($LANG['attribute_name_not_null']);
	if(!in_array($att['att_type'],array(0,1,2))) showmessage($LANG['select_property_type']);
	if(!$att['pro_id']) showmessage($LANG['product_property_type_not_null']);
	//先判断重复
	$checkrepeatsql="SELECT att_name FROM ".TABLE_PRODUCT_ATT." WHERE pro_id=".$att['pro_id']." AND att_name='".$att['att_name']."'";
	$db->query($checkrepeatsql);
	if($db->affected_rows()>0)
	{
		showmessage($LANG['repeated_attribute_refill'],$referer);
	}
	
	$keys = $values = $s = "";
	foreach($att as $key=>$value)
	{
		$keys .= $s.$key;
		$values .= $s."'".$value."'";
		$s = ",";
	}
	$db->query("insert into ".TABLE_PRODUCT_ATT." ($keys) values($values)");
	$attid = $db->insert_id();

	if($attid) showmessage($LANG['operation_success'],$referer);
}
else
{
	$pro_id = isset($pro_id) ? intval($pro_id) : 0;
	$res=$db->query("SELECT pro_id,pro_name FROM ".TABLE_PRODUCT_PROPERTY." Order by pro_id desc");
	if(mysql_num_rows($res)<1)
	showmessage($LANG['no_any_product_property'],"?mod=".$mod."&file=property&action=add");
	
	$property_select="<select name='att[pro_id]' id='propro_id'><option  value='0'>".$LANG['select_product_property']."</option>";
	while($r=$db->fetch_array($res))
	{
		$property_select.="<option value=".$r['pro_id'];
		if($pro_id==$r['pro_id'])
		{
			$property_select.=" selected ";
		}
		$property_select.=" >".$r['pro_name']."</option>";
	}
	$property_select.="</select>";	
	include admintpl('attribute_add');
}
?> 