<?php defined("IN_PHPCMS") or exit("Access Denied");
include admintpl("header");
?>
<body>
<script LANGUAGE="javascript">
<!--
function Check() {
	if ($F('subject')=="")
	{
		alert("请输入播放器名称");
		Field.clear('subject')
		Field.focus('subject');
		return false
	}
	  if ($F('code')=="")
	{
		alert("请输入播放器代码");
		Field.clear('code')
		Field.focus('code');
		return false
	}
     return true;
}
//-->
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td><?=$menu?></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr align="center">
    <th colspan=3>播放器编辑</th>
  </tr>
<form method="post" name="myform" onsubmit="return Check()" action="?mod=movie&file=player&action=<?=$action?>&playerid=<?=$playerid?>">

          <tr >
            <td class="tablerow" align="right">播放器名称</td>
            <td class="tablerow"><input name="subject" size="30" id="subject" maxlength="30" type="text"  value="<?=$subject?>">
            </td>
          </tr>
   
          <tr >
            <td class="tablerow" align="right">播放器代码</td>
            <td valign="middle" class="tablerow"><textarea name="code" id="code" cols="110" rows="20" id="introduction"><?=$code?></textarea></td>
          </tr>

          <tr >
            <td class="tablerow" align="right"></td>
            <td class="tablerow">
                <input type="submit" value=" 确定 " name="submit">
                 <input type="reset" value=" 清除 " name="reset">
            </td>
          </tr>
       </form>
      </table>
	   <br/>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align=center>参数提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">

	1、<B>{$title}</B> :影片标题 <br/>
	2、<B>{$filepath}</B> :加密后的文件地址<br/>
	3、<B>{$tureUrl}</B> :真实文件地址<br/>
	4、<B>{$PHPCMS[siteurl]}</B> :网站主域名地址，若频道绑定域名必须使用，可参考“精美real播放器”代码<br/>
	5、<B>{$PHPCMS[sitename]}</B> :网站名称
	</td>
  </tr>
</table>
</body>
</html>