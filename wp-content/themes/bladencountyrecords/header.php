<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>
<?php global $woo_options; ?>

<!-- twitter bootstrap -->
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/less.js" type="text/javascript"></script>

<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( $woo_options['woo_feed_url'] ) { echo $woo_options['woo_feed_url']; } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<meta name="viewport" content="width=320, initial-scale=1, maximum-scale=1.8">
      
<?php wp_head(); ?>
<?php woo_head(); ?>
<!--[if IE]>
<link href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 7]>
<link href="<?php bloginfo('stylesheet_directory'); ?>/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if gte IE 8]>
<link href="<?php bloginfo('stylesheet_directory'); ?>/ie8.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?php     
    $queried_post_type = get_query_var('post_type');
    if ( is_single() ):
        $post_id = get_queried_object_id();
        
    // facebook og data
?>
    <meta property="og:title" content="<?php woo_title(); ?>" />
    <meta property="og:url" content="<?php echo get_permalink($post_id); ?>" />
    <meta property="og:image" content="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post_id) ); ?>" />
    <meta property="og:site_name" content="<?php woo_title(); ?>" />

<?php else: ?>
    <meta property="og:title" content="<?php woo_title(); ?>" />
    <meta property="og:url" content="<?php echo bloginfo('url'); ?>" />
    <meta property="og:site_name" content="<?php woo_title(); ?>" />    
<?php endif; ?>
</head>
<body <?php body_class(); ?>>
<?php woo_top(); ?>
<div id="wrapper" class="container">
	<div id="header-wrap"> 
	    <div id="header">   				
				<div id="sub-head" class="clearfix"> 
				<div id="logo" >			
			        <h1 class="site-title"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>"><img alt="<?php bloginfo('description'); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" /></a></h1> 
		        	<span class="site-description"><?php bloginfo('description'); ?></span>
			    </div><!-- /#logo -->
			    <div id="banner">   
			        <?php $banner = new WP_Query(array('post_type'=>'banner', 'posts_per_page'=>1)); ?>
			        <?php while ($banner->have_posts()): $banner->the_post();?>
                    
                    <a href="<?php echo meta('banner_link') ?>"><img src="<?php echo meta('banner_image') ?>" /></a> 
                    <?php endwhile; wp_reset_query();?>
                </div>
                <div id="social">
                
                <ul>

                    <li class="first facebook"><a href="http://www.facebook.com/pages/Portland-OR/Bladen-County-Records/205130340483">Facebook</a></li>

                    <li class="youtube"><a href="http://www.youtube.com/user/BladenCountyRecords">YouTube</a></li>

                    <li class="myspace"><a href="http://www.myspace.com/bladencountyrecords">Myspace</a></li>

                    <li class="twitter"><a href="http://twitter.com/bladencounty">Twitter</a></li>

                    <li class="last "><a href="http://www.bladencountyrecords.com/ontour/">ON TOUR</a></li>

                </ul>
                </div>
				<div id="nav">
                <?php wp_nav_menu(array('theme_location' => 'primary_navigation')); ?>
			    </div><!-- /.nav -->
  	    	</div><!-- /#sub-head -->  	    	
            </div>
        </div><!-- /#header-wrap -->
<div id="torso">
