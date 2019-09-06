<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
$addtype=$survey?'问卷':'投票'
?>
<script type="text/javascript" src="images/js/validator.js"></script>
<?=$menu?>
<form method="post" name="myform" id="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&dosubmit=1&survey=<?=$survey?>">
<table cellpadding="2" cellspacing="1" class="table_form" id="table">
  <caption><?=$action=='add'?'添加':'编辑'?><?=$addtype?></caption>
  </tr>
<?php
if(!$survey)
{
?>
	  <tr>
        <th width="10%" valign="middle" ><b>投票主题</b></th>
        <td><input name="subject[subject]" size="50"  maxlength="100" require="true" datatype="require" msg="投票主题不能为空">
		 <font color="#FF0000"> *</font></td>
    </tr>
      <tr>
      	<th ><b>选项类型</b></th>
        <td>
        <input type="radio" name="subject[ischeckbox]" tag="optiontype" value="0" checked="checked"/>单选&nbsp;
        <input type="radio" name="subject[ischeckbox]" tag="optiontype" value="1"/>
        多选&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span id="range_1" style="display:none">
        最少选择<input type="text" name="subject[minval]"  value="1" size="3" prefix="[minval]"/>项 &nbsp;&nbsp;&nbsp;&nbsp;
        最多选择<input type="text" name="subject[maxval]"  value="0" size="3" prefix="[maxval]"/>项
        </span>
        </td>
      </tr>
    <tr>
       <th class="err_tip"><b>投票选项</b><br />提示:图片也可以直接填写远程图片地址</th>
       <td>
       <input type="button" value="添加选项" id="addItem1" prefix="addItem" />
       <input type="button" value="减少选项" id="descItem1" prefix="descItem" />
       <div id="option_list_1">
           <div>
           <font color="#FF0000"> *</font>
               <span>1</span>、<input type="text" name="subject[option][]" size="40" require="true" datatype="require" msg="必填" id="opt1" ids="option"/>
               图片:<input type="text" name="subject[image][]" id="pic1" size="18" />
               <input type="button" id="upload" value="上传" style="width:40px" sn="1" onclick="uploadpic(this)" />
              <span><input type="button" value="浏览..." style="width:50px" sn="1" onclick="addPic(this.sn)" /></span>
            </div>
           <div>
           <font color="#FF0000"> *</font>
               <span>2</span>、<input type="text" name="subject[option][]" size="40" require="true" datatype="require" msg="必填" id="opt2" ids="option"/>
               图片:<input type="text" name="subject[image][]" id="pic2" size="18"/>
               <input type="button" id="upload" value="上传" sn="2" onclick="uploadpic(this)" style="width:40px"/>
              <span><input type="button" value="浏览..." sn="2" onclick="addPic(this.sn)" style="width:50px"/></span>
            </div>
       </div>
       <div id="extra_option_1">

       </div>
	    </td>
    </tr>
<?php
}
?>
<?php
if($survey)
{
?>
	<tr id="main_title">
        <th class="err_tip"><b>问卷总标题</b></th>
        <td><input name="voteinfo[title]" id="main_title_text" require="true" datatype="require" msg="不能为空" size="50" />
        <font color="#FF0000"> *</font>
        </td>
     </tr>
<?php
}
?>
   	<tr>
        <th><b><?=$addtype?>介绍</b></th>
        <td><textarea name="voteinfo[description]" id="description"  rows="5" style="width:98%;scroll:auto;"></textarea>
        <?php if($M['editor']) echo form::editor('description','standard','100%','200');?>
        </td>
     </tr>
     <tr>
        <th><b>用户资料</b></th>
        <td>
        	<table class="table_form" cellspacing="1" cellpadding="0">
            <caption>投票人信息字段</caption>
            <tr>
            	<td width="20%">字段</td>
                <td width="30%">必填</td>
            	<td width="20%">字段</td>
                <td width="30%">必填</td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[truename]" value="1" />&nbsp;姓名&nbsp;</td>
                <td><input type="checkbox" name="required[truename]" value="1" /></td>
            	<td><input type="checkbox" name="userinfo[sex]" value="1" />&nbsp;性别</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[age]" value="1" />&nbsp;年龄</td>
                <td><input type="checkbox" name="required[age]" value="1" /></td>
            	<td><input type="checkbox" name="userinfo[email]" value="1" />&nbsp;电话</td>
                <td><input type="checkbox" name="required[eamil]" value="1" /></td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[addr]" value="1" />&nbsp;地址</td>
                <td><input type="checkbox" name="required[addr]" value="1" /></td>
            	<td><input type="checkbox" name="userinfo[postzip]" value="1" />&nbsp;邮编</td>
                <td><input type="checkbox" name="required[postzip]" value="1" /></td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[id]" value="1" />&nbsp;身份证号</td>
                <td><input type="checkbox" name="required[id]" value="1" /></td>
            	<td><input type="checkbox" name="userinfo[comment]" value="1" />&nbsp;投票人意见</td>
                <td><input type="checkbox" name="required[comment]" value="1" /></td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="userinfo[extra]" value="1" />&nbsp;附加信息</td>
                <td><input type="checkbox" name="required[extra]" value="1" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </table>
        </td>
     </tr>

	<tr  style="display:none">
         <th><b>投票类型</b><br />多主题有多组选项,类似调查问卷的形式</th>
         <td>
         <input type="text" name="voteinfo[ismultiple]" value="<?=intval($survey)?>" />
          </tr>
     <tr>
        <th><b>未投票人是否可以查看投票结果</b></th>
        <td><input type="radio" name="voteinfo[allowview]" value="1" checked="checked"/>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="voteinfo[allowview]" value="0"/>否
        </td>
     </tr>

   	<tr>
        <th><b>启用验证码</b></th>
        <td><input type="radio" name="voteinfo[enablecheckcode]" <?=$M['checkcode']?'checked':''?> />是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="voteinfo[enablecheckcode]" value="0" <?=$M['checkcode']?'':'checked'?> />否
        </td>
     </tr>
     <tr>
        <th><b>投票有效期范围</b></th>
        <td>
        <?=form::date('voteinfo[fromdate]',$fromdate)?>&nbsp;到&nbsp;
         <?=form::date('voteinfo[todate]',$todate)?>
        </td>
     </tr>
     <tr>
        <th><b>允许游客投票</b></th>
        <td>
        <input name="voteinfo[allowguest]" type="radio" value="1" <?=$M['anonymous']?'checked':''?> />是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     	<input name="voteinfo[allowguest]" type="radio" value="0" <?=$M['anonymous']?'':'checked'?> />否
        </td>
     </tr>
     <tr>
        <th><b>允许参与投票的会员组</b>
        <br />全选
        <input type="checkbox" onclick="checkall('posids')" boxid="posids" class="checkbox_style"/>
        <br />如果无限制，则不要选择</th>
        <td>
        <?=form::select_group('voteinfo[groupidsvote]','posids','',10,200)?>
        </td>
     </tr>
     <tr>
        <th><b>允许查看投票结果的会员组</b>
        <br />全选
        <input type="checkbox" onclick="checkall('voteinfo')" boxid="voteinfo" class="checkbox_style"/>
        <br />如果无限制，则不要选择</td>
        <td>
        <?=form::select_group('voteinfo[groupidsview]','voteinfo','',10,200)?>
        </td>
     </tr>

     <tr>
        <th><b>参与投票奖励积分数</b></th>
        <td>
        <input type="text" name="voteinfo[credit]" value="0" />
        </td>
     </tr>
     <tr>
        <th><b>投票时间间隔(天)</b><br />N天后可再次投票，0表示此IP地址只能投一次</th>
        <td>
        <input type="text" name="voteinfo[interval]" value="0" />
        </td>
     </tr>
     <tr>
        <th><b>模板设置</b></th>
        <td>
        <?php
		if($survey)
		{
			$tpl_pre = 'vote_question';
			$default_value = 'vote_question_list';
		}
		else
		{
			$tpl_pre = 'vote_vote';
			$default_value = 'vote_vote_list';
		}
		echo form::select_template('vote', 'voteinfo[template]', 'template', $default_value, 'require="true" datatype="custom" regexp="[^0\s*]$"  msg="请选择模板"', $tpl_pre);?>
		&nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="location.href='?mod=phpcms&file=template&action=edit&template='+ $('#template').val()+'&module=<?=$mod?>&forward=<?=urlencode(URL)?>'">
        </td>
     </tr>
  <tr>
     <th  width="20%"><b>启用</b></td>
     <td><input name="voteinfo[enabled]" type="radio" value="1" checked="checked" />
     是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="voteinfo[enabled]" value="0" />否
     </td>
  </tr>
    <tr>
        <td></td>
    	<td>
	<input type="hidden" name="subject[parentid]" value="<?=intval($parentid)?>" />
 	<input type="hidden" name="referer" value="<?=HTTP_REFERER?>" >
    <input type="submit" value="<?=$survey?'下一步(填写问卷主题)':'完成'?>" name="submit">
    <input type="reset" value="清除" name="reset">
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

function uploadpic(obj){
	var id=$(obj).attr('sn');
	openwinx('?mod=phpcms&file=upload&uploadtext=pic'+id,'upload','350','350');
}

$('input[name="voteinfo[ismultiple]"][value=0]').click();

//增加选项
$('input[id^="addItem"]').click(function(){
	var newOption =  $('#option_list_1 div:first').clone(true);
	newOption.find('input[name]').val('');
	var n = $('#extra_option_1').find('input[name]').length/2+3;
	newOption.find('span:first').html(n);
	newOption.find('input[id="pic1"]').attr({id:'pic'+n});
	newOption.find('input[sn="1"]').attr({sn:n});
	newOption.appendTo('#extra_option_1');
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

$('input[tag="optiontype"]').click(function(){
	var stype = $(this).val();
	if(stype==1){
		$('#range_1').show();
	} else {
		$('#range_1').hide();
	}
});


$('#table td').addClass('tablerow');


$('#myform').checkForm(1);

$('input[name="voteinfo[enabled]"]').eq(0).click();
</script>
</body>
</html>