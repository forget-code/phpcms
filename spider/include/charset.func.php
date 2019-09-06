<?php
defined('IN_PHPCMS') or exit('Access Denied');
function convert_encoding($from_encoding, $to_encoding, $str_or_array)
{
    if (!is_array($str_or_array) && empty($str_or_array)) return "";
    $from_encoding = strtolower($from_encoding);
    $to_encoding = strtolower($to_encoding);
    $converarray = array();
    // $from_encoding = str_replace("gbk","gb2312",$from_encoding);
    // $to_encoding = str_replace("gbk","gb2312",$to_encoding);
    $from_encoding = str_replace("utf8", "utf-8", $from_encoding);
    $to_encoding = str_replace("utf8", "utf-8", $to_encoding);
    if ($from_encoding == $to_encoding) return $str_or_array; 
    // mb_convert_encoding() and iconv() cannot convert the codepage:big5--gbk
    if (($from_encoding == "big5" && $to_encoding == "gb2312") || ($from_encoding == "gb2312" && $to_encoding == "big5")) $flag = false;
    else $flag = true;

    if (function_exists('mb_convert_encoding') && $to_encoding != 'pinyin' && $flag)
    {
        if (!is_array($str_or_array))
        {
            return mb_convert_encoding($str_or_array, $to_encoding, $from_encoding);
        } 
        else
        {
            foreach($str_or_array as $key => $val)
            {
                $converarray[$key] = mb_convert_encoding($val, $to_encoding, $from_encoding);
            } 
            return $converarray;
        } 
    } elseif (function_exists('iconv') && $to_encoding != 'pinyin' && $flag)
    {
        if (!is_array($str_or_array))
        {
            return iconv($from_encoding, $to_encoding, $str_or_array);
        } 
        else
        {
            foreach($str_or_array as $key => $val)
            {
                $converarray[$key] = iconv($from_encoding, $to_encoding, $val);
            } 
            return $converarray;
        } 
    } 
    else
    {
        require_once PHPCMS_ROOT . "/include/chinese.class.php";
        $chs = new chinese();

        $from_encoding = str_replace("utf-8", "utf8", $from_encoding);
        $from_encoding = str_replace("gbk", "gb2312", $from_encoding);
        $to_encoding = str_replace("utf-8", "utf8", $to_encoding);
        $to_encoding = str_replace("gbk", "gb2312", $to_encoding);

        $charset = array("utf8", "gb2312", "big5", "unicode", "pinyin");
        if (!in_array($from_encoding, $charset))
        {
            return "The codepage-" . $from_encoding . " is not support!";
        } 
        else if (!in_array($to_encoding, $charset))
        {
            return "The codepage-" . $to_encoding . " is not support!";
        } 
        else
        {
            $from_encoding = strtoupper($from_encoding);
            $to_encoding = strtoupper($to_encoding);
            if (!is_array($str_or_array))
            {
                return $chs->Convert($from_encoding, $to_encoding, $str_or_array);
            } 
            else
            {
                foreach($str_or_array as $key => $val)
                {
                    $converarray[$key] = $chs->Convert($from_encoding, $to_encoding, $val);
                } 
                return $converarray;
            } 
        } 
    } 
} 

?>