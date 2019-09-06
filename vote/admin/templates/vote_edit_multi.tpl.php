<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style>
</style>
<?=$menu?>
<form method="post" name="myform" id="myform" onsubmit="return checkMyform()" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&subjectid=<?=$subjectid?>">
<table cellpadding="2" cellspacing="1" class="tableborder" id="table">
  <tr>
    <th colspan=2>添加投票</th>
  </tr>
	<tr>
         <td  align="left">投票类型</td>
         <td><input type="radio" name="voteinfo[type]" value="0">单主题
		 <input type="radio" name="voteinfo[type]" value="1">多主题   (说明:多主题有多组选项,类似调查问卷的形式)
          </tr>
	<tr id="main_title">
        <td  align="left" class="err_tip">投票总标题</td>
        <td><textarea name="voteinfo[title]" id="main_title_text" rows="3"><?=$subject['title']?></textarea>
        <font color="#FF0000"> *</font>
        </td>
     </tr>
   	<tr>
        <td  align="left">背景资料</td>
        <td><textarea name="voteinfo[detail]" id="detail"  rows="3"><?=$subject['detail']?></textarea>
        <?=form::editor('detail','phpcms','100%','200')?>
        </td>
     </tr>
   	<tr>
        <td  align="left">是否启用验证码</td>
        <td><input type="radio" name="voteinfo[checkcode]" value="1" />启用&nbsp;&nbsp;&nbsp;
        <input type="radio" name="voteinfo[checkcode]" value="0" />不启用
        </td>
     </tr>
     <tr>
        <td  align="left">投票有效期范围</td>
        <td>
        <?=form::date('voteinfo[fromdate]',$subject['fromdate'])?>&nbsp;到&nbsp;
         <?=form::date('voteinfo[todate]',$subject['todate'])?>
        </td>
     </tr>
     <tr>
        <td  align="left">是否允许游客投票</td>
        <td>
        <input name="voteinfo[anonymous]" type="radio" value="1"> 是&nbsp;&nbsp;&nbsp;&nbsp;
     	<input name="voteinfo[anonymous]" type="radio" value="0"> 否
        </td>
     </tr>
     <tr>
        <td  align="left">允许参与投票的会员组</td>
        <td>
        <?=form::select_group('voteinfo[groups]','',$subject['groups'],10,200)?>
        </td>
     </tr>
    <tr>
        <td  align="left">是否记名投票</td>
        <td> <input type="radio" name="voteinfo[save_username]" value="1" <?=save_username?'checked':''?> />是&nbsp;&nbsp;
        <input type="radio" name="voteinfo[save_username]" value="0" <?=save_username?'':'checked'?>/>否&nbsp;&nbsp;
        (记名投票根据用户名及IP地址只能投票一次,此项启用后,游客将不能参与投票)
        </td>
     </tr>

     <tr>
        <td  align="left">参与投票奖励积分数</td>
        <td>
        <input type="text" name="voteinfo[credit]" value="<?=$subject['credit']?>" />
        </td>
     </tr>
     <tr>
        <td  align="left">投票时间间隔(以天为单位)</td>
        <td>
        <input type="text" name="voteinfo[interval]" value="<?=$subject['interval']?>" />(同一IP地址在N天后可再次投票,0表示此IP地址只能投一次,-1则表示无限制)
        </td>
     </tr>
     <tr>
        <td  align="left">投票人资料</td>
        <td>
        <fieldset>
        <input type="checkbox" name="userinfo[truename][value]" value="1" <?=$truename['value']?'checked':''?> />姓名&nbsp;
        <label>
        <input type="checkbox" name="userinfo[truename][required]" value="1" <?=$truename['required']?'checked':''?>/>必填项</label>
        </fieldset>
        <fieldset>
        <input type="checkbox" name="userinfo[sex][value]" value="1" <?=$sex['value']?'checked':''?>/>性别&nbsp;
        <label>
        <input type="checkbox" name="userinfo[sex][required]" value="1" <?=$sex['required']?'checked':''?>/>必填项</label>
        </fieldset>
        <fieldset>
        <input type="checkbox" name="userinfo[age][value]" value="1"<?=$age['value']?'checked':''?> />年龄&nbsp;&nbsp;<label>
        <input type="checkbox" name="userinfo[age][required]" value="1" <?=$age['required']?'checked':''?> />必填项</label>
        </fieldset>
        <fieldset>
        <input type="checkbox" name="userinfo[email][value]" value="1"  <?=$email['value']?'checked':''?>/>电子信箱&nbsp;<label>
        <input type="checkbox" name="userinfo[email][required]" value="1" <?=$email['required']?'checked':''?> />必填项</label>
        </fieldset>
        <fieldset>
        <input type="checkbox" name="userinfo[addr][value]" value="1"<?=$addr['value']?'checked':''?> />地址&nbsp;&nbsp;<label>
        <input type="checkbox" name="userinfo[addr][required]" value="1" <?=$addr['required']?'checked':''?> />必填项</label>
        </fieldset>
        <fieldset>
        <input type="checkbox" name="userinfo[postzip][value]" value="1" <?=$postzip['value']?'checked':''?>/>邮编&nbsp;<label>
        <input type="checkbox" name="userinfo[postzip][required]" value="1" <?=$postzip['required']?'checked':''?>/>必填项</label>
        </fieldset>
        <fieldset>
       <input type="checkbox" name="userinfo[id][value]" value="1" <?=$id['value']?'checked':''?>/>身份证号&nbsp;<label>
       <input type="checkbox" name="userinfo[id][required]" value="1" />必填项</label>
        </fieldset>
        <fieldset>
       <input type="checkbox" name="userinfo[comment][value]" value="1" <?=$comment['value']?'checked':''?> />投票人意见&nbsp;<label>
       <input type="checkbox" name="userinfo[comment][required]" value="1" <?=$comment['required']?'checked':''?>/>必填项</label>
        </fieldset>
        <fieldset>
       <input type="checkbox" name="userinfo[extra][value]" value="1" />备注&nbsp;<label>
       <input type="checkbox" name="userinfo[extra][required]" value="1" />必填项</label>
        </fieldset>
        </td>
     </tr>
     <tr>
        <td  align="left">模板设置</td>
        <td>
        <input type="text" name="voteinfo[templateid]" id="templateid" value="<?=$subject['templateid']?>" />
        <?=template_select('templateid')?>
        </td>
     </tr>
	  <tr>
        <td  align="left" valign="middle" width="15%" class="err_tip" id="title">投票主题</td>
        <td  width="85%"><input name="subject[title]" size="50"  maxlength="100" required="1" value="<?=$subject['subject']?>">
		 <font color="#FF0000"> *</font></td>
      </tr>
      <tr>
      	<td>选项类型</td>
        <td>
        <input type="radio" name="subject[optiontype]" id="optiontype0" value="0"/>单选&nbsp;
        <input type="radio" name="subject[optiontype]" id="optiontype1" value="1"/>
        多选&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span id="range_1" style="display:none">
        最少选择<input type="text" name="subject[minval]"  value="1" size="3" prefix="[minval]"/>项 &nbsp;&nbsp;&nbsp;&nbsp;
        最多选择<input type="text" name="subject[maxval]"  value="0" size="3" prefix="[maxval]"/>项
        </span>
        </td>
      </tr>
    <tr>
       <td align="left" class="err_tip">投票选项</td>
       <td>
       <input type="button" value="添加选项" id="addItem1" prefix="addItem" />
       <input type="button" value="减少选项" id="descItem1" prefix="descItem" />
          <?php
		  $i=0;
		  foreach($options as $optionid=>$option){
		  $i++;
		  ?>
          <?=($i==1)?'<div id="option_list_1">':''?>
          <font color="#FF0000"> *</font>
          <span>选项<?=$i?></span> 文字
          <input type="text" name="subject[option][<?=$optionid?>]" size="60" required="1" ids="option" value="<?=$option['option']?>"/>
           图片<input type="text" name="subject[pic][<?=$optionid?>]" id="pic<?=$i?>" value="<?=$option['pic']?>"/>
           <input type="button" id="upload" value="上传图片" sn="<?=$i?>" />
          <span><input type="button" value="浏览..." sn="<?=$i?>" onclick="addPic(this.sn)" /></span>&nbsp;
          <input type="checkbox" value="<?=$optionid?>" name="deloption[<?=$optionid?>]" />删除此项
          <br />
          <?=$i==1?'</div>':''?>
          <?php
		  }
		  ?>
       <div id="extra_option_1">

       </div>
	    </td>
    </tr>
</table>
<span class="err_tip" id="err">必填写不能为空,请填写以上红色线框标识的项目.</span>
<br />

<div class="align_c">
	<div style="display:inline">
	<input type="submit" id="addTopicBtn" value="完成并增加主题" />
    <input type="button" id="descTopicBtn" value="移除主题" />
	</div>
 	<input type="hidden" name="referer" value="<?=HTTP_REFERER?>" >
    <input type="submit" value=" 完成 " name="submit">
    <input type="reset" value=" 清除 " name="reset">
</div>
</form>

<script>
//初始化
var idpre='';
var sid;
var n=1;
var v='';

$('input[name="voteinfo[type]"][value="<?=$subject['type']?>"]').attr({checked:true});
$('input[name="voteinfo[checkcode]"][value="<?=$subject['checkcode']?>"]').attr({checked:true});
$('input[name="voteinfo[anonymous]"][value="<?=$subject['anonymous']?>"]').attr({checked:true});
$('input[name="subject[optiontype]"][value="<?=$subject['optiontype']?>"]').attr({checked:true});
//单主题 多主题切换
$('input[name="voteinfo[type]"]').click(function(){
	changeTitle(this.value);
});
$('input[name="voteinfo[type]"][value=<?=$subject['type']?>]').click();

//增加选项
$('input[id^="addItem"]').click(function(){
	var newOption =  $('#option_list_1').clone(true);
	newOption.find('input[name]').val('');
	var option_count = $('#extra_option_1').find('input[name]').length/3+1+<?=$i?>;
	//var option_count=<?=count($options)+1?>;
	newOption.find('span:first').html("选项"+option_count);
	newOption.find('input[id="pic1"]').attr({id:'pic'+option_count});
	newOption.find('input[sn="1"]').attr({sn:option_count});
	newOption.find('input').eq(0).attr({name:'newoption[]'});
	newOption.find('input').eq(1).attr({name:'newpic[]'});
	newOption.appendTo('#extra_option_1');
});

$('input[name^="deloption"]').click(function(){
	var total = <?=count($options)?>;
	var del_count=$('input[name^="deloption"][checked]').length;
	if((total-del_count)<2){
		$(this).attr({checked:false});
		alert("至少保留两个选项.");
	}
});

function addPic(index){
	file_select('#pic'+index, 0, 1);
}
//减少选项
$('input[id^="descItem"]').click(function (){
	var sn=(this.id).replace('descItem','');
	var subopt = $('#extra_option_'+sn).find('div');
	if(subopt.length<2) {
		$('input[id="descItem"][sid='+sn+']').attr({disabled:true});
	}
	subopt.eq(subopt.length-1).remove();
});

$('input[id="optiontype"]').click(function(){
	var stype = $(this).val();
	if(stype==1){
		$('#range_1').show();
	} else {
		$('#range_1').hide();
	}
});

function changeTitle(type){
	$('#title').html((type==1)?'投票主题1':'投票主题');

   	if(type==0) {
		$('#addTopicBtn').parent('div').hide();
		$('#main_title').hide().find('*').attr({required:''});
	} else {
		$('#addTopicBtn').parent('div').show();
		$('#main_title').show().find('*').attr({required:'1'});
	}
}

function checkMyform(){
	var isok=true;
	var e =$('input[required="1"],textarea[required="1"]').removeClass('err_input');
	var v="";
	e.each(function(index){
		if($.trim($(this).val())==""){
			$(this).addClass('err_input').focus().val('');
			isok=false;
		}
	});

	if(!isok){
		alert("必填项不能为空!");return false;
	}
	if($('input[ids="option"]').length<2){
		alert("至少两个投票选项");
		$('input[id^="addItem"]').click();
		return false;
	}
	return true;
}

$('input[name="option[type]"]').eq(0).click();
$('#table td').addClass('tablerow');
$('#err').hide();
$('fieldset input').find('label').hide();
$('fieldset input').click(function(index){
	if(this.checked){
		$(this).parent().find('label').show();
	} else {
		$(this).parent().find('label').hide();
	}
});

function setUserInfo(){
	var v;
	var e;
	$('fieldset').each(function(index){
		v=$(this).find('input').eq(0).attr('checked');
		e=$(this).find('label');
		v=v?(e.show()):(e.hide());
	});
}

setUserInfo();
</script>
</body>
</html>