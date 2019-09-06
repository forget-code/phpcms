DROP TABLE IF EXISTS `phpcms_announce`;
DELETE FROM `phpcms_module` WHERE module='announce';
DELETE FROM `phpcms_menu` WHERE keyid='announce';