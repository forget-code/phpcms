<?php

defined('IN_PHPCMS') or exit("No Permission to run in this page!");
if(!strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),'MSIE')) showmessage('对不起，目前采集程序只能支持IE浏览器，请换用IE浏览器浏览！');
include_once MOD_ROOT . '/include/charset.func.php';

$submenu = array
(
    array($LANG['add_spider_site'], "?mod=" . $mod . "&file=sitemgr&action=add"),
    array("<font color=red>" .$LANG['spider_site_manage']. "</font>", "?mod=" . $mod . "&file=sitemgr&action=manage"),
    array("<font color=red>" . $LANG['load_site_rule'] . "</font>", "?mod=" . $mod . "&file=sitemgr&action=sitein"),
    );
$menu = adminmenu($LANG['spider_site_manage'], $submenu);
$action = $action ? $action : 'manage';

switch ($action)
{ 

    case 'delete':
        if (is_numeric($siteid))
        {
            $res = $db->query("select JobId,SiteId from " . TABLE_SPIDER_JOB . " where SiteId='$siteid'");
            if ($db->num_rows($res) > 0)
                showmessage($LANG['existed_job_in_this_site_delete_it_first']);
            else
                $result = $db->query("delete from " . TABLE_SPIDER_SITES . " where Id=" . $siteid);
            @unlink(PHPCMS_ROOT . "/spider/rules/site_" . $siteid . ".php");
        } elseif (is_array($siteid))
        {
            foreach($siteid as $sd)
            {
                $res = $db->query("select JobId,SiteId from " . TABLE_SPIDER_JOB . " where SiteId='$sd'");
                if ($db->num_rows($res) > 0)
                    showmessage($LANG['existed_job_in_someone_site_delete_in_job_mange_page']);
            } 
            $siteids = implode(",", $siteid);
            $db->query("delete from " . TABLE_SPIDER_SITES . " where Id in ($siteids)");

            foreach ($siteid as $sd)
            {
                @unlink(PHPCMS_ROOT . "/spider/rules/site_" . $sd . ".php");
            } 
        } 

        if ($db->affected_rows() > 0)
        {
            showmessage($LANG['operation_success'], "?mod=" . $mod . "&file=sitemgr");
        } 
        else
        {
            showmessage($LANG['not_query_any_record_return'] , "?mod=" . $mod . "&file=sitemgr");
        } 
        break;
    case 'catchsiteinfo':
        include(PHPCMS_ROOT . "/spider/admin/des.inc.php");
        $rows = $db->query("SELECT * FROM " . TABLE_SPIDER_SITES . " where Id=" . $siteid);
        $numfields = $db->num_fields($rows);
        $numrows = $db->num_rows($rows);
        $tabledump = "";
        while ($row = $db->fetch_row($rows))
        {
            $comma = "";
            for($i = 1; $i < $numfields; $i++) 
            {
                $tabledump .= $comma . "'" . new_addslashes($row[$i]) . "'";
                $comma = ",";
            } 
        } 
        $tabledump .= ");\n";

        if (!file_exists(PHPCMS_ROOT . "/spider/rules/site_" . $siteid . ".php"))
            showmessage($LANG['cannot_continue_error_info_not_fount_rule_file'] . PHPCMS_ROOT . "/spider/rules/site_" . $siteid . ".php");
        $ruledata = file_get_contents(PHPCMS_ROOT . "/spider/rules/site_" . $siteid . ".php");
        $filecontent = "INSERT INTO [" . $LANG['site_database'] . "] VALUES(♂" . $tabledump . "♂" . $ruledata;
        $key = "phpcms_locoy";
        $jobrulecontent = auth_encrypt($filecontent, $key);
        $usersite = $PHPCMS['siteurl'];
        include admin_tpl('catch_info');
        break;
    case 'modify':
        if (isset($Submit))
        {
            if (strlen($site['SiteName']) < 2 || strlen($site['SiteName']) > 50)
                showmessage($LANG['site_name_not_null_or_between_2-50_chars']);

            $badwords = array("\\", '&', "'", '"', '/', '*', '<', '>', "\r", "\t", "\n", '#');
            foreach ($badwords as $value)
            {
                if (strpos($site['SiteName'], $value) !== false)
                {
                    showmessage($LANG['illegal_char_in_site_name']);
                } 
            } 

            $sql = "UPDATE " . TABLE_SPIDER_SITES . " SET SiteName='" . $site['SiteName'] . "',SiteUrl='" . $site['SiteUrl'] . "',Description='" . $site['Description'] . "' where Id='$siteid'";
            $result = $db->query($sql); 

            $ruleLabelNameArr = explode("|", $ruleLabelName);
            $ruleKeyArr = explode("|", $ruleKey);
            unset($ruleLabelNameArr[0]);
            unset($ruleKeyArr[0]);
            for($i = 1;$i <= count($ruleKeyArr);$i++)
            $rule['LabelName'][$ruleKeyArr[$i]] = $ruleLabelNameArr[$i];

            $r = array();
            if (isset($rule['HtmlTrim']) && is_array($rule['HtmlTrim']))
            {
                foreach($rule['HtmlTrim'] as $key => $value)
                $r[$key] = is_array($value) ? implode(",", $value):'' ;
            } 
            $rule['HtmlTrim'] = $r;
            $rule = dstripslashes($rule);
            array_save($rule, '\$rule', PHPCMS_ROOT . "/spider/rules/site_" . $siteid . ".php");
            showmessage($LANG['operation_success'], "?mod=" . $mod . "&file=sitemgr");
        } 

        $site = $db->get_one("SELECT * FROM " . TABLE_SPIDER_SITES . " where Id = $siteid limit 1");
        $site = new_htmlspecialchars($site);
        if (count($site) < 1) showmessage($LANG['not_query_any_record_return'], "?mod=$mod&file=sitemgr");

        @include (PHPCMS_ROOT . "/" . $mod . "/rules/site_" . $siteid . ".php");
        $labelkeys = array_keys($rule['LabelName']);

        include admin_tpl("site_modify");
        break;

    case 'add':
        if (isset($Submit))
        {

            if (strlen($site['SiteName']) < 2 || strlen($site['SiteName']) > 50)
                showmessage($LANG['site_name_not_null_or_between_2-50_chars']);

            $badwords = array("\\", '&', "'", '"', '/', '*', '<', '>', "\r", "\t", "\n", '#');
            foreach ($badwords as $value)
            {
                if (strpos($site['SiteName'], $value) !== false)
                {
                    showmessage($LANG['illegal_char_in_site_name']);
                } 
            } 

            $badwords = array("\\", '&', ' ', "'", '"', '*', ',', '<', '>', "\r", "\t", "\n");
            foreach ($badwords as $value)
            {
                if (strpos($site['SiteUrl'], $value) !== false)
                {
                    showmessage($LANG['illegal_char_in_site_url']);
                } 
            } 

            $sql = "INSERT INTO " . TABLE_SPIDER_SITES . " SET SiteName='$site[SiteName]',SiteUrl='$site[SiteUrl]',Description='$site[SiteName]'";
            $result = $db->query($sql);
            $siteinsertid = $db->insert_id();
            if ($siteinsertid > 0)
            { 

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
                $rule = dstripslashes($rule);
                array_save($rule, '\$rule', PHPCMS_ROOT . "/spider/rules/site_" . $siteinsertid . ".php");

                showmessage($LANG['operation_success'], "?mod=" . $mod . "&file=sitemgr");
            } 
            else showmessage($LANG['operation_fail_suddenness_error']);
        } 
        $labels = array(
            array("name" => $LANG['title'], "displaystatus" => "block", "imgstatus" => "open"),
            array("name" => $LANG['content'], "displaystatus" => "block", "imgstatus" => "open"),
            array("name" => $LANG['author'], "displaystatus" => "none", "imgstatus" => "close"),
            array("name" => $LANG['source'], "displaystatus" => "none", "imgstatus" => "close"),
            array("name" => $LANG['time'], "displaystatus" => "none", "imgstatus" => "close")
            );
        include admin_tpl("site_add");
        break;
    case 'siteout':

        if (empty($siteid)) showmessage($LANG['illegal_parameters']);
        if (isset($download) && $download == 1)
        {
            $fileurl = PHPCMS_ROOT . "/data/temp/" . $LANG['out_site_name'] . ".psite";
            if (!file_exists($fileurl))
                showmessage($LANG['site_cannot_out_error'] . ':cannot find the file');
            $filename = isset($sname) ? urldecode($sname) . '.psite': $LANG['out_site_name'] . ".psite";
            $filesize = filesize($fileurl); //print($filesize); //exit();
            ob_end_clean();
            header('Cache-control: max-age=31536000');
            header('Expires: ' . gmdate('D, d M Y H:i:s', TIME + 31536000) . ' GMT');
            header('Content-Encoding: none');
            if ($filesize) header('Content-Length: ' . $filesize);
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Content-Type: .psite');
            @readfile($fileurl);
        } 
        else
        {
            include(PHPCMS_ROOT . "/spider/admin/des.inc.php");
            $rows = $db->query("SELECT * FROM " . TABLE_SPIDER_SITES . " where Id=" . $siteid);
            $numfields = $db->num_fields($rows);
            $numrows = $db->num_rows($rows);
            $tabledump = "";
            while ($row = $db->fetch_row($rows))
            {
                $comma = "";
                for($i = 1; $i < $numfields; $i++) 
                {
                    $tabledump .= $comma . "'" . new_addslashes($row[$i]) . "'";
                    $comma = ",";
                } 
                $tabledump .= ");\n";

                if (!file_exists(PHPCMS_ROOT . "/$mod/rules/site_" . $siteid . ".php"))
                    showmessage($LANG['cannot_continue_error_info_not_fount_rule_file'] . PHPCMS_ROOT . "/$mod/rules/site_" . $siteid . ".php");
                $ruledata = file_get_contents(PHPCMS_ROOT . "/$mod/rules/site_" . $siteid . ".php");
                $filecontent = "INSERT INTO [" . $LANG['site_database'] . "] VALUES(♂" . $tabledump . "♂" . $ruledata;
                $key = "phpcms_locoy";
                $filecontent = auth_encrypt($filecontent, $key);

                @$fp = fopen(PHPCMS_ROOT . "/data/temp/" . $LANG['out_site_name'] . ".psite", "w");
                @flock($fp, 3);
                if (@!fwrite($fp, $filecontent))
                {
                    showmessage($LANG['data_cannot_backup_to_server_check_writeable']);
                } 
                else
                {
                    @fclose($fp);
                    showmessage($LANG['prepare_site_rule_waiting'] . "<br>\n", "?mod=$mod&file=$file&action=$action&siteid=$siteid&download=1&sname=" . urlencode($sname));
                } 
            } 
        } 
        break;

    case 'sitein':
        if (isset($extract) && $extract == 1)
        {
            include(PHPCMS_ROOT . "/" . $mod . "/admin/des.inc.php");
            if (!file_exists(PHPCMS_ROOT . "/data/temp/sitein.psite"))
                showmessage($LANG['cannot_continue_load_job_rule']);
            $filecontent = auth_decrypt(file_get_contents(PHPCMS_ROOT . "/data/temp/sitein.psite"), "phpcms_locoy");
            if (!strpos($filecontent, "♂"))
            {
                $filecontent = convert_encoding($charset_config['target'],$charset_config['self'], $filecontent);
            } 
            $rulearr = explode("♂", $filecontent);
            if (is_array($rulearr))
            {
                $sql = str_replace("[" . $LANG['site_database'] . "]", TABLE_SPIDER_SITES, $rulearr[0]);
                $sql .= "'',";
                $sql .= $rulearr[1];
            } 

            $db->query($sql);
            $insertid = $db->insert_id();
            if ($insertid > 0)
            {
                @$fp = fopen(PHPCMS_ROOT . "/" . $mod . "/rules/site_" . $insertid . ".php", "w");
                @flock($fp, 3);
                if (@!fwrite($fp, $rulearr[2]))
                {
                    showmessage($LANG['zip_file_to_server'] . " ./" . $mod . "/rules/ " . $LANG['directory_writeable']);
                } 
                else
                {
                    @fclose($fp);
                    showmessage($LANG['load_site_rule_success'] . "<br>\n", "?mod=" . $mod . "&file=sitemgr&action=manage");
                } 
            } 
        } 
        else
        {
            if (isset($uploadjob))
            {
                include_once PHPCMS_ROOT . "/include/upload.class.php";
                $upfile_size = '1000000';
                $upfile_type = 'psite';
                $fileArr = array('file' => $_FILES['uploadfile']['tmp_name'],
                    'name' => $_FILES['uploadfile']['name'],
                    'size' => $_FILES['uploadfile']['size'],
                    'type' => $_FILES['uploadfile']['type'],
                    'error' => $_FILES['uploadfile']['error']
                    );
                if (!@preg_match("/[^\.]+\.psite$/i", $fileArr['name']))
                    showmessage($LANG['illegal_file_name_file_ext_must'] . " .psite ");

                $tmpext = strtolower(fileext($fileArr['name']));
                if ($tmpext != $upfile_type)
                    showmessage($LANG['file_format_error_file_ext_must'] . " .psite ");

                $savepath = "data/temp/";
                dir_create($savepath);
                $upload = new upload('uploadfile', $savepath, 'sitein.psite', 'psite', $upfile_size, 1);
                if ($upload->up())
                    showmessage($LANG['job_file'] . $uploadfile_name . $LANG['loading_site_rule_infomation_waiting'] . "...<br />", "?mod=" . $mod . "&file=sitemgr&action=sitein&extract=1");
                else
                    showmessage($LANG['cannot_upload_error_info'] . $upload->error());
            } 
            else
            {
                include(admin_tpl('site_in'));
            } 
        } 
        break;

    case 'manage':
        $page = isset($page) ? intval($page) : 1;
        $offset = ($page-1) * $PHPCMS['pagesize'];
        $result = $db->query("SELECT count(*) as num FROM " . TABLE_SPIDER_SITES);
        $r = $db->fetch_array($result);
        $number = $r["num"];
        $pages = pages($number, $page, $PHPCMS['pagesize']);

        $result = $db->query("SELECT * FROM " . TABLE_SPIDER_SITES . "  order by ID desc limit $offset," . $PHPCMS['pagesize']);
        $sites = array();
        while ($r = $db->fetch_array($result))
        {
            $sites[] = $r;
        } 
        include admin_tpl('site_list');
        break;
} 

function dstripslashes($string)
{
    if (!is_array($string)) return stripslashes($string);
    foreach($string as $key => $val) $string[$key] = dstripslashes($val);
    return $string;
} 

?>