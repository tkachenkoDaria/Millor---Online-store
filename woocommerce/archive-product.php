<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');
global $wp_query;
$paged = !empty($_POST['paged']) ? $_POST['paged'] : 1;
$max_page     = $wp_query->max_num_pages;
?>
<section class="offer-header-section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php woocommerce_breadcrumb(); ?>
			</div>
		</div>
		<div class="row">
			<div class="header-wrapper header-wrapper_catalog">
				<div class="col-lg-7">
					<h1>
						<?php woocommerce_page_title(); ?>
					</h1>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="tea-category">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="categories-wrapp">
					<?php

					$prod_cat_args = array(
						'taxonomy' => 'product_cat',
						'orderby' => 'id',
						'hide_empty' => true,
						'parent' => 22
					);

					$woo_categories = get_categories($prod_cat_args);
					foreach ($woo_categories as $woo_cat) {
						$woo_cat_id = $woo_cat->term_id;
						$woo_cat_name = $woo_cat->name;
						$woo_cat_slug = $woo_cat->slug;
						$category_thumbnail_id = get_woocommerce_term_meta($woo_cat_id, 'thumbnail_id', true);
						$thumbnail_image_url = wp_get_attachment_url($category_thumbnail_id);
						if ($woo_cat_slug !== "all-product") {
					?>
							<a href="<?php echo get_term_link($woo_cat_id, 'product_cat'); ?>" class="col-lg-5 col-xl-3">
								<div class="category-card">
									<img src="<?php echo $thumbnail_image_url; ?>" alt="category-photo">
									<h5>
										<?php echo $woo_cat_name; ?>
									</h5>
								</div>
							</a>

					<?php }
					} ?>

				</div>
			</div>
		</div>
	</div>
</section>


<?php
/**
 * Hook: woocommerce_archive_description.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */
do_action('woocommerce_archive_description');

if (woocommerce_product_loop()) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action('woocommerce_before_shop_loop');
	do_action('woocommerce_before_shop_loop');

	woocommerce_product_loop_start();
?>
	<section class="card-coffe-catalog">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php woocommerce_catalog_ordering(); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="coffe-catalog-wrapp">
						<?php
						if (wc_get_loop_prop('total')) {
							while (have_posts()) {
								the_post();
								display_archive_product();
							}
						}
						?>
					</div>
				</div>
			</div>
			<?php if ($paged < $max_page) : ?>
				<div class="row see-more-product-row">
					<div class="col-12">
						<button type="button" id="more-product" data-page="<?php echo $paged; ?>" class="see-more-product"><?php esc_html_e('Показати ще', 'millor'); ?></button>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php
	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action('woocommerce_after_shop_loop');
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
