DROP TABLE IF EXISTS `phpcms_product`,`phpcms_product_att`,`phpcms_product_brand`,`phpcms_product_cart`,`phpcms_product_images`,`phpcms_product_order`,`phpcms_product_pdtatt`,`phpcms_product_property`;
DELETE FROM phpcms_module WHERE module='product';
DELETE FROM phpcms_menu WHERE title='我的订单';
DELETE FROM `phpcms_channel` WHERE `channelname`='商城';

DELETE FROM `phpcms_menu` WHERE `title`='添加商品' or `title`='商城首页' or `title`='商品html' or `title`='商品列表';