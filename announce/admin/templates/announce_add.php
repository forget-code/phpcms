<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script type="text/javascript" src="<?=PHPCMS_PATH?>fckeditor/fckeditor.js"></script>
<script type="text/javascript">
	var editorBasePath = '<?=PHPCMS_PATH?>fckeditor/';
	var ChannelId = <?=$channelid?> ;
</script>

<script type="text/javascript">
window.onload = function()
{
	var oFCKeditor = new FCKeditor('content') ;
	oFCKeditor.BasePath	= editorBasePath ;
	oFCKeditor.ReplaceTextarea() ;
}
</script>

<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script>
<script language=JavaScript>
// 表单提交检测
function doCheck(){

	// 检测表单的有效性
	// 如：标题不能为空，内容不能为空，等等....
	if (myform.title.value=="") {
		alert("请输入标题");
		return false;
	}
}
</script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>公告添加</th>
  </tr>
  <form name="myform" id="myform" method="post" action="?mod=announce&file=announce&action=<?=$action?>&channelid=<?=$channelid?>&submit=1" onSubmit="return doCheck();">
    <tr> 
      <td width="15%" class="tablerow">标题</td>
      <td width="85%" class="tablerow"><input name="title" type="text" size="60"></td>
    </tr>
<tr>
<td class="tablerow"> 起始日期 </td>
<td class="tablerow"><script language=javascript>var dateFrom=new MyCalendar("fromdate","<?=$today?>","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script> 格式：yyyy-mm-dd </td></tr>

<tr>
<td class="tablerow"> 截止日期 </td>
<td class="tablerow"><script language=javascript>var dateFrom=new MyCalendar("todate","","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script> 格式：yyyy-mm-dd</td></tr>
<tr>
<td class="tablerow">公告内容</td>
<td class="tablerow"><textarea name="content" style="display:none"></textarea></td></tr>
<tr>
<td class="tablerow">公告状态</td>
	  <td class="tablerow">
      <input name="passed" id="passed" type="radio" value="1" checked/> 通过&nbsp;&nbsp;
	  <input name="passed" id="passed" type="radio" value="0"/> 待审核</td>
    </tr>
	<tr> 
      <td class="tablerow">风格设置</td>
      <td class="tablerow">
       <?=$showskin?>   </td>
    </tr> 
	<tr> 
      <td class="tablerow">模板设置</td>
      <td class="tablerow">
       <?=$showtpl?>   </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
        <input type="submit" name="Submit" value=" 确定 " > &nbsp;
        <input type="reset" name="Reset" value=" 清除 ">      </td>
    </tr>
  </form>
</table>
</body>
</html>   