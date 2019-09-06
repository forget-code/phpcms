<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : 'config';

//目录参数设置
$mail_setdir = "data/mail/";
$mail_datadir = "data/mail/data/";

$f->create(PHPCMS_ROOT."/".$mail_setdir);
$f->create(PHPCMS_ROOT."/".$mail_datadir);

//临时邮件参数设置
$tmpname = PHPCMS_ROOT."/data/mail/mailing.php";
$separator='|||';
$url="?mod=".$mod."&file=mail&action=send2";

//头部菜单
$submenu=array(
	array('获取邮件列表',"?mod=".$mod."&file=mail&action=config"),
	array('管理邮件列表',"?mod=".$mod."&file=mail&action=list"),
	array('群发邮件',"?mod=".$mod."&file=mail&action=send"),
	array('发送邮件',"?mod=".$mod."&file=mail&action=sendmail")
);
$menu=adminmenu('邮件列表',$submenu);


//获取系统发送邮件基本参数
$smtpserver	= $_PHPCMS['smtphost'];
$mfrom		= $_PHPCMS['smtpuser'];
$mfrom		= $mfrom ? $mfrom : $_PHPCMS['webmasteremail'];
$smtppass	= $_PHPCMS['smtppass'];
$smtpport	= $_PHPCMS['smtpport'];


switch($action)
{
//发送邮件表单
case 'send':
	if($submit)
	{
		if(empty($mail))
		{
			showmessage("请选择邮件列表文件，请返回。");
		}
		if(empty($msubject) || empty($mbody))
			showmessage('邮件主题和内容不能为空，请返回。');

		$forms=array($mail,$msendtype,$mformat,$mnum,$msubject,$mbody);
		foreach($forms as $k=>$v)
		{
			if(empty($v))
			{
				showmessage('所有设置项必须填写，请返回。');
				break;
			}
		}	
		$sendto = file($mail_datadir.'/'.$mail);
		$totalnum = count($sendto);
		$mnum = $mnum > $totalnum ? $totalnum : $mnum ;
		$mailtemp = array('mail'=>$mail,'msendtype'=>$msendtype,'mformat'=>$mformat,'mnum'=>$mnum,'msubject'=>$msubject,'mbody'=>$mbody);
        cache_array($mailtemp,"\$mailtemp",$tmpname);
		showmessage("开始发送，请稍候．．",$url."&start=0");
	}
	else
	{
		$fmail=$f->get_list($mail_datadir);
		$fmail=$fmail['file'];
		$fnumber = count($fmail);
		if($fnumber>0)
		{
			foreach( $fmail as $key=>$val)
			{
				$mailfiles[$key]=basename($val);
			}
		}
		else
		    showmessage("请先导出邮件列表，然后再发送！","?mod=mail&file=mail&action=config");
	    include admintpl('mail_send');
	}
	break;
//发送
case 'send2':

    @set_time_limit(600);

    @include $tmpname;
	@extract($mailtemp);
	
	$sendto = file($mail_datadir.$mail);
	$totalnum = count($sendto);

	if($totalnum>0)
	{					
		if($msendtype=='mail')
		{
			if(!function_exists('mail'))
			{
				showmessage('系统不支持 Mail 函数，请返回。');
			}
			if(empty($start)) $start=0;
			if($start==$totalnum) 
			{			
				$okmsg='发送电子邮件成功，请返回。';
				@unlink($tmpname);
				showmessage($okmsg,$referer);
			}
			else
			{	
				$sendnum=0;
				for($i=$start; $i<$start+$mnum; $i++)
				{
					$sendto[$i] = trim($sendto[$i]);
					if(!$sendto[$i]) continue;
					@mail($sendto[$i],$msubject,$mbody,$mfrom);
				}
				$tmp=$start+1;
				$start=$start+$mnum;
				showmessage("正在发送从 $tmp 到 $start 个电子邮件，成功发送 $sendnum 个。",$url.'&start='.$start);
			}
		}
		elseif($msendtype=='smtp')
		{
			require_once(PHPCMS_ROOT."/class/smtp.php");
			$smtp = new smtp($smtpserver,$smtpport,true,$mfrom,$smtppass);
			$smtp->debug = false;
			if(empty($start)) $start=0;
			if($start>=$totalnum) 
			{			
				@unlink($tmpname);
				showmessage("电子邮件发送成功，请返回。");
			}
			else
			{	
				$sendnum=0;
				for($i=$start; $i<$start+$mnum; $i++)
				{
					$sendto[$i] = trim($sendto[$i]);
					if(!$sendto[$i]) continue;
					$smtp->sendmail($sendto[$i],$mfrom,$msubject,$mbody,$mformat);
				}
				$tmp = $start+1;
				$start = $start+$mnum;
				showmessage("正在发送从 $tmp 到 $start 个电子邮件",$url.'&start='.$start);
			}					
		}
		else
			showmessage('请检查 Email 发送方式是否设置正确。');
	}
	else
	{
		showmessage('Email 文件读取错误。',$referer);
	}

	break;

//邮件列表
case 'list':
	$fmail=$f->get_list($mail_datadir);
	$fmail=$fmail['file'];
	$fnumber = count($fmail);
	if($fnumber>0)
	{
		foreach( $fmail as $key=>$val)
		{
			$mailfiles[$key]=basename($val);
		}
	}
	unset($fmail);
	include admintpl('mail_list');
	break;

//下载邮件列表
case 'down':
	if(fileext($mail)!="txt") showmessage("只允许下载txt格式的文件。");
    if(!preg_match("/^[0-9a-z_]+\.txt$/i",$mail)) showmessage("非法文件!");
	file_down($mail_datadir.$mail);
	break;

//删除邮件列表
case 'delete':
	if(fileext($mail)!="txt") showmessage("只允许删除邮件列表文件。");
    if(!preg_match("/^[0-9a-z_]+\.txt$/i",$mail)) showmessage("非法文件!");
	$mailfile=$mail_datadir.$mail;
	if(file_exists($mailfile))
	{
	    @$f->unlink($mailfile);
	}
	showmessage("操作成功。","?mod=mail&file=mail&action=list");

	break;
//删除选中的邮件列表
case 'deleteall':
	if(count($file)<=0)
	{
		showmessage('请选择要删除邮件列表文件。',$referer);
	}
	$fmail=$f->get_list($mail_datadir);
	$fmail=$fmail['file'];
	$fnumber = count($fmail);
	if($fnumber>0)
	{
		foreach( $fmail as $key=>$val)
		{
			$mailfiles[$key]=basename($val);
		}
	}
	$delnum=0;
	$mailnum=count($mail);
	for($i=0;$i<$mailnum;$i++)
	{
		if(in_array($mail[$i],$mailfiles))
		{
			$f->unlink($mail_datadir.$mail[$i]);
			$delnum++;	
		}	
	}
	if($delnum==$mailnum)
		showmessage("删除邮件列表文件成功，请返回。");
	else
		showmessage('操作失败，请返回。');

	break;
//获取邮件列表
case 'get':
		if(!file_exists($mail_setdir.'mail.php'))
		{
			showmessage('配置文件不存在，请返回。');		
		}
		include $mail_setdir.'mail.php';
		if($data)
		{
			$dbfile=PHPCMS_ROOT.'/class/db_'.$data['database'].'.php';
			if(!file_exists($dbfile))
				showmessage('数据库对应的类文件 '.$dbfile.'不存在，请返回。');
			require_once($dbfile);
			$data['timelimit']=$data['timelimit']>30 ? $data['timelimit']:60;
			@set_time_limit($data['timelimit']);
			$pagesize=$data['number']>1 ? $data['number'] : 100;
			$mails='';
			$page = $page ? $page : 1; 
			$offset=($page-1)*$pagesize;
			$page++;
	
			if($data['dbfrom']==1)
			{
				$maildb=$db;
			}
			else
			{
				$maildb= new db;
				$maildb->connect($data['dbhost'],$data['dbuser'],$data['dbpw'], $data['dbname']);
				$maildb->select_db($data['dbname']);
			}
			$mail_field=$data['field'];
			$condition = $data['condition'] ? " where ".$data['condition'] : "";

			$sql="select count(*) as totalnum from ".$data['table'].$condition;
			$query=$maildb->query($sql);
			$rs=$maildb->fetch_array($query);
			$totalnum=$rs['totalnum'];

			$sql="select ".$mail_field." from ".$data['table'].$condition;
			$sql.=" limit $offset,$pagesize ";
			$query=$maildb->query($sql);

			$i=0;
			while($m=$maildb->fetch_array($query))
			{
				$mails.=$m[$mail_field]."\n";
				$i++;
			}
			if($offset>=$totalnum)
				showmessage("邮件列表文件 <a href=\"".$mail_datadir.$data['file']."\" >{$data['file']}</a> 并保存成功！现在是否发送？<br />".'<a href="?mod='.$mod.'&file='.$file.'&action=send&mail='.urlencode($data['file']).'" title="" >[  是 	]</a>&nbsp;&nbsp;&nbsp;<a href="?mod='.$mod.'&file='.$file.'&action=list" title="" >[  否  ]</a>');
			
			file_write($mail_datadir.$data['file'],$mails,"ab");
			$referer = $totalnum<= $offset ? '' : '?mod='.$mod.'&file=mail&action=get&page='.$page;
			showmessage('第'.($offset+1).'到'.($offset+$i).'条数据提取并保存成功！',$referer);
		}
break;
case 'save':
	if($submit)
	{
		$upfile_size='1000000';
		$upfile_type='txt';
		$fileArr = array(
			'file'=>$uploadfile,
			'name'=>$uploadfile_name,
			'size'=>$uploadfile_size,
			'type'=>$uploadfile_type);
		if(!@preg_match("/^[0-9a-z_]+\.txt$/i",$fileArr['name']))
			showmessage("非法的文件名称，请返回修改。");

		$tmpext=strtolower(fileext($fileArr['name']));
		if($fileArr['type']!='text/plain' || $tmpext!=$upfile_type)
			showmessage("文件类型错误，邮件列表文件扩展名必须是 txt 。");

		$savepath = $mail_datadir;
		$f->create($savepath);

		$upload = new upload($fileArr,'',$savepath,$upfile_type,1,$upfile_size);
		if($upload->up())
			showmessage("邮件列表文件 <a href=\"".$mail_datadir.$upload->savename."\" >{$upload->savename}</a> 上传成功！现在是否发送？<br />".'<a href="?mod='.$mod.'&file='.$file.'&action=send&mail='.urlencode($upload->savename).'" title="查看" >[  是 	]</a>&nbsp;&nbsp;&nbsp;<a href="?mod='.$mod.'&file='.$file.'&action=list" title="" >[  否  ]</a>');
		else
			showmessage('无法上传，错误原因：'.$upload->errmsg());
	}
break;
//基本参数配置
case 'config':
	if($submit)
	{		
		if($newdata['dbfrom']==2)
		{
			if(empty($newdata['dbhost']))
				showmessage('请填写数据库主机地址。');
			if(empty($newdata['dbuser']))
				showmessage('请填写数据库用户名。');
			if(empty($newdata['dbname']))
				showmessage('请填写数据库名称。');		
		}
		if(empty($newdata['table']))
			showmessage('请填写源数据表名称。');
		if(empty($newdata['field']))
			showmessage('请填写源数据表电子邮件字段名。');

		if(!preg_match("/^[0-9a-z_]+$/i",$newdata['file']))
			showmessage("非法的文件名称，请返回修改。");

		if(intval($newdata['timelimit'])<1)
			showmessage('php脚本执行超时时限不能小于1，请返回。');
		if(intval($newdata['number'])<1)
			showmessage('每次提取数据条数不能小于1，请返回。');
		$newdata['file']=$newdata['file'].'.txt';

		if(file_exists($mail_datadir.$newdata['file']))
			showmessage($newdata['file'].'已经存在，请返回。');
		
		cache_array($newdata , '$'.'data' ,$mail_setdir.'mail.php');
		$referer='?mod='.$mod.'&file=mail&action=get';
		showmessage('配置保存成功，开始获取邮件数据 ... ',$referer);
	}
	else
	{
		if(file_exists($mail_setdir.'mail.php'))
		{
			include $mail_setdir.'mail.php';
			$data['file']=substr($data['file'],0,-4);
		}
		$data['table'] = $data['table'] ? $data['table'] : $tablepre."member";
		$data['field'] = $data['field'] ? $data['field'] : "email";

		include admintpl('mail_config');
	}

	break;

case 'sendmail':
	if($submit)
	{
		$from	= trim($from);
		$from= $from ? $from:$mfrom;
		$to		= trim($to);
			
		if(!is_email($to))
			showmessage('收件人Email 地址非法，请返回。');
		if(!is_email($from))
			showmessage('发件人Email 地址非法，请返回。');
		if(empty($subject) || empty($body))
			showmessage('邮件主题和内容不能为空，请返回。');
		if($sendtype=='mail')
		{
			if(!function_exists('mail'))
			{
				showmessage('系统不支持 Mail 函数，请返回。');
			}
			$headers= 'From: '.$from."\r\n";
			if(@mail($to,$subject,$body,$headers))
			{
				showmessage('恭喜您，邮件发送成功，请返回。');
			}
			else
			{
				showmessage('发送失败，系统不支持 Mail 函数或 Email 地址非法，请返回。');
			}

		}
		elseif($sendtype=='smtp')
		{	
			$smtpfile=PHPCMS_ROOT.'/class/smtp.php';
			if(file_exists($smtpfile))
			{
				require_once($smtpfile);
				$smtp = new smtp($smtpserver,$smtpport,true,$mfrom,$smtppass);
				$smtp->debug = false;
			}
			else
			{
				showmessage('类文件 smtp.php 不存在，请返回。');
			}
			
			if($smtp->sendmail($to,$from,$subject,$body,$format))
			{
				showmessage('恭喜您，邮件发送成功，请返回。');
			}
			else
			{
				showmessage('发送失败，请检查 SMTP 设置和所选择的邮件列表文件，请返回。');
			}	
		}
	}
	else
	{
		include admintpl('sendmail');
	}
	break;
default:
}
?>