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
<div <?php wc_product_class('card-tea card-coffe card-coffe_catalog', $product); ?>>

    <div class="card-tea__wrapp-top">

        <div class="card-tea__items">
            <?php
            $rating_count = $product->get_rating_count();
            $review_count = $product->get_review_count();
            $average = $product->get_average_rating();

            if ($rating_count > 0) : ?>

                <div class="card-reviews card-reviews_coffe">
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

        </div>
    </div>
    <img class="card-vending-img" src="<?php echo wp_get_attachment_url($product->get_image_id()); ?>" alt="product">
    <a class="goods-name-coffe card-tea__name" href="<?php echo get_permalink($product->get_id()); ?>"> <?php echo $product->get_name(); ?></a>
    <p class="goods-desc-coffe card-tea__desc">
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

    ?>

    <?php
    woocommerce_show_product_loop_sale_flash();
    ?>

</div>