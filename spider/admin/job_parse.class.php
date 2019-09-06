<?php 

class Job_Parse
{
    var $jobid;
    var $mod;
    var $startstyle; 
    var $Job = array(); 
    var $Label = array(); 

    function GetJobInfo($jd)
    {
        global $db;
        $this->jobid = $jd;
        $this->Job = $db->get_one("SELECT * FROM " . TABLE_SPIDER_JOB . " WHERE JobId='" . $jd . "'");
        if (is_array($this->Job))
        {
            if (strpos($this->Job["StartUrl"], "\n") < 1 && strpos($this->Job["StartUrl"], '(*)') < 1) 
                {
                    $this->startstyle = 0;
                $this->Job["url"] = array($this->Job["StartUrl"]);
            } 
            else if (strpos($this->Job["StartUrl"], "\n") > 1) 
                {
                    $this->startstyle = 1;
                $this->Job["url"] = explode("\n", $this->Job["StartUrl"]);
                if (is_array($this->Job["url"]))
                    $filter = array_filter($this->Job["url"]);
                foreach ($filter as $k => $u)
                $filter[$k] = str_replace("\r", "", $u);

                $this->Job["url"] = $filter;
            } elseif (strpos($this->Job["StartUrl"], '(*)') > 1) 
                {
                    $this->startstyle = 2;
                $su = explode("♀", $this->Job["StartUrl"]);
                if (isset($su[1]))
                    $sn = explode(",", $su[1]);
                $urlid = 0;
                if ($sn[3] == "true")
                {
                    for($n = $sn[1];$n >= $sn[0];$n--)
                    {
                        if (isset($sn[4]) && $sn[4] == "true")
                        {
                            $curPage = substr('0000000000' . $n * $sn[2], - strlen($sn[1]));
                        } 
                        else
                        {
                            $curPage = $n * $sn[2];
                        } 
                        $this->Job["url"][$urlid] = str_replace("(*)", $curPage, $su[0]);
                        $urlid++;
                    } 
                } 
                else
                {
                    for($n = $sn[0];$n <= $sn[1];$n++)
                    {
                        if (isset($sn[4]) && $sn[4] == "true")
                        {
                            $curPage = substr('0000000000' . $n * $sn[2], - strlen($sn[1]));
                        } 
                        else
                        {
                            $curPage = $n * $sn[2];
                        } 
                        $this->Job["url"][$urlid] = str_replace("(*)", $curPage, $su[0]);
                        $urlid++;
                    } 
                } 
            } 
            $this->GetRuleInfo(); 
        } 
        else
            return 'not catch any information';
    } 

    function GetRuleInfo()
    {
        include MOD_ROOT . '/rules/' . $this->jobid . '.php';
        $this->Label = $rule;
    } 

    function FilterNull($url)
    {
        if (!isset($url)) return false;
        return trim($url) ? true : false;
    } 

    function Dispose()
    {
        unset($this->Job);
        unset($this->Label);
    } 
} 

?>