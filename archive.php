<?php get_header(); ?>

	<header class="page-header">
		<div class="inside">
			<h1 class="page-title">
				<?php if (is_category()) : ?>
					<span class="page-main-title"><?php _e('Archive','softbox'); ?></span>
					<span class="page-sub-title"><?php single_cat_title(); ?></span>
				<?php elseif (is_tag()) : ?>
					<span class="page-main-title"><?php _e('Archive','softbox'); ?></span>
					<span class="page-sub-title"><?php single_tag_title(); ?></span>
				<?php else : ?>
					<span class="page-main-title"><?php _e('Archive','softbox'); ?></span>
				<?php endif; ?>
			</h1>
		</div>
	</header>
	
	<section id="main" class="section">
		<div class="inside">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php $url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'preview')[0]; ?>
				<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="post-header">
						<a class="post-link" href="<?php the_permalink(); ?>"></a>
						<h2 class="post-title">
							<span class="post-main-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></span>
							<?php the_tags('<span class="post-sub-title">',', ','</span>'); ?>
						</h2>
						<?php if(has_post_thumbnail()) : ?>
							<figure class="post-background" style="background-image: url('<?php echo $url; ?>');"></figure>
						<?php endif; ?>
					</header>
				</section>
		<?php endwhile; endif; ?>
		</div>
	</section>
	
<?php get_footer(); ?>