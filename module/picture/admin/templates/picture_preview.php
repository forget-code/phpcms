<?php include admintpl('header');?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td>当前位置：<a href='?mod=picture&file=picture&action=check&channelid=<?=$channelid?>&catid=<?=$catid?>'>审核图片</a> &gt;&gt; 图片预览 &gt;&gt; [<a href="<?=$picture[catdir]?>" target="_blank"><?=$_CAT[$picture[catid]][catname]?></a>] >> <?=$picture[title]?></td>
    <td></td>
    <td align=right></td>
  </tr>
</table>
<div align="center">
  <table cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="2">图片预览</th>
    </tr>  
  <tr>
    <td width="205" align=right class="tablerowhighlight">发布人:</td>
  <td align=left class="tablerow"><a href="member/member.php?username=<?=$picture[username]?>" target="_blank"><?=$picture[username]?></a></td>
  </tr>
  <tr>
    <td width="205" align=right class="tablerowhighlight">作者:</td>
  <td align=left class="tablerow"><?=$picture[author]?><? if($picture[authoremail]) { ?>(<a href="#" onclick="javascript:window.open('<?=PHPCMS_PATH?>sendmail.php?toemail=<?=$picture[authoremail]?>','<?=$sitename?>','width=460,height=310,top=0,left=0');"><?=$picture[authoremail]?></a>)<? } ?><a href="<?=$picture[copyfromurl]?>"></a></td>
  </tr>
  <tr>
    <td align="right"  class="tablerowhighlight">来源:</td>
    <td align=left class="tablerow"><a href="<?=$picture[copyfromurl]?>">
      <?=$picture[copyfromname]?>
      </a></td>
  </tr>
  <tr>
    <td align="right"  class="tablerowhighlight">发表时间:</td>
    <td align=left class="tablerow"><?=$picture[adddate]?></td>
  </tr>
  <tr>
    <td align="right"  class="tablerowhighlight">缩略图:</td>
    <td align=left class="tablerow"><img src="<?=$picture[thumb]?>" alt="缩略图" /></td>
  </tr>
  <tr>
    <td align="right"  class="tablerowhighlight">简介:</td>
  <td align=left class="tablerow"><?=$picture[content]?></td>
  </tr>
  
  <tr>
    <td align="right"  class="tablerowhighlight">图片内容:</td>
  <td align=left class="tablerow">
  <?php 
  if(is_array($pictureurls)){
      foreach($pictureurls AS $id=>$pic) { ?>
<p><a href="<?=$pic[url]?>" target="_blank"><img src="<?=$pic[url]?>" alt="<?=$pic[name]?>" border="0" id="picture<?=$id?>" onload="javascript:setpicWH(picture<?=$id?>,650,1000)" ></a><br/><?=$pic[name]?></p>
 <?php 
	  }
  }
  ?>
	</td>
  </tr>
  <tr>
    <td colspan="2" align=right class="tablerow">
      <div align="center"><b>管理操作</b>
	  <? if($picture[status]!=3){ ?> 
            <a href="?mod=picture&file=picture&action=pass&pass=3&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>" title="通过图片审核">批准</a> |
			<? }else{ ?>
			<a href="?mod=picture&file=picture&action=pass&pass=1&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>" title="通过图片审核">取消批准</a> |
			<? } ?>
        <a href="?mod=picture&file=picture&action=edit&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&catid=<?=$picture[catid]?>" title="编辑图片">编辑</a> |
		<a href="?mod=picture&file=picture&action=sendback&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&catid=<?=$picture[catid]?>" title="退稿">退稿</a> |
        <a href="#" onclick="javascript:confirmurl('?mod=picture&file=picture&action=torecycle&value=1&view=1&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>','确认删除图片吗？此操作可以从回收站恢复。')" title="将图片移至回收站">删除</a> |
      <a href="javascript:window.close()">[关闭窗口]</a></div></td>
  </tr>
  </table>
</div>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center></td>
  </tr>
</table>
</form>
</body>
</html>
