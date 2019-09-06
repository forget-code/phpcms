DROP TABLE IF EXISTS `phpcms_ask`;
DROP TABLE IF EXISTS `phpcms_ask_actor`;
DROP TABLE IF EXISTS `phpcms_ask_credit`;
DROP TABLE IF EXISTS `phpcms_ask_posts`;
DROP TABLE IF EXISTS `phpcms_ask_vote`;
ALTER TABLE `phpcms_member_info` DROP `actortype`;
ALTER TABLE `phpcms_member_info` DROP `answercount`;
ALTER TABLE `phpcms_member_info` DROP `acceptcount`;
DELETE FROM `phpcms_urlrule` WHERE `urlruleid` IN (25,26,27,28,29);