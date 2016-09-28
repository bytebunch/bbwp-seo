<?php

class BBWP_SEO_Core extends BBWP_SEO{

  private $title_separator = NULL;
  private $site_name = NULL;
  private $page_title = NULL;
  //private $page_num = NULL;

  public function __construct(){

        add_filter('document_title_parts', array($this,'wp_title'));
        add_action('wp_head', array($this,'wp_head'),1);

        $this->title_separator = $this->get_title_separator();
        $this->site_name = get_bloginfo('name');
  }

  /*****************************************/
  /* wp_head function start from here */
  /****************************************/
  function wp_head(){

    $output = NULL;
    $seo_keywords = NULL;
    $seo_description = NULL;
    $is_canonical = NULL;

    $is_twitter_card = $this->get_option('twitter');
    $is_opengraph = $this->get_option('opengraph');
    $ogTitle = $this->page_title;
    $ogDesc = NULL;
    $ogType = 'website';
    $ogURL = home_url();
    $ogImage = $this->get_option('image_opengraph_default');
    $canonical_url = NULL;
    $noseo = NULL;


     if(is_home() || is_front_page()){
       $canonical_url = $ogURL;
       if(!($seo_description = $this->get_option('desc_home')))
          $seo_description = get_bloginfo('description');

       if($is_opengraph){
         if(!($ogTitle = $this->get_option('title_opengraph_home')))
            $ogTitle = $this->page_title;
         if(!($ogDesc = $this->get_option('desc_opengraph_home')))
            $ogDesc = $seo_description;
         if($this->get_option('image_opengraph_home'))
            $ogImage = $this->get_option('image_opengraph_home');
       }
     }
     else if(is_singular()){
        global $post;
        $canonical_url = get_the_permalink($post->ID);
        if($this->get_option('noindex_'.$post->post_type))
          $noseo = true;
        if(isset($post) && $post->post_content)
          $seo_description = $this->get_the_excerpt($post->post_content);
        $bbseoMetaData = get_post_meta($post->ID, BBWP_SEO, true);
        if(isset($bbseoMetaData['focuskw']) && $bbseoMetaData['focuskw'])
          $seo_keywords = $bbseoMetaData['focuskw'];
        if(isset($bbseoMetaData['metadesc']) && $bbseoMetaData['metadesc'])
          $seo_description = $bbseoMetaData['metadesc'];
        else if($this->get_option('desc_template_'.$post->post_type))
          $seo_description = str_replace(array("{excerpt}","{empty}"),array($seo_description,""),$this->get_option('desc_template_'.$post->post_type));

        if($is_opengraph){
          $ogURL = $canonical_url;
          $ogTitle = get_the_title($post->ID);
          if(isset($bbseoMetaData['opengraph_title']) && $bbseoMetaData['opengraph_title'])
            $ogTitle = $bbseoMetaData['opengraph_title'];
          if(!(isset($bbseoMetaData['opengraph_desc']) && $ogDesc = $bbseoMetaData['opengraph_desc']))
            $ogDesc = $seo_description;
          if(isset($bbseoMetaData['opengraph_image']) && $bbseoMetaData['opengraph_image'])
            $ogImage = $bbseoMetaData['opengraph_image'];
        }
     }
     else if(is_post_type_archive()){
       $pTitle = get_query_var('post_type');
       $canonical_url = get_post_type_archive_link( $pTitle );
       if($this->get_option('noindex_'.$pTitle))
         $noseo = true;
       if(!($this->page_num && $this->page_num >= 2))
          $canonical_url = get_post_type_archive_link( $pTitle );
       if($this->get_option('noindex_'.$pTitle))
         $noseo = true;
       if($this->get_option('desc_'.$pTitle))
         $seo_description = $this->get_option('desc_'.$pTitle);

       if($is_opengraph){
         $ogURL = $canonical_url;
         //$ogTitle = ucfirst($pTitle);
         $ogDesc = $seo_description;
       }
    }
    else if(is_tax() || is_category() || is_tag()){
       $term_data = get_queried_object();
       $canonical_url = get_term_link( $term_data );
       //$term_title = $term_data->name;
       if($this->get_option('noindex_'.$term_data->taxonomy))
         $noseo = true;
       $term_seo_data = get_term_meta($term_data->term_id, BBWP_SEO, true);
       if($term_seo_data && isset($term_seo_data['focuskw']) && $term_seo_data['focuskw'])
         $seo_keywords = $term_seo_data['focuskw'];
       if($term_seo_data && isset($term_seo_data['desc']) && $term_seo_data['desc'])
         $seo_description = $term_seo_data['desc'];
       else if(isset($term_data->taxonomy) && $this->get_option('desc_'.$term_data->taxonomy))
         $seo_description = $this->get_option('desc_'.$term_data->taxonomy);

       if($is_opengraph){
         $ogURL = $canonical_url;
         //$ogTitle = ucfirst($pTitle);
         $ogDesc = $seo_description;
       }
     }
     else if(is_search()){
       $noseo = true;
       if($this->get_option('desc_search'))
         $seo_description = $this->get_option('desc_search');

       if($is_opengraph){
         $ogURL = get_search_link();
         //$ogTitle = ucfirst($pTitle);
         $ogDesc = $seo_description;
       }
     }
     else if(is_404()){
       $noseo = true;
       if($this->get_option('desc_404'))
         $seo_description = $this->get_option('desc_404');
     }
     else if(is_author()){
       $author_data = get_queried_object();
       $canonical_url = get_author_posts_url($author_data->ID);
       if($this->get_option('noindex_archive_author'))
         $noseo = true;
       if($this->get_option('desc_archive_author'))
         $seo_description = $this->get_option('desc_archive_author');

       if($is_opengraph){
         $ogURL = $canonical_url;
         //$ogTitle = ucfirst($pTitle);
         $ogDesc = $seo_description;
       }
     }
     else if(is_day()){
       $canonical_url = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
       if($this->get_option('noindex_archive_day'))
         $noseo = true;
       if($this->get_option('desc_archive_day'))
         $seo_description = $this->get_option('desc_archive_day');

       if($is_opengraph){
         $ogURL = $canonical_url;
         //$ogTitle = ucfirst($pTitle);
         $ogDesc = $seo_description;
       }
     }
     else if(is_month()){
       $canonical_url = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
       if($this->get_option('noindex_archive_month'))
         $noseo = true;
       if($this->get_option('title_archive_month'))
         $seo_description = $this->get_option('title_archive_month');

       if($is_opengraph){
         $ogURL = $canonical_url;
         //$ogTitle = ucfirst($pTitle);
         $ogDesc = $seo_description;
       }
     }
     else if(is_year()){
       $canonical_url = get_year_link( get_query_var( 'year' ) );
       if($this->get_option('noindex_archive_year'))
         $noseo = true;
       if($this->get_option('desc_archive_year'))
         $seo_description = $this->get_option('desc_archive_year');

       if($is_opengraph){
         $ogURL = $canonical_url;
         //$ogTitle = ucfirst($pTitle);
         $ogDesc = $seo_description;
       }
     }

     $canonical_url = $this->add_subpage_url($canonical_url);
     $ogURL = $this->add_subpage_url($ogURL);

     $output .= "<!-- This site is optimized with the WordPress ByteBunch SEO  plugin v1.0 - http://bytebunch.com  -->\n";
     if($noseo)
        $output .= '<meta name="robots" content="noindex,follow"/>'."\n";
     if($seo_description)
        $output .= '<meta name="description" content="'.$seo_description.'" />'."\n";
     if($seo_keywords)
        $output .= '<meta name="keywords" content="'.$seo_keywords.'" />'."\n";

     if($canonical_url)
        $output .= '<link rel="canonical" href="'.$canonical_url.'" />'."\n";

     if($google_plus_publisher = $this->get_option('google_plus_publisher'))
        $output .= '<link rel="publisher" href="'.$google_plus_publisher.'"/>'."\n";

      if($is_opengraph){
        $output .= '<meta property="og:locale" content="'.get_locale().'" />'."\n";
        $output .= '<meta property="og:type" content="'.$ogType.'" />'."\n";
        $output .= '<meta property="og:title" content="'.$ogTitle.'" />'."\n";
        $output .= '<meta property="og:url" content="'.$ogURL.'" />'."\n";
        $output .= '<meta property="og:site_name" content="'.$this->site_name.'" />'."\n";
        if($ogDesc)
          $output .= '<meta property="og:description" content="'.$ogDesc.'" />'."\n";
        if($ogImage)
          $output .= '<meta property="og:image" content="'.$ogImage.'" />'."\n";
        if($facebook_app_id = $this->get_option('facebook_app_id'))
          $output .= '<meta property="fb:admins" content="'.$facebook_app_id.'" />'."\n";
      }

      if($is_twitter_card){
        $output .= '<meta name="twitter:card" content="'.$this->get_option('twitter_card_type').'" />'."\n";
        $output .= '<meta name="twitter:domain" content="'.$this->site_name.'" />'."\n";
        $output .= '<meta name="twitter:title" content="'.$ogTitle.'" />'."\n";
        if($this->get_option('twitter_username'))
          $output .= '<meta name="twitter:site" content="@'.$this->get_option('twitter_username').'" />'."\n";
        if($ogDesc)
          $output .= '<meta name="twitter:description" content="'.$ogDesc.'" />'."\n";
        if($ogImage)
          $output .= '<meta name="twitter:image" content="'.$ogImage.'" />'."\n";
      }


     $output .= "<!-- / ByteBunch SEO  plugin -->\n";
     echo $output;
  } // wp_head function end here

  /*****************************************/
  /* wp_title function start from here */
  /****************************************/
  public function wp_title( $title )
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

     global $page, $paged, $wp_query;
     if ( ( $paged >= 2 || $page >= 2 ) && !is_404()) {

       if($paged >= 2)
          $page_num = $paged;
       else if($page >= 2)
          $page_num = $page;
      $this->page_num = $page_num;
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
        $seo_title = get_post_meta($post->ID, BBWP_SEO, true);
        if($seo_title && isset($seo_title['title']) && $seo_title['title']){
          $title_format = $seo_title['title'];
        }else if(isset($post->post_type) && $this->get_option('title_template_'.$post->post_type)){
           $title_format = $this->get_option('title_template_'.$post->post_type);
        }else
          $title_format = '{title} {sep} {site_name} {page}';
     }
     else if(is_post_type_archive()){
       $pTitle = get_query_var('post_type');
       if($this->get_option('title_'.$pTitle))
         $title_format = $this->get_option('title_'.$pTitle);
       else
         $title_format = '{title} {sep} {site_name} {page}';
      $post_type_object = get_post_type_object($pTitle);
      if($post_type_object && isset($post_type_object->name) && isset($post_type_object->labels->name))
        $pTitle = $post_type_object->labels->name;
      else
        $pTitle = ucfirst($pTitle);
    }
     else if(is_tax() || is_category() || is_tag()){
       $term_data = get_queried_object();
       $term_title = $term_data->name;
       $term_seo_data = get_term_meta( $term_data->term_id, BBWP_SEO, true);
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
         $title_format = 'Search Results for {searchphrase} {sep} {site_name} {page}';
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
         $title_format = 'Posts by {author} {sep} {site_name} {page}';
     }
     else if(is_day()){
       $year = get_query_var('year');
   		 $month = $this->get_month_name(get_query_var('monthnum'));
       $day = get_query_var('day');
       if($this->get_option('title_archive_day'))
         $title_format = $this->get_option('title_archive_day');
       else
         $title_format = 'Archives for {month} {day}, {year} {sep} {site_name} {page}';
     }
     else if(is_month()){
       $year = get_query_var('year');
   		 $month = $this->get_month_name(get_query_var('monthnum'));
       if($this->get_option('title_archive_month'))
         $title_format = $this->get_option('title_archive_month');
       else
         $title_format = 'Archives for {month}, {year} {sep} {site_name} {page}';
     }
     else if(is_year()){
       $year = get_query_var('year');
       if($this->get_option('title_archive_year'))
         $title_format = $this->get_option('title_archive_year');
       else
         $title_format = 'Archives for {year} {sep} {site_name} {page}';
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
    $this->page_title = $title;

    return array('title' => $title, 'page' => '', 'tagline' => '', 'site' => '');
  } // wp_title end here


  /*****************************************/
  /*    Get the the separator function start from here */
  /*************************************/
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
        return '-';
  }// get_title_separator end here


}// class ByteBunchSEOCore end here
