<?php 
class session
{
    function session()
    {
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
    }

	function open($save_path, $session_name) 
	{
		return true;
	}

	function close() 
	{
		return true;
	}

	function read($id) 
	{
         return apc_fetch($id);
	}

	function write($id, $sess_data) 
	{
		return apc_store($id, $sess_data, SESSION_TTL);
	}

	function destroy($id) 
	{
	    return apc_delete($id);
	}

	function gc($maxlifetime) 
	{
	    return true;
	}
}
?>