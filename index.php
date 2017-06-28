<?php get_header(); ?>
	
	<section id="index" class="horizontal">
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="swiper-slide">
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<figure class="post-image" style="background-image: url(<?php the_post_thumbnail_url('preview'); ?>);">
							<a class="post-link" href="<?php the_permalink(); ?>"></a>
						</figure>
						<h2 class="post-title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h2>
					</div>
				</div>
				<?php endwhile; endif; ?>
			</div>
			<div class="swiper-pagination"></div>
		</div>
	</section>
	
<?php get_footer(); ?>