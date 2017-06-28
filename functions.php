<?php

load_theme_textdomain('softbox', TEMPLATEPATH .'/languages');

add_action('wp_enqueue_scripts', 'softbox_scripts');
function softbox_scripts() {
	$template = get_template_directory_uri();
	wp_enqueue_script('modernizr', $template.'/js/libs/modernizr-2.6.2.min.js');

	wp_enqueue_script('jquery');
	wp_enqueue_script('fitvids', $template.'/js/libs/jquery.fitvids.js', array(), null, false);
	wp_enqueue_script('swiper', $template.'/js/libs/swiper.min.js', array(), null, false);
	
	if(is_single()) {
		wp_enqueue_script('photoswipe', $template.'/js/libs/photoswipe.min.js', array(), null, false);
		wp_enqueue_script('photoswipe-ui-default', $template.'/js/libs/photoswipe-ui-default.min.js', array(), null, false);
	}

	wp_enqueue_script('script', $template.'/js/script.js', array(), null, true);
}

add_action('wp_enqueue_scripts', 'softbox_fonts');
function softbox_fonts() {
	wp_register_style('softbox-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,300,700,400italic,300italic|Montserrat:400,700');
	wp_enqueue_style('softbox-fonts');
}

add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus(
		array(
			'navigation' => __('Navigation','softbox')
		)
	);
}

function softbox_fallback_menu() {
    wp_page_menu(
    	array(
    		'show_home' => __('Start','softbox'),
    		'menu_class' => 'menu-container'
    	)
    );
}

if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support('post-thumbnails');
	add_image_size('gallery', 9999, 600);
	add_image_size('preview', 400, 600, true);
}

add_shortcode('wp_caption', 'custom_caption');
add_shortcode('caption', 'custom_caption');

/* add custom caption-function */
function custom_caption($attr, $content = null) {
	// New-style shortcode with the caption inside the shortcode with the link and image tags.
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	
	$doc = new DOMDocument();
	@$doc->loadHTML($content);

	$tags = $doc->getElementsByTagName('img');
	foreach ($tags as $tag) {
		$size = $tag->getAttribute('class');
	}
	
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => ''
	), $attr));
	
	if ( 1 > (int) $width || empty($caption) )
		return $content;

	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

	return '<figure '. $id .'class="'. $size .' wp-caption '. $align .'">'. do_shortcode($content) .'<figcaption class="wp-caption-text">'. $caption .'</figcaption></figure>';
}

add_filter( 'wp_get_attachment_link', 'softbox_add_data_size', 10, 6);
function softbox_add_data_size ($content, $id, $size, $permalink, $icon, $text) {
	if ($permalink) {
		return $content;
	}

	$image_attributes = wp_get_attachment_image_src( $id, 'full' );
	$content = preg_replace("/<a/","<a data-size=\"" . $image_attributes[1] . "x" . $image_attributes[2] . "\"", $content, 1);
	return $content;
}

remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'softbox_gallery_shortcode');
function softbox_gallery_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'div',
		'icontag'    => 'figure',
		'captiontag' => 'figcaption',
		'columns'    => 3,
		'size'       => 'gallery',
		'include'    => '',
		'exclude'    => ''
	), $attr, 'gallery'));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$icontag = tag_escape($icontag);
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) )
		$itemtag = 'dl';
	if ( ! isset( $valid_tags[ $captiontag ] ) )
		$captiontag = 'dd';
	if ( ! isset( $valid_tags[ $icontag ] ) )
		$icontag = 'dt';

	$columns = intval($columns);
	//$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$itemwidth = 100 / $columns;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "";
	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery horizontal galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'><div class='swiper-container'><div class='swiper-wrapper'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, false, false);
		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) )
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		
		$itemratio = $image_meta['height'] / ( $image_meta['width'] / 100 );
		
		$xxx = $image_meta['width'] / ( $image_meta['height'] / 50 );

		$output .= "<div class='swiper-slide' style='width: {$xxx}vh;'><{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}></div>";
		/* if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />'; */
	}

	$output .= '</div><div class="swiper-pagination"></div></div></div>';
	return $output;
}
?>