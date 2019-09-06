<?php
function checkModConfig()
{
   global $M;
   if(empty($M['keywordContentLenght']))
   {
		showmessage('从内容的前N个字符提取关键词尚未设置！',"?mod=spider&file=setting");
   }
   if(empty($M['keywordNumber']))
   {
		showmessage('单篇文章提取关键词数尚未设置！',"?mod=spider&file=setting");
   }
   if(empty($M['keywordStrLength']))
   {
		showmessage('提取关键词最小长度尚未设置！',"?mod=spider&file=setting");
   }
   if(empty($M['keywordStrMaxLength']))
   {
		showmessage('提取关键词最大长度尚未设置！',"?mod=spider&file=setting");
   }
   if(empty($M['descriptionLength']))
   {
		showmessage('自动提取摘要长度尚未设置！',"?mod=spider&file=setting");
   }
}
function clearHtmlChars($s)
{
	$a = array("&lt","&gt","，","；","‘","“","&nbsp;","<br />");
	return str_replace($a,'',$s);
}
// 获取关键字
function get_keywords($title, $body = '', $length = 50, $sep = ' ')
{
    global $sp,$M;
    $keywords = '';
	$title = strip_tags($title);
	$body = strip_tags($body);
	$M['keywordContentLenght']= (int)$M['keywordContentLenght'];
	if($M['keywordContentLenght']<0)$M['keywordContentLenght']=200;
    $title_indexs = explode(' ', trim($sp->GetIndexText($sp->SplitRMM($title))));
    $body_indexs = explode(' ', trim($sp->GetIndexText($sp->SplitRMM($body), $M['keywordContentLenght'])));
    $indexs = array_unique(array_merge($title_indexs, $body_indexs));
    $keywords = array();
    $i = 0;
	$keywordFilter = explode("|",$M['keywordFilter']);
    foreach($indexs as $key => $val)
    {
        $val = str_replace($keywordFilter,'',$val);
		if(strlen($val)<$M['keywordStrLength']||strlen($val)>$M['keywordStrMaxLength']) continue;
		if (!empty($val) && $i < $length)
        {
            $keywords[$i++] = trim($val);
        }
    }
    unset($title_indexs);
    unset($body_indexs);
    unset($indexs);
    $keywords = implode($sep, $keywords);
    $keywords = addslashes($keywords);
    return $keywords;
}
// 按照类型删除缓存
// $type  url 或者 title
// $item  md5后内容
function deleteCache($type, $item)
{
    global $Debug;
    if (empty($item))return;
    $cachefile = MOD_ROOT . '/rules/' . $type . '/' . substr($item, 0, 2) . '.txt';
    $cachefile = str_replace('//', '/', $cachefile);
    if (file_exists($cachefile))
    {
        if ($Debug)echo '从' . $cachefile . '中删除' . $item . '<br>';
        $tmp = file_get_contents($cachefile);
        $tmp = str_replace($item, '', $tmp);
        $tmp = str_replace('||', '|', $tmp);
        file_put_contents($cachefile, $tmp);
    } 
    // die($cachefile);
} 

function dataLoadFromDb($sql, $feild)
{
    global $db, $listCache, $ContentCache, $Debug, $CachePath, $ChangeTag,$M;
    if ($Debug)echo $sql . '<br>';
 	if(!dataIsCache()) return false;
    $result = $db->query($sql);
    $i = 0;
    while ($r = $db->fetch_array($result))
    {
        $tmp = md5($r[$feild]);
        $file = substr($tmp, 0, 2) . '.txt';
        if ($Debug)echo '增加' . $tmp . '->' . $file . '<br>';
        $ContentCache[$file][$tmp] = true;
        $ChangeTag[$file] = true;
        $listCache[$file] = true;
        $i++;
    } 
    if ($Debug)echo '共载入缓存' . $i . '条,生成文件' . count($ContentCache) . '个<br>';
} 
// 按照子文件缓存
// $cacheMaxCounter 最大缓存计数器，超过$cacheMaxCounter个新数据后，开始写入文件
function dataLoad()
{
    global $listCache, $ContentCache, $Debug, $CachePath, $ChangeTag, $cacheMaxCounter,$M;
 	if(!dataIsCache()) return false;

	$listCache = scandir($CachePath);
    unset($listCache[0]);
    unset($listCache[1]);
    $listCache = array_flip($listCache);
    $ContentCache = array();
    $ChangeTag = array();
    $cacheMaxCounter = 10;
}
// 是否开启缓存，
//1. 如果开启网址缓存，并且当前为 url判断 返回  true
//2. 如果开启标题缓存，并且当前为 title判断 返回  true
function dataIsCache()
{
    global $CachePath,$M;
 	if($M['CacheUrlTag'] && strpos($CachePath,'/url'))
	{
		return true;
	}
 	if($M['CacheTitleTag']&&strpos($CachePath,'/title'))
	{
		return true;
	}
	return false;
}
// 缓存判断，存在列表就返回true ,不存在则返回false
function dataExists($data)
{
    global $listCache, $ContentCache, $Debug, $CachePath, $ChangeTag,$M;
	//没有开启缓存，返回false,表示不存在，可以采集或者入库
	if(!dataIsCache())
	{
		return false;
	}
	$tmp = md5($data);
    $file = substr($tmp, 0, 2) . '.txt';
    if (isset($listCache[$file]))
    { 
        // 文件存在，读取缓存文件至内存中
        if (!isset($ContentCache[$file]))
        { 
            // 读取内容
            $cache = @file_get_contents($CachePath . '/' . $file);
            $cache = explode('|', $cache); 
            // $cache = @file ($CachePath.'/'.$file);
            $ContentCache[$file] = array_flip($cache);
        } 
        if (isset($ContentCache[$file][$tmp]))
        {
            if ($Debug)echo $data . '已存在' . $file . '->' . $tmp . '<br>';
            return true;
        } 
        else
        {
            if ($Debug)echo '需要增加md5' . $tmp . '->' . $file . '<br>'; 
            // 计入缓存
            $ChangeTag[$file] = true;
            $ContentCache[$file][$tmp] = true;
        } 
    } 
    else
    { 
        // 文件不存在，创建文件并缓存相关内容
        if ($Debug)echo '需要创建文件' . $file . '<br>';
        if ($Debug)echo '需要增加md5' . $tmp . '<br>';
        $listCache[$file] = true;
        $ChangeTag[$file] = true;
        $ContentCache[$file][$tmp] = true;
    } 
    return false;
} 
// 写data缓存文件
function dataCache($writetag = false)
{
    global $listCache, $ContentCache, $Debug, $CachePath, $ChangeTag, $cacheMaxCounter,$M;
    if (!is_array($ChangeTag))return false;
 	if(!dataIsCache()) return false;

	if ($writetag || count($ChangeTag) >= $cacheMaxCounter)
    {
        foreach($ChangeTag as $file => $tag)
        {
            $tmp = array_keys($ContentCache[$file]);
            $tmp = array_unique($tmp); 
            // if($Debug)echo '写缓存'.$CachePath.'/'.$file.'<br>';
            @file_put_contents($CachePath . '/' . $file, implode("|", $tmp));
        } 
        $ChangeTag = array();
    } 
} 

function dataFree()
{
    global $listCache, $ContentCache, $Debug, $CachePath, $ChangeTag,$M;
    unset($listCache);
    unset($ContentCache);
    unset($Debug);
    unset($CachePath);
    unset($ChangeTag);
} 

function unempty($r)
{
    return ($r != '' && $r != "\n" && $r != "\r" && $r != " ");
} 
function pre($r)
{
    echo "<pre>";
    print_r($r);
    echo "</pre>";
} 
// 时间函数 获得页面执行时间
function getmicrotime()
{
    list($usec, $sec) = explode(" ", microtime());
    $temp = ((float)$usec + (float)$sec) * 1000; // 返回毫秒数 
    return number_format($temp, 3, '.', ''); // 去小数点后2位
} 
function cache_array($array, $arrayname, $file)
{
    $data = var_export($array, true);
    $data = "<?php\n" . $arrayname . "=" . $data . ";\n?>\n";
    file_write($file, $data);
    return $array;
} 
function adminmenu($menuname, $submenu = array())
{
    global $mod, $file, $action;
    $menu = $s = '';
    foreach($submenu as $m)
    {
        $title = isset($m[2]) ? "title='" . $m[2] . "'" : "";
        $menu .= $s . "<a href='" . $m[1] . "' " . $title . ">" . $m[0] . "</a>";
        $s = ' | ';
    } 
    return include MOD_ROOT . '/admin/templates/adminmenu.tpl.php';
} 

function array_save($array, $arrayname, $file)
{
    $data = var_export($array, true);
    $data = "<?php\n" . $arrayname . " = " . $data . ";\n?>";
    return file_put_contents($file, $data);
} 

?>