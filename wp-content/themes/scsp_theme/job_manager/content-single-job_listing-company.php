<?php
/**
 * Single view Company information box
 *
 * Hooked into single_job_listing_start priority 30
 *
 * @since  1.14.0
 */
?>

<div class="company" itemscope itemtype="http://data-vocabulary.org/Organization">
	<?php the_company_logo(); ?>

	<p class="name">
		<?php if ( $website = get_the_company_website() ) : ?>
            <?php
                //<a class="website" href="<?php echo esc_url( $website ); ?/>" itemprop="url" target="_blank" rel="nofollow"><?php _e( 'Website', 'wp-job-manager' ); ?/></a>
		    ?>
        <?php endif; ?>
		<?php the_company_twitter(); ?>
		<?php if ( $website = get_the_company_website() ) : ?>
			<a href="<?php echo esc_url( $website ); ?>" itemprop="url" target="_blank" rel="nofollow"><?php the_company_name( '<strong itemprop="name">', '</strong>' ); ?></a>
		<?php else : the_company_name( '<strong itemprop="name">', '</strong>' ); ?>
        <?php endif; ?>
        
	</p>
	<?php the_company_tagline( '<p class="tagline">', '</p>' ); ?>
	<?php the_company_video(); ?>
</div>