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
    <td class="tablerow"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align=center><a href="?file=index&action=main" target="right">首页</a> | <a href="javascript:parent.location.href='?mod=phpcms&file=logout'">退出</a></td>
      </tr>
      <tr>
        <td>
        <table width="100%"  border="0" cellspacing="0" cellpadding="4">
<?php 
if(is_array($modtitle)){
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
}
?>
        </table>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
parent.frames['right'].location = '?mod=phpcms&file=module&action=manage';
</script>
</body>
</html>