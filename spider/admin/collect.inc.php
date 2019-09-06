<?php
set_time_limit(0);
defined('IN_PHPCMS') or exit('Access Denied');
if(!strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),'MSIE')) showmessage('对不起，目前采集程序只能支持IE浏览器，请换用IE浏览器浏览！');
require PHPCMS_ROOT . '/include/tree.class.php';
if(!$forward) $forward = HTTP_REFERER;
$submenu = array
(
    array($LANG['add_job'], "?mod=" . $mod . "&file=jobmgr&action=add"),
    array("<font color=red>" .$LANG['load_job']. "</font>", "?mod=" . $mod . "&file=jobmgr&action=jobin"),
    array("<font color=red>" .$LANG['site_manage']. "</font>", "?mod=" . $mod . "&file=sitemgr&action=manage"),
    array("<font color=red>" .$LANG['job_manage']. "</font>", "?mod=" . $mod . "&file=jobmgr&action=manage")
    );

$menu = adminmenu($LANG['spider_operation_manage'], $submenu);
$tree = new tree;
$action = $action ? $action : 'manage';
switch ($action)
{
    case 'collecturl':
        include(MOD_ROOT . "/include/htmlframe.inc.php");
        loadMtir();
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        require MOD_ROOT . "/admin/mainspider.inc.php";
        $ms = new MainSpider();
        $ms->JobId = $jobid;
        $ms->mod = $mod;
        $ms->Init();
        if (!isset($auto) && $auto != true) $auto = false;
        else if ($auto == 1) $auto = true;
        if (!isset($totalurlcount)) $totalurlcount = 0;
        if (isset($singleurl))
        {
            $totalurlnorepeatcount = isset($totalurlnorepeatcount) ? $totalurlnorepeatcount : 0;
            $currenturl = $ms->SpiderAllUrlById($currenturlid, $auto, $totalurlcount, $totalurlnorepeatcount);
            include admin_tpl('single_url');
        }
        else
            include admin_tpl('collect_url');
        break;
    case 'outcontent':
        @set_time_limit(0);
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        include (PHPCMS_ROOT . "/" . $mod . "/rules/" . $jobid . ".php");
        include (PHPCMS_ROOT . "/" . $mod . "/admin/job_parse.class.php");
        $CJob = new Job_Parse();
        $CJob->mod = $mod;
        $CJob->GetJobInfo($jobid);
        if ($step)
        {
            $option = "";
            $options = array();
            $options[''] = "请选择....";
            foreach ($rule['LabelName'] as $v)
            {
                $options[] = "[" . $LANG['label'] . ":" . $v . "]";
            } 
            $options['spider_page_url'] = "[" . $LANG['spider_page_url'] . "]";
            $options['system_time'] = "[" . $LANG['system_time'] . "]";
            $options['current_user'] = "[" . $LANG['current_user'] . "]";
            $options['radom_num_0_1000'] = "[" . $LANG['radom_num_0_1000'] . "]";
            $options['spider_page_url'] = "[" . $LANG['spider_page_url'] . "]";
            $options['radom_time'] = "[" . $LANG['radom_time'] . "2006-06-16 01:30:30" . $LANG['toto'] . date("Y-m-d H:i:s") . "]";
            $options['auto_thumb'] = "[" . $LANG['auto_thumb'] . "]";
            $options['thumb'] = "[缩略图]";
            $options['auto_keywords'] = "[" . $LANG['auto_keywords'] . "]";
            $options['auto_description'] = "[" . $LANG['auto_description'] . "]";
            $options['auto_thumbposids'] = "[" . $LANG['auto_thumbposids'] . "]";
            $options['auto_allposids'] = "[" . $LANG['auto_allposids'] . "]";
            $options['auto_status99'] = "[" . $LANG['auto_status99'] . "]";
            $options['auto_status2'] = "[" . $LANG['auto_status2'] . "]";
            $options['auto_status3'] = "[" . $LANG['auto_status3'] . "]";
            foreach ($options as $v)
            {
                $option .= "<option value=\"" . $v . "\">" . $v . "</option>";
            } 

            $r = $db->get_one("select * from " . TABLE_SPIDER_JOB . " where JobId='$jobid'");
            @extract(new_htmlspecialchars($r), EXTR_PREFIX_ALL, "job");
            $dbFields = array();
            $job_CatId = empty($_POST['job']['CatId'])?$job_CatId:$_POST['job']['CatId']; 

            $pid = $CATEGORY[$job_CatId]['parentid'];
            $job_CatName ='';
			while ($pid)
            {
                $parentCatPath[] = $CATEGORY[$pid];
                $pid = $CATEGORY[$pid]['parentid'];
            } 
            krsort($parentCatPath);
            foreach($parentCatPath as $cat)
            {
                $job_CatName .= $cat['catname'] . '>';
            }
            $job_CatName .= $CATEGORY[$job_CatId]['catname']; 

            $modelid = $CATEGORY[$job_CatId]['modelid'];
            $modelname = $MODEL[$modelid]['name'];
            $dbFields = include_once(PHPCMS_ROOT . '/data/cache_model/' . $modelid . '_fields.inc.php');
            include admin_tpl('content_out_step2');
            break;
        } 
    case 'spideradd':
        if (empty($jobid))showmessage($LANG['illegal_parameters']); 

        $job_CatId = $publish["catid"];
        $pid = $CATEGORY[$job_CatId]['parentid'];
        while ($pid)
        {
            $parentCatPath[] = $CATEGORY[$pid];
            $pid = $CATEGORY[$pid]['parentid'];
        } 
        krsort($parentCatPath);
        foreach($parentCatPath as $cat)
        {
            $job_CatName .= $cat['catname'] . '>';
        } 
        $job_CatName .= $CATEGORY[$job_CatId]['catname'];
        $r = $db->get_one("select JobName from " . TABLE_SPIDER_JOB . " where JobId='$jobid'");
        $JobName = $r['JobName'];
 
		if ($submit)
        {
            if (!$publish["catid"] || !is_numeric($publish["catid"]))
            {
                showmessage($LANG['category_null_or_not_number_id']);
            } 
            $maincontent = 'content';
            foreach($publish as $key => $value)
            {
                if ($value == '[标签:内容]')$maincontent = $key;
            } 

            if (empty($publish["title"]) || empty($publish[$maincontent]))
            {
                showmessage($LANG['title_or_content_null']);
            } 

            $commonPublish = $publish;
            $tablename = '';
            foreach($CATEGORY as $row)
            {
                if ($row['catid'] == $publish['catid'])
                {
                    $modelid = $row['modelid'];
                    $tablename = $MODEL[$row['modelid']]['tablename'];
                    break;
                } 
            } 
            if ($tablename != '')
            {
                $model_table = DB_PRE . "c_" . $tablename;
                $system_table = DB_PRE . "content";
            } 

            $modelFields = include_once(PHPCMS_ROOT . '/data/cache_model/' . $modelid . '_fields.inc.php'); 

            if ($publish['posids'])
            { 

                $posidsAll = array();
                $posidsRow = $db->get_one('SELECT max(posid) as max FROM ' . DB_PRE . 'position');
                for($i = 1;$i < $posidsRow['max'];$i++)
                {
                    $posidsAll[] = $i;
                }
            } 

            if (isset($publish['keywords']))
            {
                require_once MOD_ROOT . '/include/splitword.class.php';
                $sp = new SplitWord();
            } 

            $hits_radom_num_min = $hits_radom_num_max = $hits_day_radom_num_min = $hits_day_radom_num_max = 0;
            $hits_week_radom_num_min = $hits_week_radom_num_max = $hits_month_radom_num_min = $hits_month_radom_num_max = 0;
            if ($att['hits'])
            {
                preg_match("/\[" . $LANG['radom_num'] . "(\d+)" . $LANG['toto'] . "(\d+)\]/", $att['hits'], $matchs);
                $hits_radom_num_min = !is_numeric($att['hits'])?(int)$matchs[1]:(int)$att['hits'];
                $hits_radom_num_max = !is_numeric($att['hits'])?(int)$matchs[2]:(int)$att['hits'];
            } 
            if ($att['hits_day'])
            {
                preg_match("/\[" . $LANG['radom_num'] . "(\d+)" . $LANG['toto'] . "(\d+)\]/", $att['hits_day'], $matchs);
                $hits_day_radom_num_min = !is_numeric($att['hits_day'])?(int)$matchs[1]:(int)$att['hits_day'];
                $hits_day_radom_num_max = !is_numeric($att['hits_day'])?(int)$matchs[2]:(int)$att['hits_day'];
            } 
            if ($att['hits_week'])
            {
                preg_match("/\[" . $LANG['radom_num'] . "(\d+)" . $LANG['toto'] . "(\d+)\]/", $att['hits_week'], $matchs);
                $hits_week_radom_num_min = !is_numeric($att['hits_week'])?(int)$matchs[1]:(int)$att['hits_week'];
                $hits_week_radom_num_max = !is_numeric($att['hits_week'])?(int)$matchs[2]:(int)$att['hits_week'];
            } 
            if ($att['hits_month'] && !is_numeric($att['hits_month']))
            {
                preg_match("/\[" . $LANG['radom_num'] . "(\d+)" . $LANG['toto'] . "(\d+)\]/", $att['hits_month'], $matchs);
                $hits_month_radom_num_min = !is_numeric($att['hits_month'])?(int)$matchs[1]:(int)$att['hits_month'];
                $hits_month_radom_num_max = !is_numeric($att['hits_month'])?(int)$matchs[2]:(int)$att['hits_month'];
            } 

            foreach($commonPublish as $key => $value)
            {
                $value = str_replace("[" . $LANG['current_user'] . "]", $_userid, $value);
                if (strpos($value, $LANG['system_time'] . "]") > 0)
                {
                    $value = date('Y-m-d H:i:s');
                } 
                if (strpos($value, $LANG['auto_thumb'] . "]") > 0)
                {
                    $value = 'auto_thumb';
                } 
                if (strpos($value, $LANG['auto_keywords'] . "]") > 0)
                {
                    $value = 'auto_keywords';
                } 
                if (strpos($value, $LANG['auto_description'] . "]") > 0)
                {
                    $value = 'auto_description';
                } 
                if (strpos($value, $LANG['auto_thumbposids'] . "]") > 0)
                {
                    $value = "auto_thumbposids";
                } 
                if (strpos($value, $LANG['auto_allposids'] . "]") > 0)
                {
                    $value = $posidsAll;
                } 
                if (strpos($value, $LANG['auto_status99'] . "]") > 0)
                {
                    $value = '99';
                } 
                if (strpos($value, $LANG['auto_status2'] . "]") > 0)
                {
                    $value = '2';
                } 
                if (strpos($value, $LANG['auto_status3'] . "]") > 0)
                {
                    $value = '3';
                } 
                if (strpos($value, $LANG['radom_num']) > 0)
                {
                    preg_match("/\[" . $LANG['radom_num'] . "(\d+)" . $LANG['toto'] . "(\d+)\]/", $value, $matchs);
                    $radom_num_min = (int)$matchs[1];
                    $radom_num_max = (int)$matchs[2];
                    $rndnum = mt_rand($matchs[1], $matchs[2]);
                    $value = 'auto_radom_num';
                    unset($matchs);
                } 
                if (strpos($value, $LANG['radom_time']) > 0) // [随机时间:2006-07-16 01:30:30至2006-10-07 13:58:33]
                    {
                        preg_match("/\[" . $LANG['radom_time'] . "(.*)" . $LANG['toto'] . "(.*)\]/", $value, $matchs);
                    $radom_time_min = strtotime($matchs[1]);
                    $radom_time_max = strtotime($matchs[2]);
                    $value = 'auto_radom_time';
                    unset($matchs);
                } 
                $value = ($value == $LANG['null']) ? "" : $value;
                $commonPublish[$key] = $value;
            } 
            if (isset($publish['userid']) && $publish['userid'] == '') $commonPublish['userid'] = $_userid;
            if (isset($publish['username']) && $publish['username'] == '') $commonPublish['username'] = $_username;
            if (isset($publish['status']) && $publish['status'] == '') $commonPublish['status'] = 3; 

            require_once 'form.class.php';
            require_once 'admin/content.class.php';
            require_once 'attachment.class.php';
			
			$attachment = new attachment('phpcms', $commonPublish['catid']);
            $c = new content();
            $c->set_userid($commonPublish['userid']); 
           

            $MODEL[$modelid]['ishtml'] = $ckset['ishtml'];

            loadTitle($mod . '/rules/title'); 
            $Now = date('Y-m-d H:i:s');
            $serial = 0;
            $publimit = (int)$publimit;
            $publimit = $publimit > 0 ? $publimit :50;
            if (!isset($_REQUEST['autosubmit']))
            {
                $totalRecord = $db->get_one("Select count(Id) as count From " . TABLE_SPIDER_URLS . " Where Spidered=1 and JobId=" . $jobid . " and IsOut!=1 order by Id");
                $totalRecord = $totalRecord['count'];
            } 
            $query = "Select Id,JobId,PageUrl,Content,Spidered,Thumb From " . TABLE_SPIDER_URLS . " Where Spidered=1 and JobId=" . $jobid . " and IsOut!=1 order by Id";
            $query .= ($ckset['ckbacksort'] == 1) ?"  DESC" :" ASC";
            $query .= " limit $publimit ";
            $result = $db->query($query);
			if(!isset($_GET['publistedNum']))
			{
				$publistedNum =0;
			}
			else $publistedNum =$_GET['publistedNum'];
            while ($r = $db->fetch_array($result))
            {
                $serial++;
                $spiderCid = $r['Id'];
                $publish = array();
                $publish = $commonPublish; 

                preg_match_all("/【" . $LANG['label'] . ":([^】]+)】:([\s\S]*?)【\/" . $LANG['label'] . "】/", $r["Content"], $matchs);
                $count = count($matchs[1]);
                for($i = 0; $i < $count; $i++)
                {
                    $labels[$matchs[1][$i]] = $matchs[2][$i]; 
                } 

                foreach($publish as $key => $value)
                {
                    $value = preg_replace("/\[" . $LANG['label'] . ":([\s\S]*?)\]/e", "\$labels['\\1']", $value);
                    $value = str_replace("[" . $LANG['spider_page_url'] . "]", $r["PageUrl"], $value);
                    if (strpos($value, ":缩略图]") > 0)
                    {
                        $value = $r['Thumb'];
                    } 
                    if (strpos($value, 'radom_num') > 0)
                    {
                        $value = mt_rand($radom_num_min, $radom_num_max);
                    } 
                    if (strpos($value, 'radom_time') > 0)
                    {
                        $value = mt_rand($radom_time_min, $radom_time_max);
                    } 
                    $value = ($value == $LANG['null']) ? "" : $value;
                    $publish[$key] = $value;
                } 

                $pictureurls = array();
                $ext = $modelFields['thumb']['upload_allowext'];
                $matches = array();
                if (preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i", strtolower($publish[$maincontent]), $matches))
                {
                    $pictureurls = array();
                    $picindex = 0;
                    foreach($matches[3] as $matche)
                    {
                        $pictureurls[$picindex++] = $matche;
                    } 
                    $pictureurls = array_unique($pictureurls);
                } 
                unset($matches); 

                if (isset($modelFields['thumb']) && $publish['thumb'] == 'auto_thumb')
                {
                    if (!empty($pictureurls))
                    {
                        $publish['thumb'] = $pictureurls[min((int)$publish['thumb'], count($pictureurls)-1)];
			$publish['thumb'] = str_replace(PHPCMS_PATH.'uploadfile/', 'uploadfile/', $publish['thumb']);
                        if (isset($publish['posids']) && $publish['posids'] == 'auto_thumbposids')
                            $publish['posids'] = $posidsAll;
                    } 
                    else
                    {
                        $publish['thumb'] = '';
                        if (isset($publish['posids']) && $publish['posids'] == 'auto_thumbposids')$publish['posids'] = '';
                    } 
                } 
                else
                {
                    if (isset($publish['posids']) && $publish['posids'] == 'auto_thumbposids')$publish['posids'] = '';
                } 

                if ($r['Thumb'])
                {
                    $publish['thumb'] = $r['Thumb'];
                } 

                $inputtime = $publish['inputtime'];
                if (!is_numeric($publish['inputtime']))
                {
                    $publish['inputtime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/i', $publish['inputtime']) ? $publish['inputtime'] : $Now;
                } 
                else
                {
                    $publish['inputtime'] = date('Y-m-d H:i:s', $publish['inputtime']);
                } 
                if (!is_numeric($publish['updatetime']))
                {
                    $publish['updatetime'] = preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/i', $publish['updatetime']) ? $publish['updatetime'] : $Now;
                } 
                else
                {
                    $publish['updatetime'] = date('Y-m-d H:i:s', $publish['updatetime']);
                } 

                if (!is_numeric($publish['typeid']))
                {
                    $findtypeid = false;
                    foreach($TYPE as $typeid => $tmpType)
                    {
                        if ($tmpType['name'] == $publish['typeid'])
                        {
                            $publish['typeid'] = $typeid;
                            $findtypeid = true;
                            break;
                        } 
                    } 
                    if (!$findtypeid)unset($publish['typeid']);
                } 

                $keywords = array();
                if (isset($publish['keywords']) && $publish['keywords'] == 'auto_keywords')
                {
                    $publish['keywords'] = get_keywords($publish['title'], $publish[$maincontent], $M['keywordNumber']);
                } 

                if (isset($publish['description']) && $publish['description'] == 'auto_description')
                {
                    $publish['description'] = str_cut(trim(str_replace(array("\n", "\t", "\r", "[page]"), '', strip_tags($publish[$maincontent]))), $M['descriptionLength']);
                } 


                if ($publish['title'] != "" && $publish[$maincontent] != "")
                {
					if (!dataExists($publish['title']))
                    { 
						if(!$M['titleLength'])$M['titleLength']=80;
						$publish['title'] =str_cut($publish['title'],$M['titleLength'],'');

                        $info = array(); 

                        foreach($publish as $f => $v)
                        {
                            foreach($modelFields as $tmp)
                            {
                                if (empty($v)) continue;
                                if ($tmp['field'] == $f)
                                {
                                    $info[$f] = $v;
                                } 
                            } 
                        } 

                        switch ($modelFields[$maincontent]['formtype'])
                        {
                            case 'text':break;
                            case 'editor':break;
                            case 'textarea':break;
                            case 'downfiles':
							$tmparray = getLinkUrls($info[$maincontent],$r["PageUrl"]);
							$info[$maincontent] = '';
							if($tmparray)
							{
								foreach($tmparray as $p)
								$info[$maincontent] .= $p['title']."|".$p['url']."\n";
							}
							else $info[$maincontent] = '暂无下载地址';
							break;
                            case 'images':$info[$maincontent] = 1;
                                break; 
                        } 
                        $publish['prefix'] = $publish['prefix']? $publish['prefix'] :''; 
                        
                        $mod = "phpcms";
                        $info = new_addslashes($info);
						$contentid = $c->add($info);
                        if ($contentid)
                        { 
                            $publistedNum++;
							
                            if (!empty($pictureurls))
                            {
                                $field = $maincontent;
                                foreach($pictureurls as $url)
                                {
                                    $filename = basename($url);
                                    $filetype = filetype($url);
                                    $fileext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                                    $url = str_replace(substr(PHPCMS_PATH,1).'uploadfile/', '', $url);
                                    $sql = "insert into " . DB_PRE . "attachment (module,catid,contentid,field,filename,filepath,filetype,fileext,isimage,isthumb,userid,uploadtime,uploadip)values('phpcms','" . $info['catid'] . "','$contentid','$field','$filename','$url','$filetype','$fileext',1,0,'" . $info['userid'] . "','$Now','127.0.0.1')";
                                    $db->query($sql);
                                } 
                            }
							
                            if ($hits_radom_num_min || $hits_radom_num_max || $hits_day_radom_num_min || $hits_day_radom_num_max || $hits_week_radom_num_min || $hits_week_radom_num_max || $hits_month_radom_num_min || $hits_month_radom_num_max)
                            {
                                $hits = mt_rand($hits_radom_num_min, $hits_radom_num_max);
                                $hits_day = mt_rand($hits_day_radom_num_min, $hits_day_radom_num_min);
                                $hits_week = mt_rand($hits_week_radom_num_min, $hits_week_radom_num_max);
                                $hits_month = mt_rand($hits_month_radom_num_min, $hits_month_radom_num_max);
                                $db->query("UPDATE " . DB_PRE . "content_count Set hits='$hits',hits_day='$hits_day',hits_week='$hits_week',hits_month='$hits_month' WHERE contentid=" . $contentid);
                            } 
                            $mod = "spider";
                            $db->query("UPDATE " . TABLE_SPIDER_URLS . " Set IsOut=1 WHERE Id=" . $spiderCid); 
                            
                            dataCache();
                        } 
                    } 
                } 
				
                dataCache(true);
                unset($publish);
                ob_flush();
                flush();
            } 
            if ($ckset['ckdeletepre'] == 1) 
            {
                $query = "Delete From " . TABLE_SPIDER_URLS . " Where IsOut=1 and JobId=" . $jobid;
                $result = $db->query($query);
            } 
			
            $havefinished += $serial;
            if ($havefinished >= $totalRecord)
            {
                
				showmessage($LANG['operate_complete_total_publish'] .'成功'.$publistedNum.'/总计'. $totalRecord . $LANG['articles_manage_it_in_articles_list'], "?mod=" . $mod . "&file=jobmgr&action=manage");
            } 
            else
            {
                
				include admin_tpl('autosubmit');
            }
        } 
        break;
    case 'collectcontent':
        include(MOD_ROOT . "/include/htmlframe.inc.php");
        loadMtir();
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        require MOD_ROOT . "/admin/mainspider.inc.php";
        $ms = new MainSpider();
        $ms->JobId = $jobid;
        $ms->mod = $mod;
        $ms->Init();
        $threadnumber = $ms->CJob->Job['ThreadNum'] == 0 ? 1 : $ms->CJob->Job['ThreadNum'];
        $timeout = $ms->CJob->Job['TimeOut'] < 0?120:$ms->CJob->Job['TimeOut'];
        @set_time_limit($timeout); 
       
        $starttimestamp = time();
        $db->query("Update " . TABLE_SPIDER_URLS . " SET StartTimeStamp=" . $starttimestamp . "  where Spidered=0 and JobId='" . $jobid . "'");
        $rowone = $db->get_one("SELECT count(Id) as allnum From " . TABLE_SPIDER_URLS . " where StartTimeStamp='" . $starttimestamp . "'");
        $totalnum = $rowone['allnum'];
        $currentid = 0;
        $prestartnum = 0;
        if (!isset($currentthread)) $currentthread = 0;
        $step = ceil($totalnum / $threadnumber);
        $j = 0;
        for($i = 1;$i <= $totalnum;$i++)
        {
            if ($i % $step == 0)
            {
                $j++;
                $currentid = ($i - $step);
                $fromArr[] = "?mod=$mod&file=collect&action=collectaction&jobid=$jobid&prestartnum=$currentid&currentthread=$j&currentid=$currentid&totalnum=" . ($step * $j) . "&starttimestamp=$starttimestamp";
            } 
        } 
        if ($totalnum % $threadnumber != 0)
        {
            $currentid = $j * $step;
            $k = $j + 1;
            $fromArr[] = "?mod=$mod&file=collect&action=collectaction&currentthread=$k&jobid=$jobid&prestartnum=$currentid&currentid=$currentid&totalnum=$totalnum&starttimestamp=$starttimestamp";
        }
        else $fromArr[] = "?mod=$mod&file=collect&action=collectaction&jobid=$jobid&finished=yes";
        include admin_tpl('collect_content');
        $ms->Close();
        break;

    case 'collectaction':
        include(MOD_ROOT . "/include/htmlframe.inc.php");
        loadMtir();
		if($finished=='yes'){ echo "<script language=\"javascript\">parent.ShowFinishedInfo();</script>";die();}
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        if (empty($starttimestamp)) showmessage($LANG['not_input_time_identify_parameter']);
        require MOD_ROOT . "/admin/mainspider.inc.php";
        $ms = new MainSpider();
        $ms->JobId = $jobid;
        $ms->mod = $mod;
        $ms->Init();
        $threadnumber = $ms->CJob->Job['ThreadNum'] == 0 ? 1 : $ms->CJob->Job['ThreadNum'];
        $threadsleep = $ms->CJob->Job['ThreadSleep'];
        $threadrequest = $ms->CJob->Job['ThreadRequest'] == 0 ? 1 : $ms->CJob->Job['ThreadRequest'];
        $timeout = $ms->CJob->Job['TimeOut'] == 0 ? 120 : $ms->CJob->Job['TimeOut'];
        @set_time_limit($timeout);
        if ($totalnum > $currentid + $threadrequest) $limitSql = " limit $currentid,$threadrequest";
        else $limitSql = " limit $currentid," . ($totalnum - $currentid);
        $db->query("UPDATE " . TABLE_SPIDER_JOB . " SET UpdateOn=" . time() . " where JobId=" . $jobid);
        $res = $db->query("Select Id,JobId,PageUrl From " . TABLE_SPIDER_URLS . " where StartTimeStamp=" . $starttimestamp . " " . $limitSql);
        $nowid = $currentid;
        while ($row = $db->fetch_array($res))
        {
            $ms->GetOneContent($row['Id'], $row['PageUrl']);
            $nowid++;
            if ($threadsleep > 0) sleep($threadsleep);
        } 
        $ms->Close();
        $percent = ceil((($nowid - $prestartnum) / ($totalnum - $prestartnum)) * 100);
        $width = 4 * $percent;
        $return = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\"><tr><td style=\"width:400px;height:10px;border:1px solid #000000;\">";
        $return .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tr><td style=\"width:" . $width . "px;height:10px;background:#316ac5;\" id=\"processor\"></td>";
        $return .= "</tr></table></td><td style=\"font-size:9px;font-family:Arial;color:red;\"> &nbsp;&nbsp;" . $percent . "% Finished</td></tr></table>";
        if ($nowid < $totalnum)
        {
            $surl = "?mod=$mod&file=collect&action=collectaction&currentthread=$currentthread&jobid=$jobid&prestartnum=$prestartnum&totalnum=$totalnum&starttimestamp=$starttimestamp&currentid=" . ($currentid + $threadrequest);
            $return .= "<script language=\"javascript\">parent.GetThreadFormPage(" . ($currentthread-1) . ",'$surl');</script>";
            echo $return;
        } 
        else
        {
            $return = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\"><tr><td style=\"width:400px;height:10px;border:1px solid #000000;\">";
            $return .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tr><td style=\"width:400px;height:10px;background:#316ac5;\" id=\"processor\"></td>";
            $return .= "</tr></table></td><td style=\"font-size:9px;font-family:Arial;color:red;\"> &nbsp;&nbsp;100%  Finished</td></tr></table>";

            $return .= "<script language=\"javascript\">parent.GetThreadFormPage(" . ($currentthread-1) . ",'');parent.ShowFinishedInfo();</script>";
            echo $return;
        } 
        $ms->Close();
        break;
    case 'manage':

        $query = "Select DISTINCT " . TABLE_SPIDER_URLS . ".JobId as jid," . TABLE_SPIDER_JOB . ".JobId,JobName From " . TABLE_SPIDER_URLS . "," . TABLE_SPIDER_JOB;
        $query .= " Where " . TABLE_SPIDER_URLS . ".JobId=" . TABLE_SPIDER_JOB . ".JobId";
        $result = $db->query($query);
        $selectJobContent = "<select name=\"selectJobContent\"  onchange='window.location=\"?mod=spider&file=collect&action=manage";
        if (isset($sortby)) $selectJobContent .= "&sortby=$sortby";
        $selectJobContent .= "&jobid=\"+this.value'><option value=\"\">" . $LANG['all_job'] . "</option>";

        $deleteJobContent = "<select name=\"deleteJobContent\" id=\"deleteJobContent\">";
        while ($r = $db->fetch_array($result))
        {
            $l = "<option value=" . $r['jid'];
            if (!empty($jobid) && $jobid == $r['jid']) $l .= " selected ";
            $l .= ">";
            $l .= $r['JobName'] . "</option>";
            $selectJobContent .= $l;
            $deleteJobContent .= $l;
        } 
        $selectJobContent .= "</select>";
        $deleteJobContent .= "</select>";
        if (!isset($page)) $page = 1;
        $page = intval($page) > 0 ? $page : 1;
        $offset = ($page-1) * $PHPCMS['pagesize'];
        $q = "SELECT count(*) as num FROM " . TABLE_SPIDER_URLS;
        if (!empty($jobid)) $q .= " where JobId=" . $jobid;
        $r = $db->get_one($q);
        $number = $r["num"];
        $pages = pages($number, $page, $PHPCMS['pagesize']);
        if (empty($sortby)) $sortby = "order by Id";
        else $sortby = "order by $sortby";
        if (empty($desc)) $desc = 1;
        if ($desc % 2 == 1) $sortby .= " desc";
        else $sortby .= " asc";

		$query = "SELECT Id," . TABLE_SPIDER_URLS . ".SpiderOn," . TABLE_SPIDER_JOB . ".JobId,Title,PageUrl," . TABLE_SPIDER_URLS . ".CreateOn,Spidered,JobName,IsOut FROM " . TABLE_SPIDER_URLS . "," . TABLE_SPIDER_JOB . " where " . TABLE_SPIDER_URLS . ".JobId=" . TABLE_SPIDER_JOB . ".JobId ";
        if (!empty($jobid)) $query .= " and " . TABLE_SPIDER_URLS . ".JobId=" . $jobid;
        $query .= " " . $sortby . " limit $offset," . $PHPCMS['pagesize'];
        // pre($query);
        $result = $db->query($query);
        $contents = array();
        while ($r = $db->fetch_array($result))
        {
            $contents[] = $r;
        } 
        include admin_tpl('content_list');
        break;
    case 'viewcontent':

        if (empty($contentid)) showmessage($LANG['illegal_parameters']);
        extract($db->get_one("Select * From " . TABLE_SPIDER_URLS . " where Id=" . $contentid), EXTR_PREFIX_ALL, "content");
        if ($content_Spidered == 0)
        {
            require MOD_ROOT . "/admin/mainspider.inc.php";
            $ms = new MainSpider();
            $ms->JobId = $content_JobId;
            $ms->mod = $mod;
            $ms->Init();

            $ms->GetOneContent($contentid, $content_PageUrl);
            echo "<script>window.location.reload();</script>";
        } 
        preg_match_all("/【" . $LANG['label'] . ":([^】]+)】:([\s\S]*?)【\/" . $LANG['label'] . "】/", $content_Content, $matchs);
        for($i = 0;$i < count($matchs[1]);$i++)
        {
            $labels[$matchs[1][$i]] = $matchs[2][$i]; 
        } 
        unset($matchs);
        include admin_tpl('content_view');
        break;
    case 'Spidered':
    case 'IsOut':
		$status = (int)$status;
		if($status!=0 &&$status!=1 )$status=0; 
		if(empty($contentid)) showmessage('请选择要操作的对象！');
        if (is_array($contentid))
        {
            $contentids = implode(",", $contentid);
            $db->query("update " . TABLE_SPIDER_URLS . " set $action='$status' WHERE Id in ($contentids)");
            showmessage($LANG['operation_success']. $db->affected_rows() . $LANG['record'],$forward);
        } 
        else if (is_numeric($contentid))
        {
            $db->query("update " . TABLE_SPIDER_URLS . " set $action='$status' WHERE Id=$contentid");
            showmessage($LANG['operation_success']. $db->affected_rows() . $LANG['record'],"goback");
        } 
        break;
	case 'delete':
		if(empty($contentid)) showmessage('请选择要操作的对象！');
        if (is_array($contentid))
        {
            $contentids = implode(",", $contentid);
            $db->query("DELETE FROM " . TABLE_SPIDER_URLS . " WHERE Id in ($contentids)");
            showmessage($LANG['operation_success'].$db->affected_rows() . $LANG['record'], $forward);
        } 
        else if (is_numeric($contentid))
        {
            $db->query("DELETE FROM " . TABLE_SPIDER_URLS . " WHERE Id=$contentid");
            showmessage($LANG['operation_success'].$db->affected_rows() . $LANG['record'], "goback");
        }
        break;
    case 'deleteUrlcache':
        $caches = array();
		if(empty($contentid)) showmessage('请选择要操作的对象！');
        if (is_array($contentid))
        {
            $contentids = implode(",", $contentid);
            $query = "select PageUrl FROM " . TABLE_SPIDER_URLS . " WHERE Id in ($contentids)";
            $result = $db->query($query);
            while ($r = $db->fetch_array($result))
            {
                $caches[] = md5($r['PageUrl']);
            } 
        } 
        else if (is_numeric($contentid))
        {
            $tmp = $db->get_one("select PageUrl FROM " . TABLE_SPIDER_URLS . " WHERE Id=$contentid");
            if (!empty($tmp))
            {
                $caches[] = md5($tmp['PageUrl']);
            } 
        } 
        foreach($caches as $item)
        {
            deleteCache('url', $item);
        } 
        showmessage($LANG['operation_success'] . count($caches) . $LANG['record'], $forward);
        break;
    case 'deleteTitlecache':
        $caches = array();
		if(empty($contentid)) showmessage('请选择要操作的对象！');
        if (is_array($contentid))
        {
            $contentids = implode(",", $contentid);
            $query = "select Content FROM " . TABLE_SPIDER_URLS . " WHERE  Id in ($contentids) and Content!=''";
            $result = $db->query($query);
            $reg = "/【" . $LANG['label'] . ":标题】:([\s\S]*?)【\/" . $LANG['label'] . "】/";
            while ($r = $db->fetch_array($result))
            {
                $matchs = array();
                preg_match($reg, $r["Content"], $matchs);
                if (!empty($matchs[1]))$caches[] = md5($matchs[1]);
            } 
        } 
        else if (is_numeric($contentid))
        {
            $tmp = $db->get_one("select PageUrl FROM " . TABLE_SPIDER_URLS . " WHERE Id=$contentid");
            if (!empty($tmp))
            {
                $caches[] = md5($tmp['PageUrl']);
            } 
        } 
        foreach($caches as $item)
        {
            deleteCache('title', $item);
        } 
        showmessage($LANG['operation_success'] . count($caches) . $LANG['record'],$forward);
        break;
    case 'clearUrlcache':
        if (empty($deleteJobContent)) showmessage($LANG['illegal_parameters']);
        else
        {
            $query = "select PageUrl FROM " . TABLE_SPIDER_URLS . " WHERE JobId=$deleteJobContent";
            $result = $db->query($query);
            $caches = array();
            while ($r = $db->fetch_array($result))
            {
                $caches[] = md5($r['PageUrl']);
            } 
            foreach($caches as $item)
            {
                deleteCache('url', $item);
            } 
            if (count($caches) > 0)
            {
                showmessage($LANG['operate_success_delete_job'] . count($caches) . $LANG['record'],$forward);
            } 
            else
            {
                showmessage($LANG['operation_failure'],$forward);
            } 
        } 
        break;
    case 'clearTitlecache':
        if (empty($deleteJobContent)) showmessage($LANG['illegal_parameters']);
        else
        {
            $query = "select Content FROM " . TABLE_SPIDER_URLS . " WHERE JobId=$deleteJobContent and Content!=''";
            $result = $db->query($query);
            $caches = array();
            $reg = "/【" . $LANG['label'] . ":标题】:([\s\S]*?)【\/" . $LANG['label'] . "】/";
            while ($r = $db->fetch_array($result))
            {
                $matchs = array();
                preg_match($reg, $r["Content"], $matchs);
                if (!empty($matchs[1]))$caches[] = md5($matchs[1]);
            } 
            foreach($caches as $item)
            {
                deleteCache('title', $item);
            } 
            if (count($caches) > 0)
            {
                showmessage($LANG['operate_success_delete_job'] . count($caches) . $LANG['record'],$forward);
            } 
            else
            {
                showmessage($LANG['operation_failure'],$forward);
            } 
        } 
        break;

    case 'deletejobcontent':
        if (empty($deleteJobContent)) showmessage($LANG['illegal_parameters']);
        else
        {
            $db->query("DELETE FROM " . TABLE_SPIDER_URLS . " WHERE JobId=$deleteJobContent");
            if ($db->affected_rows() > 0)
            {
                showmessage($LANG['operate_success_delete_job'] . $db->affected_rows() . $LANG['record'],$forward);
            } 
            else
            {
                showmessage($LANG['operation_failure'],$forward);
            } 
        } 
        break;
} 

function loadTitle($Path)
{
    global $db, $listCache, $ContentCache, $Debug, $CachePath,$M;
    $Debug = $M['Debug'];
    $listCache = array();
    $ContentCache = array();
    $CachePath = $Path; 
   
    $tmp = scandir($CachePath);
    if (count($tmp) < 3)
    {
        $sql = "Select title FROM " . DB_PRE . "content order by contentid";
        dataLoadFromDb($sql, 'title');
        dataCache();
    } 
    else
    {
        dataLoad();
    } 
} 

function getLinkUrls(&$data,$url=NULL,$repeat = false)
{
	preg_match_all("/<a\s[^>]*href=['|\"]?([^'|\"]+)['|\"]?[^>]*>([^>]+)<\/a>/i",$data,$images,PREG_PATTERN_ORDER);
	$id = 0;
	$back = array();
	$back[0] = $images[1];
	$back[1] = $images[2];
	$r = array();
	while(isset($back[0][$id]))
	{
		if($url)
		{
			$tmp = parseUrl($url,$back[0][$id],$exts);
			if($tmp)$back[2][$id] = $tmp;
		}
		$id++;
	}
	if(is_array($back[2]))
	{
		if(!$repeat)$back[2] = array_unique($back[2]);
		foreach($back[2] as $id => $q)
		{
			$q = str_replace("&amp;","&",$q);
			if(preg_match("/^[^>]+$/i",$q))$r[] = array("title" => $back[1][$id], "url" => $q);
		}
		return $r;
	}else return false;
}

function parseUrl($url,$iurl,$exts=NULL)
{
	$url = parse_url($url);
	$tmpiurl = parse_url($iurl);
	if(!isset($url['scheme']))return false;
	else
	{
		$tpath = explode("/",$tmpiurl['path']);			
		$tid = 0;
		$rpath = array();
		if(substr($tmpiurl['path'],0,1) == "/")
		{
			$url['path'] = NULL;
			$rpath = $tmpiurl['path'];
		}
		else
		{
			$url['path'] =dirname($url['path']);
			foreach($tpath as $p)
			{
				if($p =="..")$url['path'] =dirname($url['path']);
				if(substr($p,0,1) != ".")$rpath[] = $p;
			}
			if(is_array($rpath))$rpath = "/".implode("/",$rpath);
		}			
		$tmpiurl['query'] = $tmpiurl['query']?"?".$tmpiurl['query']:NULL;
		if($url['path'] == "\\")$url['path'] = NULL;
		if(isset($tmpiurl['scheme']) && isset($tmpiurl['host']))
		return $tmpiurl['scheme']."://".$tmpiurl['host'].$rpath.$tmpiurl['query'];
		else
		return $url['scheme']."://".$url['host'].$url['path'].$rpath.$tmpiurl['query'];
	}
}

?>