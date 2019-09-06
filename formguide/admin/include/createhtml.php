<?php
require CACHE_MODEL_PATH.'formguide_form.class.php';
$formguide = new formguide_form($formid);
$forminfos = $formguide->get();
$FORMGUIDE = cache_read('formguide.php');
$f = $FORMGUIDE[$formid];
$formname = $f['name'];
$templateid = $f['template'];
ob_start();
include template('formguide', $templateid);
$data = ob_get_contents();
ob_clean();
$file = PHPCMS_ROOT.'data/formguide/'.$formid.'.html';
$strlen = file_put_contents($file, $data);
@chmod($file,0777);
?>