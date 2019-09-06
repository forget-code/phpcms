<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>日志搜索</th>
  </tr>
<tr align="center">
<td width="15%" class="tablerowhighlight">模块</td>
<td width="15%" class="tablerowhighlight">频道</td>
<td width="15%" class="tablerowhighlight">起始日期</td>
<td width="15%" class="tablerowhighlight">截止日期</td>
<td width="15%" class="tablerowhighlight">查询类型</td>
<td width="15%" class="tablerowhighlight">关键词</td>
<td width="10%" class="tablerowhighlight">查询</td>
</tr>
	<form method="get" action="?">
  <tr align="center">
    <td class="tablerow">
	<input name="mod" type="hidden" size="15" value="<?=$mod?>">
	<input name="file" type="hidden" size="15" value="<?=$file?>">
	<input name="action" type="hidden" size="15" value="<?=$action?>">
<select name="s_mod">
<option value=''>模块不限</option>
<?php 
if(is_array($MODULE)){
	foreach($MODULE as $module=>$m){
		$selected = $s_mod==$module ? "selected" : "";
    	echo "<option value='".$module."' $selected>".trim($m['name'])."</option>\n";
    }
}
?>
</select>
	</td>
    <td class="tablerow">
<select name="s_channelid">
<option value=''>频道不限</option>
<?php 
if(is_array($CHANNEL)){
	foreach($CHANNEL as $c){
		$selected = $s_channelid==$c['channelid'] ? "selected" : "";
        echo "<option value='".$c['channelid']."' $selected>".trim($c['channelname'])."</option>\n";
    }
}
?>
</select>
	</td>
    <td class="tablerow">
	<input name="s_fromdate" size="12" value="<?=$fromdate?>">
	</td>
    <td class="tablerow">
	<input name="s_todate" size="12" value="<?=$todate?>">
	</td>
    <td class="tablerow">
<select name="s_type">
<option value='username' <?php if($s_type=='username'){ ?>selected <?php } ?>>按用户名</option>
<option value='file' <?php if($s_type=='file'){ ?>selected <?php } ?>>按文件</option>
<option value='querystring' <?php if($s_type=='querystring'){ ?>selected <?php } ?>>按URL</option>
<option value='ip' <?php if($s_type=='ip'){ ?>selected <?php } ?>>按IP地址</option>
</select>
	</td>
    <td class="tablerow">
	<input name="keywords" size="15" value="<?=$keywords?>">
	</td>
    <td class="tablerow">
	<input type="submit" value=" 查询 ">
	</td>
  </tr>
	</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9>日志管理</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">ID</td>
<td width="10%" class="tablerowhighlight">用户名</td>
<td width="10%" class="tablerowhighlight">模块</td>
<td width="10%" class="tablerowhighlight">频道</td>
<td width="10%" class="tablerowhighlight">文件</td>
<td width="10%" class="tablerowhighlight">动作</td>
<td width="25%" class="tablerowhighlight">URL</td>
<td width="10%" class="tablerowhighlight">时间</td>
<td width="10%" class="tablerowhighlight">IP</td>
</tr>
<?php 
if(is_array($logs)){
	foreach($logs as $log){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$log['logid']?></td>
<td><?=$log['username']?></td>
<td><?=$log['mod']?></td>
<td><?=$log['channelid']?></td>
<td><?=$log['file']?></td>
<td><?=$log['action']?></td>
<td align="left"><?=$log['querystring']?></td>
<td><?=$log['addtime']?></td>
<td><?=$log['ip']?></td>
</tr>
<?php 
	}
}
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</body>
</html>