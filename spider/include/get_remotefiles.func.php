<?php
defined('IN_PHPCMS') or exit('Access Denied');
if ($PHPCMS['watermark_enable'])
{
    require_once PHPCMS_ROOT.'/include/image.class.php';
	$watermark_img = PHPCMS_ROOT.$PHPCMS['watermark_img'];
	$image = new image();
}
function get_remotefiles($string, $ext = 'gif|jpg|jpeg|bmp|png', $absurl = '', $basehref = '', $down = true, $uploaddir = "uploadfile")
{
    $remotefileurls = get_remotefileurls(new_stripslashes($string), $ext, $absurl, $basehref, $down);
    $urls = do_saveremotefiles($remotefileurls, $uploaddir, $down);
    return do_replaceremoteurls($string, $urls);
} 

function get_remotepics($string, $uploaddir)
{
    return get_remotefiles($string, 'gif|jpg|jpeg|bmp|png', '', '', true, $uploaddir);
} 

function get_remotefileurls($string, $ext = 'gif|jpg|jpeg|bmp|png', $absurl = '', $basehref = '', $down = true)
{
    global $PHP_DOMAIN;
    if ($ext == '') $ext = '[A-Za-z0-9]{2,4}';
    if (!preg_match_all("/<(?:a|img).+?(href| src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i", $string, $matches))
    {
        return array();
    } 
    $remotefileurls = array();
    foreach($matches[3] as $matche)
    {
        if ($PHP_DOMAIN && strpos($matche, $PHP_DOMAIN) !== false) continue;
        $remotefileurls[$matche] = ($down == true) ? $matche : FillUrl($matche, $absurl, $basehref);
    } 
    unset($matches, $string);
    return array_unique($remotefileurls);
} 

function do_saveremotefiles($files, $uploaddir = 'uploadfile', $down = true)
{
    global $image,$watermark_img, $PHPCMS, $att;

    $filepath = PHPCMS_PATH . $uploaddir . '/' . date('Ym') . '/';
    $uploaddir = PHPCMS_ROOT . '/' . $uploaddir . '/' . date('Ym') . '/';
    dir_create($uploaddir);
    $oldpath = $newpath = array();
    foreach($files as $k => $file)
    {
        if (strpos($file, "://") === false) continue;
        if ($down)
        { 
            // $k为相对地址，$file为替换过的绝对地址
            srand ((double) microtime() * 1000000);
            $filename = date('Ymdhis') . rand(100, 999) . "." . fileext($file);
            $newfile = $uploaddir . $filename;
            $newfile = str_replace('//','/',$newfile);

            if (@copy($file, $newfile))
            {
                $oldpath[$k] = $k;
                $newpath[$k] = $filepath . $filename;
                if ($PHPCMS['watermark_enable']&& file_exists($newfile))
                {
					$image->watermark($newfile, '', $PHPCMS['watermark_pos'], $watermark_img, '', 5, '#ff0000', $PHPCMS['watermark_jpgquality']);
                }
                @chmod($newfile, 0777);
                if (is_object($att)) $att->addfile(str_replace(PHPCMS_ROOT, '', $newfile));
            } 
        } 
        else
        {
            $oldpath[$k] = $k;
            $newpath[$k] = $file;
        } 
    } 
    return array('old' => $oldpath, 'new' => $newpath);
} 

function do_replaceremoteurls($string, $urls)
{
    return str_replace($urls['old'], $urls['new'], $string);
} 


function FillUrl($surl, $absurl, $basehref = '')
{
    if ($basehref != '')
    {
        $preurl = strtolower(substr($surl, 0, 6));
        if ($preurl == 'http:/' || $preurl == 'ftp://' || $preurl == 'mms://' || $preurl == 'rtsp:/' || $preurl == 'thunde' || $preurl == 'emule:' || $preurl == 'ed2k:/')
            return $surl;
        else
            return $basehref . '/' . $surl;
    } 
    $i = 0;
    $dstr = '';
    $pstr = '';
    $okurl = '';
    $pathStep = 0;
    $surl = trim($surl);
    if ($surl == '') return ''; 
    $urls = @parse_url($absurl);
    $HomeUrl = $urls['host'];
    $BaseUrlPath = $HomeUrl . $urls['path'];
    $BaseUrlPath = preg_replace("/\/([^\/]*)\.(.*)$/", '/', $BaseUrlPath);
    $BaseUrlPath = preg_replace("/\/$/", '', $BaseUrlPath);
    $pos = strpos($surl, '#');
    if ($pos > 0) $surl = substr($surl, 0, $pos);
	if ($surl[0] == '/')
    {
        $okurl = 'http://' . $HomeUrl . '/' . $surl;
    } elseif ($surl[0] == '.')
    {
        if (strlen($surl) <= 2) return '';
        elseif ($surl[1] == '/')
        {
            $okurl = 'http://' . $BaseUrlPath . '/' . substr($surl, 2, strlen($surl)-2);
        } 
        else
        {
            $urls = explode('/', $surl);
            foreach($urls as $u)
            {
                if ($u == "..") $pathStep++;
                else if ($i < count($urls)-1) $dstr .= $urls[$i] . '/';
                else $dstr .= $urls[$i];
                $i++;
            } 
            $urls = explode('/', $BaseUrlPath);
            if (count($urls) <= $pathStep)
                return '';
            else
            {
                $pstr = 'http://';
                for($i = 0;$i < count($urls) - $pathStep;$i++)
                {
                    $pstr .= $urls[$i] . '/';
                } 
                $okurl = $pstr . $dstr;
            } 
        } 
    } 
    else
    {
        $preurl = strtolower(substr($surl, 0, 6));
        if (strlen($surl) < 7)
            $okurl = 'http://' . $BaseUrlPath . '/' . $surl;
        else if ($preurl == "http:/" || $preurl == 'ftp://' || $preurl == 'mms://' || $preurl == "rtsp://" || $preurl == 'thunde' || $preurl == 'emule:' || $preurl == 'ed2k:/')
            $okurl = $surl;
        else
            $okurl = 'http://' . $BaseUrlPath . '/' . $surl;
    } 
    $preurl = strtolower(substr($okurl, 0, 6));
    if ($preurl == 'ftp://' || $preurl == 'mms://' || $preurl == 'rtsp://' || $preurl == 'thunde' || $preurl == 'emule:' || $preurl == 'ed2k:/')
    {
        return $okurl;
    } 
    else
    {
        $okurl = eregi_replace("^(http://)", '', $okurl);
        $okurl = eregi_replace("/{1,}", '/', $okurl);
        return 'http://' . $okurl;
    } 
} 

?>