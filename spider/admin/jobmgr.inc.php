<?php 

defined('IN_PHPCMS') or exit('Access Denied');
if(!strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),'MSIE')) showmessage('对不起，目前采集程序只能支持IE浏览器，请换用IE浏览器浏览！');
include_once MOD_ROOT . '/include/charset.func.php';
$submenu = array
(
    array($LANG['add_job'], "?mod=" . $mod . "&file=" . $file . "&action=add"),
    array("<font color=red>" .$LANG['job_manage']. "</font>", "?mod=" . $mod . "&file=" . $file . "&action=manage"),
    array("<font color=red>" . $LANG['load_job'] . "</font>", "?mod=" . $mod . "&file=" . $file . "&action=jobin"),
);
$menu = adminmenu($LANG['spider_job_manage'], $submenu);

$action = $action ? $action : 'manage';

switch ($action)
{
    case 'jobin':
        if (isset($extract) && $extract == 1)
        {
            if (empty($siteid)) showmessage($LANG['illegal_parameters']);
            include(PHPCMS_ROOT . "/" . $mod . "/admin/des.inc.php");
            if (!file_exists(PHPCMS_ROOT . "/data/temp/jobin.pjob"))
                showmessage($LANG['cannot_continue_to_load_job']);
            $filecontent = auth_decrypt(file_get_contents(PHPCMS_ROOT . "/data/temp/jobin.pjob"), "phpcms_locoy");
            if (!strpos($filecontent, "♂"))
            {
                $filecontent = convert_encoding($charset_config['target'],$charset_config['self'], $filecontent);
            } 

            $rulearr = explode("♂", $filecontent);
            if (is_array($rulearr))
            {
                $sql = str_replace("[" . $LANG['job_database'] . "]", TABLE_SPIDER_JOB, $rulearr[0]);
                $sql .= "'','" . $siteid . "',";
                $sql .= $rulearr[1];
            } 
            $db->query($sql);
            $insertid = $db->insert_id();
            if ($insertid > 0)
            {
                @$fp = fopen(PHPCMS_ROOT . "/" . $mod . "/rules/" . $insertid . ".php", "w");
                @flock($fp, 3);
                if (@!fwrite($fp, $rulearr[2]))
                {
                    showmessage($LANG['zip_file_to_server'] . " ./" . $mod . "/rules/ " . $LANG['directory_writeable']);
                } 
                else
                {
                    @fclose($fp);
                    showmessage($LANG['load_job_success'] . "<br>\n", "?mod=" . $mod . "&file=jobmgr&action=manage");
                } 
            } 
        } 
        else
        {
            if (isset($uploadjob))
            {
                include_once PHPCMS_ROOT . "/include/upload.class.php";
                $upfile_size = '1000000';
                $upfile_type = 'pjob';
                $fileArr = array('file' => $_FILES['uploadfile']['tmp_name'],
                    'name' => $_FILES['uploadfile']['name'],
                    'size' => $_FILES['uploadfile']['size'],
                    'type' => $_FILES['uploadfile']['type']);
                if (!@preg_match("/[^\.]+\.pjob$/i", $fileArr['name']))
                    showmessage($fileArr['name'] . $LANG['illegal_file_name_file_ext_must'] . " .pjob");

                $tmpext = strtolower(fileext($fileArr['name']));
                if ($tmpext != $upfile_type)
                    showmessage($LANG['file_format_error_file_ext_must'] . " .pjob");

                $savepath = "data/temp/";
                dir_create($savepath);
                $upload = new upload('uploadfile', $savepath, 'jobin.pjob', $upfile_type, $upfile_size, 1);
                if ($upload->up())
                    showmessage($LANG['job_file'] . $uploadfile_name . $LANG['loading_job_info'] . "...<br />", "?mod=" . $mod . "&file=" . $file . "&action=jobin&extract=1&siteid=" . $siteid);
                else
                    showmessage($LANG['cannot_upload_error_info'] . $upload->error());
            } 
            else
            {
                $res = $db->query("SELECT * FROM " . TABLE_SPIDER_SITES . " Order by Id desc");
                if ($db->num_rows($res) < 1)
                    showmessage($LANG['no_any_site_add_one_first'], "?mod=$mod&file=sitemgr&action=add");
                $site_select = "<select name='siteid' id='jobSiteId'><option  value='0'>" . $LANG['select_site'] . "</option>";
                while ($r = $db->fetch_array($res))
                {
                    $site_select .= "<option value=" . $r['Id'] . " >" . $r['SiteName'] . "</option>";
                } 
                $site_select .= "</select>";
                include(admin_tpl('job_in'));
            } 
        } 
        break;
    case 'catchinfo': 
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        include(PHPCMS_ROOT . "/spider/admin/des.inc.php");
        $rows = $db->query("SELECT * FROM " . TABLE_SPIDER_JOB . " where JobId=" . $jobid);
        $numfields = $db->num_fields($rows);
        $numrows = $db->num_rows($rows);
        $tabledump = "";
        while ($row = $db->fetch_row($rows))
        {
            $comma = "";
            for($i = 2; $i < $numfields; $i++) 
            {
                $tabledump .= $comma . "'" . new_addslashes($row[$i]) . "'";
                $comma = ",";
            } 
        } 
        $tabledump .= ");\n";

        if (!file_exists(PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php"))
            showmessage($LANG['job_cannot_continue_info_not_found_job_rule'] . PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php");
        $ruledata = file_get_contents(PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php");
        $filecontent = "INSERT INTO [" . $LANG['job_database'] . "] VALUES(♂" . $tabledump . "♂" . $ruledata;
        $key = "phpcms_locoy";
        $jobrulecontent = auth_encrypt($filecontent, $key);
        $usersite = $PHPCMS['siteurl'];
        include admin_tpl('catch_info');
        break;
    case 'testspider': 
        include(MOD_ROOT . "/include/htmlframe.inc.php");
        loadMtir();
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        require MOD_ROOT . "/admin/mainspider.inc.php";
        $ms = new MainSpider();
        $ms->JobId = $jobid;
        $ms->mod = $mod;
        $ms->Init();
        include admin_tpl('test_spider');
        break;
    case 'turl':
        echo '任务测试采集<br>';
        $start_time = getmicrotime();
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        require MOD_ROOT . "/admin/mainspider.inc.php";
        $ms = new MainSpider();
        $ms->JobId = $jobid;
        $ms->mod = $mod;
        $ms->Init();
        $ms->tid = isset($tid)?$tid:0;
        if (isset($testcontent))
        {
            if ($testcontent == true)
            {
                $testartile = $ms->TestArtical($pageurl);
                include admin_tpl('tcontent');
            } 
            echo '<br>';
        } 
        else
        {
            $turls = $ms->TestRules();
            include admin_tpl('turl');
        } 
        $end_time = getmicrotime();
        $total_time = number_format($end_time - $start_time, 3, '.', '');
        echo '任务测试采集总耗时：' . $total_time . '毫秒<br>';
        break;
    case 'delete':
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        if (!is_numeric($jobid))
        {
            $jobids = implode(",", $jobid);
            $db->query("DELETE FROM " . TABLE_SPIDER_JOB . " WHERE JobId in ($jobids)");
            if ($db->affected_rows() > 0)
            {
                foreach($jobid as $jd)
                @unlink(PHPCMS_ROOT . "/spider/rules/" . $jd . ".php");
                $db->query("DELETE FROM " . TABLE_SPIDER_URLS . " WHERE JobId=$jd");
                showmessage($LANG['operation_success'], "?mod=" . $mod . "&file=" . $file . "&action=manage");
            } 
            else
            {
                showmessage($LANG['operation_failure'], "?mod=" . $mod . "&file=" . $file . "&action=manage");
            } 
        } 
        else
        {
            $r = $db->get_one("select * from " . TABLE_SPIDER_JOB . " where JobId='$jobid'");
            if (!$r['JobId']) showmessage($LANG['not_exist_job_return']);
            $db->query("DELETE FROM " . TABLE_SPIDER_JOB . " WHERE JobId='$jobid'");
            if ($db->affected_rows() > 0)
            {
                @unlink(PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php");
                $db->query("DELETE FROM " . TABLE_SPIDER_URLS . " WHERE JobId=$jobid");
                showmessage($LANG['operation_success'], "?mod=" . $mod . "&file=" . $file . "&action=manage");
            } 
            else
            {
                showmessage($LANG['operation_failure'], "?mod=" . $mod . "&file=" . $file . "&action=manage");
            } 
        } 
        break;

    case 'modify':
        if (empty($jobid))
        {
            showmessage($LANG['illegal_parameters']);
        } 
        if (isset($save))
        {
            if (!$job['StartUrl']) showmessage($LANG['start_url_not_null']); 

            $job['UpdateOn'] = TIME;
            if (!isset($job['DownImg'])) $job['DownImg'] = 0;
            if (!isset($job['DownSwf'])) $job['DownSwf'] = 0;
            if (!isset($job['DownOther'])) $job['DownOther'] = 0;
            $sql1 = $s = '';
            foreach($job as $key => $value)
            {
                $sql .= $s . $key . "='" . $value . "'";
                $s = ",";
            } 
            $db->query("UPDATE " . TABLE_SPIDER_JOB . " SET $sql WHERE Jobid='$jobid'"); 

            $ruleLabelNameArr = explode("|", $ruleLabelName);
            $ruleKeyArr = explode("|", $ruleKey);
            unset($ruleLabelNameArr[0]);
            unset($ruleKeyArr[0]); 

            for($i = 1;$i <= count($ruleKeyArr);$i++)
            $rule['LabelName'][$ruleKeyArr[$i]] = $ruleLabelNameArr[$i];

            if (is_array($rule['HtmlTrim']))
            {
                foreach($rule['HtmlTrim'] as $key => $value)
                $r[$key] = is_array($value)? implode(",", $value):"" ;
            } 
            $rule['HtmlTrim'] = $r;
            $rule = new_stripslashes($rule);
            array_save($rule, "\$rule", PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php");
            showmessage($LANG['operation_success'], "?mod=" . $mod . "&file=" . $file . "&action=manage");
        } 
        else
        {
            $r = $db->get_one("select * from " . TABLE_SPIDER_JOB . " where JobId='$jobid'");
            @extract(new_htmlspecialchars($r), EXTR_PREFIX_ALL, "job");
            @include (PHPCMS_ROOT . "/" . $mod . "/rules/" . $jobid . ".php");
            $labelkeys = array_keys($rule['LabelName']);
            $res = $db->query("SELECT * FROM " . TABLE_SPIDER_SITES . " Order by Id desc");
            $site_select = "<select name='job[SiteId]' id='jobSiteId'><option  value='0'>" . $LANG['select_site'] . "</option>";
            while ($r = $db->fetch_array($res))
            {
                $site_select .= "<option value=" . $r['Id'];
                if ($job_SiteId == $r['Id'])
                    $site_select .= " selected ";
                $site_select .= ">" . $r['SiteName'] . "</option>";
            } 
            $site_select .= '</select>';
            if (isset($job_CatId))
            {
                $loadModelId = $job_CatId;
                $selectHtml = '';
                foreach($CATEGORY as $row)
                {
                    if ($row['catid'] == $loadModelId)
                    {
                        $modelname = $MODEL[$row['modelid']]['name'];
                        $fs = include_once(PHPCMS_ROOT . '/data/cache_model/' . $row['modelid'] . '_fields.inc.php');

                        $publish = array();
                        $pindex = 0;
                        foreach($rule['publish'] as $index => $item)
                        {
                            $selectHtml = "<option value='' />选择[" . $modelname . "]字段"; 

                            foreach($fs as $fName => $rArray)
                            {
                                $selectHtml .= "<option value='" . $fName . "' " . (($fName == $item)?'selected':'') . " />" . $rArray['name'];
                            } 
                            $publish[$pindex++] = '<select id="rule[publish][' . $index . ']" name="rule[publish][' . $index . ']">' . $selectHtml . '</select>';
                        } 

                        $selectHtml = "<option value='' />选择[" . $modelname . "]字段"; 

                        foreach($fs as $fName => $rArray)
                        {
                            $selectHtml .= "<option value='" . $fName . "' " . (($fName == $item)?'selected':'') . " />" . $rArray['name'];
                        } 
                        break;
                    } 
                } 
            } 

            $modelid = 0;
            $selectHtml = str_replace('selected', '', $selectHtml);
            $cat_js = "onchange=\"javascript:loadModel(this.value);\"";
            include admin_tpl('job_modify');
        } 
        break;

    case 'add':
        if (isset($save))
        {
            if (!$job['StartUrl']) showmessage($LANG['start_url_not_null']); 

            $job['CreateOn'] = TIME;
            $sql1 = $sql2 = $s = '';

            foreach($job as $key => $value)
            {
                $sql1 .= $s . $key;
                $sql2 .= $s . "'" . $value . "'";
                $s = ",";
            } 
            $db->query("insert into " . TABLE_SPIDER_JOB . " ($sql1) values($sql2)");
            $jobid = $db->insert_id(); 

            $ruleLabelNameArr = explode("|", $ruleLabelName);
            $ruleKeyArr = explode("|", $ruleKey);
            unset($ruleLabelNameArr[0]);
            unset($ruleKeyArr[0]);
            for($i = 1;$i <= count($ruleKeyArr);$i++)
            $rule['LabelName'][$ruleKeyArr[$i]] = $ruleLabelNameArr[$i];

            if (is_array($rule['HtmlTrim']))
            {
                foreach($rule['HtmlTrim'] as $key => $value)
                $r[$key] = is_array($value)? implode(",", $value) : "" ;
            } 
            $rule['HtmlTrim'] = $r;
            $rule = new_stripslashes($rule);
            array_save($rule, "\$rule", PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php");
            showmessage($LANG['operation_success'], "?mod=" . $mod . "&file=" . $file . "&action=manage");
        } 
        else
        {
            if (isset($loadModelId))
            {
                foreach($CATEGORY as $row)
                {
                    if ($row['catid'] == $loadModelId)
                    {
                        $modelname = $MODEL[$row['modelid']]['name'];
                        $selectHtml = '<option value="" />选择[' . $modelname . ']字段';
                        $fs = include_once(PHPCMS_ROOT . '/data/cache_model/' . $row['modelid'] . '_fields.inc.php'); 

                        foreach($fs as $f => $r)
                        {
                            $selectHtml .= "<option value='" . $f . "' />" . $r['name'];
                        } 
                        exit($selectHtml);
                    } 
                } 
                exit('ERR');
            } 

            if (isset($loadsiterule)) 
                {
                    $res = $db->query("SELECT * FROM " . TABLE_SPIDER_SITES . " Order by Id desc");
                if ($db->num_rows($res) < 1)
                {
                    showmessage($LANG['no_any_site_add_one_first'], "?mod=" . $mod . "&file=sitemgr&action=add");
                } 
                $site_select = "<select name='job[SiteId]' id='jobSiteId'   onchange='window.location=\"?mod=" . $mod . "&file=jobmgr&action=add&loadsiterule=\"+this.value'><option  value='0'>" . $LANG['select_job_parent_site'] . "</option>";
                while ($r = $db->fetch_array($res))
                {
                    $site_select .= "<option value=" . $r['Id'] . "";
                    if ($r['Id'] == $loadsiterule) $site_select .= " selected ";
                    $site_select .= ">" . $r['SiteName'] . "</option>";
                } 
                if (strpos($site_select, "option") < 1)
                {
                    showmessage($LANG['no_any_site_add_one_first'], "?mod=" . $mod . "&file=sitemgr&action=add");
                } 
                $site_select .= "</select>";
            } 
            $labelkeys = array();
            if (isset($loadsiterule) && file_exists(PHPCMS_ROOT . "/" . $mod . "/rules/site_" . $loadsiterule . ".php"))
            {
                @include (PHPCMS_ROOT . "/" . $mod . "/rules/site_" . $loadsiterule . ".php");
                $labelkeys = array_keys($rule['LabelName']);
            } 
            else
            {
                $labels = array(
                    array("name" => $LANG['title'], "displaystatus" => "block", "imgstatus" => "open"),
                    array("name" => $LANG['content'], "displaystatus" => "block", "imgstatus" => "open"),
                    array("name" => $LANG['author'], "displaystatus" => "none", "imgstatus" => "close"),
                    array("name" => $LANG['source'], "displaystatus" => "none", "imgstatus" => "close"),
                    array("name" => $LANG['time'], "displaystatus" => "none", "imgstatus" => "close")
                    );
                if (!isset($site_select)) 
                    {
                        $res = $db->query("SELECT * FROM " . TABLE_SPIDER_SITES . " Order by Id desc");
                    if ($db->num_rows($res) < 1)
                    {
                        showmessage($LANG['no_any_site_add_one_first'], "?mod=" . $mod . "&file=sitemgr&action=add");
                    } 
                    $site_select = "<select name='job[SiteId]' id='jobSiteId'   onchange='window.location=\"?mod=" . $mod . "&file=jobmgr&action=add&loadsiterule=\"+this.value'><option  value='0'>" . $LANG['select_site'] . "</option>";
                    while ($r = $db->fetch_array($res))
                    {
                        $site_select .= "<option value=" . $r['Id'] . " >" . $r['SiteName'] . "</option>";
                    } 
                    if (strpos($site_select, "option") < 1)
                    {
                        showmessage($LANG['no_any_site_add_one_first'], "?mod=" . $mod . "&file=sitemgr&action=add");
                    } 
                    $site_select .= "</select>";
                } 
            } 

            $modelid = 0;
            $cat_js = "onchange=\"javascript:loadModel(this.value);\"";

            include admin_tpl('job_add');
        } 
        break;

    case 'manage':

        $serverip = gethostbyname('www.phpcms.cn');
        if (!preg_match("/^[0-9.]{7,15}$/", $serverip)) showmessage($LANG['DNS_error_cannot_spider']);
        if (!function_exists('fsockopen')) showmessage($LANG['fsockopen_disabled_cannot_spider']);

        $page = isset($page) ? intval($page) : 1;
        $offset = ($page-1) * $PHPCMS['pagesize'];
        $r = $db->get_one("SELECT count(*) as num FROM " . TABLE_SPIDER_JOB);
        $number = $r['num'];
        $pages = pages($number, $page, $PHPCMS['pagesize']);
        $result = $db->query("SELECT JobId,JobName,JobDescription,SiteId,CreateOn,UpdateOn," . TABLE_SPIDER_SITES . ".Id," . TABLE_SPIDER_SITES . ".SiteName as SiteName" . " FROM " . TABLE_SPIDER_JOB . "," . TABLE_SPIDER_SITES . " WHERE SiteId=" . TABLE_SPIDER_SITES . ".Id order by JobId desc limit $offset," . $PHPCMS['pagesize']);
        $jobs = array();
        while ($r = $db->fetch_array($result))
        {
            $jobs[] = $r;
        } 
        include admin_tpl('job_list');
        break;

    case 'jobcopy':
        if (isset($copyjob))
        {
            if (empty($jobid)) showmessage($LANG['illegal_parameters']);
            if (empty($siteid)) showmessage($LANG['illegal_parameters']);

            $rows = $db->query("SELECT * FROM " . TABLE_SPIDER_JOB . " where JobId=" . $jobid);
            $numfields = $db->num_fields($rows);
            $numrows = $db->num_rows($rows);
            $tabledump = "";
            while ($row = $db->fetch_row($rows))
            {
                $comma = "";
                for($i = 2; $i < $numfields; $i++) 
                {
                    $tabledump .= $comma . "'" . new_addslashes($row[$i]) . "'";
                    $comma = ",";
                } 
                $tabledump .= ");\n";
            } 

            if (!file_exists(PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php"))
                showmessage($LANG['job_cannot_copy_info_not_found_job_rule'] . PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php");
            $sql = "INSERT INTO " . TABLE_SPIDER_JOB . " VALUES('','" . $siteid . "'," . $tabledump;
            $db->query($sql);
            $insertid = $db->insert_id();
            if ($insertid > 0)
            {
                @$fp = copy(PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php", PHPCMS_ROOT . "/spider/rules/" . $insertid . ".php");
                showmessage($LANG['success_paste_job_redirect_job_manage'] . "<br>\n", "?mod=" . $mod . "&file=jobmgr&action=manage");
            } 
        } 
        else
        {
            $res = $db->query("SELECT * FROM " . TABLE_SPIDER_SITES . " Order by Id desc");
            if ($db->num_rows($res) < 1)
                showmessage($LANG['no_any_site_add_one_first'], "?mod=" . $mod . "&file=sitemgr&action=add");
            $site_select = "<select name='siteid' id='jobSiteId'><option  value='0'>" . $LANG['select_site'] . "</option>";
            while ($r = $db->fetch_array($res))
            {
                $site_select .= "<option value=" . $r['Id'] . " >" . $r['SiteName'] . "</option>";
            } 
            $site_select .= "</select>";
            include admin_tpl('job_copy');
        } 
        break;
    case 'jobout':
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        if (isset($download) && $download == 1)
        {
            $fileurl = PHPCMS_ROOT . "/data/temp/" . $LANG['name_of_out_job'] . ".pjob";
            if (!file_exists($fileurl))
                showmessage($LANG['job_cannot_out'] . 'cannot find the file');
            $filename = isset($jname) ? urldecode($jname) . '.pjob': $LANG['name_of_out_job'] . ".pjob";
            $filesize = filesize($fileurl);
            ob_end_clean();
            header('Cache-control: max-age=31536000');
            header('Expires: ' . gmdate('D, d M Y H:i:s', TIME + 31536000) . ' GMT');
            header('Content-Encoding: none');
            if ($filesize) header('Content-Length: ' . $filesize);
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Content-Type: .pjob');
            @readfile($fileurl);
        } 
        else
        {
            @include PHPCMS_ROOT . '/spider/admin/des.inc.php';
            $rows = $db->query("SELECT * FROM " . TABLE_SPIDER_JOB . " where JobId=" . $jobid);
            $numfields = $db->num_fields($rows);
            $numrows = $db->num_rows($rows);
            $tabledump = '';
            while ($row = $db->fetch_row($rows))
            {
                $comma = '';
                for($i = 2; $i < $numfields; $i++) 
                {
                    $tabledump .= $comma . "'" . new_addslashes($row[$i]) . "'";
                    $comma = ',';
                } 
            } 
            $tabledump .= ");\n";
            if (!file_exists(PHPCMS_ROOT . '/spider/rules/' . $jobid . '.php'))
                showmessage($LANG['job_cannot_continue_info_not_found_job_rule'] . PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php");
            $ruledata = file_get_contents(PHPCMS_ROOT . "/spider/rules/" . $jobid . ".php");
            $filecontent = "INSERT INTO [" . $LANG['job_database'] . "] VALUES(♂" . $tabledump . "♂" . $ruledata;
            $key = "phpcms_locoy";
            $filecontent = auth_encrypt($filecontent, $key);
            if (@!file_put_contents(PHPCMS_ROOT . '/data/temp/' . $LANG['name_of_out_job'] . '.pjob', $filecontent))
            {
                showmessage($LANG['data_cannot_backup_to_server_check_writeable']);
            } 
            else
            {
                showmessage($LANG['prepare_job_info_waiting'] . "<br>\n", "?mod=$mod&file=$file&action=jobout&jobid=$jobid&download=1&jname=" . urlencode($jname));
            } 
            break;
        } 
} 

?>