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
        <td align=center>
		<a href="?mod=phpcms&file=index&action=main" target="right">首页</a> | <a href="?mod=phpcms&file=logout" target="right">退出</a></td>
      </tr>
      <tr>
        <td>

        <table width="100%"  border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td>

           <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                    <th><font color=#ffffff>选择频道</font></th>

<?php 
if(is_array($CHANNEL)){
	foreach($CHANNEL as $channel){
		if(!$channel['islink']){
		if($_grade==0 || in_array($channel['channelid'], $_channelids)){
?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;□ <a href="?mod=<?=$channel['module']?>&file=index&action=left&channelid=<?=$channel['channelid']?>" ><?=$channel['channelname']?></a></td>
                  </tr>
<?php 
		}
        }
	}
}
?>

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
                    <th><a href="javascript:show('<?=$mod?>')"><font color=#ffffff><?=$title?></font></a></th>
                 <TBODY style="display:" id="<?=$mod?>">
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
</body>
</html>