<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script language="JavaScript">
<!--
	function showrewrite(mode)
	{
		if(mode==1)
		{
			$("#categorySpan").css("display","none");
			$("#showSpan").css("display","none");
			$("#htmlcategorySpan").css("display","");
			$("#htmlshowSpan").css("display","");
		}
		else
		{
			$('#htmlcategorySpan').css('display','none');
			$('#htmlshowSpan').css('display','none');
			$('#categorySpan').css('display','');
			$('#showSpan').css('display','');
		}
	}
//-->
</script>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
   <caption><?=$M['name']?>模块配置</caption>
	<tr>
      <th width='40%' ><strong>发布提问是否需要审核</strong></th>
      <td><input name='setting[publish_check]' type='radio' value="1" <?php if($publish_check) echo "checked";?>> 是 <input name='setting[publish_check]' type='radio' value="0" <?php if(!$publish_check) echo "checked";?>> 否</td>
    </tr>
    <tr>
    	<th><strong>发表问题是否开启验证</strong></th>
        <td><input name='setting[publish_code]' type='radio' value="1" <?php if($publish_code) echo "checked";?>> 是 <input name='setting[publish_code]' type='radio' value="0" <?php if(!$publish_code) echo "checked";?>> 否        
        </td>
    </tr>
	<tr>
      <th><strong>回答是否需要审核</strong></th>
      <td><input name='setting[answer_check]' type='radio' value="1" <?php if($answer_check) echo "checked";?>> 是 <input name='setting[answer_check]' type='radio' value="0" <?php if(!$answer_check) echo "checked";?>> 否</td>
    </tr>
	<tr>
      <th><strong>回答是否需要开启验证</strong></th>
      <td><input name='setting[answer_code]' type='radio' value="1" <?php if($answer_code) echo "checked";?>> 是 <input name='setting[answer_code]' type='radio' value="0" <?php if(!$answer_code) echo "checked";?>> 否</td>
    </tr>
	<tr>
      <th><strong>高分上限设置</strong></th>
      <td><input name='setting[height_score]' type='text' id='height_score' value='<?=$height_score?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>匿名默认扣除积分设定</strong></th>
      <td><input name='setting[anybody_score]' type='text' id='anybody_score' value='<?=$anybody_score?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>会员回答问题奖励积分</strong></th>
      <td><input name='setting[answer_give_credit]' type='text' id='answer_give_credit' value='<?=$answer_give_credit?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>回答问题每日最多可获得积分</strong></th>
      <td><input name='setting[answer_max_credit]' type='text' id='answer_max_credit' value='<?=$answer_max_credit?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>回答被采纳为最佳答案奖励积分</strong></th>
      <td><input name='setting[answer_bounty_credit]' type='text' id='answer_bounty_credit' value='<?=$answer_bounty_credit?>' size='5' maxlength='50'></td>
    </tr>
    <tr>
      <th><strong>会员投票奖励积分</strong></th>
      <td><input name='setting[vote_give_credit]' type='text' id='vote_give_credit' value='<?=$vote_give_credit?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>会员投票每日最多可获得积分</strong></th>
      <td><input name='setting[vote_max_credit]' type='text' id='vote_max_credit' value='<?=$vote_max_credit?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>提问上线后被删除扣除积分</strong><br />提问上线后，被管理员删除，扣除提问用户<?=$del_question_credit?>分，答复者不扣</th>
      <td><input name='setting[del_question_credit]' type='text' id='del_question_credit' value='<?=$del_question_credit?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>回答上线后被删除扣除积分</strong><br />回答上线后，被管理员删除，扣除回答用户<?=$del_answer_credit?>分</th>
      <td><input name='setting[del_answer_credit]' type='text' id='del_answer_credit' value='<?=$del_answer_credit?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>问题15天内不处理扣除积分</strong> <br />问题到期，提问用户不作处理（不做最佳答案判断、不通过提高悬赏延期问题有效时间，不关闭问题，或不转入投票流程），在问题直接过期或自动转投票时扣除提问用户<?=$del_day15_credit?>分</th>
      <td><input name='setting[del_day15_credit]' type='text' id='del_day15_credit' value='<?=$del_day15_credit?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>处理过期问题返回积分</strong> <br />过期自动转投票问题选出最佳答案或提问者对过期问题进行处理，包括采纳最佳答案和选择无满意答案，提问者都可以获得系统返还的<?=$return_credit?>分</th>
      <td><input name='setting[return_credit]' type='text' id='return_credit' value='<?=$return_credit?>' size='5' maxlength='50'></td>
    </tr>

	<tr>
      <th><strong>会员角色系列名称</strong><br />每行填写一个</th>
      <td><textarea name='setting[member_group]' id='member_group' cols='40' rows='5'><?=$member_group?></textarea></td>
    </tr>
	 <tr>
      <th><strong>问吧首页自动更新间距</strong></th>
      <td><input name='setting[autoupdate]' type='text' id='highscore' value='<?=$autoupdate?>' size='5' maxlength='50'> 秒</td>
    </tr>
	<tr>
      <th><strong>启用编辑器</strong></th>
      <td><input name='setting[use_editor]' type='radio' value="1" <?php if($use_editor) echo "checked";?>> 是 <input name='setting[use_editor]' type='radio' value="0" <?php if(!$use_editor) echo "checked";?>> 否</td>
    </tr>
	<tr>
      <th><strong>启用伪静态</strong><br />支持栏目和内容页</th>
      <td><input name='setting[rewrite]' type='radio' value="1" <?php if($rewrite) echo "checked";?> onClick="showrewrite(1)"> 是 <input name='setting[rewrite]' type='radio' value="0" <?php if(!$rewrite) echo "checked";?> onClick="showrewrite(0)"> 否</td>
    </tr>
	<tr>
      <th><strong>栏目页规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=ask&filename=category&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td>
	  <span id="categorySpan" <?php if($rewrite) echo 'style="display:none"';?>><?=form::select_urlrule('ask', 'category', 0, 'category', 'category', $categoryUrlRuleid)?></span>
	  <span id="htmlcategorySpan" <?php if(!$rewrite) echo 'style="display:none"';?>><?=form::select_urlrule('ask', 'htmlcategory', 0, 'htmlcategory', 'htmlcategory', $categoryUrlRuleid)?></span>
	  </td>
    </tr>
	<tr>
      <th><strong>内容页规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=ask&filename=show&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td>
	  <span id="showSpan" <?php if($rewrite) echo 'style="display:none"';?>><?=form::select_urlrule('ask', 'show', 0, 'show', 'show',$showUrlRuleid)?></span>
	  <span id="htmlshowSpan" <?php if(!$rewrite) echo 'style="display:none"';?>><?=form::select_urlrule('ask', 'htmlshow', 0, 'htmlshow', 'htmlshow', $showUrlRuleid)?></span>
	  </td>
    </tr>
	<tr>
      <th ><strong>模块访问网址（URL）</strong></th>
      <td><input name='setting[url]' type='text' id='url' value='<?=$url?>' size='40' maxlength='50'></td>
    </tr>
</table>

<table width="100%" height="25" cellpadding="0" cellspacing="1">
  <tr>
     <td width='40%'></td>
     <td>
	 <input type="hidden" name="hiddenShowUrlRuleid" value="<?=$showUrlRuleid?>">
	 <input type="hidden" name="hiddenCategoryUrlRuleid" value="<?=$categoryUrlRuleid?>">
	 <input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>