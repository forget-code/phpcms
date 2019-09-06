<?php
require '../include/common.inc.php';
include PHPCMS_ROOT.'api/keyword.func.php';

echo get_keywords($data, $number);
?>