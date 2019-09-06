<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>回复留言</caption>
   <form action="?mod=guestbook&file=guestbook&action=reply&gid=<?=$guestbook['gid']?>&submit=1" method="post" name="myform" onsubmit="return doCheck();">
    <tr> 
      <td class="tablerowhighlight" colspan=2>标题：<?=$guestbook['title']?> --- [<?=$guestbook['addtime']?>]</td>
   </td>
    <tr> 
      <td  width="30%">
     名称：<a href="<?=member_view_url($guestbook['userid'])?>"><?=$guestbook['username']?></a><br>
     QQ：<a href="http://wpa.qq.com/msgrd?V=1&Uin=<?=$guestbook['qq']?>&Site=localhost&Menu=yes" target="_blank"><?=$guestbook['qq']?></a><br>
     E-mail：<a href="mailto:<?=$guestbook['email']?>"><?=$guestbook['email']?></a><br>
     主 页：<a href="<?=$guestbook['homepage']?>" target="_blank"><?=$guestbook['homepage']?></a><br>
     IP：<?=$guestbook['ip']?> - <?=$guestbook['country']?>
      </td>
      <td  valign="top">
<?=$guestbook['content']?><p>
<? if($guestbook['reply']) { ?>
<table cellpadding="10" cellspacing="1" border="0" width="96%" bgcolor="#dddddd">
  <tr>
    <td bgcolor="#efefef"><font color="red"><b>管理员[<?=$guestbook['replyer']?>]于<?=$guestbook['replytime']?>回复：</b></font><br>
          <?=$guestbook['reply']?>
</td>
  </tr>
</table>
<? } ?>
     </td>
    </tr>
    <tr> 
      <td>回复内容：</td>
      <td>
	  <textarea name="reply" style="display:none" id="reply"><?=$guestbook['reply']?></textarea>
		<?=form::editor("reply","basic",550,400)?>
   </td>
    </tr>
    <tr>
         <td>隐藏：</td>
         <td><input type='radio' name='hidden' value='1' <?php if($guestbook['hidden']){?>checked<?php }?>> 是 <input type='radio' name='hidden' value='0' <?php if(!$guestbook['hidden']){?>checked<?php }?>> 否</td>
   </tr>
    <tr>
         <td>批准：</td>
         <td><input type='radio' name='passed' value='1' checked> 是 <input type='radio' name='passed' value='0'> 否</td>
   </tr>
    <tr> 
      <td></td>
      <td> <input type="submit" name="Submit" value=" 确定 "> 
        &nbsp; <input type="reset" name="Reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>
