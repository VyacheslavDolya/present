<?php get_header(); ?>

	<div class="row" id="content">
		
		<div class="two-thirds column">

		<?php if (have_posts()) : ?>

			<h2 class="pagetitle">
		<?php if ( is_day() ) : ?>
			<?php printf( __( 'Daily Archives: %s', 'weddingbells' ), '<span>' . get_the_date() . '</span>' ); ?>
		<?php elseif ( is_month() ) : ?>
			<?php printf( __( 'Monthly Archives: %s', 'weddingbells' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'weddingbells' ) ) . '</span>' ); ?>
		<?php elseif ( is_year() ) : ?>
			<?php printf( __( 'Yearly Archives: %s', 'weddingbells' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'weddingbells' ) ) . '</span>' ); ?>
		<?php else : ?>
			<?php _e( 'Archives', 'weddingbells' ); ?>
		<?php endif; ?>
			</h2>

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

			<h2 class="pagetitle"><?php _e('Not Found', 'weddingbells'); ?></h2>
			
			<?php get_search_form(); ?>

		<?php endif; ?>
	
		</div><!-- 2/3 -->

		<?php get_sidebar(); ?>

	</div><!-- row/content -->

<?php get_footer(); ?>
