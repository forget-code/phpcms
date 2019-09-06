<?php
require './include/common.inc.php';
$mail = load('sendmail.class.php');
if (empty($email) && !empty($contentid) )
{
	$email = explode(',',$email);
	if(!array_map('is_mail',$email))
	{
		echo '0';
	}
}
else
{
	$email = explode(',',$email);
	if(!array_filter($email, 'is_email'))
	{
		echo '0';
	}
	else
	{
		$email = implode(',',$email);
		$sql = "SELECT `title` , `url` FROM ".DB_PRE."content WHERE contentid = '{$contentid}' ";
		$row = $db->get_one($sql);
		if(empty($row)) echo '0';
		$content = '<a href='.$row[url].' target="_blank">'.$row[title].'</a><br/>';
		if( $mail->send($email, $row['title'], $content, $PHPCMS['mail_user']) ) echo '1';
	}
}
?>
