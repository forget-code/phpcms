<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
echo "$menu<div style='text-align:left'>当前位置：添加会员头衔方案</div>";
?>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<thead>
		<tr>
			<th colspan="7"><?php echo $title; ?></th>
		</tr>
	</thead>
	<tbody class="trbg1">
		<tr><form name="myform" action="<?php echo $curUri; ?>" method="post">
			<td width="20%" align="right" valign="middle"></td>
			<td width="10%" align="left" valign="middle">等级</td>
			<td align="left" valign="middle" width="10%">最小积分</td>
			<td align="left" width="10%">最大积分</td>
			<td width="50%"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[0]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[0]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[0]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[1]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[1]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[1]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[2]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[2]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[2]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[3]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[3]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[3]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[4]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[4]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[4]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[5]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[5]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[5]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[6]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[6]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[6]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[7]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[7]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[7]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[8]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[8]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[8]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[9]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[9]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[9]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[10]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[10]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[10]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[11]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[11]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[11]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[12]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[12]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[12]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[13]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[13]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[13]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[14]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[14]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[14]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[15]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[15]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[15]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[16]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[16]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[16]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[17]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[17]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[17]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[18]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[18]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[18]['maxscore']?>" size="10"></td>
		</tr>
		<tr> 
		  <td width="20%" align="right" valign="middle"></td>
		  <td width="10%" align="center" valign="middle"><input name="class[]" type="text" value="<?php echo $score_list[19]['lev']?>" size="10"></td>
		  <td align="left" valign="middle" width="10%"><input name="minscore[]" type="text" value="<?php echo $score_list[19]['minscore']?>" size="10"></td>
		  <td><input name="maxscore[]" type="text" value="<?php echo $score_list[19]['maxscore']?>" size="10"></td>
		</tr>
		<br>
		<tr>
			<td align="center" valign="middle">&nbsp;</td>
			<td align="left" valign="middle" colspan="3"><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;<input type="reset" value=" 清除 "></td>
		</tr>
	</tbody></form>
</table>
</body>
</html>