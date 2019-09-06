<?php
include '../include/common.inc.php';
if(!$_userid) exit;

$times = TIME - $PHPCMS['editor_max_data_hour']*3600;
$db->query("DELETE FROM ".DB_PRE."editor_data WHERE created_time<$times");

header('Content-type: text/html; charset=utf-8');

switch($action)
{
	case '':
		if($data == '') exit;
		if(CHARSET != 'utf-8')
		{
			$data = iconv('utf-8', CHARSET, $data);
			$data = addslashes($data);
		}
		$db->query("INSERT INTO ".DB_PRE."editor_data SET userid='$_userid', editorid='$editorid', ip='".IP."', created_time='".TIME."', data='$data'");
		echo 'ok';
		break;

	case 'get':
		$hour = intval($hour);
		
		if($hour>1)
		{
			$hour_start = TIME - $hour*3600;
			$hour_end = TIME - ($hour-1)*3600;
			$where_time = " AND created_time>=$hour_start AND created_time<=$hour_end";
		}
		elseif($hour==1)
		{
			$hour_end = TIME - 3600;
			$where_time = " AND created_time>=$hour_end";
		}
		else
		{
			$where_time = '';
		}
		$data = array();
		$result = $db->query("SELECT `created_time`,`id` FROM ".DB_PRE."editor_data WHERE userid=$_userid AND editorid='$editorid' $where_time ORDER BY id DESC");
		while($r = $db->fetch_array($result))
		{
			$r['created_time'] = date('Y-m-d H:i:s', $r['created_time']);
			$data[] = $r;
		}
		$db->free_result($result);
		echo json_encode($data);
		break;

	case 'get_data':
		$id = (isset($id) && $id) ? intval($id) : exit;
		$r = $db->get_one("SELECT `data` FROM ".DB_PRE."editor_data WHERE `id`=$id");
		if(CHARSET != 'utf-8')
        {
            $data = iconv(CHARSET, 'utf-8', $r['data']);
        }
        else
        {
            $data = $r['data'];
        }
		echo $data;
		break;

}