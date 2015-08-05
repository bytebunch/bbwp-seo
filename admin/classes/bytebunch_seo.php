<?php

if(!class_exists('bytebunch_seo')){
   
   class bytebunch_seo{
      
      /*variable $option_name is our option table database key and also our form input array */
      //protected $option_name = 'bytebunch_seo';
      
      /* all our plugin config data is in our data veribable */
      protected static $data = array();
      
      public function __construct(){
         self::$data = get_option(BYTEBUNCH_SEO);
         add_action( 'admin_enqueue_scripts', array($this,'wp_admin_style_scripts') );
      }
      
      public function wp_admin_style_scripts() {
         
         wp_register_style( BYTEBUNCH_SEO.'_wp_admin_css', BBSEO_URL . '/css/admin.css', false, '1.0.0' );
         wp_enqueue_style( BYTEBUNCH_SEO.'_wp_admin_css' );

         wp_register_script( BYTEBUNCH_SEO.'_wp_admin_script', BBSEO_URL . '/js/admin.js', array('jquery'), '1.0.0' );
         wp_enqueue_script( BYTEBUNCH_SEO.'_wp_admin_script' );
      }
   }
}

$bytebunch_seo_object = new bytebunch_seo();