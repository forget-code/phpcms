DELETE FROM `phpcms_module` WHERE module='guestbook';
DROP TABLE IF EXISTS `phpcms_guestbook`;
DELETE FROM `phpcms_menu` WHERE keyid='guestbook';