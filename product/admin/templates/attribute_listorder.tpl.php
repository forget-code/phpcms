<?php

if(!is_array($listorder)) return FALSE;
foreach($listorder as $att_id=>$value)
{
	$value = intval($value);
	$db->query("UPDATE ".TABLE_PRODUCT_ATT." SET listorder=$value WHERE att_id=$att_id");
}
return TRUE;
//echo $refer;
showmessage('操作成功！',$refer);
?>