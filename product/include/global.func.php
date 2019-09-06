<?php

function is_systemdir($dir)
{
	global  $MOD;
	$sysdir = array($MOD['moduledir'],
					$MOD['moduledir'].'/admin',
					$MOD['moduledir'].'/include',
					$MOD['moduledir'].'/'.$MOD['uploaddir']
					);
	return in_array($dir,$sysdir);	
}
?>