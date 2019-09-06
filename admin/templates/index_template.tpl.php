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
        <td align=center><a href="?file=index&action=main" target="right">首页</a> | <a href="javascript:parent.location.href='?mod=phpcms&file=logout'">退出</a></td>
      </tr>
      <tr>
        <td>

        <table width="100%"  border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td>

            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('tpl')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="tpl_img"><a href="###">模板风格</a></td>
                  </tr>
                 <tbody style="display:" id="tpl">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=templateproject" target="right">方案管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=skin" target="right">风格管理</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=tag&channelid=0&action=list" target="right">标签列表</a></td>
                  </tr>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=mytag&channelid=0" target="right">自定义标签</a></td>
                  </tr>
                </tbody>
              </table>

              </td>
            </tr>

<?php 
foreach($MODULE as $m=>$v)
{
?>
            <tr>
              <td>

            <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white" onclick="javascript:show('tpl<?=$m?>')"><img src="<?=PHPCMS_PATH?>admin/skin/images/on.gif" width="20" height="9" id="tpl<?=$m?>_img"><a href="###"><?=$v['name']?>模板</a></td>
                  </tr>
                 <tbody style="display:none" id="tpl<?=$m?>">
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=phpcms&file=template&module=<?=$m?>" target="right">模板管理</a></td>
                  </tr>
				  <?php if(file_exists(PHPCMS_ROOT.'/'.moduledir($m).'/include/tag.func.php')){ ?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"><a href="?mod=<?=$m?>&file=tag" target="right">标签调用</a></td>
                  </tr>
				  <?php } ?>
                </tbody>
              </table>

              </td>
            </tr>
<?php 
}
?>
        </table>
		
		</td>
      </tr>
    </table>
	
	</td>
  </tr>
</table>
<script type="text/javascript">
parent.frames['right'].location = '?mod=phpcms&file=template';
</script>
</body>
</html>