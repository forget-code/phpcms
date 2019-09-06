<?php
/*
*######################################
* PHPCMS v2.00 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array("审核新会员", "?mod=".$mod."&file=".$file."&action=check"),
	array("会员列表", "?mod=".$mod."&file=".$file."&action=manage"),
	array("添加会员", "?mod=".$mod."&file=".$file."&action=add"),
);

$menu = adminmenu("会员管理",$submenu);

$result=$db->query("select * from ".TABLE_USERGROUP." order by groupid desc");
if($db->num_rows($result)>0){
  while($group=$db->fetch_array($result)){
		$groups[$group['groupid']]=$group;
  }
}

$action=$action ? $action : 'manage';

switch($action){

case 'add':
    if($save)
	{
	    if(!is_username($username,2,30)) showmessage("用户名不符合规范！请返回！");
        if(strlen($password)<4 || strlen($password)>20) showmessage("密码不得少于4个字符超过20个字符！请返回！");
        if(!is_email($email)) showmessage("请输入有效的E-mail地址！请返回！");
        if(empty($question) || strlen($question)>50) showmessage("请输入密码提示问题！请返回！");
        if(empty($answer) || strlen($answer)>50) showmessage("请输入密码提示问题答案！请返回！");
        $gender = $gender==1 ? 1 : 0;
        $showemail = $showemail==1 ? 1 : 0;
        $byear = intval($byear);
		$byear = $byear==19 ? '0000' : $byear;
		$bmonth=intval($bmonth);
		$bday=intval($bday);

		$birthday = $byear."-".$bmonth."-".$bday;
		if(!is_date($birthday)) $birthday = "0000-00-00";

        if($msn && !is_email($msn)) showmessage("请输入有效的MSN地址！请返回！");
        if($qq && (!is_numeric($qq) || strlen($qq)>20 || strlen($qq)<5)){
              showmessage("请输入正确的QQ号！请返回！");
        }
        if($postid && (!is_numeric($postid) || strlen($postid)!=6)){
              showmessage("请输入正确的邮编！请返回！");
        }
        if(strlen($truename)>50 || strlen($telephone)>50 || strlen($address)>255 || strlen($homepage)>100){
              showmessage("真实姓名、电话、地址和主页都不要太长！请返回！");
        }

	    if(user_exists($username)) message("对不起，".$username."已经被别人注册了！","goback");

	    $question=dhtmlspecialchars($question);
	    $email=dhtmlspecialchars($email);
	    $msn=dhtmlspecialchars($msn);
	    $truename=dhtmlspecialchars($truename);
	    $telephone=dhtmlspecialchars($telephone);
	    $address=dhtmlspecialchars($address);
	    $homepage=dhtmlspecialchars($homepage);

		$password=md5($password);
		$answer=md5($answer);

		$r=$db->get_one("select * from ".TABLE_USERGROUP." where groupid=$groupid");
		@extract($r);

		$begindate = date("Y-m-d");
		$date->dayadd($defaultvalidday);
		$enddate = $defaultvalidday == -1 ? "0000-00-00" : $date->get_date();

        $db->query("insert into ".TABLE_MEMBER."(username,password,question,answer,email,groupid,chargetype,point,begindate,enddate,locked,regip,regtime) values('$username','$password','$question','$answer','$email','$groupid','$chargetype','$defaultpoint','$begindate','$enddate','$locked','$ip','$timestamp')");
        if($db->affected_rows()>0){
			$userid = $db->insert_id();
            $db->query("insert into ".TABLE_MEMBERINFO."(userid,truename,gender,birthday,idtype,idcard,province,city,industry,edulevel,occupation,income,telephone,mobile,address,postid,homepage,qq,msn,icq,skype,alipay,paypal) values ('$userid','$truename','$gender','$birthday','$idtype','$idcard','$province','$city','$industry','$edulevel','$occupation','$income','$telephone','$mobile','$address','$postid','$homepage','$qq','$msn','$icq','$skype','$alipay','$paypal')");
            showmessage('操作成功！',$referer);
        }
		else
		{
            showmessage('操作失败！请返回！');
        }
    }
	else
	{
		$begindate=date("Y-m-d",$timestamp);
		$groupid = showgroup('select','groupid','4');
		include admintpl('member_add');
    }
    break;

case 'edit':
    if($save){
		if(!is_email($email)) showmessage("请输入有效的邮件地址！请返回！");
		$gender = $gender==1 ? 1 : 0;
		$showemail = $showemail==1 ? 1 : 0;
        $byear = intval($byear);
		$byear = $byear==19 ? 0000 : $byear;
		$bmonth=intval($bmonth);
		$bday=intval($bday);

		$birthday = $byear."-".$bmonth."-".$bday;
		if(!is_date($birthday)) $birthday = "0000-00-00";

		if(!empty($msn) && ( strlen($msn)>50 || !ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$msn) )){
		   showmessage("请输入有效的MSN地址！请返回！");
		}
		if(!empty($qq) && (!is_numeric($qq) || strlen($qq)>20 || strlen($qq)<5)){
		   showmessage("请输入正确的QQ号！请返回！");
		}
		if(!empty($postid) && (!is_numeric($postid) || strlen($postid)!=6)){
		   showmessage("请输入正确的邮编！请返回！");
		}
		if(strlen($truename)>50 || strlen($telephone)>50 || strlen($address)>255 || strlen($homepage)>100){
		   showmessage("真实姓名、电话、地址和主页都不要太长！请返回！");
		}
		$question=dhtmlspecialchars($question);
		$email=dhtmlspecialchars($email);
		$msn=dhtmlspecialchars($msn);
		$truename=dhtmlspecialchars($truename);
		$telephone=dhtmlspecialchars($telephone);
		$address=dhtmlspecialchars($address);
		$homepage=dhtmlspecialchars($homepage);

		$addquery = $password ? "password='".md5($password)."'," : "";
		$addquery .= $answer ? "answer='".md5($answer)."'," : "";
            
		$db->query("update ".TABLE_MEMBER." set $addquery email='$email',groupid='$groupid',question='$question',point='$point',chargetype='$chargetype',begindate='$begindate',enddate='$enddate',locked='$locked' where userid='$userid'");
  	    $db->query("update ".TABLE_MEMBERINFO." set truename='$truename',gender='$gender',birthday='$birthday',idtype='$idtype',idcard='$idcard',province='$province',city='$city',industry='$industry',edulevel='$edulevel',occupation='$occupation',income='$income',telephone='$telephone',mobile='$mobile',address='$address',postid='$postid',homepage='$homepage',qq='$qq',msn='$msn',icq='$icq',skype='$skype',alipay='$alipay',paypal='$paypal',userface='$userface',facewidth='$facewidth',faceheight='$faceheight',sign='$sign' where userid=$userid");
		showmessage('操作成功！',$PHP_REFERER);
      }
	  else
	  {
           $r=$db->get_one("select * from ".TABLE_MEMBER." m,".TABLE_MEMBERINFO." i where m.userid=i.userid AND m.userid=$userid");
           @extract($r);

           $birthday = explode("-",$birthday);

           $byear = $birthday[0];
		   $bmonth = $birthday[1];
		   $bday = $birthday[2];
		   $groupid = showgroup('select','groupid',$groupid);
           include admintpl('member_edit');
      }
      break;

case 'check':
      $page = intval($page)>0 ? $page : 1;
      $offset=($page-1)*$_PHPCMS['pagesize'];
	  $regdate = intval($regdate);
	  $fromtime = 0;
      if($regdate) 
	  {
		  $fromtime = $timestamp - 86400*$regdate;
	  }
      $condition = "";
	  $condition .= $username ? " and m.username='$username'" : "";
	  $condition .= $email ? " and m.email='$email'" : "";
	  $condition .= $truename ? " and i.truename='$truename'" : "";
	  $condition .= $province ? " and i.province='$province'" : "";
	  $condition .= $qq ? " and i.qq='$qq'" : "";
	  $condition .= $msn ? " and i.msn='$msn'" : "";
	  $condition .= $icq ? " and i.icq='$icq'" : "";
	  $condition .= $skype ? " and i.skype='$skype'" : "";
	  $condition .= $industry ? " and i.industry='$industry'" : "";
	  $condition .= $edulevel ? " and i.edulevel='$edulevel'" : "";
	  $condition .= $income ? " and i.income='$income'" : "";
	  $condition .= $occupation ? " and i.occupation='$occupation'" : "";
	  $condition .= $fromtime ? " and m.regtime>=$fromtime" : "";
	  $condition .= $city ? " and i.city like '%$city%'" : "";
	  $condition .= $homepage ? " and i.homepage like '%$homepage%'" : "";
	  $condition .= $address ? " and i.address like '%$address%'" : "";

      $r = $db->get_one("select count(*) as num from ".TABLE_MEMBER." m,".TABLE_MEMBERINFO." i where m.userid=i.userid and m.groupid=3 $condition");
      $number=$r["num"];
      $pages = phppages($number,$page,$_PHPCMS['pagesize']);

      $result=$db->query("SELECT m.*,i.truename,i.gender,i.province,i.city FROM ".TABLE_MEMBER." m,".TABLE_MEMBERINFO." i WHERE m.userid=i.userid and m.groupid=3 $condition order by m.userid desc limit $offset,$_PHPCMS[pagesize]");
      while($r=$db->fetch_array($result)){
            $r[regtime] = $r[regtime] ? date("Y-m-d H:i:s",$r[regtime]) : '';
			$r[gender] = $r[gender]==1 ? "男" : "女";
            $members[]=$r;
      }
	  $groupids = showgroup("select","groupid",$groupid);
	  $result = $db->query("SELECT province FROM ".TABLE_PROVINCE." WHERE country='中华人民共和国' ORDER BY provinceid");
	  while($r = $db->fetch_array($result))
	  {
		  $provinces[] = $r['province'];
	  }
      include admintpl('member_check');
      break;

case 'manage':
      $page = intval($page)>0 ? $page : 1;
      $offset=($page-1)*$_PHPCMS['pagesize'];
      $frommoney = $frommoney ? intval($frommoney) : "";
      $tomoney = $tomoney ? intval($tomoney) : "";
	  $frompayment = $frompayment ? intval($frompayment) : "";
      $topayment = $topayment ? intval($topayment) : "";
      $frompoint = $frompoint ? intval($frompoint) : "";
      $topoint = $topoint ? intval($topoint) : "";
	  $fromcredit = $fromcredit ? intval($fromcredit) : "";
      $tocredit = $tocredit ? intval($tocredit) : "";

      $condition = "";
	  $condition .= $username ? " and m.username='$username'" : "";
	  $condition .= $groupid ? " and m.groupid='$groupid'" : "";
	  $condition .= $locked>-1 ? " and m.locked='$locked'" : "";
	  $condition .= $email ? " and m.email='$email'" : "";
	  $condition .= $truename ? " and i.truename='$truename'" : "";
	  $condition .= $province ? " and i.province='$province'" : "";
	  $condition .= $qq ? " and i.qq='$qq'" : "";
	  $condition .= $msn ? " and i.msn='$msn'" : "";
	  $condition .= $icq ? " and i.icq='$icq'" : "";
	  $condition .= $skype ? " and i.skype='$skype'" : "";
	  $condition .= $industry ? " and i.industry='$industry'" : "";
	  $condition .= $edulevel ? " and i.edulevel='$edulevel'" : "";
	  $condition .= $income ? " and i.income='$income'" : "";
	  $condition .= $occupation ? " and i.occupation='$occupation'" : "";
	  $condition .= $frommoney ? " and m.money>=$frommoney" : "";
	  $condition .= $tomoney ? " and m.money<=$tomoney" : "";
	  $condition .= $frompayment ? " and m.payment>=$frompayment" : "";
	  $condition .= $topayment ? " and m.payment<=$topayment" : "";
	  $condition .= $frompoint ? " and m.point>=$frompoint" : "";
	  $condition .= $topoint ? " and m.point<=$topoint" : "";
	  $condition .= $fromcredit ? " and m.credit>=$fromcredit" : "";
	  $condition .= $tocredit ? " and m.credit<=$tocredit" : "";

	  $condition .= $city ? " and i.city like '%$city%'" : "";
	  $condition .= $homepage ? " and i.homepage like '%$homepage%'" : "";
	  $condition .= $address ? " and i.address like '%$address%'" : "";

      $r = $db->get_one("select count(*) as num from ".TABLE_MEMBER." m,".TABLE_MEMBERINFO." i where m.userid=i.userid and m.groupid>1 $condition");
      $number=$r["num"];
      $pages = phppages($number,$page,$_PHPCMS['pagesize']);

      $result=$db->query("SELECT m.* FROM ".TABLE_MEMBER." m,".TABLE_MEMBERINFO." i WHERE m.userid=i.userid and m.groupid>1 $condition order by m.userid desc limit $offset,$_PHPCMS[pagesize]");
      while($r=$db->fetch_array($result)){
		    $r[groupname] = $groups[$r[groupid]][groupname];
            $r[lastlogintime] = $r[lastlogintime] ? date("Y-m-d H:i:s",$r[lastlogintime]) : '';
			if($r[enddate]=="0000-00-00") 
		    {
				$r[validdatenum] = "<font color='blue'>无限期</font>";
		    }
		    else
		    {
			    $r[validdatenum] = $date->get_diff($r[enddate],date("Y-m-d"));
			    $r[validdatenum] = $r[validdatenum] <= 0 ? "<font color='red'>".$r[validdatenum]."</font>天" : $r[validdatenum];
		    }
			$r[locked] = $r[locked] ? "<font color='red'>锁定</font>" : "正常";
            $members[]=$r;
      }
	  $groupids = showgroup("select","groupid",$groupid);
	  $result = $db->query("SELECT province FROM ".TABLE_PROVINCE." WHERE country='中华人民共和国' ORDER BY provinceid");
	  while($r = $db->fetch_array($result))
	  {
		  $provinces[] = $r['province'];
	  }
	  $groups = array();
	  $result = $db->query("SELECT groupid,groupname FROM ".TABLE_USERGROUP." WHERE groupid>3 ORDER BY groupid");
	  while($r = $db->fetch_array($result))
	  {
		  $groups[$r['groupid']] = $r['groupname'];
	  }
      include admintpl('member_manage');
      break;

case 'view':
	  require PHPCMS_ROOT."/class/ip.php";
	  $getip = new IpLocation;

	  $r=$db->get_one("SELECT * FROM ".TABLE_MEMBER." m, ".TABLE_MEMBERINFO." i WHERE m.userid=i.userid AND m.userid=$userid");
	  @extract($r);
	  @extract($groups[$groupid],EXTR_SKIP);

      $regiparea = $getip->getlocation($regip);
	  $regiparea = $regip ? " - ".$regiparea['country'] : "";
      $lastloginiparea = $getip->getlocation($regip);
	  $lastloginiparea = $lastloginip ? " - ".$lastloginiparea['country'] : "";

	  $chargetype = $chargetype==1 ? "有效期" : "扣点数";
	  $enableaddalways = $enableaddalways==1 ? "<font color='red'>是</font>" : "否";
	  $gender = $gender==1 ? "男" : "女";
	  $regtime = $regtime ? date("Y-m-d H:i:s",$regtime) : "";
	  $lastlogintime = $lastlogintime ? date("Y-m-d H:i:s",$lastlogintime) : '';
	  $begindate = $begindate > "0000-00-00" ? $begindate : "";
	  $enddate = $enddate > "0000-00-00" ? $enddate : "";
	  if($birthday > "0000-00-00")
	  {
		 $date->set_date($birthday);
		 $old = date("Y")-$date->get_year();
	  }
	  $locked = $locked ? "<font color='red'>已被锁定</font>" : "正常";
	  include admintpl('member_view');
	  break;

case 'note':
	if($save)
	{
        $db->query("UPDATE ".TABLE_MEMBER." SET note='$note' WHERE userid='$userid'");
		showmessage('操作成功！',$PHP_REFERER);
    }
	else
	{
		$r=$db->get_one("SELECT username,note FROM ".TABLE_MEMBER." WHERE userid='$userid'");
		@extract($r);
		include admintpl('member_note');
	}
	break;


case 'password':
      if($submit){
            if(strlen($password)<6 || strlen($password)>32){
                 showmessage("密码不能为空且不得少于6个字符或超过32个字符！请返回！");
            }
	    $badwords=array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#');
	    foreach($badwords as $value){
		     if(strpos($password,$value)!==false){ 
			showmessage('密码中不得包含非法字符！请返回！'); 
		     }
	    }
            if($password=="" || $oldpassword==""){
                 showmessage('请输入密码!请返回!',$referer);
            }
            $oldpassword=md5($oldpassword);
            $query="select * from ".TABLE_MEMBER." where username='$_SESSION[phpcms_username]' and password='$oldpassword'";
            $result=$db->query($query);
            if($db->num_rows($result)==0){
               showmessage('原密码错误！',$referer);
            }
            $password=md5($password);
            $query="update ".TABLE_MEMBER." set password='$password' where username='$_SESSION[phpcms_username]'";
            $db->query($query);
            if($db->affected_rows()>0){
                  showmessage('操作成功！',$referer);
            }else{
                  showmessage('操作失败！请返回！');
            }
      }else{
            include admintpl('member_password');
      }
      break;

case 'pass':
      if(empty($userid)){
         showmessage('非法参数！请返回！');
      }
      $userids=is_array($userid) ? implode(',',$userid) : $userid;
	  $r=$db->get_one("select * from ".TABLE_USERGROUP." where groupid=4");
	  @extract($r);
	  $begindate = date("Y-m-d");
	  $date->dayadd($defaultvalidday);
	  $enddate = $defaultvalidday == -1 ? "0000-00-00" : $date->get_date();
      $db->query("UPDATE ".TABLE_MEMBER." SET groupid=4,chargetype=$chargetype,point=$defaultpoint,begindate='$begindate',enddate='$enddate' WHERE userid IN ($userids)");
      if($db->affected_rows()>0){
            showmessage('操作成功！',$PHP_REFERER);
      }else{
            showmessage('操作失败！请返回！');
      }
      break;

case 'passall':

      $result=$db->query("select * from ".TABLE_USERGROUP." where groupid='$groupid'");
      @extract($db->fetch_array($result));
      $db->query("UPDATE ".TABLE_MEMBER." SET groupid=$groupid,chargetype=$chargetype,point=$defaultpoint,validdate=$defaultvaliddate,begindate=$timestamp WHERE groupid=3");
      if($db->affected_rows()>0){
            showmessage('操作成功！',$PHP_REFERER);
      }else{
            showmessage('操作失败！请返回！');
      }
      break;

case 'lock':
      if(empty($userid)){
         showmessage('非法参数！请返回！');
      }
      $userids=is_array($userid) ? implode(',',$userid) : $userid;
      $db->query("UPDATE ".TABLE_MEMBER." SET locked=$val WHERE userid IN ($userids)");
      if($db->affected_rows()>0){
            showmessage('操作成功！',$PHP_REFERER);
      }else{
            showmessage('操作失败！请返回！');
      }
      break;

case 'user_exists':
	if(user_exists($username))
	{
	    showmessage('该用户名已经存在！');
	}
	else
	{
	    showmessage('该用户名不存在！');
	}
	break;

case 'delete':
      if(empty($userid)){
         showmessage('非法参数！请返回！');
      }
      $userids=is_array($userid) ? implode(',',$userid) : $userid;
      $db->query("DELETE FROM ".TABLE_MEMBER." WHERE userid IN ($userids)");
      if($db->affected_rows()>0){
            showmessage('操作成功！',$referer);
      }else{
            showmessage('操作失败！请返回！');
      }
      break;

case 'deleteallnopass':
      $db->query("DELETE FROM ".TABLE_MEMBER." WHERE groupid=3");
      if($db->affected_rows()>0){
            showmessage('操作成功！',$referer);
      }else{
            showmessage('操作失败！请返回！');
      }
      break;
}
?>
