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
require_once("common.php");

if(!$_userid) message("请登录！","login.php?referer=pm.php");

$meta_title = "短消息";

$referer=$referer ? $referer : $PHP_REFERER;
$pagesize = $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 20;

switch($action){

case 'send'://发送信件

	if($submit)
	{
		if(empty($tousername))
		{
			message('请输入收件人！','goback');
		}
		if(empty($title))
		{
			message('请输入标题！','goback');
		}
		if(empty($content))
		{
			message('请输入内容');
		}
		
		if(!empty($inbox) && $inbox!=1)
		{
			message('参数错误！','goback'); 
		}
		if(strlen($title)>100 || strlen($content)>10000)
		{
			message('参数错误！','goback');
		}

		$title = dhtmlspecialchars($title);
		$content = str_safe($content);

		$send = $unsend ? 0 : 1;
		$inbox = $unsend ? 0 : $inbox;

		if(ereg(',',$tousername))
		{
			$tousername=explode(',',$tousername);
			if(count($tousername)>5)
			{
				message('同时最多可以发送给5个人！','goback');
			}
			foreach($tousername as $touser)
			{
				sendpm($touser,$title,$content,$send,$inbox);
				if($toemail)
				{
					sendusermail($touser,$title,$content);
				}
			}
			message('操作成功！',"pm.php?action=send");
		} 
		else 
		{
			if($toemail)
			{
				sendusermail($tousername,$title,$content);
			}
			if(sendpm($tousername,$title,$content,$send,$inbox))
			{
				message('信件发送成功！',"pm.php?action=send");
			} 
			else
			{
				message('抱歉，无法发送此信件！原因可能如下：<br/>1.该用户不存在;<br/>2.该用户拒收您的来信;','goback');
			}
		}
	} 
	else
	{
		$query="select friendname from ".TABLE_FRIEND." where username='$_username' and type=1 order by `orderid`,addtime desc limit 0,30";
		$result=$db->query($query);
		while($r=$db->fetch_array($result))
		{
			$lists[]=$r;
		}
	}

break;


case 'edit'://编辑信件

	if($submit)
	{
		if(empty($tousername))
		{
			message('请输入收件人！','goback');
		}
		if(empty($title))
		{
			message('请输入标题！','goback');
		}
		if(empty($content))
		{
			message('请输入内容','goback');
		}
		if(!empty($toemail) && $toemail!=1)
		{
			message('参数错误！','goback'); 
		}
		if(!empty($inbox) && $inbox!=1)
		{
			message('参数错误！','goback'); 
		}
		if(strlen($tousername)>20 || strlen($title)>100 || strlen($content)>10000)
		{
			message('参数错误！','goback');
		}
		$result=$db->query("select userid from ".TABLE_MEMBER." where username='$tousername'");
		if(!$db->num_rows($result))
		{
			message('对不起，您所发送的用户不存在！','goback');
		}

		$title = dhtmlspecialchars($title);
		$content = str_safe($content);

		$send=$unsend ? 0 : 1;
		$inbox=$unsend ? 0 :$inbox;

		$db->query("update ".TABLE_PM." set tousername='$tousername',send='$send',inbox='$inbox',title='$title',posttime='$timestamp',content='$content' where fromusername='$_username' and pmid='$pmid'");
		if($db->affected_rows()>0)
		{
			message('操作成功！','goback');
		}
		else
		{
			message('操作失败！请联系管理员！','goback');
		}

	} 
	else 
	{
		if(!ereg('^[0-9]+$',$pmid)) 
		{
			message('参数错误！','goback'); 
		}
		$query="select * from ".TABLE_PM." where pmid='$pmid' and fromusername='$_username' limit 1";
		$result=$db->query($query);
		if(!$db->num_rows($result))
		{
			message('信件不存在！','goback');
		}
		@extract($db->fetch_array($result));
		if(!$new && $fromusername!=$_username)
		{
			message('您无权编辑此信件！','goback');
		}
		$query="select friendname from ".TABLE_FRIEND." where username='$_username' and type=1 order by `orderid`,addtime desc limit 0,30";
		$result=$db->query($query);
		while($r=$db->fetch_array($result))
		{
			$lists[]=$r;
		}
	}

break;

case 'search':
break;

case 'view'://查看信件

	if(!ereg('^[0-9]+$',$pmid))
	{
		message('参数错误！',"goback"); 
	}
	$query="select * from ".TABLE_PM." where pmid='$pmid' limit 1";
	$result=$db->query($query);
	if(!$pm = $db->fetch_array($result)) 
	{
		message('信件不存在！','goback');
	}
	if($pm['tousername']!=$_username && $pm['fromusername']!=$_username && !$pm['system'])
	{
		message('你无权查看该信件！','goback');
	}
	$pm['posttime']=date("Y-m-d H:i:s",$pm['posttime']);
	if($pm['new'] && $pm['send'] && $pm['tousername'] == $_username)
	{
		$db->query("update ".TABLE_PM." set new=0 where pmid='$pmid'");
	}

break;

case 'delete'://删除收到的来信

	if(empty($pmid))
	{
		message('非法参数！请返回！','goback');
	}
	$pmids=is_array($pmid) ? implode(',',$pmid) : $pmid;

	$db->query("delete from ".TABLE_PM." where pmid in ($pmids) and tousername='$_username'");
	if($db->affected_rows())
	{
		message('短信删除成功！','goback');
	}
	else
	{
		message('操作失败，请返回！','goback');
	}

break;


case 'deleted'://删除已经发送但对方未读的信件

	if(empty($pmid))
	{
		message('非法参数！请返回！','goback');
	}
	$pmids=is_array($pmid) ? implode(',',$pmid) : $pmid;

	$db->query("delete from ".TABLE_PM." where pmid in ($pmids) and new=1 and fromusername='$_username'");
	if($db->affected_rows())
	{
		message('短信删除成功！','goback');
	} 
	else 
	{
		message('操作失败，请返回！','goback');
	}

break;



case 'deleteoutbox'://从发件箱清除

	if(empty($pmid))
	{
		message('非法参数！请返回！','goback');
	}
	$pmids=is_array($pmid) ? implode(',',$pmid) : $pmid;

	$db->query("update ".TABLE_PM." set inbox=0 where pmid in ($pmids) and inbox=1 and fromusername='$_username'");
	if($db->affected_rows())
	{
		message('短信已经从发件箱清除！',$referer);
	} 
	else
	{
		message('操作失败，请返回！',$referer);
	}
	 
break;


case 'deletelist'://删除 好友/黑名单

	if(empty($username))
	{
		message('非法参数！请返回！','goback');
	}
	$usernames=is_array($username) ? implode(',',$username) : $username;
	$db->query("delete from ".TABLE_FRIEND." where friendname in ('$usernames') and username='$_username'");
	if($db->affected_rows())
	{
		message('删除成功！',$referer);
	} 
	else
	{
		message('操作失败，请返回！',$referer);
	}
	 
break;

case 'unsend'://取消发送

	if(empty($pmid))
	{
		message('非法参数！请返回！','goback');
	}
	$pmids=is_array($pmid) ? implode(',',$pmid) : $pmid;

	$db->query("update ".TABLE_PM." set send=0 where pmid in ($pmids) and new=1 and fromusername='$_username'");
	if($db->affected_rows())
	{
		message('已经取消发送，信件被转移到了草稿箱！',$referer);
	} 
	else
	{
		message('操作失败，请返回！',$referer);
	}
	 
break;

case 'torecycle'://扔到回收站

	if(empty($pmid))
	{
		message('非法参数！请返回！','goback');
	}
	$pmids=is_array($pmid) ? implode(',',$pmid) : $pmid;

	$db->query("update ".TABLE_PM." set recycle=1 where pmid in ($pmids) and tousername='$_username'");
	if($db->affected_rows())
	{
		message('短信已经转移到了垃圾箱！',$referer);
	} 
	else 
	{
		message('操作失败，请返回！',$referer);
	}
	 
break;


case 'unrecycle'://从回收站还原

	if(empty($pmid))
	{
		message('非法参数！请返回！','goback');
	}
	$pmids=is_array($pmid) ? implode(',',$pmid) : $pmid;

	$db->query("update ".TABLE_PM." set recycle=0 where pmid in ($pmids) and tousername='$_username'");
	if($db->affected_rows())
	{
		message('还原成功！',$referer);
	} 
	else 
	{
		message('操作失败，请返回！',$referer);
	}

break;


case 'tract'://信件追踪

	if($submit)
	{
		if(strlen($keyword)>50)
		{
			message('关键词不得超过50个字符！','goback'); 
		}
		$keyword=str_replace(' ','%',$keyword);
		$keyword=str_replace('*','%',$keyword);
		if($srchtype == 0)
		{
			$addquery=" and title like '%$keyword%' ";
		} 
		elseif($srchtype == 1)
		{
			$addquery=" and tousername like '%$keyword%' ";
		} 
		else 
		{
			$addquery=" and content like '%$keyword%' ";
		}
	}
	$page = intval($page) ? intval($page) : 1;
	$offset=($page-1)*$pagesize;  
	$query="select count(*) as num from ".TABLE_PM." where recycle=0 and send=1 and fromusername='$_username' $addquery";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r['num'];
	$url="?";
	$pages=phppages($number,$page,$pagesize,$url);
	$query="select * from ".TABLE_PM." where recycle=0 and send=1 and fromusername='$_username' $addquery order by new desc,pmid desc limit $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result))
	{
		while($r=$db->fetch_array($result))
		{
			$r['posttime']=date("Y-m-d H:i:s",$r['posttime']);
			$pms[]=$r;
		}
	}

break;


case 'draft'://草稿箱

	if($submit)
	{
		if(strlen($keyword)>50)
		{
			message('关键词不得超过50个字符！','goback'); 
		}
		$keyword=str_replace(' ','%',$keyword);
		$keyword=str_replace('*','%',$keyword);

		if($srchtype == 0)
		{
			$addquery=" and title like '%$keyword%' ";
		} 
		elseif($srchtype == 1)
		{
			$addquery=" and tousername like '%$keyword%' ";
		} 
		else 
		{
			$addquery=" and content like '%$keyword%' ";
		}
	}

	$page = intval($page) ? intval($page) : 1;
	$offset=($page-1)*$pagesize;  

	$query="select count(*) as num from ".TABLE_PM."  where recycle=0 and send=0 and fromusername='$_username' $addquery";

	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r['num'];
	$url="?";
	$pages=phppages($number,$page,$pagesize,$url);

	$query="select * from ".TABLE_PM." where recycle=0 and send=0 and fromusername='$_username' $addquery order by posttime desc limit $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r['posttime']=date("Y-m-d H:i:s",$r['posttime']);
			$pms[]=$r;
		}
	}

break;



case 'outbox'://发件箱

	if($submit)
	{
		if(strlen($keyword)>50)
		{
			message('关键词不得超过50个字符！','goback'); 
		}
		$keyword=str_replace(' ','%',$keyword);
		$keyword=str_replace('*','%',$keyword);

		if($srchtype == 0)
		{
			$addquery=" and title like '%$keyword%' ";
		} 
		elseif($srchtype == 1)
		{
			$addquery=" and tousername like '%$keyword%' ";
		} 
		else 
		{
			$addquery=" and content like '%$keyword%' ";
		}
	}

	$page = intval($page) ? intval($page) : 1;
	$offset=($page-1)*$pagesize;  

	$query="select count(*) as num from ".TABLE_PM." where recycle=0 and inbox=1 and fromusername='$_username' $addquery";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r['num'];
	$url="?";
	$pages=phppages($number,$page,$pagesize,$url);

	$query="select * from ".TABLE_PM." where recycle=0 and inbox=1 and fromusername='$_username' $addquery order by new desc,posttime desc limit $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r['posttime']=date("Y-m-d H:i:s",$r['posttime']);
			$pms[]=$r;
		}
	}

break;

case 'recycle'://垃圾箱

	if($submit)
	{
		if(strlen($keyword)>50)
		{
			message('关键词不得超过50个字符！','goback'); 
		}
		$keyword=str_replace(' ','%',$keyword);
		$keyword=str_replace('*','%',$keyword);
		if($srchtype == 0)
		{
			$addquery=" and title like '%$keyword%' ";
		} 
		elseif($srchtype == 1)
		{
			$addquery=" and fromusername like '%$keyword%' ";
		} 
		else 
		{
			$addquery=" and content like '%$keyword%' ";
		}
	}

	$page = intval($page) ? intval($page) : 1;
	$offset=($page-1)*$pagesize;  

	$query="select count(*) as num from ".TABLE_PM." where recycle=1 and send=1 and tousername='$_username' $addquery ";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r['num'];
	$url="?";
	$pages=phppages($number,$page,$pagesize,$url);

	$query="select * from ".TABLE_PM." where recycle=1 and send=1 and tousername='$_username' $addquery order by new desc,posttime desc limit $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r['posttime']=date("Y-m-d H:i:s",$r['posttime']);
			$pms[]=$r;
		}
	}

break;


//////////////////////////////////////////////


case 'updatelistorder'://更新好友排序

	if(empty($orderid) || !is_array($orderid))
	{
		message('非法参数！请返回！');
	}

	foreach($orderid as $key=>$val)
	{
		$db->query("update ".TABLE_FRIEND." SET `orderid`='$val' WHERE friendname='$key' and username='$_username'");
	}

	message('操作成功！',$referer);

break;

case 'addlist'://添加 好友/黑名单

	if(empty($username))
	{
		message('请输入用户名！','goback');
	}
	$username=trim($username);
	if($username == $_username)
	{
		message('你不能添加自己！','goback');
	}
	if(strlen($username)>20)
	{
		message('参数错误！','goback');
	}
	$result=$db->query("select username from ".TABLE_MEMBER." where username='$username'");
	if($db->num_rows($result))
	{
		$r=$db->fetch_array($result);
		$friendname=$r[username];
	}
	else
	{
		message('对不起，您所添加的用户不存在！',$referer);
	}
	$result=$db->query("select friendname from ".TABLE_FRIEND." where friendname='$friendname' and username='$_username' ");
	if($db->num_rows($result)) 
	{
		message('对不起，您已经在你的通讯录或者黑名单中添加过此用户了！',$referer);
	}

	$db->query("insert into ".TABLE_FRIEND."(username,friendname,addtime,type) values('$_username','$friendname','$timestamp','$type')");
	if($db->affected_rows())
	{
		message('添加成功！',$referer);
	}
	else
	{
		message('添加失败！请联系管理员！',$referer);
	}

break;

case 'addresslist':// 通讯录（好友列表）

	$page = intval($page) ? intval($page) : 1;
	$offset=($page-1)*$pagesize;  

	$query="select count(*) as num from ".TABLE_FRIEND." where username='$_username' and type=1 ";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r['num'];
	$url="?";
	$pages=phppages($number,$page,$pagesize,$url);

	$query="select f.*,m.email from ".TABLE_FRIEND." f,".TABLE_MEMBER." m where m.username=f.friendname and f.username='$_username' and type=1 order by `orderid`,addtime desc limit $offset,$pagesize";//and m.showemail=1
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r['addtime']=date("Y-m-d",$r['addtime']);
			$lists[]=$r;
		}
	}

break;


case 'blacklist'://黑名单

	$pagesize=100;
	$page = intval($page) ? intval($page) : 1;
	$offset=($page-1)*$pagesize;  
	$query="select count(*) as num from ".TABLE_FRIEND." where username='$_username' and type=0 ";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r['num'];
	$url="?";
	$pages=phppages($number,$page,$pagesize,$url);

	$query="select * from ".TABLE_FRIEND." where username='$_username' and type=0 order by  addtime desc limit $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r['addtime']=date("Y-m-d",$r['addtime']);
			$lists[]=$r;
		}
	}

break;

//////////////////////////////////////////////

default://收件箱

	$query="select * from ".TABLE_PM." where system=1 and recycle=0 and send=1 order by pmid desc limit 0,3";
	$result=$db->query($query,"CACHE");
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r['posttime']=date("Y-m-d H:i:s",$r['posttime']);
			$syss[]=$r;
		}
	}

	if($fromusername)
	{
		$addquery=" and fromusername='".$fromusername."'";
	}
	if($submit)
	{
		if(strlen($keyword)>50)
		{
			message('关键词不得超过50个字符！','goback'); 
		}
		$keyword=str_replace(' ','%',$keyword);
		$keyword=str_replace('*','%',$keyword);

		if($srchtype == 0)
		{
			$addquery=" and title like '%$keyword%' ";
		} 
		elseif($srchtype == 1)
		{
			$addquery=" and fromusername like '%$keyword%' ";
		}
		else
		{
			$addquery=" and content like '%$keyword%' ";
		}
	}

	$page = intval($page) ? intval($page) : 1;
	$offset=($page-1)*$pagesize;  

	$query="select count(*) as num from ".TABLE_PM." where recycle=0 and send=1 and tousername='$_username' $addquery";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r['num'];
	$url="?";
	$pages=phppages($number,$page,$pagesize,$url);

	$query="select * from ".TABLE_PM." where recycle=0 and send=1 and tousername='$_username' $addquery order by new desc,posttime desc limit $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r['posttime']=date("Y-m-d H:i:s",$r['posttime']);
			$pms[]=$r;
		}
	}

}

@extract($db->get_one("SELECT COUNT(*) AS inbox_new_num FROM ".TABLE_PM." WHERE tousername='$_username' and new=1 and send=1 and recycle=0","CACHE"));//新信件数量

include template("member","pm");
?>