	<div class="row" id="widgetcontainer">
		<div class="one-third column">
			<ul class="widgetblock">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer - Left column") ) : ?>
			<?php endif; ?>
			</ul>
		</div><!-- 1/3 -->
		
		<div class="one-third column">
			<ul class="widgetblock">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer - Center column") ) : ?>
			<?php endif; ?>
			</ul>
		</div><!-- 1/3 -->

		<div class="one-third column">
			<ul class="widgetblock">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer - Right column") ) : ?>
			<?php endif; ?>
			</ul>
		</div><!-- 1/3 -->
	</div><!-- row -->
	
	<div class="row">
		
		<div class="sixteen columns" id="footer">
			<p class="alignleft">&copy; Copyright <?php bloginfo('name'); ?> | <a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a> | <a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a> | <a href="#header"><?php _e('Back to top &uarr;', 'weddingbells'); ?></a></p>
			<p class="alignright">Powered by <a href="mailto:vyacheslav.dolya@gmail.com">Vyacheslav Dolya</a></p>
		</div><!-- 16 -->
			
	</div><!-- row -->

</div><!-- container -->
</div><!-- wrapper -->
<?php wp_footer(); ?>
</body>
</html>
