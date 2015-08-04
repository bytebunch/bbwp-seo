<?php
/*
Plugin Name: ByteBunch SEO
Plugin URI: http://bytebunch.com/products/bytebunch-so
Description: It's time to have a good and fast SEO plugin for wordpress.
Version: 1.0
Author: Tahir
Author URI: http://community.bytebunch.com
*/


/**
 * Adds a meta box to the post editing screen
 */


define('BYTEBUNCH_SEO','bytebunch_seo');
define('BBSEO_URL',plugins_url().'/bytebunch-seo/');
define('BBSEO_ABS',plugin_dir_path(dirname(__FILE__) ));


function bytebunch_seo_wp_admin_style_scripts() {
   wp_register_style( 'bytebunch_seo_wp_admin_css', BBSEO_URL . '/css/admin.css', false, '1.0.0' );
   wp_enqueue_style( 'bytebunch_seo_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'bytebunch_seo_wp_admin_style_scripts' );






if(is_admin()){
   function bytebunch_seo_add_meta_box() {
      $screens = array( 'post', 'page' );
      foreach ( $screens as $screen ) {
       add_meta_box( 'bytebunch-seo', 'ByteBunch SEO', 'bytebunch_seo_meta_box_callback', $screen );
      }
   }
   add_action( 'add_meta_boxes', 'bytebunch_seo_add_meta_box' );


   /**
    * Outputs the content of the meta box
    */
   function bytebunch_seo_meta_box_callback( $post ) {
//       print_r($post);
//       exit();
       ?>
   <div class="bytebunch_seo_meta_box_container">
         <div class="row">
            <div class="form-label">
               <label for="bytebunch_seo_title"><strong>SEO Title: </strong> <br /><small>If you leave empty will default the title of the post.</small></label>
            </div>
            <div class="form-field">
             <input type="text" name="bytebunch_seo_title" id="bytebunch_seo_title" class="large-text" value="<?php echo get_post_meta($post->ID,'bytebunch_seo_title',true); ?>" />
            </div>
            <div class="clearboth"></div>
         </div>
         <div class="row">
         <div class="form-label">
            <label for="bytebunch_seo_metadesc"><strong>Meta description:</strong> <br /><small>If you leave empty will default the first letters of the text of the post. The meta description will be limited to 156 chars</small></label>
         </div>
            <div class="form-field">
            <textarea name="bytebunch_seo_metadesc" id="bytebunch_seo_metadesc" class="large-text"><?php echo get_post_meta($post->ID,'bytebunch_seo_metadesc',true); ?></textarea>
            </div>
            <div class="clearboth"></div>
         </div>
         <div class="row">
         <div class="form-label">
            <label for="bytebunch_seo_focuskw"><strong>Focus Keyword:</strong> <br /><small>For what? This is already obsolete by google since 2009. We recommend that you do not put anything here that because the google search engine may penalize you.</small></label>
         </div>
            <div class="form-field">
             <input type="text" name="bytebunch_seo_focuskw" id="bytebunch_seo_focuskw" class="large-text" value="<?php echo get_post_meta($post->ID,'bytebunch_seo_focuskw',true); ?>" />
            </div>
         </div>
      <div class="clearboth"></div>
   </div>
       <?php
   }



   /**
    * Saves the custom meta input
    */
   function bytebunch_seo_save_meta_box_data( $post_id ) {

       // Checks save status
       $is_autosave = wp_is_post_autosave( $post_id );
       $is_revision = wp_is_post_revision( $post_id );
       

       // Exits script depending on save status
       if ( $is_autosave || $is_revision ) {
           return;
       }

       // Checks for input and sanitizes/saves if needed
       if( isset( $_POST[ 'bytebunch_seo_title' ] ) ) {
           update_post_meta( $post_id, 'bytebunch_seo_title', stripcslashes( $_POST[ 'bytebunch_seo_title' ] ) );
       }
       // Checks for input and sanitizes/saves if needed
       if( isset( $_POST[ 'bytebunch_seo_metadesc' ] ) ) {
           update_post_meta( $post_id, 'bytebunch_seo_metadesc', stripcslashes( $_POST[ 'bytebunch_seo_metadesc' ] ) );
       }
       // Checks for input and sanitizes/saves if needed
       if( isset( $_POST[ 'bytebunch_seo_focuskw' ] ) ) {
           update_post_meta( $post_id, 'bytebunch_seoc', stripcslashes( $_POST[ 'bytebunch_seo_focuskw' ] ) );
       }

   }
   add_action( 'save_post', 'bytebunch_seo_save_meta_box_data' );
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













if(is_admin()){

   $allowed_taxonomies = array('post_tag','category');
  
   // Add term page
   function bytebunch_seo_taxonomy_add_new_meta_field() { 
      // this will add the custom meta field to the add new term page ?>
      <div class='bytebunch_seo_taxonomy_container'>
         <h3>ByteBunch SEO options</h3>
         <div class="form-field">
            <label for="bytebunch_seo_term_meta[bytebunch_seo_title]">SEO Title</label>
            <input type="text" name="bytebunch_seo_term_meta[bytebunch_seo_title]" id="bytebunch_seo_term_meta[bytebunch_seo_title]" value="">
            <p class="description">If you leave empty will default the title of the term.</p>
         </div>
         <div class="form-field">
            <label for="bytebunch_seo_term_meta[bytebunch_seo_desc]">SEO Description</label>
            <textarea name="bytebunch_seo_term_meta[bytebunch_seo_desc]" id="bytebunch_seo_term_meta[bytebunch_seo_desc]" rows="5" cols="40"></textarea>
            <p class="description">If you leave empty will default the term description will be used. The meta description will be limited to 156 chars</p>
         </div>
         <div class="form-field">
            <label for="bytebunch_seo_term_meta[bytebunch_seo_focuskw]">SEO Focus Keywords</label>
            <input type="text" name="bytebunch_seo_term_meta[bytebunch_seo_focuskw]" id="bytebunch_seo_term_meta[bytebunch_seo_focuskw]" value="">
            <p class="description">For what? This is already obsolete by google since 2009. We recommend that you do not put anything here that because the google search engine may penalize you.</p>
         </div>
      </div>
         <?php 
   }


   // Edit term page
   function bytebunch_seo_taxonomy_edit_meta_field($term) {

      // put the term ID into a variable
      $t_id = $term->term_id;

      // retrieve the existing value(s) for this meta field. This returns an array
      $term_meta = get_option( "bytebunch_seo_taxonomy_$t_id" ); ?>
      <tr class="form-field"><th colspan='2'><h3>ByteBunch SEO options</h3></th></tr>
      <tr class="form-field">
      <th scope="row" valign="top">
         
         <label for="bytebunch_seo_term_meta[bytebunch_seo_title]">SEO title</label></th>
         <td>
            <input type="text" name="bytebunch_seo_term_meta[bytebunch_seo_title]" id="bytebunch_seo_term_meta[bytebunch_seo_title]" value="<?php echo esc_attr( $term_meta['bytebunch_seo_title'] ) ? esc_attr( $term_meta['bytebunch_seo_title'] ) : ''; ?>">
            <p class="description">If you leave empty will default the title of the term.</p>
         </td>
      </tr>
      
      <tr class="form-field">
      <th scope="row" valign="top">
         <label for="bytebunch_seo_term_meta[bytebunch_seo_desc]">SEO Description</label></th>
         <td>
            <textarea name="bytebunch_seo_term_meta[bytebunch_seo_desc]" id="bytebunch_seo_term_meta[bytebunch_seo_desc]"><?php echo esc_attr( $term_meta['bytebunch_seo_desc'] ) ? esc_attr( $term_meta['bytebunch_seo_desc'] ) : ''; ?></textarea>
            <p class="description">If you leave empty will default the term description will be used. The meta description will be limited to 156 chars.</p>
         </td>
      </tr>
      
      <tr class="form-field">
      <th scope="row" valign="top">
         <label for="bytebunch_seo_term_meta[bytebunch_seo_focuskw]">SEO Focus Keywords</label></th>
         <td>
            <input type="text" name="bytebunch_seo_term_meta[bytebunch_seo_focuskw]" id="bytebunch_seo_term_meta[bytebunch_seo_focuskw]" value="<?php echo esc_attr( $term_meta['bytebunch_seo_focuskw'] ) ? esc_attr( $term_meta['bytebunch_seo_focuskw'] ) : ''; ?>">
            <p class="description">If you leave empty will default the title of the term.</p>
         </td>
      </tr>
   <?php
   }



   // Save extra taxonomy fields callback function.
   function save_taxonomy_custom_meta( $term_id ) {
      if ( isset( $_POST['bytebunch_seo_term_meta'] ) ) {
         $term_meta = get_option( "bytebunch_seo_taxonomy_$term_id" );
         $cat_keys = array_keys( $_POST['bytebunch_seo_term_meta'] );
         foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['bytebunch_seo_term_meta'][$key] ) ) {
               $term_meta[$key] = $_POST['bytebunch_seo_term_meta'][$key];
            }
         }
         // Save the option array.
         update_option( "bytebunch_seo_taxonomy_$term_id", $term_meta );
      }
   }


   foreach($allowed_taxonomies as $allowed_taxonomy){
      add_action( $allowed_taxonomy.'_add_form_fields', 'bytebunch_seo_taxonomy_add_new_meta_field', 10, 2 );
      add_action( $allowed_taxonomy.'_edit_form_fields', 'bytebunch_seo_taxonomy_edit_meta_field', 10, 2 );
      add_action( 'edited_'.$allowed_taxonomy, 'save_taxonomy_custom_meta', 10, 2 );  
      add_action( 'create_'.$allowed_taxonomy, 'save_taxonomy_custom_meta', 10, 2 );
   }
}