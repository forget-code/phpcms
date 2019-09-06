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
<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789" >
  <tr>
    <td class="tablerow">
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><a href="<?=PHPCMS_PATH?>" target="_blank">网站首页</a> | <a href="?mod=phpcms&file=logout" target="_top">退出登录</a></td>
      </tr>

      <tr>
        <td>
        <table width="100%"  border="0" cellspacing="0" cellpadding="4">

            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('tohtml')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="tohtml_img"><a href="###">发布网页</a></td>
                  </tr>
				  
                 <TBODY style="display:''" id="tohtml">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=createhtml&action=index" target="right"><font color="red">更新首页</font></a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=cache&action=update" title="更新模块、频道、栏目、模板等缓存数据" target="right">更新缓存</a></td>
                  </tr>
				  <?php if($CONFIG['phpcache'] == '1'){ ?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=tag&action=clear" title="清空标签缓存数据" target="right">清空标签缓存</a></td>
                  </tr>
				  <?php } ?>
                </TBODY>
              </table>
              </td>
            </tr>

            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('setting')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="setting_img"><a href="###">基本配置</a></th>
                  </tr>
                 <TBODY style="display:''" id="setting">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting&tab=0" target="right">基本信息</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting&tab=1" target="right">网站设置</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting&tab=2" target="right">搜索设置</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting&tab=3" target="right">安全设置</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting&tab=4" target="right">图片处理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting&tab=5" target="right">邮件设置</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting&tab=6" target="right">FTP设置</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting&tab=7" target="right">通行证</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=setting&tab=8" target="right">扩展设置</a></td>
                  </tr>
                </tbody>
              </table>
           </td>
            </tr>

            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('admin')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="admin_img"><a href="###">管理员设置</a></td>
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

            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('channel')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="channel_img"><a href="###">频道设置</a></td>
                  </tr>
                 <TBODY style="display:" id="channel">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=channel&action=add" target="right">新建频道</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=channel&action=manage" target="right">频道管理</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('module')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="module_img"><a href="###">模块设置</a></td>
                  </tr>
                 <TBODY style="display:" id="module">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=module&action=install" target="right">安装模块</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=module&action=manage" target="right">模块管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=module&action=add" target="right" title="此功能只针对php程序员用来开发新的phpcms模块">新建模块</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('database')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="database_img"><a href="###">数据库管理</a></td>
                  </tr>
                 <TBODY style="display:" id="database">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=database&action=export" target="right">数据库备份</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=database&action=import" target="right">数据库恢复</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=database&action=repair" target="right">数据库修复</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=strreplace" target="right">字符串替换</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=database&action=executesql" target="right">执行SQL</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('tool')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="tool_img"><a href="###">系统工具</a></td>
                  </tr>
                 <TBODY style="display:" id="tool">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=freelink" target="right"><font color="red">自由调用</font></a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=attachment" target="right">附件管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=filemanager" target="right">在线文件管理器</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=menu" target="right">导航菜单管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=position&keyid=" target="right">推荐位置管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=ip" target="right">IP管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=log" target="right">后台操作日志</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=errorlog" target="right">PHP 错误日志</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=sitemap" target="right">Google地图</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=province" target="right">省市管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=index&action=env" target="right">环境变量</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('ext')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="ext_img"><a href="###">扩展功能</a></td>
                  </tr>
                 <TBODY style="display:''" id="ext">
				 <?php 
					   foreach($extmenus as $m=>$extmenu)
					   {
				  ?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$m?>&file=<?=$m?>&action=manage&keyid=0" target="right"><?=$extmenu['name']?>管理</a></td>
                  </tr>
				  <?php 
			           }
				 ?>
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