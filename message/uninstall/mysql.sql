DROP TABLE IF EXISTS `phpcms_message_inbox`;
DROP TABLE IF EXISTS `phpcms_message_outbox`;
DROP TABLE IF EXISTS `phpcms_message_read`;
DROP TABLE IF EXISTS `phpcms_message_friend`;
DELETE FROM `phpcms_module` WHERE module='message';
DELETE FROM `phpcms_menu` WHERE title='短消息';