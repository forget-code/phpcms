<?php
require MOD_ROOT . '/include/httpdown.class.php';
require MOD_ROOT . '/admin/html_parse.class.php';
require MOD_ROOT . '/admin/tag_parse.class.php';
require MOD_ROOT . '/admin/job_parse.class.php';
include_once MOD_ROOT . '/include/get_remotefiles.func.php';
include_once MOD_ROOT . '/include/charset.func.php';
set_time_limit(0);
class MainSpider
{
    var $Article = Array();
    var $JobId = '';
    var $CJob;
    var $mod;
    var $CTagHtml = '';
    var $CFileGetContent = '';
    var $dividePageHtml = '';
    var $tid = 0;
    var $CachePath = '/rules/url/'; //2009-1-6
     
    function Init()
    {
        $this->CFileGetContent = new httpdown();
        $this->CJob = new Job_Parse();
        $this->CJob->mod = $this->mod;
        $this->CJob->GetJobInfo($this->JobId);
    } 

    function loadUrl()
    {
        global $db, $listCache, $ContentCache, $Debug, $CachePath,$M;
        $listCache = array();
        $ContentCache = array();
		$Debug = $M['Debug'];
        $CachePath = MOD_ROOT . $this->CachePath; 

        $tmp = scandir($CachePath);
        if (count($tmp) < 3)
        {
            $sql = "Select PageUrl FROM " . TABLE_SPIDER_URLS . " order by Id";
            dataLoadFromDb($sql, 'PageUrl');
            dataCache();
        } 
        else
        {
            dataLoad();
        } 
    } 

    function Close()
    {
        unset($this->Article);
        unset($this->CJob);
        dataFree(); 
    } 

    function TestRules()
    {
        global $CONFIG, $LANG;
        $start_time = getmicrotime();
        $return = "<table width=\"100%\"  border=\"0\">";
        if (isset($this->CJob->Job["url"][$this->tid])) $dourl = $this->CJob->Job["url"][$this->tid];
        else
        {
            $return .= "<tr><td colspan=2>" . $LANG['have_appoint_start_url'] . "</td></tr>\n";
            $return .= "</table>";
            echo $return;
        } 
        $htmlp = new Html_Parse();
        $basehref = '';
        $fgc = new httpdown();
        if ($this->CJob->Job['Cookie']) $fgc->puthead["Cookie"] = $this->CJob->Job['Cookie'];
        $fgc->OpenUrl(trim($dourl));
        $html = $fgc->GetHtml();
        $fgc->Close();
        $basehref = get_basehref($html);
        $htmlp->GetLinkType = "link";
        if ($html == '')
        {
            $return .= "<tr><td  colspan=2>" . $LANG['request_to_url'] . $dourl . $LANG['not_receive_any_response'] . "</td></tr>\n";
            $return .= "</table>";
            echo $return;
        } 

        $v = $html = $this->ConvertChatSet($html,'SiteEncode'); 

        if (!empty($this->CJob->Job['ListUrlStart']) && !empty($this->CJob->Job['ListUrlEnd']))
        {
            $pos = strpos($html, $this->CJob->Job['ListUrlStart']);
            $endpos = strpos($html, $this->CJob->Job['ListUrlEnd'], $pos);
            $v = '';
            if ($endpos > $pos && $pos > 0)
            {
                $v = substr($html, $pos + strlen($this->CJob->Job['ListUrlStart']), $endpos - $pos - strlen($this->CJob->Job['ListUrlStart']));
            } 
        } 
        if ($v != '')
        {
            if ($this->CJob->Job['SpiderRule'])
            { 

                $htmlp->SetSource($v, $dourl, false, false);
                $regexStr = str_replace('[缩略图]', '[参数]', $this->CJob->Job['SpiderRule']);
                $regexStr = str_replace('[实际链接]', '[参数]', $regexStr);
                $regexStr = str_replace('[标题]', '[参数]', $regexStr);
                $regexStr = "/" . $this->regexEncode($regexStr) . "/";

                $regexnum = preg_match_all($regexStr, $v, $matches);

                $thumbpos = strpos($this->CJob->Job['SpiderRule'], '[缩略图]');
                $urlpos = strpos($this->CJob->Job['SpiderRule'], '[实际链接]');
                $titlepos = strpos($this->CJob->Job['SpiderRule'], '[标题]');
                if ($thumbpos < $urlpos && $thumbpos < $titlepos)
                {
                    $thumbRow = $matches[1];
                    if ($urlpos < $titlepos)
                    {
                        $urlRow = $matches[2];
                        $titleRow = $matches[3];
                    } 
                    else
                    {
                        $urlRow = $matches[3];
                        $titleRow = $matches[2];
                    } 
                } elseif ($urlpos < $thumbpos && $urlpos < $titlepos)
                {
                    $urlRow = $matches[1];
                    if ($thumbpos < $titlepos)
                    {
                        $thumbRow = $matches[2];
                        $titleRow = $matches[3];
                    } 
                    else
                    {
                        $thumbRow = $matches[3];
                        $titleRow = $matches[2];
                    } 
                } 
                else
                {
                    $titleRow = $matches[1];
                    if ($thumbpos < $urlpos)
                    {
                        $thumbRow = $matches[2];
                        $urlRow = $matches[3];
                    } 
                    else
                    {
                        $thumbRow = $matches[3];
                        $urlRow = $matches[2];
                    } 
                } 
                $thumbArray = array();
                foreach($matches[1] as $key => $row)
                {
                    $url = $htmlp->FillUrl($urlRow[$key], $basehref);
                    $img = $htmlp->FillUrl($thumbRow[$key], $basehref);
                    $thumbArray[] = $url . '|' . $img;
                    $return .= "<tr><td><font color=blue>" . ($key + 1) . "</font> <a href='" . $url . "' target='_blank' id='url" . ($key + 1) . "' ><img src='" . $img . "' width=60 height=40></a> 【" . $titleRow[$key] . "】</td><td width=\"70\"><a href=\"javascript:TestContentById(" . ($key + 1) . ")\">" . $LANG['test_this_page'] . "</a></td></tr>\n";
                } 
                file_put_contents('spider/rules/tmp.php', implode("\n", $thumbArray));
                echo $return;
                exit;
            } 
            $htmlp->SetSource($v, $dourl, false);
        } 

        $testpage = '';
        $urlSerial = 0;

        if (is_array($htmlp->Links))
        {
            $return .= "<tr><td colspan=2>" . $LANG['url_'] . $dourl . $LANG['fetched_url'] . "</td></tr>\n";
            foreach($htmlp->Links as $k => $v)
            {
                $k = $htmlp->FillUrl($k, $basehref);
                if ($this->CJob->Job["ContentPageMust"] != '')
                {
                    if (eregi($this->CJob->Job["ContentPageMust"], $k))
                    {
                        if ($this->CJob->Job["ContentPageForbid"] == '')
                        {
                            $return .= "<tr><td><font color=blue>" . ++$urlSerial . "</font> <a href='$k' target='_blank' id='url" . $urlSerial . "' >$k</a> 【" . $v . "】</td><td width=\"70\"><a href=\"javascript:TestContentById(" . $urlSerial . ")\">" . $LANG['test_this_page'] . "</a></td></tr>\n";
                        } 
                        else if (!eregi($this->CJob->Job["ContentPageForbid"], $k))
                        {
                            $return .= "<tr><td><font color=blue>" . ++$urlSerial . "</font> <a href='$k' target='_blank'  id='url" . $urlSerial . "' >$k</a> 【" . $v . "】</td><td width=\"70\"><a href=\"javascript:TestContentById(" . $urlSerial . ")\">" . $LANG['test_this_page'] . "</a></td></tr>\n";
                        } 
                    } 
                } 
                else
                {
                    $return .= "<tr><td><font color=blue>" . ++$urlSerial . "</font> <a href='$k' target='_blank'  id='url" . $urlSerial . "'  >$k</a> 【" . $v . "】</td><td width=\"70\"><a href=\"javascript:TestContentById(" . $urlSerial . ")\">" . $LANG['test_this_page'] . "</a></td></tr>\n";
                } 
            } 
        } 
        else
        {
            $return .= "<tr><td colspan=2>" . $LANG['not_fetched_any_useable_link_from_appoint_url'] . "</td></tr>\n";
            return $return;
        } 
        $htmlp->Clear();
        $return .= "</table>";
        $end_time = getmicrotime();
        $total_time = number_format($end_time - $start_time, 3, '.', '');
        echo '采集URL耗时：' . $total_time . '毫秒<br>';
        echo $return;
    } 

    function regexEncode($str)
    {
        $str = str_replace("\\", "\\\\", $str); 
        $str = str_replace(".", "\.", $str);
        $str = str_replace("[", "\[", $str);
        $str = str_replace("]", "\]", $str);
        $str = str_replace("(", "\(", $str);
        $str = str_replace(")", "\)", $str);
        $str = str_replace("?", "\?", $str);
        $str = str_replace("+", "\+", $str);
        $str = str_replace("*", "\*", $str);
        $str = str_replace("^", "\^", $str);
        $str = str_replace("{", "\{", $str);
        $str = str_replace("}", "\}", $str);
        $str = str_replace("$", "\$", $str);
        $str = str_replace("|", "\|", $str);
        $str = str_replace("/", "\/", $str);
        $str = str_replace("\[参数\]", "([\s\S]*?)", $str);
        $str = str_replace("\(\*\)", "[\s\S]*?", $str);
        return $str;
    } 

    function ConvertChatSet($html,$EncodeType='SourceEncode')
    {
        global $charset_config; 

        if ($this->CJob->Job[$EncodeType] == 1) $sourcecharset = "utf8";
        else if ($this->CJob->Job[$EncodeType] == 2) $sourcecharset = "big5";
        else $sourcecharset = "gbk";
        $html = convert_encoding($sourcecharset, $charset_config['self'], $html);
        return $html;
    }


    
    function GetLabelsContent($html, $dourl, $down = false)
    {
        set_time_limit(0);
        global $db, $PHP_DOMAIN, $CONFIG, $LANG;
        if ($html == '') return ''; 

        $html = $this->ConvertChatSet($html);

        $basehref = get_basehref($html);
        $artitem = '';
        if (file_exists('spider/rules/tmp.php'))
        {
            $thumbArray = array();
            $tmplist = file_get_contents('spider/rules/tmp.php');
            $tmplist = explode("\n", $tmplist);
            foreach($tmplist as $row)
            {
                $tmp = explode('|', $row);
                $thumbArray[$tmp['0']] = $tmp['1'];
            } 

            if (isset($thumbArray[$dourl]))
            {
                $artitem .= "【" . $LANG['label'] . ":缩略图】:" . $thumbArray[$dourl];
                if ($down)$artitem .= "【/" . $LANG['label'] . "】\r\n";
                else $artitem .= "\r\n";
            } 
        } 
        $isPutUnit = false;
        $keys = array_keys($this->CJob->Label['LabelName']);
        $num_label = count($keys);
        for($i = 0; $i < $num_label; $i++)
        {
            $pos = 0;
            $endpos = 0;
            $v = '';
            $sarr_start = '';
            $sarr_end = '';
            $sarr_start = $this->regexEncode($this->CJob->Label['StartStr'][$keys[$i]]);
            $sarr_end = $this->regexEncode($this->CJob->Label['EndStr'][$keys[$i]]); 

            if (!empty($this->CJob->Job['DividePageStart']) && !empty($this->CJob->Job['DividePageEnd']) && $this->CJob->Label['LabelName'][$keys[$i]] == $LANG['content'])
            {
                $pagestart = $this->regexEncode($this->CJob->Job['DividePageStart']);
                $pageend = $this->regexEncode($this->CJob->Job['DividePageEnd']);
                $regexStr = "/" . $pagestart . "([\s\S]*?)" . $pageend . "/";
                $regexnum = preg_match($regexStr, $html, $matches);
                $p = $matches[1];
                unset($matches);
                $p = trim($p);
                if ($p != '')
                {
                    $p = "-" . $p;
                    $htmlp = new Html_Parse();
                    $htmlp->GetLinkType = "link";
                    $htmlp->SetSource($p, $dourl, false);
					$this->dividePageHtml ='';
                    foreach($htmlp->Links as $k => $v)
                    {
                        $k = $htmlp->FillUrl($k, $basehref);
                        if ($k == $dourl) continue;
                        if ($this->CJob->Job['Cookie']) $this->CFileGetContent->puthead["Cookie"] = $this->CJob->Job['Cookie'];
                        $this->CFileGetContent->OpenUrl($k);
                        $nhtml = $this->CFileGetContent->GetHtml();
                        if ($nhtml != '')
                        {
                            $this->dividePageHtml .= $this->CJob->Job['DividePageUnion'] . $this->GetOneField($nhtml, $k, $sarr_start, $sarr_end, $pagestart, $pageend);
                        }
                    }
                } 
            } 

            if (!empty($sarr_start) && !empty($sarr_end))
            { 

                $regex = "/" . $sarr_start . "([\s\S]*?)" . $sarr_end . "/";
                preg_match($regex, $html, $matchess);
                if (count($matchess) < 2) $v = $LANG['null'];
                else $v = $matchess[1];

                if ($v != '')
                {
                    if ($this->dividePageHtml && $this->CJob->Label['LabelName'][$keys[$i]] == $LANG['content']) 
                    {
                            $regex = "/" . $pagestart . "([\s\S]*?)" . $pageend . "/";
							$v = preg_replace($regex, '', $v); 
							$v .= $this->dividePageHtml; 
                    } 

                    $v = get_remotefiles($v, '', $dourl, $basehref, false); 

                    if (!empty($this->CJob->Label['TrimStart'][$keys[$i]]))
                    {
                        $strArrStart = explode("(|)", $this->CJob->Label['TrimStart'][$keys[$i]]);
                        $strArrEnd = explode("(|)", $this->CJob->Label['TrimEnd'][$keys[$i]]);

                        if (count($strArrStart) > 0)
                        {
                                $num = count($strArrStart);
                            for($y = 0; $y < $num; $y++)
                            {
                                $regexTrimRelaceStar = '|' . $this->regexEncode($strArrStart[$y]) . '|';
                                $v = preg_replace($regexTrimRelaceStar, $strArrEnd[$y], $v) . "\r\n";
                            } 
                        } 
                    } 

                    if (isset($this->CJob->Label['HtmlTrim'][$keys[$i]]))
                        $v = $this->HtmlTrim($v, $this->CJob->Label['HtmlTrim'][$keys[$i]]); 

                    if ($down)
                    {
                        $downtype = '';
                        $notdowntype = '';
                        if ($this->CJob->Job['DownImg'] == 1)
                            {
                                if ($this->CJob->Label['LabelName'][$keys[$i]] == $LANG['content'])
                                {
                                    @set_time_limit(300);
                                    $downtype .= "gif|jpg|jpeg|bmp|png";
                                } 
                            } 
                            if ($this->CJob->Job['DownSwf'] == 1) 
                                {
                                    if ($this->CJob->Label['LabelName'][$keys[$i]] == $LANG['content'])
                                    {
                                        @set_time_limit(300);
                                        $downtype .= ($downtype == '')?"swf|flv":"|swf|flv";
                                    } 
                                } 
                                if ($this->CJob->Job['DownOther'] == 1) 
                                    {
                                        if ($this->CJob->Label['LabelName'][$keys[$i]] == $LANG['content'])
                                        {
                                            @set_time_limit(300);
                                            $downtype .= ($downtype == '')?$this->CJob->Job['OtherFileType']:"|" . $this->CJob->Job['OtherFileType'];
                                        } 
                                    } 
                                    if ($downtype)
                                    {
                                        $v = get_remotefiles($v, $downtype, $dourl, $basehref, true);
                                    } 
                                } 
                                $v = trim($v);
                                $v = preg_replace("/\r\n{2,}/", "\r\n", $v); 
                                if (($this->CJob->Label['LabelName'][$keys[$i]] == $LANG['title'] || $this->CJob->Label['LabelName'][$keys[$i]] == $LANG['content']) && $v == '')
                                {
                                    $v = $LANG['title_or_content_null'];
                                    return $v;
                                } 
                            } 
                            $artitem .= "【" . $LANG['label'] . ":" . $this->CJob->Label['LabelName'][$keys[$i]] . "】:" . $v;
                            if ($down == true) $artitem .= "【/" . $LANG['label'] . "】\r\n";
                            else $artitem .= "\r\n";
                        } 
                        else
                        {
                            $artitem .= "【" . $LANG['label'] . ":" . $this->CJob->Label['LabelName'][$keys[$i]] . "】:" . $LANG['null'];
                            if ($down == true) $artitem .= "【/" . $LANG['label'] . "】\r\n";
                            else $artitem .= "\r\n";
                        } 
                    } 
                    return $artitem;
                } 

                function TestArtical($dourl)
                {
                    global $LANG;
                    if ($dourl == '')
                    {
                        echo $LANG['input_the_test_page'];
                        exit;
                    } 
                    $fgc = new httpdown();
                    if ($this->CJob->Job['Cookie']) $fgc->puthead["Cookie"] = $this->CJob->Job['Cookie'];
                    $fgc->OpenUrl($dourl);
                    $html = $fgc->GetHtml();
                    $fgc->Close();
					$dourl =$fgc->url;
                    echo "<textarea cols=\"60\" rows=\"27\" id='ContentArea'>";
                    echo $this->GetLabelsContent($html, $dourl, false);
                    echo "</textarea>";
                } 

                function SpiderAllUrlById($uid, $auto, $totalurlcount, $totalurlnorepeatcount = 0)
                {
                    global $db, $CONFIG, $LANG;
                    echo 'SpiderAllUrlById采集URL<br>';
                    $start_time = getmicrotime();
                    if ($this->CFileGetContent == '')
                        $this->CFileGetContent = new httpdown();
                    if ($this->CTagHtml == '')
                        $this->CTagHtml = new Html_Parse();
                    $this->CTagHtml->GetLinkType = "link";
                    $tmplink = array();
                    $totalnum = count($this->CJob->Job["url"]);
                    $return = '';
                    if ($uid >= $totalnum)
                    {
                        $return .= "<br><font color=blue>" . $LANG['analysic_to_end_of_the_list_total_fetched'] . $totalurlcount . $LANG['article_link_remove_repeat_get_valid_url'] . $totalurlnorepeatcount . $LANG['one'] . "<br><br/></font>\r\n";
                        $return .= "&nbsp;&nbsp;" . $LANG['select_operation_below'] . "<br><br/>\r\n";
                        $return .= "&nbsp;&nbsp;" . $LANG['direct_to_next_step'] . " <a href='?mod=$this->mod&file=collect&action=collectcontent&jobid=$this->JobId'><font color='blue'>" . $LANG['spider_content'] . "</font></a><br><br/>\r\n";
                        $return .= "&nbsp;&nbsp;" . $LANG['verify_url_fetch_by_current_job'] . " <a href='?mod=$this->mod&file=collect&action=manage&jobid=$this->JobId'><font color='blue'>" . $LANG['view_content'] . "</font></a><br><br/>\r\n";
                        $return .= "&nbsp;&nbsp;" . $LANG['verify_url_fetch_by_all_job'] . " <a href='?mod=$this->mod&file=collect&action=manage'><font color='blue'>" . $LANG['view_all'] . "</font></a><br><br/>\r\n";
                    } 
                    else
                    {
                        $BaseUrl = $pageurl = $this->CJob->Job["url"][$uid];
                        $return .= "<br><font color=blue>" . $LANG['connect_to_list_page'] . "(<b>No." . ($uid + 1) . "</b>): $pageurl  " . $LANG['analysing'] . "<br><br/></font>\r\n";

                        if ($this->CJob->Job['Cookie']) $this->CFileGetContent->puthead["Cookie"] = $this->CJob->Job['Cookie'];
                        $this->CFileGetContent->OpenUrl($pageurl);
                        $html = $this->CFileGetContent->GetHtml();
                        $this->CFileGetContent->Close();
                        $this->CTagHtml->GetLinkType = "link";
                        $basehref = get_basehref($html); 

                        $v = $html = $this->ConvertChatSet($html,'SiteEncode');

                        if (!empty($this->CJob->Job['ListUrlStart']) && !empty($this->CJob->Job['ListUrlEnd']))
                        {
                            $pos = strpos($html, $this->CJob->Job['ListUrlStart']);
                            $endpos = strpos($html, $this->CJob->Job['ListUrlEnd'], $pos);
                            if ($endpos > $pos && $pos > 0)
                            {
                                $v = substr($html, $pos + strlen($this->CJob->Job['ListUrlStart']), $endpos - $pos - strlen($this->CJob->Job['ListUrlStart']));
                            } 
                        } 
                        if (!$this->CJob->Job['SpiderRule'])
                        {
                            $this->CTagHtml->SetSource($v, $pageurl, false);
                            if (is_array($this->CTagHtml->Links))
                            {
                                foreach($this->CTagHtml->Links as $url => $title)
                                {
                                    $url = $this->CTagHtml->FillUrl($url, $basehref);
                                    if ($this->CJob->Job["ContentPageMust"] != '')
                                    {
                                        if (eregi($this->CJob->Job["ContentPageMust"], $url))
                                        {
                                            if ($this->CJob->Job["ContentPageForbid"] == '')
                                            {
                                                $tmplink[$url] = $title;
                                            } 
                                            else if (!eregi($this->CJob->Job["ContentPageForbid"], $url))
                                            {
                                                $tmplink[$url] = $title;
                                            } 
                                        } 
                                    } 
                                    else
                                    {
                                        $tmplink[$url] = $title;
                                    } 
                                } 
                            } 
                        } 
                        else
                        { 

                            $this->CTagHtml->SetSource($v, $pageurl, false, false);
                            echo 'action:采集缩略图'; 

                            $regexStr = str_replace('[缩略图]', '[参数]', $this->CJob->Job['SpiderRule']);
                            $regexStr = str_replace('[实际链接]', '[参数]', $regexStr);
                            $regexStr = str_replace('[标题]', '[参数]', $regexStr);
                            $regexStr = "/" . $this->regexEncode($regexStr) . "/"; 

                            $regexnum = preg_match_all($regexStr, $v, $matches); 

                            $thumbpos = strpos($this->CJob->Job['SpiderRule'], '[缩略图]');
                            $urlpos = strpos($this->CJob->Job['SpiderRule'], '[实际链接]');
                            $titlepos = strpos($this->CJob->Job['SpiderRule'], '[标题]');
                            if ($thumbpos < $urlpos && $thumbpos < $titlepos)
                            {
                                $thumbRow = $matches[1];
                                if ($urlpos < $titlepos)
                                {
                                    $urlRow = $matches[2];
                                    $titleRow = $matches[3];
                                } 
                                else
                                {
                                    $urlRow = $matches[3];
                                    $titleRow = $matches[2];
                                } 
                            } elseif ($urlpos < $thumbpos && $urlpos < $titlepos)
                            {
                                $urlRow = $matches[1];
                                if ($thumbpos < $titlepos)
                                {
                                    $thumbRow = $matches[2];
                                    $titleRow = $matches[3];
                                } 
                                else
                                {
                                    $thumbRow = $matches[3];
                                    $titleRow = $matches[2];
                                } 
                            } 
                            else
                            {
                                $titleRow = $matches[1];
                                if ($thumbpos < $urlpos)
                                {
                                    $thumbRow = $matches[2];
                                    $urlRow = $matches[3];
                                } 
                                else
                                {
                                    $thumbRow = $matches[3];
                                    $urlRow = $matches[2];
                                } 
                            } 
                            $thumbArray = array();
                            $downtype = "gif|jpg|jpeg|bmp|png";
                            foreach($matches[1] as $index => $item)
                            {
                                $url = $this->CTagHtml->FillUrl($urlRow[$index], $basehref);
                                $img = $this->CTagHtml->FillUrl($thumbRow[$index], $basehref);
                                $tmplink[$url] = $titleRow[$index];
                                $thumbArray[$url] = $img;
                            } 
                        } 

                        $unum = count($tmplink);
                        $d = 0;
                        $re = 0; 
                        $this->loadUrl(); 
                        foreach($tmplink as $keys => $values)
                        {
                            $d++;
                            $return .= "&nbsp;<font color=red>" . $d . "</font>&nbsp;" . $keys . "  【" . $values . "】 <br>"; 

                            if (!dataExists($keys))
                            {
                                $re++;
                                $thumb = isset($thumbArray[$keys])?$thumbArray[$keys]:'';
                                if ($thumb)
                                {
                                    $remotefileurls = array('0' => $thumb);
                                    $urls = do_saveremotefiles($remotefileurls, 'uploadfile', true);
                                    $thumb = $urls['new'][0];
                                } 
                                $db->query("Insert Into " . TABLE_SPIDER_URLS . " (JobId,Title,Thumb,PageUrl,BaseUrl,CreateOn,Spidered) values(" . $this->JobId . ",'" . addslashes($values) . "','" . addslashes($thumb) . "','" . addslashes($keys) . "','" . $BaseUrl . "'," . time() . ",0)");
                            } 
                        } 

                        if ($re)
                        {
                            dataCache(true);
                        } 
                        if ($unum > 0)
                        {
                            $totalurlcount = $totalurlcount + $unum;
                            $totalurlnorepeatcount = $totalurlnorepeatcount + $re;
                            $return .= "<br><font color=blue>" . $LANG['finish_spider_in_current_page_generate'] . $unum . " " . $LANG['records_repeat_num'] . ($unum - $re) . $LANG['valid_url'] . $re . $LANG['one'] . " <br/><font>\r\n";
                            if ($auto) $return .= "<script language=\"javascript\">parent.GotoPageByNext(\"Next\",$totalurlcount,$totalurlnorepeatcount);</script>";
                        } 
                        else
                        {
                            $return .= "<br><font color=blue>" . $LANG['current_page_url'] . "[" . $this->CJob->Job["url"][$uid] . "]" . $LANG['not_fetched_any_valid_link'] . "</font>";
                            if ($auto) $return .= "<script language=\"javascript\">parent.GotoPageByNext(\"Next\",$totalurlcount,$totalurlnorepeatcount);</script>";
                        } 
                    } 
                    $end_time = getmicrotime();
                    $total_time = number_format($end_time - $start_time, 3, '.', '');
                    echo '采集URL耗时：' . $total_time . '<br>';
                    return $return;
                } 

                function GetOneContent($aid, $dourl)
                {
                    global $db, $LANG;
                    if ($this->CFileGetContent == '') $this->CFileGetContent = new httpdown();
                    if ($this->CJob->Job['Cookie']) $this->CFileGetContent->puthead["Cookie"] = $this->CJob->Job['Cookie'];
                    $this->CFileGetContent->OpenUrl($dourl);
                    $html = $this->CFileGetContent->GetHtml();
					$dourl =$this->CFileGetContent->url; 
                    $this->CFileGetContent->Close();
                    $body = $this->GetLabelsContent($html, $dourl, true);
                    if ($body != $LANG['title_or_content_null'])
                    {
                        $db->query("Update " . TABLE_SPIDER_URLS . " Set SpiderOn='" . time() . "',Content='" . addslashes($body) . "',Spidered=1 where Id=" . $aid);
                    } 
                    $body = '';
                    $html = '';
                    return $body;
                } 

                function GetOneField($html, $dourl, $startstr, $endstr, $pagestart, $pageend)
                {
                    if ($html == '') return ''; 

                    $html = $this->ConvertChatSet($html);
                    $regexStr = "/" . $startstr . "([\s\S]*?)" . $endstr . "/";
					$regexnum = preg_match($regexStr, $html, $matches);
                    $v = $matches[1];
                    $v = trim($v);

                    $regexStr = "/" . $pagestart . "([\s\S]*?)" . $pageend . "/";
                    $v = preg_replace($regexStr, '', $v);
                    return $v;
                } 

                function HtmlTrim($strHtml, $serial)
                {
                    if ($serial != '')
                    {
                        $ids = explode(',', $serial); 
                        $aryReg = array("/<a[^>]*?>([\s\S]*?)<\/a>/i",
                            "/<br[^>]*?>/i",
                            "/<table[^>]*?>([\s\S]*?)<\/table>/i",
                            "/<tr[^>]*?>([\s\S]*?)<\/tr>/i",
                            "/<td[^>]*?>([\s\S]*?)<\/td>/i",
                            "/<p[^>]*?>([\s\S]*?)<\/p>/i",
                            "/<font[^>]*?>([\s\S]*?)<\/font>/i",
                            "/<div[^>]*?>([\s\S]*?)<\/div>/i",
                            "/<span[^>]*?>([\s\S]*?)<\/span>/i",
                            "/<tbody[^>]*?>([\s\S]*?)<\/tbody>/i",
                            "/<([\/]?)b>/i",
                            "/<img[^>]*?>/i",
                            "/[&nbsp;]{2,}/i",
                            "/<script[^>]*?>([\w\W]*?)<\/script>/i",
                            );
                        $aryRep = array("\\1",
                            "",
                            "\\1",
                            "\\1",
                            "\\1",
                            "\\1",
                            "\\1",
                            "\\1",
                            "\\1",
                            "\\1",
                            "",
                            "",
                            "&nbsp;",
                            "",
                            );
                        $expBeginTag = array("/<a[^>]*?>/i",
                            "/<br[^>]*?>/i",
                            "/<table[^>]*?>/i",
                            "/<tr[^>]*?>/i",
                            "/<td[^>]*?>/i",
                            "/<p[^>]*?>/i",
                            "/<font[^>]*?>/i",
                            "/<div[^>]*?>/i",
                            "/<span[^>]*?>/i",
                            "/<tbody[^>]*?>/i",
                            "/<([\/]?)b>/i",
                            "/<img[^>]*?>/i",
                            "/[&nbsp;]{2,}/i",
                            "/<script[^>]*?>/i",

                            );
                        $expEndTag = array("/<\/a>/i",
                            "/<\/br>/i",
                            "/<\/table>/i",
                            "/<\/tr>/i",
                            "/<\/td>/i",
                            "/<\/p>/i",
                            "/<\/font>/i",
                            "/<\/div>/i",
                            "/<\/span>/i",
                            "/<\/tbody>/i",
                            "/<\/b>/i",
                            "/<img[^>]*?>/i",
                            "/[&nbsp;]{2,}/i",
                            "/<\/script>/i",
                            );

                        $strOutput = $strHtml;
                        foreach($ids as $id)
                        {
                            $strOutput = preg_replace($aryReg[$id], $aryRep[$id], $strOutput);
                            $strOutput = preg_replace($expBeginTag[$id], '', $strOutput);
                            $strOutput = preg_replace($expEndTag[$id], '', $strOutput);
                        } 
                        return $strOutput;
                    } 
                    else
                    {
                        return $strHtml;
                    } 
                } 
            } 

            function get_basehref($html)
            {
                return preg_match("/<base[\s]+href=([\"|']?)([^ \"'>]+)\\1/i", $html, $matches) ? $matches[2] : '';
            } 

            ?>