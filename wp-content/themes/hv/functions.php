<?php

if(function_exists( 'register_nav_menu' )) register_nav_menu( 'primary', 'Huvudmeny' );
if(function_exists( 'register_nav_menu' )) register_nav_menu( 'Secondary', 'Undermeny' );
if(function_exists( 'add_image_size' )) add_image_size( 'hv_slideshow', 630, 473, true );

if(function_exists( 'add_theme_support' )) {
	function theme_supports() {
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
		add_theme_support( 'post-thumbnails' );
	}
	
	add_action('after_setup_theme', 'theme_supports');
}
if(function_exists( 'register_sidebars' )) {
	add_action('widgets_init', function() {
		register_sidebar(array(
			'name' => 'Sidkolumn - enskilt inlägg',
			'id' => 'single',
			'before_widget' => '<div class="widget grid-100">',
			'after_widget' => '</div>',
			'before_title' => '<header class="title"><h1>',
			'after_title' => '</h1></header>'
		));
		
		register_sidebar(array(
			'name' => 'Sidkolumn - kategorisida',
			'id' => 'archive',
			'before_widget' => '<div class="widget grid-100">',
			'after_widget' => '</div>',
			'before_title' => '<header class="title"><h1>',
			'after_title' => '</h1></header>'
		));
		
		register_sidebar(array(
			'name' => 'Sidkolumn - evenemangsida',
			'id' => 'event',
			'before_widget' => '<div class="widget grid-100">',
			'after_widget' => '</div>',
			'before_title' => '<header class="title"><h1>',
			'after_title' => '</h1></header>'
		));
	});
}
if(function_exists( 'register_widget' )) {
	require_once('include/latest-posts-widget-class.php');
	require_once('include/related-posts-widget-class.php');
	require_once('include/share-post-widget-class.php');
	require_once('include/popular-posts-widget-class.php');
	
	add_action('widgets_init', function() {
		register_widget('Latest_Posts_Widget');
		register_widget('Related_Posts_Widget');
		register_widget('Share_Post_Widget');
		register_widget('Popular_Posts_Widget');
	});
}

function add_niceScroll() {
	wp_enqueue_script('nice-scroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js');
}
add_action('wp_footer', 'add_niceScroll');

function fromNow($timestamp){
	require_once('include/fromnow.php');
	return fromNow_action($timestamp);
}

function hv_asides() {
	require_once('include/hv-asides.php');
}

function wp_get_attachment($attachment_id) {
	require_once('include/wp-get-attachment.php');
	return wp_get_attachment_action($attachment_id);
}

function hv_slideshow($termName) {
	require_once('include/hv-slideshow.php');
}

function gallery_post($content) {
	require_once('include/gallery-post.php');
}

function post_attachment_count($post_id) {
	$attachments = get_children(
		array('post_parent' => $post_id)
	);
		
	return( count( $attachments ) );
}

function the_post_thumbnail_caption() {
	require_once('include/the-post-thumbnail-caption.php');
}

function hv_comment($comment, $args, $depth) {
	require_once('include/hv-comment.php');
	hv_comment_action($comment, $args, $depth);
}

function debug($obj) {
	echo '<pre>';
	print_r($obj);
	echo '</pre>';
}

function urlfix($url){
	$search = array('å', 'ä', 'ö', 'Å', 'Ä', 'Ö');
	$replace = array('a%CC%88', 'a%CC%88', 'o%CC%88', 'a%CC%88', 'a%CC%88', 'o%CC%88');

	return str_replace($search, $replace, $url);
}

function get_custom_cat_template($single_template) {
     global $post;

       if ( in_category( 'tv' )) {
          $single_template = dirname( __FILE__ ) . '/single-tv-category.php';
     }
     return $single_template;
}

add_filter( "single_template", "get_custom_cat_template" ) ;

?>