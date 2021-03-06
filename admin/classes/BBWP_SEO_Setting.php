<?php

class BBWP_SEO_Setting extends BBWP_SEO{

  public function __construct(){
      add_action('admin_init', array($this, 'admin_init'));
      add_action( 'admin_menu', array($this,'add_admin_menu_pages'));
  }

  public function add_admin_menu_pages(){

     /* add main menu page in wordpress dashboard */
     add_menu_page( 'BBWP SEO', 'BBWP SEO', 'manage_options', 'bbwp_seo_dashboard', array($this,'main_admin_menu_page_content'), 'dashicons-chart-bar', 87.4);

     /* add sub menu in our wordpress dashboard main menu */
     add_submenu_page( 'bbwp_seo_dashboard', 'Titles & Metas - BBWP SEO', 'Titles & Metas', 'manage_options', 'bbwp_seo_dashboard', array($this,'submenu_page_title_and_meta_content') );

     /* add sub menu in our wordpress dashboard main menu */
     add_submenu_page( 'bbwp_seo_dashboard', 'Social - BBWP SEO', 'Social', 'manage_options', 'bbwp_seo_social', array($this,'submenu_page_social_content'));

  }

  public function main_admin_menu_page_content(){
  }

  public function submenu_page_title_and_meta_content() {
     include_once BBWP_SEO_ABS.'admin/page_titles_and_metas.php';
  }

  function submenu_page_social_content() {
     include_once BBWP_SEO_ABS.'admin/page_social.php';
  }


  public function admin_init() {

     /* // White list our options using the Settings API
      * first parameter in thsi function is database key and 2nd paramter is form input name */
      register_setting(BBWP_SEO, BBWP_SEO, array($this, 'validate'));
      register_setting(BBWP_SEO_SOCIAL, BBWP_SEO_SOCIAL, array($this, 'validate'));

      //register_setting(BBWP_SEO_SOCIAL, BBWP_SEO_SOCIAL, array($this, 'validate'));
  }

  public function validate($input) {


    /*if(isset($input['reset_bbseo']) && $input['reset_bbseo'] && $input['reset_bbseo'] == 'yes'){
      $this->update_db(true);
      unset($input['reset_bbseo']);
    }*/
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
    if(isset($_POST[BBWP_SEO]) || isset($_POST[BBWP_SEO_SOCIAL]) ){
      update_option("bbwp_update_message",'Your settings have been update.');
    }

    return $input;
  }
}
