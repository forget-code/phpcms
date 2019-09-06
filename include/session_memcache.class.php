<?php 
class session
{
    function session()
    {
		$session_save_path = 'tcp://'.MEMCACHE_HOST.':'.MEMCACHE_PORT.'?persistent=1&weight=2&timeout=2&retry_interval=10';
		ini_set('session.save_handler', 'memcache');
		ini_set('session.save_path', $session_save_path);
    }
}
?>