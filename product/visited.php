<?php 
include_once './include/common.inc.php';

if($productid) $productid = intval($productid);
$visitednum = intval($visitednum);
$visitednum = $visitednum>100 ? 100 : $visitednum;
$visitedproduct = getcookie("visitedproduct");
$visitedarray = array();
if($visitedproduct)
{
	$visitedarray = explode(',',$visitedproduct);
}
$visitedarray = array_unique($visitedarray);
$visitedarray = array_filter($visitedarray);
$visitedproduct = implode(',',$visitedarray);
if(!in_array($productid,$visitedarray))
{
	mkcookie('visitedproduct',$visitedproduct.','.$productid);
}
$invisit = '';
$visitedcount = count($visitedarray);
$visitednum = $visitedcount<$visitednum ? $visitedcount : $visitednum;
foreach($visitedarray as $v)
{
	if($v !=$productid && $v) $invisit.= $v.',';
}
$invisit = substr($invisit,0,-1);
$html = '';
if($invisit)
{
	$i = 0;
	$result = $db->query("SELECT pdt_name,pdt_img,linkurl FROM ".TABLE_PRODUCT." WHERE productid IN($invisit)");	
	while($r = $db->fetch_array($result))
	{
		if($i>=$visitednum) break;
		$html.= "<li><a href=\"".linkurl($r['linkurl'])."\"><img src=\"".imgurl($r['pdt_img'])."\" alt=\"".$r['pdt_name']."\" border=\"0\" /></a></li>";
		$i++;
	}
}
echo "$('visitedproduct').innerHTML = '".addslashes($html)."';";

?>