<?php 
class phpcms_session
{
	var $lifetime = 1800;

    function __construct()
    {
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
		session_start();
    }

    function phpcms_session()
    {
		$this->__construct();
    }

    function open($save_path, $session_name)
	{
		global $db,$CONFIG,$PHP_TIME;
	    $this->lifetime = 1800;
	    $this->time = $PHP_TIME;
		$this->pre = $CONFIG['tablepre'];
		$this->sess = &$db;
		return true;
    }

    function close()
	{
		$this->gc($this->lifetime);
        return $this->sess->close();
    } 

    function read($id)
	{
		$r = $this->sess->get_one("SELECT data FROM `{$this->pre}sessions` WHERE sessionid='$id'");
		return $r ? $r['data'] : '';
    } 

    function write($id, $sess_data)
	{
		global $PHP_TIME;
        $this->sess->query("REPLACE INTO `{$this->pre}sessions` (sessionid, data, lastvisit) VALUES('$id', '".addslashes($sess_data)."', '".$PHP_TIME."')");
		return true;
    } 

    function destroy($id)
	{ 
		$this->sess->query("DELETE FROM `{$this->pre}sessions` WHERE sessionid='$id'");
		return true;
    } 

    function gc($maxlifetime)
	{
		$expiretime = $this->time-$maxlifetime;
		$this->sess->query("DELETE FROM `{$this->pre}sessions` WHERE lastvisit<$expiretime");
		return true;
    }
}
?>