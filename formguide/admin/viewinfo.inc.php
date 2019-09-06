<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$forward) $forward = HTTP_REFERER;
if(!class_exists('formguide_admin'))
{
	require MOD_ROOT.'admin/include/formguide_admin.class.php';
}
if(!class_exists('formguide_form'))
{
	require CACHE_MODEL_PATH.'formguide_output.class.php';
}
$formguide_admin = new formguide_admin();
$result = $formguide_admin->getbydataid($formid, $dataid);
$formguide_output = new formguide_output($formid);
$info = $formguide_output->get($result);
include admin_tpl('viewinfo');
?>