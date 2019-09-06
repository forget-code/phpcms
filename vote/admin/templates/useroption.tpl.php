<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>用户列表  (<?=$option?>)</caption>
<tr>
    <th>用户名</th>
    <th>投票信息</th>
</tr>

<?php
foreach($user_lists as $key=>$data)
{
       extract($data);
       if($userinfo) eval("\$userinfo = $userinfo ;");
?>
<tr>
    <td>
    <?php if($userid){ ?>
    <a title="查看<?=$username?>的信息" href="?mod=member&file=member&action=view&userid=<?=$userid?>"><?=$username?></a>
    <?php } else { ?>
        游客
    <?php } ?>
    </td>
    <td>
    <?php
    foreach($userinfo as $key=>$val){
    ?>
    <?=$LANG[$key]?>:<?=$val?><br />
    <?php
    }
    ?>
    </td>
</tr>
<?php
}
?>
</table>
<?=$pages?>
</body>
</html>