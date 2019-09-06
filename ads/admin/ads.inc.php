<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'include/ads_place.class.php';
require_once MOD_ROOT.'include/ads.class.php';
require_once 'attachment.class.php';

$action = $action ? $action : 'manage';
$c_ads = new ads();
$adsplace = new ads_place();

switch($action)
{
	case 'add':
		if($dosubmit)
		{
			if(!$c_ads->add($ads)) showmessage($c_ads->msg(), 'goback');
			showmessage($LANG['opration_successd_you_can_select_record_in_advertisement_order_list'], '?mod=ads&file=ads&action=manage','5000');
		}
		else
		{
			$placeid = intval($placeid);
			$place = array();
			$places = array();
			if(!$placeid) $places[0] = '请选择广告位';
			$place = $db->select("SELECT placeid, placename FROM ".DB_PRE."ads_place ORDER BY placeid", 'placeid');
			foreach($place as $key => $value)
			{
				foreach($value as $v)
				{
					$places[$key] = $v;
				}
			}
			include admin_tpl('ads_add');
		}
	break;

	case 'manage':

		$page = $page ? intval($page) : 1;
		$expired = $expired ? intval($expired) : 1;
		$adsplaceid = $adsplaceid ? intval($adsplaceid) : 0;
		$pagesize = $M['pagesize'] ? intval($M['pagesize']) : 15;
		$pages = $c_ads->page($page, $expired, $adsplaceid, $pagesize,$username,$status,$passid );
		$offset = ($page-1)*$pagesize;
		$adssigns = $place = array();
		$adssigns = $c_ads->manage($offset, $pagesize);
		$place = $c_ads->get_places();
		$expireds = array(3=>'等待广告列表', 1=>$LANG['right_ads'], 2=>$LANG['timeout_ads']);
		include admin_tpl('ads_manage');
	break;

	case 'edit':

        if($dosubmit)
        {
            if(!$c_ads->edit($ads, $adsid)) showmessage($c_ads->msg(), 'goback');
            showmessage($LANG['edit_ads_success'], '?mod=ads&file=ads');
        }
        else
        {
            $adsid = intval($adsid);
            $_ads = $places = array();
            $_ads = $c_ads->get_info($adsid);
            include admin_tpl('ads_edit');
        }
	break;
	case 'passed':
        if(empty($adsid)) showmessage('请选择要操作的广告');
        $val = intval($val);
        if(!in_array($val, array('0', '1'))) showmessage($LANG['illegal_move_parameters'], 'goback');
        if($c_ads->update($adsid, $val)) showmessage($LANG['opration_completed'], '?mod=ads&file=ads');
        break;
    case 'delete':
        if(empty($adsid)) showmessage('请选择要删除的广告');
        if($c_ads->delete($adsid)) showmessage($LANG['opration_completed'], '?mod=ads&file=ads');
	    break;
	case 'view':

        $adsid = intval($adsid);
        echo "<SCRIPT LANGUAGE=\"JavaScript\">";
        $c_ads->view($adsid);
        echo "</script>";
        break;

	case 'stat':
        $type = empty($type) ? 1 : intval($type);
        $states = array();
        $c_ads->updatearea($adsid);
        $year = date('Y',TIME);
        $month = date('m',TIME);
        $day = date('d',TIME);
        if($range == 2)
        {
            $fromtime = date('Y-m-d H:i:s',mktime(0, 0, 0, $month, $day-2, $year));
            $totime = date('Y-m-d H:i:s',mktime(0, 0, 0, $month, $day-1, $year));
        }
        elseif(is_numeric($range))
        {
            $fromtime = date('Y-m-d H:i:s',mktime(0, 0, 0, $month, $day-$range, $year));
        }
		/*历史数据按月份查询*/

		$year = isset($_GET['year']) ? $_GET['year'] : '';
		$diff1 = date('Y',TIME);/*当前年份*/
		$diff2 = date('m',TIME);/*当前月份*/
		$diff = ($diff1-2010)*12+$diff2;
		$selectstr = "";
		for($y=$diff;$y>0;$y--) {
			$value = date("ym", mktime(0, 0, 0, $y, 1, 2010));
			if($value<'1002') break;
			$selected = $year==$value ? 'selected' : '';
			$selectstr .= "<option value='$value' $selected>".date("Y-m", mktime(0, 0, 0, $y, 1, 2010));
		}
		if($year) {
			$c_ads->stat_table = DB_PRE.'ads_'.$year;
		} else {
			$c_ads->stat_table = DB_PRE.'ads_'.date('ym',TIME);
		}
		//检查表是否存在，如果不存在，则创建表
		$table_status = $db->table_status($c_ads->stat_table);
		if(!$table_status) {
			include MOD_ROOT.'include/create.table.php';
		}

        $states = $c_ads->stat($adsid, $type, $fromtime, $totime);
        include admin_tpl('ads_stat');
	break;
}
?>