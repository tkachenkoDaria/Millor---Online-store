<?php

/**
 * millor functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package millor
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function millor_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on millor, use a find and replace
	 * to change 'millor' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('millor', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'header'      => esc_html__('Header', 'millor'),
			'header_mobi' => esc_html__('Header Mobi', 'millor'),
			'footer'      => esc_html__('Footer', 'millor'),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'millor_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'millor_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function millor_content_width() {
	$GLOBALS['content_width'] = apply_filters('millor_content_width', 640);
}
add_action('after_setup_theme', 'millor_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function millor_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'millor'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'millor'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'millor_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function millor_scripts() {

	wp_enqueue_style('millor-swiperBundle', get_template_directory_uri() . "/assets/css/swiper-bundle.css");
	wp_enqueue_style('millor-bootstrapReboot', get_template_directory_uri() . "/assets/css/bootstrap-reboot.min.css");
	wp_enqueue_style('millor-bootstrapGrid.min', get_template_directory_uri() . "/assets/css/bootstrap-grid.min.css");
	wp_enqueue_style('millor-main', get_template_directory_uri() . "/assets/css/main.css");

	wp_enqueue_style('millor-style', get_stylesheet_uri(), array(), _S_VERSION);
	// wp_style_add_data( 'millor-style', 'rtl', 'replace' );

	// wp_enqueue_script( 'millor-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script('jquery');
	wp_enqueue_script('millor-swiperBundle', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('millor-js', get_template_directory_uri() . '/assets/js/main.js', array(), _S_VERSION, true);
	wp_enqueue_script('millor-ajax-js', get_template_directory_uri() . '/assets/js/ajax-js.js', array(), _S_VERSION, true);
	wp_enqueue_script('millor-ajax-js');
	global $wp_query;
	$localize_var_args = array(
		'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
		'cur_page' => get_query_var('paged') ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages,
		'ajaxurl' => admin_url('admin-ajax.php')
	);
	wp_localize_script('millor-ajax-js', 'wp_js_vars', $localize_var_args);


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'millor_scripts');


/**
 * Page style
 */

function page_template_custom_select_styles() {
	if (is_page_template('template-blog.php') || is_single()) {
		wp_enqueue_script('millor-accordion', get_template_directory_uri() . '/assets/js/accordion.js', array(), _S_VERSION, true);
	}
}
add_action('wp_enqueue_scripts', 'page_template_custom_select_styles');


/*** Перезапис стилів woocommerce ***/
function woo_style() {
	wp_register_style('millor-woocommerce-css', get_template_directory_uri() . '/woocommerce/assets/css/woocommerce.css', null, 1.0, 'screen');
	wp_enqueue_style('millor-woocommerce-css');
}
add_action('wp_enqueue_scripts', 'woo_style');


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 *  WooCommerce theme custom .
 */
require get_template_directory() . '/inc/woocommerce-file.php';




add_filter('upload_mimes', 'svg_upload_allow');


function svg_upload_allow($mimes) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}


add_filter('wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5);


function fix_svg_mime_type($data, $file, $filename, $mimes, $real_mime = '') {

	// WP 5.1 +
	if (version_compare($GLOBALS['wp_version'], '5.1.0', '>=')) {
		$dosvg = in_array($real_mime, ['image/svg', 'image/svg+xml']);
	} else {
		$dosvg = ('.svg' === strtolower(substr($filename, -4)));
	}


	if ($dosvg) {

		// разрешим
		if (current_user_can('manage_options')) {

			$data['ext'] = 'svg';
			$data['type'] = 'image/svg+xml';
		} else {
			$data['ext'] = false;
			$data['type'] = false;
		}
	}

	return $data;
}

add_filter('wp_prepare_attachment_for_js', 'show_svg_in_media_library');


function show_svg_in_media_library($response) {

	if ($response['mime'] === 'image/svg+xml') {

		// С выводом названия файла
		$response['image'] = [
			'src' => $response['url'],
		];
	}

	return $response;
}

/**
 * ACF Options Page
 */
if (function_exists('acf_add_options_page')) {

	acf_add_options_page();

	acf_add_options_sub_page(array(
		'page_title' => 'FAQ',
		'menu_title' => 'FAQ',
		// 'parent_slug' => 'theme-general-settings',
		'post_id'    => 'faq'
	));
	acf_add_options_sub_page(array(
		'page_title' => 'Cooking',
		'menu_title' => 'Cooking',
		// 'parent_slug' => 'theme-general-settings',
		'post_id'    => 'cooking'
	));

	acf_add_options_sub_page(array(
		'page_title' => 'Theme Footer Settings',
		'menu_title' => 'Footer',
		// 'parent_slug' => 'theme-general-settings',
	));
}

/**
 *  Ajax load news-category
 */
add_action('wp_ajax_load_posts_by_category', 'load_posts_by_category_callback');
add_action('wp_ajax_nopriv_load_posts_by_category', 'load_posts_by_category_callback');

function load_posts_by_category_callback() {
	$data = json_decode(file_get_contents("php://input"), true);
	$category_id = (int) $data['category_id'];
	$args = array(
		'category__in' => $category_id,
		'posts_per_page' => 2,
		'paged' => 1,
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		ob_start();
		while ($query->have_posts()) {
			$query->the_post();
			get_template_part('template-parts/content-filter-news', get_post_type());
		}
		$posts_html = ob_get_clean();

		$big = 999999999;
		$pagination_html = '<div class="pagination-news">';
		$pagination_html .= wp_kses_post(paginate_links([
			'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format'  => '?paged=%#%',
			'current' => 1,
			'total'   => $query->max_num_pages,
			'prev_text' => __('«', 'millor'),
			'next_text' => __('»', 'millor'),
		]));
		$pagination_html .= '</div>';

		wp_send_json_success(['posts' => $posts_html, 'pagination' => $pagination_html]);
	} else {
		wp_send_json_error('No posts found');
	}

	wp_reset_postdata();
	wp_die();
}



/**
 *  Ajax load pagination for news-category
 */
add_action('wp_ajax_load_posts_by_page', 'load_posts_by_page_callback');
add_action('wp_ajax_nopriv_load_posts_by_page', 'load_posts_by_page_callback');

function load_posts_by_page_callback() {
	$data = json_decode(file_get_contents("php://input"), true);

	if (!isset($data['page']) || !isset($data['category_id'])) {
		wp_send_json_error('Invalid request parameters');
		wp_die();
	}

	$page = intval($data['page']);
	$category_id = intval($data['category_id']);

	$args = [
		'post_type'      => 'post',
		'posts_per_page' => 2,
		'paged'          => $page,
		'category__in'   => $category_id,
	];

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		ob_start();
		while ($query->have_posts()) {
			$query->the_post();
			get_template_part('template-parts/content-filter-news', get_post_type());
		}
		$posts_html = ob_get_clean();

		$big = 999999999;
		$pagination_html = '<div class="pagination-news">';
		$pagination_html .= wp_kses_post(paginate_links([
			'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format'    => '?paged=%#%',
			'current'   => max(1, $page),
			'total'     => $query->max_num_pages,
			'prev_text' => __('«', 'millor'),
			'next_text' => __('»', 'millor'),
		]));
		$pagination_html .= '</div>';

		wp_send_json_success(['posts' => $posts_html, 'pagination' => $pagination_html]);
	} else {
		wp_send_json_error('No posts found');
	}

	wp_reset_postdata();
	wp_die();
}


/**
 *  Ajax load reviews for product
 */
add_action('wp_ajax_load_more_reviews', 'load_more_reviews_callback');
add_action('wp_ajax_nopriv_load_more_reviews', 'load_more_reviews_callback');

function load_more_reviews_callback() {

	$data = json_decode(file_get_contents("php://input"), true);

	$paged = (int) $data['page'];
	$product_id = (int) $data['product_id'];

	$comments = get_comments([
		'post_id' => $product_id,
		'status' => 'approve'
	]);

	wp_list_comments([
		'page'              => $paged,
		'per_page' => 2,
		'order' => 'DESC',
		'callback' => 'woocommerce_comments',
	], $comments);

	wp_die();
}
