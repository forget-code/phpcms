<?php
defined('IN_PHPCMS') or exit('Access Denied');
function cache_PARS_write($file, $string, $type = 'array')
{
	if(is_array($string))
	{
		$type = strtolower($type);
		if($type == 'array')
		{
			$string = "<?php\n return ".var_export($string,TRUE).";\n?>";
		}
		elseif($type == 'constant')
		{
			$data='';
			foreach($string as $key => $value) $data .= "define('".strtoupper($key)."','".addslashes($value)."');\n";
			$string = "<?php\n".$data."\n?>";
		}
	}
	$strlen = file_put_contents($file, $string);
	chmod($file, 0777);
	return $strlen;
}
function revers_Array($array)
{
	$array = array_flip($array);
	return array_map('addone',$array);	
}
function addone($obj)
{
	return $obj+1;	
}

if(isset($submit))
{
	$areaid = explode("\n",str_replace("\r","",$areaid));
	$towards = explode("\n",str_replace("\r","",$towards));
	$decorate = explode("\n",str_replace("\r","",$decorate) );
	$housetype = explode("\n",str_replace("\r","",$housetype));
	$infrastructure = explode("\n",str_replace("\r","",$infrastructure));
	$indoor = explode("\n",str_replace("\r","",$indoor));
	$peripheral = explode("\n",str_replace("\r","",$peripheral));

	$PARS['areaid']=revers_Array($areaid);
	$PARS['towards']=revers_Array($towards);
	$PARS['decorate']=revers_Array($decorate);
	$PARS['type']=revers_Array($housetype);
	$PARS['infrastructure']=revers_Array($infrastructure);
	$PARS['indoor']=revers_Array($indoor);
	$PARS['peripheral']=revers_Array($peripheral);
	
	cache_PARS_write(PHPCMS_ROOT.'/house/include/pars.inc.php', $PARS, 'array');

	showmessage("操作成功","?mod=$mod&file=$file&action=option");
}
else 
{
	$areaidstr = implode("\n",$areaidS);
	$towardsstr = implode("\n",$TOWARDS);
	$decoratestr = implode("\n",$DECORATES);
	$housetypestr = implode("\n",$HOUSETYPE);
	$infrastructurestr = implode("\n",$INFRASTRUCTURE);
	$indoorstr = implode("\n",$INDOOR);
	$peripheralstr = implode("\n",$PERIPHERAL);	
	include admintpl("setting_option");
}
?> 