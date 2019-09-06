<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
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
<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789" >
  <tr>
    <td class="tablerow">
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><a href="<?=$INDEX?>" target="_blank">网站首页</a> | <a href="?action=logout" target="_top">退出登录</a></td>
      </tr>

      <tr>
        <td>
        <table width="100%"  border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('setting')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="setting_img"><a href="###">新闻管理</a></th>
                  </tr>
                 <TBODY style="display:''" id="setting">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=article&action=add" target="right">新闻发布</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=article&action=manage" target="right">管理新闻</a></td>
                  </tr>
                 
                </tbody>
              </table>
           </td>
            </tr>
		<tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('product')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="admin_img"><a href="###">产品管理</a></td>
                  </tr>
                 <TBODY style="display:" id="product">
				 
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=product&action=add" target="right"><font color="green">发布产品</font></a></td>
                  </tr>
				   <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=product&action=manage" target="right">产品管理</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>
<tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('product_sales')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="admin_img"><a href="###">促销信息管理</a></td>
                  </tr>
                 <TBODY style="display:" id="product_sales">
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=sales&action=add" target="right">发布促销信息</a></td>
                  </tr>
				   <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=sales&action=manage" target="right">促销信息管理</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>
<tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('product_buy')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="admin_img"><a href="###">求购信息管理</a></td>
                  </tr>
                 <TBODY style="display:" id="product_buy">
				   <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=buy&action=add" target="right">发布求购信息</a></td>
                  </tr>
				 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=buy&action=manage" target="right">求购信息管理</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>
            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('job')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="admin_img"><a href="###">人才中心</a></td>
                  </tr>
                 <TBODY style="display:" id="job">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=job&action=add" target="right">招聘发布</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=job&action=manage" target="right">招聘管理</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=apply&action=manage" target="right">人才库</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>
		<tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('function')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="admin_img"><a href="###">扩展功能</a></td>
                  </tr>
                 <TBODY style="display:" id="function">
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=order&action=manage" target="right">订单管理</a></td>
                  </tr>
				 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=guestbook&action=manage" target="right">留言本</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>
			<tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('basic')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="admin_img"><a href="###">基本信息</a></td>
                  </tr>
                 <TBODY style="display:" id="basic">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=companyinfo" target="right">更改企业信息</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=introduce" target="right">更改企业简介</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=map" target="right">企业地理位置标注</a></td>
                  </tr>
				    
				    <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=banner" target="right">Banner管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=menu" target="right">导航菜单管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?file=templates" target="right">模板管理</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="<?=$SITEURL?>/member/editpassword.php" target="right">修改密码</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="<?=$SITEURL?>/member/edit.php" target="right">更改个人资料</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

        </table>

		</td>
      </tr>
    </table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>

<script type="text/javascript">
parent.frames['right'].location = '?file=index&action=main';
</script>
</body>
</html>