<?php
defined('IN_PHPCMS') or exit('Access Denied');

$filename = PHPCMS_ROOT.'/data/js.php';
$data = "<?php\nchdir('../ads/');\nrequire './ad.php';\n?>";
file_put_contents($filename, $data);
@chmod($filename, 0777);
?>