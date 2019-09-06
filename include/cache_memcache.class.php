<?php 
class cache
{
	var $memcache;

    function __construct()
    {
		$this->memcache = &new Memcache;
		$this->memcache->pconnect(MEMCACHE_HOST, MEMCACHE_PORT, MEMCACHE_TIMEOUT);
    }

    function cache()
    {
		$this->__construct();
    }

	function get($name)
    {
        return $this->memcache->get($name);
    }

    function set($name, $value, $ttl = 0)
    {
         return $this->memcache->set($name, $value, 0, $ttl);
    }

    function rm($name)
    {
        return $this->memcache->delete($name);
    }

    function clear()
    {
        return $this->memcache->flush();
    }
}
?>