<?php 
defined('IN_PHPCMS') or exit('Access Denied');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8>" />
<title>Phpcms2008 提示信息</title>
<link href="admin/skin/system.css" rel="stylesheet" type="text/css">
<script language="javascript" src="data/config.js"></script>
<script language="javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="images/js/common.js"></script>
</head>
<body style="margin-top:20px">
<table cellpadding="0" cellspacing="0" class="table_info" style="width:400px">
  <caption>
  提示信息
  </caption>
  <tr>
    <td height="60" valign="middle" class="align_c"><?=$msg?></td>
  </tr>
  <tr>
    <td height="20" valign="middle" class="align_c"><?php if($url_forward == "goback"){?>
      <a href="javascript:history.go(-1);" >[ 点这里返回上一页 ]</a>
      <?php  }elseif($url_forward){?>
      <a href="<?=$url_forward?>">如果您的浏览器没有自动跳转，请点击这里</a>
      <script>setTimeout("redirect('<?=$url_forward?>');", <?=$ms?>);</script>
      <?php } ?>
    </td>
  </tr>
</table>
<?php if(debug()){?>
<div class="align_c">Processed in
  <?=DEBUG_TIME?>
  second(s),
  <?=DEBUG_QUERIES?>
  queries
  <?php if(GZIP){?>
  , Gzip enabled
  <?php } ?>
</div>
<?php } ?>
</body>
</html>
