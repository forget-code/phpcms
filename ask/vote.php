<?php
require './include/common.inc.php';

require_once MOD_ROOT.'include/answer.class.php';
$answer = new answer();

$infos = $answer->vote_result($id);
$num = count($infos);
include template('ask', 'view_vote');
?>