<?php
/**
 * bets functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bets
 */

if ( ! function_exists( 'bets_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bets_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on bets, use a find and replace
		 * to change 'bets' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wp-bets', get_template_directory() . '/languages' );

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
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'bets' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'bets_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'bets_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bets_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'bets_content_width', 640 );
}
add_action( 'after_setup_theme', 'bets_content_width', 0 );



function true_register_wp_sidebars() {
 	register_sidebar(
		array(
			'id' => 'true_side',
			'name' => __('Боковая колонка', 'wp-bets'),
			'description' => __('Перетащите сюда виджеты, чтобы добавить их в сайдбар.', 'wp-bets'), // описание
			'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
			'after_title' => '</h3>'
		)
	);
 	register_sidebar(
		array(
			'id' => 'true_foot',
			'name' => __('Футер', 'wp-bets'),
			'description' => __('Перетащите сюда виджеты, чтобы добавить их в футер.', 'wp-bets'),
			'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
}
 
add_action( 'widgets_init', 'true_register_wp_sidebars' );


/**
 * Enqueue scripts and styles.
 */
function bets_scripts() {
	wp_enqueue_style( 'bets-style', get_stylesheet_uri() );
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bets-custom', get_template_directory_uri() . '/js/custom.js', array(), '20151215', true );

}
add_action( 'wp_enqueue_scripts', 'bets_scripts' );


add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){

	wp_localize_script('bets-custom', 'myajax',
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);

}
add_action('wp_ajax_add_post_bets', 'add_post_bets');
add_action('wp_ajax_nopriv_add_post_bets', 'add_post_bets');
function add_post_bets() {
	global $post;
	
	$post_title = isset( $_POST['post_title'] ) ? $_POST['post_title'] : 'N/A';
	$post_content = isset( $_POST['post_content'] ) ? $_POST['post_content'] : 'N/A';
	$type_bets = isset( $_POST['type_bets'] ) ? $_POST['type_bets'] : 'N/A';
	$user_id = get_current_user_id();
	
	$post_data = array(
		'post_type'     => 'bets',
		'post_title'    => $post_title,
		'post_content'  => $post_content,
		'tax_input'     => array( 'type_bets' => array($type_bets) ),
		'post_status'   => 'publish',
		'post_author'   => $user_id,
	);
	
	//echo($type_bets);
	$post_id = wp_insert_post( wp_slash($post_data) );
	wp_die();
}

add_action('wp_ajax_add_meta_bets', 'add_meta_bets');
add_action('wp_ajax_nopriv_add_meta_bets', 'add_meta_bets');
function add_meta_bets() {
	global $post;
	
	$meta_value = isset( $_POST['meta_value'] ) ? $_POST['meta_value'] : '0';
	$post_id = isset( $_POST['post_id'] ) ? $_POST['post_id'] : '0';
	
	$update_post_meta = update_post_meta( $post_id, '_bet_vote', $meta_value );
	if($update_post_meta){
		return true;
	}
	wp_die();
}