<?php
/*
Plugin Name: ByteBunch SEO
Plugin URI: http://bytebunch.com/products/bytebunch-so
Description: It's time to have a good and fast SEO plugin for wordpress.
Version: 1.0
Author: Tahir
Author URI: http://community.bytebunch.com
License: GPL2

*/
function alert($alertText)
{
	echo '<script type="text/javascript">';
	echo "alert(\"$alertText\");";
	echo "</script>";
}
function db($array1)
{
	echo "<pre>";
	var_dump($array1);
	echo "</pre>";
}

define('BYTEBUNCH_SEO','bytebunch_seo');
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
