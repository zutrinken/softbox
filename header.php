<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">

		<title><?php bloginfo('name'); ?> <?php wp_title(' - ', true, 'left'); ?></title>

		<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url');?>/style.css" media="screen" />
		<link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_url'); ?>/images/touchicon.png"/>
		<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/favicon.png">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="description" content="<?php bloginfo('description'); ?>" />

		<link rel='canonical' href='<?php bloginfo('url'); ?>' />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel='index' title='<?php bloginfo('description'); ?>' href='<?php bloginfo('url'); ?>' />

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>
		<header id="header">
			<a class="blog-title" href="<?php bloginfo('url'); ?>">
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