<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
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
        <td align="center"><a href="<?=PHPCMS_PATH?>" target="_blank">网站首页</a> | <a href="?mod=phpcms&file=logout" target="_top">退出登录</a></td>
      </tr>
      <tr>
        <td>
        <table width="100%"  border="0" cellspacing="0" cellpadding="4">

            <tr>
              <td>
                <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#183789">
                  <tr>
                    <th class="white">网站频道</td>
                  </tr>

<?php 
if(is_array($CHANNEL)){
	foreach($CHANNEL as $channel){
		if(!$channel['islink']){
		if($_grade==0 || in_array($channel['channelid'], $_channelids)){
?>
                  <tr>
                    <td height="22" bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F8F8F8'" onMouseOut="this.style.backgroundColor='#FFFFFF'">&nbsp;□ <a href="?mod=<?=$channel['module']?>&file=<?=$channel['module']?>&action=left&channelid=<?=$channel['channelid']?>" ><?=$channel['channelname']?></a></td>
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
        </table>

		</td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
parent.frames['right'].location = '?mod=phpcms&file=channel&action=manage';
</script>
</body>
</html>