<?php
class Html_Parse
{
    var $TagP;
    var $SourceHtml;
    var $Title;
    var $Medias;
    var $MediaInfos;
    var $Links;
    var $CharSet;
    var $BaseUrl;
    var $BaseUrlPath;
    var $HomeUrl;
    var $IsHead;
    var $ImgHeight;
    var $ImgWidth;
    var $GetLinkType; 
    function __construct()
    {
        $this->TagP = "";
        $this->SourceHtml = "";
        $this->Title = "";
        $this->Medias = Array();
        $this->MediaInfos = Array();
        $this->Links = Array();
        $this->CharSet = "";
        $this->BaseUrl = "";
        $this->BaseUrlPath = "";
        $this->HomeUrl = "";
        $this->IsHead = false;
        $this->ImgHeight = 30;
        $this->ImgWidth = 50;
        $this->GetLinkType = "all"; 
    } 
    function Html_Parse()
    {
        $this->__construct();
    } 

    function SetSource($html, $url = "", $gethead = true, $analyser = true)
    {
        if ($gethead) $this->IsHead = false;
        else $this->IsHead = true;
        $this->TagP = new Tag_Parse();
        $url = trim($url);
        $this->SourceHtml = $html;
        $this->BaseUrl = $url; 

        $urls = @parse_url($url);
        $this->HomeUrl = $urls["host"];
        $this->BaseUrlPath = $this->HomeUrl . $urls["path"];
        $this->BaseUrlPath = preg_replace("/\/([^\/]*)\.(.*)$/", "/", $this->BaseUrlPath);
        $this->BaseUrlPath = preg_replace("/\/$/", "", $this->BaseUrlPath);
        if ($html != "" && $analyser) $this->Analyser();
    } 

    function Analyser()
    {
        $tagp = new Tag_Parse();
        $tagp->IsTagName = false;
        $c = "";
        $i = 0;
        $startPos = 0;
        $endPos = 0;
        $wt = 0;
        $ht = 0;
        $scriptdd = 0;
        $attStr = "";
        $tmpValue = "";
        $tmpValue2 = "";
        $tagName = "";
        $hashead = 0;
        $slen = strlen($this->SourceHtml);

        if ($this->GetLinkType == "link")
        {
            $needTag = "a|meta|title|/head|body";
        } 
        else if ($this->GetLinkType == "media")
        {
            $needTag = "img|embed|a";
            $this->IsHead = true;
        } 
        else
        {
            $needTag = "img|embed|a|meta|title|/head|body";
        } 

        for(;$i < $slen; $i++)
        {
            $c = $this->SourceHtml[$i];
            if ($c == "<")
            { 
                $tagName = "";
                $j = 0;
                for($i = $i + 1; $i < $slen; $i++)
                {
                    if ($j > 10) break;
                    $j++;
                    if (!ereg("[ <>\r\n\t]", $this->SourceHtml[$i]))
                    {
                        $tagName .= $this->SourceHtml[$i];
                    } 
                    else break;
                } 
                $tagName = strtolower($tagName);
                if ($tagName == "!--")
                {
                    $endPos = strpos($this->SourceHtml, "-->", $i);
                    if ($endPos !== false) $i = $endPos + 3;
                    continue;
                } 
                if (ereg($needTag, $tagName))
                {
                    $startPos = $i;
                    $endPos = strpos($this->SourceHtml, ">", $i + 1);
                    if ($endPos === false) break;
                    $attStr = substr($this->SourceHtml, $i + 1, $endPos - $startPos-1);
                    $tagp->SetSource($attStr);
                } 
                else
                {
                    continue;
                } 

                if (!$this->IsHead)
                {
                    if ($tagName == "meta")
                    { 

                        $tmpValue = strtolower($tagp->GetAtt("http-equiv"));
                        if ($tmpValue == "content-type")
                        {
                            $this->CharSet = strtolower($tagp->GetAtt("charset"));
                        } 
                    } 
                    else if ($tagName == "title")
                    {
                        $this->Title = $this->GetInnerText($i, "title");
                        $i += strlen($this->Title) + 12;
                    } 
                    else if ($tagName == "/head" || $tagName == "body")
                    {
                        $this->IsHead = true;
                        $i = $i + 5;
                    } 
                } 
                else
                { 

                    if ($tagName == "img")
                    {
                        $this->InsertMedia($tagp->GetAtt("src"), "img");
                    } 
                    else if ($tagName == "embed") 
                    {
                        $rurl = $this->InsertMedia($tagp->GetAtt("src"), "embed");
                        if ($rurl != "")
                        {
                            $this->MediaInfos[$rurl][0] = $tagp->GetAtt("width");
                            $this->MediaInfos[$rurl][1] = $tagp->GetAtt("height");
                        } 
                    } 
                    else if ($tagName == "a") 
                    {
                        $this->InsertLink($tagp->GetAtt("href"), $this->GetInnerText($i, "a"));
                    } 
                }
            }
        } 
        if ($this->Title == "") $this->Title = $this->BaseUrl;
    } 
    function Clear()
    {
        $this->TagP = "";
        $this->SourceHtml = "";
        $this->Title = "";
        $this->Links = "";
        $this->Medias = "";
        $this->BaseUrl = "";
        $this->BaseUrlPath = "";
    } 
    
    function InsertMedia($url, $mtype)
    {
        if (ereg("^(javascript:|#|'|\")", $url)) return "";
        if ($url == "") return "";
        $this->Medias[$url] = $mtype;
        return $url;
    } 
    function InsertLink($url, $atitle)
    {
        if (ereg("^(javascript:|#|'|\")", $url)) return "";
        if ($url == "") return "";
        $this->Links[$url] = $atitle;
        return $url;
    } 
   
    function ParCharSet($att)
    {
        $startdd = 0;
        $taglen = 0;
        $startdd = strpos($att, "=");
        if ($startdd === false) return "";
        else
        {
            $taglen = strlen($att) - $startdd-1;
            if ($taglen <= 0) return "";
            return trim(substr($att, $startdd + 1, $taglen));
        } 
    } 
    
    
    function ParRefresh($att)
    {
        return $this->ParCharSet($att);
    } 
     
    
    function FillUrl($surl, $basehref = '')
    {
        if ($basehref != '')
        {
            $preurl = strtolower(substr($surl, 0, 6));
            if ($preurl == "http:/" || $preurl == "ftp://" || $preurl == "mms://" || $preurl == "rtsp:/" || $preurl == "thunde" || $preurl == "emule:" || $preurl == "ed2k:/")
                return $surl;
            else return $basehref . '/' . $surl;
        } 
        $i = 0;
        $dstr = "";
        $pstr = "";
        $okurl = "";
        $pathStep = 0;
        $surl = trim($surl);
        if ($surl == "") return "";
        $pos = strpos($surl, "#");
        if ($pos > 0) $surl = substr($surl, 0, $pos);
        if ($surl[0] == "/")
        {
            $okurl = "http://" . $this->HomeUrl . $surl;
        } 
        else if ($surl[0] == ".")
        {
            if (strlen($surl) <= 1) return "";
            else if ($surl[1] == "/")
            {
                $okurl = "http://" . $this->BaseUrlPath . "/" . substr($surl, 2, strlen($surl)-2);
            } 
            else
            {
                $urls = explode("/", $surl);
                foreach($urls as $u)
                {
                    if ($u == "..") $pathStep++;
                    else if ($i < count($urls)-1) $dstr .= $urls[$i] . "/";
                    else $dstr .= $urls[$i];
                    $i++;
                } 
                $urls = explode("/", $this->BaseUrlPath);
                if (count($urls) <= $pathStep)
                    return "";
                else
                {
                    $pstr = "http://";
                    for($i = 0;$i < count($urls) - $pathStep;$i++)
                    {
                        $pstr .= $urls[$i] . "/";
                    } 
                    $okurl = $pstr . $dstr;
                } 
            } 
        } 
        else
        {
            $preurl = strtolower(substr($surl, 0, 6));
            if (strlen($surl) < 7)
                $okurl = "http://" . $this->BaseUrlPath . "/" . $surl;
            else if ($preurl == "http:/" || $preurl == "ftp://" || $preurl == "mms://" || $preurl == "rtsp:/" || $preurl == "thunde" || $preurl == "emule:" || $preurl == "ed2k:/")
                $okurl = $surl;
            else
                $okurl = "http://" . $this->BaseUrlPath . "/" . $surl;
        } 
        $preurl = strtolower(substr($okurl, 0, 6));
        if ($preurl == "ftp://" || $preurl == "mms://" || $preurl == "rtsp:/" || $preurl == "thunde" || $preurl == "emule:" || $preurl == "ed2k:/")
        {
            return $okurl;
        } 
        else
        {
            $okurl = eregi_replace("^(http://)", "", $okurl);
            $okurl = eregi_replace("/{1,}", "/", $okurl);
            return "http://" . $okurl;
        } 
    } 
    
    function GetInnerText($pos, $tagname)
    {
        $startPos = 0;
        $endPos = 0;
        $textLen = 0;
        $str = "";
        $startPos = strpos($this->SourceHtml, '>', $pos);
        if ($tagname == "title")
            $endPos = strpos($this->SourceHtml, '<', $startPos);
        else
        {
            $endPos = strpos($this->SourceHtml, '</a', $startPos);
            if ($endPos === false) $endPos = strpos($this->SourceHtml, '</A', $startPos);
        } 
        if ($endPos > $startPos)
        {
            $textLen = $endPos - $startPos;
            $str = substr($this->SourceHtml, $startPos + 1, $textLen-1);
        } 
        if ($tagname == "title")
            return trim($str);
        else
        {
            $str = eregi_replace("</(.*)$", "", $str);
            $str = eregi_replace("^(.*)>", "", $str);
            return trim($str);
        } 
    } 
} 

?>