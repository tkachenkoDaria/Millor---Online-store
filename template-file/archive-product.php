<?php
global $product;
global $post;

$category_style = '';

if (empty($category_style)) {
    $categories = get_the_terms($post->ID, 'product_cat');

    if ($categories && !is_wp_error($categories)) {
        $category_id = $categories[0]->term_id;
        $category_style = get_field('style_category', 'product_cat_' . $category_id);
    }
} else {
    $category_id = get_queried_object_id();
    $category_style = get_field('style_category', 'product_cat_' . $category_id);
}





if ($category_style == 1): ?>
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
        $product_description = $product->get_short_description();
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
                $review_count = $product->get_review_count();
                $rating_count = $product->get_rating_counts();
                $average = $product->get_average_rating();
                if ($review_count && $average): ?>
                    <div class="response">
                        <p> <?php echo $average; ?></p>
                        <?php if (comments_open()) : ?>
                            <div class="woocommerce-review-link" rel="nofollow">(
                                <?php printf(_n('%s відгук', '%s відгука', $review_count, 'woocommerce'), '<span class="count">' . esc_html($review_count) . '</span>'); ?>)
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif; ?>
                <!-- end rating -->


                <!-- strength-coffe -->
                <div class="strength-coffe">
                    <?php
                    $termStrength = $product->get_attribute('pa_degree-of-roasting');
                    $termStrength = get_term_by('slug', $termStrength, 'pa_degree-of-roasting');
                    $imgCoffe = get_field('select_degree_of_roasting', 'pa_degree-of-roasting_' . $termStrength->term_id);
                    if ($imgCoffe): ?>
                        <img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/grain/grain-<?php echo $imgCoffe; ?>.svg" alt="grain" width="<?php echo $imgCoffe * 24 ?>" height="24">
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
                        if ($imgCoffeQuality): ?>
                            <img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-<?php echo $imgCoffeQuality; ?>.svg" alt="strength" width="127" height="24">
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
                        if ($imgCoffeMustard): ?>
                            <img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-<?php echo $imgCoffeMustard; ?>.svg" alt="grain" width="127" height="24">
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
                        if ($imgCoffeSaturation): ?>
                            <img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-<?php echo $imgCoffeSaturation; ?>.svg" alt="grain" width="127" height="24">
                        <?php endif; ?>
                    </div>
                </div>
                <!-- end saturation-coffe  -->

            </div>
        </div>


        <a class="goods-name-coffe" href="<?php echo get_permalink($product->get_id()); ?>"><?php echo $product->get_name(); ?></a>
        <?php if ($product_description): ?>
            <p class="goods-desc-coffe"> <?php echo $product_description; ?></p>
        <?php endif; ?>

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
<?php elseif ($category_style == 2): ?>

    <div <?php wc_product_class('card-tea card-coffe card-coffe_catalog', $product); ?>>

        <div class="card-tea__wrapp-top">

            <div class="card-tea__items">
                <?php
                if ($rating_count > 0) : ?>

                    <div class="card-reviews card-reviews_coffe">
                        <?php echo wc_get_rating_html($average, $rating_count);  ?>
                    </div>

                <?php endif; ?>
                <?php if ($average): ?>
                    <div class="response">
                        <p><?php echo $average; ?></p>
                        <?php if (comments_open()) : ?>
                            <div class="woocommerce-review-link" rel="nofollow">(
                                <?php printf(_n('%s відгук', '%s відгука', $review_count, 'woocommerce'), '<span class="count">' . esc_html($review_count) . '</span>'); ?>)
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif; ?>
                <!-- end rating -->

            </div>
        </div>
        <img class="card-vending-img" src="<?php echo wp_get_attachment_url($product->get_image_id()); ?>" alt="product">
        <a class="goods-name-coffe card-tea__name" href="<?php echo get_permalink($product->get_id()); ?>"> <?php echo $product->get_name(); ?></a>
        <?php if ($product_description): ?>
            <p class="goods-desc-coffe card-tea__desc"> <?php echo $product_description; ?></p>
        <?php endif; ?>


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
<?php elseif ($category_style == 3): ?>
    <div <?php wc_product_class('card-tea card-coffe card-coffe_catalog', $product); ?>>

        <div class="card-tea__wrapp-top">

            <div class="card-tea__items">
                <?php
                if ($rating_count > 0) : ?>
                    <div class="card-reviews card-reviews_coffe">
                        <?php echo wc_get_rating_html($average, $rating_count); ?>
                    </div>

                <?php endif; ?>
                <?php if ($average): ?>
                    <div class="response">
                        <p> <?php echo $average; ?></p>
                        <?php if (comments_open()) : ?>
                            <div class="woocommerce-review-link" rel="nofollow">(
                                <?php printf(_n('%s відгук', '%s відгука', $review_count, 'woocommerce'), '<span class="count">' . esc_html($review_count) . '</span>'); ?>)
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>
                <!-- end rating -->

            </div>
        </div>
        <img class="card-tea__img" src="<?php echo wp_get_attachment_url($product->get_image_id()); ?>" alt="product">
        <a href="<?php echo get_permalink($product->get_id()); ?>" class="goods-name-coffe card-tea__name"> <?php echo $product->get_name(); ?> </a>
        <?php if ($product_description): ?>
            <p class="goods-desc-coffe card-tea__desc"> <?php echo $product_description; ?></p>
        <?php endif; ?>



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
<?php endif; ?>