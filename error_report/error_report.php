<?php
require './include/common.inc.php';
if ($dosubmit)
{
    if (!$report_mod || (!array_key_exists($report_mod, $MODULE))) showmessage($LANG['illegal_operation']);
    $forward = "?title=$error[error_title]&error_link=$error[error_link]";
    if ($checkcodestr)
    {
        checkcode($checkcodestr, $PHPCMS['enableadmincheckcode'], $forward);
    }
    else
    {
        showmessage($LANG['input_checkcode'], $forward);
    }
    $error['addtime'] = $PHP_TIME;
    if ($keyid == 0 || empty($keyid))
    {
        $error['keyid'] = $report_mod;
    }
    else
    {
        $error['keyid'] = $keyid;
    }
    $keys = $values = $s = "";
    foreach($error as $key => $value)
    {
        $keys .= $s . $key;
        $values .= $s . "'" . $value . "'";
        $s = ",";
    }
    $db->query("INSERT INTO " . TABLE_ERROR_REPORT . "($keys) VALUES ($values)");
    echo "<script type='text/javascript'>\n";
    echo "alert('" . $LANG['thanks'] . "');";
    echo "close();";
    echo "</script>\n";
}
else
{
    if (empty($title) || empty($error_link)) showmessage($LANG['illegal_operation']);
    $error_link = substr($error_link, 0, -1);
    $error_link = substr($error_link, 1);
    $error_date = date('Y-m-d', $PHP_TIME);

    include template('error_report', 'error_report');
}

?>