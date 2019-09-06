<?php 
@set_time_limit(0);

class httpdown
{
    var $fp = "";
    var $html = "";
    var $url = "";
    var $urlpath = "";
    var $scheme = "http";
    var $host = "";
    var $port = "80";
    var $user = "";
    var $pass = "";
    var $path = "/";
    var $query = "";
    var $error = "";
    var $httphead = "" ;
    var $puthead = "";

    var $BaseUrlPath = "";
    var $HomeUrl = "";
    var $JumpCount = 0; 
    
    
    function Init($url)
    {
        if ($url == "") return ;
        $urls = "";
        $urls = @parse_url($url);
        $this->url = $url;
        if (is_array($urls))
        {
            $this->host = $urls["host"];
            if (isset($urls["scheme"])) $this->scheme = $urls["scheme"];
            if (isset($urls["user"])) $this->user = $urls["user"];
            if (isset($urls["pass"])) $this->pass = $urls["pass"];
            if (isset($urls["port"])) $this->port = $urls["port"];
            if (isset($urls["path"])) $this->path = $urls["path"];
            $this->urlpath = $this->path;
            if (isset($urls["query"]))
            {
                $this->query = $urls["query"];
                $this->urlpath .= "?" . $this->query;
            } 
            $this->HomeUrl = $urls["host"];
            $this->BaseUrlPath = $this->HomeUrl . $urls["path"];
            $this->BaseUrlPath = preg_replace("/\/([^\/]*)\.(.*)$/", "/", $this->BaseUrlPath);
            $this->BaseUrlPath = preg_replace("/\/$/", "", $this->BaseUrlPath);
        } 
    } 
    
    
    function OpenConnection()
    {
        if ($this->host == "") return false;
        $errno = "";
        $errstr = "";
        $this->fp = @fsockopen($this->host, $this->port, $errno, $errstr, 10);
        if (!$this->fp)
        {
            $this->error = $errstr;
            return false;
        } 
        else
        {
            return true;
        } 
    } 
    
    
    function Close()
    {
        /*if(!$this->fp)
		{
			fclose($this->fp);
		}*/
    } 
    
    
    function OpenUrl($url)
    {
        $this->url = "";
        $this->urlpath = "";
        $this->scheme = "http";
        $this->host = "";
        $this->port = "80";
        $this->user = "";
        $this->pass = "";
        $this->path = "/";
        $this->query = "";
        $this->error = "";
        $this->JumpCount = 0;
        $this->httphead = Array() ;
        $this->html = "";
        $this->Close();
        $this->Init($url);
        $this->StartHttpPost();
    } 
    
    
    function JumpOpenUrl($url)
    {
        $this->url = "";
        $this->urlpath = "";
        $this->scheme = "http";
        $this->host = "";
        $this->port = "80";
        $this->user = "";
        $this->pass = "";
        $this->path = "/";
        $this->query = "";
        $this->error = "";
        $this->JumpCount++;
        $this->httphead = Array() ;
        $this->html = "";
        $this->Close();
        $this->Init($url);
        $this->StartHttpPost();
    } 
    
    
    function Error()
    {
        echo 'Error occur:' . $this->error;
        echo 'returned http head info:' . "<br/>";
        foreach($this->httphead as $k => $v)
        {
            echo "$k => $v <br/>\r\n";
        } 
    } 
    
    
    function IsGetOK()
    {
        if (ereg("^2", $this->GetHead("http-state")))
        {
            return true;
        } 
        else
        {
            $this->error .= $this->GetHead("http-state") . " - " . $this->GetHead("http-describe") . "<br/>";
            return false;
        } 
    } 
    
    
    function IsText()
    {
        if (ereg("^2", $this->GetHead("http-state")) && eregi("^text", $this->GetHead("content-type")))
        {
            return true;
        } 
        else
        {
            $this->error .= 'returned info is not text,cannot analyze<br/>';
            return false;
        } 
    } 
    
    
    function IsContentType($ctype)
    {
        if (ereg("^2", $this->GetHead("http-state")) && $this->GetHead("content-type") == strtolower($ctype))
        {
            return true;
        } 
        else
        {
            $this->error .= 'type mismatch' . $this->GetHead("content-type") . "<br/>";
            return false;
        } 
    } 
    
    
    function DownFile($savename)
    {
        if (!$this->IsGetOK()) return false;
        if (@feof($this->fp))
        {
            $this->error = 'connect closed';
            return false;
        } 

        $fp = fopen($savename, "w");
        while (!feof($this->fp))
        {
            fwrite($fp, fread($this->fp, 1024));
        } 
        fclose($this->fp);
        fclose($fp);
        return true;
    } 
    
    
    function SaveToText($savename)
    {
        if ($this->IsText()) $this->DownFile($savename);
        else return "";
    } 
    
    
    function GetHtml()
    {
        if (!$this->IsText()) return "";
        if ($this->html != "") return $this->html;
        if (!$this->fp || @feof($this->fp)) return "";
        while (!feof($this->fp))
        {
            $this->html .= fgets($this->fp, 256);
        } 
        @fclose($this->fp);
        return $this->html;
    } 
    
    
    function StartHttpPost()
    {
        if (!$this->OpenConnection())
        {
            $this->error .= 'cannot connect to remote server!';
            return false;
        } 

        if ($this->GetHead("http-edition") == "HTTP/1.1") $httpv = "HTTP/1.1";
        else $httpv = "HTTP/1.0"; 
        fputs($this->fp, "GET " . $this->urlpath . " $httpv\r\n");
        $this->puthead["Host"] = $this->host; 
        if (!isset($this->puthead["Accept"]))
        {
            $this->puthead["Accept"] = "*/*";
        } 
        if (!isset($this->puthead["User-Agent"]))
        {
            $this->puthead["User-Agent"] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; LocoySpider; .NET CLR 1.1.4322; .NET CLR 2.0.50727)";
        } 
        if (!isset($this->puthead["Refer"]))
        {
            $this->puthead["Refer"] = "http://" . $this->puthead["Host"];
        } 
        foreach($this->puthead as $k => $v)
        {
            $k = trim($k);
            $v = trim($v);
            if ($k != "" && $v != "")
            {
                fputs($this->fp, "$k: $v\r\n");
            } 
        } 
        if ($httpv == "HTTP/1.1") fputs($this->fp, "Connection: Close\r\n\r\n");
        else fputs($this->fp, "\r\n"); 
        $httpstas = explode(" ", fgets($this->fp, 256));
        $this->httphead["http-edition"] = trim($httpstas[0]);
        $this->httphead["http-state"] = trim($httpstas[1]);
        $this->httphead["http-describe"] = "";
        for($i = 2;$i < count($httpstas);$i++)
        {
            $this->httphead["http-describe"] .= " " . trim($httpstas[$i]);
        } 
        while (!feof($this->fp))
        {
            $line = trim(fgets($this->fp, 256));
            if ($line == "") break;
            $hkey = "";
            $hvalue = "";
            $v = 0;
            for($i = 0;$i < strlen($line);$i++)
            {
                if ($v == 1) $hvalue .= $line[$i];
                if ($line[$i] == ":") $v = 1;
                if ($v == 0) $hkey .= $line[$i];
            } 
            $hkey = trim($hkey);
            if ($hkey != "") $this->httphead[strtolower($hkey)] = trim($hvalue);
        } 
        if (ereg("^3", $this->httphead["http-state"]))
        {
            if ($this->JumpCount > 3) return;
            if (isset($this->httphead["location"]))
            {
                $newurl = $this->httphead["location"];
                if (eregi("^http", $newurl))
                {
                    $this->JumpOpenUrl($newurl);
                } 
                else
                {
                    $newurl = $this->FillUrl($newurl);
                    $this->JumpOpenUrl($newurl);
                } 
            } 
            else
            {
                $this->error = 'cannot transfer response!';
            } 
        } //
    } 
    
    
    function GetHead($headname)
    {
        $headname = strtolower($headname);
        if (isset($this->httphead[$headname]))
            return $this->httphead[$headname];
        else
            return "";
    } 
    
    
    function SetHead($skey, $svalue)
    {
        $this->puthead[$skey] = $svalue;
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
} 

?>