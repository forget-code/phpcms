<?php
if (ini_get('session.save_handler') != 'files' || !function_exists('eaccelerator_get') || !function_exists('eaccelerator_put'))
{
    return true;
} 
else
{
    function open($save_path, $session_name)
    {
        global $sess_save_path, $sess_session_name;
        $sess_save_path = $save_path;
        $sess_session_name = $session_name;
        return(true);
    } 

    function close()
    {
        return(true);
    } 

    function read($id)
    {
        global $sess_save_path, $sess_session_name;
        $sess_file = "$sess_save_path/sess_$id";
        return eaccelerator_get(md5($sess_file));
    } 

    function write($id, $sess_data)
    {
        global $sess_save_path, $sess_session_name;
        $sess_file = "$sess_save_path/sess_$id";
		$sesss_maxlifetime = ini_get('session.gc_maxlifetime');
        return eaccelerator_put(md5($sess_file), $sess_data, $sesss_maxlifetime);
    } 

    function destroy($id)
    {
        global $sess_save_path, $sess_session_name;
        $sess_file = "$sess_save_path/sess_$id";
        return eaccelerator_rm(md5($sess_file));
    } 

    function gc($maxlifetime)
    {
        if (function_exists('eaccelerator_gc'))
        {
            eaccelerator_gc();
        } 
        return true;
    } 

    session_set_save_handler('open', 'close', 'read', 'write', 'destroy', 'gc');

    if (ini_get('session.auto_start') == '1')
    {
        session_start();
    } 
} 
// proceed to use sessions normally
?>