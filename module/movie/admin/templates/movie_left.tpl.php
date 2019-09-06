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
        <td>
        <table width="100%"  border="0" cellspacing="0" cellpadding="4">
		<tr>
              <td>
               <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9"><a href="?mod=<?=$mod?>&file=movie&action=main&channelid=<?=$channelid?>"  target="right"><?=$CHA['channelname']?>首页</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$mod?>&file=createhtml&channelid=<?=$channelid?>"  target="right"><font color="blue">发布网页(html)</font></a></td>
                  </tr>

                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>"  target="right"><font color="red">添加影片</font></a></td>
                  </tr>

                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>"  target="right">管理影片</a></td>
                  </tr>
				  </table>
			</td>
			</tr>

           <?php if($_grade<2){ ?>
            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
				   <tr>
                    <th class="white" onclick="javascript:show('category')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="category_img"><a href="###">栏目管理</a></td>
                  </tr>

                 <tbody style="display:" id="category">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=category&action=add&channelid=<?=$channelid?>" target="right">添加栏目</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=category&action=manage&channelid=<?=$channelid?>" target="right">管理栏目</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=category&action=join&channelid=<?=$channelid?>" target="right">合并栏目</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
				  <tr>
                    <th class="white" onclick="javascript:show('special')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="special_img"><a href="###">专题管理</a></td>
                  </tr>

                 <tbody style="display:" id="special">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=special&action=add&keyid=<?=$channelid?>" target="right">添加专题</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=special&action=manage&keyid=<?=$channelid?>" target="right">管理专题</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td>
               <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">

				  <tr>
                    <th class="white" onclick="javascript:show('extension')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="extension_img"><a href="###">扩展功能</a></td>
                  </tr>

                 <tbody style="display:" id="extension">
				 <?php 
				 foreach($MODULE as $module=>$m)
				 {
					 if($m['isshare'] == 0) continue;
				?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$module?>&file=<?=$module?>&keyid=<?=$channelid?>" target="right"><?=$m['name']?>管理</a></td>
                  </tr>
				<?php
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
                    <th class="white" onclick="javascript:show('setting')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="setting_img"><a href="###">相关设置</a></td>
                  </tr>

                 <TBODY style="display:" id="setting">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$mod?>&file=setting&channelid=<?=$channelid?>" target="right"><font color=blue>模块配置</font></a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=channel&action=edit&channelid=<?=$channelid?>" target="right"><font color=red>频道参数设置</font></a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=type&action=manage&keyid=<?=$channelid?>" target="right">地区分类管理</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=position&keyid=<?=$channelid?>" target="right">推荐位置管理</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=keywords&action=manage&keyid=<?=$channelid?>" target="right">关键字管理</a></td>
                  </tr>
                  
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=reword&action=manage&channelid=<?=$channelid?>" target="right">字符过滤</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=keylink&action=manage&channelid=<?=$channelid?>" target="right">关联链接</a></td>
                  </tr>
                </tbody>
              </table>
           </td>
            </tr>

            <tr>
              <td>
               <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
				   <tr>
                    <th class="white" onclick="javascript:show('advance')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="advance_img"><a href="###">高级管理</a></td>
                  </tr>

                 <TBODY style="display:" id="advance">
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$mod?>&file=tag&action=manage&channelid=<?=$channelid?>" target="right"><font color=blue>标签调用管理</font></a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=template&action=manage&channelid=<?=$channelid?>" target="right"><font color=red>模板管理</font></a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=field&action=manage&channelid=<?=$channelid?>&tablename=<?=channel_table('movie', $channelid)?>" target="right">自定义字段</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$mod?>&file=player&channelid=<?=$channelid?>" target="right">影片播放器管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$mod?>&file=server&channelid=<?=$channelid?>" target="right">影片服务器管理</a></td>
                  </tr>
                </tbody>
              </table>
           </td>
            </tr>
          <?php } ?>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
parent.frames['right'].location = '?mod=movie&file=movie&action=main&channelid=<?=$channelid?>';
</script>
</body>
</html>