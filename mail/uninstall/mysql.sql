DROP TABLE IF EXISTS `phpcms_mail`,`phpcms_mail_email`;
DELETE FROM phpcms_module WHERE module='mail';
DELETE FROM phpcms_menu WHERE title='邮件订阅';