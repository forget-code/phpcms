<?php
require dirname(__FILE__).'/include/common.inc.php';
$head['title'] = $PHPCMS['sitename'].'_'.$PHPCMS['meta_title'];
$head['keywords'] = $PHPCMS['meta_keywords'];
$head['description'] = $PHPCMS['meta_description'];
header('Last-Modified: '.gmdate('D, d M Y H:i:s', TIME).' GMT');
header('Expires: '.gmdate('D, d M Y H:i:s', TIME+CACHE_PAGE_INDEX_TTL).' GMT');
header('Cache-Control: max-age='.CACHE_PAGE_INDEX_TTL.', must-revalidate');

include template('phpcms', 'index');
cache_page(CACHE_PAGE_INDEX_TTL);
?>