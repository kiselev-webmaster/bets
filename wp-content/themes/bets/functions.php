<?php


if ( ! function_exists( 'bets_setup' ) ) :

	function bets_setup() {

		load_theme_textdomain( 'wp-bets', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'bets' ),
		) );
		
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'customize-selective-refresh-widgets' );
		

	}
endif;
add_action( 'after_setup_theme', 'bets_setup' );



function bets_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Сайтбар - right', 'bets' ),
		'id'            => 'sidebar-right',
		'description'   => esc_html__( 'Добавить виджет.', 'bets' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Сайтбар - buttom', 'bets' ),
		'id'            => 'sidebar-buttom',
		'description'   => esc_html__( 'Добавить виджет.', 'bets' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bets_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bets_scripts() {
	wp_enqueue_style( 'bets-style', get_stylesheet_uri() );
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bets-custom', get_template_directory_uri() . '/js/custom.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
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