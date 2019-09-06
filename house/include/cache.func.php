<?php

function cache_brands()
{
	global $db;
	$data = array();
    $query = $db->query("SELECT brand_id,brand_name,brand_frequency,brand_icon,brand_description FROM ".TABLE_PRODUCT_BRAND."  ORDER by brand_frequency DESC");
    while($r = $db->fetch_array($query))
	{
		$brand_id = $r['brand_id'];
        $data[$brand_id] = $r;
		$brand_ids[] = $brand_id;
    }
	cache_write("product_brands.php", $data);
	return $brand_ids;
}

?>