<?php
function zhWeek($date)
{
	global $LANG;
	$week = array(
		'<span style="color:#ff0000">' . $LANG['sunday'] . '</span>',
		$LANG['monday'],
		$LANG['tuesday'],
		$LANG['wednesday'],
		$LANG['thursday'],
		$LANG['friday'],
		'<span style="color:#ff0000">' . $LANG['saturday'] . '</span>'
	);
	$key = date('w', strtotime($date));
	return $week[$key];
}
?>