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
        return eaccelerator_get($name);
    }

    function set($name, $value, $ttl = 0)
    {
        eaccelerator_lock($name);
        return eaccelerator_put($name, $value, $ttl);
    }

    function rm($name)
    {
        return eaccelerator_rm($name);
    }

    function clear()
    {
        return eaccelerator_gc();
    }
}
?>