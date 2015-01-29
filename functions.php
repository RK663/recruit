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
	//add_theme_support( 'post-thumbnails' );

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
		'aside', 'image', 'video', 'quote', 'link',
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
	wp_register_style('recruit-web-fonts', 'http://fonts.googleapis.com/css?family=Abel|Lobster|Indie+Flower|Titillium+Web:400,600,400italic,300,300italic,700');
	wp_enqueue_style('recruit-web-fonts');
}

/**
 * Enqueue scripts and styles.
 */
function recruit_scripts() {

	wp_enqueue_style( 'recruit-style', get_stylesheet_uri() );

	// add custom fonts for our main stylesheet
	wp_enqueue_style('recruit-fonts', recruit_web_fonts(), array(), null);

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.3.2');
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


add_filter( 'widget_tag_cloud_args', 'my_widget_tag_cloud_args' );
function my_widget_tag_cloud_args( $args ) {
	// Your extra arguments go here
	$args['number'] = 20;
	$args['largest'] = 1.6;
	$args['smallest'] = 1.6;
	$args['unit'] = 'rem';
	return $args;
}