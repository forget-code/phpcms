<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<script LANGUAGE="javascript">
<!--
function Check() {
	if (document.myform.name.value=="")
	{
	  alert("请输入网站名称")
	  document.myform.name.focus()
	  return false
	 }
	if (document.myform.url.value=="")
	{
	  alert("请输入网站地址")
	  document.myform.url.focus()
	  return false
	 }
	if (document.myform.url.value=="http://")
	{
	  alert("请输入网站地址")
	  document.myform.url.focus()
	  return false
	}
	if (document.myform.password.value!="" && document.myform.pwdconfirm.value!=document.myform.password.value)
	{
	  alert("两次输入的密码不一致！")
	  document.myform.pwdconfirm.focus()
	  document.myform.pwdconfirm.select()
	  return false
	 }
     return true;
}
//-->
</script>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2><? if($action=='add') { ?>添加<? } else { ?>修改<? } ?>友情链接</th>
  </tr>
<form method="post" name="myform" onsubmit="return Check()" action="?mod=link&file=link&action=<?=$action?>&siteid=<?=$site[siteid]?>&channelid=<?=$channelid?>">
          <tr >
            <td class="tablerow" align="right">链接类型</td>
            <td class="tablerow">
<input name="linktype" type="radio" value="1" <? if($site[linktype]) { ?>checked<? } ?> style="border:0">
        Logo链接&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="linktype" value="0" <? if(!$site[linktype]) { ?>checked<? } ?> style="border:0">
        文字链接</td>
          </tr>
          <tr >
            <td class="tablerow" align="right" valign="middle">网站名称</td>
            <td class="tablerow"><input name="name" size="30"  maxlength="20" value="<?=$site[name]?>">
                <font color="#FF0000"> *</font></td>
          </tr>
          <tr >
            <td class="tablerow" align="right">网站地址</td>
            <td class="tablerow"><input name="url" size="30"  maxlength="100" type="text"  value="<?=$site[url]?>">
                <font color="#FF0000">*</font></td>
          </tr>
          <tr >
            <td class="tablerow" align="right">网站Logo</td>
            <td class="tablerow"><input name="logo" size="30"  maxlength="100" type="text"  value="<?=$site[logo]?>"> 大小规格为88*31像素</td>
          </tr>
          <tr>
            <td class="tablerow" align="right" >站长姓名</td>
            <td class="tablerow"><input name="username" size="30"  maxlength="20" type="text"  value="<?=$site[username]?>">
                可不填</td>
          </tr>
          <tr >
            <td class="tablerow" align="right">站长邮箱</td>
            <td class="tablerow"><input name="email" size="30"  maxlength="30" type="text"  value="<?=$site[email]?>">
                可不填</td>
          </tr>
          <tr >
            <td class="tablerow" align="right">密码</td>
            <td class="tablerow"><input name="password" type="password" id="password" size="20" maxlength="20"> 可不填
                 </td>
          </tr>
          <tr >
            <td class="tablerow" align="right">确认密码</td>
            <td class="tablerow"><input name="pwdconfirm" type="password" id="pwdconfirm" size="20" maxlength="20"> 可不填
                 </td>
          </tr>
          <tr >
            <td class="tablerow" align="right">网站介绍</td>
            <td valign="middle" class="tablerow"><textarea name="introduction" cols="40" rows="5" id="introduction"><?=$site[introduction]?></textarea></td>
          </tr>
          <tr >
            <td class="tablerow" align="right">推荐</td>
            <td class="tablerow"><input type='radio' name='elite' value='1' <? if($site[elite]) { ?>checked<? } ?>> 是 <input type='radio' name='elite' value='0' <? if(!$site[elite]) { ?>checked<? } ?>> 否</td>
          </tr>
		  <?if($action=='add') { ?>
		  <tr>
            <td class="tablerow" align="right">批准</td>
            <td class="tablerow"><input type='radio' name='passed' value='1' checked> 是 <input type='radio' name='passed' value='0'> 否</td>
          </tr>
		  <? } else { ?>
          <tr>
            <td class="tablerow" align="right">批准</td>
            <td class="tablerow"><input type='radio' name='passed' value='1' <? if($site[passed]) { ?>checked<? } ?>> 是 <input type='radio' name='passed' value='0' <? if(!$site[passed]) { ?>checked<? } ?>> 否</td>
          </tr>
		  <? } ?>
          <tr >
            <td class="tablerow" align="right"></td>
            <td class="tablerow">
                <input type="submit" value=" 确定 " name="submit">
                 <input type="reset" value=" 清除 " name="reset">
            </td>
          </tr>
       </form>
      </table>
</body>
</html>
