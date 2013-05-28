<?php get_header(); ?>

	<div class="row" id="content">
		
		<div class="two-thirds column">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>

		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class('post'); ?>>
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time( get_option( 'date_format' ) ); ?></small>
				
				<div class="entry">
					<?php the_excerpt(); ?>
				</div>
			</div><!-- post -->

		<?php endwhile; ?>

			<div class="navigation">
				<div class="alignleft"><?php next_posts_link(__('&larr; Older Entries', 'weddingbells')) ?></div>
				<div class="alignright"><?php previous_posts_link(__('Newer Entries &rarr;', 'weddingbells')) ?></div>
			</div>

	<?php else : ?>
			<h2 class="pagetitle"><?php _e('No posts found. Try a different search?', 'weddingbells'); ?></h2>
		
			<div class="post">
				<?php get_search_form(); ?>
			</div>
	<?php endif; ?>

		</div><!-- 2/3 -->

		<?php get_sidebar(); ?>

	</div><!-- row/content -->

<?php get_footer(); ?>