<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="get" action="?">
<input name="mod" type="hidden" size="15" value="<?=$mod?>">
<input name="file" type="hidden" size="15" value="<?=$file?>">
<input name="action" type="hidden" size="15" value="delete">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>日志删除</caption>
  <tr>
    <td>
模块：<select name="module">
<option value=''>不限</option>
<?php 
if(is_array($MODULE)){
	foreach($MODULE as $k=>$m){
		$selected = $module==$k ? "selected" : "";
    	echo "<option value='".$k."' $selected>".trim($m['name'])."</option>\n";
    }
}
?>
</select>
&nbsp;&nbsp;
起始日期：<?=form::date('fromdate', $fromdate)?>
&nbsp;&nbsp;
截止日期：<?=form::date('todate', $todate)?>
&nbsp;&nbsp;
<input type="submit" value=" 删除日志 ">
&nbsp;&nbsp;
<input type="button" value=" 全部清空 " onClick="redirect('?mod=<?=$mod?>&file=<?=$file?>&action=clear')">
	</td>
  </tr>
</table>
</form>

<form method="get" action="?">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>日志搜索</caption>
<tr>
    <th><strong>模块</strong></th>
    <th><strong>文件</strong></th>
    <th><strong>操作</strong></th>
    <th><strong>URL</strong></th>
    <th><strong>用户名</strong></th>
    <th><strong>IP</strong></th>
    <th><strong>起始日期</strong></th>
    <th><strong>截止日期</strong></th>
    <th><strong>查询</strong></th>
</tr>
  <tr>
    <td>
	<input name="mod" type="hidden" size="15" value="<?=$mod?>">
	<input name="file" type="hidden" size="15" value="<?=$file?>">
	<input name="action" type="hidden" size="15" value="<?=$action?>">
<select name="s_module">
<option value=''>不限</option>
<?php 
if(is_array($MODULE)){
	foreach($MODULE as $module=>$m){
		$selected = $s_module==$module ? "selected" : "";
    	echo "<option value='".$module."' $selected>".trim($m['name'])."</option>\n";
    }
}
?>
</select>
	</td>
    <td><input name="s_file" size="12" value="<?=$s_file?>"></td>
    <td><input name="s_action" size="12" value="<?=$s_action?>"></td>
    <td><input name="s_url" size="15" value="<?=$s_url?>"></td>
    <td><input name="s_username" size="12" value="<?=$s_username?>"></td>
    <td><input name="s_ip" size="12" value="<?=$s_ip?>"></td>
    <td><?=form::date('s_fromdate', $s_fromdate)?></td>
    <td><?=form::date('s_todate', $s_todate)?></td>
    <td>
	<input type="submit" value=" 查询 ">
	</td>
  </tr>
</table>
</form>
<table cellpadding="0" cellspacing="1" class="table_list">
  <tr>
    <caption><?=$username?> 日志记录</caption>
  </tr>
    <tr>
        <th width="5%"><strong>ID</strong></th>
        <th width="10%"><strong>用户名</strong></th>
        <th width="15%"><strong>模块</strong></th>
        <th><strong>文件</strong></th>
        <th><strong>操作</strong></th>
        <th><strong>URL</strong></th>
        <th><strong>时间</strong></th>
        <th><strong>IP</strong></th>
    </tr>
<?php 
if(is_array($data)){
	foreach($data as $r){
?>
    <tr>
        <td><?=$r['logid']?></td>
        <td><a href="<?=member_view_url($r['userid'])?>"><?=$r['username']?></a></td>
        <td><?=$r['module']?></td>
        <td><?=$r['file']?></td>
        <td><?=$r['action']?></td>
        <td align="left" title="<?=$r['querystring']?>"><?=str_cut($r['querystring'], 40)?></td>
        <td><?=$r['time']?></td>
        <td><a href="<?=ip_url($r['ip'])?>"><?=$r['ip']?></a></td>
    </tr>
<?php 
	}
}
?>
</table>
<div id="pages"><?=$log->pages?></div>
</body>
</html>