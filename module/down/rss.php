<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : 'result';
$referer = $referer ? $referer : $PHP_REFERER;
$rows = intval($rows);
$rows = $rows>0 ? $rows : 50;    //定义数量
$catid=intval($catid)>0 ? intval($catid) : 0 ;
if($catid>0 && !isset($_CAT[$catid])){
    message('参数错误！','goback');
}

header("Content-type:application/xml");
if($catid>0)
{
	     $cat = $_CAT[$catid];
         $title = htmlspecialchars($cat[catname]);
         $introduce = htmlspecialchars($cat[introduce]);

print <<< END
<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/">

<channel about="$PHP_URL">
<title>$title</title> 
<link>$PHP_URL</link>
<description>$introduce</description>
<dc:language>zh-cn</dc:language>
END;

	$sql=$db->query("select downid,catid,introduce,title,elite,addtime from ".TABLE_DOWN." where elite>0 and status=3 and recycle=0 and channelid=$channelid and catid in($cat[arrchildid]) order by downid desc limit 0,$rows");
	while($r=$db->fetch_array($sql)){
		  $p->set_catid($r[catid]);
	      $r[url] = "http://".$PHP_DOMAIN.$p->get_itemurl($r[downid],$r[addtime]);
		  $r[title] = htmlspecialchars($r[title]);
		  $r[adddate] = date("Y-m-d H:i:s",$r[addtime]);
		  $r[catname] = htmlspecialchars($cat[catname]);
		  $r[caturl] = "http://".$PHP_DOMAIN.$p->get_listurl(0);
		  $r[content] = wordscut($r[introduce],500,1);

print <<< END

<item>
<title>$r[title]</title>
<link>$r[url]</link>
<pubDate>$r[adddate]</pubDate>
<guid>$r[url]</guid>
<categoryname>$r[catname]</categoryname>
<categorylink>$r[caturl]</categorylink>
<description><![CDATA[ $r[introduce] ]]></description>
</item>

END;
        }
print <<< END
</channel>
</rss>
END;

}else{

$title=htmlspecialchars($_CHA[channelname]);
$introduce=htmlspecialchars($_CHA[introduce]);

print <<< END
<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/">

<channel about="$PHP_URL">
<title>$title</title> 
<link>$PHP_URL</link>
<description>$introduce</description>
<dc:language>zh-cn</dc:language>
END;

    $result=$db->query("select downid,introduce,catid,title,ontop,elite,addtime from ".TABLE_DOWN." where elite>0 and status=3 and recycle=0  and channelid=$channelid order by ontop desc,downid desc limit 0,$rows");
    while($r=$db->fetch_array($result)){
		  $p->set_catid($r[catid]);
	      $r[url] = "http://".$PHP_DOMAIN.$p->get_itemurl($r[downid],$r[addtime]);
		  $r[title] = htmlspecialchars($r[title]);
		  $r[adddate] = date('Y-m-d H:i:s',$r[addtime]);
		  $r[catname] = htmlspecialchars($_CAT[$r[catid]][catname]);
		  $r[caturl] = "http://".$PHP_DOMAIN.$p->get_listurl(0);
		  $r[introduce] = wordscut($r[introduce],500,1);

print <<< END

<item>
<title>$r[title]</title>
<link>$r[url]</link>
<pubDate>$r[adddate]</pubDate>
<guid>$r[url]</guid>
<categoryname>$r[catname]</categoryname>
<categorylink>$r[caturl]</categorylink>
<description><![CDATA[ $r[introduce] ]]></description>
</item>

END;

   }

print <<< END
</channel>
</rss>
END;

}
?>