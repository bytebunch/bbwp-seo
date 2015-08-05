<?php
if(!class_exists('bytebunch_seo_setting')){
   class bytebunch_seo_setting extends bytebunch_seo{
      
      
      public function __construct(){
         
         add_action('admin_init', array($this, 'admin_init'));
         
         add_action( 'admin_menu', array($this,'add_admin_menu_pages'));
      }
      
      public function add_admin_menu_pages(){
         
         /* add main menu page in wordpress dashboard */
         add_menu_page( 'ByteBunch SEO', 'ByteBunch SEO', 'manage_options', 'bbseo_dashboard', array($this,'main_admin_menu_page_content'), 'dashicons-chart-bar', 87.4);
         
         /* add sub menu in our wordpress dashboard main menu */
         add_submenu_page( 'bbseo_dashboard', 'Titles & Metas - ByteBunch SEO', 'Titles & Metas', 'manage_options', 'bbseo_dashboard', array($this,'submenu_page_title_and_meta_content') );
         
         /* add sub menu in our wordpress dashboard main menu */
         add_submenu_page( 'bbseo_dashboard', 'Social - ByteBunch SEO', 'Social', 'manage_options', 'bbseo_social', array($this,'submenu_page_social_content'));
         
      }
      
      public function main_admin_menu_page_content(){
      }
      
      public function submenu_page_title_and_meta_content() {
         include_once BBSEO_ABS.'/admin/page_titles_and_metas.php';
      }
      
      function submenu_page_social_content() {
         include_once BBSEO_ABS.'/admin/page_social.php';
      }
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      public function admin_init() {
         
         /* // White list our options using the Settings API
          * first parameter in thsi function is database key and 2nd paramter is form input name */
          register_setting(BYTEBUNCH_SEO, BYTEBUNCH_SEO, array($this, 'validate'));
      }
      
      public function validate($input) {

        /*$valid = array();
        $valid['url_todo'] = sanitize_text_field($input['url_todo']);
        $valid['title_todo'] = sanitize_text_field($input['title_todo']);

        if (strlen($valid['url_todo']) == 0) {
            add_settings_error(
                    'todo_url', 					// setting title
                    'todourl_texterror',			// error ID
                    'Please enter a valid URL',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['url_todo'] = $this->data['url_todo'];
        }
        return $valid;
        */
		
        return $input;
    }
   }
}
$bytebunch_seo_setting_object = new bytebunch_seo_setting();