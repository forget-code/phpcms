<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<form id="form1" name="form1" method="post" action="?mod=<?=$mod?>&amp;file=<?=$file?>&amp;error_id=<?=$error_id?>">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1"  class="tableborder">
    <tr>
      <th height="20" colspan="11">报错详细信息</th>
    </tr>
    <tr>
      <td width="25%" height="20" bgcolor="#F1F3F5" ><div align="center">标题</div></td>
      <td height="20" colspan="2" bgcolor="#F1F3F5" ><div align="left">
          <?=$error_text['error_title']?>
      </a></div></td>
    </tr>
    <tr>
      <td width="25%" height="20" bgcolor="#F1F3F5" ><div align="center">地址</div></td>
      <td height="20" colspan="2" bgcolor="#F1F3F5" ><div align="left">
          <a href=" <?=$error_text['error_link']?>" target="_blank">
 <?=$error_text['error_link']?></a></div></td>
    </tr>
    <tr>
      <td width="25%" height="20" bgcolor="#F1F3F5" ><div align="center">时间</div></td>
      <td height="20" colspan="2" bgcolor="#F1F3F5" ><div align="left">
          <?=date("Y-m-d H:i", $error_text['addtime']) ?>
      </div></td>
    </tr>
    <tr>
      <td width="25%" height="20" bgcolor="#F1F3F5" ><div align="center">内容</div></td>
      <td width="200" height="20" colspan="2" bgcolor="#F1F3F5" ><div align="left">
          <?=$error_text['error_text']?>
      </div></td>
    </tr>
    <tr>
      <td width="25%" height="20" bgcolor="#F1F3F5" ><div align="center">是否处理</div></td>
      <td width="10%" height="20" bgcolor="#F1F3F5" ><label>
        我要处理
            <input name="radiobutton" type="radio" value="1" checked="checked" />
      </label></td>
      <td width="69%" height="20" bgcolor="#F1F3F5" >暂时不处理
      <input name="radiobutton" type="radio" value="0" /></td>
    </tr>
  </table>
  <table width="100%" border="0">
    <tr>
      <td width="24%">&nbsp;</td>
      <td width="76%"><label>
        <input name="dosubmit" type="submit" id="dosubmit" value="提交" />
        <input type="reset" name="Submit2" value="重置" />
      </label></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
