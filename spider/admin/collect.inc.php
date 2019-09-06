<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/include/tree.class.php';

$submenu = array
(
	array($LANG['add_job'],"?mod=".$mod."&file=jobmgr&action=add"),
	array($LANG['load_job'], "?mod=".$mod."&file=jobmgr&action=jobin"),
	array($LANG['site_manage'], "?mod=".$mod."&file=sitemgr&action=manage"),
	array($LANG['job_manage'], "?mod=".$mod."&file=jobmgr&action=manage")
	);
$menu = adminmenu($LANG['spider_operation_manage'],$submenu);
$tree=new tree;
$action = $action ? $action : 'manage';
switch($action)
{
	case 'collecturl':
		include(PHPCMS_ROOT."/include/htmlframe.inc.php");
	 	loadMtir();
		if(empty($jobid))	showmessage($LANG['illegal_parameters']);
		require MOD_ROOT."/admin/mainspider.inc.php";
		$ms=new MainSpider();
		$ms->JobId=$jobid;	
		$ms->mod=$mod;
		$ms->Init();
		if(!isset($auto)&&$auto!=true) $auto=false;
		else if($auto==1) $auto=true;
		if(!isset($totalurlcount)) $totalurlcount=0;
		if(isset($singleurl))
		{
			$totalurlnorepeatcount = isset($totalurlnorepeatcount) ? $totalurlnorepeatcount : 0;
			$currenturl=$ms->SpiderAllUrlById($currenturlid,$auto,$totalurlcount,$totalurlnorepeatcount);
			include admintpl('single_url');
		}	
		else 	
		include admintpl('collect_url');
		break;
	case 'outcontent':
		
		$CATEGORY = cache_read('categorys_'.$channelid.'.php');
		$CHA = cache_read('channel_'.$channelid.'.php');
		if(empty($jobid))	showmessage($LANG['illegal_parameters']);
		include (PHPCMS_ROOT."/".$mod."/rules/".$jobid.".php");
		include (PHPCMS_ROOT."/".$mod."/admin/job_parse.class.php");
		$CJob =new Job_Parse();
		$CJob->mod = $mod;
		$CJob->GetJobInfo($jobid);
		if($step==1)
		{			
			$js="onchange='window.location=\"?mod=$mod&file=collect&action=outcontent&jobid=$jobid&step=1&channelid=\"+this.value'";
			$channel_select = channel_select('article','channelid',$LANG['select_channel'],$channelid,$js);
			$cat_select = category_select('catid',$LANG['select_category'],0,'');
			include admintpl('content_out_step1');
			break;			
		}
		else if($step==2)
		{			
			if(isset($resetdefault) && $resetdefault==1) //用户导出设置 恢复默认
			{
				$db->query("Update ".TABLE_SPIDER_OUT." Set UserValue='' where CMS='article' or CMS='set'");				
			}		
			$title_table = channel_table('article',$channelid);
			$content_table = channel_table('article_data',$channelid);
			$option="";
			foreach ($rule['LabelName'] as $v){
				$option.="<option value=\"[".$LANG['label'].":".$v."]\">[".$LANG['label'].":".$v."]</option>";}
			$option.="<option value=\"[".$LANG['spider_page_url']."]\">[".$LANG['spider_page_url']."]</option>";
			$option.="<option value=\"[".$LANG['system_time']."]\">[".$LANG['system_time']."]</option>";
			$option.="<option value=\"[".$LANG['current_user']."]\">[".$LANG['current_user']."]</option>";
			$option.="<option value=\"[".$LANG['radom_num_0_1000']."]\">[".$LANG['radom_num_0_1000']."]</option>";
			$option.="<option value=\"[".$LANG['radom_time']."2006-06-16 01:30:30".$LANG['toto'].date("Y-m-d H:i:s",time())."]\">[".$LANG['radom_time']."2006-06-16 01:30:30".$LANG['toto'].date("Y-m-d H:i:s",time())."]</option>";
			$TYPE = cache_read('type_'.$channelid.'.php');
			$posid_select = type_select('art[posid]',$LANG['type'],0,'style="margin-left:20px;width:240px;" id="textUinposid" ');
			$showskin = showskin('art[skinid]',0,"style=\"margin-left:20px;width:240px;\" id=\"textUinskinid\"");
			$showtpl = showtpl('article','content','art[templateid]',0,"style=\"margin-left:20px;width:240px;\" id=\"textUintemplateid\"");
		
			$result = $db->query("Select * FROM ".TABLE_SPIDER_OUT." Where CMS='article_data' and hidden=0");
			$selectvalue = "<script language='javascript'>\r\n";//生成在最后调用的js,用于初始化各表单的值
			$article_data = array();
			while($r = $db->fetch_array($result))
			{
				$r['Label'] = str_replace("[".$LANG['auto_generate_label']."]",$option,$r['Label']);
				$r['Label'] = str_replace("[".$LANG['current_time']."]",date("Y-m-d H:i:s",time()),$r['Label']);
		 		$article_data[] = $r;		 		
		 		$itemvalue = ($r['UserValue']=="") ? $r['DefaultValue'] : $r['UserValue'];
		 		$selectvalue.= "document.getElementById('textUin".$r['Field']."').value='".str_replace("[".$LANG['current_time']."]",date("Y-m-d H:i:s",time()),$itemvalue)."';\r\n";
			}
			
			
			$result = $db->query("Select * FROM ".TABLE_SPIDER_OUT." Where CMS='article' and hidden=0");
			$out = array();
			while($r = $db->fetch_array($result))
			{
				$r['Label'] = str_replace("[".$LANG['auto_generate_label']."]",$option,$r['Label']);
				$r['Label'] = str_replace("[".$LANG['current_time']."]",date("Y-m-d H:i:s",time()),$r['Label']);
		 		$out[] = $r;
		 		
		 		$itemvalue = ($r['UserValue']=="") ? $r['DefaultValue'] : $r['UserValue'];
		 		$selectvalue.= "document.getElementById('textUin".$r['Field']."').value='".str_replace("[".$LANG['current_time']."]",date("Y-m-d H:i:s",time()),$itemvalue)."';\r\n";
			}		
			$result = $db->query("Select * FROM ".TABLE_SPIDER_OUT." Where CMS='article' and hidden=1");
			
			$outhidden = array();
			while($r = $db->fetch_array($result))
			{
				$r['Label'] = str_replace("[".$LANG['auto_generate_label']."]",$option,$r['Label']);
				$r['Label'] = str_replace("[".$LANG['current_time']."]",date("Y-m-d H:i:s",time()),$r['Label']);
				$r['Label'] = str_replace("[".$LANG['sub_type']."]",$posid_select,$r['Label']);
				$r['Label'] = str_replace("[".$LANG['style_list']."]",$showskin,$r['Label']);
				$r['Label'] = str_replace("[".$LANG['template_list']."]",$showtpl,$r['Label']);
				$r['Label'] = str_replace("[".$LANG['category_urlruleid']."]",$CATEGORY[$catid]['urlruleid'],$r['Label']);
		 		$outhidden[] = $r;		 		
		 		$itemvalue = ($r['UserValue']=="") ? $r['DefaultValue'] : $r['UserValue'];
		 		if($r['Field']!='urlruleid')
		 		$selectvalue.= "document.getElementById('textUin".$r['Field']."').value='".str_replace("[".$LANG['current_time']."]",date("Y-m-d H:i:s",time()),$itemvalue)."';\r\n";
			}
			//载入自定义字段 从文件中
			$Labeltpl="<input style=\"width:220px;height:20px;\" id=\"textUinlabelname\" name=\"art[userfieldlabelname]\" >".
					"<span style=\"position:absolute;margin:1px 1px 1px -6px\">".
					"<select style=\"margin-left:-202px;width:220px;\" id=\"uinSelectorlabelname\" onchange=\"document.getElementById('textUinlabelname').value=value;\">".
					"<option selected>---".$LANG['input_or_select_droplist']."---</option>".
					"[".$LANG['auto_generate_label']."]</select></span>";
					
			//载入自定义字段
			$fieldManual = array();
			$fieldnames = '';
			$_FIELDS = cache_read($CONFIG['tablepre']."article_".$channelid."_fields.php");
			if($_FIELDS)
			{			
				foreach($_FIELDS as $value)
				{
					$label = str_replace("labelname",$value['name'],$Labeltpl);
					$label = str_replace("[".$LANG['auto_generate_label']."]",$option,$label);

					$fieldManual[] = array('fieldname'=>$value['name'],'title'=>$value['title'],'label'=>$label);
					$fieldnames.= $value['name'].",";
					//$itemvalue.=$r['UserValue'];
		 			$selectvalue.="document.getElementById('textUin".$value['name']."').value='".$value['defaultvalue']."';\r\n";
				}
			}	
			//下面载入三项设置 发布时保存当前配置，倒序发布，发布成功后删除原采集内容
			$result=$db->query("Select * FROM ".TABLE_SPIDER_OUT." Where CMS='set'");
			while($r=$db->fetch_array($result))
			{
		 		$itemvalue = ($r['UserValue']=="") ? $r['DefaultValue'] : $r['UserValue'];
		 		$tu = ($itemvalue==1) ? "true" : "false";
		 		$selectvalue.="document.getElementById('".$r['Field']."').value='$itemvalue';\r\n";
		 		$selectvalue.="document.getElementById('".$r['Field']."').checked=".$tu.";\r\n";
			}
			$selectvalue.="</script>\r\n";		
		
			include admintpl('content_out_step2');
			break;
		}
	case 'spideradd':
		
		include_once(PHPCMS_ROOT.'/include/channel.func.php');
		include_once(PHPCMS_ROOT.'/include/urlrule.inc.php');
		$channelid = $art['channelid'];
		$CATEGORY = cache_read('categorys_'.$art['channelid'].'.php');
		$CHA = cache_read('channel_'.$art['channelid'].'.php');		
		@set_time_limit(0);
		if(empty($jobid))	showmessage($LANG['illegal_parameters']);
		$arttemplate = $art;
		if($submit)
		{
			if(!$art["catid"]||!is_numeric($art["catid"]))
			{
				showmessage($LANG['category_null_or_not_number_id']);
			}
			$CAT = cache_read('category_'.$art['catid'].'.php');
			if($CAT['child'] && !$CAT['enableadd'])
			{
				showmessage($LANG['category_not_allow_to_add_article']);
			}
			if(empty($art["title"]))
			{
				return FALSE;
			}
			if(empty($art["content"]))
			{
				return FALSE;
			}
			if($ckset['cksaveset']==1) //发布时自动保存当前设置
			{
				$art = new_addslashes($art,1);
				foreach($art as $k=>$v)
				{
					$db->query("UPDATE ".TABLE_SPIDER_OUT." SET UserValue='$v' WHERE CMS='article' and Field ='$k'");
				}
				if(!isset($ckset['ckdeletepre'])||$ckset['ckdeletepre']=="") $ckset['ckdeletepre']=0;
				if(!isset($ckset['ckbacksort'])||$ckset['ckbacksort']=="") $ckset['ckbacksort']=0;
				if(!isset($ckset['cksaveset'])||$ckset['cksaveset']=="") $ckset['cksaveset']=0;
				foreach($ckset as $k=>$v)
				{
					$db->query("UPDATE ".TABLE_SPIDER_OUT." SET UserValue='$v' WHERE CMS='set' and Field ='$k'");
				}
				$db->query("UPDATE ".TABLE_SPIDER_OUT." SET UserValue='0' WHERE CMS='set' and UserValue=''");
				//插入自定义字段 每次将旧的删除，新的插入
				$db->query("Delete From ".TABLE_SPIDER_OUT." WHERE CMS='FieldManual'");
				foreach ($arttemplate as $k=>$v)
				{
					if(strpos($k,"userfield")>-1)
					{
						$k=str_replace("userfield","",$k);					
						@$db->query("Insert Into ".TABLE_SPIDER_OUT."(CMS,Field,Description,UserValue) values('FieldManual','".addslashes($k)."','','".addslashes($v)."')");
					}			
				}		
			}
			$serial = 0;
			$art = $arttemplate;
			$title_table = channel_table('article',$art['channelid']);
			$content_table = channel_table('article_data',$art['channelid']);
			$MOD = cache_read('article_setting.php');//读取文章配置，采集无配置 无需考虑
			if($MOD['storage_mode'] > 1) require PHPCMS_ROOT.'/module/article/include/global.func.php';
			
			$query = "Select Id,JobId,PageUrl,Content,Spidered From ".TABLE_SPIDER_URLS." Where Spidered=1 and JobId=".$jobid." and IsOut!=1 order by Id";
			if($ckset['ckbacksort'] == 1) //倒序发布 
			   $query.="  DESC";
			else $query.=" ASC";
			$result = $db->query($query);
			while($r = $db->fetch_array($result))
			{ 
				$contentid=$r['Id'];
				//获取系统标签内容
				 preg_match_all("/【".$LANG['label'].":([^】]+)】:([\s\S]*?)【\/".$LANG['label']."】/",$r["Content"],$matchs);
   	   			 for($i=0; $i<count($matchs[1]); $i++)
   	   			 {
   	    			$labels[$matchs[1][$i]] = $matchs[2][$i]; //相当于php5里面 array_combine()
   	    		 }  
   	    		 //开始替换各个系统标签 	    		 
   	    		 foreach($arttemplate as $key=>$value)
   	    		 {
   	    		 	$value = preg_replace("/\[".$LANG['label'].":([\s\S]*?)\]/e","\$labels['\\1']",$value);
   	    		 	$value = str_replace("[".$LANG['spider_page_url']."]",$r["PageUrl"],$value);
   	    		 	$value = str_replace("[".$LANG['current_user']."]",$_username,$value);
   	    		 	
   	    		 	if(strpos($value,$LANG['radom_num'])>0)
   	    		 	{
   	    		 		preg_match("/\[".$LANG['radom_num']."(\d+)".$LANG['toto']."(\d+)\]/",$value,$matchs);
   	    		 		$rndnum = mt_rand($matchs[1],$matchs[2]);
   	    		 		$value = preg_replace("/\[".$LANG['radom_num']."(\d+)".$LANG['toto']."(\d+)\]/",$rndnum,$value);
   	    		 	}
   	    		 	if(strpos($value,$LANG['radom_time'])>0) //[随机时间:2006-07-16 01:30:30至2006-10-07 13:58:33]
   	    		 	{
   	    		 		preg_match("/\[".$LANG['radom_time']."(.*)".$LANG['toto']."(.*)\]/",$value,$matchs);
   	    		 		$startstamp = strtotime($matchs[1]);
   	    		 		$endstamp = strtotime($matchs[2]);
   	    		 		$rndnum = mt_rand($startstamp,$endstamp);
   	    		 		$value = preg_replace("/\[".$LANG['radom_time']."(.*)".$LANG['toto']."(.*)\]/",$rndnum,$value);
   	    		 	}
   	    		 	if(strpos($value,$LANG['system_time']."]")>0)
   	    		 	{
   	    		 		$value = $PHP_TIME;
   	    		 	}
					$value = ($value==$LANG['null']) ? "" : $value;
   	    		  	$art[$key] = $value;
   	    		 }
   	    		 $artaddtime = $art['addtime'];
   	    		 if(!is_numeric($art['addtime']))
   	    		 	$art['addtime']=preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/i', $art['addtime']) ? strtotime($art['addtime']) : $PHP_TIME;
   	    		 if(!is_numeric($art['checktime']))
   	    		 	$art['checktime']=preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/i', $art['checktime']) ? strtotime($art['checktime']) : $PHP_TIME;
   	    		 if(!is_numeric($art['addtime']))
   	    		 	$art['edittime']=preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/i', $art['edittime']) ? strtotime($art['edittime']) : $PHP_TIME;
   	    		 $art = new_addslashes($art,1);  
   	    		 unset($labels);
   	    		 if($art['paginationtype']!=2)//不是手动分页的情况
   	    		 $art['content'] = str_replace("[next]","",$art['content']);
   	    		 
   	    		 //处理用户自定义字段
   	    		 $userfieldkeys = array_keys($arttemplate);
   	    		 $valuekeys = $valuevalues = "";
   	    		 foreach ($userfieldkeys as $value) 
   	    		 {
   	    		 	if(strpos($value,"userfield")>-1)
   	    		 	{
   	    		 		$valuekeys.=",".str_replace("userfield","",$value);
   	    		 		$valuevalues.=",'".$art[$value]."'";   	    		 		 		 		
   	    			 }
				}
				if($art['title']!="" && $art['content']!="")
				{
					$r = $db->get_one('SELECT title FROM '.$title_table." WHERE title='".$art['title']."' limit 0,1");
					if(!$r['title'])
					{
	   	    			$db->query("INSERT INTO ".$title_table."(catid,typeid,title,titleintact,subheading,introduce,keywords,author,copyfrom,paginationtype,maxcharperpage,hits,thumb,username,addtime,editor,edittime,checker,checktime,templateid,skinid,arrposid,status,ishtml,htmldir,prefix,urlruleid ".$valuekeys.") VALUES".
	   	    		 										"('".$art['catid']."','".$art['typeid']."','".$art['title']."','".$art['titleintact']."','".$art['subheading']."','".$art['introduce']."','".$art['keywords']."','".$art['author']."','".$art['copyfrom']."','".$art['paginationtype']."','".$art['maxcharperpage']."','".$art['hits']."','".$art['thumb']."','".$art['username']."','".$art['addtime']."','".$art['editor']."','".$art['edittime']."','".$art['checker']."','".$art['checktime']."','0','0','".$art['arrposid']."','".$art['status']."','".$art['ishtml']."','".$art['htmldir']."','".$art['prefix']."','".$art['urlruleid']."'".$valuevalues.")");
						 $articleid = $db->insert_id();	
						 
						 //生成URl规则
						 $art['ishtml'] = $art['ishtml'] ? 1 : 0;
						 $art['htmldir'] = $art['htmldir'] ? $art['htmldir'] : '';
						 $art['prefix'] = $art['prefix']? $art['prefix'] :'';
						 $ispage = $art['paginationtype'] ? 1 : 0;
						 $linkurl = item_url('url', $art['catid'], $art['ishtml'], $art['urlruleid'], $art['htmldir'], $art['prefix'], $articleid,$artaddtime,$ispage);
						 $db->query("UPDATE ".$title_table." SET linkurl='$linkurl' WHERE articleid=$articleid");

						 //文章数据存储模式
						if($MOD['storage_mode'] < 3) $db->query("INSERT INTO ".$content_table."(articleid,content) VALUES ('".$articleid."','".$art['content']."')");
						if($MOD['storage_mode'] > 1) txt_update($art['channelid'], $articleid, $art['content']);
						if($MOD['storage_mode'] == 3) $db->query("INSERT INTO ".$content_table."(articleid,content) VALUES ('".$articleid."','')");

						 unset($art);
						 $serial++;	
						 $db->query("UPDATE ".TABLE_SPIDER_URLS." Set IsOut=1 WHERE Id=".$contentid);	
					}	
				}	
			}
			if($ckset['ckdeletepre']==1) //删除原来数据
			{
				$query = "Delete From ".TABLE_SPIDER_URLS." Where Spidered=1 and JobId=".$jobid;
				$result = $db->query($query);				
			}
			showmessage($LANG['operate_complete_total_publish'].$serial.$LANG['articles_manage_it_in_articles_list'],"?mod=".$mod."&file=jobmgr&action=manage");			
		}
		break;
	case 'collectcontent':
		include(PHPCMS_ROOT."/include/htmlframe.inc.php");
	 	loadMtir();
		if(empty($jobid))	showmessage($LANG['illegal_parameters']);
		require MOD_ROOT."/admin/mainspider.inc.php";
		$ms = new MainSpider();
		$ms->JobId = $jobid;	
		$ms->mod = $mod;
		$ms->Init();
		$threadnumber = $ms->CJob->Job['ThreadNum']==0 ? 1 : $ms->CJob->Job['ThreadNum'];
		$timeout = $ms->CJob->Job['TimeOut']<0?90:$ms->CJob->Job['TimeOut'];
		@set_time_limit($timeout);
		
		//仅仅Spidered=0的限制不够，因为每次采集完成时Spidered的状态都会发生变化，需设置统一的标志
		$starttimestamp = time();
		$db->query("Update ".TABLE_SPIDER_URLS." SET StartTimeStamp=".$starttimestamp."  where Spidered=0 and JobId='".$jobid."'");
		$rowone = $db->get_one("SELECT count(Id) as allnum From ".TABLE_SPIDER_URLS." where StartTimeStamp='".$starttimestamp."'");
		$totalnum = $rowone['allnum'];
		$currentid = 0;
		$prestartnum = 0;
			if(!isset($currentthread)) $currentthread = 0;
			$step = ceil($totalnum / $threadnumber);
			$j = 0;
			for($i=1;$i<=$totalnum;$i++)
			{
				if($i%$step==0)
				{
					$j++;
					$currentid = ($i-$step);
					$fromArr[] = "?mod=$mod&file=collect&action=collectaction&jobid=$jobid&prestartnum=$currentid&currentthread=$j&currentid=$currentid&totalnum=".($step * $j)."&starttimestamp=$starttimestamp";
				}
			}
			if($totalnum % $threadnumber != 0)
			{		
				$currentid = $j*$step;
				$k = $j+1;
				$fromArr[] = "?mod=$mod&file=collect&action=collectaction&currentthread=$k&jobid=$jobid&prestartnum=$currentid&currentid=$currentid&totalnum=$totalnum&starttimestamp=$starttimestamp";
			}
			else $fromArr[]="";
		include admintpl('collect_content');
		$ms->Close();
		break;
		
	case 'collectaction':
		include(PHPCMS_ROOT."/include/htmlframe.inc.php");
	 	loadMtir();
		if(empty($jobid))	showmessage($LANG['illegal_parameters']);
		if(empty($starttimestamp))	showmessage($LANG['not_input_time_identify_parameter']);
		require MOD_ROOT."/admin/mainspider.inc.php";
		$ms=new MainSpider();
		$ms->JobId=$jobid;	
		$ms->mod=$mod;
		$ms->Init();
		$threadnumber = $ms->CJob->Job['ThreadNum'] ==0 ? 1 : $ms->CJob->Job['ThreadNum'];
		$threadsleep = $ms->CJob->Job['ThreadSleep'];
		$threadrequest = $ms->CJob->Job['ThreadRequest'] ==0 ? 1 : $ms->CJob->Job['ThreadRequest'];
		$timeout = $ms->CJob->Job['TimeOut'] ==0 ? 90 : $ms->CJob->Job['TimeOut'];
		@set_time_limit($timeout);
			if($totalnum > $currentid+$threadrequest) $limitSql = " limit $currentid,$threadrequest";
			else $limitSql = " limit $currentid,".($totalnum - $currentid);
			$db->query("UPDATE ".TABLE_SPIDER_JOB." SET UpdateOn=".time()." where JobId=".$jobid);
			$res=$db->query("Select Id,JobId,PageUrl From ".TABLE_SPIDER_URLS." where StartTimeStamp=".$starttimestamp." ".$limitSql);
			$nowid=$currentid;
			while($row = $db->fetch_array($res))
			{
				$ms->GetOneContent($row['Id'],$row['PageUrl']);
				$nowid++;
				if($threadsleep>0) sleep($threadsleep);
			}
			$ms->Close();
			$percent = ceil( (($nowid-$prestartnum)/($totalnum-$prestartnum)) * 100 );
			$width = 4*$percent;
			$return	 ="<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\"><tr><td style=\"width:400px;height:10px;border:1px solid #000000;\">";
 			$return.= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tr><td style=\"width:".$width."px;height:10px;background:#316ac5;\" id=\"processor\"></td>";
 			$return.="</tr></table></td><td style=\"font-size:9px;font-family:Arial;color:red;\"> &nbsp;&nbsp;".$percent."% Finished</td></tr></table>";
			if($nowid < $totalnum)
			{
				$surl="?mod=$mod&file=collect&action=collectaction&currentthread=$currentthread&jobid=$jobid&prestartnum=$prestartnum&totalnum=$totalnum&starttimestamp=$starttimestamp&currentid=".($currentid+$threadrequest);
				$return.= "<script language=\"javascript\">parent.GetThreadFormPage(".($currentthread-1).",'$surl');</script>";
				echo $return;
			}
			else
			{
				$return	 ="<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\"><tr><td style=\"width:400px;height:10px;border:1px solid #000000;\">";
 				$return.= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tr><td style=\"width:400px;height:10px;background:#316ac5;\" id=\"processor\"></td>";
 				$return.="</tr></table></td><td style=\"font-size:9px;font-family:Arial;color:red;\"> &nbsp;&nbsp;100%  Finished</td></tr></table>";
 				
 				$return.= "<script language=\"javascript\">parent.GetThreadFormPage(".($currentthread-1).",'');parent.ShowFinishedInfo();</script>";
				echo $return;
			}
		$ms->Close();
		break;
	case 'manage':
		
		$query="Select DISTINCT ".TABLE_SPIDER_URLS.".JobId as jid,".TABLE_SPIDER_JOB.".JobId,JobName From ".TABLE_SPIDER_URLS.",".TABLE_SPIDER_JOB;
		$query.=" Where ".TABLE_SPIDER_URLS.".JobId=".TABLE_SPIDER_JOB.".JobId";
		$result=$db->query($query);
		$selectJobContent="<select name=\"selectJobContent\"  onchange='window.location=\"?mod=spider&file=collect&action=manage";
			if(isset($sortby)) $selectJobContent.="&sortby=$sortby";
		$selectJobContent.="&jobid=\"+this.value'><option value=\"\">".$LANG['all_job']."</option>";
		$deleteJobContent="<select name=\"deleteJobContent\" id=\"deleteJobContent\">";
		while($r=$db->fetch_array($result))
		{
			$l="<option value=".$r['jid'];
			if(!empty($jobid)&&$jobid==$r['jid']) $l.=" selected ";
			$l.=">";
			$l.=$r['JobName']."</option>";
			$selectJobContent.= $l;
			$deleteJobContent.= $l;
		}
		$selectJobContent.= "</select>";
		$deleteJobContent.= "</select>";
		if(!isset($page)) $page=1;
		$page = intval($page)>0 ? $page : 1;
		$offset=($page-1)*$PHPCMS['pagesize'];
		$q="SELECT count(*) as num FROM ".TABLE_SPIDER_URLS;
		if(!empty($jobid)) $q.=" where JobId=".$jobid;
		$r = $db->get_one($q);
		$number = $r["num"];
		$pages = phppages($number,$page,$PHPCMS['pagesize']);
		if(empty($sortby)) $sortby="order by Id";
		else $sortby="order by $sortby";
			if(empty($desc))
			 $desc=1;
			if($desc % 2 == 1)
				$sortby.=" desc";
			else  $sortby.=" asc";
		$query="SELECT Id,".TABLE_SPIDER_URLS.".JobId,".TABLE_SPIDER_JOB.".JobId,Title,PageUrl,".TABLE_SPIDER_URLS.".CreateOn,Spidered,JobName,IsOut FROM ".TABLE_SPIDER_URLS.",".TABLE_SPIDER_JOB." where ".TABLE_SPIDER_URLS.".JobId=".TABLE_SPIDER_JOB.".JobId ";
		if(!empty($jobid)) $query.=" and ".TABLE_SPIDER_URLS.".JobId=".$jobid;		
		$query.=" ".$sortby." limit $offset,".$PHPCMS['pagesize'];
		$result = $db->query($query);
		$contents = array();
		while($r = $db->fetch_array($result))
		{
			$r['CreateOn'] = date("y-m-d H:i",$r['CreateOn']);
			$contents[] = $r;
		}
		include admintpl('content_list');
		break;
   case 'viewcontent':
   		
		if(empty($contentid))	showmessage($LANG['illegal_parameters']);
   	    extract($db->get_one("Select * From ".TABLE_SPIDER_URLS." where Id=".$contentid),EXTR_PREFIX_ALL,"content");
   	    if($content_Spidered==0)//需要重新进行下载的情况
   	    {
   	    	require MOD_ROOT."/admin/mainspider.inc.php";
			$ms=new MainSpider();
			$ms->JobId=$content_JobId;
			$ms->mod=$mod;
			$ms->Init();
			
			$ms->GetOneContent($contentid,$content_PageUrl);
			echo "<script>window.location.reload();</script>";
   	    }
   	    preg_match_all("/【".$LANG['label'].":([^】]+)】:([\s\S]*?)【\/".$LANG['label']."】/",$content_Content,$matchs);
   	    for($i=0;$i<count($matchs[1]);$i++)
   	    {
   	    	$labels[$matchs[1][$i]]=$matchs[2][$i]; //相当于php5里面 array_combine()
   	    }
   	    unset($matchs);
		include admintpl('content_view');
		break;
	case 'delete':
		if (is_array($contentid))
		{
			$contentids = implode(",",$contentid);
			$db->query("DELETE FROM ".TABLE_SPIDER_URLS." WHERE Id in ($contentids)");
			if($db->affected_rows()>0){
				showmessage($LANG['operation_success'],"?mod=".$mod."&file=".$file."&action=manage&jobid=".$jobid);
			}else{
				showmessage($LANG['operation_failure'],"?mod=".$mod."&file=".$file."&action=manage&jobid=".$jobid);
			}
		}
		else if(is_numeric($contentid))
		{
			$db->query("DELETE FROM ".TABLE_SPIDER_URLS." WHERE Id=$contentid");
			if($db->affected_rows()>0){
				showmessage($LANG['operation_success'],"?mod=".$mod."&file=".$file."&action=manage&jobid=".$jobid);
			}else{
				showmessage($LANG['operation_failure'],"?mod=".$mod."&file=".$file."&action=manage&jobid=".$jobid);
			}
		}
		break;
	case 'deletejobcontent':	
		if(empty($deleteJobContent)) showmessage($LANG['illegal_parameters']);
		else
		{
			$db->query("DELETE FROM ".TABLE_SPIDER_URLS." WHERE JobId=$deleteJobContent");
			if($db->affected_rows()>0){
				showmessage($LANG['operate_success_delete_job'].$db->affected_rows().$LANG['record'],"?mod=".$mod."&file=".$file."&action=manage");
			}else{
				showmessage($LANG['operation_failure'],"?mod=".$mod."&file=".$file."&action=manage");
			}
		}
		break;
}
?>