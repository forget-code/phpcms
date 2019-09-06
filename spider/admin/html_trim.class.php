<?php

class Html_Trim
{ 

    function HtmlTrim($strHtml, $serial)
    {
        $ids = explode(",", $serial); 
        $aryReg = array("/<a[^>]*?>([\w\W]*?)</a>/i",
            "/<br>/i",
            "/<table[^>]*?>([\w\W]*?)</table>/i",
            "/<tr[^>]*?>([\w\W]*?)</tr>/i",
            "/<td[^>]*?>([\w\W]*?)</td>/i",
            "/<p[^>]*?>([\w\W]*?)</p>/i",
            "/<font[^>]*?>([\w\W]*?)</font>/i",
            "/<div[^>]*?>([\w\W]*?)</div>/i",
            "/<span[^>]*?>([\w\W]*?)</span>/i",
            "/<([\/]?)b>/i",
            "/<tbody[^>]*?>([\w\W]*?)</tbody>/i",
            "/<img[^>]*?>/i",
            "/[&nbsp;]{2,}/i",
            "/<script[^>]*?>([\w\W]*?)</script>/i",

            );

        $aryRep = array("$1",
            "",
            "$1",
            "$1",
            "$1",
            "$1",
            "$1",
            "$1",
            "$1",
            "",
            "$1",
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

        $newReg = $aryReg[0];
        $strOutput = $strHtml;
        foreach($ids as $id)
        {
            $strOutput = preg_replace($newReg[$id], $newRep[$id], $strOutput);
			$strOutput = preg_replace($expBeginTag[$id], '', $strOutput);
			$strOutput = preg_replace($expEndTag[$id], '', $strOutput);
        } 
        return $strOutput;
    } 
} 

?>