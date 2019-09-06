<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>

<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>修改投票</th>
  </tr>
<form method="post" name="myform" action="?mod=vote&file=vote&action=edit&keyid=<?=$keyid?>&voteid=<?=$voteid?>">
          <tr>
            <td align="left" valign="middle" width="20%">投票主题</td>
            <td width="80%"><input name="subject" size="50"  maxlength="100" value="<?=$subject?>">
		 <font color="#FF0000"> *</font></td>
          </tr>

		<tr>
        <td  align="left">背景资料</td>
        <td><textarea name="voteinfo[detail]"  rows="3"><?=$detail?></textarea>
        </td>
		</tr>
		  <tr>
            <td align="left">起始日期</td>
            <td><?=form::date('voteinfo[fromdate]',$fromdate)?>
                <font color="#FF0000">*</font></td>
          </tr>
          <tr>
            <td align="left">截止日期</td>
            <td>&nbsp;到&nbsp;<?=form::date('voteinfo[todate]',$todate)?><font color="#FF0000">*</font>
            </td>
          </tr>
          <tr >
            <td align="left">选项类型</td>
            <td>
		<input name="optiontype" type="radio" value="0" >单选&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="optiontype" type="radio" value="1">
        多选</td>
          </tr>

		<tr>
        <td  align="left">是否启用验证码</td>
        <td><input type="radio" name="voteinfo[checkcode]" value="1" />启用&nbsp;&nbsp;&nbsp;
        <input type="radio" name="voteinfo[checkcode]" value="0" checked="checked" />不启用
        </td>
		</tr>
		<tr>
        <td  align="left">是否允许游客投票</td>
        <td>
        <input name="voteinfo[anonymous]" type="radio" value="1" <?=$anonymous?'checked':''?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
     	<input name="voteinfo[anonymous]" type="radio" value="0" <?=(!$anonymous)?'checked':''?>> 否
        </td>
		</tr>
        <tr >
          <td align="left">投票选项</td>
          <td><input type="button" value="添加选项" id="addItem">
              <input type="button" value="清除选项" id="descItem">
          </td>
          </tr>
		  <?php
		  foreach($ops as $i=>$op)
		  {
			  $i++;
		  ?>
			<tr>
			<td>
			 选项<?=$i?>
			</td>
			 <td>
			 文字:<input type='text' size='50' name='option[<?=$op['optionid']?>]'  id='option<?=$op['optionid']?>'
			 value="<?=$op['option']?>">
			 图片:<input type="text" name="pic[<?=$op['optionid']?>]" value="<?=$op['pic']?>" id="pic<?=$op['optionid']?>">
			 <input type="button" value="浏览..." sn="1" onclick="addPic(<?=$op['optionid']?>)" />
			</td>
		</tr>
    <?php
		}
	?>
		<tr>
		<td colspan="2"><div id="voteitem"></div>
		</td>
		</tr>
	<tr>
      <td>模板设置</td>
      <td>
       <?=$showtpl?>
   </td>
    </tr>
	<tr>
     <td align="left">是否允许游客投票</td>
     <td>
	 <input name="enableTourist" type="radio" value="1" style="border:0" <?php if($attribute)	echo 'checked="checked"';?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
     <input name="enableTourist" type="radio" value="0" style="border:0" <?php if(!$attribute)	echo 'checked="checked"';?>> 否
	 </td>
  </tr>
	<tr>
    <td align="left"></td>
            <td>
			 	<input type="hidden" name="forward" value="<?=$forward?>" >
                <input type="submit" value=" 确定修改 " name="submit">
            </td>
          </tr>
       </form>
      </table>
</body>
<script>
$('td').addClass('tablerow');
$('input[name="optiontype"][value="<?=$optiontype?>"]').attr({checked:true});
</script>
</html>