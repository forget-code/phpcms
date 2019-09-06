<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header','phpcms');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="400" align='center'>
  <tr>
    <td >
		<table border='0' cellpadding='1' cellspacing='1' align='center' class="tableborder">
		  <tr>
			<th>提示信息</th>
		  </tr>
            <tr align="center">
               <td height='100' valign='middle' class="tablerow">
				<br><br><?=$msg?><br><br>

				<?php if($msgtype=='form'){?>
				<form method="post" action="<?=$url_forward?>">
				<input type="submit" name="confirmed" value="确定"> &nbsp; 
				<input type="button" value="返回" onClick="history.go(-1);">
				</form>
				<br>
				<?php }else{ ?>

				<?php if($url_forward == "goback"){?>
				<br><a href="javascript:history.go(-1);" >[ 点这里返回上一页 ]</a>
				<?php  }elseif($url_forward){?>
				<br><a href="<?=$url_forward?>">如果您的浏览器没有自动跳转，请点击这里</a>
				<script>setTimeout("redirect('<?=$url_forward?>');", 1250);</script>
				<?php } ?>

				<?php } ?>
				</td>
            </tr>
       </table>
   </td>
  </tr>
<?php if(debuginfo()){?>
  <tr>
    <td align="center">Processed in <?=$debuginfo['time']?> second(s), <?=$debuginfo['queries']?> queries<?php if($PHPCMS['enablegzip']){?>, Gzip enabled<?php } ?> </td>
  </tr>
<?php } ?>
</table>
</body>
</html>