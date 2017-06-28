<?php get_header(); ?>

	<section <?php post_class(); ?>>
		<header class="post-header">
			<div class="inside">
				<h1 class="post-title"><?php _e('404, page not found.','softbox') ?></h1>
			</div>
		</header>			
		<article class="post-content">
			<div class="inside">
				<?php _e('That is not the content you are looking for.','softbox') ?>
				<div class="clear"></div>
			</div>
		</article>
	</section>
	
<?php get_footer(); ?>