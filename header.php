<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<header id="header">
			<a class="blog-title" href="<?php echo esc_url( home_url() ); ?>">
				<?php if(has_site_icon()) : ?>
					<img class="blog-logo" src="<?php site_icon_url(); ?>" alt="<?php bloginfo('name'); ?>" />
				<?php endif; ?>
				<span class="blog-name"><?php bloginfo('name'); ?></span>
				<span class="blog-description"><?php bloginfo('description'); ?></span>
			</a>
			<div id="menu" class="navigation">
				<a id="menu-handler" class="nav-button">
				    <span class="nav-button-part nav-button-part-1"></span>
				    <span class="nav-button-part nav-button-part-2"></span>
				    <span class="nav-button-part nav-button-part-3"></span>
					<span class="nav-button-label"><?php _e('Menu','streefkerk'); ?></span>
				</a>
				<?php wp_nav_menu(
					array(
						'theme_location' => 'navigation',
						'container_class' => 'menu-container',
						'fallback_cb' => 'streefkerk_fallback_menu'
					)
				); ?>
			</div>
		</header>