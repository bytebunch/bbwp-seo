<?php

class BBWP_SEO_TaxonomyMetaFields{

  protected $allowed_taxonomies = array(/*'post_tag','category'*/);

  public function __construct(){
    add_action( 'admin_init', array($this,'admin_init') );
  }

  public function admin_init(){
    $args = array('public' => true);
    $this->allowed_taxonomies = get_taxonomies($args);

     foreach($this->allowed_taxonomies as $allowed_taxonomy){
       if($allowed_taxonomy == 'post_format')
         continue;
       add_action( $allowed_taxonomy.'_add_form_fields',array($this,'taxonomy_add_new_meta_field'),10,2);
       add_action( $allowed_taxonomy.'_edit_form_fields',array($this,'taxonomy_edit_meta_field'),10,2);
       add_action( 'edited_'.$allowed_taxonomy, array($this,'save_taxonomy_custom_meta'), 10, 2 );
       add_action( 'create_'.$allowed_taxonomy, array($this,'save_taxonomy_custom_meta'), 10, 2 );
     }
  }

  // Add term page
  public function taxonomy_add_new_meta_field() {
     // this will add the custom meta field to the add new term page ?>
     <div class='bytebunch_seo_taxonomy_container'>
        <h3>ByteBunch SEO options</h3>
        <div class="form-field">
           <label for="<?php echo BBWP_SEO; ?>[title]">SEO Title</label>
           <input type="text" name="<?php echo BBWP_SEO; ?>[title]" id="<?php echo BBWP_SEO; ?>[title]" value="">
           <p class="description">If you leave empty will default the title of the term.</p>
        </div>
        <div class="form-field">
           <label for="<?php echo BBWP_SEO; ?>[desc]">SEO Description</label>
           <textarea name="<?php echo BBWP_SEO; ?>[desc]" id="<?php echo BBWP_SEO; ?>[desc]" rows="5" cols="40"></textarea>
           <p class="description">If you leave empty will default the term description will be used. The meta description will be limited to 156 chars</p>
        </div>
        <div class="form-field">
           <label for="<?php echo BBWP_SEO; ?>[focuskw]">SEO Focus Keywords</label>
           <input type="text" name="<?php echo BBWP_SEO; ?>[focuskw]" id="<?php echo BBWP_SEO; ?>[focuskw]" value="">
           <p class="description">For what? This is already obsolete by google since 2009. We recommend that you do not put anything here that because the google search engine may penalize you.</p>
        </div>
     </div>

        <?php
  }
  // Edit term page
  public function taxonomy_edit_meta_field($term) {

     // put the term ID into a variable
     $t_id = $term->term_id;

     // retrieve the existing value(s) for this meta field. This returns an array
     //$term_meta = get_option( BBWP_SEO."_taxonomy_$t_id" );
     $term_meta = get_term_meta($t_id, BBWP_SEO, true ); ?>
     <tr class="form-field"><th colspan='2'><h3>ByteBunch SEO options</h3></th></tr>
     <tr class="form-field">
     <th scope="row" valign="top">

        <label for="<?php echo BBWP_SEO; ?>[title]">SEO title</label></th>
        <td>
           <input type="text" name="<?php echo BBWP_SEO; ?>[title]" id="<?php echo BBWP_SEO; ?>[title]" value="<?php if(isset($term_meta['title'])){ echo $term_meta['title']; } ?>">
           <p class="description">If you leave empty will default the title of the term.</p>
        </td>
     </tr>

     <tr class="form-field">
     <th scope="row" valign="top">
        <label for="<?php echo BBWP_SEO; ?>[desc]">SEO Description</label></th>
        <td>
           <textarea name="<?php echo BBWP_SEO; ?>[desc]" id="<?php echo BBWP_SEO; ?>[desc]"><?php if(isset($term_meta['desc'])){ echo $term_meta['desc']; } ?></textarea>
           <p class="description">If you leave empty will default the term description will be used. The meta description will be limited to 156 chars.</p>
        </td>
     </tr>

     <tr class="form-field">
     <th scope="row" valign="top">
        <label for="<?php echo BBWP_SEO; ?>[focuskw]">SEO Focus Keywords</label></th>
        <td>
           <input type="text" name="<?php echo BBWP_SEO; ?>[focuskw]" id="<?php echo BBWP_SEO; ?>[focuskw]" value="<?php if(isset($term_meta['focuskw'])){ echo $term_meta['focuskw']; } ?>">
           <p class="description">If you leave empty will default the title of the term.</p>
        </td>
     </tr>
  <?php
  }

  // Save extra taxonomy fields callback function.
  public function save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST[BBWP_SEO] ) ) {
      $bytebunch_seo_meta = get_term_meta($term_id, BBWP_SEO, true );
      if(!$bytebunch_seo_meta)
        $bytebunch_seo_meta = array();

      $bytebunch_seo_meta_keys = array_keys( $_POST[BBWP_SEO] );
      foreach ( $bytebunch_seo_meta_keys as $key ) {
         if ( isset ( $_POST[BBWP_SEO][$key] ) ) {
            $bytebunch_seo_meta[$key] = htmlentities(stripcslashes(trim($_POST[BBWP_SEO][$key])));
         }
      }
      update_term_meta( $term_id, BBWP_SEO, $bytebunch_seo_meta );
   }
  }


}
