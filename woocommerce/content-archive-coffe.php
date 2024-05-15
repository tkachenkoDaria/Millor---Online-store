<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}
?>
<div <?php wc_product_class('card-coffe card-coffe_catalog', $product); ?>>

	<?php

	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item' );




	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	//  do_action( 'woocommerce_shop_loop_item_title' );
	woocommerce_show_product_loop_sale_flash();
	?>



	<!-- taxonomy -->
	<?php
	$output = array();

	// get an array of the WP_Term objects for a defined product ID
	$terms = wp_get_post_terms(get_the_id(), 'product_tag');

	// Loop through each product tag for the current product
	if (count($terms) > 0) {
		foreach ($terms as $term) {
			$term_id = $term->term_id; // Product tag Id
			$term_name = $term->name; // Product tag Name

			// Set the product tag names in an array
			$output[] = '<span class="card-coffe__text">' . $term_name . '</span>';
		}
		// Set the array in a coma separated string of product tags for example
		$output = implode('', $output);

		// Display the coma separated string of the product tags
		echo $output;
	}
	?>
	<!-- end taxonomy -->

	<!-- rating -->
	<div class="card-coffe__inner">
		<?php echo wp_get_attachment_image($product->get_image_id(), 'medium', false, array('class' => 'card-coffe__photo')) ?>
		<div class="card-coffe__items">

			<?php
			$rating_count = $product->get_rating_count();
			$review_count = $product->get_review_count();
			$average = $product->get_average_rating();

			if ($rating_count > 0) : ?>

				<div class="woocommerce-product-rating card-reviews card-reviews_coffe">
					<?php echo wc_get_rating_html($average, $rating_count); // WPCS: XSS ok. 
					?>
				</div>

			<?php endif; ?>

			<div class="response">
				<p>
					<?php echo $product->get_average_rating(); ?>
				</p>
				<?php if (comments_open()) : ?>
					<?php //phpcs:disable 
					?>
					<div class="woocommerce-review-link" rel="nofollow">(
						<?php printf(_n('%s відгук', '%s відгука', $review_count, 'woocommerce'), '<span class="count">' . esc_html($review_count) . '</span>'); ?>)
					</div>
					<?php // phpcs:enable 
					?>
				<?php endif ?>
			</div>
			<!-- end rating -->


			<!-- strength-coffe -->
			<div class="strength-coffe">
				<?php
				$termStrength = $product->get_attribute('pa_degree-of-roasting');
				$termStrength = get_term_by('slug', $termStrength, 'pa_degree-of-roasting');
				$imgCoffe = get_field('select_degree_of_roasting', 'pa_degree-of-roasting_' . $termStrength->term_id);

				if ($imgCoffe == 'one') : ?>
					<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/grain/grain.svg" alt="grain" width="24" height="24">
				<?php elseif ($imgCoffe == 'two') : ?>
					<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/grain/grain-2.svg" alt="grain-two" width="58" height="24">
				<?php elseif ($imgCoffe == 'three') : ?>
					<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/grain/grain-3.svg" alt="grain-three" width="92" height="24">
				<?php elseif ($imgCoffe == 'four') : ?>
					<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/grain/grain-4.svg" alt="grain-four" width="126" height="24">
				<?php elseif ($imgCoffe == 'five') : ?>
					<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/grain/grain-5.svg" alt="grain-five" width="160" height="24">
				<?php endif; ?>
			</div>
			<!-- end strength-coffe -->

			<!-- quality-coffe -->
			<div class="quality-coffe">
				<p>Кислинка</p>
				<div class="quality-properties">
					<?php
					$termQuality = $product->get_attribute('pa_quality-coffe');
					$termQuality = get_term_by('slug', $termQuality, 'pa_quality-coffe');
					$imgCoffeQuality = get_field('select_strength_coffe', 'pa_quality-coffe_' . $termQuality->term_id);

					if ($imgCoffeQuality == 'one') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-1.svg" alt="grain" width="127" height="10">
					<?php elseif ($imgCoffeQuality == 'two') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-2.svg" alt="grain-two" width="127" height="10">
					<?php elseif ($imgCoffeQuality == 'three') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-3.svg" alt="grain-three" width="127" height="10">
					<?php elseif ($imgCoffeQuality == 'four') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-4.svg" alt="grain-four" width="127" height="10">
					<?php elseif ($imgCoffeQuality == 'five') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-5.svg" alt="grain-five" width="127" height="10">
					<?php elseif ($imgCoffeQuality == 'six') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-6.svg" alt="grain-six" width="127" height="10">
					<?php elseif ($imgCoffeQuality == 'seven') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-7.svg" alt="grain-seven" width="127" height="10">
					<?php elseif ($imgCoffeQuality == 'eight') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-8.svg" alt="grain-eight" width="127" height="10">
					<?php elseif ($imgCoffeQuality == 'nine') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-9.svg" alt="grain-nine" width="127" height="10">
					<?php elseif ($imgCoffeQuality == 'ten') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-10.svg" alt="grain-ten" width="127" height="10">
					<?php endif; ?>
				</div>
			</div>
			<!-- end quality-coffe -->

			<!--  mustard-coffe -->
			<div class="quality-coffe">
				<p>Гірчинка</p>
				<div class="quality-properties">
					<?php
					$termMustard = $product->get_attribute('pa_mustard-coffe');
					$termMustard = get_term_by('slug', $termMustard, 'pa_mustard-coffe');
					$imgCoffeMustard = get_field('select_mustard_coffe', 'pa_mustard-coffe_' . $termMustard->term_id);

					if ($imgCoffeMustard == 'one') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-1.svg" alt="grain" width="127" height="10">
					<?php elseif ($imgCoffeMustard == 'two') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-2.svg" alt="grain-two" width="127" height="10">
					<?php elseif ($imgCoffeMustard == 'three') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-3.svg" alt="grain-three" width="127" height="10">
					<?php elseif ($imgCoffeMustard == 'four') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-4.svg" alt="grain-four" width="127" height="10">
					<?php elseif ($imgCoffeMustard == 'five') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-5.svg" alt="grain-five" width="127" height="10">
					<?php elseif ($imgCoffeMustard == 'six') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-6.svg" alt="grain-six" width="127" height="10">
					<?php elseif ($imgCoffeMustard == 'seven') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-7.svg" alt="grain-seven" width="127" height="10">
					<?php elseif ($imgCoffeMustard == 'eight') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-8.svg" alt="grain-eight" width="127" height="10">
					<?php elseif ($imgCoffeMustard == 'nine') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-9.svg" alt="grain-nine" width="127" height="10">
					<?php elseif ($imgCoffeMustard == 'ten') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-10.svg" alt="grain-ten" width="127" height="10">
					<?php endif; ?>
				</div>
			</div>
			<!-- end mustard-coffe -->

			<!-- saturation-coffe -->
			<div class="quality-coffe">
				<p>Насиченість</p>
				<div class="quality-properties">
					<?php
					$termSaturation = $product->get_attribute('pa_saturation-coffe');
					$termSaturation = get_term_by('slug', $termSaturation, 'pa_saturation-coffe');
					$imgCoffeSaturation = get_field('select_saturation_coffe', 'pa_saturation-coffe_' . $termSaturation->term_id);

					if ($imgCoffeSaturation == 'one') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-1.svg" alt="grain" width="127" height="10">
					<?php elseif ($imgCoffeSaturation == 'two') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-2.svg" alt="grain-two" width="127" height="10">
					<?php elseif ($imgCoffeSaturation == 'three') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-3.svg" alt="grain-three" width="127" height="10">
					<?php elseif ($imgCoffeSaturation == 'four') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-4.svg" alt="grain-four" width="127" height="10">
					<?php elseif ($imgCoffeSaturation == 'five') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-5.svg" alt="grain-five" width="127" height="10">
					<?php elseif ($imgCoffeSaturation == 'six') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-6.svg" alt="grain-six" width="127" height="10">
					<?php elseif ($imgCoffeSaturation == 'seven') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-7.svg" alt="grain-seven" width="127" height="10">
					<?php elseif ($imgCoffeSaturation == 'eight') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-8.svg" alt="grain-eight" width="127" height="10">
					<?php elseif ($imgCoffeSaturation == 'nine') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-9.svg" alt="grain-nine" width="127" height="10">
					<?php elseif ($imgCoffeSaturation == 'ten') : ?>
						<img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-10.svg" alt="grain-ten" width="127" height="10">
					<?php endif; ?>
				</div>
			</div>
			<!-- end saturation-coffe  -->

		</div>
	</div>


	<a class="goods-name-coffe" href="<?php echo get_permalink($product->get_id()); ?>"><?php echo $product->get_name(); ?></a>
	<p class="goods-desc-coffe">
		<?php echo $product->get_short_description(); ?>
	</p>

	<?php
	if ($product->is_type("variable") && $product->get_stock_status() == 'instock') :
		woocommerce_template_single_add_to_cart();

	elseif ($product->is_type("simple") && $product->get_stock_status() == 'instock') :
		woocommerce_template_loop_price();
		woocommerce_template_loop_add_to_cart();

	elseif ($product->get_stock_status() == 'outofstock') :
		woocommerce_template_loop_price();
	?>
		<p class="outofstock">Немає в наявності</p>
	<?php

	elseif ($product->get_stock_status() == 'onbackorder') :
		woocommerce_template_loop_price();
	?>
		<a href="<?php echo get_permalink($product->get_id()); ?>" class="price-basket">На замовлення</a>
	<?php
	endif;


	woocommerce_show_product_loop_sale_flash();
	?>
</div>