<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>

<table cellpadding="0" cellspacing="1"  class="table_list" id="table">
<caption>投票人列表 (投票主题:<?=$title?>)</caption>
<tr>
	<th>用户名</th>
	<th>投票时间</th>
	<th>IP</th>
	<th>投票人资料</th>
</tr>
<?php
foreach($user_lists as $dataid=>$data){
extract($data);
if($userinfo)  eval("\$userinfo=$userinfo;") ;
?>
<tr>
	<td class="align_c"><a title="点击查看<?=$username?>的投票清单" href="?mod=vote&file=vote&action=user_detail&dataid=<?=$dataid?>&subjectid=<?=$subjectid?>&time=<?=$time?>"><?=$username?$username:'游客'?></a>
    <?php
    if($userid){
    ?><a href="?mod=member&file=member&action=view&userid=<?=$userid?>&time=<?=$time?>" title="查看<?=$username?>的信息"> | 会员信息</a>
    <?php
    }
    ?>
    </td>
	<td class="align_c"><?=date('Y-m-d H:I:s',$time)?></td>
	<td class="align_c"><?=$ip?></td>
    <td>
    <?php
    if(is_array($userinfo)){
        foreach($userinfo as $key=>$val){
            if($key=='sex') echo $val==1?'男':'女';
    ?>
    <?=$LANG[$key]?>:<?=$val?><br />
    <?php
        }
    }
    ?>
    </td>
</tr>
<?php
}
?>
</table>
<div id="pages"><?=$pages?></div>
</body>
</html>