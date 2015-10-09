<?php

if(!class_exists('BBSEOMetaBoxFields')){

   class BBSEOMetaBoxFields{

      public function __construct(){
        //db($GLOBALS);
        //exit();
         add_action( 'add_meta_boxes', array($this,'add_meta_box'));
         add_action( 'save_post', array($this,'save_meta_box_data'));
      }

      public function add_meta_box() {
        $args = array('public' => true);
        $screens = get_post_types( $args, 'names' );
        //$screens = array( 'post', 'page' );
         foreach ( $screens as $screen ) {
          add_meta_box( BYTEBUNCH_SEO, 'ByteBunch SEO', array($this,'meta_box_callback'), $screen );
         }
      }

      /**
      * Outputs the content of the meta box
      */
     public function meta_box_callback( $post ) {
         $bytebunch_seo_meta = get_post_meta($post->ID, BYTEBUNCH_SEO, true ); ?>
      <div class="bytebunch_seo_meta_box_container">
         <ul class="tabbed_menu">
            <li><a href="#bytebunch_seo_tab1">General</a></li>
            <li><a href="#bytebunch_seo_tab2">Social</a></li>
         </ul>
         <div class="clearboth"></div>
         <div id="bytebunch_seo_tab1" class="tab_menu_content">
            <div class="row">
               <div class="form-label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[title]"><strong>SEO Title: </strong> <br /><small>If you leave empty will default the title of the post.</small></label>
               </div>
               <div class="form-field">
                <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[title]" id="<?php echo BYTEBUNCH_SEO; ?>[title]" class="large-text" value="<?php if(isset($bytebunch_seo_meta['title'])){ echo $bytebunch_seo_meta['title']; } ?>" />
                <!-- <br />Variables: {site_name} , {sep} -->
               </div>
               <div class="clearboth"></div>
            </div>
            <div class="row">
            <div class="form-label">
               <label for="<?php echo BYTEBUNCH_SEO; ?>{metadesc]"><strong>Meta description:</strong> <br /><small>If you leave empty will default the first letters of the text of the post. The meta description will be limited to 156 chars</small></label>
            </div>
               <div class="form-field">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[metadesc]" id="<?php echo BYTEBUNCH_SEO; ?>{metadesc]" class="large-text" rows="5"><?php if(isset($bytebunch_seo_meta['metadesc'])){ echo $bytebunch_seo_meta['metadesc']; } ?></textarea>
               </div>
               <div class="clearboth"></div>
            </div>
            <div class="row">
            <div class="form-label">
               <label for="<?php echo BYTEBUNCH_SEO; ?>[focuskw]"><strong>Focus Keyword:</strong> <br /><small>For what? This is already obsolete by google since 2009. We recommend that you do not put anything here that because the google search engine may penalize you.</small></label>
            </div>
               <div class="form-field">
                <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[focuskw]" id="<?php echo BYTEBUNCH_SEO; ?>[focuskw]" class="large-text" value="<?php if(isset($bytebunch_seo_meta['focuskw'])){ echo $bytebunch_seo_meta['focuskw']; } ?>" />
               </div>
            </div>
         <div class="clearboth"></div>
         </div><!-- tab1 div end here -->
         <div id="bytebunch_seo_tab2" class="tab_menu_content">
            <div class="row">
               <div class="form-label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[opengraph_title]"><strong>Facebook Title: </strong></label>
               </div>
               <div class="form-field">
                <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[opengraph_title]" id="<?php echo BYTEBUNCH_SEO; ?>[opengraph_title]" class="large-text" value="<?php if(isset($bytebunch_seo_meta['opengraph_title'])){ echo $bytebunch_seo_meta['opengraph_title']; } ?>" />
                <br /><small>If you don't want to use the post title for sharing the post on Facebook but instead want another title there, write it here.</small>
               </div>
               <div class="clearboth"></div>
            </div>

            <div class="row">
            <div class="form-label">
               <label for="<?php echo BYTEBUNCH_SEO; ?>{opengraph_desc]"><strong>Facebook Description:</strong> </label>
            </div>
               <div class="form-field">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[opengraph_desc]" id="<?php echo BYTEBUNCH_SEO; ?>{opengraph_desc]" class="large-text" rows="5"><?php if(isset($bytebunch_seo_meta['opengraph_desc'])){ echo $bytebunch_seo_meta['opengraph_desc']; } ?></textarea>
                  <br /><small>If you don't want to use the meta description for sharing the post on Facebook but want another description there, write it here.</small>
               </div>
               <div class="clearboth"></div>
            </div>

            <div class="row">
               <div class="form-label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[opengraph_image]"><strong>Facebook Image: </strong></label>
               </div>
               <div class="form-field">
                <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[opengraph_image]" id="<?php echo BYTEBUNCH_SEO; ?>[opengraph_image]" class="bytebunch_seo_image_upload_input" value="<?php if(isset($bytebunch_seo_meta['opengraph_image'])){ echo $bytebunch_seo_meta['opengraph_image']; } ?>" /><input id="bytebunch_seo_opengraph_image_button" class="bytebunch_seo_image_upload_button button" type="button" value="Upload Image">
                <br /><small>If you want to override the image used on Facebook for this post, upload / choose an image or add the URL here. The recommended image size for Facebook is 1200 x 628px.</small>
               </div>
               <div class="clearboth"></div>
            </div>




            <div class="row">
               <div class="form-label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[twitter_title]"><strong>Twitter Title:</strong></label>
               </div>
               <div class="form-field">
                <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[twitter_title]" id="<?php echo BYTEBUNCH_SEO; ?>[twitter_title]" class="large-text" value="<?php if(isset($bytebunch_seo_meta['twitter_title'])){ echo $bytebunch_seo_meta['twitter_title']; } ?>" />
                <br /><small>If you don't want to use the post title for sharing the post on Twitter but instead want another title there, write it here.</small>
               </div>
               <div class="clearboth"></div>
            </div>

            <div class="row">
            <div class="form-label">
               <label for="<?php echo BYTEBUNCH_SEO; ?>[twitter_desc]"><strong>Twitter Description:</strong> </label>
            </div>
               <div class="form-field">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[twitter_desc]" id="<?php echo BYTEBUNCH_SEO; ?>[twitter_desc]" class="large-text" rows="5"><?php if(isset($bytebunch_seo_meta['twitter_desc'])){ echo $bytebunch_seo_meta['twitter_desc']; } ?></textarea>
                  <br /><small>If you don't want to use the meta description for sharing the post on Twitter but want another description there, write it here.</small>
               </div>
               <div class="clearboth"></div>
            </div>
            <div class="row">
               <div class="form-label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[twitter_image]"><strong>Twitter Image: </strong></label>
               </div>
               <div class="form-field">
                <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[twitter_image]" id="<?php echo BYTEBUNCH_SEO; ?>[twitter_image]" class="bytebunch_seo_image_upload_input" value="<?php if(isset($bytebunch_seo_meta['twitter_image'])){ echo $bytebunch_seo_meta['twitter_image']; } ?>" /><input id="bytebunch_seo_twitter_image_button" class="bytebunch_seo_image_upload_button button" type="button" value="Upload Image">
                <br /><small>If you want to override the image used on Twitter for this post, upload / choose an image or add the URL here. The recommended image size for Twitter is 1024 x 512px.</small>
               </div>
               <div class="clearboth"></div>
            </div>
         </div><!-- bytebunch seo tab2 div end here -->
      </div><!-- bytebunch_seo_meta_box_container div end here-->
          <?php
      }

      /**
      * Saves the custom meta input
      */
     public function save_meta_box_data( $post_id ) {

         // Checks save status
         $is_autosave = wp_is_post_autosave( $post_id );
         $is_revision = wp_is_post_revision( $post_id );


         // Exits script depending on save status
         if ( $is_autosave || $is_revision ) {
             return;
         }


         if ( isset( $_POST[BYTEBUNCH_SEO] ) ) {

           $bytebunch_seo_meta = get_post_meta($post_id, BYTEBUNCH_SEO, true );
           if(!$bytebunch_seo_meta)
             $bytebunch_seo_meta = array();

           $bytebunch_seo_meta_keys = array_keys( $_POST[BYTEBUNCH_SEO] );
           foreach ( $bytebunch_seo_meta_keys as $key ) {
              if ( isset ( $_POST[BYTEBUNCH_SEO][$key] ) ) {
                 $bytebunch_seo_meta[$key] = htmlentities(stripcslashes(trim($_POST[BYTEBUNCH_SEO][$key])));
              }
           }

           update_post_meta( $post_id, BYTEBUNCH_SEO, $bytebunch_seo_meta );
        }






         /*// Checks for input and sanitizes/saves if needed
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
         }*/

     }

   }
}
