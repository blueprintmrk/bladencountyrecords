<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>
    <div id="content" class="col-full">
        <div id="main" class="two-col">
            <div class="content">
    		    <h1 class="title"><?php the_title(); ?></h1>
    		    
                <div id="rotating-banner">
                <ul>

		        <?php $banner = new WP_Query(array('post_type'=>'slideshow', 'posts_per_page'=>4)); ?>
		        <?php while ($banner->have_posts()): $banner->the_post();?>
                <li ><a href="<?php echo meta('slideshow_link') ?>"><img src="<?php echo meta('slideshow_image') ?>" /></a> 
                </li>
                <?php endwhile; wp_reset_query(); ?>
                </ul>
                    <div id="banner-pager"></div>
                </div>
                
                <div id="updates">
                <h2>Bladen County News</h2>
                <a class="index" href="/news">see all news</a>
                <?php
                    query_posts(array('post_type'=>'post', 'posts_per_page'=>5));
                	while ( have_posts() ) : the_post(); 
                ?>

                    <!-- Post Starts -->
                    <div <?php post_class(); ?>>
                	    <h2 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                	    <?php woo_post_meta(); ?>


                	    <?php if ( $woo_options[ 'woo_post_content' ] != 'content' ) { woo_image( 'width='.$woo_options['woo_thumb_w'].'&height='.$woo_options['woo_thumb_h'].'&class=thumbnail '.$woo_options['woo_thumb_align'] ); } ?>

                	    <div class="entry">
                	        <?php the_content( __( 'Continue Reading &rarr;' ) ); ?>
                	    </div>

                	    <div class="post-more">      
                	    	<?php if ( $woo_options[ 'woo_post_content' ] == 'excerpt' ) { ?>
                	    	<span class="read-more"><a href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'Read More', 'woothemes' ); ?>"><?php _e( 'Read More', 'woothemes' ); ?></a></span>
        			    	<span class="comments"><?php comments_popup_link( __( '0 Comments', 'woothemes' ), __( '1 Comment', 'woothemes' ), __( '% Comments', 'woothemes' ) ); ?></span>
                	        <div class="fix"></div>
                	        <?php } ?>
                	    </div>

                	</div><!-- /.post -->
    		    <?php endwhile; ?>
    		    </div>

            </div><!-- /.content -->
        </div><!-- /#main -->
	    <?php get_sidebar(); ?>

    </div><!-- /#content -->
				
<?php get_footer(); ?>