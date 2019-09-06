<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
$type = $survey ? '答卷' : '投票';
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0"  class="table_form">
    <caption>获取调用代码 (<a style="color:#fff" href="<?-$M['url']?>vote.php?voteid=<?=$voteid?>" target="_blank"><?=$type?>页面预览</a>)</caption>
  <tr align=center>
    <td class="tablerowhighlight">(1) JS静态调用代码</td>
  </tr>
  <tr align=center>
    <td>
	<input name="script" type="text" size="100" value="<script language='javascript' src='<?=SITE_URL?>vote/data/vote_<?=$voteid?>.js'></script>" onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');" >
    </td>
  </tr>
  <tr align=center>
    <td class="tablerowhighlight">(2) JS动态调用代码 (推荐使用此种方式调用)</td>
  </tr>
  <tr align=center>
    <td>
	<input name="script" id="code2" type="text" size="100" value="<script language='javascript' src='<?=SITE_URL?>vote/vote.php?voteid=<?=$voteid?>&action=js'></script>" onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');" > 选择模板
    <?=form::select_template('vote', 'templateid', 'templateid2', '', '', 'vote');?>
    </td>
  </tr>
  <tr align=center>
    <td class="tablerowhighlight">(3) 标签调用代码 </td>
  </tr>
  <tr align=center>
    <td>
<input name="tag" id="code3" type="text" size="100" value="{php include_once PHPCMS_ROOT.'/vote/include/common.inc.php' ; echo vote('<?=$templateid?>',<?=$voteid?>);}" onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');" >

选择模板
    <?=form::select_template('vote', 'templateid', 'templateid3', '', '', 'vote');?>
</td>
  </tr>
    <!--tr align=center>
    <td class="tablerowhighlight">(4) HTML调用代码 (双击下面的文本框即可复制代码)</td>
  </tr>
  <tr align=center>
    <td>
<textarea name="tag" cols="100" rows="15" onDblClick="clipboardData.setData('text',this.value); alert('已复制到剪贴板!');">
<?=htmlspecialchars($voteform)?>
</textarea>
</td>
  </tr-->
</table>

<table cellpadding="2" cellspacing="1" border="0"  class="table_form">
    <caption><?=$type?>结果调用标签</caption>
    <tr>
    <td>
    <input type="text" id="code4" size="100" value="<script src='<?=SITE_URL?>vote/show.php?voteid=<?=$voteid?>&action=js'></script>">
     选择模板
    <?=form::select_template('vote', 'templateid', 'templateid4', '', '', 'vote');?>
    </td>
    </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0"  class="table_form">
    <caption>说明</caption>
    <tr>
    <td>
默认的vote.html : 在独立页面中显示一个投票页面 <br />
show.html : 在独立页面中显示投票结果 <br />
vote_submit.html :  如果投票表单要嵌入到其它页面中,请使用这个模板 <br />
vote_show.html   :  如果投票结果要嵌入到其它页面中显示, 请使用这个模板
    </td>
    </tr>
</table>

<script>
$('input,textarea').click(function(){
	this.select();
});

$('#templateid2').change(function () {
  var tpl = $(this).val() ;
  tpl = "<script language='javascript' src='<?=SITE_URL?>vote/vote.php?voteid=<?=$voteid?>&action=js&template="+tpl+"'><\/script>"
  $('#code2').val(tpl);
});

$('#templateid3').change(function () {
  var tpl = $(this).val() ;
  tpl = "{php include_once PHPCMS_ROOT.'/vote/include/common.inc.php' ; echo vote('"+tpl+"',<?=$voteid?>);}" ;
  $('#code3').val(tpl);
});

$('#templateid4').change(function () {
  var tpl = $(this).val() ;
  tpl = "<script src='<?=SITE_URL?>vote/show.php?voteid=<?=$voteid?>&action=js&template="+tpl+"'><\/script>" ;
  $('#code4').val(tpl);
});

</script>
</body>
</html>