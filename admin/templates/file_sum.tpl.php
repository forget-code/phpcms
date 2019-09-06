<?php include admintpl('header'); ?>
<body>
<br />
<?php echo $attmenu; ?>
<br />
<table width="400" border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr><th colspan="3"><?php echo $headtitle; ?></tr>
  <tr align="center" >
    <td class="tablerowhighlight">文件类型</td>
    <td class="tablerowhighlight">个数</td>
    <td class="tablerowhighlight">管理操作</td>
  </tr>
  <?php 
 if($atts) 
 { 
   foreach($atts as $id=>$att)
   { 
  
  ?> 
  <tr onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgcolor="#F1F3F5">
    <td align="center"><?php echo strtoupper($att['filetype']); ?></td>
    <td><?php echo $att['num']; ?>个</td>
    <td align="center">
	<a href="#" onclick="self.location.href='?mod=phpcms&file=file&action=admin&channelid=2&filetype=<?php echo $att['filetype']; ?>';">查看</a>
	</td>
  </tr>
  <?php 
  	}
  }
  else
  { 
  ?>
  <tr>
    <th colspan="3">暂无附件</th>
  </tr>
  <?php 
    }
  ?>
</table>
