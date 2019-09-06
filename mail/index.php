<?php
require './include/common.inc.php';
if($_userid)
{
    header("Location: subscription.php?action=do&em=$em");
}
else
{
    header("Location: nosubscription.php?action=do&em=$em");
}
?>