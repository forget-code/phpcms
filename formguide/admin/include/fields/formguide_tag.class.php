<?php
class formguide_tag
{
	var $db;
	var $formid;
	var $fields;
	var $table;

    function __construct($formid)
    {
		global $db;
		$this->db = &$db;
		$this->formid = $formid;
		$this->fields = cache_read($this->formid.'_formfields.inc.php', CACHE_MODEL_PATH);
		$this->table = DB_PRE.'formguide_fields';
    }

    function formguide_tag($formid)
    {
    	$this->__construct($formid);	
    }
    
	function get()
	{
		$where = "WHERE formid='$this->formid'";
		$sql = "SELECT * FROM $this->table $where";
		return $sql;
	}

}?>