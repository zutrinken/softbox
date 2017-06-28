<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="inside">
					<p><?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>
						<a href="<?php echo $att_image[0];?>"><img src="<?php echo $att_image[0];?>" width="<?php echo $att_image[1];?>" height="<?php echo $att_image[2];?>" alt="<?php $post->post_excerpt; ?>" /></a>
					<?php else : ?>
						<a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid); ?></a>
					<?php endif; ?>
					</p>
					<p><a href="<?php echo get_permalink($post->post_parent); ?>"><?php _e('Project','softbox'); ?></a></p>
				</div>
			</section>

		<?php endwhile; endif; ?>

<?php get_footer(); ?>