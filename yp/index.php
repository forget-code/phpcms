<?php
require './include/common.inc.php';
cache_page_start();
$template = 'index';
$C = subcat('yp', 0);
$lettercat = array('a'=>NULL,'b'=>NULL,'c'=>NULL,'d'=>NULL,'e'=>NULL,'f'=>NULL,'g'=>NULL,'h'=>NULL,'i'=>NULL,'j'=>NULL,'k'=>NULL,'l'=>NULL,
'm'=>NULL,'n'=>NULL,'o'=>NULL,'p'=>NULL,'q'=>NULL,'r'=>NULL,'s'=>NULL,'t'=>NULL,'u'=>NULL,'v'=>NULL,'w'=>NULL,'x'=>NULL,'y'=>NULL,'z'=>NULL,);
foreach($CATEGORY as $p)
{
	if($p['letter'] && $p['module'] == 'yp')$lettercat[$p['letter']][] = $p;
}
ksort($lettercat);
$head['keywords'] = $M['name'].'_'.$M['seo_keywords'];
$head['title'] = $M['name'].'_'.$M['seo_title'].'_'.$PHPCMS['sitename'];
$head['description'] = $M['name'].'_'.$M['seo_description'].'_'.$PHPCMS['sitename'];

include template('yp',$template);
cache_page(intval($M['cache_index']));
?>