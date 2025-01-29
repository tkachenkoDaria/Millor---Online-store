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

/**
 *  WooCommerce filter .
 */
require get_template_directory() . '/inc/woocommerce-filter.php';


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





remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);


// jQuery code
add_action('wp_footer', 'custom_checkout_jquery_script');
function custom_checkout_jquery_script() {
	if (is_checkout() && !is_wc_endpoint_url()) :
	?>
		<script type="text/javascript">
			jQuery(function($) {
				$('.coupon-form button[name="apply_coupon"]').on('click', function(e) {
					e.preventDefault();
					var couponCode = $('.coupon-form input[name="coupon_code"]').val();

					if (couponCode) {
						$.ajax({
							type: 'POST',
							url: wc_checkout_params.ajax_url,
							data: {
								security: wc_checkout_params.apply_coupon_nonce,
								coupon_code: couponCode,
								action: 'woocommerce_apply_coupon'
							},
							beforeSend: function() {
								$('.woocommerce-error, .woocommerce-message').remove();
							},
							success: function(response) {
								$('body').trigger('update_checkout');
								if (!response.success) {
									$('.coupon-form').prepend(response);
								}
							},
							error: function() {
								$('.coupon-form').prepend('<div class="woocommerce-error">Виникла помилка. Спробуйте ще раз.</div>');
							}
						});
					} else {
						$('.coupon-form').prepend('<div class="woocommerce-error">Будь ласка, введіть код купону.</div>');
					}
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

// add_action('wp_ajax_load_more_product', 'load_more_product');
// add_action('wp_ajax_nopriv_load_more_product', 'load_more_product');

// function load_more_product() {

// 	$paged = $_POST['page'];
// 	$cat_id = $_POST['cat_id'];
// 	$paged++;

// 	$args = [
// 		'post_type' => 'product',
// 		'posts_per_page' => 9,
// 		'post_status' => 'publish',
// 		'paged'     => $paged,
// 		'tax_query' => array(
// 			array(
// 				'taxonomy' => 'product_cat',
// 				'field'    => 'id',
// 				'terms'    => $cat_id,
// 			),
// 		)
// 	];

// 	$query = new WP_Query($args);
// 	$html  = '';


// 	if ($query->have_posts()):
// 		ob_start();
// 		while ($query->have_posts()): $query->the_post();
// 			get_template_part('template-file/archive-product');
// 		endwhile;

// 		$html = ob_get_clean();

// 	endif;
// 	wp_reset_postdata();

// 	$data = array('success' => true, 'html' => $html, 'page'=> $paged);
// 	echo json_encode($data);

// 	wp_die();
// }



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


// New dropdown_variation
if (! function_exists('wc_dropdown_variation_attribute_options')) {

	/**
	 * Output a list of variation attributes for use in the cart forms.
	 *
	 * @param array $args Arguments.
	 * @since 2.4.0
	 */
	function wc_dropdown_variation_attribute_options($args = array()) {
		$args = wp_parse_args(
			apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args),
			array(
				'options'          => false,
				'attribute'        => false,
				'product'          => false,
				'selected'         => false,
				'name'             => '',
				'id'               => '',
				'class'            => '',
				'show_option_none' => __('Choose an option', 'woocommerce'),
			)
		);

		// Get selected value.
		if (false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
			$selected_key = 'attribute_' . sanitize_title($args['attribute']);
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
			// phpcs:enable WordPress.Security.NonceVerification.Recommended
		}

		$options          = $args['options'];
		$product          = $args['product'];
		$attribute        = $args['attribute'];
		$name             = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title($attribute);
		$id               = $args['id'] ? $args['id'] : sanitize_title($attribute);
		$class            = $args['class'];
		$show_option_none = (bool) $args['show_option_none'];
		$checked_value    = '';

		if (empty($options) && ! empty($product) && ! empty($attribute)) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[$attribute];
		}

		if (! empty($options)) {
			if ($product && taxonomy_exists($attribute)) {
				$terms = wc_get_product_terms(
					$product->get_id(),
					$attribute,
					array(
						'fields' => 'all',
					)
				);
				foreach ($options as $option) {
					if ($option === $args['selected']) {
						$checked_value = $option;
					}
				}
			}
		}

		// Button + List
		$html  = '<button class="btn-select-open" id="' . esc_attr($id) . '-btn" type="button">' . esc_html($checked_value ? $checked_value : __('Choose an option', 'woocommerce')) . '</button>';
		$html .= '<ul id="' . esc_attr($id) . '" class="select-list ' . esc_attr($class) . '" name="' . esc_attr($name) . '" data-attribute_name="attribute_' . esc_attr(sanitize_title($attribute)) . '" data-show_option_none="' . ($show_option_none ? 'yes' : 'no') . '">';

		if (! empty($options)) {
			if ($product && taxonomy_exists($attribute)) {
				$terms = wc_get_product_terms(
					$product->get_id(),
					$attribute,
					array(
						'fields' => 'all',
					)
				);

				foreach ($terms as $term) {
					if (in_array($term->slug, $options, true)) {
						$html .= '<li class="select-list__item" value="' . esc_attr($term->slug) . '" ' . selected(sanitize_title($args['selected']), $term->slug, false) . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $term->name, $term, $attribute, $product)) . '</li>';
					}
				}
			} else {
				foreach ($options as $option) {
					$selected = sanitize_title($args['selected']) === $args['selected'] ? selected($args['selected'], sanitize_title($option), false) : selected($args['selected'], $option, false);
					$html    .= '<li class="select-list__item" value="' . esc_attr($option) . '" ' . $selected . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $option, null, $attribute, $product)) . '</li>';
				}
			}
		}

		$html .= '</ul>';

		// Standard Select
		$html .= '<select id="' . esc_attr($id) . '-select" class="' . esc_attr($class) . '" name="' . esc_attr($name) . '" data-attribute_name="attribute_' . esc_attr(sanitize_title($attribute)) . '">';
		if ($show_option_none) {
			$html .= '<option value="">' . esc_html(__('Choose an option', 'woocommerce')) . '</option>';
		}
		if (! empty($options)) {
			if ($product && taxonomy_exists($attribute)) {
				foreach ($terms as $term) {
					if (in_array($term->slug, $options, true)) {
						$html .= '<option value="' . esc_attr($term->slug) . '" ' . selected(sanitize_title($args['selected']), $term->slug, false) . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $term->name, $term, $attribute, $product)) . '</option>';
					}
				}
			} else {
				foreach ($options as $option) {
					$selected = sanitize_title($args['selected']) === $args['selected'] ? selected($args['selected'], sanitize_title($option), false) : selected($args['selected'], $option, false);
					$html    .= '<option value="' . esc_attr($option) . '" ' . $selected . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $option, null, $attribute, $product)) . '</option>';
				}
			}
		}

		$html .= '</select>';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters('woocommerce_dropdown_variation_attribute_options_html', $html, $args);
	}
}
