<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>短消息管理</caption>
    <tr align="center">
		<th width="5%"><strong>选中</strong></th>
        <th width="5%"><strong>ID</strong></th>
    	<th width="20%"><strong>发信人</strong></th>
        <th width="*"><strong>标题</strong></th>
        <th width="20%"><strong>发信时间</strong></th>
        <th width="10%"><strong>回复数</strong></th>
    </tr>
   	<?php if(is_array($arr_message)){
		foreach ($arr_message as $msg) { ?>
    <tr>
    	<td class="align_c"><input type="checkbox" id="checkbox" name="del_msgid[]" value="<?=$msg['messageid']?>" /></td>
        <td class="align_c"><?=$msg['messageid']?></td>
        <td title="<?=$msg['msgfromname']?>" class="align_c"><a href="<?=member_view_url($msg['send_from_id'])?>"><?=$msg['msgfromname']?></a></td>
        <td title="消息正文：<?=str_cut($msg['content'], 100)?>"><?=$msg['subject']?></td>
        <td title="<?=$msg['date']?>" class="align_c"><?=$msg['date']?></td>
        <td class="align_c"><?=$msg['num_reply']?>次</td>
    </tr>
    <?php } }?>
</table>
<div class="button_box">
	<input name='chkall' type='button' id='chkall' value='全选' onClick="checkall()" />
  	<input type="submit" name="dosubmit" value="删除" onClick="if(confirm('确认批量删除这些消息吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&dosubmit=1'">
</div>
</form>
<?php if($pages) { echo "<div id=\"pages\">$pages</div>";}?>

<table cellpadding="0" cellspacing="1" class="table_form">
<form method="post" name="search" action="">
  <caption>短消息搜索</caption>
  <tr>
     <th width="8%"><strong>用户名</strong></th>
     <td width="12%"><?=form::text($name='username', $id = 'username', $username, $type = 'text', $size = 12, $class = '', $ext = '')?></td>
	<th><strong>消息标题</strong></th>
	<td width="12%"><?=form::text($name='subject', $id = 'subject', $subject, $type = 'text', $size = 12, $class = '', $ext = '')?></td>
  	 <th><strong>起始时间</strong></th>
     <td><?=form::date($name='datestart', $datestart, 0)?>至 <?=form::date($name='dateend', $dateend, 0)?></td> 

  <input name='mod' type='hidden' value='<?=$mod?>' />
<input name='file' type='hidden' value='<?=$file?>' />
<input name='action' type='hidden' value='<?=$action?>' />
    <td><input name='search' class="button_style" type='submit' value=' 搜索 ' /></td>
  </tr>
  </form>
</table>
</body>
</html>