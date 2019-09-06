<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style type="text/css">
<!--
* { padding:0; margin:0;}
body { padding:0; font-size:12px; color: black;	line-height: 150%; background-color: white;}
a:link, a:visited { text-decoration:none; color:#5097D8;}
a:hover, a:active { text-decoration:underline;}
a.orange:link, a.orange:visited { text-decoration:none;	color:orange;}
a.orange:hover, a.orange:active { text-decoration:underline;}
ul li {	list-style:none; margin:5px 0;}
img { border-width:0;}
.font_arial { font-family:Arial, Helvetica;}
.bdr{border:1px solid #b4d3ef; clear:both;}
#admin_main{ padding:0 10px;}
caption{*margin-top:10px; line-height:25px; height:25px; text-align:left; padding-left:14px;}
caption,#admin_main h3 { border:1px solid #99d3fb; border-bottom-width:0; color:#077ac7; background:url(admin/skin/images/bg_table.jpg) repeat-x 0 0; height:27px; line-height:27px; margin:10px auto 0; font-size:12px; font-family:"宋体"}
caption{border-bottom:1px solid #99d3fb !important; border:1px solid #99d3fb; border-bottom-width:0; font-weight:bold; }
caption span{float:right; padding-right:10px;}
table{background:#99d3fb; margin-top:-5px !important; margin-top:10px; width:100%;}
td{background:#fff;}
th,td{line-height:24px; text-align:center; color:#5097D8;}
th{ font-size:12px; background: url(admin/skin/images/bg_table.jpg) repeat-x 0 -26px; line-height:22px; height:24px !important; height:22px; font-weight:bold;}
#admin_main_2_1 {width:48%; float:left;}
#admin_main_2_1 p { border-bottom:1px dotted #b4d3ef; margin:10px auto;	text-align:left; padding:0 10px 10px; color:#5097D8;	line-height:22px;}
#admin_main_2_2 { float:left; margin-left:1.5%; width:48%;}
#admin_main_2_2 li,#admin_main_2_1 li { background:#fff url(admin/skin/images/list_bg.gif) no-repeat 5px 8px;}
#admin_main_2_2 { float:left; margin-left:1.5%; width:48%;}
.ad { text-align:center; margin:10px auto;}
.c_orange { color:orange;}
-->
</style>
<body onLoad="$.get('?mod=phpcms&file=memo&action=get', function(data){$('#memo_mtime').html(data.substring(0, 19));$('#memo_data').val(data.substring(19));}); ">
<div id="admin_main">
  <div id="admin_main_2_1">
    <h3>我的个人信息</h3>
    <div class="bdr">
		<!--管理员基本信息-->
		<p>您好，<a href="<?=space_url($_userid)?>"><strong><span class="font_arial" style="color:#690"><?=$_username?></span></strong></a><br />
		   角色：<?php foreach($_roleid as $roleid) echo $ROLE[$roleid].' ';?><br />
		  <?php if(isset($MODULE['message'])){ ?>您有 <a href="<?=$MODULE['message']['url']?>inbox.php?userid=<?=$_userid?>" class="orange"><strong class="c_orange"><?=$msg_new?></strong></a> 条未读短消息，<a href="<?=$MODULE['message']['url']?>inbox.php?userid=<?=$_userid?>" class="orange email">收件箱（<strong class="c_orange"><?=$msg_inbox?></strong>）</a></p><?php } ?>
		<p>
		  登录时间：<?=date('Y-m-d H:i:s')?><br />
		  登 录 IP：<?=$lastloginip?> <br />
		  登录次数：<?=$logintimes?> 次
		</p>
    </div>

	<table cellpadding="0" cellspacing="1">
	<caption>网站统计信息</caption>
		<tr>
			<th>统计</th>
			<th>信息</th>
			<th>会员</th>
			<?php if(isset($MODULE['comment'])){ ?><th>评论</th><?php } ?>
			<?php if(isset($MODULE['guestbook'])){ ?><th>留言</th><?php } ?>
			<?php if(isset($MODULE['order'])){ ?><th>订单</th><?php } ?>
			<th>栏目</th>
			<th>在线</th>
		</tr>
		<tr>
			<td>总数</td>
			<td><?=$stat->count('content')?></td>
			<td><?=$stat->count('member')?></td>
			<?php if(isset($MODULE['comment'])){ ?><td><?=$stat->count('comment')?></td><?php } ?>
			<?php if(isset($MODULE['guestbook'])){ ?><td><?=$stat->count('guestbook')?></td><?php } ?>
			<?php if(isset($MODULE['order'])){ ?><td><?=$stat->count('order')?></td><?php } ?>
			<td><?=$stat->count('category')?></td>
			<td><?=$stat->count('session')?></td>
		</tr>
		<tr>
			<td>今日</td>
			<td><?=$stat->count('content', 'inputtime', 'today')?></td>
			<td><?=$stat->count('member_info', 'regtime', 'today')?></td>
			<?php if(isset($MODULE['comment'])){ ?><td><?=$stat->count('comment', 'addtime', 'today')?></td><?php } ?>
			<?php if(isset($MODULE['guestbook'])){ ?><td><?=$stat->count('guestbook', 'addtime', 'today')?></td><?php } ?>
			<?php if(isset($MODULE['order'])){ ?><td><?=$stat->count('order', 'time', 'today')?></td><?php } ?>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>昨日</td>
			<td><?=$stat->count('content', 'inputtime', 'yesterday')?></td>
			<td><?=$stat->count('member_info', 'regtime', 'yesterday')?></td>
			<?php if(isset($MODULE['comment'])){ ?><td><?=$stat->count('comment', 'addtime', 'yesterday')?></td><?php } ?>
			<?php if(isset($MODULE['guestbook'])){ ?><td><?=$stat->count('guestbook', 'addtime', 'yesterday')?></td><?php } ?>
			<?php if(isset($MODULE['order'])){ ?><td><?=$stat->count('order', 'time', 'yesterday')?></td><?php } ?>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>本周</td>
			<td><?=$stat->count('content', 'inputtime', 'week')?></td>
			<td><?=$stat->count('member_info', 'regtime', 'week')?></td>
			<?php if(isset($MODULE['comment'])){ ?><td><?=$stat->count('comment', 'addtime', 'week')?></td><?php } ?>
			<?php if(isset($MODULE['guestbook'])){ ?><td><?=$stat->count('guestbook', 'addtime', 'week')?></td><?php } ?>
			<?php if(isset($MODULE['order'])){ ?><td><?=$stat->count('order', 'time', 'week')?></td><?php } ?>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>本月</td>
			<td><?=$stat->count('content', 'inputtime', 'month')?></td>
			<td><?=$stat->count('member_info', 'regtime', 'month')?></td>
			<?php if(isset($MODULE['comment'])){ ?><td><?=$stat->count('comment', 'addtime', 'month')?></td><?php } ?>
			<?php if(isset($MODULE['guestbook'])){ ?><td><?=$stat->count('guestbook', 'addtime', 'month')?></td><?php } ?>
			<?php if(isset($MODULE['order'])){ ?><td><?=$stat->count('order', 'time', 'month')?></td><?php } ?>
			<td></td>
			<td></td>
		</tr>
	</table>
    <div id="phpcms_notice"></div>
	<table cellpadding="0" cellspacing="1">
	<caption>Phpcms 开发团队</caption>
		<tr>
			<td width="100" class="align_r">总架构</td>
			<td class="align_l">钟胜辉</td>
		</tr>
		<tr>
			<td class="align_r">程序开发</td>
			<td class="align_l">王参加 司天宇 邹智海 陈周瑜 陈学旺</td>
		</tr>
		<tr>
			<td class="align_r">UI设计</td>
			<td class="align_l">康凯军</td>
		</tr>
		<tr>
			<td class="align_r">官方网站</td>
			<td class="align_l"><a href="http://www.phpcms.cn/" target="_blank">http://www.phpcms.cn/</a></td>
		</tr>
	</table>

  </div>
  <div id="admin_main_2_2">
    <h3><span id="memo_mtime" style="float:right; padding-right:10px;"></span>我的备忘录</h3>
    <div class="bdr"><textarea name="data" id="memo_data" class="inputtext" style="height:170px;width:99%;margin:5px; padding:5px" onblur='$.post("?mod=phpcms&file=memo&action=set", { data: this.value }, function(data){$("#memo_mtime").html(data);});'></textarea></div>
	<table cellpadding="0" cellspacing="1">
	<caption>安全小卫士</caption>
	<?php if(DEBUG) {?>
		<tr>
			<td class="align_l"><font color="red">网站上线后，建议关闭 DEBUG （前台SQL错误提示）</font> <BR>方法：打开文件 include/config.inc.php
设置此项 define('DEBUG', <font color="red">0</font>);</td>
		</tr>
	<?php }
	if(FILE_MANAGER) {?>
		<tr>
			<td class="align_l"><font color="red">建议关闭 FILE_MANAGER （文件管理器）</font> <BR>方法：打开文件 include/config.inc.php
设置此项 define('FILE_MANAGER', '<font color="red">0</font>');</td>
		</tr>
	<?php } 
	if(ACTION_TEMPLATE) {?>
		<tr>
			<td class="align_l"><font color="red">建议关闭 ACTION_TEMPLATE （在线编辑模板）</font> <BR>方法：打开文件 include/config.inc.php
设置此项 define('ACTION_TEMPLATE', '<font color="red">0</font>');</td>
		</tr>
	<?php }
	if(EXECUTION_SQL) {?>
		<tr>
			<td class="align_l"><font color="red">建议关闭 EXECUTION_SQL （执行SQL）</font> <BR>方法：打开文件 include/config.inc.php
设置此项 define('EXECUTION_SQL', '<font color="red">0</font>');</td>
		</tr>
	<?php } 
	if(@file_exists(PHPCMS_ROOT.'install/modules.inc.php')) {?>
		<tr>
			<td class="align_l"><font color="red">建议从空间删除安装文件目录 install/ </font></td>
		</tr>
	<?php } ?>
	</table>

	<table cellpadding="0" cellspacing="1">
	<caption>Phpcms 授权信息</caption>
		<tr>
			<td width="60" class="align_r">版本号</td>
			<td class="align_l">Phpcms <?=PHPCMS_VERSION?>（<?=PHPCMS_RELEASE?>）</td>
		</tr>
		<tr>
			<td class="align_r">授权类型</td>
			<td class="align_l" id="phpcms_license"></td>
		</tr>
		<tr>
			<td class="align_r">序列号</td>
			<td class="align_l" id="phpcms_sn"></td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="1">
	<caption>会员模型统计信息</caption>
		<tr>
			<th>统计</th>
			<th>总数</th>
			<th>今日</th>
			<th>昨日</th>
			<th>本周</th>
			<th>本月</th>

		</tr>	
		<?php 
		ksort($MODEL);
		foreach($MODEL as $modelid=>$model)
		{
			if($model['modeltype'] == 0) continue;
		?>
		<tr>
			<td><a href="?mod=member&file=member&action=manage&modelid=<?=$modelid?>"><?=$model['name']?></a></td>
			<td><?=$stat->count_member("`modelid`=$modelid")?></td>
			<td><?=$stat->count('member_info', 'regtime', 'today',array(DB_PRE."member_cache",'userid',"a.userid=m.userid AND m.`modelid`=$modelid"))?></td>
			<td><?=$stat->count('member_info', 'regtime', 'yesterday',array(DB_PRE."member_cache",'userid',"a.userid=m.userid AND m.`modelid`=$modelid"))?></td>
			<td><?=$stat->count('member_info', 'regtime', 'week',array(DB_PRE."member_cache",'userid',"a.userid=m.userid AND m.`modelid`=$modelid"))?></td>
			<td><?=$stat->count('member_info', 'regtime', 'month',array(DB_PRE."member_cache",'userid',"a.userid=m.userid AND m.`modelid`=$modelid"))?></td>
		</tr>
		<?php
		}
		?>
	</table>

	<table cellpadding="0" cellspacing="1">
	<caption>会员组统计信息</caption>
		<tr>
			<th>统计</th>
			<th>总数</th>
			<th>今日</th>
			<th>昨日</th>
			<th>本周</th>
			<th>本月</th>

		</tr>
		
	<?php 
		ksort($GROUP);
		foreach($GROUP as $groupid=>$groupname)
		{
	?>
		<tr>
			<td><a href="?mod=member&file=member&action=manage&groupid=<?=$groupid?>"><?=$groupname?></a></td>	
			<td><?=$stat->count_member("`groupid`=$groupid")?></td>
			<td><?=$stat->count('member_info', 'regtime', 'today',array(DB_PRE."member_cache",'userid',"a.userid=m.userid AND m.`groupid`=$groupid"))?></td>
			<td><?=$stat->count('member_info', 'regtime', 'yesterday',array(DB_PRE."member_cache",'userid',"a.userid=m.userid AND m.`groupid`=$groupid"))?></td>
			<td><?=$stat->count('member_info', 'regtime', 'week', array(DB_PRE."member_cache",'userid',"a.userid=m.userid AND m.`groupid`=$groupid"))?></td>
			<td><?=$stat->count('member_info', 'regtime', 'month',array(DB_PRE."member_cache",'userid',"a.userid=m.userid AND m.`groupid`=$groupid"))?></td>
		</tr>
	<?php
		}
	?>
	</table>
  </div>
</div>
<?php 
if($_message) 
{
?> 
	<bgsound src="images/message.wav" id="message_sound" > 
<?php }
?>
<script type="text/javascript" src="<?=$notice_url?>"></script>
</body>
</html>