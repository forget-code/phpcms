<?php
defined('IN_PHPCMS') or exit('Access Denied');

$attlists = array();
if($pro_id) 
{
	$pro_id = intval($pro_id);
	if(isset($productid)) 
	{
		$productid = intval($productid);
		$query = "SELECT * FROM ".TABLE_PRODUCT_PDTATT." WHERE productid=$productid";
		$result = $db->query($query);
		$pdtatt = array();
		while($r = $db->fetch_array($result))
		{
			$pdtatt[$r['att_id']] = $r['att_value'];
		}
	}
	$query = "SELECT * FROM ".TABLE_PRODUCT_ATT;
	if($pro_id!=0)
	{
		$query.=" WHERE pro_id=".$pro_id;
	}
	$query.=" ORDER BY listorder desc";
	$result = $db->query($query);
	while($r = $db->fetch_array($result))
	{	
		$attinput = '';
		switch($r['att_type'])
		{
			case 0:
				if(isset($pdtatt) && array_key_exists($r['att_id'],$pdtatt))
				{
					$attinput = "<input type='text' name='pdt_att_value[]' value='".$pdtatt[$r['att_id']]."' size='40'/>";
				}
				else 
				{
					$attinput = "<input type='text' name='pdt_att_value[]' size='40'/>";
				}
				break;
			
			case 1:
				$attinput = "<select name='pdt_att_value[]'>\n";
				$attinput.= "<option value=''>".$LANG['select_list_value']."</option>\n";	
				$attvalue=explode("\n",$r['att_values']);
				foreach ($attvalue as $v)
				{
					$v=str_replace("\r","",$v);
					if(!empty($v))
					{
						if(isset($pdtatt) && array_key_exists($r['att_id'],$pdtatt) && $pdtatt[$r['att_id']]==$v)
						{
							$attinput.= "<option value='".$v."' selected>$v</option>\n";
						}
						else 
						{
							$attinput.= "<option value='".$v."'>$v</option>\n";
						}
					}
				}
				$attinput.= "</select>\n";
				break;
			
			case 2:
				if(isset($pdtatt) && array_key_exists($r['att_id'],$pdtatt))
				{
					$attinput= "<textarea name='pdt_att_value[]' cols='40' rows='3'>".$pdtatt[$r['att_id']]."</textarea>";
				}
				else
				{
					$attinput= "<textarea name='pdt_att_value[]' cols='40' rows='3'></textarea>";
				}
				break;
			
			default:
				$attinput= "<input type='text' name='pdt_att_value[]' size='40'/>";
				break;
		
		}
		$r['attinput'] = $attinput;
	
		$attlists[] = $r;
	}
}
include admintpl('attribute_list');
?> 