<?php

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

/**
 * Show child category
 */

function show_child_category($class_block, $id_parent, $slug_parent, $class_category, $additional_class_catagory, $other_style = false) { ?>
	<section class="tea-category">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="<?php echo $class_block; ?>">
						<?php
						$prod_cat_args = array(
							'taxonomy'   => 'product_cat',
							'orderby'    => 'id',
							'hide_empty' => false,
							'parent'     => $id_parent,
						);

						$woo_categories = get_categories($prod_cat_args);
						foreach ($woo_categories as $woo_cat) {
							$woo_cat_id            = $woo_cat->term_id;
							$woo_cat_name          = $woo_cat->name;
							$woo_cat_slug          = $woo_cat->slug;
							$class_active          = '';
							$category_thumbnail_id = get_woocommerce_term_meta($woo_cat_id, 'thumbnail_id', true);
							$thumbnail_image_url   = wp_get_attachment_url($category_thumbnail_id);
							if (is_product_category($slug_parent)) {
								$class_active = '';
							} elseif (is_product_category($woo_cat)) {
								$class_active = 'active-cat';
							}

							if ($other_style == false): ?>
								<a class="<?php echo $class_category; ?> <?php echo $additional_class_catagory; ?> <?php echo $class_active; ?>" href="<?php echo get_term_link($woo_cat_id, 'product_cat'); ?>">
									<img class="<?php echo $class_category; ?>__img" src="<?php echo $thumbnail_image_url; ?>" alt="category img">
									<p class="<?php echo $class_category; ?>__name">
										<?php echo $woo_cat_name; ?>
									</p>
								</a>
							<?php else: ?>
								<a href="<?php echo get_term_link($woo_cat_id, 'product_cat'); ?>" class="<?php echo $class_category; ?>">
									<div class="<?php echo $additional_class_catagory; ?>">
										<img src="<?php echo $thumbnail_image_url; ?>" alt="category-photo">
										<h5>
											<?php echo $woo_cat_name; ?>
										</h5>
									</div>
								</a>
						<?php endif;
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php }





/**
 * Load More Products with AJAX
 * 
 */

add_action('wp_ajax_load_more_product', 'load_more_product');
add_action('wp_ajax_nopriv_load_more_product', 'load_more_product');

function load_more_product() {

	$paged = $_POST['page'];
	$cat_id = $_POST['cat_id'];
	$paged++;

	$args = [
		'post_type' => 'product',
		'posts_per_page' => 12,
		'post_status' => 'publish',
		'paged'     => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => $cat_id,
			),
		)
	];

	$query = new WP_Query($args);
	$html  = '';


	if ($query->have_posts()):
		ob_start();
		while ($query->have_posts()): $query->the_post();
			get_template_part('template-file/archive-product');
		endwhile;
		$html = ob_get_clean();

	endif;
	wp_reset_postdata();

	$data = array('success' => true, 'html' => $html);
	echo json_encode($data);

	wp_die();
}



/**
 *  Ajax load reviews for product
 */
add_action('wp_ajax_load_more_reviews', 'load_more_reviews');
add_action('wp_ajax_nopriv_load_more_reviews', 'load_more_reviews');

function load_more_reviews() {
	$paged = $_POST['page'];
	$product_id = $_POST['product_id'];
	$paged++;

	$html  = '';

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
	$html = ob_get_clean();

	$data = array('success' => true, 'html' => $html);
	echo json_encode($data);
	
	wp_die();
}



// We change the number of comments on the product page to 2
function custom_comments_per_page() {
	if (!is_admin() && is_product()) {
		update_option('page_comments', 2);
	}
}
add_action('template_redirect', 'custom_comments_per_page');