<?php 
defined('IN_PHPCMS') or exit('Access Denied');

ob_start();
voteshow(0,$voteid);
$data = ob_get_contents();
ob_clean();
$data = strip_js($data);
$jsname = PHPCMS_ROOT.'/vote/data/vote_'.$voteid.'.js';
file_write($jsname,$data);
?>