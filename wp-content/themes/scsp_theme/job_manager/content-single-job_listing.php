
    <div class="col-container">
        <div class="main-content col-8 class=default-container single_job_listing" itemscope itemtype="http://schema.org/JobPosting">
        	<meta itemprop="title" content="<?php echo esc_attr( $post->post_title ); ?>" />
        	<?php if ( $post->post_status == 'expired' ) : ?>

			<div class="job-manager-info"><?php _e( 'This listing has expired', 'wp-job-manager' ); ?></div>

			<?php else : ?>

				<?php 
					/**
					 * single_job_listing_start hook
					 *
					 * @hooked job_listing_meta_display - 20
					 * @hooked job_listing_company_display - 30
					 */
					do_action( 'single_job_listing_start' ); 
				?>

				<div class="job_description" itemprop="description">
					<?php echo apply_filters( 'the_job_description', get_the_content() ); ?>
				</div>

				<?php if ( ! is_position_filled() && $post->post_status !== 'preview' ) : ?>
					<?php get_job_manager_template( 'job-application.php' ); ?>
				<?php endif; ?>

				<?php 
					/**
					 * single_job_listing_end hook
					 */
					do_action( 'single_job_listing_end' ); 
				?>

			<?php endif; ?>
        </div>
        <aside class="sidebar col-3">
            <?php dynamic_sidebar('Jobs Sidebar'); ?>
        </aside>
    </div>