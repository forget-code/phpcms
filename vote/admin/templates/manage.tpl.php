<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
$type = $survey ? '答卷' : '投票';
?>
<body>
<?=$menu?>
<form method="post" name="myform" id="myform">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$type?>管理</caption>
<tr>
<th class="align_c">选中</th>
<th class="align_c">标题</th>
<th class="align_c">开始时间</th>
<th class="align_c">结束时间</th>
<th class="align_c">发表时间</th>
<th style="text-align:center;width:330px;">管理操作</th>
</tr>
<?php
$votes = is_array($votes) ? $votes : array();
foreach($votes as $vote) {
?>
<tr align="center" tag="hover">
    <td><input type="checkbox" name="subjectids[]"  id="subjectid" value="<?=$vote['subjectid']?>" boxid="selectall"></td>
    <td class="align_left">
    <a href="<?=PHPCMS_PATH?>vote/vote.php?voteid=<?=$vote['subjectid']?>" target="_blank">
	<?=$vote['subject']?> <?php if($vote['enabled']==0) {?><font color='red'>锁定</font><? }?>
    <?=$vote['ismultiple']?'[多]':''?>
    </a>
    </td>
    <td class="align_c"><?=$vote['fromdate']?></td>
    <td class="align_c"><?=$vote['todate']?></td>
    <td class="align_c"><?=date('Y-m-d H:i',$vote['addtime'])?></td>
    <td class="align_c">
    <a href='?mod=vote&file=vote&action=detail&subjectid=<?=$vote['subjectid']?>&keyid=<?=$keyid?>' title="统计">统计</a> |
    <a href='?mod=vote&file=vote&action=edit&subjectid=<?=$vote['subjectid']?>&keyid=<?=$keyid?>&survey=<?=$survey?>' title="编辑">编辑</a> |
    <a href="javascript:resetData('?mod=vote&file=vote&action=reset_data&subjectid=<?=$vote['subjectid']?>&keyid=<?=$keyid?>')">重置</a>
    <?php
	if($vote['ismultiple']){
	?>| <a href="?mod=vote&file=vote&action=edit_subject&subjectid=<?=$vote['subjectid']?>">主题列表</a>
    <?php
	}?>
    | <a href='?mod=vote&file=vote&action=getcode&voteid=<?=$vote['subjectid']?>&keyid=<?=$keyid?>&templateid=<?=$vote['templateid']?>&survey=<?=$survey?>' title="js调用">获取调用代码</a>
    <?php if($vote['enabled']){ ?>
     | <a href='?mod=vote&file=vote&action=pass&passed=0&keyid=<?=$keyid?>&subjectids=<?=$vote['subjectid']?>' title="禁用">禁用</a><?php }?>
    </td>
</tr>
<?php
}
?>
</table>
<div class="button_box">
<input name='chkall' type='button' id='selectall' onClick="javascript: CheckedRev();" value='全选'>
<input name='submit2' type='submit' value='批准选定的投票' onClick="document.myform.action='?mod=vote&file=vote&action=pass&passed=1&keyid=<?=$keyid?>'">&nbsp;&nbsp;


<input name="submit1" type="submit"  value="删除选定的投票" onClick="$('#myform').get(0).action='?mod=vote&file=vote&action=delete&keyid=<?=$keyid?>'">
</div>
</form>
<div id="pages"><?=$pages?></div>

<script type="text/javascript" language="JavaScript">
function del_customer()
{
	var mycoler = document.getElementsByName("subjectids[]");
	var flag = false;
	for(var i = 0; i< mycoler.length ;i++){
		if(mycoler[i].checked){
			flag = true;
			break;
		}
	}
	if(!flag){
		alert("请选择要删除的对象");
		return false;
	}
	var msg = "你真的要删除吗!!!";
	if(! window.confirm(msg)){
		return false;
	}
	document.getElementsByName("thisForm").submit();
}

function CheckedRev(){
	var arr = $(':checkbox');
	for(var i=0;i<arr.length;i++)
	{
		if (arr[i].checked = ! arr[i].checked)
		{
			$("#selectall").val("取消全选");
		}else
		{
			$("#selectall").val("全选");
		}

	}
}

function resetData(url_addr){
	if(!confirm("将要清除此主题的所有投票记录!一旦确认,将无法恢复.\n\n确认要这样做吗?")) return ;
	$.ajax({
		type:'GET',
		url:url_addr,
		cache:false,
		success:function(data){
			if(data=='success'){
				alert('操作完成,数据已经清空.');
			} else {
				alert("请示失败!\n"+data);
			}
		}
	})
}
</script>
</body>
</html>