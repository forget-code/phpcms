<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(@ini_get('file_uploads'))
{
	$sys_info['fileupload'] = ini_get('upload_max_filesize');
}
else
{
	$sys_info['fileupload'] = '<font color="red">未知大小</font>';
}

function gd_version()
{
    static $version = -1;

    if ($version >= 0)
    {
        return $version;
    }

    if (!extension_loaded('gd'))
    {
        $version = 0;
    }
    else
    {
        // 尝试使用gd_info函数
        if (PHP_VERSION >= '4.3')
        {
            if (function_exists('gd_info'))
            {
                $ver_info = gd_info();
                preg_match('/\d/', $ver_info['GD Version'], $match);
                $version = $match[0];
            }
            else
            {
                if (function_exists('imagecreatetruecolor'))
                {
                    $version = 2;
                }
                elseif (function_exists('imagecreate'))
                {
                    $version = 1;
                }
            }
        }
        else
        {
            if (preg_match('/phpinfo/', ini_get('disable_functions')))
            {
                /* 如果phpinfo被禁用，无法确定gd版本 */
                $version = 1;
            }
            else
            {
              // 使用phpinfo函数
               ob_start();
               phpinfo(8);
               $info = ob_get_contents();
               ob_end_clean();
               $info = stristr($info, 'gd version');
               preg_match('/\d/', $info, $match);
               $version = $match[0];
            }
         }
    }

    return $version;
 }
$gd = gd_version();
if ($gd == 0)
{
    $sys_info['gd'] = 'N/A';
}
else
{
    if ($gd == 1)
    {
        $sys_info['gd'] = 'GD1';
    }
    else
    {
        $sys_info['gd'] = 'GD2';
    }

    $sys_info['gd'] .= ' (';

    /* 检查系统支持的图片类型 */
    if ($gd && (imagetypes() & IMG_JPG) > 0)
    {
        $sys_info['gd'] .= ' JPEG';
    }

    if ($gd && (imagetypes() & IMG_GIF) > 0)
    {
        $sys_info['gd'] .= ' GIF';
    }

    if ($gd && (imagetypes() & IMG_PNG) > 0)
    {
        $sys_info['gd'] .= ' PNG';
    }

    $sys_info['gd'] .= ')';
}

$sys_info['os']             = PHP_OS;
$sys_info['zlib']           = function_exists('gzclose');//zlib
$sys_info['safe_mode']      = (boolean) ini_get('safe_mode');//safe_mode = Off
$sys_info['safe_mode_gid']  = (boolean) ini_get('safe_mode_gid');//safe_mode_gid = Off
$sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : '没有设置';
$sys_info['socket']         = function_exists('fsockopen') ;
$sys_info['web_server']     = $_SERVER['SERVER_SOFTWARE']; //web服务器

$sys_info['short_open_tag'] = (boolean) @ini_get('short_open_tag');//短标签功能
$sys_info['php_fopenurl']   = (boolean) @ini_get('allow_url_fopen') ;//远程打开,不符合要求将导致采集、远程资料本地化等功能无法应用
//GD 不支持将导致与图片相关的大多数功能无法使用
$sys_info['php_dns']        = preg_match("/^[0-9.]{7,15}$/", @gethostbyname('www.phpcms.cn'));//域名解析
$sys_info['gzip']           = GZIP && function_exists('ob_gzhandler') ;//开启gzip设置

$sys_info['version']        = PHPCMS_VERSION;
$sys_info['phpv']           = phpversion();
$sys_info['mysqlv']         = $db->version();
$sys_info['ft_min_word_len'] = $db->get_one("SHOW VARIABLES LIKE 'ft_min_word_len'");
$sys_info['ft_min_word_len'] = $sys_info['ft_min_word_len']['Value'];
$sys_info['web_root']        = PHPCMS_ROOT;//网站跟目录
//ft min word len
//fopen
$entryarray = array(
            'index.html',
            'include/config.inc.php',
            'data/config.js',
            'sitemap.xml'
          );

$writelist = array('data/bakup','data/cache_model','data/cache_page','data/cache','data/cache_tag','data/cache_template','data/filterlog','data/log','data/temp','data/txt','uploadfile','data/js','about','templates');
foreach($writelist as $directory)
{
    getdirentry($directory);
}
$result = '';
foreach($entryarray as $entry)
{
    $fullentry = PHPCMS_ROOT.$entry;
    if(!is_dir($fullentry) && !file_exists($fullentry))
	{
        continue;
    } 
	else
	{
        if(!is_writeable($fullentry))
		{
            $result .= '<tr><td><font color="red">'.(is_dir($fullentry) ? '目录' : '文件')." ./$entry 无法写入</font></td></tr>";
        }
    }
}
$result = $result ? $result : '<tr><td>文件及目录属性全部正确</td></tr>';

function getdirentry($directory)
{
	global $entryarray;
	$dir = dir(PHPCMS_ROOT.$directory);
	while($entry = $dir->read())
	{
		if(!in_array($entry, array('.', '..', 'index.htm')))
		{
			if(is_dir(PHPCMS_ROOT.$directory.'/'.$entry))
			{
				getdirentry($directory."/".$entry);
			}
			$entryarray[] = $directory.'/'.$entry;
		}
	}
	$dir->close();
}
include admin_tpl('system_manage');
?>