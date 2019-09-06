<?php
/**
 * +--------------------------------------------------
 * |   函数名：loadMtir
 * |   作用：装载MTIR的JS脚本,在使用MTIR前必须装载!
 * |
 * 
 * @param  $ : $url:MTIR的地址,缺省为$url="../js/MTIR.js";
 * |   返回值：输出JS脚本
 * +--------------------------------------------------
 */
function loadMtir($url = "")
{
    if (empty($url)) echo "<script src=\"spider/include/htmlframe.js\"></script>";
    else echo "<script src=\"$url\"></script>";
} 

/**
 * +--------------------------------------------------
 * |   函数名：loadMtirPage
 * |   作用：预先装载某个页面
 * |
 * 
 * @param  $ : $frame为显示的区域,$from为要显示的源目标,$second为定时更新预装载页面,单位为秒
 * |   返回值：输出JS脚本
 * +--------------------------------------------------
 */
function loadMtirPage($frame, $from, $innerHTML, $second = 0)
{
    if ($second == 0)
        echo "<script language=\"javascript\"> function frame_init() { document.getElementById('$frame').location('$from');document.getElementById('$frame').innerHTML='$innerHTML';} </script>";
    else echo "<script  language=\"javascript\"> function frame_init() { document.getElementById('$frame').location('$from');document.getElementById('$frame').innerHTML='$innerHTML';setTimeout('frame_init()',$second);}</script>";
}

/**
 * +--------------------------------------------------
 * |   函数名：setMtirFrame
 * |   作用：设置要显示的区域
 * |
 * 
 * @param  $ : $frame为要显示的区域
 * |   返回值：输出JS脚本
 * +--------------------------------------------------
 */
function setMtirFrame($frame)
{
    echo "<span id=$frame _frame></span>";
}

/**
 * +--------------------------------------------------
 * |   函数名：setMtirTarget
 * |   作用：跟href form等结合用,设置显示的区域_target=$target _addon=$addon;
 * |
 * 
 * @param  $ : $target为将要显示的区域,$addon为显示的方式,"","after","before";
 * |   返回值：输出JS脚本
 * +--------------------------------------------------
 */
function setMtirTarget($target, $addon = "")
{
    switch ($addon)
    {
        case "before" : echo "_target=$target _addon";
            break;
        case "after" : echo "_target=$target _addon=\"$addon\"";
            break;
        default : echo "_target=" . $target;
            break;
    } 
} 

/**
 * +--------------------------------------------------
 * |   函数名：setMtirLink
 * |   作用：只跟Link结合用,设置显示的区域_target=$target _addon=$addon;
 * |
 * 
 * @param  $ : $target为将要显示的区域,$addon为显示的方式,"","after","before";
 * |   返回值：输出JS脚本
 * +--------------------------------------------------
 */
function setMtirLink($target, $addon = "")
{
    setMtirTarget($target, $addon);
} 

/**
 * +--------------------------------------------------
 * |   函数名：setMtirForm
 * |   作用：只跟Form结合用,设置显示的区域_target=$target _addon=$addon;
 * |
 * 
 * @param  $ : $target为将要显示的区域,$addon为显示的方式,"","after","before";
 * |   返回值：输出JS脚本
 * +--------------------------------------------------
 */
function setMtirForm($target, $addon = "")
{
    setMtirTarget($target, $addon);
} 

/**
 * +--------------------------------------------------
 * |   函数名：addMtirBotton
 * |   作用：插入一个botton,,来源文件,以及显示方式
 * |
 * 
 * @param  $ : $bottonName为按键的名字,$frame为显示区域,$from为来源文件,$addon显示方式,默认为替换,before;在区域前插入信息,after:    在区域后插入信息
 * |   返回值：输出JS脚本
 * +--------------------------------------------------
 */

function addMtirBotton($bottonName, $frame, $from, $addon = "")
{
    switch ($addon)
    {
        case "before" :echo "<button onclick=\"frame('$frame').location('$from',true,'after')\">$bottonName</button>";
            break;
        case "after" :echo "<button onclick=\"frame('$frame').location('$from',true,'before')\">$bottonName</button>";
            break;
        default :echo "<button onclick=\"frame('$frame').location('$from',false)\">$bottonName</button>";
            break;
    } 
} 

/**
 * +--------------------------------------------------
 * |   函数名：loadMultiPage
 * |   作用：预先装载多个页面
 * |
 * 
 * @param  $ : $frame为显示的区域,$from为要显示的源目标,$second为定时更新预装载页面,单位为秒
 * |   返回值：输出JS脚本
 * +--------------------------------------------------
 */
function loadMultiPage($framepre, $fromArr, $innerHTML, $second = 0)
{
    if ($second == 0)
    {
        echo "<script language=\"javascript\"> function frame_init() { ";
        for($i = 0;$i < count($fromArr);$i++)
        {
			echo "document.getElementById('$framepre$i').location('$fromArr[$i]');\r\n";
            echo "document.getElementById('$framepre$i').innerHTML='$innerHTML';\r\n";
        } 
        echo "}</script>";
    } 
    else
    {
        echo "<script language=\"javascript\"> function frame_init() { ";
        for($i = 0;$i < count($fromArr);$i++)
        {
            echo "document.getElementById('$framepre$i').location('$fromArr[$i]');\r\n";
            echo "document.getElementById('$framepre$i').innerHTML='$innerHTML';setTimeout('frame_init()',$second);\r\n";
        } 
        echo "}</script>";
    } 
} 

?>