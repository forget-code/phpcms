<?php
$browsers = array(
	'MSIE',
	'Firefox',
	'Netscape',
	'Lynx',
	'MOSAIC',
	'AOL',
	'Opera',
	'JAVA',
	'MacWeb',
	'WebExplorer',
	'OmniWeb'
);
$search = array(
	'/^win.*nt 5.2/i',
	'/^win.*nt 5.1/i',
	'/^win.*nt 5.0/i',
	'/^win.*nt 4/i',
	'/^win.*9x 4.9/i',
	'/^win.*98/i',
	'/^win.*95/i',
	'/^win.*32/i'
);
$replace = array(
	'Windows 2003',
	'Windows XP',
	'Windows 2000',
	'Windows NT',
	'Windows ME',
	'Windows 98',
	'Windows 95',
	'Windows 3.2'
);
?>