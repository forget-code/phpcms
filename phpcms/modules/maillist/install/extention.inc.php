<?php
/**
 * Description:
 * 
 * Encoding:    GBK
 * Created on:  2012-4-16-下午5:48:04
 * Author:      kangyun
 * Email:       KangYun.Yun@Snda.Com
 */

defined ( 'IN_PHPCMS' ) or exit ( 'Access Denied' );
defined ( 'INSTALL' ) or exit ( 'Access Denied' );

$parentid = $menu_db->insert ( array ('name' => 'maillist', 'parentid' => 29, 'm' => 'maillist', 'c' => 'maillist', 'a' => 'init', 'data' => '', 'listorder' => 1, 'display' => '1' ), true );
$menu_db->insert ( array ('name' => 'maillist_create', 'parentid' => $parentid, 'm' => 'maillist', 'c' => 'maillist', 'a' => 'maillist_create', 'data' => '', 'listorder' => 2, 'display' => '1' ) );
$menu_db->insert ( array ('name' => 'maillist_mgr', 'parentid' => $parentid, 'm' => 'maillist', 'c' => 'maillist', 'a' => 'maillist_mgr', 'data' => '', 'listorder' => 3, 'display' => '1' ) );
$menu_db->insert ( array ('name' => 'send_setting', 'parentid' => $parentid, 'm' => 'maillist', 'c' => 'maillist', 'a' => 'send_setting', 'data' => '', 'listorder' => 4, 'display' => '1' ) );
$menu_db->insert ( array ('name' => 'user_mgr', 'parentid' => $parentid, 'm' => 'maillist', 'c' => 'maillist', 'a' => 'user_mgr', 'data' => '', 'listorder' => 5, 'display' => '1' ) );

$language = array ('maillist' => '邮件组', 'maillist_create' => '创建邮件组', 'maillist_mgr' => '邮件组管理', 'send_setting' => '发送设置', 'user_mgr' => '用户管理');