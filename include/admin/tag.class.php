<?php
class tag
{
	var $module;
	var $tag_path;
	var $tag_config_path;
	var $pages;
	var $number;
	var $TAG;
	var $issave = 0;

    function __construct($module)
    {
		$this->module = $module;
		$this->tag_path = TPL_ROOT.TPL_NAME.'/';
		$this->tag_config_path = $this->tag_path.'/'.$this->module.'/';
		$this->TAG = cache_read('tag.inc.php', $this->tag_path);
		$this->TAG_CONFIG = cache_read('tag_config.inc.php', $this->tag_config_path);
    }

	function tag($module)
	{
		$this->__construct($module);
	}

	function get_tag_config($tagname)
	{
		return isset($this->TAG_CONFIG[$tagname]) ? $this->TAG_CONFIG[$tagname] : false;
	}

	function get_tag($tagname)
	{
		return isset($this->TAG[$tagname]) ? $this->TAG[$tagname] : false;
	}

	function get_tagname($string)
	{

        return preg_match("/\{tag_([^}]+)\}/", $string, $m) ? $m[1] : $string;
	}

	function preview($tagname, $config, $setting = array())
	{
		if(!is_array($config) || empty($tagname)) return false;
		$config = new_stripslashes($config);
		extract($config);
		foreach($config['var_name'] as $i=>$key)
		{
			if($key) $setting[$key] = $config['var_value'][$i];
		}
		$setting = preg_replace("/'([$][^']+)'/", "\\1", str_replace("\n", '', var_export($setting, true)));
		$preview['module'] = $this->module;
		$preview['template'] = $template;
		$preview['sql'] = $sql;
		$preview['page'] = is_numeric($page) ? intval($page) : $page;
		$preview['number'] = $number;
		eval("\$setting=$setting;");
		$preview['var_description'] = $setting;
		return $preview;
	}

	function update($tagname, $config, $setting = array())
	{
		if(!is_array($config) || empty($tagname)) return false;
        $config = new_stripslashes($config);
		extract($config);
		if(!isset($page)) $page = 0;
		if(!isset($number)) $number = 100;
		foreach($config['var_name'] as $i=>$key)
		{
			if($key) $setting[$key] = $config['var_value'][$i];
		}
		$setting = preg_replace("/'([$][^']+)'/", "\\1", str_replace("\n", '', var_export($setting, true)));
		if(isset($where['catid']) && $where['catid'] && $page)
		{
			$catid = $where['catid'];
			$this->TAG[$tagname] = "tag('$this->module', '$template', \"$sql\", $page, $number, $setting, $catid)";
		}
		else
		{
			$this->TAG[$tagname] = "tag('$this->module', '$template', \"$sql\", $page, $number, $setting)";
		}
		$config['tagcode'] = $this->TAG[$tagname];
		$this->TAG_CONFIG[$tagname] = $config;
		$this->save();
		return true;
	}

	function delete($tagname)
	{
		unset($this->TAG[$tagname]);
		unset($this->TAG_CONFIG[$tagname]);
		$this->save();
		return true;
	}

	function save()
	{
		cache_write('tag.inc.php', $this->TAG, $this->tag_path);
		cache_write('tag_config.inc.php', $this->TAG_CONFIG, $this->tag_config_path);
	}

	function listinfo($type = '', $page = 1, $pagesize = 50)
	{
		if($type)
		{
			$tag_config = array();
			foreach($this->TAG_CONFIG as $tagname=>$config)
			{
				if($config['type'] == $type) $tag_config[$tagname] = $config;
			}
		}
		else
		{
			$tag_config = &$this->TAG_CONFIG;
		}
		if($page === 0)
		{
			$array = &$tag_config;
		}
		else
		{
			$array = array();
			$start = $pagesize*($page-1);
			$end = $start + $pagesize;
			$number = count($tag_config);
			if($end > $number) $end = $number;
			$i = 0;
			foreach($tag_config as $tagname=>$tag)
			{
				if($i>=$start && $i<$end) $array[$tagname] = $tag;
				$i++;
			}
			$this->pages = pages($number, $page, $pagesize);
		}
		return $array;
	}
}
?>