<?php
if(!class_exists('bytebunch_seo_core')){
   class bytebunch_seo_core extends bytebunch_seo{
      
      private $title_separator = NULL;
      private $site_name = NULL;
      
      public function __construct(){
         
            add_filter('wp_title', array($this,'wp_title'));
            //add_action('wp_head', array($this,'wp_head'),0);
            
            $this->title_separator = $this->get_title_separator();
            $this->site_name = get_bloginfo('name');
      }
      
      
      function wp_title( $title )
      {
         if ( is_feed() ) {
            return $title;
         }
         
         
         $dummy_value = '';
         $modify_title = false;
         
         if(is_home() || is_front_page()){
            if($dummy_value = $this->get_option('title_home')){
               $title = str_replace(array('{site_name}','{sep}','{site_description}'), array($this->site_name,$this->title_separator, get_bloginfo( 'description')), $dummy_value);
               $modify_title = true;
            }
         }
         elseif(is_singular()){
            
            global $post;
            $seo_title = get_post_meta($post->ID,BYTEBUNCH_SEO,true);
            if($seo_title && isset($seo_title['title']) && $seo_title['title']){
               $title = str_replace(array('{site_name}','{sep}'),array($this->site_name,$this->title_separator), $seo_title['title']);
            }
         }
         
         // Add a page number if necessary:
         global $page, $paged;
         if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
            if($modify_title && $dummy_value = $this->get_option('title_pagination')){
               $title = str_replace(array('{title}','{sep}','{num}'), array($title,$this->title_separator,$paged), $dummy_value);
            }
         }
         
         //$title = str_replace("|", "-", $title);
         return $title;
      }
      
      
      
      
      function wp_head(){
         
         if($this->get_option('desc_opengraph_home')){
            //alert($this->get_option('desc_opengraph_home'));
         }else{
            //alert('oh, its else');
         }
         
         
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
      
      private function get_title_separator(){
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
         if($this->get_option('title_separator')){
            foreach($separator_options as $key=>$separator){
               if($this->get_option('title_separator') == $key){
                  return $separator;
                  break;
               }
            }
         }else{
            return '|';
         }
      }
   }
}

$bytebunch_seo_core_object = new bytebunch_seo_core();