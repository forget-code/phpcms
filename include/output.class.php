<?php
class output
{
	function style($title, $style = '')
	{
		return $style == '' ? $title : "<span class=\"$style\">$title</span>";
	}
}
?>