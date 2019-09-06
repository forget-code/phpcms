<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="4"><?=$username?> 的基本资料</th>
  </tr>
<tr>
<td width="15%" class="tablerowhighlight" align="right">用 户 名：</td>
<td width="35%" class="tablerow"><?=$username?></td>
<td width="15%" class="tablerowhighlight" align="right">E-MAIL：</td>
<td width="35%" class="tablerow"><a href="<?=$MODULE['mail']['linkurl']?>sendmail.php?mailto=<?=$email?>" title="点击发送Email" target="_blank"><?=$email?></a></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">会 员 组：</td>
<td  class="tablerow"><?=$groupname?>（<?php echo $arrgroupname;?>）</td>
<td  class="tablerowhighlight" align="right">计费方式：</td>
<td  class="tablerow"><?=$chargetype ? '有效期' : '扣点'?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">资金余额：</td>
<td  class="tablerow"><?=$money?>元</td>
<td  class="tablerowhighlight" align="right">消费金额：</td>
<td  class="tablerow"><?=$payment?>元</td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">可用点数：</td>
<td  class="tablerow"><?=$point?>点</td>
<td  class="tablerowhighlight" align="right">可用积分：</td>
<td  class="tablerow"><?=$credit?>分</td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">服务起始日期：</td>
<td  class="tablerow"><?=$begindate?></td>
<td  class="tablerowhighlight" align="right">服务截止日期：</td>
<td  class="tablerow"><?=($enddate == '0000-00-00' ? '无限期' : $enddate)?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">发布特权：</td>
<td  class="tablerow"><?=$enableaddalways ? '是' : '否'?></td>
<td  class="tablerowhighlight" align="right">购买折扣：</td>
<td  class="tablerow"><?=$discount?>%</td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">注册时间：</td>
<td  class="tablerow"><?=date('Y-m-d h:i:s',$regtime)?></td>
<td  class="tablerowhighlight" align="right">注册IP：</td>
<td  class="tablerow"><?=$regip?> - <?=$regiparea?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">最后登录时间：</td>
<td  class="tablerow"><?=$lastlogintime ? date('Y-m-d h:i:s',$lastlogintime) : ''?></td>
<td  class="tablerowhighlight" align="right">最后登录IP：</td>
<td  class="tablerow"><?=$lastloginip?> - <?=$lastloginiparea?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">登录次数：</td>
<td  class="tablerow"><?=$logintimes?>次</td>
<td  class="tablerowhighlight" align="right">当前状态：</td>
<td  class="tablerow"></td>
</tr>
  <tr>
    <th colspan=4><?=$username?> 的详细资料</th>
  </tr>
<tr>
<td  class="tablerowhighlight" align="right">真实姓名：</td>
<td  class="tablerow"><?=$truename?></td>
<td  class="tablerowhighlight" align="right">性别：</td>
<td  class="tablerow"><?=$genders[$gender]?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">生日：</td>
<td  class="tablerow"><?=$birthday?></td>
<td  class="tablerowhighlight" align="right">年龄：</td>
<td  class="tablerow"><?=$old?>岁</td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">证件类型：</td>
<td  class="tablerow"><?=$idtype?></td>
<td  class="tablerowhighlight" align="right">证件号码：</td>
<td  class="tablerow"><?=$idcard?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">所在地区：</td>
<td  class="tablerow"><?=$province?>-<?=$city?>-<?=$area?></td>
<td  class="tablerowhighlight" align="right">所属行业：</td>
<td  class="tablerow"><?=$industry?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">教育水平：</td>
<td  class="tablerow"><?=$edulevel?></td>
<td  class="tablerowhighlight" align="right">职    业：</td>
<td  class="tablerow"><?=$occupation?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">收入状况：</td>
<td  class="tablerow"><?=$income?></td>
<td  class="tablerowhighlight" align="right">电话：</td>
<td  class="tablerow"><?=$telephone?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">手机：</td>
<td  class="tablerow"><?=$mobile?></td>
<td  class="tablerowhighlight" align="right">地址：</td>
<td  class="tablerow"><?=$address?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">邮编：</td>
<td  class="tablerow"><?=$postid?></td>
<td  class="tablerowhighlight" align="right">主页：</td>
<td  class="tablerow"><a href="<?=$homepage?>" target="_blank"><?=$homepage?></a></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">QQ：</td>
<td  class="tablerow"><a href="http://wpa.qq.com/msgrd?V=1&Uin=<?=$qq?>&Site=<?=$PHP_DOMAIN?>&Menu=yes" title="点击QQ交谈" target="_blank"><?=$qq?></a></td>
<td  class="tablerowhighlight" align="right">MSN：</td>
<td  class="tablerow"><?=$msn?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">ICQ：</td>
<td  class="tablerow"><?=$icq?></td>
<td  class="tablerowhighlight" align="right">Skype：</td>
<td  class="tablerow"><?=$skype?></td>
</tr>
<tr>
<td  class="tablerowhighlight" align="right">支付宝帐号：</td>
<td  class="tablerow"><?=$alipay?></td>
<td  class="tablerowhighlight" align="right">贝宝帐号：</td>
<td  class="tablerow"><?=$paypal?></td>
</tr>
  <tr>
    <th colspan=4><?=$username?> 的其他资料</th>
  </tr>
<?=$fields?>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <td height="30" align="center">
	<input type="button" name="edit" value="修改资料" onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=edit&userid=<?=$userid?>'"> &nbsp;&nbsp;
	<input type="button" name="edit" value="个人文集" onclick="window.open('<?=$MOD['linkurl']?>member.php?username=<?=urlencode($username)?>')"> &nbsp;&nbsp;
	<input type="button" name="edit" value="入款" onclick="window.location='?mod=pay&file=pay&action=add&typeid=1&username=<?=$username?>&forward=<?=urlencode($PHP_URL)?>'"> &nbsp;&nbsp;
	<input type="button" name="edit" value="扣款" onclick="window.location='?mod=pay&file=pay&action=add&typeid=2&username=<?=$username?>&forward=<?=urlencode($PHP_URL)?>'"> &nbsp;&nbsp;
	<input type="button" name="edit" value="财务记录" onclick="window.location='?mod=pay&file=pay&action=list&username=<?=$username?>&forward=<?=urlencode($PHP_URL)?>'"> &nbsp;&nbsp;
	</td>
  </tr>
</table>
</body>
</html>
