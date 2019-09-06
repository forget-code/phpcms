<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body onload="submit()">
<table style="display:none;"><tr><td>
<form action="http://www.sai9.com/share/sharejob.php" method="post" name="formimport">
      <textarea name="jobrulecontent"><?=$jobrulecontent?></textarea>
      <?php if(isset($jobname)){?><input type="text" name="jobname" value="<?=$jobname?>"><?php } ?>
      <input type="text" name="sitename" value="<?=$sitename?>">
      <input type="text" name="usersite" value="<?=$usersite?>">
	  <input type="submit" value=" 发 布 " />&nbsp;
</form>
</td>
</tr>
</table>
 <script language="JavaScript">   
  function submit()
  {   
     formimport.submit();   
  }   
  </script> 
</body>
</html>