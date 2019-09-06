<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';
require_once 'form.class.php';
switch($action)
{
	case 'manage':
		$modelid = get_modelid();
		require CACHE_MODEL_PATH.'member_output.class.php';
		$member = load('member.class.php', 'member', 'include');
		$data = $member->get_model_info($userid, $modelid);
		$member_output = new member_output($modelid, $userid);
		$forminfos = $member_output->get($data);
		
	break;

	case 'edit':
		$modelid = get_modelid();
		require CACHE_MODEL_PATH.'member_output.class.php';
		$member = load('member.class.php', 'member', 'include');
		require CACHE_MODEL_PATH.'member_form.class.php';
		$member_form = new member_form($modelid);
		if($dosubmit)
		{
			require CACHE_MODEL_PATH.'member_input.class.php';
			$member_input = new member_input($modelid);
			require CACHE_MODEL_PATH.'member_update.class.php';
			$member_update = new member_update($modelid, $_userid);
			$inputinfo = $member_input->get($info);
			if(isset($info) && is_array($info))
			{
				if(!$member->edit($info)) showmessage($member->msg());
			}
			$modelinfo = $inputinfo['model'];
			if($modelinfo)
			{
				$modelinfo['userid'] = $_userid;
				$member_update->update($modelinfo);
				$member->edit_model($modelid, $modelinfo);
			}
			$byear = intval($byear);
			$bmonth = intval($bmonth);
			$employnum = htmlspecialchars($employnum);
			$turnover = htmlspecialchars($turnover);
			$telephone = htmlspecialchars($telephone);
			
			$byear = intval($byear);
			$byear = $byear==19 ? '0000' : $byear;
			$bmonth = intval($bmonth);
			$establishtime = $byear.'-'.$bmonth.'-01';
			$db->query("UPDATE ".DB_PRE."member_company SET `establishtime`='$establishtime',`employnum`='$employnum',`turnover`='$turnover' WHERE `userid`='$userid'");
			showmessage('更新成功',$forward);
		}
		else
		{
			$memberinfo = $member->get($_userid, $fields = '*', 1);
			$memberinfo['avatar'] = avatar($_userid);
			@extract(new_htmlspecialchars($memberinfo));
			$data = $member->get_model_info($_userid, $modelid);
			$forminfos = $member_form->get($data);
			$establishtime = explode("-", $company_user_infos['establishtime']);
			$byear = $establishtime[0]== '0000' ? '19' : $establishtime[0];
			$bmonth = $establishtime[1];
			$montharr = array('01','02','03','04','05','06','07','08','09','10','11','12');
		}
	break;

	case 'basic':
		if($dosubmit)
		{
			$logo = htmlspecialchars($logo);
			$banner = htmlspecialchars($banner);
			$linkman = htmlspecialchars($linkman);
			$email = htmlspecialchars($email);
			$telephone = htmlspecialchars($telephone);
			$db->query("UPDATE ".DB_PRE."member_company SET `logo`='$logo',`banner`='$banner',`linkman`='$linkman',`email`='$email',`telephone`='$telephone',`introduce`='$introduce' WHERE `userid`='$userid'");
			showmessage('更新成功',$forward);
		}
	break;

	case 'checksitedomain':
		if($sitedomain)
		{			
			if(preg_match('/^([a-zA-Z0-9-]+)$/i',$sitedomain))
			{
				if(strlen($sitedomain) < $M['domainlestleth'])
				exit('域名长度不能少于'.$M['domainlestleth'].'个字符');
				else
				{
					$saveDomains = explode("\n",$M['savedDomain']);
					foreach($saveDomains as $p)
					{
						if(trim($sitedomain) == trim($p))exit('对不起，这个域名已经被管理员禁止注册！');
					}
				}
				$r = $db->get_one("SELECT userid FROM `".DB_PRE."member_company` WHERE `sitedomain`='$sitedomain'");
				if($r && $r['userid'] != $_userid)
				{
					exit('该域名已经被其他人占用，请选择其它...');
				}
				else
				{
					$db->query("UPDATE `".DB_PRE."member_company` SET `sitedomain`='$sitedomain' WHERE `userid`='$userid'");
					exit('1');
				}
				
			}
			else
			{
				exit('域名只能包含：小写字母、数字、中划线');
			}
		}
		else
		{
			exit('请输入二级域名，域名只能包含：小写字母、数字、中划线');
		}
		exit;
	break;
}
include template('yp', 'center_company');
?>