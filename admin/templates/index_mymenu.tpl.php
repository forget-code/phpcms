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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="500" id="loading">
  <tr>
    <td align="center" valign="center"><img src="<?=PHPCMS_PATH?>admin/skin/images/loading.gif" /><br /><br />正在装载...</td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<div id="load" style="display:none;">
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
                    <th class="white" onclick="javascript:show('setting')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="setting_img"><a href="###">控制面板</a></th>
                  </tr>
                 <TBODY style="display:''" id="setting">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=admin&action=view" target="right">查看权限</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="<?=$MODULE['message']['linkurl']?>" target="_blank">短消息</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="<?=$MODULE['member']['linkurl']?>edit.php" target="_blank">修改资料</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="<?=$MODULE['member']['linkurl']?>editpassword.php" target="_blank">修改密码</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=menu&action=my" target="right">定义常用操作</a></td>
                  </tr>
                </tbody>
              </table>
           </td>
            </tr>

            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('ext')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="ext_img"><a href="###">常用操作</a></td>
                  </tr>
                 <TBODY style="display:''" id="ext">
                 <?=menu($mod, 'admin_mymenu')?>
                </tbody>
              </table>
              </td>
            </tr>

<?php if($_grade){ ?>
            <tr>
              <td>
            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('channel')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="ext_img"><a href="###">网站频道</a></td>
                  </tr>
                 <TBODY style="display:''" id="channel">
<?php foreach($_channelids as $channelid){ ?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;□ <a href="?mod=<?=$CHANNEL[$channelid]['module']?>&file=<?=$CHANNEL[$channelid]['module']?>&action=left&channelid=<?=$channelid?>" target="_self"><?=$CHANNEL[$channelid]['channelname']?></a></td>
                  </tr>
<?php } ?>
				 </tbody>
              </table>
              </td>
            </tr>
<?php if($modtitle){ 
	foreach($modtitle as $mod=>$title){
?>
            <tr>
              <td>
           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('<?=$mod?>')"><img src="<?=PHPCMS_PATH?>admin/skin/images/off.gif" width="20" height="9" id="<?=$mod?>_img"><a href="###"><?=$title?></a></td>
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
} ?>

        </table>

		</td>
      </tr>
<?php } ?>
    </table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</div>
<script type="text/javascript">
setTimeout("$('loading').style.display='none';$('load').style.display='block';", 500);
parent.frames['right'].location = '?file=index&action=main';
</script>
</body>
</html>