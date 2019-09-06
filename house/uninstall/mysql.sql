DROP TABLE IF EXISTS `phpcms_house`,`phpcms_house_display`,`phpcms_house_hold`,`phpcms_house_coop`;
ALTER TABLE `phpcms_member_info` DROP `my_house_membertype`,  DROP `my_house_corpname`,  DROP `my_house_introduce`;
DELETE FROM phpcms_module WHERE module='house';
DELETE FROM phpcms_menu WHERE name='房屋出租管理' or name='房屋求租管理' or name='房屋合租管理' or name='房屋出售管理' or name='房屋求购管理' or name='房屋置换管理' or name='新楼盘管理';
DELETE FROM `phpcms_channel` WHERE `channelname`='房产';