<?php
/*  if(isset($_POST[BYTEBUNCH_SEO_SOCIAL]) && is_array($_POST[BYTEBUNCH_SEO_SOCIAL]) && count($_POST[BYTEBUNCH_SEO_SOCIAL]) >= 1){
    $this->save_form_data($_POST[BYTEBUNCH_SEO_SOCIAL]);
  }*/
?>
<div class="wrap bytebunch_seo_container"><div id="icon-tools" class="icon32"></div>
<form method="post" action="options.php">
  <!-- <form method="post" action=""> -->
      <?php
        settings_fields(BYTEBUNCH_SEO_SOCIAL);
       ?>
      <h2>Social - ByteBunch SEO</h2>
      <ul class="tabbed_menu">
         <li><a href="#bytebunch_seo_tab1">Facebook</a></li>
         <li><a href="#bytebunch_seo_tab2">Twitter</a></li>
         <li><a href="#bytebunch_seo_tab3"> Google+</a></li>
<!--         <li><a href="#bytebunch_seo_tab4">Linked In</a></li>
         <li><a href="#bytebunch_seo_tab5">Pinterest</a></li>-->
      </ul>
      <div class="clearboth" style="border-top:1px solid #ccc;"></div>
      <div class="setting_pages_content_wrapper">

         <div id="bytebunch_seo_tab1" class="tab_menu_content">
            <p>Add Open Graph meta data to your site's <head> section, Facebook and other social networks use this data when your pages are shared.</p>

               <p><input type="checkbox" name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[opengraph]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[opengraph]" <?php checked( $this->get_option('opengraph') ,'Yes',true); ?> value="Yes" /> &nbsp; <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[opengraph]">Add Open Graph meta data</label></p>
               <h3>Home page / Front page settings</h3>
               <p>These are the title, description and image used in the Open Graph meta tags on the front page of your site</p>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[title_opengraph_home]">Title</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[title_opengraph_home]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[title_opengraph_home]" value="<?php echo $this->get_option('title_opengraph_home'); ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[desc_opengraph_home]">Meta description template:</label>
               </div>
               <div class="field_input">
                  <textarea name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[desc_opengraph_home]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[desc_opengraph_home]" cols="45" rows="5"><?php echo $this->get_option('desc_opengraph_home'); ?></textarea>
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->

            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[image_opengraph_home]">Image URL</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[image_opengraph_home]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[image_opengraph_home]" value="<?php echo $this->get_option('image_opengraph_home'); ?>" /> <input type="button" id="" class="bytebunch_seo_image_upload_button button" value="Upload Image">
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <h3>Default settings</h3>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[image_opengraph_default]">Image URL</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[image_opengraph_default]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[image_opengraph_default]" value="<?php echo $this->get_option('image_opengraph_default'); ?>" /> <input type="button" id="" class="bytebunch_seo_image_upload_button button" value="Upload Image"> <br> <small>This image is used if the post/page being shared does not contain any images.</small>
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[facebook_app_id]">Facebook App ID:</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[facebook_app_id]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[facebook_app_id]" value="<?php echo $this->get_option('facebook_app_id'); ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
         </div>


         <div id="bytebunch_seo_tab2" class="tab_menu_content">
            <p>Add Twitter card meta data to your site's <head> section.</p>

            <p><input type="checkbox" name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[twitter]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[twitter]" <?php checked($this->get_option('twitter') ,'Yes',true); ?> value="Yes" /> &nbsp; <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[twitter]">Add Twitter card meta data</label></p>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[twitter_username]">Twitter username:</label>
                  <br /><small>Put only the user without the @</small>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[twitter_username]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[twitter_username]" value="<?php echo $this->get_option('twitter_username'); ?>" />

               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[twitter_card_type]">The default card type to use:</label>
               </div>
               <div class="field_input">
                  <select name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[twitter_card_type]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[twitter_card_type]">
                  <?php
                  $twitter_card_types = array('summary'=>'Summary','summary_large_image' => 'Summary with large image');

                  foreach($twitter_card_types as $key=>$card_type){
                     echo '<option value="'.$key.'" '.  selected($this->get_option('twitter_card_type'),$key,false).'>'.$card_type.'</option>';
                  }
                  ?>
                  </select>

               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->

         </div> <!-- tab2 div end here-->

         <div id="bytebunch_seo_tab3" class="tab_menu_content">
            <p>If you have a Google+ page for your business, add that URL here and link it on your Google+ page's about page.</p>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[google_plus_publisher]">Google Publisher Page:</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[google_plus_publisher]" id="<?php echo BYTEBUNCH_SEO_SOCIAL; ?>[google_plus_publisher]" value="<?php echo $this->get_option('google_plus_publisher'); ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
         </div><!-- tab3 div end here-->

         <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
       </p>
      </div>
   </form>
</div>
