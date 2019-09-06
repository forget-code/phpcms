<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script> 
<script language="javascript">
     var i=<?=$number?>;
     function AddItem()
     { 
        i++;
		if(i>50)
		{
			alert("选项不得超过50个！");
			return;
		}
        document.all.voteitem.innerHTML+="<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td class='tablerow' align='left' width='20%'>选项"+i+"</td><td class='tablerow' width='80%'><input name='voteoption[]' type='text' size='50' maxlength='100'></td></tr></table>";
     }
	function ResetItem()
    { 
        i = <?=$number?>;
		document.all.voteitem.innerHTML="";
    }
</script>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>修改投票</th>
  </tr>
<form method="post" name="myform" action="?mod=vote&file=vote&action=edit&channelid=<?=$channelid?>&voteid=<?=$voteid?>">
          <tr>
            <td class="tablerow" align="left" valign="middle" width="20%">投票主题</td>
            <td class="tablerow" width="80%"><input name="subject" size="50"  maxlength="100" value="<?=$subject?>">
		 <font color="#FF0000"> *</font></td>
          </tr>
		  <tr>
            <td class="tablerow" align="left">起始日期</td>
            <td class="tablerow">
<script language=javascript>var dateFrom=new MyCalendar("fromdate","<?=$fromdate?>","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script>
                <font color="#FF0000">*</font> 格式：yyyy-mm-dd</td>
          </tr>
          <tr>
            <td class="tablerow" align="left">截止日期</td>
            <td class="tablerow">
<script language=javascript>var dateFrom=new MyCalendar("todate","<?=$todate?>","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script>
                <font color="#FF0000">*</font> 留空为不限制, 格式：yyyy-mm-dd</td>
          </tr>
          <tr >
            <td class="tablerow" align="left">类型</td>
            <td class="tablerow">
	<input name="type" type="radio" value="radio" style="border:0" <?php if($type=="radio") echo "checked"; ?>>
        单选&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="type" value="checkbox" style="border:0" <?php if($type=="checkbox") echo "checked"; ?>>
        多选</td>
          </tr>
          <tr >
            <td class="tablerow" align="left">投票选项</td>
            <td class="tablerow">
              <input type="button" value="添加选项" name="addoption" onClick="AddItem();">
              <input type="button" value="清除选项" name="resetoption" onClick="ResetItem();">
            </td>
          </tr>
		  <?php 
		  foreach($ops as $i=>$op)
		  {
			  $i++;
		  ?>
		<tr>
			<td class="tablerow">
			 选项<?=$i?>
			</td>
			 <td class="tablerow">
			 <input type='text' size='50' name='voteoptionedit[<?=$op['optionid']?>]'  id='voteoptionedit<?=$op['optionid']?>' value="<?=$op['option']?>">
			</td>
		</tr>
     <?php 
		}
	?>
		<tr>
		<td colspan="2" class="tablerow"><div id="voteitem"></div>
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
            <td class="tablerow" align="left"></td>
            <td class="tablerow">
			 	<input type="hidden" name="referer" value="<?=$PHP_REFERER?>" >
                <input type="submit" value=" 确定修改 " name="submit">
            </td>
          </tr>
       </form>
      </table>
</body>
</html>