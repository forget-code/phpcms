<?php
function formguide($templateid='',$formid)
{
	global $db,$MOD,$MODULE;
	$formid = (!isset($formid)||$formid=='') ? 0 : intval($formid);
	$query = "SELECT * FROM ".TABLE_FORMGUIDE." WHERE formid=$formid limit 1";
	$r = $db->get_one($query);
	if(!$r)
	{
		echo $LANG['not_exist_form'];
		return '';	
	}
	@extract($r);
	if($disabled ==1 )
	{
		echo $LANG['form_out_of_date'];
		return '';
	}
	
	$itemstr = new_htmlspecialchars($formitems);
	$formitems = unserialize($formitems);
	if($formitems)
	{
		$keyinput = array();
		foreach($formitems['itemname'] as $k=>$item)
		{
			$values = str_replace("\r",'',$formitems['list'][$k]);
			$valuearr = explode("\n",$values);
			$valuearr = array_filter($valuearr);
			switch($formitems['formtype'][$k])
			{
				case '1':
				$htmltpl= "<input type='text' name='f$k' size='50' value=''/>";
				if($formitems['ismust'][$k]) $htmltpl.=" &nbsp<font color='red'>*</font>";
				$keyinput[] = array('key'=>$formitems['itemname'][$k],'input'=>$htmltpl);
				break;
			
				case '2':
				$htmltpl = "<textarea cols='42' rows='5' name='f$k' ></textarea>";
				if($formitems['ismust'][$k]) $htmltpl.=" &nbsp<font color='red'>*</font>";
				$keyinput[] = array('key'=>$formitems['itemname'][$k],'input'=>$htmltpl);
				break;
				
				case '3':
				$htmltpl = '';
				foreach($valuearr as $q=>$value)
				{
					$str = $q==0 ? ' checked ' : '';
					$htmltpl.="<input name='f$k' type='radio'  value='$value' $str />$value&nbsp;&nbsp;";
				}
				if($formitems['ismust'][$k]) $htmltpl.=" &nbsp<font color='red'>*</font>";
				$keyinput[] = array('key'=>$formitems['itemname'][$k],'input'=>$htmltpl);
				break;
				
				case '4':
				$htmltpl = '';
				foreach($valuearr as $value)
				{
					$htmltpl.=  "<input type='checkbox' name='f".$k."[]' value='$value'/>$value&nbsp;";
				}
				if($formitems['ismust'][$k]) $htmltpl.=" &nbsp<font color='red'>*</font>";
				$keyinput[] = array('key'=>$formitems['itemname'][$k],'input'=>$htmltpl);
				break;
				
				case '5':
				$htmltpl=  "<select name='f$k".$k."[]' >";
				foreach($valuearr as $value)
				{
					$htmltpl.=  "<option value='$value'>$value</option>";
				}
				$htmltpl.="</select>";
				if($formitems['ismust'][$k]) $htmltpl.=" &nbsp<font color='red'>*</font>";
				$keyinput[] = array('key'=>$formitems['itemname'][$k],'input'=>$htmltpl);
				break;
				
				case '6':
				$htmltpl= "<input type='file' name='f$k' size='40' />";
				if($formitems['ismust'][$k]) $htmltpl.=" &nbsp<font color='red'>*</font>";
				$keyinput[] = array('key'=>$formitems['itemname'][$k],'input'=>$htmltpl);
				break;
				
				default:
				$htmltpl= "<input type='text' name='f$k' value='' size='50' />";
				if($formitems['ismust'][$k]) $htmltpl.=" &nbsp<font color='red'>*</font>";
				$keyinput[] = array('key'=>$formitems['itemname'][$k],'input'=>$htmltpl);
				break;
			}
		}
	}
	$templateid = $templateid ? $templateid : "tag_formguide";
	include template('formguide',$templateid);
}
?>