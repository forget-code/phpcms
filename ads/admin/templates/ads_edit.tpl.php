<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function checkform()
{
	var adsname = $('#adsname').val();
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
	return true;
}
function alterUC(eID) {
	$("#table tbody").hide();
	$("#"+eID).show();
}

//-->
</SCRIPT>
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>编辑广告</caption>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&adsid=<?=$adsid?>&dosubmit=1" method="post" name="myform" enctype="multipart/form-data" onSubmit="return checkform();">
	    <tr>
      <th width="20%"><strong>广告名称</strong></th>
      <td>
	  <input type="hidden" name='ads[placeid]' value='<?=$_ads['placeid']?>'>
      <input size=40 name="ads[adsname]" type="text" value="<?=$_ads['adsname']; ?>" id="adsname"> <font color="red">*</font>
     </td>
    </tr>
	<tr>
	<th><strong>广告介绍</strong></th>
	<td>
	<input size=60 name="ads[introduce]" type="text" value="<?=$_ads['ads_introduce']; ?>">
	</td>
	</tr>
	<tr>
	<th><strong>广告类型</strong></th>
	<td>
	<input type='radio' name='ads[type]' value='image' onclick="alterUC('imageid')" <?php if($_ads['type']=='image') {?>checked<? } ?>>
        图片
        <input type='radio' name='ads[type]' value='flash' onclick="alterUC('flashid')" <?php if($_ads['type']=='flash') {?>checked<? } ?>>
        FLASH
        <input type='radio' name='ads[type]' value='text' onclick="alterUC('textid')" <?php if($_ads['type']=='text') {?>checked<? } ?>>
        文本
        <input type='radio' name='ads[type]' value='code' onclick="alterUC('codeid')" <?php if($_ads['type']=='code') {?>checked<? } ?>>
        文字链 <font color="red">*</font>
	</td>
	</tr>
	<tr>
	<th><strong>广告内容</strong></th>
	<td>
  <table cellpadding="0" cellspacing="0" id="table">
          <tbody id="imageid" style="display:none">
            <tr>
              <td> 上传图片：&nbsp;<?=form::upload_image("ads[imageurl]", 'thumb', $_ads['imageurl'])?><font color="red">*</font><br/>
                图片提示：
                <input type="text" name="ads[alt]" size="50" value="<?=$_ads['alt']?>">
                <br/>
                链接地址：
                <input name="ads[linkurl]" type="text" size="50" value="<?=$_ads['linkurl']?>" id="linkurl">
                <font color="red">*</font><br />
                上传图片1：<?=form::upload_image("ads[s_imageurl]", 'thumb1', $_ads['s_imageurl'])?><br />
                (第二张图片当广告为随屏移动广告或者对联广告的时有效) </td>
            </tr>
          </tbody>
          <tbody id="flashid" style="display:none">
            <tr>
              <td> FLASH地址：&nbsp;<?=form::file("flash", 'flash')?><input type='hidden' name="ads[flashurl]" value="<?=$_ads['flashurl']?>"><font color="red">*</font><br/>
                背景透明：
                <input type='radio' name='ads[wmode]' value='transparent' <?php if($_ads['wmode']=='transparent') {?>checked<? }?>>
                是
                <input type='radio' name='ads[wmode]' value='' <?php if($_ads['wmode']=='') {?>checked<? }?>>
                否 </td>
            </tr>
          </tbody>
          <tbody id="textid" style="display:none">
            <tr>
              <td><textarea name='ads[text]' cols='64' rows='15' id='text'><?=$_ads['text']?></textarea>
                <font color="red">*</font> </td>
            </tr>
          </tbody>
          <tbody id="codeid" style="display:none">
            <tr>
              <td>链接内容：<input type='text' name='ads[code]' size=40 value='<?=$_ads['code']?>'><font color="red">*</font><br />
                链接地址：<input type='text' name='ads[text_link]' size=40 value='<?=$_ads['linkurl']?>' id="text_link"><font color="red">*</font> </td>
            </tr>
          </tbody>
        </table>
	</td>
	</tr>
		<tr>
	<th><strong>客户帐号</strong></th>
	<td>
	<input size=20 name="ads[username]" id="username" type="text" value="<?=$_ads['username']?>">
	</td>
	</tr>
		<tr>
	<th><strong>广告发布日期</strong></th>
	<td>
		<?=form::date('ads[fromdate]',date('Y-m-d', $_ads['fromdate']))?>
 <font color="red">*</font>
	</td>
	</tr>
		<tr>
	<th><strong>广告结束日期</strong></th>
	<td>
	<?=form::date('ads[todate]', date('Y-m-d', $_ads['todate']))?> <font color="red">*</font>
	</td>
	</tr>
     <tr>
         <th><strong>是否通过</strong></th>
         <td><input type='radio' name='ads[passed]' value='1' <?=$_ads['passed']?"checked":""?>> 是 <input type='radio' name='ads[passed]' value='0' <?=!$_ads['passed']?"checked":""?>> 否</td>
     </tr>
    <tr>
	  <td></td>
      <td> <input type="submit" name="submit" value=" 修改 ">
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
<SCRIPT LANGUAGE="JavaScript">
<!--
alterUC("<?=$_ads['type'];?>id");
//-->
</SCRIPT>

</body>
</html>