<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
echo $menu;
?>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=delete" method="post" name="form" id="form">
<input type="hidden" name="formid" value="<?=$formid?>" />
<input type="hidden" name="formname" value="<?=$formname?>" />
  <table align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="7">提交内容管理 所属表单：<?=$formname?></th>
    </tr>
    <tr align="center">
      <td width="3%" class="tablerowhighlight">选</td>
      <td width="4%" class="tablerowhighlight">序号</td>
      <td width="74%" class="tablerowhighlight">提交内容</td>
      <td width="15%" class="tablerowhighlight">用户/IP/添加时间</td>
      <td width="4%" class="tablerowhighlight">操作</td>
    </tr>	
    <? foreach($submits as $submit)
    {
   ?>
    <tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgcolor="#F1F3F5">
      <td><input name='did[]' type='checkbox' value='<?=$submit['did']?>'></td>
      <td><?=$submit['did']?></td>
      <td valign="top">
			<div style="height:150px;width=100%;background:#F1F3F5;overflow-y:auto;float:left;">
		      <table align="center" cellpadding="2" cellspacing="1" class="tableborder">
		      <?php
		      foreach($submit['itemnames'] as $k=>$itemname)
		      {
		      	?>
		      <tr>
		      <td width="10%" class="tablerow"  align="center"><?=$itemname?></td>
		      <td class="tablerow" align="left"><?php
		      						$j = $k-1;
		      						$content = $submit['content'][$j];
		      						if(is_array($content)) $content = implode(",",$content);
		      						$content = str_replace("\r\n","<br>",$content);
		      						if($submit['formtype'][$k] == 6 && $content!="没有上传文件") $content = "<a href='".PHPCMS_PATH.$content."' target='_blank'><font color='red'>点击查看/下载附件</font></a>";
		      						echo $content;
		      						?></td>
		      </tr>
		      <?php
    		   }
		      ?>	      
		    </table> 
		  </div>
	   </td>
      <td align="left">用户名:<a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($submit['username'])?>" target="_blank"  title="查看<?=$submit['username']?>的资料" ><?=$submit['username']?></a></br>
      IP:<a href="http://www.phpcms.cn/ip.php?ip=<?=$submit['ip']?>" title="查看该IP的位置" target="_blank"><?=$submit['ip']?></a></br><?=$submit['addtime']?></td>
      <td>
      <a href="javascript:if(confirm('确认删除该内容项吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&did=<?=$submit['did']?>&formid=<?=$submit['formid']?>&formname=<?=$formname?>'" >删除</a></td>
    </tr> 
    <?php
    }
    ?>
    <tr>
      <td colspan="7" class="tablerow">
	  <input name="chkall" type="checkbox" id="chkall" onclick="checkall(this.form)" value="checkbox" title="全部选中">
	  全选/反选
	  <input name="dosubmit" type="submit" id="submit" value=" 删除所选 " />	  </td>
    </tr>
  </table>
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>
</form>
</body>
</html>