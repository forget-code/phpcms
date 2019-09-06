<?php
$modtitle[$mod] = "邮件订阅";
$menu[$mod][] = array("邮件订阅分类","?mod=phpcms&file=type&action=manage&keyid=$mod");
$menu[$mod][] = array("邮件内容管理","?mod=".$mod."&file=subscription&action=manage");
$menu[$mod][] = array("订阅email列表","?mod=".$mod."&file=email&action=manage");
$menu[$mod][] = array('发送订阅邮件','?mod='.$mod.'&file=subscription&action=send');
$menu[$mod][] = array("邮件列表管理","?mod=".$mod."&file=maillist&action=manage");
$menu[$mod][] = array('手动发送邮件接口','?mod='.$mod.'&file=send&type=2');
$menu[$mod][] = array('模块配置','?mod='.$mod.'&file=setting');
$menu[$mod][] = array('系统发送邮件配置','?mod=phpcms&file=setting&tab=5');

?>