DELETE FROM `phpcms_module` WHERE module='comment';
DROP TABLE IF EXISTS `phpcms_comment`;
DELETE FROM `phpcms_menu` WHERE `url` like '%mod=comment%';
DELETE FROM `phpcms_menu` WHERE `url` like '%module=comment%';