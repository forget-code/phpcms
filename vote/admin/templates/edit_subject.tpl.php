<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header','phpcms');
?>

<body>
<style>
p{
background-repeat:repeat-x;

}
</style>
<?php if(!empty($subjects)): ?>
<form id="list_form" action="?mod=<?=$mod?>&file=<?=$file?>&keyid=<?=$keyid?>&subjectid=<?=$sid?>&dosubmit=1" method="post" class="myform">
<table cellpadding="0" cellspacing="1" class="table_list">
<caption><?=$title?></caption>
	<tr>
    <th width="30">选择</th>
    <th width="60">ID</th>
    <th width="50">排序</th>
    <th>标题</th>
    <th width="100">添加时间</th>
    <th width="100">操作</th>
    </tr>
<?php
foreach($subjects as $sid=>$data)
{
?>
   	<tr tag="hover">
    <td><input type="checkbox" name="delsubject[<?=$sid?>]" value="<?=$sid?>" tag="delsubject"></td>
    <td class="align_c"><?=$sid?></td>
    <td class="align_c"><input type="text" size="4" name="subjectorder[<?=$sid?>]" value="<?=$data['listorder']?>"></td>
    <td><?=$data['subject']?></td>
    <td class="align_c"><?=date('Y-m-d H:i',$data['addtime'])?></td>
    <td class="align_c">
        <a href="?mod=<?=$mod?>&file=<?=$file?>&keyid=<?=$keyid?>&action=edit_option&subjectid=<?=$sid?>">编辑主题</a>
    </td>
    </tr>
<?php
}
?>
</table>
<div class="button_box">
        <input type="hidden" name="action" id="action" value="<?=$action?>">
        <input type="submit" value="更新排序" id="listorder">
        <input type="submit" value="删除选中的项目" id="del">
</div>
</form>
<?php endif; ?>
<form id="add_new" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&keyid=<?=$keyid?>&action=add&dosubmit=1" method="post">
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>新加投票主题</caption>
	<tr>
    <td>主题*</td>
    <td><input type="text" name="subject[subject]" size="70" require="true" datatype="require" msg="不能为空" /></td>
    </tr>
	<tr>
    <td>选项类型*</td>
    <td>
    <input type="radio" name="subject[ischeckbox]" value="0" alter="val" checked="checked"/>单选&nbsp;&nbsp;&nbsp;
    <input type="radio" name="subject[ischeckbox]" value="1" alter="val" />多选&nbsp;&nbsp;&nbsp;
    <span style="display:none" id="val">
    	最少选择<input type="text" name="subject[minval]" value="1" size="1" class="noime" />项&nbsp;&nbsp;
    	最多选择<input type="text" name="subject[maxval]" value="0" size="1" class="noime" />项&nbsp;&nbsp;    </span>    </td>
    </tr>
    <tr>
    <td>选项*</td>
    <td>
    1、<input type="text" name="subject[option][]" size="60" require="true" datatype="require" msg="不能为空" />&nbsp;
    图片:<input type="text" name="subject[]" id="pic1" sn="1" size="18" />
    <input type="button" value="上传"  onclick="uploadpic(this)"  sn="1" />
    <input type="button" value="浏览..." sn="1"  onclick="addPic(this.sn)" />    <br />
    2、<input type="text" name="subject[option][]" size="60"  require="true" datatype="require" msg="不能为空" />&nbsp;
    图片:<input type="text" name="subject[]" id="pic2" sn="2" size="18" />
    <input type="button" value="上传"  onclick="uploadpic(this)" sn="2" />
    <input type="button" value="浏览..." sn="2"  onclick="addPic(this.sn)"/>

    <div id="newsub0">

    </div>
    <input value="添加选项" type="button" id="add0" optcount="2" subjectid="0" />
    <input value="减少选项" type="button" id="dec0" optcount="2" subjectid="0"/>
    </td>
	</tr>
	<tr>
	<td></td>
	<td> <input type="hidden" name="subject[parentid]" value="<?=$subjectid?>" />
      <input type="submit" name="dosubmit" value="提交" tag="submit" />&nbsp;</td>
	</tr>
</table>
</form>
<div id="opt_template">
	<span> </span><input type="text" name="subject[option][]" value="" size="60"  require="true" datatype="require" msg="不能为空" />&nbsp;
        图片:<input type="text" name="subject[pic][]" value="" id="pic" size="18" />
        <input type="button" id="upload" value="上传" sn="99"  onclick="uploadpic(this)" />
		<input type="button" value="浏览..."  onclick="addPic(this.sn)" sn="99"/>
</div>

<script>
function addPic(index){
	file_select('pic'+index, 0, 1);
}

function uploadpic(obj){
	var id=$(obj).attr('sn');
	openwinx('?mod=phpcms&file=upload&uploadtext=pic'+id,'upload','350','350');
}

$('#opt_template').hide();

$('#add_new').checkForm(1);

$('input[id^="add"]').click(function(){
	var n=$(this).attr('optcount');
	$(this).attr({optcount:(++n)});
	var sid=$(this).attr('subjectid');
	var newopt=$('#opt_template').clone(true);
	newopt.attr({id:'newsopt1'}).find('span').text(n+'、');
	newopt.find('input[id="pic"]').attr({id : 'pic'+n});
	newopt.find('input[sn="99"]').attr( { sn : n } );
	newopt.appendTo('#newsub'+sid).show();
});

$('input[id^="dec"]').click(function(){
	var sid=$(this).attr('subjectid');
	if($('#newsub'+sid).find('div:last').length<1) return false;
	var ncount=$('input[subjectid="'+sid+'"][id^="add"]').attr('optcount')
	$('input[subjectid="'+sid+'"][id^="add"]').attr({optcount:(ncount-1)});
	//$(this).attr({optcount:(ncount-1)});
	$('#newsub'+sid).find('div:last').remove();
});

//删除主题
$('#del').click(function(){
	var n=$('input[tag="delsubject"][checked]').length;
	if(n<1){
		alert("没有选中任何选项");return false;
	}

	if(!confirm("真的删除吗?"))  return false ;

	$('#action').val('delete');
	return true ;
});

//更新排序
$('#listorder').click(function(){
	$('#action').val('edit_subject');
	this.form.submit();
});

$('input[alter]').click(function(){
	var v=$(this).val();
	if(v=='0'){
		$('#val').hide();
	} else {
		$('#val').show();
	}
});
</script>

</body>
</html>
