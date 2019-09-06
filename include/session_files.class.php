<?php 
class session
{
    function session()
    {
		$path = SESSION_N > 0 ? SESSION_N.';'.SESSION_SAVEPATH : SESSION_SAVEPATH;
		ini_set('session.save_handler', 'files');
    	session_save_path($path);
    }
}
?>