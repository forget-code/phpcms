DROP TABLE IF EXISTS `phpcms_pay`,`phpcms_pay_card`,`phpcms_pay_exchange`,`phpcms_pay_online`,`phpcms_pay_price`,`phpcms_pay_setting`,`phpcms_pay_type`;
DELETE FROM `phpcms_module` WHERE module='pay';
DELETE FROM `phpcms_menu` WHERE title='付款充值' or title='在线支付' or title='购买有效期' or title='充值卡充值' or title='购买点数' or title='交易记录';