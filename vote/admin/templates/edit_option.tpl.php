<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<?php
$n=1;
?>
<form name="myform" id="myform" action="?mod=<?=$mod?>&file=<?=$file?>&keyid=<?=$keyid?>&action=<?=$action?>&subjectid=<?=$subjectid?>&dosubmit=1" method="post" class="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>编辑主题</caption>
	<tr>
    <th sid="<?=$sid?>">
    投票主题：</th><td><input type="text" size="50" name="subject" value="<?=$subject['subject']?>" />

    </td>
    <?php
    if($subject['parentid']){
	?>

    <?php
	}
	?>
	</tr>
    <tr id="<?=$sid?>">
    	<th>
        选项类型:
        </th>
      <td>
        <input type="radio" value="0" alter="#val<?=$sid?>" name="ischeckbox" <?=$subject['ischeckbox']?'':'checked'?> />单选 &nbsp;
    <input type="radio" name="ischeckbox" value="1" alter="#val<?=$sid?>" <?=$subject['ischeckbox']?'checked':''?>/>多选  &nbsp;
    <span id="val<?=$sid?>">
    最少选择<input type="text" name="minval" value="<?=max($subject['minval'],1)?>" size="5" />
    最多选择<input type="text" name="maxval" value="<?=$subject['maxval']?>" size="5" />  &nbsp;
    </span>
    </td>
    </tr>
    <tr>
    <td></td>
    <td>
    <?php
	$i=0;
	foreach($subject['options'] as $optid=>$opt)
	{
	?>
    <div id="sep<?=$sid.$i?>">选项<?=++$i?>&nbsp;
        排序 <input type="text" name="listorder[<?=$optid?>]" value="<?=$opt['listorder']?>" class="noime" size="1" />
        文字 <input type="text" name="option[<?=$optid?>]" value="<?=$opt['option']?>" size="40" />
        图片 <input type="text" name="image[<?=$optid?>]" value="<?=$opt['image']?>" id="pic<?=$i?>" sn="<?=$i?>" />
        <input type="button" id="upload" value="上传图片"  onclick="uploadpic(this)" sn="<?=$i?>" />
		<input type="button" value="浏览..." sn="<?=$i?>"   onclick="addPic(this.sn)"/>
        删除 <input type="checkbox" name="deloption[<?=$optid?>]" value="<?=$optid?>" sn="<?=$sid?>" />
    </div>
    <?php
	}
	?>
    <div id="newsub<?=$sid?>">

    </div>
     </td>
    </tr>
    <tr>
    <td>
    </td>
    <td>
    <input value="添加选项" type="button" id="add<?=$sid?>" optcount="<?=$i?>" subjectid="<?=$sid?>" />
    <input value="减少选项" type="button" id="dec<?=$sid?>" optcount="<?=$i?>" subjectid="<?=$sid?>"/>
	 </td>
    </tr>
    <tr><td></td>
    <td>
    <input type="button" value=" 确定 " name="dosubmit" tag="submit" />
    <!--input type="button" value="删除选中的项目" name="dosubmit" sid="<?=$sid?>" id="delopt<?=$sid?>" /-->
    <!--input type="button" value="删除主题" onclick="javascript:delSubject('<?=$sid?>')"-->
    <input type="button" value="返回" onclick="history.go(-1);" />
    </td>
    </tr>
</table>
</form>

<div id="opt_template">
	<span></span>&nbsp;
        文字<input type="text" name="newopt[]" value="" size="50" />
        图片<input type="text" name="newpic[]" value="" sn="90" />
        <input type="button" id="upload" value="上传图片"   onclick="uploadpic(this)" sn="99"/>
		<input type="button" value="浏览..."   onclick="addPic(this.sn)" sn="99" />
</div>

<script>
$('#opt_template').hide();

$('input[id^="add"]').click(function(){
	var n=$(this).attr('optcount');
	$(this).attr({optcount:(++n)});
	var sid=$(this).attr('subjectid');
	var newopt=$('#opt_template').clone(true);
	newopt.attr({id:'newsopt1'}).find('span').text("选项"+n);
	newopt.find('input[sn="90"]').attr({id : 'pic'+n });
	newopt.find('input[sn="99"]').attr({sn : n });
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

//提交修改
$('input[tag="submit"]').click(function(){
	var f=$(this.form);
	var ok=true;
	$('input').removeClass('err_input');
	var v='';
	f.find('input[name^="option"],input[name^="newopt"],input[name^="subject"]').each(function(){
		v=$.trim($(this).val());
		if(v==""){
			$(this).addClass('err_input').focus().select();
			alert("请输入完整");
			return 	ok=false;
		}
	});
	if(ok==false) return ;
	f.find('input[name^="pic"],input[name^="newpic"]').each(function(){
		v=$(this).val();
		var reg= new RegExp('(\.gif|\.png|\.jpg|\.jpeg)$','gi');
		if(v!="" && !reg.test(v)){
			$(this).addClass('err_input').focus().select();
			alert("不是有效的图片格式,图片格式应该为 gif|png|jpg|jpeg");
			return 	ok=false;
		}
	});

	if(ok==true){
		this.form.submit();
	}
});

function delopt(obj){
	var sid=$(obj).attr('sid');
	var n=$('input[type="checkbox"][sn="'+sid+'"][checked]').length;
	if(n<1){
		alert("请选中要删除的选项!");
		return false;
	}

	if(confirm("确认要删除选中的选项吗?")){
		obj.form.action="?mod=<?=$mod?>&file=<?=$file?>&keyid=<?=$keyid?>&action=delopt&subjectid="+sid;
		obj.form.submit();
	}
}

$('input[id^="delopt"]').click(function(){
	delopt(this);
});


function delSubject(sid){
	if(confirm("是否确认删除此主题 ?\n\n一旦删除此主题,则此主题下的选项也将被删除")){
		self.location="?mod=<?=$mod?>&file=<?=$file?>&keyid=<?=$keyid?>&action=delsubject&subjectid="+sid;
	}
}

$('td[sid]').css({cursor:'pointer'}).click(function(){
	var sn=$(this).attr('sid');
	$('tr[id='+sn+']').toggleClass('alter');
});


$('input[name^="deloption"]').click(function(){
	var sn=$(this).attr('sn');
	var n=$('input[sn="'+sn+'"]').length-$('input[sn="'+sn+'"][checked]').length;
	if(n<2){
		$(this).attr({checked:false});
		alert("至少保留两个选项.");
	}
});

$('input[name="optiontype"],input[name="subject[optiontype]"]').click(function(){
	var v=$(this).val();
	var forid=$(this).attr('alter');
	(v==1)?($('#'+forid).show()):($('#'+forid).hide());
});

function addPic(index){
	file_select('pic'+index, 0, 1);
}

function uploadpic(obj){
	var id=$(obj).attr('sn');
	openwinx('?mod=phpcms&file=upload&uploadtext=pic'+id,'upload','350','350');
}

$('input[name="ismultiple"]').click(function(){
	var v=$(this).val();
	if(v==1) {
		$($(this).attr('alter')).show();
	} else {
		$($(this).attr('alter')).hide();
	}
});

$('input[name="ismultiple"][value=<?=$subject['ismultiple']?>]').click();
</script>
</body>
</html>
