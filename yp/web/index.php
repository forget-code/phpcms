<?php
define('rootdir', str_replace("\\", '/', substr(dirname(__FILE__), 0, -7)));
$mod = 'yp';

require rootdir.'/include/common.inc.php';
require rootdir.'/yp/include/tag.func.php';
require PHPCMS_ROOT.'/yp/web/include/common.inc.php';

if(isset($categroy))
{
	$H_url = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$domainName.'/header.php';

	switch($categroy)
	{
		case 'product':
			require $H_url;
			$templateid = $tplType.'-product';
			include template('yp',$templateid);
		break;
		case 'buy':
			require $H_url;
			$templateid = $tplType.'-buy';
			include template('yp',$templateid);
		break;
		case 'sales':
			require $H_url;
			$templateid = $tplType.'-sales';
			include template('yp',$templateid);
		break;
		case 'article':
			require $H_url;
			$templateid = $tplType.'-article';
			include template('yp',$templateid);
		break;

		case 'job':
			$AREA = cache_read('areas_'.$mod.'.php');
			require $H_url;
			$result = $db->query("SELECT * FROM ".TABLE_YP_JOB." WHERE username='$username' AND status>=3 ORDER BY jobid DESC");
			while($r = $db->fetch_array($result))
			{
				extract($db->get_one("SELECT companyname FROM ".TABLE_MEMBER_COMPANY." WHERE companyid=$r[companyid]"));
				$r['companyname'] = $companyname;
				if($r['period'])
				{
					$r['period'] = $r['period']*86400+$PHP_TIME;
					$r['period'] = date("Y-m-d",$r['period']);
				}
				else
				{
					$r['period'] = $LANG['job_time_no_limit'];
				}
				$r['area'] = $AREA[$r['areaid']]['areaname'];
				$jobs[] = $r;
			}
			$templateid = $tplType.'-job';
			include template('yp',$templateid);
		break;

		case 'introduce':
			require $H_url;
			$datafile = 'userdata/'.$_userdir.'/'.$domainName.'/introduce.php';
			file_exists($datafile) ? include $datafile : exit('File not exists.');
		break;

		case 'order':
			if($dosubmit)
			{
				$itemid = intval($item);
				$r = $db->get_one("SELECT orderid FROM ".TABLE_YP_ORDER." WHERE label='$label' AND itemid='$itemid' AND status=0");
				if(!$r)
				{
					$number = intval($number);
					$qq = intval($qq);
					$companyid = intval($companyid);
					$content = strip_tags($content);
					$inputstring=new_htmlspecialchars(array('title'=>$title,'linkman'=>$linkman,'email'=>$email,'msn'=>$msn,'fax'=>$fax,'msn'=>$msn,'unit'=>$unit));
					extract($inputstring,EXTR_OVERWRITE);
					$result = $db->query("INSERT INTO ".TABLE_YP_ORDER." (`companyid`,`title`,`number`,`content`,`linkman`,`username`,`telephone`,`email`,`qq`,`msn`,`fax`,`unit`,`addtime`,`label`,`itemid`) VALUES ($companyid,'$title','$number','$content','$linkman','$_username','$telephone','$email','$qq','$msn','$fax','$unit',$PHP_TIME,'$label','$itemid')");
					if($db->affected_rows($result))
					$orderid = $db->insert_id();
					$order_no = date("ymdis",$PHP_TIME);
					$order_no = $order_no.$orderid;
					$db->query("UPDATE ".TABLE_YP_ORDER." SET order_no='$order_no' WHERE orderid=$orderid ");
					showmessage($LANG['order_successful'].$order_no,'close');
				}
				else
				{
					showmessage('你已经订购过此商品','close');
				}
			}
			else
			{
				if($_userid)
				{
					$productid = intval($item);
					@extract($db->get_one("SELECT telephone,qq,msn FROM ".TABLE_MEMBER_INFO." WHERE userid='$_userid'"));
					if($label=='product')
					{
						extract($db->get_one("SELECT title,price FROM ".TABLE_YP_PRODUCT." WHERE productid=$productid"));
					}
					elseif($label=='sales')
					{
						extract($db->get_one("SELECT title,price FROM ".TABLE_YP_SALES." WHERE productid=$productid"));
					}
					else
					{
						showmessage($LANG['illegal_parameters']);
					}
					require $H_url;
					$templateid = $tplType.'-order';
					include template('yp',$templateid);
				}
				else
				{
					showmessage($LANG['please_login'],$MODULE['member']['linkurl'].'login.php');
				}
			}
		break;

		case 'guestbook':
			if($dosubmit)
			{
				if(!$yourname) showmessage($LANG['name_not_empty'],'goback');
				if(!$telephone) showmessage($LANG['telephone_not_empty'],'goback');
				if(!$unit) showmessage($LANG['unit_not_empty'],'goback');
				if(!is_email($email)) showmessage($LANG['email_wrong'],'goback');
				if(!$content) showmessage($LANG['content_not_empty'],'goback');
				$title = strip_tags($title);
				$username = strip_tags($username);
				$content = htmlspecialchars($content);
				$item = intval($item);
				$db->query("INSERT INTO ".TABLE_YP_GUESTBOOK." (`companyid` , `itemid` ,`username` , `fax` , `telephone` , `qq` , `unit` , `msn` , `email` , `content` ,`label`, `addtime` ) VALUES ('$companyid', '$item', '$yourname', '$fax', '$telephone', '$qq', '$unit', '$msn', '$email', '$content', '$label', '$PHP_TIME')");
				showmessage($LANG['inquiry_submits_successfully'],$forward);
			}
			else
			{
				$companyid = isset($companyid) ? intval($companyid) : showmessage('参数错误');
				$product['companyid'] = $companyid;
				$item = isset($item) ? intval($item) : 0;
				require $H_url;
				include template('yp',$tplType.'-guestbook');
			}
		break;
	}
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET hits=(hits+1) WHERE companyid=$companyid");
}
else
{
	$datafile = 'userdata/'.$_userdir.'/'.$domainName.'/index.php';
	file_exists($datafile) ? include $datafile : exit('File not exists.');
}

?>