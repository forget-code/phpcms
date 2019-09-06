<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
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
    <td class="tablerow"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align=center><a href="?file=index&action=main" target="right">首页</a> | <a href="javascript:parent.location.href='?mod=phpcms&file=logout'">退出</a></td>
      </tr>
      <tr>
        <td>
        <table width="100%"  border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('setting')"><font color=#ffffff>系统设置</font></a></td>
                  </tr>
                 <TBODY style="display:''" id="setting">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=update" target="right"><font color="red">更新网站首页</font></a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=update&action=allcache" target="right">更新缓存</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting" target="right">基本配置</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=admin" target="right">管理员设置</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=channel" target="right">网站频道管理</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=module" target="right">模块管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=ip" target="right">IP管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=log&action=manage" target="right">日志管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=database" target="right">数据库管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=sitemap&action=search" target="right">google地图</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=province" target="right">省市管理</a></td>
                  </tr>
                </tbody>
              </table>
           </td>
            </tr>

<?php 
if(is_array($modtitle)){
	foreach($modtitle as $mod=>$title){
?>

            <tr>
              <td>

           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="templates/admin/style/default/images/minus.gif" width="20" height="9"><a href="javascript:show('<?=$mod?>')"><font color=#ffffff><?=$title?></font></a></td>
                  </tr>
                 <TBODY style="display:none" id="<?=$mod?>">
<?php 
if(is_array($menu[$mod])){
	foreach($menu[$mod] as $m){
?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="<?=$m[1]?>" target="right"><?=$m[0]?></a></td>
                  </tr>
<?php 
	}
}
?>
                </tbody>
              </table>
		      </td>
            </tr>
<?php 
	}
}
?>

            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('ext')"><font color=#ffffff>扩展功能</font></a></td>
                  </tr>
                 <TBODY style="display:" id="ext">
				 <?php 
				 if(is_array($extmenus)){
					   foreach($extmenus as $m=>$extmenu)
					   {
						   	if($m=="comment") continue;
				  ?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$m?>&file=<?=$m?>&action=manage&channelid=0" target="right"><?=$extmenu[modulename]?>管理</a></td>
                  </tr>
				  <?php 
			          }
			     }
				 ?>
                </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('tpl')"><font color=#ffffff>模板风格</font></a></td>
                  </tr>
                 <TBODY style="display:" id="tpl">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=templateproject" target="right">模板方案管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=template" target="right">模板管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=skin" target="right">风格管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=tag&channelid=0" target="right">标签JS调用管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=mytag&channelid=0" target="right">自定义标签</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('9466')"><font color=#ffffff>关于PHPCMS</font></a></td>
                  </tr>
                 <TBODY style="display:none" id="9466">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="http://www.phpcms.cn/update/" target="right">检查更新</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="http://help.phpcms.cn" target="right">在线帮助</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="http://bbs.phpcms.cn" target="_blank">技术支持论坛</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="http://www.phpcms.cn" target="_blank">官方网站</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>