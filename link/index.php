<?php
require_once './include/common.inc.php';
require_once 'form.class.php';
require_once MOD_ROOT.'include/link.class.php';
$link = new link();
if(isset($typeid))
{
	$datas = subtype('link');
    $link_name = $TYPE[$typeid][name];
	$tid = intval($typeid) ? intval($typeid) : 0;
	if($tid)
	{
		$link_logo = $link->listinfo("where typeid=$tid and linktype=1 and passed =1");
		$link_word = $link->listinfo("where typeid=$tid and linktype=0 and passed =1");
	}
	include template('link', 'list');
}
else
{
    $datas = subtype('link');
    foreach($datas AS $data)
    {
        $link_logos[$data[typeid]] = $link->listinfo("where passed =1 AND linktype=1 AND typeid ='$data[typeid]'");
        $link_words[$data[typeid]] = $link->listinfo("where passed =1 AND linktype=0 AND typeid ='$data[typeid]'");
    }
	include template('link', 'index');
}

?>