<?php
/*
Plugin Name: BBWP SEO
Plugin URI: https://bytebunch.com
Description: It's time to have a good and fast SEO plugin for wordpress.
Version: 0.1
Author: Tahir
Author URI: http://bytebunch.com
License: GPL2
*/


define('BBWP_SEO','bbwp_seo');
define('BBWP_SEO_SOCIAL','bbwp_seo_social');
define('BBWP_SEO_URL',plugin_dir_url(__FILE__));
define('BBWP_SEO_ABS',plugin_dir_path( __FILE__ ));

include_once BBWP_SEO_ABS.'inc/functions.php';

if(!class_exists('BBWP_SEO')){
	include_once BBWP_SEO_ABS.'admin/classes/BBWP_SEO.php';
	$BBWP_SEO = new BBWP_SEO();
}

if(is_admin()){

	if(!class_exists('BBWP_SEO_Setting')){
		include_once BBWP_SEO_ABS.'admin/classes/BBWP_SEO_Setting.php';
		$BBWP_SEO_Setting = new BBWP_SEO_Setting();
	}
	if(!class_exists('BBWP_SEO_MetaBoxFields')){
		include_once BBWP_SEO_ABS.'admin/classes/BBWP_SEO_MetaBoxFields.php';
		$BBWP_SEO_MetaBoxFields = new BBWP_SEO_MetaBoxFields();
	}
	if(!class_exists('BBWP_SEO_TaxonomyMetaFields')){
		include_once BBWP_SEO_ABS.'admin/classes/BBWP_SEO_TaxonomyMetaFields.php';
		$BBWP_SEO_TaxonomyMetaFields = new BBWP_SEO_TaxonomyMetaFields();
	}

}
else{

	if(!class_exists('BBWP_SEO_Core')){
		include_once BBWP_SEO_ABS.'admin/classes/BBWP_SEO_Core.php';
		$BBWP_SEO_Core = new BBWP_SEO_Core();
	}

}
