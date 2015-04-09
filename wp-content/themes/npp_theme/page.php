<?php

 get_header('single'); ?>   

            
            <article>
                <?php if (have_posts()) : while (have_posts()) : the_post();?>
                <div class="default-container">
                    <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

                    if ($feat_image){
                    ?>
                    <div class="detail-img">
                        <img src="<?php echo $feat_image; ?>" />
                    </div>
                    <?php
                    }
                    ?>
                    
                    <?php the_title('<h2 class="hdr-detail">','</h2>'); ?>
                
                    <ul class="tag-list">
                        <li><a href="#">Package</a></li>
                        <li><a href="#">Network</a></li>
                        <li><a href="#">Work Place</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                    
                    <?php the_content(); ?>
                    <?php endwhile; endif; ?>
                </div>
                
            </article>
<?php get_footer(); ?>