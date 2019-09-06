<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script> 
<script language="javascript">
     var i=1;
     function AddItem()
     { 
        i++;
		if(i>50)
		{
			alert("!maxoptions!");
			return;
		}
        $('voteitem').innerHTML+="<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td class='tablerow' align='left' width='20%'>选项"+i+"</td><td class='tablerow' width='80%'><input name='voteoption[]' type='text' size='50' maxlength='100'></td></tr></table>";
     }
	function ResetItem()
    { 
        i = 1;
		$('voteitem').innerHTML="<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td class='tablerow' align='left' width='20%'>选项"+i+"</td><td class='tablerow' width='80%'><input name='voteoption[]' type='text' size='50' maxlength='100'></td></tr></table>";
    }
</script>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加投票</th>
  </tr>
<form method="post" name="myform" action="?mod=vote&file=vote&action=add&keyid=<?=$keyid?>">
          <tr>
            <td class="tablerow" align="left" valign="middle" width="20%">投票主题</td>
            <td class="tablerow" width="80%"><input name="subject" size="50"  maxlength="100">
		 <font color="#FF0000"> *</font></td>
          </tr>
		  <tr>
            <td class="tablerow" align="left">起始日期</td>
            <td class="tablerow"><?=date_select('fromdate', $fromdate)?>
                <font color="#FF0000">*</font> 格式：yyyy-mm-dd</td>
          </tr>
          <tr>
            <td class="tablerow" align="left">截止日期</td>
            <td class="tablerow"><?=date_select('todate', $todate)?>
                <font color="#FF0000">*</font> 留空为不限制, 格式：yyyy-mm-dd</td>
          </tr>
          <tr >
            <td class="tablerow" align="left">类型</td>
            <td class="tablerow">
	<input name="type" type="radio" value="radio" checked style="border:0">
        单选&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="type" value="checkbox" style="border:0">
        多选</td>
          </tr>
          <tr >
            <td class="tablerow" align="left">投票选项</td>
            <td class="tablerow">
              <input type="button" value="添加选项" name="addoption" onClick="AddItem();">
              <input type="button" value="清除选项" name="resetoption" onClick="ResetItem();">
            </td>
          </tr>
  <tr>
    <td colspan=2 class="tablerow">
   <div id="voteitem">
       <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr> 
            <td class="tablerow" align="left" width="20%">选项1</td>
            <td class="tablerow" width="80%">
			<input name="voteoption[]" type="text" id="voteoption[]" size="50" maxlength="100">
	    </td>
          </tr>
      </table>
   </div>
      </td>
  </tr>
   <tr> 
      <td class="tablerow">风格设置</td>
      <td class="tablerow">
       <?=$showskin?>
   </td>
    </tr> 
	<tr> 
      <td class="tablerow">模板设置</td>
      <td class="tablerow">
       <?=$showtpl?>
   </td>
    </tr>
	<tr>
     <td class="tablerow" align="left">是否允许游客投票</td>
     <td class="tablerow">
	 <input name="enableTourist" type="radio" value="1" style="border:0" <?php if($MOD['enableTourist'])	echo 'checked="checked"';?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
     <input name="enableTourist" type="radio" value="0" style="border:0" <?php if(!$MOD['enableTourist'])	echo 'checked="checked"';?>> 否
	 </td>
   </tr>
   <tr>
     <td class="tablerow" align="left">立即发布</td>
     <td class="tablerow">
	 <input name="passed" type="radio" value="1" checked style="border:0"> 是&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="radio" name="passed" value="0" style="border:0"> 否
	 </td>
     </tr>
     <tr>
        <td class="tablerow" align="left"></td>
            <td class="tablerow">
 			     <input type="hidden" name="referer" value="<?=$PHP_REFERER?>" >
                 <input type="submit" value=" 确定 " name="submit">
                 <input type="reset" value=" 清除 " name="reset">
            </td>
          </tr>
       </form>
      </table>
</body>
</html>