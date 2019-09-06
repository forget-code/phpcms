<?php
include './include/common.inc.php';
if($savetime) $db->query("DELETE FROM ".TABLE_STAT_VISITOR." WHERE TO_DAYS(CURDATE())-TO_DAYS(etime)>$savetime");
$row = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_STAT_VISITOR." WHERE UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(ltime)<=$interval");
$numonline = $row['num'] + 1;
echo "document.write('<a href=\"".$MOD['linkurl']."\" title=\"{$LANG['visiting_statistics']}\">{$LANG['online_number']}:<span id=\"online\">$numonline</span></a>');\n";
?>
function ajaxRequest(url, postData) {
	new Ajax.Request(url,{
		method:'post',
		postBody:postData
	});
}
function ajaxUpdater() {
    var url = '<?php echo PHPCMS_PATH; ?>stat/keepol.php';
	var postData = '';
	new Ajax.PeriodicalUpdater('online',url,{
		method:'post',
		postBody:postData,
		frequency:<?php echo $interval; ?>,
		decay:1
	});
}
var sAgent = navigator.userAgent.toLowerCase();
var strPath = document.location.pathname;
var arrTemp = strPath.split("/");
var strFile = arrTemp.last();
var viewerInfo = new Array();  
viewerInfo['refurl'] = document.referrer;
viewerInfo['pageurl'] = document.location;
viewerInfo['strFile'] = strFile ? strFile.substring(0,strFile.indexOf(".")) : 'index';
<?php
$view = 0;
if($vid)
{
	$db->query("UPDATE ".TABLE_STAT_VISITOR." SET beon=1 WHERE vid=$vid");
	if ($db->affected_rows())
	{
		$view = 1;
		echo "ajaxRequest('" . PHPCMS_PATH ."stat/chpage.php', \$H(viewerInfo).toQueryString());";
	}
}
if(!$view)
{
	$times++;
	mkcookie('visits', $times, $PHP_TIME + 3600 * 24 * 365);
	require MOD_ROOT.'/include/os.inc.php';
	$brser = 'Unknow';
	$agent = $_SERVER['HTTP_USER_AGENT'];
	foreach($browsers as $browser)
	{
		if(strpos($agent, $browser) !== false)
		{
			$brser = $browser == 'MSIE' ? 'Internet Explorer' : $browser;
			break;
		}
	}
	$temp = explode(';', $agent);
	$osys = trim($temp[2]);
	$osys = preg_replace($search, $replace, $osys);
?>
viewerInfo['times'] = <?php echo $times; ?>;
viewerInfo['browser'] = '<?php echo $brser; ?>';
viewerInfo['osys'] = '<?php echo $osys; ?>';
viewerInfo['vip'] = '<?php echo $PHP_IP; ?>';
viewerInfo['language'] = navigator.browserLanguage==undefined ? navigator.language : navigator.browserLanguage;
viewerInfo['screen'] = screen.width + "X" + screen.height;
viewerInfo['color'] = screen.colorDepth ? screen.colorDepth : screen.pixelDepth;
viewerInfo['alexa'] = sAgent.indexOf('alexa toolbar') != -1 ? 1: 0;
ajaxRequest('<?php echo PHPCMS_PATH; ?>stat/newusr.php', $H(viewerInfo).toQueryString());
<?php
}
?>
Event.observe(window, 'load', ajaxUpdater);
Event.observe(window, 'focus', ajaxUpdater);
Event.observe(window, 'beforeunload', function() {
	ajaxRequest('<?php echo PHPCMS_PATH.'stat/leave.php'; ?>', '');
});
Event.observe(window, 'blur', function() {
	ajaxRequest('<?php echo PHPCMS_PATH.'stat/leave.php'; ?>', '');
});