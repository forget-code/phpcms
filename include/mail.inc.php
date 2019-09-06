<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($PHPCMS['sendmailtype'] == 'mail')
{
	function sendmail($mail_to, $mail_subject, $mail_body, $mail_from = '')
	{
		global $CONFIG,$PHPCMS;
		$mail_from = $mail_from ? $mail_from : $PHPCMS['sitename']." <".$PHPCMS['smtpuser'].">";
		if($PHPCMS['enablesignature']) $mail_body.=$PHPCMS['signature'];
		$mail_subject = str_replace("\r", '', str_replace("\n", '', $mail_subject));
		$mail_body = str_replace("\r\n.", " \r\n..", str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $mail_body)))));
		$mail_body = str_replace("\r", '', $mail_body);

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=".$CONFIG['charset']."\r\n";
		$headers .= "From: $mail_from\r\n";

		return strpos($mail_to, ',') ? @mail($mail_from, $mail_subject, $mail_body, $headers."Bcc: $mail_to") :	@mail($mail_to, $mail_subject, $mail_body, $headers);
	}
}
elseif($PHPCMS['smtpuser'])
{
	require_once PHPCMS_ROOT.'/include/smtp.class.php';

	$smtp = new smtp($PHPCMS['smtphost'], $PHPCMS['smtpport'], TRUE, $PHPCMS['smtpuser'], $PHPCMS['smtppass']);
	$smtp->debug = FALSE;

	function sendmail($mail_to, $mail_subject, $mail_body, $mail_from = '')
	{
		global $smtp,$PHPCMS;
		$mail_to = trim($mail_to);
		$mail_from = $mail_from ? $mail_from : $PHPCMS['sitename']." &lt;".$PHPCMS['smtpuser']."&gt;";
		if($PHPCMS['enablesignature']) $mail_body.=$PHPCMS['signature'];
		$mail_subject = str_replace("\r", '', str_replace("\n", '', $mail_subject));
		$mail_body = str_replace("\r\n.", " \r\n..", str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $mail_body)))));
		$mail_from = "\"".$PHPCMS['sitename']."\" <".$PHPCMS['smtpuser'].">";
		return strpos($mail_to, ',') ? $smtp->sendmail($PHPCMS['smtpuser'],$mail_from,$mail_subject,$mail_body,'HTML',$mail_to) : $smtp->sendmail($mail_to,$mail_from,$mail_subject,$mail_body,"HTML");	
	}	
}
?>