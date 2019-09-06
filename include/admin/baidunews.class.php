<?php
class baidunews
{
	var $baidunews = '';
	var $num = 100;
    var $db = '';
    var $table_content = '';
    var $limit = 100;
    var $updateperi = '';
	function baidunews($adminemail = '', $updateperi, $num = 100)
	{ ;
        global $db,$PHPCMS;
        $this->db = $db;
        $this->table_content = DB_PRE."content";
        $this->updateperi = $updateperi ? intval($updateperi): '40';
		$adminemail = is_email($adminemail) ?$adminemail:'';
        $webname = substr(str_replace('http://','',SITE_URL),0,-1) ;
		$this->limit = intval($num);
		$this->baidunews = "<?xml version=\"1.0\" encoding=\"".CHARSET."\" ?>\n";
		$this->baidunews .= "<document>\n";
		$this->baidunews .= "<webSite>$webname</webSite>\n";
		$this->baidunews .= "<webMaster>$adminemail </webMaster>\n";
		$this->baidunews .= "<updatePeri>$this->updateperi </updatePeri>\n";
	}
	function set_xml()
	{
        global $CATEGORY;
		if($this->limit > 100 || $this->limit < 1)
		{
			$this->limit = 10;
		}
        require_once 'admin/content.class.php';
        require_once CACHE_MODEL_PATH.'content_output.class.php';
        $c = new content();
        $out = new content_output();
        $news = array();
        $news['catids'] = array_keys($this->db->select('select `catid` from '.DB_PRE.'category where modelid != 0','catid'));
        $news['catids']  =implode(',',$news['catids']);
        $news['newsids']= array_keys($this->db->select('SELECT `contentid` FROM '.DB_PRE."content WHERE `catid` IN ($news[catids]) AND `status` = 99 ORDER BY `contentid` DESC LIMIT ".$this->limit, 'contentid')) ;

		foreach($news['newsids'] AS $k => $v)
		{
            $r = $c->get($v);
            $data = $out->get($r);
			$title = htmlspecialchars($data['title']);
			if(strpos($data['url'],'http://') === false)
			{
				$link = SITE_URL.$data['url'];
			}else
			{
				$link = $data['url'];
			}
			$link = htmlspecialchars($link);
			$description = htmlspecialchars(strip_tags($data['description']));
			$text = htmlspecialchars(strip_tags($data['content']));
            $img = preg_replace("/<img\s+src=\"([a-z_0-9\.\/:-]+)\"\s+(.+)/i","\\1",$data['thumb']);
            if(strpos($img,'http://') === false)
			{
				$image = $img;
			}else
			{
				$image = $img;
			}
			//$headlineimg = '';
			$keywords = htmlspecialchars($data['keywords']);
			$category = htmlspecialchars($CATEGORY[$data['catid']]['catname']);
			$author = htmlspecialchars($data['author']);
			$source = htmlspecialchars($data['copyfrom']);
			$pubdate = htmlspecialchars(gmdate('Y-m-d H:i',$data['inputtime'] + $this->updateperi * 3600));

			$this->baidunews .= "<item>\n";
			$this->baidunews .= "<title>$title </title>\n";
			$this->baidunews .= "<link>$link </link>\n";
			$this->baidunews .= "<description>$description </description>\n";
			$this->baidunews .= "<text>$text </text>\n";
			$this->baidunews .= "<image>$image </image>\n";
			//$this->baidunews .= "<headlineImg />\n";
			$this->baidunews .= "<keywords>$keywords </keywords>\n";
			$this->baidunews .= "<category>$category </category>\n";
			$this->baidunews .= "<author>$author </author>\n";
			$this->baidunews .= "<source>$source </source>\n";
			$this->baidunews .= "<pubDate>$pubdate </pubDate>\n";
			$this->baidunews .= "</item>\n";
		}
		$this->baidunews .= "</document>\n";

		$fp = fopen(PHPCMS_ROOT.'/baidunews.xml','w');
		fwrite($fp,$this->baidunews);
		fclose($fp);
	}
	function get_xml()
	{
	}
}
?>