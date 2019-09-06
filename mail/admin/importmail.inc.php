<?php
defined('IN_PHPCMS') or exit('Access Denied');
define('CACHE_IMPORT_PATH', PHPCMS_ROOT.'data/cache_import/');
require PHPCMS_ROOT.'include/admin/import_funcs.inc.php';
if(!class_exists('import'))
{
	require PHPCMS_ROOT.'include/admin/import.class.php';
}
$import = new import();
if(!class_exists('datasource'))
{
	require PHPCMS_ROOT.'include/admin/datasource.class.php';
}
$datasource = new datasource();
$mail_datadir = PHPCMS_ROOT.'data/mail/data/';
switch ($action)
{
    case 'import':
		$import_info = $import->view('mail','mail');
		if($import_info['expire']) @set_time_limit($import_info['expire']);
		$name = $import_info['name'];
	    $number = $import_info['number'];
	    $offset = isset($offset) ? intval($offset) : 0 ;
        $result = $import->_db_content($import_info, $offset);
         list($finished, $start, $total) = explode('-', $result);
		$newoffset = $offset + $number;
		$end = $offset + 1;
		$start = $finished ? ($offset + $importnum) : $newoffset;
		$forword = ($total < $offset) ? "?mod=mail&file=maillist&action=list" : "?mod=mail&file=importmail&action=import&type=mail&offset=$newoffset&total=$total";
		($total < $offset) ? showmessage('成功导出', $forword) : showmessage('成功导出'.$finished.'条<br />开始导出'.$start.'到'.$end, $forword);
		break;
	case 'choice':
		$info = $datasource->listinfo();
        $data = array();
        $data[0] = '请选择';
		foreach ($info as $k=>$v)
		{
			$data[$v['name']] = $v['name'];
		}
		include admin_tpl('import_mail');
    break;
    case 'setting':
		if ($dosubmit)
		{
            $forword = "?mod=mail&file=importmail&action=manage&type=mail";
			$type = $setting['name'] = 'mail';
			$import->setting($setting, $type);
			showmessage('保存配置文件成功',$forword);
		}
		else
		{
            if($dataname == '0') showmessage('请选择数据源','goback');
            if(!preg_match("/^[0-9a-z_]+$/i",$mailname)) showmessage('文件名称错误','goback');
            $savemailfile = $mailname.'.txt';
            if(file_exists($mail_datadir.$savemailfile)) showmessage($savemailfile.'已经存在','goback');
			$setting = $import->view('mail', 'mail');
            $setting['dataname'] = $dataname;
			$data = cache_read('db_'.$dataname.'.php');
            include admin_tpl('import_mail_setting');
		}
		break;
    case 'manage':
        $type = trim($type);
        $forword = "?mod=mail&file=importmail&action=import&type=mail";
        if(!empty($type))
        {
            $info = $import->manage($type);
            showmessage('开始导出请等待...',$forword);
        }
		break;

}
?>