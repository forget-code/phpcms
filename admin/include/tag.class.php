<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/template.func.php';

class tag
{
	var $mod;
	var $tags;
	var $tags_config;
	var $tags_config_path;
	var $tags_path;
	var $badchars = array('\'', '"', '$', '{', '}', ' ', '\\', '/', '(', ')', ',', ';', '=');

	function tag($mod, $template = '')
	{
		$this->set_tag($mod, $template);
        register_shutdown_function(array(&$this, '__destruct'));
	}

	function __destruct()
	{
        unset($this->tags);
        unset($this->tags_config);        
        unset($this->tags_config_path);        
        unset($this->tags_path);        
        unset($this->badchars);        
	}

	function set_tag($mod, $template = '')
	{
		global $CONFIG;
		$this->mod = $mod;
		$template = $template ? $template : $CONFIG['defaulttemplate'];
		$this->tags_config_path = PHPCMS_ROOT.'/templates/'.$template.'/'.$mod.'/tags_config.php';
		$this->tags_path = PHPCMS_ROOT.'/templates/'.$template.'/tags.php';
		$this->html_path = PHPCMS_ROOT.'/templates/'.$template.'/html.php';
		@include $this->tags_config_path;
		@include $this->tags_path;
		@include $this->html_path;
		$this->tags_config = $tags_config;
		$this->tags = $tags;
		$this->html = $html;
	}

	function update($tagname, $config = '', $rule = '')
	{
		global $_username,$MODULE;
		if($config) $tagname = $this->strip($tagname);
		if($config == '')
		{
			unset($this->tags_config[$tagname]);
			unset($this->tags[$tagname]);
			if(isset($this->html[$tagname])) unset($this->html[$tagname]);
		}
		elseif(is_array($config))
		{
			$config = new_stripslashes($config);
			$config['edittime'] = date('Y-m-d h:i:s');
			$config['editor'] = $_username;
			$tag_config = array();
			foreach($config as $k=>$v)
			{
				if(!is_numeric($v) && strpos($v, '$') === FALSE) $v = "'$v'";
				$tag_config[$k] = $v;
			}
			@extract($tag_config);
			eval("\$this->tags[\$tagname] = \"$rule\";");
			$config['longtag'] = $this->tags[$tagname];
			$this->tags_config[$tagname] = $config;
			$newtag = str_replace(array('$channelid','$keyid','$mod'), '', $this->tags[$tagname]);
			if(strpos($newtag, '$') === FALSE)
			{
				$keyid = (isset($config['channelid']) && $MODULE[$this->mod]['iscopy']) ? $config['channelid'] : "'$this->mod'";
				$this->html[$tagname] = "$keyid, '$tagname'";
			}
			elseif(isset($this->html[$tagname]))
			{
				unset($this->html[$tagname]);
			}
		}
		else
		{
			return FALSE;
		}
		$a = array_save($this->tags_config, "\$tags_config", $this->tags_config_path);
		$b = array_save($this->tags, "\$tags", $this->tags_path);
		$c = array_save($this->html, "\$html", $this->html_path);
        template_module($this->mod);
		if($this->mod != 'phpcms') template_module('phpcms');
		return $a && $b;
	}
	
	function get_tag_config($tagname)
	{
		return $this->tags_config[$tagname];
	}

	function get_tags_config($func = '')
	{
		if(!$func) return $this->tags_config;
		$tags = array();
		foreach($this->tags_config as $k=>$v)
		{
			if($v['func'] == $func) $tags[$k] = $v;
		}
		return $tags;
	}

	function get_tags()
	{
		return $this->tags;
	}

	function exists($tagname)
	{
		return array_key_exists($tagname, $this->tags);
	}

	function check($tagname)
	{
		if($tagname == '') return FALSE;
		foreach($this->badchars as $char)
		{
			if(strpos($tagname, $char) !== FALSE) return FALSE;
		}
		return TRUE;
	}

	function strip($tagname)
	{
		$tagname = trim($tagname);
		foreach($this->badchars as $char)
		{
			$tagname = str_replace($char, '', $tagname);
		}
		return str_cut($tagname, 32, '');
	}

	function writeable()
	{
		return is_writeable($this->tags_path) && is_writeable($this->tags_config_path);
	}
	function tagcache()
	{
		global $MODULE,$CONFIG;
		$tpldir = PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/';
		$tags = array();
		foreach($MODULE AS $mk=>$mv)
		{
			if(file_exists($tpldir.$mv['module'].'/tags_config.php'))
			{
				require $tpldir.$mv['module'].'/tags_config.php';
				foreach($tags_config AS $tk=>$tv)
				{
					$tags[$tk] = $tv['longtag'];
				}		
			}
		}
		$this->tags_path = $tpldir.'/tags.php';
		array_save($tags, "\$tags", $this->tags_path);
	}
}
?>