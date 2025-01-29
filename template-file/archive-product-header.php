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
    <div class="button-filter">
        <div class="container">
            <div class="button-filter-flex">
                <button type="button" class="open-filter">
                    <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_3015_2796)">
                            <path d="M43.729 0.289955C43.51 0.0699548 43.216 -0.0130452 42.93 0.0139548H1.099C0.813 -0.0120452 0.52 0.0709548 0.301 0.289955C0.211 0.379955 0.146 0.484955 0.098 0.595955C0.039 0.723955 0 0.863955 0 1.01395C0 1.30595 0.129 1.56295 0.329 1.74495L15 22.284V42.946C14.992 43.098 15.015 43.25 15.077 43.392C15.226 43.756 15.582 44.013 16 44.013C16.303 44.013 16.565 43.871 16.749 43.659L28.729 31.706C28.956 31.479 29.036 31.173 29 30.878V22.289L43.729 1.70595C44.121 1.31495 44.121 0.680955 43.729 0.289955ZM27.284 21.288C27.075 21.497 26.986 21.773 27 22.047V30.6L17 40.577V22.047C17.014 21.774 16.925 21.497 16.716 21.288L2.949 2.01395H41.077L27.284 21.288Z" fill="#E2A300" />
                        </g>
                        <defs>
                            <clipPath id="clip0_3015_2796">
                                <rect width="44.023" height="44.023" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <?php esc_html_e('Фільтр', 'millor'); ?>
                </button>
                <button type="button" class="btn-close-filter">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 7L25 25" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7 25L25 7" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>

            </div>


        </div>
    </div>
    <section class="coffe-filters">
        <div class="container">
            <div class="row">
                <div class="col-xl-3">
                    <div class="coffe-filter">
                        <div class="coffe-filter__wrapp">
                            <div class="coffe-filter__background"></div>
                            <div class="coffe-filter__contents">
                                <div class="coffe-filter__inner" id="grain">
                                    <?php attribute_woo('pa_degree-of-roasting', 'grain', 'render_term_filter_grain'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="coffe-filter coffe-filter_two">
                        <div class="coffe-filter__wrapp coffe-filter__wrapp_filter-two">
                            <div class="coffe-filter__background coffe-filter__background_filter-two"></div>
                            <div class="coffe-filter__content-wrapp">
                                <div class="coffe-filter__content" id="geography">
                                    <?php attribute_woo('pa_geography', 'geography', 'render_term_filter'); ?>
                                </div>
                                <div class="coffe-filter__content" id="kislinka">
                                    <?php attribute_woo('pa_sour-filter', 'kislinka', 'render_term_filter'); ?>
                                </div>
                                <div class="coffe-filter__content" id="method">
                                    <?php attribute_woo('pa_the-method-of-processing', 'method', 'render_term_filter'); ?>
                                </div>

                                <div class="coffe-filter__content" id="special">
                                    <?php display_all_product_tags(); ?>
                                </div>

                                <div class="coffe-filter__content" id="type-coffee">
                                    <?php attribute_woo('pa_type-coffee', 'type-coffee', 'render_term_filter'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end filter -->

    <!-- Cooking file -->
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