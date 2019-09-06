<?php
class scws
{
	var $sh;

	function scws()
	{
		$this->sh = scws_open();
	}

	function set_charset($charset = 'gbk')
	{
		return scws_set_charset($this->sh, $charset);
	}

	function set_dict($path)
	{
		return scws_set_dict($this->sh, $path);
	}

	function set_rule($path)
	{
		return scws_set_rule($this->sh, $path);
	}

	function set_ignore($isignore = true)
	{
		return scws_set_ignore($this->sh, $isignore);
	}

	function set_multi($ismulti = true)
	{
		return scws_set_multi($this->sh, $ismulti);
	}

	function set($dict = '', $rule = '', $charset = 'gbk', $isignore = true, $ismulti = true)
	{
		if($dict) $this->set_dict($dict);
		if($rule) $this->set_rule($rule);
		if($charset) $this->set_charset($charset);
		$this->set_ignore($isignore);
		$this->set_multi($ismulti);
	}

	function set_text($text)
	{
		return scws_send_text($this->sh, strip_tags($text));
	}

	function get_result()
	{
		return scws_get_result($this->sh);
	}

	function get_tops($limit = 10, $attr = NULL)
	{
		return scws_get_tops($this->sh, $limit, $attr);
	}

	function get_words($attr = 'c,e,f,o,p,u,w,y,uj')
	{
		$this->set_ignore(true);
		$this->set_multi(true);
		if($attr) $attr = explode(',', $attr);
		$words = '';
		while($r = scws_get_result($this->sh))
		{
			foreach($r as $v)
			{
				if(($attr && in_array($v['attr'], $attr)) || trim($v['word']) == '') continue;
				$words .= ' '.$v['word'];
			}
		}
		return trim($words);
	}

	function get_keywords($number = 3, $attr = 'n,nr,ns,nt,nz,vn')
	{
		$this->set_multi(false);
		$words = '';
		$array = $this->get_tops($number, $attr);
		if(!$array) return '';
		foreach($array as $r)
		{
			$words .= ' '.$r['word'];
		}
		return trim($words);
	}

	function close()
	{
		return scws_close($this->sh);
	}

	function version()
	{
		return scws_version();
	}
}
?>