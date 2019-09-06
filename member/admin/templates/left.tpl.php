<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript">
function show(c_Str){
if($(c_Str).style.display=='none'){
$(c_Str).style.display='';
$(c_Str+"_img").src='<?=PHPCMS_PATH?>admin/skin/images/on.gif';
}else{
$(c_Str).style.display='none';
$(c_Str+"_img").src='<?=PHPCMS_PATH?>admin/skin/images/off.gif';
}
}
</script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
  <tr>
    <td class="tablerow">
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><a href="?file=index&action=main" target="right">首页</a> | <a href="javascript:parent.location.href='?mod=phpcms&file=logout'">退出</a></td>
      </tr>
      <tr>
        <td>

        <table width="100%"  border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td>

           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">

                  <tr>
                    <th class="white" onclick="javascript:show('member')"><img src="<?=PHPCMS_PATH?>admin/skin/images/off.gif" width="20" height="9" id="member_img"><a href="###">会员管理</a></td>
                  </tr>
                 <TBODY style="display:" id="member">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=member&file=member&action=check" target="right">审核新会员</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=member&file=member&action=manage" target="right">会员管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=member&file=member&action=search" target="right">搜索会员</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=member&file=group&action=manage" target="right">会员组管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=field&action=manage&module=<?=$mod?>&tablename=<?=$CONFIG['tablepre']?>member_info" target="right">自定义字段</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=member&file=import" target="right">会员数据导入</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=member&file=setting" target="right">模块配置</a></td>
                  </tr>
                </tbody>
              </table>

              </td>
            </tr>


			            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('admin')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="admin_img"><a href="###">管理员管理</a></td>
                  </tr>
                 <TBODY style="display:" id="admin">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=admin&action=add" target="right">添加管理员</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=admin&action=manage" target="right">管理员管理</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

        </table>
		
	</td>
  </tr>
</table>
<script type="text/javascript">
parent.frames['right'].location = '?mod=member&file=member&action=manage';
</script>
</body>
</html>