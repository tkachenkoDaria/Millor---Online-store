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
global $wp_query;
$paged = !empty($_POST['paged']) ? $_POST['paged'] : 1;
$max_page     = $wp_query->max_num_pages;
$product_cat = get_queried_object();
$cat_id = $product_cat->term_id;
get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

?>

<section class="offer-header-section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php woocommerce_breadcrumb(); ?>
      </div>
    </div>
    <div class="row">
      <div class="header-wrapper">
        <div class="col-lg-7">
          <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <h1 class="woocommerce-products-header__title page-title">
              <?php woocommerce_page_title(); ?>
            </h1>
          <?php endif; ?>
        </div>
        <div class="col-lg-5">
          <div class="coffe-photo-catalig">
            <img class="coffe-catalog-img" src="<?php bloginfo('template_url'); ?>/assets/img/offer/slider_one.png" alt="coffe">
            <img class="coffe-catalog-img-bg" src="<?php bloginfo('template_url'); ?>/assets//img/offer/slider_one_one.png" alt="coffe">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End breadcrumb -->



<!-- Filter -->
<section class="coffe-filters">
  <div class="container">
    <div class="coffe-filter">
      <?php echo do_shortcode('[br_filters_group group_id=294]'); ?>
      <div class="coffe-filter__inner">
        <?php echo do_shortcode('[br_filters_group group_id=273]'); ?>
      </div>
    </div>
  </div>
</section>
<!-- End filter -->




<!-- Cooking file -->
<div class="section-bg"></div>
<?php get_template_part('template-file/content', 'cooking'); ?>
<!-- End cooking file -->





<?php
/**
 * Hook: woocommerce_archive_description.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */
do_action('woocommerce_archive_description');
?>

<?php
if (woocommerce_product_loop()) {

  /**
   * Hook: woocommerce_before_shop_loop.
   *
   * @hooked woocommerce_output_all_notices - 10
   * @hooked woocommerce_result_count - 20
   * @hooked woocommerce_catalog_ordering - 30
   */
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

                /**
                 * Hook: woocommerce_shop_loop.
                 */

                do_action('woocommerce_shop_loop');
                wc_get_template_part('content', 'archive-coffe');

                global $product;
              }
            }
            ?>


          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <?php if ($paged < $max_page) : ?>
            <div class="row see-more-product-row">
              <div class="col-12">
                <button type="button" data-cat-id="<?php echo $cat_id; ?>" data-page="<?php echo $paged; ?>" id="more-product-category" class="see-more-product"><?php esc_html_e('Показати ще', 'millor'); ?></button>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
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
