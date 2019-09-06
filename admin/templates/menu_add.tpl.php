<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加菜单</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
    <tr>
      <td class='tablerow'><strong>所属位置</strong></td>
      <td class='tablerow'>
      <?=$position?>
      </td>
    </tr>
	<tr> 
      <td class="tablerow" width="25%"><strong>菜单名称</strong></td>
      <td class="tablerow"><input name="name" type="text" size="20" maxlength="20" value=""> <?=style_edit('style')?></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>链接地址</strong></td>
      <td class="tablerow"><input name="url" type="text" size="50"></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>链接提示信息</strong></td>
      <td class="tablerow"><input name="title" type="text" size="50"></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>打开窗口</strong></td>
      <td class="tablerow"><?=$target?></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>用户组浏览权限</strong><br /> 如果都不选，则表示不限制</td>
      <td class='tablerow'><?=$showgroup?></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>管理员浏览权限</strong><br /> 如果都不选，则表示不限制</td>
      <td class='tablerow'><?=$showgrade?></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>管理员自定义菜单</strong></td>
      <td class="tablerow"><input name="username" type="radio" value="<?=$_username?>"> 是&nbsp;&nbsp;&nbsp;&nbsp;<input name="username" type="radio" value=""> 否&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">若选“是”，则此菜单只有创建人能浏览</font></td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
	    <input type="hidden" name="forward" value="<?=$forward?>"> 
	    <input type="Submit" name="dosubmit" value=" 确定 "> 
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>