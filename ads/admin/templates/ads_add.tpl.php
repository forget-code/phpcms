<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function checkform()
{
	if($('#adsname').val() == '')
	{
		alert("请填写广告名称");
		$('#adsname').focus();
		return false;
	}
	var linkurl = $('#linkurl').val();
	if(linkurl)
	{
		if(!linkurl.search('http:'))
		{
			alert('链接地址不需要包含http://');
			$('#linkurl').val('');
			$('#linkurl').focus();
			return false;
		}
	}
	var text_link = $('#text_link').val();
	if(text_link)
	{
		if(!text_link.search('http:'))
		{
			alert('链接地址不需要包含http://');
			$('#text_link').val('');
			$('#text_link').focus();
			return false;
		}
	}
}
function alterUC(eID) {
	$("#table tbody").hide();
	$("#"+eID).show();
}

//-->
</SCRIPT>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&dosubmit=1" method="post" name="myform" enctype="multipart/form-data" onSubmit="return checkform(this);return flase;">
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>添加广告</caption>
    <tr>
      <th width="20%"><strong>广告位</strong></th>
      <td>
<?=form::select($places, 'ads[placeid]', 'placeid', $placeid);?>
 <font color="red">*</font>
</td>
    </tr>
	    <tr>
      <th><strong>广告名称</strong></th>
      <td>
      <input size=40 name="ads[adsname]" type="text" id="adsname"> <font color="red">*</font>
     </td>
    </tr>
	<tr>
	<th><strong>广告介绍</strong></th>
	<td>
	<input size=60 name="ads[introduce]" type=text>
	</td>
	</tr>
	<tr>
	<th><strong>广告类型</strong></th>
	<td>
	<input type='radio' name='ads[type]' value='image' onclick="alterUC('imageid')" checked>
        图片
        <input type='radio' name='ads[type]' value='flash' onclick="alterUC('flashid')">
        FLASH
        <input type='radio' name='ads[type]' value='text' onclick="alterUC('textid')">
        文本
        <input type='radio' name='ads[type]' value='code' onclick="alterUC('codeid')">
        文字链 <font color="red">*</font>
	</td>
	</tr>
	<tr>
	<th><strong>广告内容</strong></th>
	<td>
	<table cellpadding="0" cellspacing="0" id="table">
          <tbody id="imageid" style="display:none">
            <tr>
              <td> 上传图片：&nbsp;<?=form::file("thumb", 'thumb')?><font color="red">*</font><br/>
                图片提示：
                <input type="text" name="ads[alt]" size="50">
                <br/>
                链接地址：
                 http://<input name="ads[linkurl]" type="text" size="43" id='linkurl'>
                <font color="red">*</font><br />
                上传图片1：<?=form::file("thumb1", 'thumb1')?><br />
                (第二张图片当广告为随屏移动广告或者对联广告的时有效) </td>
            </tr>
          </tbody>
          <tbody id="flashid" style="display:none">
            <tr>
              <td> FLASH地址：&nbsp;<?=form::file("flash", 'flash')?><font color="red">*</font><br/>
                背景透明：
                <input type='radio' name='ads[wmode]' value='transparent' checked>
                是
                <input type='radio' name='ads[wmode]' value=''>
                否 </td>
            </tr>
          </tbody>
          <tbody id="textid" style="display:none">
            <tr>
              <td><textarea name='ads[text]' cols='64' rows='15' id='text'></textarea>
                <font color="red">*</font> </td>
            </tr>
          </tbody>
          <tbody id="codeid" style="display:none">
            <tr>
              <td>链接内容：<input type='text' name='ads[code]' size=47><font color="red">*</font><br />
                链接地址：http://<input type='text' name='ads[text_link]' size=40 id="text_link"><font color="red">*</font> </td>
            </tr>
          </tbody>
        </table>
	</td>
	</tr>
		<tr>
	<th><strong>客户帐号</strong></th>
	<td>
	<input size=20 name="ads[username]" id="username" type="text">
	</td>
	</tr>
		<tr>
	<th><strong>广告发布日期</strong></th>
	<td>
	<?=form::date('ads[fromdate]', date('Y-n-j'))?> <font color="red">*</font>
	</td>
	</tr>
		<tr>
	<th><strong>广告结束日期</strong></th>
	<td>
	<?=form::date('ads[todate]', date('Y-n-j', mktime(0, 0, 0, date('n')+1, date('j'), date('Y'))))?> <font color="red">*</font>
	</td>
	</tr>
     <tr>
         <th><strong>是否通过</strong></th>
         <td><input type='radio' name='ads[passed]' value='1' checked> 是 <input type='radio' name='ads[passed]' value='0'> 否</td>
     </tr>
    <tr>
	  <td></td>
      <td> <input type="submit" name="submit" value=" 添加 " >
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
</table>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
alterUC('imageid');
//-->
</SCRIPT>
</body>
</html>