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


define('BYTEBUNCH_SEO','bytebunch_seo');
define('BBSEO_URL',plugins_url().'/bytebunch-seo');
define('BBSEO_ABS',plugin_dir_path(dirname(__FILE__) ).'/bytebunch-seo');

function db_plugin($array_value){
   echo '<pre>';
   print_r($array_value);
   echo '</pre>';
}



include_once BBSEO_ABS.'/admin/classes/bytebunch_seo.php';
include_once BBSEO_ABS.'/admin/classes/bytebunch_seo_setting.php';

if(is_admin()){
   include_once BBSEO_ABS.'/admin/classes/meta_box_fields.php';
   include_once BBSEO_ABS.'/admin/classes/taxonomy_meta_fields.php';
}





if(!is_admin()){
   
   add_filter('wp_title', BYTEBUNCH_SEO.'_custom_title');
   function bytebunch_seo_custom_title( $title )
   {
      global $bytebunch_seo_title;
      if(is_singular()){
         global $post;
         $seo_title = get_post_meta($post->ID,BYTEBUNCH_SEO.'_title',true);
         if($seo_title){
            $title = $seo_title." - ".get_bloginfo('name');
         }
      }
      
      $title = str_replace("|", "-", $title);
      return $title;
   }
   
   
   add_action('wp_head','bytebunch_seo_getMetaTags',0);
   function bytebunch_seo_getMetaTags(){
      $start_meta_comments = "<!-- This site is optimized with the WordPress ByteBunch SEO  plugin v1.0 - http://bytebunch.com  -->";
      $seo_keywords = NULL;
      $seo_description = NULL;
      $output = NULL;
      
      if(is_singular()){
         global $post;
         $bb_seo_temp_data = get_post_meta($post->ID,BYTEBUNCH_SEO.'_metadesc',true);
         if(!empty($bb_seo_temp_data)) 
            $seo_description = $bb_seo_temp_data;
         if(empty($seo_description)){
            
            $seo_description = substr(strip_tags(preg_replace("/\r|\n/", '',$post->post_content)),0,150)." ...";
            
         }
             
         
         $bb_seo_temp_data = get_post_meta($post->ID,BYTEBUNCH_SEO.'_focuskw',true);
         if(!empty($bb_seo_temp_data)) $seo_keywords = $bb_seo_temp_data;
      }
      $output .= $start_meta_comments;
      if(empty($seo_description))
         $seo_description = "ByteBunch Blog is all about design, development, ideas, web trends, technology and tutorials";
      $output .= '<meta name="description" content="'.$seo_description.'" />';
      if(!empty($seo_keywords))
         $output .= '<meta name="keywords" content="'.$seo_keywords.'" />';
      
      $output .= '<meta property="og:locale" content="en_US" />';
      $output .= '<meta property="og:type" content="website" />';
      $output .= '<meta property="og:title" content="'.wp_title("|",false).'" />';
      $output .= '<meta property="og:description" content="'.$seo_description.'" />';
      //$output .= '<meta property="og:url" content="'.get_the_permalink($post->ID).'" />';
      $output .= '<meta property="og:site_name" content="'.  get_bloginfo('name').'" />';
      //$output .= '<meta property="article:publisher" content="http://facebook.com/wpbeginner" />';
      //$output .= '<meta property="fb:admins" content="1107000098" />';
      $output .= '<meta property="og:image" content="http://cdn4.wpbeginner.com/wp-content/uploads/2012/07/logo.jpg" />';
      //$output .= '<meta name="twitter:card" content="summary"/>';
      $output .= '<meta name="twitter:description" content="'.$seo_description.'"/>';
      $output .= '<meta name="twitter:title" content="'.wp_title("|",false).'"/>';
      //$output .= '<meta name="twitter:site" content="@wpbeginner"/>';
      $output .= '<meta name="twitter:image:src" content="http://cdn4.wpbeginner.com/wp-content/uploads/2012/07/logo.jpg"/>';
      //$output .= '<meta name="twitter:creator" content="@wpbeginner"/>';
      //$output .= '<meta name="revised" content="Wednesday, October 9, 2013, 9:39 am" />';
      //$output .= '<meta property="twitter:account_id" content="40516848" />';
      
      
      echo $output;
   }
}