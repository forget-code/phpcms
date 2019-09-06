DROP TABLE IF EXISTS `phpcms_spider_job`,`phpcms_spider_out`,`phpcms_spider_sites`,`phpcms_spider_urls`;
DELETE FROM `phpcms_module` WHERE module='spider';
DELETE FROM `phpcms_menu` WHERE keyid ='spider';