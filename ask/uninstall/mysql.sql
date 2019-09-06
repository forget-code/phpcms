DROP TABLE IF EXISTS `phpcms_ask`,`phpcms_ask_department`,`phpcms_ask_reply`;
DELETE FROM phpcms_module WHERE module='ask';
DELETE FROM phpcms_menu WHERE title='我要咨询';