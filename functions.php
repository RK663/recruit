<?php
/**
 * RECRUIT functions and definitions
 *
 * @package RECRUIT
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

/**
 * For easy translation purposes
 * return string
 */
$GLOBALS['textdomain'] = 'recruit';

if ( ! function_exists( 'recruit_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function recruit_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on RECRUIT, use a find and replace
	 * to change 'recruit' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'recruit', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(750, 400, true);
	add_image_size('recruit-thumbnail', 750, 400, true);
	add_image_size('recruit-gallery-thumbnail', 450, 450, true);
	add_image_size('recruit-large', 1024, 9999, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'recruit' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'recruit_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // recruit_setup
add_action( 'after_setup_theme', 'recruit_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function recruit_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'recruit' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'recruit_widgets_init' );

function recruit_web_fonts() {
	wp_register_style('recruit-web-fonts', 'http://fonts.googleapis.com/css?family=Abel|Titillium+Web:400,600,400italic|Lato:400italic|Marck+Script');
	wp_enqueue_style('recruit-web-fonts');
}

/**
 * Enqueue scripts and styles.
 */
function recruit_scripts() {

	wp_enqueue_style( 'recruit-style', get_stylesheet_uri() );

	// add custom fonts for our main stylesheet
	wp_enqueue_style('recruit-fonts', recruit_web_fonts(), array(), null);

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '3.3.2');
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.3.0');
	wp_enqueue_style('recruit-style-2', get_template_directory_uri() . '/assets/css/recruit-style.css', array(), '1.0');

	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), true);
	wp_enqueue_script('hoverIntent', get_template_directory_uri() . '/assets/js/hoverIntent.js', array('jquery'), true);
	wp_enqueue_script('superfish', get_template_directory_uri() . '/assets/js/superfish.js', array('jquery'), true);
	wp_enqueue_script('supersubs', get_template_directory_uri() . '/assets/js/supersubs.js', array('jquery'), true);
	wp_enqueue_script('recruit-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), true);

	wp_enqueue_script( 'recruit-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'recruit-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'recruit_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


if (!function_exists('wpex_mce_buttons')) {
	function wpex_mce_buttons($buttons) {
		array_unshift($buttons, 'fontselect');
		array_unshift($buttons, 'fontsizeselect');
		return $buttons;
	}
}
add_filter('mce_buttons_2', 'wpex_mce_buttons');


// register my custom button to tinymce editor
function register_recruit_buttons() {
	add_filter('mce_external_plugins', 'my_external_js');
	add_filter('mce_buttons', 'register_my_custom_button');
}

function my_external_js($plugin_array){
	$plugin_array['recruit_button'] = get_template_directory_uri() . '/js/custom.js';
	return $plugin_array;
}

function register_my_custom_button($buttons) {
	array_push($buttons, 'recruit_button');
	return $buttons;
}

add_action('admin_head', 'register_recruit_buttons');


/**
 * Modify the output of default wordpress tagcloud by giving each tag same size
 * @param  object $args Same size in rem unit
 * @return string       Same size in rem unit
 */
function recruit_widget_tag_cloud_args($args) {
	$args['number'] = 20;
	$args['largest'] = 1.6;
	$args['smallest'] = 1.6;
	$args['unit'] = 'rem';
	return $args;
}
add_filter('widget_tag_cloud_args', 'recruit_widget_tag_cloud_args');


/**
 * Retrive link from post content
 * @return string The first link
 */
function recruit_post_format_link() {
	if (has_post_format('link')) {
		$content = get_the_content();
		$linktoend = stristr($content, 'http');
		$afterlink = stristr($linktoend, '"');

		if (!strlen($afterlink) == 0) {
			$linkurl = substr($linktoend, 0, -(strlen($afterlink)));
		} else {
			$linkurl = $linktoend;
		}

		printf('<h1 class="entry-title"><a href="%1$s" rel="bookmark" target="_blank">%2$s</a></h1><a href="%1$s" class="link" target="_blank">%1$s</a>',
			$linkurl,
			get_the_title()
		);
	}
}


/**
 * Retrive the url of image
 * @return string Html content with img src
 */
function recruit_post_format_image() {
	global $post;

	if ($output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches)) {
		$img_url = $matches[1][0];
	}

	if (empty($img_url)) {
		if (has_post_thumbnail()) {
			$link_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'recruit-thumbnail');
			$img_url = $link_thumbnail[0];
		}
	}

	if (!empty($img_url)) {
		printf('<div class="post-thumbnail"><a href="%1$s"><img src="%2$s" alt="%3$s" title="%4$s"></img></a></div>',
			get_the_permalink(),
			$img_url,
			get_the_title(),
			get_the_title()
		);
	}
}

/**
 * Post format quote
 * @return string Return html content
 */
function recruit_post_format_quote() {
	printf('<blockquote>%1$s<cite>%2$s</cite></blockquote>',
		get_the_content(),
		get_the_title()
	);
}

/**
 * Retrive post thumbnail link
 * @return string Post thumbnail link
 */
function recruit_post_thumbnail_url() {
	global $post;
	$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'recruit-thumbnail');
	$thumb_url = $thumb[0];

	return $thumb_url;
}

// add meta-box
require_once 'inc/meta-box.php';