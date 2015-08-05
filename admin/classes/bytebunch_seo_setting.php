<?php
if(!class_exists('bytebunch_seo_setting')){
   class bytebunch_seo_setting extends bytebunch_seo{
      
      public function __construct(){
         // Admin sub-menu
        add_action('admin_init', array($this, 'admin_init'));
      }
      
      
      public function admin_init() {
         /* // White list our options using the Settings API
          * first parameter in thsi function is database key and 2nd paramter is form input name */
          register_setting($this->option_name, $this->option_name, array($this, 'validate'));
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