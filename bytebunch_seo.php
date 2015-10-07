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


include_once BBSEO_ABS.'/admin/classes/bytebunch_seo.php';
include_once BBSEO_ABS.'/admin/classes/bytebunch_seo_setting.php';

if(is_admin()){
   include_once BBSEO_ABS.'/admin/classes/meta_box_fields.php';
   include_once BBSEO_ABS.'/admin/classes/taxonomy_meta_fields.php';
}else{
   include_once BBSEO_ABS.'/admin/classes/bytebunch_seo_core.php';
}
