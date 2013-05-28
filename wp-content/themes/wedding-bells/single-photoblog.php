<?php get_header(); ?>

	<div class="row" id="content">
		
		<div class="sixteen columns">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div <?php post_class('post photoblog') ?> id="post-<?php the_ID(); ?>">
				<h2><?php the_title(); ?></h2>
				<small><?php the_time( get_option( 'date_format' ) ); ?></small>
				
				<?php the_post_thumbnail('photoblog-big-size'); ?>
	
				<div class="entry">
					<?php edit_post_link(__('Edit this entry.', 'weddingbells'), '<p>', '</p>'); ?>			
				</div>
			</div>
		
			<?php the_tags( __('<p class="tags">Tags: ', 'weddingbells'), ', ', '</p>'); ?>
		
			<?php comments_template(); ?>

		<?php endwhile; else: ?>
		
			<div class="post">
				<div class="entry">
					<p><?php _e('Sorry, no posts matched your criteria.', 'weddingbells'); ?></p>
				</div>
			</div>

		<?php endif; ?>

		</div><!-- 16 -->

	</div><!-- row/content -->

<?php get_footer(); ?>
