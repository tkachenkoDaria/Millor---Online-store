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
                    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('product-card', $product); ?>>
                        <?php woocommerce_show_product_sale_flash() ?>
                        <div class="product-card__inner-img">
                            <?php woocommerce_show_product_images() ?>
                        </div>
                        <div class="product-card__content">
                            <div class="product-card__innet-grain">
                                <div class="grain-wrapp">
                                    <?php
                                    $termStrength = $product->get_attribute('pa_degree-of-roasting');
                                    $termStrength = get_term_by('slug', $termStrength, 'pa_degree-of-roasting');
                                    $imgCoffe = get_field('select_degree_of_roasting', 'pa_degree-of-roasting_' . $termStrength->term_id);
                                    if ($imgCoffe) : ?>
                                        <img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/grain/grain-<?php echo $imgCoffe ?>.svg" alt="grain">
                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="product-card__inner-title">
                                <h3 class="product-card__name">
                                    <?php echo $product->get_name(); ?>
                                </h3>

                                <?php
                                $output = array();
                                $terms = wp_get_post_terms($product->get_id(), 'product_tag');

                                if (count($terms) > 0) { ?>
                                    <div class="product-card__text-wrapp">
                                        <?php foreach ($terms as $term) {
                                            $term_id = $term->term_id;
                                            $term_name = $term->name;
                                            $output[] = '<span class="card-coffe__text">' . $term_name . '</span>';
                                        }
                                        $output = implode('', $output);
                                        echo $output; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <p class="product-card__desc-name">Мита, натуральна суміш</p>
                            <div class="product-card__inner-reviews">

                                <?php
                                $review_count = $product->get_review_count();
                                $rating_count = $product->get_rating_counts();
                                $average = $product->get_average_rating();

                                if ($rating_count && $average) : ?>

                                    <div class="card-reviews card-reviews_coffe product-card__card-reviews">
                                        <?php echo wc_get_rating_html($average, $rating_count); // WPCS: XSS ok. 
                                        ?>
                                    </div>

                                <?php endif; ?>
                                <?php if ($average): ?>
                                    <div class="response">
                                        <p>
                                            <?php echo $average; ?>
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
                                <?php endif; ?>
                                <!-- end rating -->
                            </div>

                            <div class="product-card__desc">
                                <?php echo $product->get_description(); ?>
                            </div>
                            <div class="product-card__inner-desc">
                                <div class="quality-coffe">
                                    <p class="product-card__quality">Кислинка</p>
                                    <div class="quality-properties">
                                        <?php
                                        $termQuality = $product->get_attribute('pa_quality-coffe');
                                        $termQuality = get_term_by('slug', $termQuality, 'pa_quality-coffe');
                                        $imgCoffeQuality = get_field('select_strength_coffe', 'pa_quality-coffe_' . $termQuality->term_id);
                                        if ($imgCoffeQuality) : ?>
                                            <img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-<?php echo $imgCoffeQuality; ?>.svg" alt="grain">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="quality-coffe">
                                    <p class="product-card__quality">Гірчинка</p>
                                    <div class="quality-properties">
                                        <?php
                                        $termMustard = $product->get_attribute('pa_mustard-coffe');
                                        $termMustard = get_term_by('slug', $termMustard, 'pa_mustard-coffe');
                                        $imgCoffeMustard = get_field('select_mustard_coffe', 'pa_mustard-coffe_' . $termMustard->term_id);
                                        if ($imgCoffeMustard): ?>
                                            <img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-<?php echo $imgCoffeMustard; ?>.svg" alt="grain">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="quality-coffe">
                                    <p class="product-card__quality">Насиченість</p>
                                    <div class="quality-properties">
                                        <?php
                                        $termSaturation = $product->get_attribute('pa_saturation-coffe');
                                        $termSaturation = get_term_by('slug', $termSaturation, 'pa_saturation-coffe');
                                        $imgCoffeSaturation = get_field('select_saturation_coffe', 'pa_saturation-coffe_' . $termSaturation->term_id);
                                        if ($imgCoffeSaturation): ?>
                                            <img src="<?php bloginfo('template_url'); ?>/assets/img/coffe-filter/properties-coffe/properties-<?php echo $imgCoffeSaturation; ?>.svg" alt="grain">
                                        <?php endif; ?>
                                    </div>
                                </div>
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
    </div>
</section>

<section class="ancor-links">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ancor-wrapp">
                    <a class="ancor" href="#desc">Опис</a>
                    <a class="ancor" href="#cook">Як готувати?</a>
                    <a class="ancor" href="#additionally">Додатково</a>
                    <a class="ancor" href="#review">Відгуки</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ancor-link">
    <div class="container" id="desc">
        <div class="row">
            <div class="decription-wrapp">
                <div class=" description-card description-card_width">
                    <div class="col-md-12 col-lg-4">
                        <h4 class="decriprion-card__title">Смак</h4>
                        <div class="decriprion-flex-wrapper">
                            <div class="decriprion-flex">
                                <img class="decriprion-icon" src="<?php bloginfo('template_url'); ?>/assets/img/description-icon.svg" alt="decriprion-icon">
                                <p class="decriprion-text">Шоколад</p>
                            </div>
                            <div class="decriprion-flex">
                                <img class="decriprion-icon" src="<?php bloginfo('template_url'); ?>/assets/img/description-icon.svg" alt="decriprion-icon">
                                <p class="decriprion-text">Яблуко</p>
                            </div>
                            <div class="decriprion-flex">
                                <img class="decriprion-icon" src="<?php bloginfo('template_url'); ?>/assets/img/description-icon.svg" alt="decriprion-icon">
                                <p class="decriprion-text">Какао</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="description-card">
                        <h4 class="decriprion-card__title decriprion-card__title_margin">Характеристики</h4>
                        <div class="decriprion-flex decriprion-flex_border">
                            <h5 class="decriprion-name">Арабіка:</h5>
                            <p class="decriprion-text-desc">Кіт Бразиліо, Перу гр.2, Ефіопія Сідамогр.4 Преміум
                                Амхара
                                Айєху</p>
                        </div>
                        <div class="decriprion-flex decriprion-flex_border">
                            <h5 class="decriprion-name">Робуста:</h5>
                            <p class="decriprion-text-desc">мита Індія, сухий В'єтнам</p>
                        </div>
                        <div class="decriprion-flex decriprion-flex_border">
                            <h5 class="decriprion-name">Спосіб обробки:</h5>
                            <p class="decriprion-text-desc">мита, суха</p>
                        </div>
                        <div class="decriprion-flex decriprion-flex_border">
                            <h5 class="decriprion-name">Вид кави:</h5>
                            <p class="decriprion-text-desc">суміш арабіка/робуста</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="decriprion-bottom-wrapp decriprion-bottom-wrapp_coffe">
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
    <!-- Cooking file -->
    <?php get_template_part('template-file/content', 'cooking', ['section_class' => 'cook-coffe', 'id' => 'cook']); ?>

    <!-- End cooking file -->

    <div class="container" id="additionally">
        <div class="row">
            <div class="col-12">
                <div class="wrap-block-text-desc">
                    <h3>Додатково</h3>
                    <p>Різноманітний та багатий досвід нова модель організаційної діяльності дозволяє оцінити
                        значення позицій, які займають
                        учасниками щодо поставлених завдань. Значимість цих проблем настільки очевидна, що
                        подальший розвиток
                        різних форм діяльності значною мірою зумовлює створення моделі розвитку.
                    </p>
                    <p>Завдання організації, особливо ж рамки та місце навчання кадрів сприяє підготовці та
                        реалізації систем масового
                        участі. Таким чином зміцнення та розвиток структури сприяє підготовці та реалізації
                        напрямів прогресивного
                        розвитку.</p>
                    <p>Товариші! реалізація намічених планових завдань забезпечує широкому колу (фахівців)
                        участь у формуванні
                        відповідних умов активізації. З іншого боку, реалізація намічених планових завдань
                        вимагають від нас аналізу
                        суттєвих фінансових та адміністративних умов.</p>
                    <img src="<?php bloginfo('template_url'); ?>/assets/img/card-product-cofee/deck-photo.png" alt="photo">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="wrap-block-text-desc">
                    <h3>Назва теми</h3>
                    <p>Різноманітний та багатий досвід нова модель організаційної діяльності дозволяє оцінити
                        значення позицій, які займають
                        учасниками щодо поставлених завдань. Значимість цих проблем настільки очевидна, що
                        подальший розвиток
                        різних форм діяльності значною мірою зумовлює створення моделі розвитку.
                    </p>
                    <p>Завдання організації, особливо ж рамки та місце навчання кадрів сприяє підготовці та
                        реалізації систем масового
                        участі. Таким чином зміцнення та розвиток структури сприяє підготовці та реалізації
                        напрямів прогресивного
                        розвитку.</p>
                    <p>Товариші! реалізація намічених планових завдань забезпечує широкому колу (фахівців)
                        участь у формуванні
                        відповідних умов активізації. З іншого боку, реалізація намічених планових завдань
                        вимагають від нас аналізу
                        суттєвих фінансових та адміністративних умов.</p>
                    <img src="<?php bloginfo('template_url'); ?>/assets/img/card-product-cofee/deck-photo-two.png" alt="photo">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="wrap-block-text-desc">
                    <h3>Назва теми</h3>
                    <p>Різноманітний та багатий досвід нова модель організаційної діяльності дозволяє оцінити
                        значення позицій, які займають
                        учасниками щодо поставлених завдань. Значимість цих проблем настільки очевидна, що
                        подальший розвиток
                        різних форм діяльності значною мірою зумовлює створення моделі розвитку.
                    </p>
                    <p>Завдання організації, особливо ж рамки та місце навчання кадрів сприяє підготовці та
                        реалізації систем масового
                        участі. Таким чином зміцнення та розвиток структури сприяє підготовці та реалізації
                        напрямів прогресивного
                        розвитку.</p>
                    <p>Товариші! реалізація намічених планових завдань забезпечує широкому колу (фахівців)
                        участь у формуванні
                        відповідних умов активізації. З іншого боку, реалізація намічених планових завдань
                        вимагають від нас аналізу
                        суттєвих фінансових та адміністративних умов.</p>
                    <img src="<?php bloginfo('template_url'); ?>/assets/img/card-product-cofee/deck-photo-three.png" alt="photo">
                </div>
            </div>
        </div>
    </div>


</section>
<!--  -->


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