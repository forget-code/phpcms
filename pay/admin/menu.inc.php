<?php
$modtitle[$mod] = '支付管理';

$menu[$mod][] = array('添加财务记录', '?mod='.$mod.'&file=pay&action=add');
$menu[$mod][] = array('财务流水', '?mod='.$mod.'&file=pay&action=list');
$menu[$mod][] = array('充值卡管理', '?mod='.$mod.'&file=paycard&action=manage');
$menu[$mod][] = array('在线支付', '?mod='.$mod.'&file=payonline&action=manage');
$menu[$mod][] = array('用户交易记录', '?mod='.$mod.'&file=exchange');
$menu[$mod][] = array('点数购买设置', '?mod='.$mod.'&file=point');
$menu[$mod][] = array('有效期购买设置', '?mod='.$mod.'&file=time');
$menu[$mod][] = array('积分换点数设置', '?mod='.$mod.'&file=credit2point');
$menu[$mod][] = array('积分换有效期设置', '?mod='.$mod.'&file=credit2time');
$menu[$mod][] = array('支付配置', '?mod='.$mod.'&file=setting');
?>