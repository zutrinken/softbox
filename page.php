<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="inside">
				<h1 class="post-title"><?php the_title(); ?></h1>
				<article class="post-content">
					<?php the_content(); ?>
				</article>
			</div>
		</section>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>