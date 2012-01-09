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
        }
    }       

    function album_metaboxes( $meta_boxes ) {

    	 $meta_boxes[] = array(
    		'id' => 'album_options',
    		'title' => 'Album Details',
    		'pages' => array('banner'), // post type
    		'context' => 'normal',
    		'priority' => 'default',
    		'show_names' => true, // Show field names on the left
    		'fields' => array(
    			array(
    				'name' => 'Release Date',
    				'id' => 'album_release_date',
    				'type' => 'text_date_timestamp',
    			),
    			array(
    				'name' => 'Active?',
    				'desc' => 'Check this to make this banner visible to site visitors.',
    				'id' => 'banner_active',
    				'type' => 'checkbox'
    			),
    		),
    	 );

    	return $meta_boxes;
    }

    add_filter( 'cmb_meta_boxes', 'banner_metaboxes' );

    add_action('do_meta_boxes', 'album_image_box');

    function album_image_box() {

        if(get_post_type() == 'album'){
        	remove_meta_box( 'postimagediv', 'album', 'side' );

        	add_meta_box('postimagediv', __('Album Cover'), 'post_thumbnail_meta_box', 'album', 'normal', 'high');
        }

    }      
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
    				'type' => 'checkbox'
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
            "active" => "Is Active?",      
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
          case "active":
              if(meta('banner_active') == 'on'){
                  echo 'Active';                  
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
    				'name' => 'Active?',
    				'desc' => 'Check this to make this slide visible to site visitors.',
    				'id' => 'slideshow_active',
    				'type' => 'checkbox'
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
            "active" => "Is Active?",
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
            case 'active':
            if(meta('slideshow_active') == 'on'){
                echo 'Active';                  
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
    echo get_the_album_artist($album_id);
    
}   

    function get_the_album_artist($album_id){
        $album = get_post($album_id);
        return "not implemented";
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
