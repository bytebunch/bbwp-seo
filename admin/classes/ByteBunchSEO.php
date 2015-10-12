<?php

if(!class_exists('ByteBunchSEO')){

   class ByteBunchSEO{

      /*variable $option_name is our option table database key and also our form input array */
      //protected $option_name = 'bytebunch_seo';

      /* all our plugin config data is in our data veribable */
      //protected $data = array();
      private static $data = array();
      private $default_setting = array(
        'noindex_archive_author' => 'Yes',
        'noindex_archive_day' => 'Yes',
        'noindex_archive_month' => 'Yes',
        'noindex_archive_year' => 'Yes',
      );
      private $default_social_setting = array(
        'opengraph' => 'Yes',
      );

      public function __construct(){

        self::$data = get_option(BYTEBUNCH_SEO);
        if(!(self::$data && is_array(self::$data) && count(self::$data) >= 1)){
          self::$data = $this->default_setting;
          update_option(BYTEBUNCH_SEO,self::$data);
        }

        $BYTEBUNCH_SEO_SOCIAL = get_option(BYTEBUNCH_SEO_SOCIAL);
        if(!($BYTEBUNCH_SEO_SOCIAL && is_array($BYTEBUNCH_SEO_SOCIAL) && count($BYTEBUNCH_SEO_SOCIAL) >= 1))
          $BYTEBUNCH_SEO_SOCIAL = $this->default_social_setting;
        self::$data = array_merge(self::$data, $BYTEBUNCH_SEO_SOCIAL);


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
      // set options function start from here
      protected function set_option($key, $value){
         if($key && $value){
           self::$data[$key] = $value;
         }
      }
      // update values in database
      protected function update_db($reset_option = false){
        if($reset_option == false){
          update_option(BYTEBUNCH_SEO,self::$data);
        }else{

          update_option(BYTEBUNCH_SEO, $this->default_setting);
          update_option(BYTEBUNCH_SEO_SOCIAL, $this->default_social_setting);
          self::$data = array();
        }
      }

      // save forums options
      protected function save_form_data($form_values){
        foreach($form_values as $key=>$value){
          self::$data[$key] = $this->sql_ready($value);
        }
        $this->update_db();
      }
      // sql ready function
      protected function sql_ready($string)
      {
      	global $wpdb;
      	return $string = trim(stripcslashes($string));
      	/*if ( isset( $wpdb->use_mysqli ) && !empty( $wpdb->use_mysqli ) )
      		  return mysqli_real_escape_string($wpdb->dbh, $string);
      	else
      		 return mysql_real_escape_string($string);*/
      }

      // addd page number to sub pages / pagination
      protected function add_subpage_url($url){
        if ( $url && get_query_var( 'paged' ) > 1 ) {
          global $wp_rewrite;
          if ( ! $wp_rewrite->using_permalinks() ) {
            if ( is_front_page() ) {
              $url = trailingslashit( $url );
            }
            $url = add_query_arg( 'paged', get_query_var( 'paged' ), $url );
          }
          else {
            /*if ( is_front_page() ) {
              $canonical = wpseo_xml_sitemaps_base_url( '' );
            }*/
            //$this->db($wp_rewrite->pagination_base);
            $url = user_trailingslashit( trailingslashit( $url ) . trailingslashit( $wp_rewrite->pagination_base ) . get_query_var( 'paged' ) );
          }
        }
        return $url;
      }
      // Load javascript and css files for wp-admin section
      public function wp_admin_style_scripts() {

         wp_enqueue_script('uploads');
         wp_enqueue_media();

         wp_register_style( BYTEBUNCH_SEO.'_wp_admin_css', BBSEO_URL . '/css/admin.css', false, '1.0.0' );
         wp_enqueue_style(BYTEBUNCH_SEO.'_wp_admin_css');

         wp_register_script( BYTEBUNCH_SEO.'_wp_admin_script', BBSEO_URL . '/js/admin.js', array('jquery'), '1.0.0' );
         wp_enqueue_script( BYTEBUNCH_SEO.'_wp_admin_script' );
      }

      protected function get_the_excerpt($string, $charLimit = 150, $readmore = ' ...'){
        if(is_string($string) && $string != "" && is_numeric($charLimit) && $charLimit >= 0){
          $string = substr(trim(str_replace(array("\r", "\n",'"'),"",strip_tags(strip_shortcodes($string)))), 0, $charLimit);
          if(strlen($string) >= $charLimit){
            $string .= $readmore;
          }
          return $string;
        }else
          return false;
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
      } // get month name function end here

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

   } // ByteBunchSEO class end here
}
