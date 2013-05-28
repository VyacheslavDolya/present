<?php get_header(); ?>

	<div class="row" id="content">

		<div class="two-thirds column">
		
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div <?php post_class('post') ?> id="post-<?php the_ID(); ?>">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<small><?php the_time( get_option( 'date_format' ) ); ?> by <?php the_author(); ?></small>
					
					<div class="entry">
						<?php the_content(__('Read the rest of this entry &raquo;', 'weddingbells')); ?>
					</div>		
		
					<p class="postmetadata"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> / <?php the_tags(__('Tags: ', 'weddingbells'), ', ', ' / '); ?> <?php _e('Posted in','weddingbells'); ?> <?php the_category(', ') ?> <?php edit_post_link(__('Edit', 'weddingbells'), ' / ', ''); ?></p>	
				</div><!-- post -->
					
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

		</div><!-- 2/3 -->

		<?php get_sidebar(); ?>

	</div><!-- row -->

<?php get_footer(); ?>
