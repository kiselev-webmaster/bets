<?php
/*
 * Plugin Name: Ставки
 * Plugin URI: https://kiselev-webmaster.ru/
 * Description: Тестовое задание
 * Version: 1.1.1
 * Author: Киселев Денис
 * Author URI: https://kiselev-webmaster.ru/
  * Text Domain: wp-bets
 * Domain Path: /lang
 */
 
 global $wpdb;
 // создаем пользовательский тип поста
 add_action( 'init', 'register_post_type_bets' );
 
function register_post_type_bets() {
	$labels = array(
		'name' => __('Ставки', 'wp-bets'),
		'singular_name' => __('Ставку', 'wp-bets'), 
		'add_new' => __('Добавить ставку', 'wp-bets'),
		'add_new_item' => __('Добавить новую ставку', 'wp-bets'),
		'edit_item' => __('Редактировать ставку', 'wp-bets'),
		'new_item' => __('Новая ставка', 'wp-bets'),
		'all_items' => __('Все ставки', 'wp-bets'),
		'view_item' => __('Просмотр ставку на сайте', 'wp-bets'),
		'search_items' => __('Искать ставки', 'wp-bets'),
		'not_found' =>  __('Ставки не найдено.', 'wp-bets'),
		'not_found_in_trash' => __('В корзине нет ставок.', 'wp-bets'),
		'menu_name' => __('Ставки', 'wp-bets') // ссылка в меню в админке
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true, // показывать интерфейс в админке
		'has_archive' => true, 
		'menu_icon' => 'dashicons-clipboard', // иконка в меню
		'menu_position' => 20, // порядок в меню
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields'),
		'capabilities' => array(
			'read_post'					=> 'read_bets',
			'read_private_posts' 		=> 'read_private_betss',
			'edit_post'					=> 'edit_bets',
			'edit_posts'				=> 'edit_betss',
			'edit_others_posts'			=> 'edit_others_betss',
			'edit_published_posts'		=> 'edit_published_betss',
			'edit_private_posts'		=> 'edit_private_betss',
			'delete_post'				=> 'delete_bets',
			'delete_posts'				=> 'delete_betss',
			'delete_others_posts'		=> 'delete_others_betss',
			'delete_published_posts'	=> 'delete_published_betss',
			'delete_private_posts'		=> 'delete_private_betss',
			'publish_posts'				=> 'publish_betss',
			'moderate_comments'			=> 'moderate_bets_comments',
		)
	);
	register_post_type('bets', $args);
}

// создаем таксономии 
add_action( 'init', 'type_bets' );
function type_bets(){
	register_taxonomy('type_bets', array('bets'), array(
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => array(
			'name'              => __('Тип ставки', 'wp-bets'),
			'singular_name'     => __('Тип ставки', 'wp-bets'),
			'search_items'      => __('Поиск типа ставки', 'wp-bets'),
			'all_items'         => __('Все типы', 'wp-bets'),
			'view_item '        => __('Просмотреть', 'wp-bets'),
			'parent_item'       => __('Parent типа', 'wp-bets'),
			'parent_item_colon' => __('Parent типа:', 'wp-bets'),
			'edit_item'         => __('Редактировать тип', 'wp-bets'),
			'update_item'       => __('Сохранить', 'wp-bets'),
			'add_new_item'      => __('Добавить новый', 'wp-bets'),
			'new_item_name'     => __('Добавить тип', 'wp-bets'),
			'menu_name'         => __('Типы ставок', 'wp-bets')
		),
		'hierarchical' => true,
		'capabilities'          => array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_categories',
			'delete_terms' => 'manage_categories',
			'assign_terms' => 'edit_betss'
		)
	) );
}

add_action( 'init', 'status_bets' );
function status_bets(){
	register_taxonomy('status_bets', array('bets'), array(
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => array(
			'name'              => __('Статус ставки', 'wp-bets'),
			'singular_name'     => __('Статус ставки', 'wp-bets'),
			'search_items'      => __('Поиск статуса ставки', 'wp-bets'),
			'all_items'         => __('Все статусы', 'wp-bets'),
			'view_item '        => __('Просмотреть', 'wp-bets'),
			'parent_item'       => __('Parent статус', 'wp-bets'),
			'parent_item_colon' => __('Parent статус:', 'wp-bets'),
			'edit_item'         => __('Редактировать статус', 'wp-bets'),
			'update_item'       => __('Сохранить', 'wp-bets'),
			'add_new_item'      => __('Добавить статус', 'wp-bets'),
			'new_item_name'     => __('Добавить статус', 'wp-bets'),
			'menu_name'         => __('Статус ставок', 'wp-bets')
		),
		'hierarchical' => true,
		'capabilities'          => array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_categories',
			'delete_terms' => 'manage_categories',
			'assign_terms' => 'edit_betss'
		)
	) );
}

// добавляем термины
add_action( 'init', 'insert_term_bets' );
function insert_term_bets() {
    wp_insert_term('Ординар', 'type_bets');
    wp_insert_term('Экспресс', 'type_bets');
    
    wp_insert_term('Выигрыш', 'status_bets');
    wp_insert_term('Проигрыш', 'status_bets');
    wp_insert_term('Возврат', 'status_bets');
    wp_insert_term('Активная', 'status_bets');
}

// добавляем роли один раз при активации плагина
register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );
function add_roles_on_plugin_activation() {
	add_role( 'capper', __('Каппер', 'wp-bets'), array('read' => true) );
	add_role( 'moderator', __('Модератор', 'wp-bets'), array('read' => true) );
}

// прописываем права
add_action('admin_init','add_bets_cap');
function add_bets_cap(){
	$capper = get_role( 'capper' );
	$capper->add_cap( 'read_bets' );
	$capper->add_cap( 'edit_bets' );
	$capper->add_cap( 'edit_betss' );
	$capper->add_cap( 'delete_bets' );
	$capper->add_cap( 'delete_betss' );
	$capper->add_cap( 'publish_betss' );
	$capper->remove_cap('edit_others_betss');
	$capper->remove_cap('delete_others_betss');
	
	$moderator = get_role( 'moderator' );
	$moderator->add_cap( 'read_bets' );
	$moderator->add_cap( 'read_private_bets' );
	$moderator->add_cap( 'edit_bets' );
	$moderator->add_cap( 'edit_betss' );
	$moderator->add_cap( 'edit_others_betss' );
	$moderator->add_cap( 'edit_published_betss' );
	$moderator->add_cap( 'edit_private_betss' );
	$moderator->add_cap( 'delete_betss' );
	$moderator->add_cap( 'delete_bets' );
	$moderator->add_cap( 'delete_others_betss' );
	$moderator->add_cap( 'delete_published_bets' );
	$moderator->add_cap( 'delete_bets' );
	$moderator->add_cap( 'delete_private_bets' );
	$moderator->add_cap( 'publish_betss' );
	$moderator->add_cap( 'moderate_bets_comments' );
	
	$admin = get_role( 'administrator' );
	$admin->add_cap( 'read_bets' );
	$admin->add_cap( 'read_private_bets' );
	$admin->add_cap( 'edit_bets' );
	$admin->add_cap( 'edit_betss' );
	$admin->add_cap( 'edit_others_betss' );
	$admin->add_cap( 'edit_published_betss' );
	$admin->add_cap( 'edit_private_betss' );
	$admin->add_cap( 'delete_betss' );
	$admin->add_cap( 'delete_bets' );
	$admin->add_cap( 'delete_others_betss' );
	$admin->add_cap( 'delete_published_bets' );
	$admin->add_cap( 'delete_bets' );
	$admin->add_cap( 'delete_private_bets' );
	$admin->add_cap( 'publish_betss' );
	$admin->add_cap( 'moderate_bets_comments' );
	$admin->add_cap( 'manage_categories' );
}

// при деактивации плагина убираем все за собой
function bets_remove_roles(){
	$capper = get_role( 'capper' );
	$moderator = get_role( 'moderator' );
	$admin = get_role( 'administrator' );
	
	$caps = array(
		'read_bets',
		'read_private_bets',
		'edit_bets',
		'edit_betss',
		'edit_others_betss',
		'edit_published_betss',
		'edit_private_betss',
		'delete_betss',
		'delete_bets',
		'delete_others_betss',
		'delete_published_bets',
		'delete_bets',
		'delete_private_bets',
		'publish_betss',
		'moderate_bets_comments',
		'manage_categories'
	);
	foreach ( $caps as $cap ) {
		$capper->remove_cap( $cap );
		$moderator->remove_cap( $cap );
		$admin->remove_cap( $cap );
	}	
	
	if( $capper ){
		remove_role( 'capper' );
	}
	if( $moderator ){
		remove_role( 'moderator' );
	}
}
register_deactivation_hook( __FILE__, 'bets_remove_roles' );