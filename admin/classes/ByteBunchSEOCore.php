<?php
if(!class_exists('ByteBunchSEOCore')){
   class ByteBunchSEOCore extends ByteBunchSEO{

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

         $title_format = NULL;
         $page_num = NULL;
         $pTitle = NULL;
         $term_title = NULL;
         $year = NULL;
         $month = NULL;
         $day = NULL;
         $author = NULL;

         global $page, $paged;
         if ( ( $paged >= 2 || $page >= 2 ) && !is_404()) {

           if($paged >= 2)
              $page_num = $paged;
           else if($page >= 2)
              $page_num = $page;

           if($dummy_value = $this->get_option('title_pagination'))
             $page_num = str_replace(array('{sep}','{num}'), array($this->title_separator,$page_num), $dummy_value);
           else
             $page_num = $this->title_separator." Page ".$page_num;
         }

         if(is_home() || is_front_page()){
            if(!($title_format = $this->get_option('title_home')))
               $title_format = '{site_name} {sep} {site_description} {page}';
         }
         elseif(is_singular()){
            global $post;
            $pTitle = get_the_title($post->ID);
            $seo_title = get_post_meta($post->ID, BYTEBUNCH_SEO, true);
            if($seo_title && isset($seo_title['title']) && $seo_title['title']){
              $title_format = $seo_title['title'];
            }else if(isset($post->post_type) && $this->get_option('title_'.$post->post_type)){
               $title_format = $this->get_option('title_'.$post->post_type);
            }else
              $title_format = '{title} {sep} {site_name} {page}';
         }
         else if(is_post_type_archive()){
           $title_format = $title;
         }
         else if(is_tax() || is_category() || is_tag()){
           $term_data = get_queried_object();
           $term_title = $term_data->name;
           $term_seo_data = get_option( BYTEBUNCH_SEO."_taxonomy_".$term_data->term_id );
           if($term_seo_data && isset($term_seo_data['title']) && $term_seo_data['title'])
             $title_format = $term_seo_data['title'];
           else if(isset($term_data->taxonomy) && $this->get_option('title_'.$term_data->taxonomy))
             $title_format = $this->get_option('title_'.$term_data->taxonomy);
           else
             $title_format = '{term_title} {sep} {site_name} {page}';
         }
         else if(is_search()){
           if($this->get_option('title_search'))
             $title_format = $this->get_option('title_search');
           else
             $title_format = '{searchphrase} {sep} {site_name} {page}';
         }
         else if(is_404()){
           if($this->get_option('title_404'))
             $title_format = $this->get_option('title_404');
           else
             $title_format = 'Page not found {sep} {site_name}';
         }
         else if(is_author()){
           global $wp_query;
           $author_data = get_queried_object();
           $author = $author_data->display_name;
           if($this->get_option('title_archive_author'))
             $title_format = $this->get_option('title_archive_author');
           else
             $title_format = '{author} {sep} {site_name} {page}';
         }
         else if(is_day()){
           $year = get_query_var('year');
       		 $month = $this->get_month_name(get_query_var('monthnum'));
           $day = get_query_var('day');
           if($this->get_option('title_archive_day'))
             $title_format = $this->get_option('title_archive_day');
           else
             $title_format = '{day} {sep} {month} {sep} {year} {sep} {site_name} {page}';
         }
         else if(is_month()){
           $year = get_query_var('year');
       		 $month = $this->get_month_name(get_query_var('monthnum'));
           if($this->get_option('title_archive_month'))
             $title_format = $this->get_option('title_archive_month');
           else
             $title_format = '{month} {sep} {year} {sep} {site_name} {page}';
         }
         else if(is_year()){
           $year = get_query_var('year');
           if($this->get_option('title_archive_year'))
             $title_format = $this->get_option('title_archive_year');
           else
             $title_format = '{year} {sep} {site_name} {page}';
         }

         else{
           $title_format = $title;
         }

         $variables = array(
       		'{site_name}' => $this->site_name,
          '{site_description}' => get_bloginfo('description'),
          '{title}' => $pTitle,
          '{term_title}' => $term_title,
          '{author}' => $author,
          '{year}' => $year,
          '{month}' => $month,
          '{day}' => $day,
          '{searchphrase}' => get_search_query(),
          '{sep}' => $this->title_separator,
       		'{page}' => $page_num
       	);

       	$title = str_replace(array_keys($variables), array_values($variables), htmlspecialchars($title_format));
        return $title;
      } // wp_title end here




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
      } // wp_head function end here

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
         }else
            return '|';
      }// get_title_separator end here


   }// class ByteBunchSEOCore end here
}
