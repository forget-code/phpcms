<?php
return array('trade_member'=>array('name'=>'交易记录', 'url'=>'?mod=pay&file=exchange&action=list&dosubmit=1', 'key'=>'username'),
			 'pay_member'=>array('name'=>'支付记录', 'url'=>'?mod=pay&file=payonline&action=list&ispay=-1&dosubmit=1', 'key'=>'username'),
			 'remit_member'=>array('name'=>'汇款记录', 'url'=>'?mod=pay&file=useramount&action=list&is_paid=-1&dosubmit=1', 'key'=>'username'),
			);
?>