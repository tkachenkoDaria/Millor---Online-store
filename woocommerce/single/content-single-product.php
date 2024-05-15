<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<section class="product-coffe">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-all-wrapp">

                    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('product-card product-card_all', $product); ?>>
                        <?php woocommerce_show_product_sale_flash() ?>
                        <div class="product-card__inner-img">
                            <?php woocommerce_show_product_images() ?>
                        </div>
                        <div class="product-card__content">
                            <div class="product-card__inner-title">
                                <h3 class="product-card__name">
                                    <?php echo $product->get_name(); ?>
                                </h3>

                            </div>
                            <p class="product-card__desc-name">Молочный улунг</p>
                            <div class="product-card__inner-reviews">

                                <?php
                                $rating_count = $product->get_rating_count();
                                $review_count = $product->get_review_count();
                                $average = $product->get_average_rating();

                                if ($rating_count > 0) : ?>

                                    <div class="card-reviews card-reviews_coffe product-card__card-reviews">
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

                            <div class="product-card__desc">
                                <?php echo $product->get_description(); ?>
                            </div>
                            <?php
                            if ($product->is_type("variable")) :
                                woocommerce_template_single_add_to_cart();

                            elseif ($product->is_type("simple")) :
                                woocommerce_template_single_price();
                                woocommerce_template_single_add_to_cart();

                            endif;
                            ?>



                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ancor-links">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ancor-wrapp">
                    <a class="ancor" href="#desc">Опис</a>
                    <a class="ancor" href="#cook">Як готувати?</a>
                    <a class="ancor" href="#review">Відгуки</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="ancor-link">
    <div class="container">
        <div class="decriprion-bottom-wrapp" id="desc">
            <div class="row">
                <div class="col-lg-8">
                    <p class="decriprion-bottom-text">Різноманітний та багатий досвід нова модель організаційної
                        діяльності дозволяє оцінити значення позицій, які займають учасники щодо поставлених
                        завдань.
                        Значимість цих проблем настільки очевидна, що розвиток різних форм діяльності значною мірою
                        зумовлює створення моделі розвитку.</p>
                    <p class="decriprion-bottom-text">Завдання організації, особливо ж рамки та місце навчання
                        кадрів
                        сприяє підготовці та реалізації систем масової участі. Таким чином зміцнення та розвиток
                        структури сприяє підготовці та реалізації напрямів прогресивного розвитку.</p>
                    <p class="decriprion-bottom-text">Товариші! Реалізація намічених планових завдань забезпечує
                        широкому колу (фахівцям) участь у формуванні відповідних умов активізації. З іншого боку,
                        реалізація намічених планових завдань вимагають від нас аналізу суттєвих фінансових та
                        адміністративних умов.</p>
                </div>
                <?php
                $photo_to_zoom = get_field('photo_to_zoom'); ?>
                <div class="col-lg-4">
                    <div class="open">
                        <button type="button" class="open__btn" id="open__btn">
                            <?php
                            if ($photo_to_zoom) :
                                echo  wp_get_attachment_image($photo_to_zoom['ID'], 'medium', false);
                            else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/click-sm.png" alt="photo" width="397" height="418">

                            <?php endif; ?>

                            <span class="overlay-photo"></span>
                        </button>
                    </div>
                    <div class="wrapper-modal" id="wrapper-modal">
                        <div class="overlay" id="overlay"></div>
                        <div class="close" id="close"></div>
                        <div class="content">
                            <?php
                            if ($photo_to_zoom) :
                                echo wp_get_attachment_image($photo_to_zoom['ID'], 'full', false, array('class' => 'content__photo'));
                            else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/card-product-cofee/card-product-cofee-two.png" class="content__photo" alt="photo" width="1300" height="1481">
                            <?php endif; ?>
                            <span class="close-img" id="close-img"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="border-bottom"></span>

    <div class="container" id="cook">
        <div class="row">
            <div class="col-12">
                <div class="wrap-block-text-desc">
                    <h3>Як готувати</h3>
                    <p>Різноманітний та багатий досвід нова модель організаційної діяльності дозволяє оцінити значення
                        позицій, які займають учасники щодо поставлених завдань. Значимість цих проблем настільки
                        очевидна, що розвиток різних форм діяльності значною мірою зумовлює створення моделі розвитку
                        ленних завдань. Значимість цих проблем настільки очевидна, що розвиток різних форм діяльності
                        значною мірою зумовлює створення моделі розвитку</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="review" id="review">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Відгуки</h3>
            </div>
            <div class="col-12">
                <div class="wprapper-review">
                    <?php woocommerce_output_product_data_tabs(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php do_action('woocommerce_after_single_product'); ?>