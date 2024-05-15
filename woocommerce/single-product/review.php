<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>
<li <?php comment_class('review-card'); ?> id="li-comment-<?php comment_ID(); ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container review-card__container">
		<div class="review-card__inner">
			<img src="<?php bloginfo('template_url'); ?>/assets/img/card-product-cofee/quote.svg" alt="icon-quote">
			<span> <time class="woocommerce-review__published-date"
					datetime="<?php echo esc_attr(get_comment_date('c')); ?>"><?php echo esc_html(get_comment_date(wc_date_format())); ?></time></span>
		</div>

		<?php woocommerce_review_display_rating() ?>
		<?php comment_text(); ?>
	</div>
	<div class="review-card__bottom">
		<?php do_action('woocommerce_review_before', $comment); ?>
		<div class="review-card__bottom_name">
			<p>
				<?php comment_author(); ?>
			</p>
			<?php comment_text(); ?>
		</div>
	</div>
</li>