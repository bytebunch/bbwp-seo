<?php

if(!class_exists('ByteBunchSEO')){

   class ByteBunchSEO{

      /*variable $option_name is our option table database key and also our form input array */
      //protected $option_name = 'bytebunch_seo';

      /* all our plugin config data is in our data veribable */
      //protected $data = array();
      private static $data = array();

      public function __construct(){
        self::$data = get_option(BYTEBUNCH_SEO);

         if(is_admin()){
            add_action( 'admin_enqueue_scripts', array($this,'wp_admin_style_scripts') );
         }
      }

      // get options values from static data array
      protected function get_option($key){
         //if(isset($this->data) && isset($this->data[$key])){
         if(isset(self::$data) && isset(self::$data[$key]) && self::$data[$key]){
            return self::$data[$key];
            //return $this->data[$key];
         }else{
            return NULL;
         }
      }

      // Load javascript and css files for wp-admin section
      public function wp_admin_style_scripts() {

         wp_enqueue_script('uploads');
         wp_enqueue_media();

         wp_register_style( BYTEBUNCH_SEO.'_wp_admin_css', BBSEO_URL . '/css/admin.css', false, '1.0.0' );
         wp_enqueue_style( BYTEBUNCH_SEO.'_wp_admin_css' );

         wp_register_script( BYTEBUNCH_SEO.'_wp_admin_script', BBSEO_URL . '/js/admin.js', array('jquery'), '1.0.0' );
         wp_enqueue_script( BYTEBUNCH_SEO.'_wp_admin_script' );
      }

      // get full month name from numeric value
      protected function get_month_name($key){
        $args = array(
          '01' => 'January',    '1' => 'January',
          '02' => 'February',   '2' => 'February',
          '03' => 'March',      '3' => 'March',
          '04' => 'April',      '4' => 'April',
          '05' => 'May',        '5' => 'May',
          '06' => 'June',       '6' => 'June',
          '07' => 'July',       '7' => 'July',
          '08' => 'August',     '8' => 'August',
          '09' => 'September',  '9' => 'September',
          '10' => 'October',
          '11' => 'November',
          '12' => 'December'
        );

        if(isset($args[$key]))
          return $args[$key];
        else
          return NULL;
      }
   }
}
