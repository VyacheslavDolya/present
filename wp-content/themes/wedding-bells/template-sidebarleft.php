<?php
/*
Template Name: Sidebar Left
*/
?>

<?php get_header(); ?>

	<div class="row" id="content">
	
		<?php get_sidebar(); ?>
		
		<div class="two-thirds column">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
				
				<h2><?php the_title(); ?></h2>
				
				<div class="entry">
					<?php the_content(); ?>
					
					<?php edit_post_link(__('Edit this entry.', 'weddingbells'), '<p>', '</p>', ''); ?>
	
					<?php wp_link_pages(array('before' => __('<p><strong>Pages:</strong> ', 'weddingbells'), 'after' => '</p>', 'next_or_number' => 'number')); ?>
				</div>
			</div><!-- post -->
		<?php endwhile; endif; ?>
		
		<?php comments_template(); ?>
	
		</div><!-- 2/3 -->

	</div><!-- row/content -->

<?php get_footer(); ?>