<?php 
class cache
{
	var $shm_key;
	var $shm_id;

    function __construct()
    {
    }

    function cache()
    {
		$this->__construct();
    }

    function get($name)
    {
        $this->shm_key = $this->_ftok($name);
        $this->shm_id = shmop_open($this->shm_key, 'c', 0600, 0);
        if($this->shm_id === false) return false;
		$data = shmop_read($this->shm_id, 0, shmop_size($this->shm_id));
		shmop_close($this->shm_id);
		return function_exists('gzuncompress') ? gzuncompress($data) : $data;
    }

    function set($name, $value, $ttl = 0)
    {
        if(function_exists('gzcompress')) $value = gzcompress($value, 3);
        $this->shm_key = $this->_ftok($name);
        $this->shm_id = shmop_open($this->shm_key, 'c', 0600, strlen($value));
        $result = shmop_write($this->shm_id, $value, 0);
		shmop_close($this->shm_id);
		return $result;
    }

    function rm($name)
    {
        $this->shm_key = $this->_ftok($name);
        $this->shm_id = shmop_open($this->shm_key, 'c', 0600, 0);
        $result = shmop_delete($this->shm_id);
		shmop_close($this->shm_id);
		return $result;
    }

    function _ftok($project)
    {
        if(function_exists('ftok')) return ftok(__FILE__, $project);
        if(strtoupper(PHP_OS) == 'WINNT')
		{
            $s = stat(__FILE__);
            return sprintf("%u", (($s['ino'] & 0xffff) | (($s['dev'] & 0xff) << 16) | (($project & 0xff) << 24)));
        }
		else
		{
            $filename = __FILE__.(string)$project;
            for($key = array(); sizeof($key) < strlen($filename); $key[] = ord(substr($filename, sizeof($key), 1)));
            return dechex(array_sum($key));
        }
    }
}
?>