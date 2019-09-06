<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=useramount&action=check" name="theForm" >
<!--标签页-->
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>
  基本信息
  </caption>
  <tr>
    <th width="25%"><strong>会员名称：</strong></th>
    <td width="75%"><?=$amount['username']?></td>
  </tr>
  <tr>
    <th><strong>金额：</strong>
    <td><?=$amount['amount']?></td>
  </tr>
  <tr>
    <th><strong>操作日期：</strong></th>
    <td><?=date('Y-m-d',$amount['addtime'])?></td>
  </tr>
  <tr>
    <th><strong>类型：</strong></th>
    <td><?if (!$amount['type']) {?>充值<?}else{?>其他<?}?></td>
  </tr>
  <tr>
    <th><strong>会员描述：</strong>
    <td><?=$amount['usernote']?></td>
  </tr>
  <tr>
    <th><strong>管理员备注：</strong>
    <td><?=$amount['adminnote']?></td>
  </tr>
  <tr>
  <tr>
    <th><strong>到款状态：</strong>
    <td><?php if($amount['ispay']) { ?>已确认<?php }else{?>未确认<?php } ?></td>
</table></form></body></html>