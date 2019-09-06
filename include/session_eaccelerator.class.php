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
         return eaccelerator_get($id);
	}

	function write($id, $sess_data) 
	{
		return eaccelerator_put($id, $sess_data, SESSION_TTL);
	}

	function destroy($id) 
	{
	    return eaccelerator_rm($id);
	}

	function gc($maxlifetime) 
	{
	    return true;
	}
}
?>