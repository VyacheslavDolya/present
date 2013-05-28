<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

	<div class="row" id="content">
		
		<div class="sixteen columns">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
				
				<h2><?php the_title(); ?></h2>
				
				<div class="entry">
					<?php the_content(); ?>
	
					<?php wp_link_pages(array('before' => __('<p><strong>Pages:</strong> ', 'weddingbells'), 'after' => '</p>', 'next_or_number' => 'number')); ?>
					
					<?php edit_post_link(__('Edit this entry.', 'weddingbells'), '<p>', '</p>', ''); ?>
				</div>
			</div>
		<?php endwhile; endif; ?>
		
		<?php comments_template(); ?>
	
		</div><!-- 16 -->

	</div><!-- row/content -->

<?php get_footer(); ?>