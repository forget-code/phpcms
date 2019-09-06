<?php 
class html
{
	function __construct()
	{
	}

	function html()
	{
		$this->__construct();
	}

	//生成首页
	function index()
	{   
		extract($GLOBALS, EXTR_SKIP);
		$head['title'] = $M['name'];
		$head['keywords'] = $M['seo_keywords'];
		$head['description'] = $M['seo_description'];
		ob_start();
		$datas = subtype('link');
		include template('link','index');
		$file = PHPCMS_ROOT."/link/index.html";
		return createhtml($file);
	}
		//生成列表
	function type($typeid)
	{
		extract($GLOBALS, EXTR_SKIP);
		$head['title'] = $M['name'];
		$head['keywords'] = $M['seo_keywords'];
		$head['description'] = $M['seo_description'];
		ob_start();
		$datas = subtype('link');
		include template('link','list');
		$file = PHPCMS_ROOT."/link/list_".$typeid.".html";
		return createhtml($file);
	}
}
?>