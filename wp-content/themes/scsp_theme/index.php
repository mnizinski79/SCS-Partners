<?php 
/*
 * Template Name: NPP Home Page Template
 * Description: This should only be used for the home page!
 */

get_header(); 

?>
<article>
               
                <?php
                $post_id = get_the_ID();
                $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );

                $thumbnail_id    = get_post_thumbnail_id($post_id);
                $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

                

                ?>
                <div id="home-intro" class="parallax" style="background-image:url(<?php echo $feat_image; ?>);">
                    <div class="abs-content">
                        <h1><?php echo $thumbnail_image[0]->post_title; ?></h1>
                        <?php cc_featured_image_caption(); ?>                       
                    </div>
                </div>

                <!---DYNAMIC CONTENT BLOCKS---->
                <?php include('custom_content_blocks.php'); ?> 
                <!---END DYNAMIC CONTENT BLOCKS---->
                
               
                
                
                <div id="content-feeds">
                    <div class="col-container">
                        <div class="container-feed-positions col-7">
                            <h3>Recent Updates</h3>
                            <ul>
                                <?php $recent_posts = wp_get_recent_posts(array(
                                                        'numberposts' => 2,                                                        
                                                        'orderby' => 'post_date',
                                                        'order' => 'DESC',                                                        
                                                        'post_type' => array('job_listing','post'),
                                                        'post_status' => 'publish'));
                                    foreach( $recent_posts as $recent ){  
                                        //if ($recent["post_title"]==''){continue;}
                                        
                                        //if (get_the_company_name($recent["ID"])==''){continue;} //AMY HELP!!
                                        
                                        $position_city = get_post_meta($recent["ID"], '_job_location', true );
                                        $position_zipcode = get_post_meta($recent["ID"], 'position_zipcode', true );
                                        echo '<li>';
                                        echo '<a href="'.get_permalink($recent["ID"]).'">';
                                        
                                        echo '<h3>'.$recent["post_title"].'</h3>';
                                        echo '<p>'.substr($recent["post_content"], 0,150).'...</p>'; //changed from 50 characters
                                        //echo '<p>'.substr( $recent["post_content"], 0, strpos( $recent["post_content"], '</p>' ) + 4 ).'</p>'; //changed from 50 characters
                                        //echo the_content("",true);
                                        
                                        if ($position_city){
                                            echo '<h4 class="position-location">'.$position_city;
                                        }
                                        if ($position_zipcode){
                                            if ($position_city){
                                                echo ': <strong>'.$position_zipcode.'</strong></h4>';
                                            }else {
                                                '<h4><strong>'.$position_zipcode.'</strong></h4>';
                                            }
                                        }else if ($position_city){
                                            echo '</h4>';
                                        }
                                        $counter=0;
                                        $tags = wp_get_post_tags($recent["ID"]);
                                       
                                        foreach ( $tags as $tag){
                                           if ($counter>0){echo " , ";}
                                            echo '<h4 class="position-location">'.$tag->name.'</h4>';
                                            $counter++;
                                        }
                                        
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                ?>                               
                            </ul>
                        </div>
                        
                
                        <div class="container-feed-events col-5">
                            <ul>
                                 <?php $recent_posts = wp_get_recent_posts(array(
                                                        'numberposts' => 1,                                                        
                                                        'orderby' => 'post_date',
                                                        'order' => 'DESC',                                                        
                                                        'post_type' => 'event',
                                                        'post_status' => 'publish'));
                                    foreach( $recent_posts as $recent ){  
                                        echo '<li>';
                                        echo '<a href="'.get_permalink($recent["ID"]).'">';
                                        $image = wp_get_attachment_url(get_post_thumbnail_id($recent["ID"]));
                                        if ($image!='' && $image){
                                            echo '<img src="'.$image.'">';
                                        }else {
                                            echo '<img src="'.get_template_directory_uri().'/img/img-news-1.jpg">';
                                        }
                                        echo '<h3>'.$recent['post_title'].'</h3>';
                                        $event_date = get_post_meta($recent["ID"], 'event_date', true );
                                        echo '<p>'.$recent['post_excerpt'].'</p>';
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                ?>
                                
                            </ul>
                        </div>
                        
                        
                    </div>                    
                </div>
            </article>
<?php get_footer(); ?>