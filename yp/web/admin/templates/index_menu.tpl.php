<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<script>
function show(c_Str){
if(document.all(c_Str).style.display=='none'){
document.all(c_Str).style.display='block'
}else{
document.all(c_Str).style.display='none'
}
}
</script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
  <tr>
    <td class="tablerow">
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align=center>
		<a href="?file=index&action=main" target="right">首页</a> | <a href="?mod=phpcms&file=logout" target="right">退出</a></td>
      </tr>
      <tr>
        <td>

        <table width="100%"  border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td>

           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
		   <tr>
                    <th><font color=#ffffff>基本信息</font></th>
				 </tr>
                 <TBODY style="display:''" id="setting">
				 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=companyinfo" target="right">公司信息</a></td>
                  </tr>
				    <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=banner" target="right">Banner管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=introduce" target="right">公司简介</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=templates" target="right">模板管理</a></td>
                  </tr>
                   <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="<?=$SITEURL?>/member/editpassword.php" target="right">修改密码</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="<?=$SITEURL?>/member/edit.php" target="right">个人资料修改</a></td>
                  </tr>
                </tbody>
        </table>

		</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>