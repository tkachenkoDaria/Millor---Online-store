<?php
function get_child_category_ids($parent_id) {
    $args = [
        'taxonomy'   => 'product_cat',
        'child_of'   => $parent_id,
        'hide_empty' => false,
    ];

    $terms = get_terms($args);
    $child_ids = [];
    foreach ($terms as $term) {
        $child_ids[] = $term->term_id;
    }

    return $child_ids;
}

$coffe_child_ids = get_child_category_ids(23);
$tea_and_coffee_drinks_child_ids = get_child_category_ids(24);
$products_for_vending_child_ids = get_child_category_ids(25);
$healthy_eating_child_ids = get_child_category_ids(26);

$product_cat = get_queried_object();
$product_cat_id = $product_cat->term_id;

if ($product_cat_id == 23 || in_array($product_cat_id, $coffe_child_ids)) : ?>
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
<?php elseif ($product_cat_id == 24 || in_array($product_cat_id, $tea_and_coffee_drinks_child_ids)): ?>
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
                        <h1>
                            <?php woocommerce_page_title(); ?>
                        </h1>
                    </div>
                    <div class="col-lg-5">
                        <div class="tea-photo-catalig">
                            <img class="tea-catalog-img" src="<?php bloginfo('template_url'); ?>/assets/img/tea-catalog/tea-offer.png" alt="tea-offer">
                            <!-- <picture><source srcset="img/offer/slider_one_one.webp" type="image/webp"><img class="coffe-catalog-img-bg" src="img/offer/slider_one_one.png" alt="coffe"></picture> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="section-bg section-bg_tea"></div>
    <?php show_child_category('tea-category-wrapp', 24, 'tea-and-coffee-drinks', 'tea-category-card', ''); ?>
<?php elseif ($product_cat_id == 25 || in_array($product_cat_id, $products_for_vending_child_ids)): ?>
    <section class="offer-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php woocommerce_breadcrumb(); ?>
                </div>
            </div>
            <div class="row">
                <div class="header-wrapper">
                    <div class="col-lg-8">
                        <h1>
                            <?php woocommerce_page_title(); ?>
                        </h1>
                    </div>
                    <div class="col-lg-4">
                        <div class="tea-photo-catalig">
                            <img class="tea-catalog-img" src="<?php bloginfo('template_url'); ?>/assets/img/vending-catalog/vending-offer.png" alt="tea-offer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="section-bg section-bg_tea"></div>
    <?php show_child_category('tea-category-wrapp', 25, 'products-for-vending', 'vending-category-card', 'tea-category-card'); ?>
<?php elseif ($product_cat_id == 26 || in_array($product_cat_id, $healthy_eating_child_ids)): ?>
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
                        <h1>
                            <?php woocommerce_page_title(); ?>
                        </h1>
                    </div>
                    <div class="col-lg-5">
                        <div class="tea-photo-catalig">
                            <img class="tea-catalog-img" src="<?php bloginfo('template_url'); ?>/assets/img/food-catalog/food.png" alt="tea-offer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="section-bg section-bg_tea"></div>
    <section class="tea-category">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php show_child_category('food-category-wrapp', 26, 'healthy-eating', 'food-catalog-card', ''); ?>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
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
    <?php show_child_category('categories-wrapp', 22, 'all-product', 'col-lg-5 col-xl-3', 'category-card', true); ?>
<?php endif; ?>