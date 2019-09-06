<?php include admintpl('header'); ?>
<body>
<br />
<?php echo $attmenu; ?>
<br />
<form name="form1" method="post" action="?mod=phpcms&file=file&action=del&channelid=2&submit=1">
<table border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan="8"><?php echo $headtitle; ?></tr>
  <tr align="center" >
    <td width="5%" class="tablerowhighlight">选中</td>
    <td class="tablerowhighlight">ID</td>
    <td class="tablerowhighlight">Itemid</td>
    <td class="tablerowhighlight">文件名</td>
    <td class="tablerowhighlight">描述</td>
    <td class="tablerowhighlight">时间</td>
    <td class="tablerowhighlight">大小</td>
    <td class="tablerowhighlight">管理操作</td>
  </tr>
  <?php 
 if($atts) 
 { 
   foreach($atts as $id=>$att)
   { 
  
  ?>
  
  <tr onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgcolor="#F1F3F5">
    <td align="center"><input name="aid[]" id="aid<?php echo $att['aid']; ?>" type="checkbox" value="<?php echo $att['aid']; ?>" ></td>
	<td align="center" onMouseDown="document.getElementById('aid<?php echo $att['aid']; ?>').checked = (document.getElementById('aid<?php echo $att['aid']; ?>').checked ? false : true);">
	<?php echo $att['aid']; ?>	</td>
	<td align="center" onMouseDown="document.getElementById('aid<?php echo $att['aid']; ?>').checked = (document.getElementById('aid<?php echo $att['aid']; ?>').checked ? false : true);">
	<?php if($att['itemid']) { ?>
	<a href="<?php echo $att['itempath']; ?>" title="编辑此信息" ><?php echo $att['itemid']; ?></a>
	<?php } else {  ?>
	<a title="建议删除此附件"><?php echo '---'; ?></a>
	<?php } ?>
	</td>
    <td onMouseDown="document.getElementById('aid<?php echo $att['aid']; ?>').checked = (document.getElementById('aid<?php echo $att['aid']; ?>').checked ? false : true);"><a href="<?php echo $att['filepath']; ?>" title="<?php echo $att['filename']; ?>" target="_blank"><?php echo $att['shortfilename']; ?></a></td>
    <td onMouseDown="document.getElementById('aid<?php echo $att['aid']; ?>').checked = (document.getElementById('aid<?php echo $att['aid']; ?>').checked ? false : true);" title="<?php echo $att['adescription']; ?>"><?php echo $att['description']; ?></td>
    <td align="center" onMouseDown="document.getElementById('aid<?php echo $att['aid']; ?>').checked = (document.getElementById('aid<?php echo $att['aid']; ?>').checked ? false : true);"><?php echo $att['addtime']; ?></td>
    <td onMouseDown="document.getElementById('aid<?php echo $att['aid']; ?>').checked = (document.getElementById('aid<?php echo $att['aid']; ?>').checked ? false : true);"><?php echo $att['filesize']; ?>KB</td>
    <td align="center">
	<a href="#" title="下载 <?php echo $att['filename']; ?>" >下载</a> | <a href="?mod=phpcms&file=file&action=del&channelid=2&aid=<?php echo $att['aid']; ?>&submit=1" title="删除 <?php echo $att['filename']; ?>" >删除</a>
	</td>
  </tr>
  <?php 
  	}
  }
  else
  { 
  ?>
  <tr>
    <th colspan="8">暂无附件</th>
  </tr>
  <?php 
    }
  ?>
</table>
  <table width="100%" border="0" cellpadding="2" cellspacing="1">
    <tr>
      <td>
	  <input type="checkbox" name="chkall" id="chkall" value="checkbox" onclick="checkall(this.form)" />
	  全选/不选	  
	  <input name="submit" type="submit" value="删除选定的附件" /></td>
    </tr>
 </table>
</form>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?php echo $pages; ?></td>
  </tr>
</table>
</body>
</html>
