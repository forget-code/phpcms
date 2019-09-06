<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
    <th colspan=2>安装模块</th>
  </tr>
  <tr>
    <td class="tablerowhighlight" colspan=2>第二步：确认模块信息</td>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&installdir=<?=$module?>&confirminstall=1" method="post" name="myform">
    <tr> 
      <td width="30%" class="tablerow"><b>模块名称</b></td>
      <td class="tablerow">
        <?=$modulename?>
     </td>
    </tr>
      <tr> 
      <td class="tablerow"><b>模块简介</b></td>
      <td class="tablerow"><?=$introduce?></td>
    </tr>
	<tr> 
	<td class="tablerow"><b>模块作者</b></td>
	<td class="tablerow">
	<?=$author?>
	</td>
	</tr>
	<tr> 
      <td class="tablerow"><b>E-mail</b></td>
      <td class="tablerow">
	  <?=$authoremail?>
    </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>作者主页</b></td>
      <td class="tablerow">
	  <a href="<?=$authorsite?>" target="_blank"><?=$authorsite?></a>
    </td>
    </tr>
     <tr>
         <td class="tablerow"><b>是否为可复制模块</b></td>
         <td class="tablerow"><?=$enablecopy?></td>
   </tr>
     <tr>
         <td class="tablerow"><b>是否为共享模块</b></td>
         <td class="tablerow"><?=$isshare?></td>
   </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
	  <input type="hidden" name="installdir" value="<?=$installdir?>"> 
	  <input type="submit" name="submit" value=" 确认安装 "> 
      &nbsp; <input type="button" name="cancel" value=" 取消安装 " onclick="window.location='?mod=<?=$mod?>&file=module'">
		</td>
    </tr>
  </form>
</table>
</body>
</html>