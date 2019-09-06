<?php
defined('IN_PHPCMS') or exit('Access Denied');

switch ($action)
{
    case 'installjob':
        if (isset($submit))
        {
            if (empty($siteid)) showmessage($LANG['illegal_parameters']);

            if (empty($rulecontent)) showmessage($LANG['illegal_parameters']);
            include(PHPCMS_ROOT . "/" . $mod . "/admin/des.inc.php");
            $rulecontent = auth_decrypt($rulecontent, "phpcms_locoy");
            if (strpos($rulecontent, "♂") < 1) showmessage($LANG['error_job_info_cannot_finish_install']);
            $rulearr = explode("♂", $rulecontent);
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
            $res = $db->query("SELECT * FROM " . TABLE_SPIDER_SITES . " Order by Id desc");
            if (mysql_num_rows($res) < 1)
                showmessage($LANG['no_any_site_add_one_first'], "?mod=" . $mod . "&file=sitemgr&action=add");
            $site_select = "<select name='siteid' id='jobSiteId'><option  value='0'>" . $LANG['select_site'] . "</option>";
            while ($r = $db->fetch_array($res))
            {
                $site_select .= "<option value=" . $r['Id'] . " >" . $r['SiteName'] . "</option>";
            } 
            $site_select .= "</select>";
            include(admin_tpl('install_job'));
        } 

        break;

    case 'installsite':
        if ($rulecontent)
        {
            if (empty($rulecontent)) showmessage($LANG['illegal_parameters']);
            include(PHPCMS_ROOT . "/" . $mod . "/admin/des.inc.php");
            $rulecontent = auth_decrypt($rulecontent, "phpcms_locoy");
            if (strpos($rulecontent, "♂") < 1) showmessage($LANG['error_job_info_cannot_finish_install']);
            $rulearr = explode("♂", $rulecontent);
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
                    showmessage($LANG['install_share_site_rule_success'] . "<br>\n", "?mod=" . $mod . "&file=sitemgr&action=manage");
                } 
            } 
        } 
        else
        {
            $id = $id;
            $type = $type;
            include(admin_tpl('install_site'));
        } 

        break;
    case 'catchinfo': 
        if (empty($jobid)) showmessage($LANG['illegal_parameters']);
        @include(PHPCMS_ROOT . "/spider/admin/des.inc.php");
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
        $usersite = $PHP_DOMAIN;
        include admin_tpl('catch_info');
        break;
} 

function dstripslashes($string)
{
    if (!is_array($string)) return stripslashes($string);
    foreach($string as $key => $val) $string[$key] = dstripslashes($val);
    return $string;
} 

?>