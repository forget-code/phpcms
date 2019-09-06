<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
   <th colspan="2"><?=$MODULE[$mod]['name']?>模块配置</th>
	<tr>
      <td width='40%' class='tablerow'><strong>每页显示多少条记录</strong></td>
      <td class='tablerow'><input name='setting[higth_score]' type='text' id='answer_give_credit' value='<?=$higth_score?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>高分问题上限设定</strong></td>
      <td class='tablerow'><input name='setting[higth_score]' type='text' id='answer_give_credit' value='<?=$higth_score?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>匿名默认扣除积分设定</strong></td>
      <td class='tablerow'><input name='setting[anybody_score]' type='text' id='answer_give_credit' value='<?=$anybody_score?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>会员回答问题奖励积分</strong></td>
      <td class='tablerow'><input name='setting[answer_give_credit]' type='text' id='answer_give_credit' value='<?=$answer_give_credit?>' size='5' maxlength='50'></td>
    </tr>

    <tr>
      <td width='40%' class='tablerow'><strong>会员投票奖励积分</td>
      <td class='tablerow'><input name='setting[vote_give_credit]' type='text' id='vote_give_credit' value='<?=$vote_give_credit?>' size='5' maxlength='50'></td>
    </tr>
	 <tr>
      <td width='40%' class='tablerow'><strong>高分上限设置</td>
      <td class='tablerow'><input name='setting[highscore]' type='text' id='highscore' value='<?=$highscore?>' size='5' maxlength='50'></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>会员角色系列名称</strong><br />每行填写一个</td>
      <td class='tablerow'><textarea name='setting[vote_give_actor]' id='vote_give_credit' cols='40' rows='5' id='seo_title'><?=$vote_give_actor?></textarea></td>
    </tr>
	 <tr>
      <td width='40%' class='tablerow'><strong>问吧首页自动更新间距</td>
      <td class='tablerow'><input name='setting[autoupdate]' type='text' id='highscore' value='<?=$autoupdate?>' size='5' maxlength='50'> 秒</td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>模块绑定域名</strong><br>最后不带反斜线'/'</td></td>
      <td class='tablerow'><input name='setting[moduledomain]' type='text' id='moduledomain' value='<?=$moduledomain?>' size='40' maxlength='50'></td>
    </tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>