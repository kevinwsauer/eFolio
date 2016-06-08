<?php
/**
 * eFolio functions and definitions
 *
 * @package eFolio
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 780; /* pixels */
}

if ( ! function_exists( 'efolio_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function efolio_setup() {

	// This theme styles the visual editor to resemble the theme style.
	$font_url = 'http://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,900,900italic|PT+Serif:400,700,400italic,700italic';
	add_editor_style( array( 'inc/editor-style.css', str_replace( ',', '%2C', $font_url ) ) );
                
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on eFolio, use a find and replace
	 * to change 'efolio' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'efolio', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'main' => __( 'Main Menu', 'efolio' ),
		'benchmark' => __( 'Benchmark Menu', 'efolio' ),
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
	add_theme_support( 'post-formats', array( 'aside' ) );

	// Set up the WordPress core custom background feature.
	/*add_theme_support( 'custom-background', apply_filters( 'efolio_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) ); */
}
endif; // efolio_setup
add_action( 'after_setup_theme', 'efolio_setup' );

/**
 * Enqueue scripts and styles.
 */
function efolio_scripts() {
	wp_enqueue_style( 'efolio-style', get_stylesheet_uri() );

	if (is_page_template('page-templates/page-nosidebar.php') || is_page_template('page-templates/page-directory.php')) {
		wp_enqueue_style( 'efolio-layout-style' , get_template_directory_uri() . '/layouts/no-sidebar.css');
	} else {
		wp_enqueue_style( 'efolio-layout-style' , get_template_directory_uri() . '/layouts/content-sidebar.css');
	}
          
	wp_enqueue_style( 'efolio-google-fonts', 'http://fonts.googleapis.com/css?family=Lato:100,300,400,400italic,700,900,900italic|PT+Serif:400,700,400italic,700italic' );
                    
	// FontAwesome
	wp_enqueue_style('efolio-fontawesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');

	wp_enqueue_script( 'efolio-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
                
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'efolio_scripts' );

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

// Add FitVids to allow for responsive sizing of videos
function efolio_fitvids() {
	if (!is_admin()) {
		wp_register_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), '1.0', true);    	
    	wp_enqueue_script( 'fitvids');
    	add_action('wp_head', 'add_fitthem');
    	
    	function add_fitthem() { ?>
	    	<script type="text/javascript">
		    	jQuery(document).ready(function() {
	    			jQuery('.video').fitVids();
	    		});
    		</script><?php
	    }
	}
}

add_action('init', 'efolio_fitvids');

// Automatically append .video class to oembed content (not a perfect solution, but close)
function efolio_embed_filter( $html, $data, $url ) {
	$return = '<div class="video">'.$html.'</div>';
	return $return;
}

add_filter('oembed_dataparse', 'efolio_embed_filter', 90, 3 );

// Includes the eFolio Directory List 
include (TEMPLATEPATH . '/directory/directory-list.php');

function efoilo_directory_loader() {	
	if (!is_admin()) {
		wp_register_script( 'efolio_directory_ajax', get_template_directory_uri() . '/directory/js/efolio_directory_ajax.js', array('jquery'));   		
		wp_localize_script('efolio_directory_ajax', 'Template', array('path' => get_template_directory_uri() . '/directory/directory-loader.php'));  
    	wp_enqueue_script( 'efolio_directory_ajax');
	}
}

add_action('init', 'efoilo_directory_loader');