<?php
// custom constant (opposite of STYLESHEETPATH)
define('_TEMPLATEURL', get_bloginfo('stylesheet_directory') );

function syc_sample_metaboxes( $meta_boxes ) {
    
	/* $meta_boxes[] = array(
		'id' => 'test_metabox',
		'title' => 'Test Metabox',
		'pages' => array('page'), // post type
		'context' => 'side',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Test Text',
				'desc' => 'field description (optional)',
				'id' => 'test_text',
				'type' => 'text'
			),
		),
	); */

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'syc_sample_metaboxes' );

// Initialize the metabox class
add_action( 'init', 'syc_initialize_cmb_meta_boxes', 9999 );
function syc_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( locate_template('inc/metaboxes/init.php' ) );
	}
}

/**
 * error logs a variable in a parseable format while maintaining whitespace
 * in html
 * @param $var
 */
function clog($var){
       error_log(var_export($var, TRUE));      
}

// thumbnails
add_theme_support( 'post-thumbnails' );

// Admin CSS layer
if ( !function_exists('base_admin_css') ) {
    function base_admin_css()
    {
        wp_enqueue_style('base-admin-css', _TEMPLATEURL .'/admin.css', false, '1.0', 'all');
    }
    add_action('admin_print_styles', 'base_admin_css');
}

// Body class for admin
if ( !function_exists('base_admin_body_class') ) {
function base_admin_body_class( $classes )
{
    // Current action
    if ( is_admin() && isset($_GET['action']) ) {
        $classes .= 'action-'.$_GET['action'];
    }
    // Current post ID
    if ( is_admin() && isset($_GET['post']) ) {
        $classes .= ' ';
        $classes .= 'post-'.$_GET['post'];
    }
    // New post type & listing page
    if ( isset($_GET['post_type']) ) $post_type = $_GET['post_type'];
    if ( isset($post_type) ) {
        $classes .= ' ';
        $classes .= 'post-type-'.$post_type;
    }
    // Editting a post type
    $post_query = $_GET['post'];
    if ( isset($post_query) ) {
        $current_post_edit = get_post($post_query);
        $current_post_type = $current_post_edit->post_type;
        if ( !empty($current_post_type) ) {
            $classes .= ' ';
            $classes .= 'post-type-'.$current_post_type;
        }
    }
    // Return the $classes array
    return $classes;
}

add_filter('admin_body_class', 'base_admin_body_class');
}

/** adds tinymce editors to any fields with '.use-tinymce' class in admin **/
//important: note the priority of 99, the js needs to be placed after tinymce loads
add_action('admin_print_footer_scripts','my_admin_print_footer_scripts',99);
function my_admin_print_footer_scripts()
{
    ?><script type="text/javascript">/* <![CDATA[ */
        jQuery(function($)
        {
            var i=1;
            $('.use-tinymce textarea').each(function(e)
            {
                var id = $(this).attr('id');

                if (!id)
                {
                    id = 'customEditor-' + i++;
                    $(this).attr('id',id);
                }

                tinyMCE.execCommand('mceAddControl', false, id);

            });
        });
        
        var activeTinyEditor = '';
        
        jQuery( document ).ready( function(){
        	jQuery( '.custom_upload_buttons a' ).live( 'click', function(e){
        		var id = jQuery( e.target )
        				.closest( 'td' )
        				.find( '.use-tinymce textarea' )
        				.attr( 'id' );

        		activeTinyEditor = id;
        	});

        	if ( parent != self )
        	{
        		if ( typeof parent.tinyMCE != 'undefined' && parent.tinyMCE.activeEditor ) {
        			parent.tinyMCE.get( parent.activeTinyEditor ).focus();
        			parent.tinyMCE.activeEditor.windowManager.bookmark = parent.tinyMCE.activeEditor.selection.getBookmark('simple');
        		}
        	}
        });        
    /* ]]> */</script><?php
}

add_filter('mce_buttons','prc_mce_buttons');
function prc_mce_buttons($mce_buttons) {
    $mce_buttons[] = 'code';

    return $mce_buttons;
}

function meta($the_field, $single=true){
  global $post;
  $the_meta = get_post_meta($post->ID, $the_field, $single);
  return $the_meta;
}

/** add first & last classes to menu items **/
function syc_add_first_and_last($output) {
  $output = preg_replace('/class="menu-item/', 'class="first menu-item', $output, 1);
  $output = substr_replace($output, 'class="last menu-item', strripos($output, 'class="menu-item'),
      strlen('class="menu-item'));
  return $output;
}
add_filter('wp_nav_menu', 'syc_add_first_and_last');

function syc_add_markup_categories($output) {
    $output= preg_replace('/cat-item/', ' first cat-item', $output, 1);
	$output=substr_replace($output, " last cat-item", strripos($output, "cat-item"), strlen("cat-item"));
    return $output;
}
add_filter('wp_list_categories', 'syc_add_markup_categories');

function devinsays_translation_mangler($translation, $text, $domain) {
        global $post;
    if ($post->post_type == 'retreat' || $post->post_type == 'workshop' ) {
 
        $translations = &get_translations_for_domain( $domain);
        if ( $text == 'Scheduled for: <b>%1$s</b>') {
            return $translations->translate( 'Retreat Date: <b>%1$s</b>' );
        }
        if ( $text == 'Published on: <b>%1$s</b>') {
            return $translations->translate( 'Retreat Date: <b>%1$s</b>' );
        }
        if ( $text == 'Publish <b>immediately</b>') {
            return $translations->translate( 'Retreat Date: <b>%1$s</b>' );
        }
    }
 
    return $translation;
}

// Show Scheduled Posts
 
function devinsays_show_scheduled_posts($posts) {
   global $wp_query, $wpdb;
   if(is_single() && $wp_query->post_count == 0) {
      $posts = $wpdb->get_results($wp_query->request);
   }
   return $posts;
}
 
add_filter('the_posts', 'devinsays_show_scheduled_posts');

add_filter('gettext', 'devinsays_translation_mangler', 10, 4);


add_action('save_post', 'metabox_save');

// parses woo_metaboxes and adds <p> tags via wpautop to tinymce fields
function metabox_save($post_id) {
    global $woo_metaboxes;

    $woo_metaboxes = woo_metaboxes_add(get_option('woo_custom_template'));  

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    foreach ($woo_metaboxes as $metabox) {
        $key = $metabox['name'];
      
        $old = get_post_meta($post_id, $key, true);
        $new = $_POST[$key];
        
        if( in_array($metabox['type'], array('tinymce', 'textarea'))){
          $new = wpautop($new);
        }
                
        if ($new && $new != $old) {
            update_post_meta($post_id, $key, $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $key, $old);
        }
    }
}

// Add all custom post types to the "Right Now" box on the Dashboard
add_action( 'right_now_content_table_end' , 'syc_right_now_content_table_end' );

function syc_right_now_content_table_end() {
  $args = array(
    'show_ui' => true,
    '_builtin' => false
  );
  $output = 'object';
  $operator = 'and';

  $post_types = get_post_types( $args , $output , $operator );

  
  foreach( $post_types as $post_type ) {
    $num_posts = wp_count_posts( $post_type->name );
    $num = number_format_i18n( $num_posts->publish );
    $text = _n( $post_type->labels->singular_name, $post_type->labels->name , intval( $num_posts->publish ) );
    if ( current_user_can( 'edit_posts' ) ) {
      $num = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
      $text = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
    }
    echo '<tr><td class="first b b-' . $post_type->name . '">' . $num . '</td>';
    echo '<td class="t ' . $post_type->name . '">' . $text . '</td></tr>';
  }

}

// add slugs to body classes
add_filter( 'body_class', 'syc_add_body_class_slug' );
function syc_add_body_class_slug( $classes )
{
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}

function syc_get_video_info($url){
    error_log('getting video info:' . $url);

    if(preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches) != 0){
        $video_id = $matches[0];
        
        error_log(print_r($matches, true));
        error_log("got yotube video id: $video_id");
    	// YouTube - get the corresponding thumbnail images
		if($video_id != ''){
			$video_thumb = "http://img.youtube.com/vi/".$video_id."/0.jpg";
			$video_embed = '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$video_id.'" frameborder="0" allowfullscreen></iframe>';
			$result = array('video_thumb'=>$video_thumb, 'video_embed'=>$video_embed);
			return $result;
        }
    }elseif(preg_match('#vimeo\.com\/(\d+)#', $url, $matches) != 0){
        $video_id = $matches[1];
        error_log("got vimeo id: $video_id");

		if($video_id != ''){
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));

            error_log($hash[0]['thumbnail_medium']);
            
			$video_thumb = $hash[0]['thumbnail_medium'];
			$video_embed = '<iframe src="http://player.vimeo.com/video/'. $video_id.'?title=0&amp;byline=0&amp;portrait=0&amp;color=fc575e" width="560" height="315" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';
			$result = array('video_thumb'=>$video_thumb, 'video_embed'=>$video_embed);
			return $result;
        }
        
    }
    error_log("got no id: $url");
    
	return false;
}

function syc_copy_post_image($url, $post_id){
    $time = current_time('mysql');
    if ( $post = get_post($post_id) ) {
        if ( substr( $post->post_date, 0, 4 ) > 0 )
            $time = $post->post_date;
    }

    //making sure there is a valid upload folder
    if ( ! ( ( $uploads = wp_upload_dir($time) ) && false === $uploads['error'] ) )
        return false;

    error_log('finding basename in syc post copy:' . $url);
    $name = basename($url);

    $filename = wp_unique_filename($uploads['path'], $name);

    // Move the file to the uploads dir
    $new_file = $uploads['path'] . "/$filename";

    $uploaddir = wp_upload_dir();
    $path = str_replace($uploaddir["baseurl"], $uploaddir["basedir"], $url);

    error_log('copying to: ' . $path);
    if(!copy($path, $new_file))
        return false;

    // Set correct file permissions
    $stat = stat( dirname( $new_file ));
    $perms = $stat['mode'] & 0000666;
    @ chmod( $new_file, $perms );

    // Compute the URL
    $url = $uploads['url'] . "/$filename";

    if ( is_multisite() )
        delete_transient( 'dirsize_cache' );

    $type = wp_check_filetype($new_file);
    return array("file" => $new_file, "url" => $url, "type" => $type["type"]);

}

add_action('admin_init', 'syc_remove_dashboard_widgets');
function syc_remove_dashboard_widgets() {
    // remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // right now
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // recent comments
    // remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // incoming links
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // plugins

    remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');  // quick press
    // remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');  // recent drafts
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');   // wordpress blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');   // other wordpress news
}

function add_or_update_post_meta($post_id, $key, $value)
{
    add_post_meta($post_id, $key, $value, true) or update_post_meta($post_id, $key, $value); 
}

/**
 * Set the latest attachment as the featured image of the given post
 **/
function syc_reset_featured_image($post_id){
    // get the last image added to the post
    $attachments = get_posts(array('numberposts' => '1', 'post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC'));

    
    if(sizeof($attachments) > 0){
        // set image as the post thumbnail
        set_post_thumbnail($post_id, $attachments[0]->ID);
    }    
    
}

function modify_footer_admin () {
  echo 'Created by <a href="http://switchyardcreative.com">Switchyard Creative</a>. &nbsp;';
  echo 'Powered by <a href="http://WordPress.org">WordPress</a>.';
}

add_filter('admin_footer_text', 'modify_footer_admin');
