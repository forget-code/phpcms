<?php
class yp_update
{
	var $modelid;
	var $fields;
	var $contentid;

    function __construct($modelid, $contentid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->contentid = $contentid;
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
    }

	function yp_update($modelid, $contentid)
	{
		$this->__construct($modelid, $contentid);
	}

	function update($data)
	{
		$info = array();
		foreach($data as $field=>$value)
		{
			if(!isset($this->fields[$field])) continue;
			$func = $this->fields[$field]['formtype'];
			$info[$field] = method_exists($this, $func) ? $this->$func($field, $value) : $value;
		}
		return $info;
	}

	function editor($field, $value)
	{
	    global $aids,$attachment;
		if(!$value) return false;
		if($this->fields[$field]['storage'] == 'file')
		{
			content_set($this->contentid, $field, stripslashes($value));
		}
		return $attachment->update($this->contentid, $field, $value);
	}
	function groupid($field, $value)
	{
		if(!$value) return false;
		global $priv_group;
		$priv_groupid = array();
		$priv = $this->fields[$field]['priv'];
		foreach($value as $groupid)
		{
		    $priv_groupid[] = $priv.','.$groupid;
		}
		$priv_group->update('contentid', $this->contentid, $priv_groupid);
		return true;
	}
	function image($field, $value)
	{
		$aid = intval($GLOBALS[$field.'_aid']);
		if($aid < 1) return false;
		$_SESSION['field_image'] = 1;
		return $this->db->query("UPDATE `".DB_PRE."attachment` SET `contentid`=$this->contentid WHERE `aid`=$aid");
	}
	function images($field, $value)
	{
	    global $aids,$attachment;
		return $attachment->update($this->contentid, $field);
	}
	function keyword($field, $value)
	{
		$r = $this->db->get_one("SELECT `$field` FROM `".DB_PRE."content` WHERE `contentid`=$this->contentid");
		$value = $r[$field];
		$this->db->query("DELETE FROM `".DB_PRE."content_tag` WHERE `contentid`=$this->contentid");
		$keywords = explode(' ', $value);
		foreach($keywords as $tag)
		{
			$tag = addslashes(trim($tag));
			if($tag) $this->db->query("INSERT INTO `".DB_PRE."content_tag` (`tag`,`contentid`) VALUES('$tag','$this->contentid')");
		}
        if(function_exists('cache_keyword')) cache_keyword();
		return true;
	}
	function posid($field, $value)
	{
		global $action;
		$this->db->query("DELETE FROM `".DB_PRE."content_position` WHERE `contentid`='$this->contentid'");
		if($value == '-99')
		{
			if($action == 'edit') $this->db->query("UPDATE ".DB_PRE."content SET posids=0 WHERE contentid='$this->contentid'");
			return false;
		}
		if(is_array($value))
		{
			foreach($value as $posid)
			{
				$posid = intval($posid);
				$this->db->query("INSERT INTO `".DB_PRE."content_position` (`contentid`,`posid`) VALUES('$this->contentid','$posid')");
			}
		}
		return true;
	}
}
?>