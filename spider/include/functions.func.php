<?php
function cache_array($array,$arrayname,$file)
{
	$data = var_export($array,TRUE);
	$data = "<?php\n".$arrayname."=".$data.";\n?>\n";
	file_write($file,$data);
	return $array;
}
?>