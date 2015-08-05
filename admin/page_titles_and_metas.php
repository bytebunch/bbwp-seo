<div class="wrap"><div id="icon-tools" class="icon32"></div>
   <form method="post" action="options.php">
      <h2>Titles & Metas - ByteBunch SEO</h2>
   
      <ul class="tabbed_menu">
         <li><a href="#bytebunch_seo_tab1">Home Page</a></li>
         <li><a href="#bytebunch_seo_tab2">Post Types</a></li>
         <li><a href="#bytebunch_seo_tab1">Taxonomies</a></li>
         <li><a href="#bytebunch_seo_tab2">Archives</a></li>
         <li><a href="#bytebunch_seo_tab1">Special Pages</a></li>
         <li><a href="#bytebunch_seo_tab2">Other</a></li>
      </ul>
       <?php 
       //update_option('bytebunch_seo', array());
       settings_fields('bytebunch_seo');
       //do_settings_sections( 'bytebunch_seo' );
       $bytebunch_seo_options = get_option('bytebunch_seo');
       ?>
       <table class="form-table">
           <tr valign="top"><th scope="row">App URL:</th>
               <td><input type="text" name="bytebunch_seo[url_todo]" value="<?php if(isset($options['url_todo']))echo $options['url_todo']; ?>" /></td>
           </tr>
           <tr valign="top"><th scope="row">Title:</th>
               <td><input type="text" name="bytebunch_seo[title_todo]" value="<?php if(isset($options['title_todo'])) { echo $options['title_todo']; } ?>" /></td>
           </tr>
       </table>
       <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
       </p>
   </form>
</div>