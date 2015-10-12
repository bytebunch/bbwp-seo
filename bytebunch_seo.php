<?php
/*
Plugin Name: ByteBunch SEO
Plugin URI: https://bytebunch.com
Description: It's time to have a good and fast SEO plugin for wordpress.
Version: 0.1
Author: Tahir
Author URI: http://bytebunch.com
License: GPL2
*/


define('BYTEBUNCH_SEO','bytebunch_seo');
define('BYTEBUNCH_SEO_SOCIAL','bytebunch_seo_social');
define('BBSEO_URL',plugins_url().'/bytebunch-seo');
define('BBSEO_ABS',plugin_dir_path(dirname(__FILE__) ).'/bytebunch-seo');


include_once BBSEO_ABS.'/admin/classes/ByteBunchSEO.php';
if(class_exists('ByteBunchSEO'))
	$ByteBunchSEO = new ByteBunchSEO();


if(is_admin()){

	include_once BBSEO_ABS.'/admin/classes/ByteBunchSEOSetting.php';
	if(class_exists('ByteBunchSEOSetting'))
		$ByteBunchSEOSetting = new ByteBunchSEOSetting();

	include_once BBSEO_ABS.'/admin/classes/BBSEOMetaBoxFields.php';
	if(class_exists('BBSEOMetaBoxFields'))
		$BBSEOMetaBoxFields = new BBSEOMetaBoxFields();

	include_once BBSEO_ABS.'/admin/classes/BBSEOTaxonomyMetaFields.php';
	if(class_exists('BBSEOTaxonomyMetaFields'))
		$BBSEOTaxonomyMetaFields = new BBSEOTaxonomyMetaFields();

}else
	include_once BBSEO_ABS.'/admin/classes/ByteBunchSEOCore.php';
	if(class_exists('ByteBunchSEOCore'))
		$ByteBunchSEOCore = new ByteBunchSEOCore();
