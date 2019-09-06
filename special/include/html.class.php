<?php
class html
{
	var $url;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'special';
		$this->url = load('url.class.php', 'special', 'include');
		if(!defined('CREATEHTML')) define('CREATEHTML', 1);
    }

	function html()
	{
		$this->__construct();
	}

	function index()
	{
		extract($GLOBALS, EXTR_SKIP);
		$TYPE = subtype('special');
		$head['title'] = '专题_'.$PHPCMS['sitename'];
		ob_start();
		include template('special', 'index');
		$file = MOD_ROOT.$this->url->index();
		return createhtml($file);
	}

	function type($typeid, $page = 0)
	{
		extract($GLOBALS, EXTR_SKIP);
		if(!isset($TYPE[$typeid])) return false;
		$typename = $TYPE[$typeid]['name'];
        $head['title'] = $TYPE[$typeid]['name'].'_'.$PHPCMS['sitename'];
		$head['keywords'] = $TYPE[$typeid]['name'];
		$head['description'] = strip_tags($TYPE[$typeid]['description']);
		ob_start();
		include template('special', 'type');
		$file = MOD_ROOT.$this->url->type($typeid, $page);
		return createhtml($file);
	}

	function show($specialid)
	{
		extract($GLOBALS, EXTR_SKIP);
		$r = $this->db->get_one("SELECT * FROM $this->table WHERE specialid=$specialid");
		if(!$r || $r['disabled']) return false;
		extract($r);
		$head['title'] = $title.'_'.$TYPE[$typeid]['name'].'_'.$PHPCMS['sitename'];
		$head['keywords'] = $title;
		$head['description'] = strip_tags($description);
		ob_start();
		include template('special', $template);
		$file = MOD_ROOT.$this->url->show($specialid, $filename, $typeid);
		return createhtml($file);
	}
}
?>