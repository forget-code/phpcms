<html>
<body  style="display:none">
<table cellpadding="2" cellspacing="1" class="tableborder">
<form action="?mod=<?=$mod?>&file=rulemgr&action=installsite" method="post" name="form1" id="form1" >
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
      <tr>
      <th colspan="3">在线安装共享站点规则</th>
    </tr>
    <tr>
      <td colspan="2" class="tablerow">操作</td>
      <td class="tablerow">
      <textarea name="rulecontent"><? echo file_get_contents("http://www.phpcms.cn/spider/rulemgt.php?action=getcontent&type=$type&id=$id");?></textarea>
	  <input type="submit" value=" 导 入 "/>&nbsp;
	  <input name="reset" type="reset" id="reset" value=" 清 除 " />
      </td>
    </tr>
  </table>
</form>
 <script language="JavaScript">   
  window.onload=function()
  {
  form1.submit();
  }   
  </script>
</body>
</html>