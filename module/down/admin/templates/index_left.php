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
    <td class="tablerow">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <table width="100%"  border="0" cellspacing="0" cellpadding="4">

            <tr>
              <td>
               <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('down')"><font color="#ffffff">下载管理</font></a></td>
                  </tr>
                 <TBODY style="display:''" id="down">
				  <?php if($_grade<3 && $_CHA['htmlcreatetype']){ ?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$mod?>&file=tohtml&action=publish&channelid=<?=$channelid?>" title="添加好信息后，需要发布网页（点更新频道即可），前台才能看到新信息" target="right"><font color="blue">发布网页(html)</font></a></td>
                  </tr>
				    <?php } ?>

				  <?php if($_grade!=5){ ?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=add&channelid=<?php echo $channelid; ?>" target="right"><font color="red">添加下载</font></a></td>
                  </tr>
				   <?php } ?>

				  <?php if($_grade!=4){ ?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=check&channelid=<?php echo $channelid; ?>" target="right">审核下载</a></td>
                  </tr>
				    <?php } ?>

				  <?php if($_grade<4){ ?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=manage&channelid=<?php echo $channelid; ?>" target="right"><font color="red">管理下载</font></a></td>
                  </tr>
				  <?php } ?>

				  <?php if($_grade!=5){ ?>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=myitem&channelid=<?php echo $channelid; ?>" target="right">我添加的下载</a></td>
                  </tr>
				   <?php } ?>

				  <?php if($_grade<3){ ?>
				   <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=special&channelid=<?php echo $channelid; ?>" target="right"><font color="red">管理专题下载</font></a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=move&channelid=<?php echo $channelid; ?>" target="right">批量移动下载</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=recycle&channelid=<?php echo $channelid; ?>" target="right">回收站</a></td>
                  </tr>
				   <?php } ?>
                </tbody>
              </table>
           </td>
            </tr>
			  <?php if($_grade<2){ ?>
            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('category')"><font color="#ffffff">栏目管理</font></a></td>
                  </tr>
                 <TBODY style="display:" id="category">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=category&action=add&channelid=<?php echo $channelid; ?>" target="right">添加栏目</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=category&action=manage&channelid=<?php echo $channelid; ?>" target="right">管理栏目</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=category&action=join&channelid=<?php echo $channelid; ?>" target="right">合并栏目</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('special')"><font color=#ffffff>专题管理</font></a></td>
                  </tr>
                 <TBODY style="display:" id="special">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=special&action=add&channelid=<?=$channelid?>" target="right">添加专题</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=special&action=manage&channelid=<?=$channelid?>" target="right">管理专题</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=special&action=join&channelid=<?=$channelid?>" target="right">合并专题</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>
		
            <tr>
              <td>
               <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('extension')"><font color=#ffffff>扩展功能</font></a></td>
                  </tr>
                 <TBODY style="display:" id="extension">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=comment&file=comment&action=manage&item=downid&channelid=<?=$channelid?>" target="right">评论管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=announce&file=announce&action=manage&channelid=<?=$channelid?>" target="right">管理公告</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=vote&file=vote&action=manage&channelid=<?=$channelid?>" target="right">投票管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=guestbook&file=guestbook&action=manage&channelid=<?=$channelid?>" target="right">留言本管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=link&file=link&action=manage&channelid=<?=$channelid?>" target="right">友情链接</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=page&file=page&action=manage&channelid=<?=$channelid?>" target="right">单网页管理</a></td>
                  </tr>
                </tbody>
              </table>
              </td>
            </tr>


            <tr>
              <td>
               <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('setting')"><font color=#ffffff>相关设置</font></a></td>
                  </tr>
                 <TBODY style="display:''" id="setting">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=channel&action=edit&channelid=<?=$channelid?>" target="right">频道参数设置</a></td>
                  </tr>
				  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=keywords&action=manage&channelid=<?=$channelid?>" target="right">关键字管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=author&action=manage&channelid=<?=$channelid?>" target="right">作者管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=copyfrom&action=manage&channelid=<?=$channelid?>" target="right">来源管理</a></td>
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
                    <th><img src="<?=PHPCMS_PATH?>skin/admin/images/minus.gif" width="20" height="9"><a href="javascript:show('advance')"><font color=#ffffff>高级管理</font></a></td>
                  </tr>
                 <TBODY style="display:''" id="advance">
				 <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$mod?>&file=tag&action=manage&channelid=<?=$channelid?>" target="right">标签调用管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=template&action=manage&channelid=<?=$channelid?>" target="right">模板管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=field&action=manage&channelid=<?=$channelid?>" target="right">自定义字段</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=string&action=manage&channelid=<?=$channelid?>" target="right">字符替换</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=stats&channelid=<?=$channelid?>" title="您可以对本频道信息分布情况了如指掌，可以依据报表对相关人员进行工作考核！" target="right">统计报表</a></td>
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
</body>
</html>