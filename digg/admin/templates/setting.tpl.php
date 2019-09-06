<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<script type="text/javascript">
    <!--
    function CheckForm()
	{
	if(document.myform.main_num.value<=0)
	{
		alert('当天列表数必须大于零');
		document.myform.main_num.focus();
		return false;
	}
	if(document.myform.week_num.value<=0)
	{
		alert('每周列表数必须大于零');
		document.myform.week_num.focus();
		return false;
	}

	if(document.myform.mouth_num.value<=0)
	{
		alert('每月列表数必须大于零');
		document.myform.mouth_num.focus();
		return false;
	}
	if(document.myform.credit_num.value<=0)
	{
		alert('兑换积分设置必须大于零');
		document.myform.credit_num.focus();
		return false;
	}

	if(document.myform.digg_cookie.value<=0)
	{
		alert('有效点击日期间隔设置必须大于零');
		document.myform.digg_cookie.focus();
		return false;
	}

	if(document.myform.text_num.value<=0)
	{
		alert('当日显示内容的字数必须大于零');
		document.myform.text_num.focus();
		return false;
	}
}


function InitAjax()
{
　var ajax=false;
　try {
　　ajax = new ActiveXObject("Msxml2.XMLHTTP");
　} catch (e) {
　　try {
　　　ajax = new ActiveXObject("Microsoft.XMLHTTP");
　　} catch (E) {
　　　ajax = false;
　　}
　}
　if (!ajax && typeof XMLHttpRequest!='undefined') {
　　ajax = new XMLHttpRequest();
　}
　return ajax;
}
//点击操作函数
function showimage(id,url)
{
  var url =url+"show_images.php?id="+id;
	var show = document.getElementById('style_digg');
　var ajax = InitAjax();
　ajax.open("GET", url, true);
　ajax.onreadystatechange = function() {
　　if (ajax.readyState == 4 && ajax.status == 200) {
　　　show.innerHTML = ajax.responseText;
　　}
　}
　ajax.send(null);
}

   / -->
</script>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>

<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>" onSubmit='return CheckForm();'>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1"  class="tableborder">
  <tr>
    <th colspan="2"><strong>DIGG模块设置</strong></th>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>是否启用兑换积分</strong></td>
    <td width="75%" height="25" ><label>
      启用
          <input name="digg[credit_on]" type="radio" value="1" <?php if ($credit_on==1) {?>checked="checked"<?php }?> />
          禁用
          <input type="radio" name="digg[credit_on]" value="0" <?php if ($credit_on==0) {?>checked="checked"<?php }?>/>
    </label></td>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>多少点击兑换1点积分（必须&gt;0）</strong></td>
    <td height="25" ><input name="digg[credit_num]" type="text" id="credit_num" value="<?=$credit_num?>" size="10" /></td>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>有效点击日期间隔</strong></td>
    <td height="25" ><label>
      <input name="digg[digg_cookie]" type="text" id="digg_cookie" value="<?=$digg_cookie?>" size="10" />
      天
    </label></td>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>是否把“顶”和“踩”分开统计</strong></td>
    <td height="25" >是
      <input name="digg[hits_on]" type="radio" value="1" <?php if ($hits_on==1) {?>checked="checked"<?php }?> />
      否
      <input type="radio" name="digg[hits_on]" value="0" <?php if ($hits_on==0) {?>checked="checked"<?php }?>/></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="5">
  <tr>
    <td width="30%">&nbsp;</td>
    <td width="70%"><label>
      <input name="dosubmit" type="submit" id="dosubmit" value="提交" />
      <input type="reset" name="Submit2" value="重置" />
    </label></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1"class="tableborder">
  <tr>
    <th colspan="7">提示信息</th>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="20"><p>此模块暂时只可以在<span class="STYLE1">“文章”“下载”“图片”“信息”“影视”“商城”</span></p></td>
  </tr>
</table>
</form>
