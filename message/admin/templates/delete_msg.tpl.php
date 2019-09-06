<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>统计信息</caption>
    <tr>
    	<th width="10%" class="align_c"><strong>统计</strong></th>
		<th width="40%" title="收件箱短信数"><strong>收件箱短信数</strong></th>
        <th width="40%" title="发件箱短信数"><strong>发件箱短信数</strong></th>
    </tr>
    <tr>
    	<td class="align_c">今日</td>
        <td class="align_c"><?=$stat->count('message', 'message_time', 'today', "folder='inbox'")?></td>
        <td class="align_c"><?=$stat->count('message', 'message_time', 'today', "folder='outbox'")?></td>
    </tr>
    <tr>
    	<td class="align_c">昨日</td>
        <td class="align_c"><?=$stat->count('message', 'message_time', 'yesterday', "folder='inbox'")?></td>
        <td class="align_c"><?=$stat->count('message', 'message_time', 'yesterday', "folder='outbox'")?></td>
    </tr>
     <tr>
    	<td class="align_c">本周</td>
        <td class="align_c"><?=$stat->count('message', 'message_time', 'week', "folder='inbox'")?></td>
        <td class="align_c"><?=$stat->count('message', 'message_time', 'week', "folder='outbox'")?></td>
    </tr>
     <tr>
    	<td class="align_c">本月</td>
        <td class="align_c"><?=$stat->count('message', 'message_time', 'month', "folder='inbox'")?></td>
        <td class="align_c"><?=$stat->count('message', 'message_time', 'month', "folder='outbox'")?></td>
    </tr>
    <tr>
    	<td class="align_c">总共</td>
    	<td class="align_c"><?=$num_inbox?></td>
        <td class="align_c"><?=$num_outbox?></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>删除操作</caption>
    <form name="delete" action="" method="post">
    <tr>
    	<th><strong>按时间删除</strong></th>
 		<td><?=form::select($del_from_array, 'time', 'time')?>&nbsp;<input type="submit" class="button_style" name="dosubmit" value="提交" ></td>
    </tr>
    <input name='mod' type='hidden' value='<?=$mod?>'>
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='action' type='hidden' value='<?=$action?>'>
    </form>
</table>
</body>
</html>