<?php
require './include/common.inc.php';
$catid = intval($catid);
switch($action)
{
	case 'cat_option':
		$cats = subcat('yp',$catid);
		if(is_array($cats) && !empty($cats))
		{
			foreach($cats AS $catid=>$c)
			{
				echo "<option value='$catid'>$c[catname]</option>";
			}
		}
		else
		{
			echo 1;
		}
		break;

	case 'catid_select':
		//print_r($CATEGORY);
		echo $CATEGORY[$catid]['child'];
		break;
	
	case 'cat_name':
		echo $CATEGORY[$catid]['catname'];
		break;
	
	case 'collect_favorite':
		include MOD_ROOT.'include/collect.class.php';
		$c = new collect();
		$c->add($userid,$title,$forward);
		break;
}
?>