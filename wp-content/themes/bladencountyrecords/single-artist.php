<?php
	get_header();
	global $woo_options, $post;
	
	// Get the metadata for the current post.
	$post_meta = get_post_custom( $post->ID );
	
	$title_before = '<div class="post-title-wrap">' . "\n" . '<h1 class="title">' . '<a href="' . get_permalink( get_the_ID() ) . '" rel="bookmark" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
	$title_after = '</a>' . '</h1>' . "\n" . '</div><!-- /.post-title-wrap -->';
?> 

	<?php if ( $woo_options[ 'woo_breadcrumbs_show' ] == 'true' ) { ?>
			<div id="breadcrumbs">
				<?php woo_breadcrumbs(); ?>
			</div><!--/#breadcrumbs -->
		<?php } ?>
	
    <div id="content">
    	
    	<div id="main" class="two-col">
		
		<?php if ( have_posts() ) { $count = 0; ?>
        <?php while ( have_posts() ) { the_post(); $count++; ?>
        	
        	<div <?php post_class(); ?>>
        	
        		<div class="title-media-block">
        			<?php
						the_title( $title_before, $title_after );
					?>
					<div class="fix"></div>
				</div><!-- /.title-media-block -->
            	
                <div class="entry">

                    <?php if(has_post_thumbnail()):?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail(array('560','480')); ?>
                    </div>
                    <?php endif; ?>
                	<div class="column column-01">
	                	<?php the_content(); ?>
	                	<?php the_tags( '<p class="tags">'.__( 'Tags: ', 'woothemes' ), ', ', '</p>' ); ?>
	                	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
	                	<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>
                	</div><!--/.column-->
                	<div class="fix"></div>
				</div>
                                
            </div><!-- .post -->
            
            <div id="post-entries">
	            <div class="nav-prev fl"><?php previous_post_link( '%link', '%title' ); ?></div>
	            <div class="nav-next fr"><?php next_post_link( '%link', '%title' ); ?></div>
	            <div class="fix"></div>
	        </div><!-- #post-entries -->
                                                
		<?php
				} // End WHILE Loop
			} else {
		?>
			<div <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
			</div><!-- .post -->             
       	<?php } ?>  
        
		</div><!-- #main -->
        
        <div id="sidebar">
        <?php get_sidebar(); ?>
        </div><!-- /#sidebar -->


    </div><!-- #content -->
		
<?php get_footer(); ?>