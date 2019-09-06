<?php
defined('IN_PHPCMS') or exit('Access Denied');

//获取邮件列表
if(!file_exists(PHPCMS_ROOT.'/'.$mail_setdir.'mail.php'))
{
	showmessage($LANG['setting_file_not_exist']);		
}
$data = include(PHPCMS_ROOT.'/'.$mail_setdir.'mail.php');
if($data)
{
	$dbfile = PHPCMS_ROOT.'/include/db_'.$data['database'].'.class.php';
	if(!file_exists($dbfile))
		showmessage($LANG['database_class_file'].' '.$dbfile.$LANG['not_exist']);
	require_once($dbfile);
	@set_time_limit(120);
	$pagesize=$data['number']>1 ? $data['number'] : 100;
	$mails='';
	$page = isset($page) ? $page : 1; 
	$offset=($page-1)*$pagesize;
	$page++;
	if($data['dbfrom']==1)
	{
		$maildb = $db;
	}
	else
	{
		$maildb= new db();
		$maildb -> connect($data['dbhost'],$data['dbuser'],$data['dbpw'], $data['dbname']);
		$maildb -> select_db($data['dbname']);
	}
	$mail_field = $data['field'];
	$condition = $data['condition'] ? " where ".$data['condition'] : "";

	$sql = "select count(*) as totalnum from ".$data['table'].$condition;
	$query = $maildb->query($sql);
	$rs = $maildb->fetch_array($query);
	$totalnum = $rs['totalnum'];

	$sql = "select ".$mail_field." from ".$data['table'].$condition;
	$sql.= " limit $offset,$pagesize ";
	$query = $maildb->query($sql);

	$i=0;
	while($m = $maildb->fetch_array($query))
	{
		$mails.= $m[$mail_field]."\n";
		$i++;
	}
	if($offset>=$totalnum)
		showmessage($LANG['maillist_file']." <a href=\"".$mail_datadir.$data['file']."\" >{$data['file']}</a> ".$LANG['save_success_send_now'].'<br /><a href="?mod='.$mod.'&file=send&type=3&filename='.urlencode($data['file']).'" title="" >[  '.$LANG['yes'].' 	]</a>&nbsp;&nbsp;&nbsp;<a href="?mod='.$mod.'&file='.$file.'&action=manage" title="" >[  '.$LANG['no'].'  ]</a>');
	
	file_put_contents(PHPCMS_ROOT.'/'.$mail_datadir.$data['file'],$mails);
	$forward = $totalnum<= $offset ? '' : '?mod='.$mod.'&file=maillist&action=getlist&page='.$page;
	showmessage($LANG['id_from'].($offset+1).$LANG['to'].($offset+$i).$LANG['pick_up_save_success'],$forward);
}
		
?>