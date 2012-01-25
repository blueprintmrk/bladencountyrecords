<?php
/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/

/** includes woo_themes functions **/
include('functions_woo.php');

/** includes switchyard creative functions **/
include('functions_syc.php');

// remove default portfolio post type
remove_action('init', 'woo_add_portfolio');

function woo_metaboxes_add($woo_metaboxes){
    return;
}

register_nav_menus(array(
  'primary_navigation' => __('Primary Navigation', 'roots'),
  'social_navigaion' => __('Social Navigation', 'roots'),
  'utility_navigation' => __('Utility Navigation', 'roots')
));


/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Artist */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'artist_init');
function artist_init() 
{
    $labels = array(
        'name' => __('Artists'),
        'singular_name' => __('Artist'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New Artist'),
        'edit_item' => __('Edit Artist'),
        'new_item' => __('New Artist'),
        'view_item' => __('View Artist'),
        'search_items' => __('Search Artists'),
        'not_found' =>  __('No Artists found'),
        'not_found_in_trash' => __('No Artists found in Trash'), 
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_position' => 4,
        '_builtin' => false,
        'show_ui' => true, 
        'query_var' => true,
        'capability_type' => 'post',
        'rewrite'=> array('slug'=>'artists'),
        'hierarchical' => false,
        'has_archive' => true,
        'menu_icon' => get_template_directory_uri() .'/includes/icons/image.png',
        'supports' => array('title','editor','thumbnail', /*'author','excerpt'*/)
    ); 
    register_post_type('artist', $args);   
    
    add_filter("manage_edit-artist_columns", "artist_edit_columns");
    add_action("manage_posts_custom_column",  "artist_custom_columns");

    function artist_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Artist Name",      
            "active" => "Is Active?",
        );

        return $columns;
    }

    function artist_custom_columns($column){
        global $post;
        $post_type = get_post_type($post->ID);

        switch ($column) {
          case "active":
              if(meta('artist_active') == 'on'){
                  echo 'Active';                  
              }
          break;          
        }
    }

    //hook into the init action and call create_artist_tax when it fires
    add_action( 'init', 'create_artist_tax', 0 );

    //create two taxonomies, Artist and writers for the post type "book"
    function create_artist_tax() 
    {
      // Add new taxonomy, make it hierarchical (like categories)
      $labels = array(
        'name' => _x( 'Artists', 'taxonomy general name' ),
        'singular_name' => _x( 'Artist', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Artist' ),
        'all_items' => __( 'All Artist' ),
        'parent_item' => __( 'Parent Artist' ),
        'parent_item_colon' => __( 'Parent Artist:' ),
        'edit_item' => __( 'Edit Artist' ), 
        'update_item' => __( 'Update Artist' ),
        'add_new_item' => __( 'Add New Artist' ),
        'new_item_name' => __( 'New Artist Name' ),
        'menu_name' => __( 'Artist' ),
      );    

      register_taxonomy('artist_tax', array('album'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_menu' => false,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'Artist' ),
      ));
    }

    add_action('save_post', 'correlate_artist_taxonomy');
    function correlate_artist_taxonomy( $post_id ){

        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
            return $post_id;

        if ( 'artist' == $_POST['post_type'] ){
            if (!wp_is_post_revision($post_id)){
                if (!term_exists( $_POST["post_title"], 'artist_tax' )){

                    $termid = wp_insert_term( $_POST["post_title"], 'artist_tax' );

                }
            }
        }

    }
             
}

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Album */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'album_init');
function album_init() 
{
    $labels = array(
        'name' => __('Albums'),
        'singular_name' => __('Album'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New Album'),
        'edit_item' => __('Edit Album'),
        'new_item' => __('New Album'),
        'view_item' => __('View Album'),
        'search_items' => __('Search Albums'),
        'not_found' =>  __('No Albums found'),
        'not_found_in_trash' => __('No Albums found in Trash'), 
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_position' => 4,
        '_builtin' => false,
        'show_ui' => true, 
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'menu_icon' => get_template_directory_uri() .'/includes/icons/image.png',
        'supports' => array('title','thumbnail', /*'author','excerpt'*/)
    ); 
    register_post_type('album', $args);   
    
    add_filter("manage_edit-album_columns", "album_edit_columns");
    add_action("manage_posts_custom_column",  "album_custom_columns");

    function album_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Album Name",      
            "featured" => "Is Featured?",
            "thumbnail" => "Album Art"
        );

        return $columns;
    }

    function album_custom_columns($column){
        global $post;
        $post_type = get_post_type($post->ID);

        switch ($column) {
          case "featured":
              if(meta('album_featured') == 'on'){
                  echo 'Featured';                  
              }
          break;       
          case 'banner_image':
              if(has_post_thumbnail()){
                  echo '<img src="' . meta('banner_image') . '" />';                  
              }
          break;
             
        }
    }       

    function album_metaboxes( $meta_boxes ) {

       	 $meta_boxes[] = array(
       		'id' => 'album_price',
       		'title' => 'Album Price',
       		'pages' => array('album'), // post type
       		'context' => 'side',
       		'priority' => 'default',
       		'show_names' => true, // Show field names on the left
       		'fields' => array(
       			array(
       				'name' => 'Domestic Price',
       				'id' => 'domestic_price',
       				'type' => 'text_money'
       			),      
       			array(
       				'name' => 'International Price',
       				'id' => 'intl_price',
       				'type' => 'text_money'
       			),
       			
       		),
       	 );

    	 $meta_boxes[] = array(
    		'id' => 'album_options',
    		'title' => 'Album Release Date',
    		'pages' => array('album'), // post type
    		'context' => 'normal',
    		'priority' => 'default',
    		'show_names' => true, // Show field names on the left
    		'fields' => array(
    			array(
    				'name' => 'Release Date',
    				'id' => 'album_release_date',
    				'type' => 'text_date_timestamp',
    			),
    		),
    	 );

    	return $meta_boxes;
    }

    add_filter( 'cmb_meta_boxes', 'album_metaboxes' );

    add_action('do_meta_boxes', 'album_image_box');

    function album_image_box() {

        if(get_post_type() == 'album'){
        	remove_meta_box( 'postimagediv', 'album', 'side' );

        	add_meta_box('postimagediv', __('Album Cover'), 'post_thumbnail_meta_box', 'album', 'normal', 'high');
        }

    }  
    function album_artist_connection() {
        // Make sure the Posts 2 Posts plugin is active.
        if ( !function_exists( 'p2p_register_connection_type' ) )
            return;

        p2p_register_connection_type( array(
            'name' => 'album_to_artist',
            'from' => 'artist',
            'to' => 'album'
        ) );
    }
    add_action( 'wp_loaded', 'album_artist_connection' );
    
}

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Banner */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'banner_init');
function banner_init() 
{
    $labels = array(
        'name' => __('Top Banners'),
        'singular_name' => __('Banner'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New Banner'),
        'edit_item' => __('Edit Banner'),
        'new_item' => __('New Banner'),
        'view_item' => __('View Banner'),
        'search_items' => __('Search Banners'),
        'not_found' =>  __('No Banners found'),
        'not_found_in_trash' => __('No Banners found in Trash'), 
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_position' => 4,
        '_builtin' => false,
        'show_ui' => true, 
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'menu_icon' => get_template_directory_uri() .'/includes/icons/image.png',
        'supports' => array('title',/*'title','editor', /*'author','excerpt'*/)
    ); 
    register_post_type('banner', $args);

    register_taxonomy(  
        'featured_banner',  
        'banner',  
        array(  
         'hierarchical' => false,  
         'label' => 'Featured Banner',  
         'query_var' => true,
         'public' => false,  
         'rewrite' => array('slug'=>'featured')  
        )  
    ); 

    function banner_metaboxes( $meta_boxes ) {

    	 $meta_boxes[] = array(
    		'id' => 'banner_options',
    		'title' => 'Banner Details',
    		'pages' => array('banner'), // post type
    		'context' => 'normal',
    		'priority' => 'default',
    		'show_names' => true, // Show field names on the left
    		'fields' => array(
    			array(
    				'name' => 'Banner Image',
    				'desc' => 'Upload the Banner Image (728 x 90)',
    				'id' => 'banner_image',
    				'type' => 'file',
    				'save_id' => true, // save ID using true
    			),
    			array(
    				'name' => 'Banner Link',
    				'desc' => 'Enter the URL this banner will link to',
    				'id' => 'banner_link',
    				'type' => 'text',
    				'save_id' => true, // save ID using true
    			),
    			array(
    				'name' => 'Active?',
    				'desc' => 'Check this to make this banner visible to site visitors.',
    				'id' => 'banner_active',
    				'type' => 'taxonomy_multicheck',
    				'taxonomy' => 'featured_banner'
    			),

    		),
    	 );

    	return $meta_boxes;
    }
    add_filter( 'cmb_meta_boxes', 'banner_metaboxes' );

    // setup wordpres admin list view       
    
    add_filter("manage_edit-banner_columns", "banner_edit_columns");
    add_action("manage_posts_custom_column",  "banner_custom_columns");

    function banner_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Slide Name",
            "banner_image" => "Banner Image",      
            "featured_banner" => "Is Active?"
            
        );

        return $columns;
    }

    function banner_custom_columns($column){
        global $post;
        $post_type = get_post_type($post->ID);

        switch ($column) {
          case 'banner_image':
              if(meta('banner_image')){
                  echo '<img src="' . meta('banner_image') . '" />';                  
              }
              break;
          case "featured_banner":
              $terms = get_the_terms($post->ID, 'featured_banner');
              if(is_array($terms)){
                foreach ( $terms as $term )
                    $post_terms[] = "<a href='edit.php?post_type={$post_type}&featured_banner={$term->slug}'> " . esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
                echo join( ', ', $post_terms );                  
              }
              break;          
              
        }
    }             

}

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Slideshow */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'slideshow_init');
function slideshow_init() 
{
    $labels = array(
        'name' => __('Slideshow'),
        'singular_name' => __('Slide'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New Slide'),
        'edit_item' => __('Edit Slide'),
        'new_item' => __('New Slide'),
        'view_item' => __('View Slide'),
        'search_items' => __('Search Slides'),
        'not_found' =>  __('No Slides found'),
        'not_found_in_trash' => __('No Slides found in Trash'), 
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_position' => 4,
        '_builtin' => false,
        'show_ui' => true, 
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'menu_icon' => get_template_directory_uri() .'/includes/icons/image.png',
        'supports' => array('title', /*'author','excerpt'*/)
    ); 
    
    register_post_type('slideshow', $args);
    register_taxonomy(  
        'featured_slideshow',  
        'slideshow',  
        array(  
         'hierarchical' => false,  
         'label' => 'Featured Slide',  
         'query_var' => true,
         'public' => false,  
         'rewrite' => array('slug'=>'featured')  
        )  
    ); 
    function slideshow_metaboxes( $meta_boxes ) {

    	 $meta_boxes[] = array(
    		'id' => 'slideshow_options',
    		'title' => 'Slide Details',
    		'pages' => array('slideshow'), // post type
    		'context' => 'normal',
    		'priority' => 'default',
    		'show_names' => true, // Show field names on the left
    		'fields' => array(
    			array(
    				'name' => 'Slideshow Image',
    				'desc' => 'Upload the Slideshow Image (560 x 240)',
    				'id' => 'slideshow_image',
    				'type' => 'file',
    				'save_id' => true, // save ID using true
    			),
    			array(
    				'name' => 'Slideshow Link',
    				'desc' => 'Enter the URL this slide will link to',
    				'id' => 'slideshow_link',
    				'type' => 'text',
    				'save_id' => true, // save ID using true
    			),
    			array(
    				'name' => 'Active Slide?',
    				'desc' => 'Check this to make this slide visible to site visitors.',
    				'id' => 'slideshow_active',
    				'type' => 'taxonomy_multicheck',
    				'taxonomy' => 'featured_slideshow'
    			),
    		),
    	 );

    	return $meta_boxes;
    }
    add_filter( 'cmb_meta_boxes', 'slideshow_metaboxes' );

    // setup wordpres admin list view       
    
    add_filter("manage_edit-slideshow_columns", "slideshow_edit_columns");
    add_action("manage_posts_custom_column",  "slideshow_custom_columns");

    function slideshow_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Slide Name",
            "slide_image" => "Slide Image",      
            "featured_slideshow" => "Is Active?"            
        );

        return $columns;
    }

    function slideshow_custom_columns($column){
        global $post;
        $post_type = get_post_type($post->ID);

        switch ($column) {
            case 'slide_image':
            if(meta('slideshow_image')){
                echo '<img src="' . meta('slideshow_image') . '" />';                  
            }
            break;
            case "featured_slideshow":
                $terms = get_the_terms($post->ID, 'featured_slideshow');
                if(is_array($terms)){
                  foreach ( $terms as $term )
                      $post_terms[] = "<a href='edit.php?post_type={$post_type}&featured_slideshow={$term->slug}'> " . esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
                  echo join( ', ', $post_terms );                  
                }
            break;          
            
        }
    }             
}

function remove_menus () {
global $menu;
        $restricted = array(__('Links'), __('Comments'), __('Tools'));
        end ($menu);
        while (prev($menu)){
            $value = explode(' ',$menu[key($menu)][0]);
            if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
        }
}
add_action('admin_menu', 'remove_menus');

function the_album_artist($album_id){
    $artist_id = get_the_album_artist($album_id);
    if( !$artist_id ){
        echo 'Various Artists';
    }
    $artist = get_post($artist_id);

    echo $artist->post_title;
}   

    function get_the_album_artist($album_id){
        $connected = p2p_type( 'album_to_artist' )->get_connected( $album_id );

        clog($connected);

        $artist = $connected->posts[0]->ID;  
        clog($artist);
        clog($connected->posts[0]->ID);
        return $artist;
    }   

if (!is_admin()) add_action( 'wp_print_scripts', 'syc_add_javascript' );

function syc_add_javascript( ) {
    wp_enqueue_script( 'cycle', get_bloginfo('template_directory').'/js/jquery.cycle.all.min.js', array( 'jquery', ) );

    wp_enqueue_script( 'site', get_bloginfo('template_directory').'/js/site.js', array( 'jquery', 'cycle') );   

}

    
/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/
?>
