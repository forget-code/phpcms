DELETE FROM `phpcms_module` WHERE `module`='union';
ALTER TABLE `phpcms_member` DROP `introducer`;
DROP TABLE IF EXISTS `phpcms_union`, `phpcms_union_pay`, `phpcms_union_visit`;
DELETE FROM `phpcms_menu` WHERE title='推广联盟';