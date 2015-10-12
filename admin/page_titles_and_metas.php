<?php
  /*if(isset($_POST[BYTEBUNCH_SEO]) && is_array($_POST[BYTEBUNCH_SEO]) && count($_POST[BYTEBUNCH_SEO]) >= 1){
    $this->save_form_data($_POST[BYTEBUNCH_SEO]);
  }*/
  if($this->get_option('reset_bbseo') && $this->get_option('reset_bbseo') == 'yes'){
    $this->set_option('reset_bbseo','No');
    $this->update_db(true);
  }
?>
<div class="wrap bytebunch_seo_container"><div id="icon-tools" class="icon32"></div>
<form method="post" action="options.php">
  <!-- <form method="post" action=""> -->
      <?php
       settings_fields(BYTEBUNCH_SEO);
       //db($this);
       ?>
      <h2> Titles & Metas - ByteBunch SEO </h2>
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
                  <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[title_home]" id="<?php echo BYTEBUNCH_SEO; ?>[title_home]" value="<?php if($this->get_option('title_home')){ echo $this->get_option('title_home'); }else{echo '{site_name} {sep} {site_description} {page}';} ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[desc_home]">Meta description template:</label>
               </div>
               <div class="field_input">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[desc_home]" id="<?php echo BYTEBUNCH_SEO; ?>[desc_home]" cols="45" rows="5"><?php echo $this->get_option('desc_home'); ?></textarea>
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
         </div>

         <div id="bytebunch_seo_tab2" class="tab_menu_content">
            <?php
            $args = array('public' => true);
            $post_types = get_post_types( $args, 'names' );
            foreach ( $post_types as $post_type ) {
              if($post_type == 'attachment'){
                continue;
              }

               echo '<h4>' . ucfirst($post_type) . '</h4>'; ?>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[title_template_<?php echo $post_type; ?>]">Title template for all pages/posts in this post type:</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[title_template_<?php echo $post_type; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[title_template_<?php echo $post_type; ?>]" value="<?php if($this->get_option('title_template_'.$post_type)){echo $this->get_option('title_template_'.$post_type);}else{echo '{title} {sep} {site_name} {page}';} ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[desc_template_<?php echo $post_type; ?>]">Meta description template for all pages/posts in this post type:</label>
               </div>
               <div class="field_input">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[desc_template_<?php echo $post_type; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[desc_template_<?php echo $post_type; ?>]" cols="45" rows="5"><?php if($this->get_option('desc_template_'.$post_type)){ echo $this->get_option('desc_template_'.$post_type); }else{ echo '{excerpt}'; } ?></textarea>
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[noindex_<?php echo $post_type; ?>]">Meta Robots:</label>
               </div>
               <div class="field_input">
                  <input type="checkbox" name="<?php echo BYTEBUNCH_SEO; ?>[noindex_<?php echo $post_type; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[noindex_<?php echo $post_type; ?>]" <?php checked( $this->get_option('noindex_'.$post_type) ,'Yes',true); ?> value="Yes" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <?php if(!($post_type == 'page' || $post_type == 'post')){ ?>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $post_type; ?>]">Title for archive page of this post type:</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $post_type; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $post_type; ?>]" value="<?php if($this->get_option('title_'.$post_type)){echo $this->get_option('title_'.$post_type);}else{echo '{title} {sep} {site_name} {page}';} ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $post_type; ?>]">Meta description for archive page of this post type:</label>
               </div>
               <div class="field_input">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $post_type; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $post_type; ?>]" cols="45" rows="5"><?php echo $this->get_option('desc_'.$post_type); ?></textarea>
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <?php }
            }
            ?>

         </div>

         <div id="bytebunch_seo_tab3" class="tab_menu_content">
            <?php
            $args = array(
               'public'   => true
            );
            $taxonomies = get_taxonomies($args);
            foreach ( $taxonomies as $taxonomy ) {
                echo '<h4>' . ucfirst($taxonomy) . '</h4>';?>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $taxonomy; ?>]">Title template:</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $taxonomy; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $taxonomy; ?>]" value="<?php if($this->get_option('title_'.$taxonomy)){echo $this->get_option('title_'.$taxonomy);}else{echo '{term_title} {sep} {site_name} {page}';} ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $taxonomy; ?>]">Meta description template:</label>
               </div>
               <div class="field_input">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $taxonomy; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $taxonomy; ?>]" cols="45" rows="5"><?php echo $this->get_option('desc_'.$taxonomy); ?></textarea>
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[noindex_<?php echo $taxonomy; ?>]">Meta Robots:</label>
               </div>
               <div class="field_input">
                  <input type="checkbox" name="<?php echo BYTEBUNCH_SEO; ?>[noindex_<?php echo $taxonomy; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[noindex_<?php echo $taxonomy; ?>]" <?php checked( $this->get_option('noindex_'.$taxonomy) ,'Yes',true); ?> value="Yes" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <?php }
            ?>
         </div>

         <div id="bytebunch_seo_tab4" class="tab_menu_content">
            <?php
            $archive_templates = array(
                array('Author Archive','archive_author','Posts by {author} {sep} {site_name} {page}'),
                array('Day Archive','archive_day','Archives for {month} {day}, {year} {sep} {site_name} {page}'),
                array('Month Archive','archive_month', 'Archives for {month}, {year} {sep} {site_name} {page}'),
                array('Year Archive', 'archive_year','Archives for {year} {sep} {site_name} {page}')
            );
            foreach ( $archive_templates as $archive_template ) {
                echo '<h4>' . ucfirst($archive_template[0]) . '</h4>';?>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $archive_template[1]; ?>]">Title template:</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $archive_template[1]; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $archive_template[1]; ?>]" value="<?php if($this->get_option('title_'.$archive_template[1])){echo $this->get_option('title_'.$archive_template[1]);}else{echo $archive_template[2];} ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $archive_template[1]; ?>]">Meta description template:</label>
               </div>
               <div class="field_input">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $archive_template[1]; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $archive_template[1]; ?>]" cols="45" rows="5"><?php echo $this->get_option('desc_'.$archive_template[1]); ?></textarea>
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[noindex_<?php echo $archive_template[1]; ?>]">Meta Robots:</label>
               </div>
               <div class="field_input">
                  <input type="checkbox" name="<?php echo BYTEBUNCH_SEO; ?>[noindex_<?php echo $archive_template[1]; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[noindex_<?php echo $archive_template[1]; ?>]" <?php checked( $this->get_option('noindex_'.$archive_template[1]) ,'Yes',true); ?> value="Yes" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <?php }
            ?>

         </div>

         <div id="bytebunch_seo_tab5" class="tab_menu_content">
            <?php
            $archive_templates = array(
                array('Search Page','search','Search Results for {searchphrase} {sep} {site_name} {page}'),
                array('404 Page','404','Page not found {sep} {site_name}'),
                array('Pagination Pages','pagination', '{sep} Page {num}')
            );
            foreach ( $archive_templates as $archive_template ) {
                echo '<h4>' . ucfirst($archive_template[0]) . '</h4>';?>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $archive_template[1]; ?>]">Title template:</label>
               </div>
               <div class="field_input">
                  <input type="text" name="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $archive_template[1]; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[title_<?php echo $archive_template[1]; ?>]" value="<?php if($this->get_option('title_'.$archive_template[1])){echo $this->get_option('title_'.$archive_template[1]);}else{echo $archive_template[2];} ?>" />
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <?php if($archive_template[1] != 'pagination'){ ?>
            <div class="row">
               <div class="field_label">
                  <label for="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $archive_template[1]; ?>]">Meta description template:</label>
               </div>
               <div class="field_input">
                  <textarea name="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $archive_template[1]; ?>]" id="<?php echo BYTEBUNCH_SEO; ?>[desc_<?php echo $archive_template[1]; ?>]" cols="45" rows="5"><?php echo $this->get_option('desc_'.$archive_template[1]); ?></textarea>
               </div>
               <div class="clearboth"></div>
            </div><!-- row div end here-->
            <?php }
            }
            ?>

         </div>

         <div id="bytebunch_seo_tab6" class="tab_menu_content title_separator">
            <div class="row">
               <div class="field_label">Title Separator
               </div>
               <div class="field_input">
                  <?php
                  $separator_options = array(
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
                  );
                  if($this->get_option('title_separator')){ $checked = $this->get_option('title_separator');}
                  else {$checked = 'sc-pipe';}
                  foreach ($separator_options as $key=>$separator){
                     echo '<input id="'.BYTEBUNCH_SEO.'_'.$key.'" name="'.BYTEBUNCH_SEO.'[title_separator]" type="radio" value="'.$key.'" '.checked( $checked ,$key,false).' class="radio" />';
                     echo '<label for="'.BYTEBUNCH_SEO.'_'.$key.'" class="separator_label">'.$separator.'</label>';
                  }
                  ?>
               </div>
               <div class="clearboth"></div>
            </div>
            <div class="row">
              <input type="checkbox" id="reset_bbseo" name="<?php echo BYTEBUNCH_SEO; ?>[reset_bbseo]" value="yes" /> <label for="reset_bbseo">Reset All Settings</label>
              <!-- <a class="button" href="<?php echo add_query_arg( array("reset_bbseo" => "true"), $_SERVER['REQUEST_URI'] ); ?>">Reset All Setting</a> -->
            </div><!-- row div end here-->
         </div>

      </div><!-- setting pages content wrapper div end here-->


       <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
       </p>
   </form>
</div>
