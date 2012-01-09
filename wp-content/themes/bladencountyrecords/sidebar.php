    <div id="featured-release" class="mini widget">
        <h2>
            Featured Release
        </h2>    
        <?php 
        $albums = new WP_Query(array('post_type'=>'album', 'meta_key'=>'featured', 'meta_value'=>true, 'posts_per_page'=>1 ));
        $count = 0;
        while($albums->have_posts()): $albums->the_post(); $count++;
        ?>
        <div class="album-art">
            <a href="<?php the_permalink(get_the_album_artist(get_the_ID())); ?>#artist-releases"><?php the_post_thumbnail(array(84,84)); ?></a>
        </div>
        <div class="album-details">
            <a href="<?php the_permalink(get_the_album_artist(get_the_ID())); ?>#artist-releases" class="album-title"><strong>"<?php the_title(get_the_album_artist(get_the_ID())); ?></strong><br>
            <em><?php the_title(); ?></em></a><br>
        </div>
        <div class="store-links">
            <?php get_template_part('paypal-button'); ?>
        </div>
        <?php endwhile; ?>
        
    </div>
    <div id="sidebar-mailing-list" class="mini widget">
        <h2>
            Join Our Mailing List
        </h2>
        <p>
            Get free music, updates on tours and news by joining our mailing list!
        </p>
        <form action="http://bladencountyrecords.us1.list-manage.com/subscribe/post?u=795e3e15cd1294d236690e10e&amp;id=0e6b33ef74" method="post">
            <input type="hidden" name="u" value="795e3e15cd1294d236690e10e"> <input type="hidden" name="id" value="0e6b33ef74"> <label for="MERGE1">Name:</label><br>
            <input type="text" name="MERGE1" id="MERGE1" size="20"><br>
            <label for="MERGE0">Email Address:</label><br>
            <input type="text" name="MERGE0" id="MERGE0" size="25" value=""><br>
            <input class="button" type="submit" value="Subscribe">
        </form>
    </div>
    <div id="sidebar-artists" class="mini widget">
        <h2>
            Bladen County Artists
        </h2>
        <ul>
            <?php 
            $artists = new WP_Query(array('post_type'=>'artist', 'meta_key'=>'active', 'meta_value'=>'on' ));
            $count = 0;
            while($artists->have_posts()): $artists->the_post(); $count++;
            ?>
            <li class="row<?php echo $count % 2 + 1 ?>">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <div id="sidebar-link-list" class="mini widget">
        <h2>
            Bladen County Friends
        </h2>
        <ul>
            <li class="first">
                <a href="http://www.230publicity.com/">230 Publicity</a>
            </li>
            <li class="">
                <a href="http://www.tenderlovingempire.com/">The Tender Loving Empire</a>
            </li>
            <li class="">
                <a href="http://www.shotclockmanagement.com/">ShotClock Management</a>
            </li>
            <li class="">
                <a href="http://www.hushrecords.com/">Hush Records</a>
            </li>
            <li class="">
                <a href="http://www.giganticmusic.com/">Gigantic Music</a>
            </li>
            <li class="">
                <a href="http://www.melanibrown.com/">Melani Brown Photography</a>
            </li>
            <li class="">
                <a href="http://www.stereotyperecords.com/">Stereotype Records</a>
            </li>
            <li class="">
                <a href="http://www.geocities.com/sunsetstrip/palladium/1131/polvotab.html">Fuck Yeah!</a>
            </li>
            <li class="">
                <a href="http://bcrbasementblog.tumblr.com/">The BCR Basement Blog</a>
            </li>
            <li class="last">
                <a href="http://caseyburns.com">Casey Burns Illustration and Design</a>
            </li>
        </ul>
    </div>
