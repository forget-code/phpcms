<?php
defined('IN_PHPCMS') or exit('Access Denied');

switch($action)
{
	case 'index':
		createhtml('index');
        createhtml('search');
		showmessage($LANG['home_update_success']);
	break;

	case 'search':
        createhtml('search');
		showmessage($LANG['search_frame_update_success']);
    break;
}

?>