<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'admin/datasource.class.php';
$datasource = new datasource();

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$result = $datasource->add($info);
			if($result)
			{
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			include admin_tpl('datasource_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $datasource->edit($name, $info);
			if($result)
			{
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			$info = $datasource->get($name);
			if(!$info) showmessage('指定的数据源不存在！');
			extract($info);
			include admin_tpl('datasource_edit');
		}
		break;
    case 'delete':
		$result = $datasource->delete($name);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
	case 'checkname':
		echo $datasource->checkname($value) ? 'success' : '名称只能由字母、数字和下划线组成且不得重复';
		break;
    case 'link':
		echo $datasource->link($name) ? 1 : 0;
		break;
    case 'test':
		echo $datasource->test($dbhost, $dbuser, $dbpw, $dbname, $dbcharset);
		break;
    case 'tables':
		$arrtables = $datasource->tables($dbhost, $dbuser, $dbpw, $dbname, $dbcharset);
	    if($arrtables) echo form::select($arrtables, 'tablename', 'tablename', $tablename, 1, '', "onchange=\"$('#div_fields').load('?mod=phpcms&file=datasource&action=fields&dbhost='+myform.dbhost.value+'&dbuser='+myform.dbuser.value+'&dbpw='+myform.dbpw.value+'&dbname='+myform.dbname.value+'&dbcharset='+myform.dbcharset.value+'&tablename='+myform.tablename.value)\"");
		break;
    case 'fields':
		$arrfields = $datasource->fields($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $tablename);
	    if($arrfields)
	    {
			$data = '';
			foreach($arrfields as $field)
			{
				$data .= '<span style="width:100px">'.$field.'</span>';
			}
			echo $data;
		}
		break;
	
    default :
        $data = $datasource->listinfo('', '`name`');
		include admin_tpl('datasource');
}
?>