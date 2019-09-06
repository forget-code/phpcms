<?php 
class cache
{
    function __construct()
    {
    }

    function cache()
    {
		$this->__construct();
    }

    function get($name)
    {
        return apc_fetch($name);
    }

    function set($name, $value, $ttl = 0)
    {
        return apc_store($name, $value, $ttl);
    }

    function rm($name)
    {
        return apc_delete($name);
    }

    function clear()
    {
        return apc_clear_cache();
    }
}
?>