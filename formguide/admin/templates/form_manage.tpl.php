<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
echo $menu;
?>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=delete" method="post" name="form" id="form">
  <table align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="7">已生成表单列表</th>
    </tr>
    <tr align="center">
      <td width="3%" class="tablerowhighlight">选</td>
      <td width="5%" class="tablerowhighlight">序号</td>
      <td width="20%" class="tablerowhighlight">表单名(提交内容数)</td>
      <td width="17%" class="tablerowhighlight">描述</td>
      <td width="17%" class="tablerowhighlight">发送结果到email</td>
      <td width="10%" class="tablerowhighlight">添加时间</td>
      <td width="28%" class="tablerowhighlight">管理操作</td>
    </tr>	
    <? foreach($forms as $form)
    {
   ?>
    <tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgcolor="#F1F3F5" title="该表单调用方式：{tag_<?=$form['formname']?>}&#10;在模板中插入该标签即可显示此表单">
      <td><input name='formid[]' type='checkbox' value='<?=$form['formid']?>'></td>
      <td><?=$form['formid']?></td>
      <td><a href="<?=$MOD['linkurl']?>index.php?formid=<?=$form['formid']?>" title="打开该表单" target="_blank"><?=$form['formname']?></a>&nbsp;
      (<a href="?mod=<?=$mod?>&file=submit&action=manage&formid=<?=$form['formid']?>&formname=<?=urlencode($form['formname'])?>" ><font color="Blue"><?=$form['submitnum']?></font></a>)</td>
      <td><?=$form['introduce']?></td>
      <td><?=$form['toemail']?></td>
      <td><?=$form['addtime']?></td>
      <td><a href="?mod=<?=$mod?>&file=tag&action=preview&tagname=<?=urlencode($form['formname'])?>" >预览</a> 
	     <a href="?mod=<?=$mod?>&file=tag&action=changetemplate&tagname=<?=urlencode($form['formname'])?>&function=formguide&formid=<?=$form['formid']?>" >选择模板</a>
	    <?php if($form['disabled']){ ?>
		<a href="?mod=<?=$mod?>&file=<?=$file?>&action=disabled&formid=<?=$form['formid']?>" title="点击将该项设为启用">已禁用</a>
		<?php } else { ?>
		<a href="?mod=<?=$mod?>&file=<?=$file?>&action=disabled&formid=<?=$form['formid']?>" title="点击将该项设为禁用">已启用</a>
		<?php } ?>
        <a href="javascript:if(confirm('确认删除该表单项吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&formid=<?=$form['formid']?>'" >删除</a>
        <a href="?mod=<?=$mod?>&file=submit&action=manage&formid=<?=$form['formid']?>&formname=<?=urlencode($form['formname'])?>" ><font color="Blue">查看内容</font></a></td>
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