<?php
/// Startup
if (class_exists('VQMod')) {
	require_once(VQMod::modCheck(DIR_SYSTEM . 'startup.php'));        
} else {
	require_once(DIR_SYSTEM . 'startup.php');
}

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

$db->query("CREATE TABLE  IF NOT EXISTS `" . DB_PREFIX . "qq_login` (
	`qq_login_id` int(11) NOT NULL AUTO_INCREMENT,
	`customer_id` int(11) NOT NULL,
	`openid` varchar(255) NOT NULL COLLATE utf8_bin,
	PRIMARY KEY (`qq_login_id`),
	KEY `customer_id` (`customer_id`)
)");

$db->query("CREATE TABLE  IF NOT EXISTS `" . DB_PREFIX . "weibo_login` (
	`weibo_login_id` int(11) NOT NULL AUTO_INCREMENT,
	`customer_id` int(11) NOT NULL,
	`weibo_uid` varchar(20) NOT NULL ,
	PRIMARY KEY (`weibo_login_id`),
	KEY `customer_id` (`customer_id`)
)");

