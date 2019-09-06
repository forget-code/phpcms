<?php
/**
 * HTML标签排除
 */
class Html_Trim
{
    function HtmlTrim($strHtml, $serial)
    {
        $ids = explode(",", $serial); //获取要排除html代码的序号
        $aryReg = array ("'<[^>]*?>.*? >'si", // 去掉 javascript
            "'<[\/\!]*?[^<>]*?>'si", // 去掉 HTML 标记
            "'([\r\n])[\s]+'", // 去掉空白字符
            "'&(quot|#34);'i", // 替换 HTML 实体
            "'&(amp|#38);'i",
            "'&(lt|#60);'i",
            "'&(gt|#62);'i",
            "'&(nbsp|#160);'i",
            "'&(iexcl|#161);'i",
            "'&(cent|#162);'i",
            "'&(pound|#163);'i",
            "'&(copy|#169);'i",
            "'&#(\d+);'e"); // 作为 PHP 代码运行

        $aryRep = array ("",
            "",
            "\\1",
            "\"",
            "&",
            "<",
            ">",
            " ",
            chr(161),
            chr(162),
            chr(163),
            chr(169),
            "chr(\\1)");

        $newReg = $aryReg[0];
        $strOutput = $strHtml;
        foreach($ids as $id)
        {
            $strOutput = preg_replace($aryReg, $aryRep, $strOutput);
        }
        return $strOutput;
    }
}

?>