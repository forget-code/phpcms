<?php
defined('IN_PHPCMS') or exit('Access Denied');

class field
{
	var $table = '';
	var $fieldtypes = array('varchar', 'int','date', 'text', 'mediumtext', 'longtext');
	var $db;
	var $fieldlist;

    function field($table = '')
    {
		global $db;
        $this->table = $table;
		$this->db = &$db;
		if($this->table) $this->fieldlist = $this->get_list();
    }

    function add($name, $type, $size, $defaultvalue = '', $options = '', $title = '', $note = '', $formtype = '', $inputtool = '', $inputlimit = '', $enablehtml = 1, $enablelist = 1, $enablesearch = 0)
    {
		if(!in_array($type, $this->fieldtypes) || $this->exists($name)) return FALSE;
		$size = intval($size);
		$fieldsize = $type == 'varchar' ? min($size, 255) : ($type == 'int' ? min($size, 10) : 0);
		$fieldtype = strtoupper($type);
		if($fieldsize) $fieldtype .= "( $fieldsize )";
        $this->db->query("ALTER TABLE $this->table ADD $name $fieldtype NOT NULL");
        $this->db->query("INSERT INTO ".TABLE_FIELD."(tablename,name,type,size,defaultvalue,options,title,note,formtype,inputtool,inputlimit,enablehtml,enablelist,enablesearch) VALUES('$this->table','$name','$type','$size','$defaultvalue','$options','$title','$note','$formtype','$inputtool','$inputlimit','$enablehtml','$enablelist','$enablesearch')");
		$result = $this->db->affected_rows();
		$this->cache();
		return $result;
    }

    function edit($fieldid, $type, $size, $defaultvalue = '', $options = '', $title = '', $note = '', $formtype = '', $inputtool = '', $inputlimit = '', $enablehtml = 1, $enablelist = 1, $enablesearch = 0)
    {
		if(!in_array($type, $this->fieldtypes)) return FALSE;
		$fieldid = intval($fieldid);
		$field = $this->get_info($fieldid);
		$name = $field['name'];
		$size = intval($size);
		$fieldsize = $type == 'varchar' ? min($size, 255) : ($type == 'int' ? min($size, 10) : 0);
		$fieldtype = strtoupper($type);
		if($fieldsize) $fieldtype .= "( $fieldsize )";
        $this->db->query("ALTER TABLE `$this->table` CHANGE `$name` `$name` $fieldtype NOT NULL");
        $this->db->query("UPDATE ".TABLE_FIELD." SET title='$title',note='$note',type='$type',size='$size',defaultvalue='$defaultvalue',options='$options',formtype='$formtype',inputtool='$inputtool',inputlimit='$inputlimit',enablehtml='$enablehtml',enablelist='$enablelist',enablesearch='$enablesearch' WHERE fieldid=$fieldid");
		$result = $this->db->affected_rows();
		$this->cache();
		return $result;
	}

    function delete($fieldid)
    {
		$fieldid = intval($fieldid);
		$r = $this->db->get_one("SELECT name FROM ".TABLE_FIELD." WHERE fieldid=$fieldid");
		if(!$r) return FALSE;
		$name = $r['name'];
	    $this->db->query("ALTER TABLE $this->table DROP $name");
        $this->db->query("DELETE FROM ".TABLE_FIELD." WHERE fieldid=$fieldid");
		$result = $this->db->affected_rows();
		$this->cache();
		return $result;
    }

	function get_columns()
	{
		$columns = $s = '';
		$query = $this->db->query("SHOW COLUMNS FROM $this->table like 'my_%' ");
		while($r = $this->db->fetch_row($query))
		{
			$columns .= $s.$r[0];
			$s = ',';
		}
		$this->db->free_result($query);
		return $columns;
	}

	function get_list()
	{
		$rs = array();
		$query = $this->db->query("SELECT * FROM ".TABLE_FIELD." WHERE tablename='$this->table' ORDER BY listorder,fieldid");
		while($r = $this->db->fetch_array($query))
		{
			$rs[] = $r;
		}
		$this->db->free_result($query);
		return $rs;
	}

	function get_info($fieldid)
	{
		$fieldid = intval($fieldid);
		return $this->db->get_one("SELECT * FROM ".TABLE_FIELD." WHERE fieldid=$fieldid");
	}

	function get_form($style = '<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$input $tool $note</td></tr>')
	{
		if(!$this->fieldlist) return FALSE;
		$string = '';
		foreach($this->fieldlist as $field)
		{
			if(isset($GLOBALS[$field['name']])) $field['defaultvalue'] = $GLOBALS[$field['name']];
			if($field['inputlimit'] == 'unique' && $field['defaultvalue']) continue;
			if($field['type'] == 'date' && $field['defaultvalue'] == '0000-00-00') $field['defaultvalue'] = ''; 
			if($field['formtype'] == 'text')
			{
				$input = '<input type="text" size="40" name="'.$field['name'].'" id="'.$field['name'].'" value="'.$field['defaultvalue'].'" class="'.$field['name'].'" /> ';
			}
			elseif($field['formtype'] == 'textarea')
			{
				$input = '<textarea name="'.$field['name'].'" id="'.$field['name'].'" rows="8" cols="50" class="'.$field['name'].'">'.$field['defaultvalue'].'</textarea>';
			}
			elseif($field['formtype'] == 'select')
			{
				$input = "<select name='".$field['name']."' id='".$field['name']."' class='".$field['name']."'>\n";
				$options = explode("\n",$field['options']);
				foreach($options as $option)
				{
					if(strpos($option, '|'))
					{
						list($name, $value) = explode('|', trim($option));
					}
					else
					{
						$name = $value = trim($option);
					}
					$selected = $field['defaultvalue'] == $value ? 'selected' : '';
					$input .= "<option value='".$value."' ".$selected.">".$name."</option>\n";
				}
				$input .= "</select>\n";
			}
			elseif($field['formtype'] == 'radio')
			{
				$input = '';
				$options = explode("\n",$field['options']);
				foreach($options as $option)
				{
					if(strpos($option, '|'))
					{
						list($name, $value) = explode('|', trim($option));
					}
					else
					{
						$name = $value = trim($option);
					}
					$checked = $field['defaultvalue'] == $value ? 'checked' : '';
					$input .= '<input type="radio" name="'.$field['name'].'" value="'.$value.'" class="'.$field['name'].'" '.$checked.'> '.$name.' ';
				}
			}
			elseif($field['formtype'] == 'checkbox')
			{
				$field['defaultvalue'] = strpos($field['defaultvalue'], ',') ? explode(',', $field['defaultvalue']) : array($field['defaultvalue']);
				$input = '';
				$options = explode("\n",$field['options']);
				foreach($options as $option)
				{
					if(strpos($option, '|'))
					{
						list($name, $value) = explode('|', trim($option));
					}
					else
					{
						$name = $value = trim($option);
					}
					$checked = in_array($value, $field['defaultvalue']) ? 'checked' : '';
					$input .= '<input type="checkbox" name="'.$field['name'].'[]" value="'.$value.'" class="'.$field['name'].'" '.$checked.'> '.$name.' ';
				}
			}
			elseif($field['formtype'] == 'password')
			{
				$input = '<input type="password" name="'.$field['name'].'" id="'.$field['name'].'" value="'.$field['defaultvalue'].'" class="'.$field['name'].'" /> ';
			}
			elseif($field['formtype'] == 'hidden')
			{
				$input = '<input type="hidden" name="'.$field['name'].'" id="'.$field['name'].'" value="'.$field['defaultvalue'].'"/> ';
			}
		    $title = $field['title'];
		    $note = $field['note'];
			$tool = $this->get_tool($field['inputtool'], $field['name'], $field['defaultvalue']);
            $string .= str_replace(array('$title','$input','$tool','$note'), array($title,$input,$tool,$note), $style);
		}
        return $string;
	}

	function get_tool($inputtool, $name, $value = '')
	{
		global $LANG;
		if(empty($inputtool))
		{
			return '';
		}
		elseif($inputtool == 'dateselect')
		{
	        global $iscalendarinit;
			if($value == '0000-00-00') $value = '';
			$id = str_replace(array('[',']'), array('',''), $name);
			$str = '';
			if(!$iscalendarinit)
			{
				$iscalendarinit = 1;
				$str .= "<script language=\"javascript\">var imgDir = \"".PHPCMS_PATH."include/calendar/\";</script>\n<script language=\"javascript\" src=\"".PHPCMS_PATH."include/calendar/calendar.js\"></script>\n";
			}
			$str .= '&nbsp;<img src="'.PHPCMS_PATH.'include/calendar/date_selector.gif" border="0" align="absMiddle" style="cursor:pointer" onclick="popUpCalendar(this,document.getElementById(\''.$id.'\'),\'yyyy-mm-dd\');">';
			return $str;
		}
		elseif($inputtool == 'fileupload')
		{
			global $mod, $channelid;
			$keyid = $channelid ? $channelid : $mod;
			$openurl = defined('IN_ADMIN') ? '?mod=phpcms&file=uppic&keyid='.$keyid.'&uploadtext='.$name : PHPCMS_PATH.'upload.php?keyid='.$keyid.'&uploadtext='.$name;

			return ' <input type="button" value=" '.$LANG['upfile'].' " onClick="javascript:openwinx(\''.$openurl.'\',\'upload\',\'350\',\'200\')">';
		}
		elseif($inputtool == 'imageupload')
		{
			global $mod,$channelid;
			$keyid = $channelid ? $channelid : $mod;
			$openurl = defined('IN_ADMIN') ? '?mod=phpcms&file=uppic&keyid='.$keyid.'&uploadtext='.$name : PHPCMS_PATH.'upload.php?keyid='.$keyid.'&type=thumb&uploadtext='.$name;
            return ' <input type="button" value=" '.$LANG['uppic'].' " onClick="javascript:openwinx(\''.$openurl.'\',\'upload\',\'350\',\'350\')">';
		}
		elseif($inputtool == 'editor')
		{
			return editor($name, 'phpcms', 550, 400);
		}
	}

	function show_list($style = '<tr><td class="tablerow"><strong>$title</strong></td><td class="tablerow">$value</td></tr>')
	{
		if(!$this->fieldlist) return FALSE;
		$string = '';
		foreach($this->fieldlist as $field)
		{
		    $title = $field['title'];
			$value = $GLOBALS[$field['name']];
            $string .= str_replace(array('$title','$value'), array($title,$value), $style);
		}
        return $string;
	}

	function get_searchform($style = '<tr><td class="search_l">$title</td><td class="search_r">$input</td></tr>')
	{
		if(!$this->fieldlist) return FALSE;
		$string = '';
		foreach($this->fieldlist as $field)
		{
			if(!$field['enablesearch']) continue;
			if($field['formtype'] == 'select')
			{
				$input = "<select name='".$field['name']."' id='".$field['name']."'>\n";
				$options = explode("\n",$field['options']);
				foreach($options as $option)
				{
					if(strpos($option, '|'))
					{
						list($name, $value) = explode('|', trim($option));
					}
					else
					{
						$name = $value = trim($option);
					}
					$selected = $GLOBALS[$field['name']] == $value ? 'selected' : '';
					$input .= "<option value='".$value."' ".$selected.">".$name."</option>\n";
				}
				$input .= "</select>\n";
			}
			elseif($field['formtype'] == 'radio')
			{
				$input = '';
				$options = explode("\n",$field['options']);
				foreach($options as $option)
				{
					if(strpos($option, '|'))
					{
						list($name, $value) = explode('|', trim($option));
					}
					else
					{
						$name = $value = trim($option);
					}
					$checked = $GLOBALS[$field['name']] == $value ? 'checked' : '';
					$input .= '<input type="radio" name="'.$field['name'].'" value="'.$value.'" '.$checked.'> '.$name.' ';
				}
			}
			elseif($field['type'] == 'int')
			{
				$input = '<input type="text" name="'.$field['name'].'_from" value="'.$GLOBALS[$field['name'].'_from'].'" size="10" /> - <input type="text" name="'.$field['name'].'_to" value="'.$GLOBALS[$field['name'].'_to'].'" size="10" />';
			}
			elseif($field['type'] == 'date')
			{
				global $iscalendarinit;
				$input = '';
				if(!$iscalendarinit)
				{
					$iscalendarinit = 1;
					$input .= "<script language=\"javascript\">var imgDir = \"".PHPCMS_PATH."include/calendar/\";</script>\n<script language=\"javascript\" src=\"".PHPCMS_PATH."include/calendar/calendar.js\"></script>\n";
				}
				$input .= '<input type="text" name="'.$field['name'].'_from" value="'.$GLOBALS[$field['name'].'_from'].'" size="10" />&nbsp;<img src="'.PHPCMS_PATH.'include/calendar/date_selector.gif" border="0" align="absMiddle" style="cursor:pointer" onclick="popUpCalendar(this,document.getElementById(\''.$field['name'].'_from\'),\'yyyy-mm-dd\');">- <input type="text" name="'.$field['name'].'_to" value="'.$GLOBALS[$field['name'].'_to'].'" size="10" />&nbsp;<img src="'.PHPCMS_PATH.'include/calendar/date_selector.gif" border="0" align="absMiddle" style="cursor:pointer" onclick="popUpCalendar(this,document.getElementById(\''.$field['name'].'_to\'),\'yyyy-mm-dd\');">';
			}
			else
			{
				$input = '<input type="text" name="'.$field['name'].'" value="'.$GLOBALS[$field['name']].'" size="20" />';
			}
		    $title = $field['title'];
            $string .= str_replace(array('$title','$input'), array($title,$input), $style);
		}
        return $string;
	}

	function get_searchsql()
	{
		if(!$this->fieldlist) return FALSE;
		$sql = '';
		foreach($this->fieldlist as $field)
		{
			if(!$field['enablesearch']) continue;
			$name = $field['name'];
            if($field['formtype'] == 'select' || $field['formtype'] == 'radio')
			{
				$value = $GLOBALS[$name];
				$sql .= " AND $name='$value'";
			}
			elseif($field['type'] == 'int')
			{
				if(isset($GLOBALS[$name.'_from']) && $GLOBALS[$name.'_from'] != '')
				{
					$from = intval($GLOBALS[$name.'_from']);
                    $sql .= " AND $name>=$from";
				}
				if(isset($GLOBALS[$name.'_to']) && $GLOBALS[$name.'_to'] != '')
				{
					$to = intval($GLOBALS[$name.'_to']);
                    $sql .= " AND $name<=$to";
				}
			}
			elseif($field['type'] == 'date')
			{
				if(isset($GLOBALS[$name.'_from']) && is_date($GLOBALS[$name.'_from']))
				{
					$from = $GLOBALS[$name.'_from'];
                    $sql .= " AND $name>='$from'";
				}
				if(isset($GLOBALS[$name.'_to']) && is_date($GLOBALS[$name.'_to']))
				{
					$to = $GLOBALS[$name.'_to'];
                    $sql .= " AND $name<='$to'";
				}
			}
			elseif(isset($GLOBALS[$name]) && $GLOBALS[$name])
			{
				$value = $GLOBALS[$name];
				$sql .= " AND $name LIKE '%$value%'";
			}
		}
        return $sql;
	}

	function check_form()
	{
		global $LANG;
		foreach($this->fieldlist as $field)
		{
			$name = $field['name'];
			$value = trim($GLOBALS[$name]);
			if($field['inputlimit'] == 'notnull' && empty($value)) showmessage($field['title'].$LANG['not_null']);
			elseif($field['inputlimit'] == 'numeric' && !is_numeric($value) && !empty($value)) showmessage($field['title'].$LANG['is_numeric']);
			elseif($field['inputlimit'] == 'letter' && !preg_match("/^[a-z]+$/i", $value) && !empty($value)) showmessage($field['title'].$LANG['is_letter']);
			elseif($field['inputlimit'] == 'numeric_letter' && !preg_match("/^[0-9a-z]+$/i", $value) && !empty($value)) showmessage($field['title'].$LANG['is_numeric_or_letter']);
			elseif($field['inputlimit'] == 'email' && !is_email($value) && !empty($value)) showmessage($field['title'].$LANG['is_email']);
			elseif($field['inputlimit'] == 'date' && !is_date($value) && !empty($value)) showmessage($field['title'].$LANG['is_date']);
			elseif($field['inputlimit'] == 'unique' && $this->db->get_one("SELECT $name FROM $this->table WHERE $name='$value' ") && !empty($value)) showmessage($field['title'].$LANG['is_unique']);
		}
	}

    function listorder($listorders)
    {
		foreach($listorders as $fieldid=>$listorder)
		{
			$this->db->query("UPDATE ".TABLE_FIELD." SET listorder='$listorder' WHERE fieldid=$fieldid");
		}
    }

	function update($condition = '')
	{
		if(!$this->fieldlist) return FALSE;
		$fields = $s = ''; 
		foreach($this->fieldlist as $field)
		{
			$name = $field['name'];
			$value = $GLOBALS[$name];
			if($field['formtype'] == 'checkbox') $value = is_array($value) ? implode(',', $value) : trim($value);
			$value = $field['enablehtml'] ? str_safe($value) : new_htmlspecialchars($value);
			if($field['size'] > 0) $value = str_cut($value, $field['size'], '');
			$fields .= $s.$name."='".$value."'";
			$s = ',';
		}
		if($condition) $condition = "WHERE $condition";
		$this->db->query("UPDATE $this->table SET $fields $condition");
	}

	function cache()
	{
		cache_common();
		$this->fieldlist = $this->get_list();
		return cache_write($this->table.'_fields.php', $this->fieldlist);
	}

    function exists($name)
    {
		return $this->db->get_one("SHOW COLUMNS FROM `$this->table` like '$name' ");
	}
}
?>