<?php 
defined('IN_PHPCMS') or exit('Access Denied');

update_freelink($type);

include PHPCMS_ROOT.'/data/freelink/'.urlencode($type).'.html';
?>