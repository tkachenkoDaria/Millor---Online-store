<?php

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

	function millor_add_woocommerce_support() {
		add_theme_support('woocommerce');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-zoom');
	}

	add_action('after_setup_theme', 'millor_add_woocommerce_support');


	// The price near the variation and rating of the product card
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

	// Sorting
	remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
	remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
	remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);


	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);


	remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);


	add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);
	function woo_remove_product_tabs($tabs) {

		unset($tabs['description']);
		unset($tabs['additional_information']);

		return $tabs;
	}

	// review single page product
	add_filter('comment_form_defaults', 'render_pros_cons_fields_for_anonymous_users', 10, 1);
	add_action('comment_form_top', 'render_pros_cons_fields_for_authorized_users');
	function get_pros_cons_fields_html() {
		ob_start();
?>

		<div class="pcf-container">
			<div class="pcf-field-container">
				<label for="pros"><?php esc_html_e('Заголовок:', 'millor'); ?></label>
				<input id="pros" name="pros" type="text">
			</div>

			<div class="pcf-field-container">
				<label for="cons"><?php esc_html_e('Місто:', 'millor'); ?></label>
				<input id="cons" name="cons" type="text">
			</div>
		</div>

	<?php
		return ob_get_clean();
	}

	function render_pros_cons_fields_for_authorized_users() {
		if (!is_product() || !is_user_logged_in()) {
			return;
		}

		echo get_pros_cons_fields_html();
	}

	function render_pros_cons_fields_for_anonymous_users($defaults) {
		if (!is_product() || is_user_logged_in()) {
			return;
		}

		$defaults['comment_notes_before'] .= get_pros_cons_fields_html();

		return $defaults;
	}

	add_action('comment_post', 'save_review_pros_and_cons', 10, 3);
	function save_review_pros_and_cons($comment_id, $approved, $commentdata) {
		// The pros and cons fields are not required, so we have to check if they're not empty
		$pros = isset($_POST['pros']) ? $_POST['pros'] : '';
		$cons = isset($_POST['cons']) ? $_POST['cons'] : '';

		// Spammers and hackers love to use comments to do XSS attacks.
		// Don't forget to escape the variables
		update_comment_meta($comment_id, 'pros', esc_html($pros));
		update_comment_meta($comment_id, 'cons', esc_html($cons));
	}


	add_filter('comment_text', 'add_pros_and_cons_to_review_text', 10, 1);
	function add_pros_and_cons_to_review_text($text) {
		// We don't want to modify a comment's text in the admin, and we don't need to modify the text of blog post commets
		if (is_admin() || !is_product()) {
			return $text;
		}

		$pros = get_comment_meta(get_comment_ID(), 'pros', true);
		$cons = get_comment_meta(get_comment_ID(), 'cons', true);

		$pros_html = '<h5>' . esc_html($pros) . '</h5>';
		$cons_html = '<p class="city-comment">' . esc_html($cons) . '</p>';

		$updated_text = $pros_html . $cons_html . $text;

		return $updated_text;
	}
}



add_action('woocommerce_before_checkout_form', 'hide_checkout_coupon_form', 5);
function hide_checkout_coupon_form() {
	echo '<style>.woocommerce-form-coupon-toggle {display:none;}</style>';
}


// jQuery code
add_action('wp_footer', 'custom_checkout_jquery_script');
function custom_checkout_jquery_script() {
	if (is_checkout() && !is_wc_endpoint_url()) :
	?>
		<script type="text/javascript">
			jQuery(function($) {

				$('.checkout-coupon-toggle .show-coupon').on('click', function(e) {
					$('.coupon-form').toggle(200);
					e.preventDefault();
				})


				$('.coupon-form input[name="coupon_code"]').on('input change', function() {
					$('form.checkout_coupon input[name="coupon_code"]').val($(this).val());

				});


				$('.coupon-form button[name="apply_coupon"]').on('click', function() {
					$('form.checkout_coupon').submit();

				});
			});
		</script>
	<?php
	endif;
}

// Update counter for icon cart
add_filter('woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count');
function wc_refresh_mini_cart_count($fragments) {
	ob_start();
	$items_count = WC()->cart->get_cart_contents_count();
	?>
	<span class="wc-block-mini-cart__badge"><?php echo $items_count ? $items_count : '&nbsp;'; ?></span>
<?php
	$fragments['.wc-block-mini-cart__badge'] = ob_get_clean();
	return $fragments;
}


function display_archive_product() {
	global $product;
	global $post;
	$categories = get_the_terms($post->ID, "product_cat");
	$product_vending = array(25, 110, 113, 111, 114, 112, 115, 116);
	$product_coffee_drinks = array(104, 24, 109, 107, 105, 108, 106, 103);
	$product_healthy = array(119, 120, 121, 117, 118);
	foreach ($categories as $category) {
		$cat_ids = $category->term_id;

		if ($cat_ids == 23) {
			wc_get_template_part('content', 'archive-coffe');
		}

		if (in_array($cat_ids, $product_vending)) {
			wc_get_template_part('content', 'archive-vending');
		}

		if (in_array($cat_ids, $product_coffee_drinks)) {
			wc_get_template_part('content', 'archive-tea-healthy');
		}
		if (in_array($cat_ids, $product_healthy)) {
			wc_get_template_part('content', 'archive-tea-healthy');
		}
	}
}


/**
 * Load More Products with AJAX
 */

add_action('wp_ajax_more_product', 'more_product_ajax_handler');
add_action('wp_ajax_nopriv_more_product', 'more_product_ajax_handler');

function more_product_ajax_handler() {
	$data = json_decode(file_get_contents("php://input"), true); // Отримуємо дані з POST-запиту у вигляді асоціативного масиву

	$paged = (int) $data['page'];

	$args = array(
		'paged'          => $paged,
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 9
	);
	$loop = new WP_Query($args);

	if ($loop->have_posts()) {
		while ($loop->have_posts()) {
			$loop->the_post();
			display_archive_product();
		}
	}

	wp_reset_postdata();
	wp_die();
}



/**
 * Load More Products with AJAX for product category
 */

add_action('wp_ajax_more_product_category', 'more_product_category_ajax_handler');
add_action('wp_ajax_nopriv_more_product_category', 'more_product_category_ajax_handler');

function more_product_category_ajax_handler() {
	$data = json_decode(file_get_contents("php://input"), true); // Отримуємо дані з POST-запиту у вигляді асоціативного масиву

	$paged = (int) $data['page'];
	$cat_id = (int) $data['cat_id'];

	$args = array(
		'paged'          => $paged,
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 9,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'id',
				'terms' => $cat_id,
			)
		)
	);
	$loop = new WP_Query($args);

	if ($loop->have_posts()) {
		while ($loop->have_posts()) {
			$loop->the_post();
			display_archive_product();
		}
	}
	wp_reset_postdata();
	wp_die();
}


// We change the number of comments on the product page to 2
function custom_comments_per_page() {
	if (!is_admin() && is_product()) {
		update_option('page_comments', 2);
	}
}
add_action('template_redirect', 'custom_comments_per_page');
