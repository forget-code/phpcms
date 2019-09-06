<?php
function ubb($string) {
		$searcharray['bbcode_regexp'] = array(
			"/\s*\[quote\][\n\r]*(.+?)[\n\r]*\[\/quote\]\s*/is",
			"/(\[box=(#[0-9A-F]{6}|[a-z]+)\])[\n\r]*(.+?)[\n\r]*(\[\/box\])/is",
			"/\[url\]\s*(www.|https?:\/\/|ftp:\/\/|gopher:\/\/|news:\/\/|telnet:\/\/|rtsp:\/\/|mms:\/\/){1}([^\[\"']+?)\s*\[\/url\]/ie",
			"/\[url=www.([^\[\"']+?)\](.+?)\[\/url\]/is",
			"/\[url=(https?|ftp|gopher|news|telnet|rtsp|mms){1}:\/\/([^\[\"']+?)\](.+?)\[\/url\]/is",
			"/\[email\]\s*([A-Za-z0-9\-_.]+)@([A-Za-z0-9\-_]+[.][A-Za-z0-9\-_.]+)\s*\[\/email\]/i",
			"/\[email=([A-Za-z0-9\-_.]+)@([A-Za-z0-9\-_]+[.][A-Za-z0-9\-_.]+)\](.+?)\[\/email\]/is",
			"/\[color=([^\[]+?)\]/i",
			"/\[size=([^\[]+?)\]/i",
			"/\[font=([^\[]+?)\]/i",
			"/\[align=([^\[]+?)\]/i",
			"/\[center\]/i",
			"/\[swf\]\s*([^\[]+?)\s*\[\/swf\]/ies",
			"/\[img\]\s*([^\[]+?)\s*\[\/img\]/ies",
			"/\[img=(\d{1,3})[x|\,](\d{1,3})\]\s*([^\[]+?)\s*\[\/img\]/ies"
		);
		$replacearray['bbcode_regexp'] = array(
			"<br><br><center><table border=\"0\" width=\"90%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td>&nbsp;&nbsp;Quote:</td></tr><tr><td><table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"10\" bgcolor=\"".BORDERCOLOR."\"><tr><td width=\"100%\" bgcolor=\"".ALTBG2."\" style=\"word-break:break-all\">\\1</td></tr></table></td></tr></table></center><br>",
			"<blockquote style=\"background-color: \\2 ;\"><span class=\"bold\">$title</span>\\3</blockquote>",
			"cuturl('\\1\\2')",
			"<a href=\"http://www.\\1\" target=\"_blank\">\\2</a>",
			"<a href=\"\\1://\\2\" target=\"_blank\">\\3</a>",
			"<a href=\"mailto:\\1@\\2\">\\1@\\2</a>",
			"<a href=\"mailto:\\1@\\2\">\\3</a>",
			"<font color=\"\\1\">",
			"<font size=\"\\1\">",
			"<font face=\"\\1\">",
			"<p align=\"\\1\">",
			"<p align=\"center\">",
			"bbcodeurl('\\1', ' <img src=\"images/flash.gif\" align=\"absmiddle\"> <a href=\"%s\" target=\"_blank\">Flash: %s</a> ')",
			"bbcodeurl('\\1', '<img src=\"%s\" border=\"0\" onload=\"if(this.width>screen.width*0.7) {this.resized=true; this.width=screen.width*0.7; this.alt=\'Click here to open new window\';}\" onmouseover=\"if(this.resized) this.style.cursor=\'hand\';\" onclick=\"if(this.resized) {window.open(\'%s\');}\">')",
			"bbcodeurl('\\3', '<img width=\"\\1\" height=\"\\2\" src=\"%s\" border=\"0\">')"
		);

		$searcharray['bbcode_str'] = array(
			'[/color]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]',
			'[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
			'[list=A]', '[*]', '[/list]','[/center]'
		);

		$replacearray['bbcode_str'] = array(
			'</font>', '</font>', '</font>', '</p>', '<b>', '</b>', '<i>',
			'</i>', '<u>', '</u>', '<ul>', '<ol type=1>', '<ol type=a>',
			'<ol type=A>', '<li>', '</ul></ol>','</p>'
		);                  
		$string = str_replace($searcharray['bbcode_str'], $replacearray['bbcode_str'], preg_replace($searcharray['bbcode_regexp'], $replacearray['bbcode_regexp'], $string));

                return $string;
}

function bbcodeurl($url, $tags) {
	if(!preg_match("/<.+?>/s",$url)) {
		if(!in_array(strtolower(substr($url, 0, 6)), array('http:/', 'ftp://', 'rtsp:/', 'mms://'))) {
			$url = 'http://'.$url;
		}
		return str_replace('submit', '', sprintf($tags, $url, $url));
	} else {
		return '&nbsp;'.$url;
	}
}

function cuturl($url) {
	$length = 65;
	$urllink = "<a href=\"".(substr(strtolower($url), 0, 4) == 'www.' ? "http://$url" : $url).'" target="_blank">';
	if(strlen($url) > $length) {
		$url = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
	}
	$urllink .= $url.'</a>';
	return $urllink;
}
?>