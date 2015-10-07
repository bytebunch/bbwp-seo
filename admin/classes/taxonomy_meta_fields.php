<?php
if(!class_exists('taxonomy_meta_fields')){
   class taxonomy_meta_fields{
      
      protected $allowed_taxonomies = array('post_tag','category');
      
      public function __construct(){
         foreach($this->allowed_taxonomies as $allowed_taxonomy){
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
               <label for="bytebunch_seo_term_meta[title]">SEO Title</label>
               <input type="text" name="bytebunch_seo_term_meta[title]" id="bytebunch_seo_term_meta[title]" value="">
               <p class="description">If you leave empty will default the title of the term.</p>
            </div>
            <div class="form-field">
               <label for="bytebunch_seo_term_meta[desc]">SEO Description</label>
               <textarea name="bytebunch_seo_term_meta[desc]" id="bytebunch_seo_term_meta[desc]" rows="5" cols="40"></textarea>
               <p class="description">If you leave empty will default the term description will be used. The meta description will be limited to 156 chars</p>
            </div>
            <div class="form-field">
               <label for="bytebunch_seo_term_meta[focuskw]">SEO Focus Keywords</label>
               <input type="text" name="bytebunch_seo_term_meta[focuskw]" id="bytebunch_seo_term_meta[focuskw]" value="">
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
         $term_meta = get_option( "bytebunch_seo_taxonomy_$t_id" ); ?>
         <tr class="form-field"><th colspan='2'><h3>ByteBunch SEO options</h3></th></tr>
         <tr class="form-field">
         <th scope="row" valign="top">

            <label for="bytebunch_seo_term_meta[title]">SEO title</label></th>
            <td>
               <input type="text" name="bytebunch_seo_term_meta[title]" id="bytebunch_seo_term_meta[title]" value="<?php echo esc_attr( $term_meta['title'] ) ? esc_attr( $term_meta['title'] ) : ''; ?>">
               <p class="description">If you leave empty will default the title of the term.</p>
            </td>
         </tr>

         <tr class="form-field">
         <th scope="row" valign="top">
            <label for="bytebunch_seo_term_meta[desc]">SEO Description</label></th>
            <td>
               <textarea name="bytebunch_seo_term_meta[desc]" id="bytebunch_seo_term_meta[desc]"><?php echo esc_attr( $term_meta['desc'] ) ? esc_attr( $term_meta['desc'] ) : ''; ?></textarea>
               <p class="description">If you leave empty will default the term description will be used. The meta description will be limited to 156 chars.</p>
            </td>
         </tr>

         <tr class="form-field">
         <th scope="row" valign="top">
            <label for="bytebunch_seo_term_meta[focuskw]">SEO Focus Keywords</label></th>
            <td>
               <input type="text" name="bytebunch_seo_term_meta[focuskw]" id="bytebunch_seo_term_meta[focuskw]" value="<?php echo esc_attr( $term_meta['focuskw'] ) ? esc_attr( $term_meta['focuskw'] ) : ''; ?>">
               <p class="description">If you leave empty will default the title of the term.</p>
            </td>
         </tr>
      <?php
      }
      
      // Save extra taxonomy fields callback function.
      public function save_taxonomy_custom_meta( $term_id ) {
         if ( isset( $_POST['bytebunch_seo_term_meta'] ) ) {
            $term_meta = get_option( "bytebunch_seo_taxonomy_$term_id" );
            $cat_keys = array_keys( $_POST['bytebunch_seo_term_meta'] );
            foreach ( $cat_keys as $key ) {
               if ( isset ( $_POST['bytebunch_seo_term_meta'][$key] ) ) {
                  $term_meta[$key] = htmlentities(stripcslashes(trim($_POST['bytebunch_seo_term_meta'][$key])));
               }
            }
            // Save the option array.
            update_option( "bytebunch_seo_taxonomy_$term_id", $term_meta );
         }
      }
      
      
   }
   
}
$taxonomy_meta_fields_object = new taxonomy_meta_fields();