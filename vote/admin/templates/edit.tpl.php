<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header','phpcms');
$type = $survey ? '问卷' : '投票'
?>

<form method="post" name="myform" id="myform"  action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&subjectid=<?=$subjectid?>&survey=<?=$survey?>">
<table cellpadding="2" cellspacing="1"  class="table_form" id="table">
  <caption>修改<?=$type?></caption>
<?php
if(!$subject['ismultiple']){
?>
	  <tr>
        <th width="20%"><b>投票主题</b></th>
        <td><input name="subject[subject]" size="50"  maxlength="100"  value="<?=$subject['subject']?>" require="true" datatype="require" msg="必填" msgid="msgid1">
		 <font color="#FF0000"> *</font><span id="msgid1" /></td>
    </tr>
      <tr>
      	<th ><b>选项类型</b></th>
        <td>
        <input type="radio" name="voteinfo[ischeckbox]" sn="optiontype" value="0" onclick="$('#range_1').hide();" <?php if($subject['ischeckbox'] == '0') {?>checked="checked"<?}?>/>单选&nbsp;
        <input type="radio" name="voteinfo[ischeckbox]" sn="optiontype" value="1" <?php if($subject['ischeckbox'] == '1') {?>checked="checked"<?}?> onclick="$('#range_1').show();"/>
        多选&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span id="range_1" <?php if($subject['ischeckbox']){ ?>style="display:"<?php }else{?>style="display:none"<?php }?> >
        最少选择<input type="text" name="voteinfo[minval]"  size="3"  prefix="[minval]" value="<?=$subject['minval']?>"/>项 &nbsp;&nbsp;&nbsp;&nbsp;
        最多选择<input type="text" name="voteinfo[maxval]" size="3" prefix="[maxval]" value="<?=$subject['maxval']?>"/>项
        </span>
        </td>
      </tr>
    <tr>
       <th><b>投票选项</b></th>
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
          排序<input type="text" size="2" name="listorder[<?=$optionid?>]" value="<?=$option['listorder']?>" />
          <span><?=$i?>、</span>
          <input type="text" name="subject[option][<?=$optionid?>]" size="30" ids="option" value="<?=$option['option']?>"  require="true" datatype="require" msg="必填"/>
           图片:<input type="text" name="subject[image][<?=$optionid?>]" id="pic<?=$i?>" value="<?=$option['image']?>" size="15"/>
           <input type="button" id="upload" value="上传" sn="<?=$i?>"   onclick="uploadpic(this)"/>
          <span><input type="button" value="浏览..." sn="<?=$i?>" onclick="addPic(this.sn)" style="width:50px" /></span>
          <input type="checkbox" value="<?=$optionid?>" name="deloption[<?=$optionid?>]" />删除
          <br />
          <?=$i==1?'</div>':''?>
          <?php
		  }
		  ?>
       <div id="extra_option_1">

       </div>
	    </td>
    </tr>
<?php
} //end $subject['type']
?>

     <tr style="display:none">
         <td  align="left"><b>投票类型</b></td>
         <td>
         <?=$subject['ismultiple']?'多主题':'单主题'?>
         <input type="hidden" name="voteinfo[ismultiple]" value="<?=$subject['ismultiple']?>" />
          </tr>
<?php
if($subject['ismultiple']){
?>
	<tr id="main_title">
        <th class="err_tip" width="20%"><b>总标题</b></th>
        <td><input type="text" name="subject[subject]" id="main_title_text" size="50" value="<?=$subject['subject']?>" require="true" datatype="require" msg="必填">
        <font color="#FF0000"> *</font>
        </td>
     </tr>
<?php
}
?>
   	<tr>
        <th><b>背景资料</b></th>
        <td><textarea name="voteinfo[description]" id="description"  rows="5" cols="70"><?=$subject['description']?></textarea>
        <?php if($M['editor']) echo form::editor('description','standard','100%','200');?>
        </td>
     </tr>
	 <tr>
        <th><b>投票人资料</b></th>
        <td>
        <table class="table_form">
            <caption>投票人信息字段</caption>
            <tr>
            	<td width="20%">字段</td>
                <td width="30%">必填</td>
            	<td width="20%">字段</td>
                <td width="30%">必填</td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[truename]" value="1" <?=isset($truename)?'checked':''?>/>&nbsp;姓名&nbsp;</td>
                <td><input type="checkbox" name="required[truename]" value="1"  <?=$truename?'checked':''?>/></td>
            	<td><input type="checkbox" name="userinfo[sex]" value="1" <?=isset($sex)?'checked':''?>/>&nbsp;性别</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[age]" value="1" <?=isset($age)?'checked':''?>/>&nbsp;年龄</td>
                <td><input type="checkbox" name="required[age]" value="1" <?=$age?'checked':''?>/></td>
            	<td><input type="checkbox" name="userinfo[email]" value="1" <?=isset($email)?'checked':''?>/>&nbsp;信箱</td>
                <td><input type="checkbox" name="required[email]" value="1" <?=$email?'checked':''?>/></td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[addr]"   value="1" <?=isset($addr)?'checked':''?>/>&nbsp;地址</td>
                <td><input type="checkbox" name="required[addr]" value="1" <?=$addr?'checked':''?>/></td>
            	<td><input type="checkbox" name="userinfo[postzip]" value="1" <?=isset($postzip)?'checked':''?>/>&nbsp;邮编</td>
                <td><input type="checkbox" name="required[postzip]" value="1" <?=$postzip?'checked':''?>/></td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[id]" value="1" <?=isset($id)?'checked':''?>/>&nbsp;身份证号</td>
                <td><input type="checkbox" name="required[id]" value="1" <?=$id?'checked':''?>/></td>
            	<td><input type="checkbox" name="userinfo[comment]" value="1" <?=isset($comment)?'checked':''?>/>&nbsp;投票人意见</td>
                <td><input type="checkbox" name="required[comment]" value="1" <?=$comment?'checked':''?>/></td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[extra]" value="1" <?=isset($extra)?'checked':''?>/>&nbsp;附加信息</td>
                <td><input type="checkbox" name="required[extra]" value="1" <?=$extra?'checked':''?>/></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </table>
        </td>
     </tr>
   	<tr>
        <th><b>未投票可以查看投票结果</b></th>
        <td><input type="radio" name="voteinfo[allowview]" value="1" <?=$subject['allowview']?'checked':''?>/>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="voteinfo[allowview]" value="0"  <?=$subject['allowview']?'':'checked'?>/>否&nbsp;
        </td>
     </tr>
   	<tr>
        <th><b>启用验证码</b></th>
        <td><input type="radio" name="voteinfo[enablecheckcode]" value="1" />是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="voteinfo[enablecheckcode]" value="0" />否
        </td>
     </tr>
     <tr>
        <th><b>投票有效期范围</b></th>
        <td>
        <?=form::date('voteinfo[fromdate]',$subject['fromdate'])?>&nbsp;到&nbsp;
         <?=form::date('voteinfo[todate]',$subject['todate'])?>
        </td>
     </tr>
     <tr>
        <th><b>允许游客投票</b></th>
        <td>
        <input name="voteinfo[allowguest]" type="radio" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     	<input name="voteinfo[allowguest]" type="radio" value="0">否
        </td>
     </tr>
     <tr>
        <th><b>允许参与投票的会员组</b><br />全选
        <input type="checkbox" onclick="checkall('posids')" boxid="posids" class="checkbox_style"/>
        <br />如果无限制，则不要选择
        </th>
        <td>
        <?=form::select_group('voteinfo[groupidsvote]','posids',$subject['groupidsvote'],10,200)?>
        </td>
     </tr>
     <tr>
        <th><b>允许查看投票结果的会员组</b>
        <br />全选
        <input type="checkbox" onclick="checkall('voteinfo')" boxid="voteinfo" class="checkbox_style"/>
        <br />如果无限制，则不要选择</td>
        </th>
        <td>
        <?=form::select_group('voteinfo[groupidsview]','voteinfo',$subject['groupidsview'],10,200)?>
        </td>
     </tr>
     <tr>
        <th><b>参与投票奖励积分数</b></th>
        <td>
        <input type="text" name="voteinfo[credit]" value="<?=$subject['credit']?>" />
        </td>
     </tr>
     <tr>
        <th><b>投票时间间隔(天)</b><br />N天后可再次投票，0表示此IP地址只能投一次</th>
        <td>
        <input type="text" name="voteinfo[interval]" value="<?=$subject['interval']?>" /> </td>
     </tr>

     <tr>
        <th><b>模板设置</b></th>
        <td>
		 <?php
		if($survey)
		{
			$tpl_pre = 'vote_question';
		}
		else
		{
			$tpl_pre = 'vote_vote';
		}
		echo form::select_template('vote', 'voteinfo[template]', 'template', $subject['template'], 'require="true" datatype="custom" regexp="[^0\s*]$"  msg="请选择模板"', $tpl_pre);?>
		&nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="location.href='?mod=phpcms&file=template&action=edit&template='+ $('#template').val()+'&module=<?=$mod?>&forward=<?=urlencode(URL)?>'">
        </td>
     </tr>
   	<tr>
        <th><b>启用</b></th>
        <td><input type="radio" name="voteinfo[enabled]" value="1" <?=$subject['enabled']?'checked':''?> />是&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="voteinfo[enabled]" value="0" <?=$subject['enabled']?'':'checked'?> />否
        </td>
     </tr>
	<tr>
        <th></th>
    	<td>
	<input type="hidden" name="voteinfo[addtime]" value="<?=$subject['addtime']?>" />
 	<input type="hidden" name="referer" value="<?=HTTP_REFERER?>" >
    <input type="submit" value=" 完成 " name="submit">
    <input type="reset" value=" 清除 " name="reset">
        </td>
    </tr>
</table>

</form>

<script>
//初始化
var idpre='';
var sid;
var n=1;
var v='';

$('input[name="voteinfo[ismultiple]"][value="<?=$subject['ismultiple']?>"]').attr({checked:true});
$('input[name="voteinfo[enablecheckcode]"][value="<?=$subject['enablecheckcode']?>"]').attr({checked:true});
$('input[name="voteinfo[allowguest]"][value="<?=$subject['allowguest']?>"]').attr({checked:true});
$('input[name="subject[ischeckbox]"][value="<?=$subject['ischeckbox']?>"]').attr({checked:true});
//单主题 多主题切换
$('input[name="voteinfo[ismultiple]"]').click(function(){
	var votetype=<?=intval($subject['ismultiple'])?>;
	var c=0;
	if(votetype==1 && this.value==0 ){
		if(confirm("这是一个多主题的投票,如果你修改成单主题投票,则此投票下的其它主题将删除,\n\n确认要这样做吗?")){
			$('input[name="voteinfo[ismultiple]"]').eq(0).attr({checked:true});
		} else {
			return $('input[name="voteinfo[ismultiple]"]').eq(1).attr({checked:true});
		}
	}

});
$('input[name="voteinfo[ismultiple]"][value=<?=$subject['ismultiple']?>]').click();

//增加选项
$('input[id^="addItem"]').click(function(){
	var newOption =  $('#option_list_1').clone(true);
	newOption.find('input[name]').val('');
	var option_count = $('#extra_option_1').find('input[name]').length/4+1+<?=intval($i)?>;
	newOption.find('input:first').attr({disabled:'true'});
	//var option_count=<?=count($options)+1?>;
	newOption.find('span:first').html(option_count+'、');
	newOption.find('input[id="pic1"]').attr({id:'pic'+option_count});
	newOption.find('input[sn="1"]').attr({sn:option_count});
	newOption.find('input').eq(1).attr({name:'newoption[]'});
	newOption.find('input').eq(2).attr({name:'newpic[]'});
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
	file_select('pic'+index, 0, 1);
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

$('input[sn="ischeckbox"]').click(function(){
	var stype = $(this).val();
	if(stype==1){
		$('#range_1').show();
	} else {
		$('#range_1').hide();
	}
});

$('#myform').checkForm(1);

function uploadpic(obj){
	var id=$(obj).attr('sn');
	openwinx('?mod=phpcms&file=upload&uploadtext=pic'+id,'upload','350','350');
}


$('input[name="option[ismultiple]"]').eq(0).click();


$('fieldset').css({'border':'none','display':'inline-block'});

</script>
</body>
</html>