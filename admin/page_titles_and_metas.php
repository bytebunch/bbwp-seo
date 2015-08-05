<div class="wrap bytebunch_seo_container"><div id="icon-tools" class="icon32"></div>
   <form method="post" action="options.php">
      <?php
       settings_fields(BYTEBUNCH_SEO);
       
       ?>
      <h2>Titles & Metas - ByteBunch SEO</h2>
      <ul class="tabbed_menu">
         <li><a href="#bytebunch_seo_tab1">Home Page</a></li>
         <li><a href="#bytebunch_seo_tab2">Post Types</a></li>
         <li><a href="#bytebunch_seo_tab3">Taxonomies</a></li>
         <li><a href="#bytebunch_seo_tab4">Archives</a></li>
         <li><a href="#bytebunch_seo_tab5">Special Pages</a></li>
         <li><a href="#bytebunch_seo_tab6">Other</a></li>
      </ul>
      <div class="clearboth" style="border-top:1px solid #ccc;"></div>
      <div class="setting_pages_content_wrapper">
         
         <div id="bytebunch_seo_tab1" class="tab_menu_content">
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[title_home]">Title template:</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[title_home]" id="<?php echo BYTEBUNCH_SEO; ?>[title_home]" value="<?php if(isset(parent::$data['title_home'])){echo parent::$data['title_home'];}else{echo '{site_name} {sep} {site_description}';} ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[desc_home]">Meta description template:</label>
               </div>
               <div class="field_input">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[desc_home]" id="<?php echo BYTEBUNCH_SEO; ?>[desc_home]" cols="45" rows="5"><?php if(isset(parent::$data['desc_home'])){echo parent::$data['desc_home'];} ?></textarea>
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
         </div>
         
         <div id="bytebunch_seo_tab2" class="tab_menu_content">
            <h4>Posts</h4>
            <h4>Pages</h4>
            <h4>Media</h4>
         </div>
         
         <div id="bytebunch_seo_tab3" class="tab_menu_content">
            <h4>Categories</h4>
            <h4>Tags</h4>
         </div>
         
         <div id="bytebunch_seo_tab4" class="tab_menu_content">
            <h4>Author Archive</h4>
            <h4>Day Archive</h4>
            <h4>Month Archive</h4>
            <h4>Year Archive</h4>
         </div>
         
         <div id="bytebunch_seo_tab5" class="tab_menu_content">
            <h4>Search Page</h4>
            <h4>404 Page</h4>
            <h4>Pagination Pages</h4>
         </div>
         
         <div id="bytebunch_seo_tab6" class="tab_menu_content">
            <h4>Title Separator</h4>
<!--            $separator_options = array(
'sc-dash' => '-',
'sc-ndash' => '–',
'sc-mdash' => '—',
'sc-middot' => '·',
'sc-bull' => '•',
'sc-star' => '*',
'sc-smstar' => '⋆',
'sc-pipe' => '|',
'sc-tilde' => '~',
'sc-laquo' => '«',
'sc-raquo' => '»',
'sc-lt' => '<',
'sc-gt' => '>',
);-->
         </div>
         
      </div><!-- setting pages content wrapper div end here-->
      
       
       <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
       </p>
   </form>
</div>