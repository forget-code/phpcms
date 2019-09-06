<?php

class Tag_Parse
{
    var $SourceString = '';
    var $SourceMaxSize = 1024;
    var $CharToLow = false; 
    var $IsTagName = true; 
    var $Count = -1;
    var $Items = ''; 
    function SetSource($str = '')
    {
        $this->Count = -1;
        $this->Items = '';
        $strLen = 0;
        $this->SourceString = trim(preg_replace("/[ \t\r\n]{1,}/", " ", $str));
        $strLen = strlen($this->SourceString);
        $this->SourceString .= ' '; 
        if ($strLen > 0 && $strLen <= $this->SourceMaxSize)
        {
            $this->ParseAttribute();
        } 
    } 

    function GetAtt($str)
    {
        if ($str == '') return '';
        $str = strtolower($str);
        if (isset($this->Items[$str])) return $this->Items[$str];
        else return '';
    } 

    function IsAtt($str)
    {
        if ($str == '') return false;
        $str = strtolower($str);
        if (isset($this->Items[$str])) return true;
        else return false;
    } 

    function GetTagName()
    {
        return $this->GetAtt("tagname");
    } 

    function GetCount()
    {
        return $this->Count + 1;
    } 

    function ParseAttribute()
    {
        $d = '';
        $tmpatt = '';
        $tmpvalue = '';
        $startdd = -1;
        $ddtag = '';
        $strLen = strlen($this->SourceString);
        $j = 0; 

        if ($this->IsTagName)
        { 
            if (isset($this->SourceString[2]))
            {
                if ($this->SourceString[0] . $this->SourceString[1] . $this->SourceString[2] == "!--")
                {
                    $this->Items["tagname"] = "!--";
                    return ;
                } 
            } 
            
            for($i = 0;$i < $strLen;$i++)
            {
                $d = $this->SourceString[$i];
                $j++;
                if (ereg("[ '\"\r\n\t]", $d))
                {
                    $this->Count++;
                    $this->Items["tagname"] = strtolower(trim($tmpvalue));
                    $tmpvalue = '';
                    break;
                } 
                else
                {
                    $tmpvalue .= $d;
                } 
            } 
            if ($j > 0) $j = $j-1;
        } 

        for($i = $j;$i < $strLen;$i++)
        {
            $d = $this->SourceString[$i]; 

            if ($startdd == -1)
            {
                if ($d != "=") $tmpatt .= $d;
                else
                {
                    $tmpatt = strtolower(trim($tmpatt));
                    $startdd = 0;
                } 
            } 

            else if ($startdd == 0)
            {
                switch ($d)
                {
                    case ' ':
                        continue;
                        break;
                    case '\'':
                        $ddtag = '\'';
                        $startdd = 1;
                        break;
                    case '"':
                        $ddtag = '"';
                        $startdd = 1;
                        break;
                    default:
                        $tmpvalue .= $d;
                        $ddtag = ' ';
                        $startdd = 1;
                        break;
                } 
            } 

            else if ($startdd == 1)
            {
                if ($d == $ddtag)
                {
                    $this->Count++;
                    if ($this->CharToLow) $this->Items[$tmpatt] = strtolower(trim($tmpvalue));
                    else $this->Items[$tmpatt] = trim($tmpvalue);
                    $tmpatt = '';
                    $tmpvalue = '';
                    $startdd = -1;
                } 
                else
                    $tmpvalue .= $d;
            } 
        } 
        if ($tmpatt != '') $this->Items[$tmpatt] = '';
    } 
} 

?>