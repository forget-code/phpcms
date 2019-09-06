<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
require_once("common.php");

if($Submit)
{
      if(empty($mailto)) message("请输入收件人邮件地址!","goback");

      if(empty($subject)) message("请输入邮件主题!","goback");

      if(empty($content)) message("请输入邮件内容!","goback");

      $content = stripslashes(str_safe($content));

	  sendmail($mailto,$subject,$content);
      
      message("电子邮件发送成功!","close");
}
else
{
     $mailmessage = $mailmessage ? $mailmessage : "发送电子邮件";
     include template("mail","sendmail");
}
?>