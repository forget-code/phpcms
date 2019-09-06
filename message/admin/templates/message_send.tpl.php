<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
<table width="100%" cellpadding="2" cellspacing="1" align="center" class="tableborder"><tbody>
	<tr>
		<th colspan="3"><?php echo $menutitle[$fid]; ?></th>
	</tr>
	<tr>
		<td width="100%" height="25" align="center" valign="middle" colspan="3" class="tablerowhighlight">
<?php
if (isset($msg)) {
	echo $msg;
} else {
	echo "&nbsp;";
}

?>
		</td>
	</tr>
	<tr onmouseout="this.style.backgroundColor='#F1F3F5';" onmouseover="this.style.backgroundColor='#BFDFFF';" bgColor="#F1F3F5"><form action="<?php $_SERVER['REQUEST_URI']; ?>" method="post" onsubmit="return formSubmit();" onreset="return formReset();">
		<td width="20%" height="25" align="right" valign="middle" style="padding-right:10px;font-weight:bold">标&nbsp;&nbsp;题：</td>
		<td width="60%" height="25" align="left" valign="middle"><input id="title" type="text" name="title" style="width:100%"></td>
		<td width="20%" height="25" align="center" valign="middle">&nbsp;</td>
	</tr>
	<tr bgColor="#F1F3F5">
		<td width="20%" height="250" align="right" valign="top" style="padding-right:10px;font-weight:bold">内&nbsp;&nbsp;容：<p style="text-align:right;padding-right:15px;"><script src="<?php echo PHPCMS_PATH . $mod; ?>/face/face.js.php" language="javascript" type="text/javascript"></script><div style="height:80px;writing-mode:tb-rl;padding-right:18px;font-weight:normal">插入表情图标</div></p></td>
		<td width="60%" height="250" align="left" valign="middle"><textarea id="content" name="content" rows="1" cols="1" style="display:none"></textarea><script src="<?php echo PHPCMS_PATH . $mod; ?>/face/editor.js" language="javascript" type="text/javascript"></script></td>
		<td width="20%" height="250" align="center" valign="middle">&nbsp;</td>
	</tr>
	<tr>
		<td width="100%" height="50" align="center" valign="middle" colspan="3" class="tablerowhighlight"><input type="submit" name="dosubmit" value="发  送">&nbsp;&nbsp;<input type="reset" value="重  置"></td>
	</tr></form>
</tbody></table>
</body>
</html>