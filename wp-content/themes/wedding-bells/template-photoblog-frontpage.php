<?php
/*
Template Name: Photoblog Frontpage
*/
?>

<?php get_header(); ?>

	<div class="row" id="content">
		
		<div class="sixteen columns">
			
			<?php query_posts('post_type=photoblog&posts_per_page=10'); ?>

			<?php if (have_posts()) : ?>

				<?php while (have_posts()) : the_post(); ?>

					<div <?php post_class('post photoblog') ?> id="post-<?php the_ID(); ?>">
						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							<small><?php the_time( get_option( 'date_format' ) ); ?></small>
							
							<?php the_post_thumbnail('photoblog-big-size'); ?>	
			
							<p class="postmetadata"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> / <?php echo get_the_term_list( $post->ID, 'photoblog-cats', __('Categories: ', 'weddingbells'), ', ', '' ); ?> <?php edit_post_link(__('Edit', 'weddingbells'), ' / ', ''); ?></p>	
					</div>

				<?php endwhile; ?>

			<div class="navigation">
				<div class="alignleft"><?php next_posts_link(__('&larr; Older Entries', 'weddingbells')) ?></div>
				<div class="alignright"><?php previous_posts_link(__('Newer Entries &rarr;', 'weddingbells')) ?></div>
			</div>
				
				<div class="clear"></div>

			<?php else : ?>

			<div class="post">
				<h2><?php _e('Not Found', 'weddingbells'); ?></h2>
				<div class="entry">
					<p><?php _e('Sorry, but you are looking for something that isn&rsquo;t here.', 'weddingbells'); ?></p>
					<?php get_search_form(); ?>
				</div>
			</div>

			<?php endif; ?>
			
		</div><!-- 16 -->

	</div><!-- row/content -->

<?php get_footer(); ?>
