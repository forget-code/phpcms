<?php
class yp_search_form
{
	var $db;
	var $modelid;
	var $fields;
	var $common_fields;
	var $contentid;

    function __construct()
    {
		global $db;
		$this->db = &$db;
        $this->fields = $this->common_fields = cache_read('common_fields.inc.php', 'fields/');
		$catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
		if($catid > 0) $this->set_catid($catid);
        $this->set();
    }

	function yp_search_form()
	{
		$this->__construct();
	}

	function set()
	{
		$this->where = array();
		if(!is_array($this->fields) || empty($this->fields)) return true;
		foreach($this->fields as $field=>$v)
		{
			$func = $v['formtype'];
			if($v['issearch'] && method_exists($this, $func))
			{
				$value = isset($_GET[$field]) ? $_GET[$field] : '';
				$form = $this->$func($field, $value, $v);
				if($form !== false) 
				{
					$this->where[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$v['minlength']);
				}
			}
			if($v['isorder'])
			{
				$pre = isset($this->common_fields[$field]) ? 'a.' : 'b.';
				$this->order[$pre.$field.' ASC'] = $v['name'].' 升序';
				$this->order[$pre.$field.' DESC'] = $v['name'].' 降序';
			}
		}
		return true;
	}

	function set_catid($catid)
	{
		global $MODEL,$CATEGORY;
		if(!isset($CATEGORY[$catid])) return false;
		$modelid = $CATEGORY[$catid]['modelid'];
		$this->fields = cache_read($modelid.'_fields.inc.php', CACHE_MODEL_PATH);
		return true;
	}

	function get_where()
	{
		return $this->where;
	}

	function get_order()
	{
		return $this->order;
	}

	function areaid($field, $value, $fieldinfo)
	{
		global $AREA;
		extract($fieldinfo);
		$js = "<script type=\"text/javascript\">
					function area_load(id)
					{
						\$.get('load.php', { field: 'areaid', id: id, value: '".$field."' },
							  function(data){
							    \$('#$field').val(id);
								\$('#load_$field').append(data);
							  });
					}
					function area_reload()
					{
						\$('#load_$field').html('');
						area_load(0);
					}
					area_load(0);
			</script>";
		if($value)
		{
			$areaname = $AREA[$value]['name'];
			return "<input type=\"hidden\" name=\"$field\" id=\"$field\" value=\"$value\">
			<span onclick=\"this.style.display='none';\$('#reselect_$field').show();\" style=\"cursor:pointer;\">$areaname <font color=\"red\">点击重选</font></span>
			<span id=\"reselect_$field\" style=\"display:none;\">
			<span id=\"load_$field\"></span> 
			<a href=\"javascript:area_reload();\">重选</a>
			</span>$js";
		}
		else
		{
			return "<input type=\"hidden\" name=\"$field\" id=\"$field\" value=\"$value\">
			<span id=\"load_$field\"></span>
			<a href=\"javascript:area_reload();\">重选</a>$js";
		}
	}
	function box($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if($boxtype == 'radio')
		{
			return form::radio($options, $field, $field, $value, $cols, $css, $formattribute, $width);
		}
		else
		{
			return form::select($options, $field, $field, $value, $size, $css, $formattribute);
		}
	}
	function catid($field, $value, $fieldinfo)
	{
		global $CATEGORY;
		extract($fieldinfo);
		$js = "<script type=\"text/javascript\">
					function category_load(id)
					{
						\$.get('load.php', { field: 'catid', id: id },
							  function(data){
								\$('#load_$field').append(data);
							  });
					}
					function category_reload()
					{
						\$('#load_$field').html('');
						category_load(0);
					}
					category_load(0);
			</script>";
		if($value)
		{
			$catname = $CATEGORY[$value]['catname'];
			return "<input type=\"hidden\" name=\"$field\" id=\"$field\" value=\"$value\">
			<span onclick=\"this.style.display='none';\$('#reselect_$field').show();\" style=\"cursor:pointer;\">$catname <font color=\"red\">点击重选</font></span>
			<span id=\"reselect_$field\" style=\"display:none;\">
			<span id=\"load_$field\"></span> 
			<a href=\"javascript:category_reload();\">重选</a>
			</span>$js";
		}
		else
		{
			return "<input type=\"hidden\" name=\"$field\" id=\"$field\" value=\"$value\">
			<span id=\"load_$field\"></span>
			<a href=\"javascript:category_reload();\">重选</a>$js";
		}
    }
	function datetime($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		$isdatetime = $dateformat == 'datetime' ? 1 : 0;
		return form::date("{$field}[start]", $value['start'], $isdatetime).' - '.form::date("{$field}[end]", $value['end'], $isdatetime);
	}
	function editor($field, $value, $fieldinfo)
	{
		return "<input type=\"text\" name=\"$field\" value=\"$value\" size=\"20\">";
	}
	function keyword($field, $value, $fieldinfo)
	{
		$infos = cache_read('keyword.php');
		return form::text($field, $field, $value, $type, 20, $css, $formattribute);
	}
	function number($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		return form::text($field.'[start]', $field, $value['start'], 'text', 10, $css, $formattribute).' - '.form::text($field.'[end]', $field, $value['end'], 'text', 10, $css, $formattribute);
	}
	function posid($field, $value, $fieldinfo)
	{
		if(!defined('IN_ADMIN')) return false;
	    $POS = cache_read('position.php');
		extract($fieldinfo);
		array_unshift($POS, '请选择');
		return form::select($POS, $field, $field, $value);
	}
	function text($field, $value, $fieldinfo)
	{
		return form::text($field, $field, $value, 'text', 15);
	}
	function textarea($field, $value, $fieldinfo)
	{
		return "<input type=\"text\" name=\"$field\" value=\"$value\" size=\"15\">";
	}
	function title($field, $value, $fieldinfo)
	{
		return form::text($field, $field, $value, 'text', 20);
	}
	function typeid($field, $value, $fieldinfo)
	{
		return form::select_type('phpcms', $field, $field, '不限', $value);
	}
	function userid($field, $value, $fieldinfo)
	{
		return "<input type=\"text\" name=\"$field\" id=\"$field\" value=\"$value\" size=\"10\">";
	}
}
?>