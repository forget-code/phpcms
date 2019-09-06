<?php 
class session
{
	var $shm_key;
	var $shm_id;

    function session()
    {
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
    }

	function open($save_path, $session_name) 
	{
		$this->shm_key = ftok(__FILE__, $id);
		return true;
	}

	function close() 
	{
		return shmop_close($this->shm_id);
	}

	function read($id) 
	{
		$this->shm_id = @shmop_open($this->shm_key, 'w', 0644, 0);
        return $this->shm_id ? shmop_read($this->shm_id, 0, shmop_size($this->shm_id)) : '';
	}

	function write($id, $sess_data) 
	{
		$this->shm_id = shmop_open($this->shm_key, 'c', 0644, strlen($sess_data));
		return shmop_write($this->shm_id, $sess_data, 0);
	}

	function destroy($id) 
	{
	    return shmop_delete($this->shm_id);
	}

	function gc($maxlifetime) 
	{
	    return true;
	}
}
?>