<?php
/*
Template Name: Home
Template Post Type: post, page, product
*/

get_header();
?>

<section class="offer">
	<div class="container">
		<div class="col-lg-12">
			<div class="offer-wrapp">
				<?php if (have_rows('first_screen')) : ?>
					<?php while (have_rows('first_screen')) :
						the_row();

						$title = get_sub_field('home_title');
						$desk = get_sub_field('home_desc_one');
						$desk2 = get_sub_field('home_desc_two');;
						$link = get_sub_field('home_button');;
					?>

						<div class="offer-title">

							<?php if ($title) : ?>
								<h1>
									<?php echo $title; ?>
								</h1>
							<?php endif; ?>

							<?php if ($desk) : ?>
								<p><?php echo $desk; ?></p>
							<?php endif; ?>
							<?php if ($desk2) : ?>
								<p class="offer-desc">
									<?php echo $desk2; ?>
								</p>
							<?php endif;
							if ($link) :
								$link_url = $link['url'];
								$link_title = $link['title'];
								$link_target = $link['target'] ? $link['target'] : '_self';
							?>
								<a class="btn" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
							<?php endif; ?>

						</div>

						<div class="swiper swiper_head">
							<div class="swiper-wrapper">

								<?php if (have_rows('home_slides')) : ?>
									<?php while (have_rows('home_slides')) :
										the_row();
										$imageOne = get_sub_field('home_one_image');
										$imageTwo = get_sub_field('home_two_image');
									?>
										<div class="swiper-slide">
											<div class="swiper-slide__wrapp">
												<?php echo wp_get_attachment_image($imageOne, 'full', false, array('class' => 'swiper-slide__background')); ?>
												<?php echo wp_get_attachment_image($imageTwo, 'full', false, array('class' => 'swiper-slide__photo')); ?>
											</div>
										</div>
									<?php endwhile; ?>
								<?php endif; ?>

							</div>
							<div class="swiper-pagination"></div>
						</div>

					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
</section>
<section class="categories">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
				$title_catalog = get_field('home_first_screen_title');
				?>
				<?php if ($title_catalog) : ?>
					<h2>
						<?php echo $title_catalog; ?>
					</h2>
				<?php endif; ?>

			</div>
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
					if ($woo_cat_slug !== "all-product") {
				?>
						<a href="<?php echo get_term_link($woo_cat_id, 'product_cat'); ?>" class="col-lg-5 col-xl-3">
							<div class="category-card">
								<?php echo wp_get_attachment_image($category_thumbnail_id, 'medium, false'); ?>
								<h3>
									<?php echo $woo_cat_name; ?>
								</h3>
							</div>
						</a>

				<?php }
				} ?>

			</div>
		</div>
	</div>
</section>
<section class="catalog-product-sale">
	<div class="container">
		<div class="row">
			<?php
			$title_sale = get_field('home_two_screen_title');
			$sale_deck = get_field('home_two_screen_desc');;

			?>
			<div class="col-12">
				<div class="product-home-sale">
					<?php if ($title_sale) : ?>
						<h2>
							<?php echo $title_sale; ?>
						</h2>
					<?php endif; ?>
					<?php if ($sale_deck) : ?>
						<p>
							<?php echo $sale_deck; ?>
						</p>
					<?php endif; ?>

				</div>
			</div>
			<div class="col-lg-12" style="position:relative;">
				<div class="products-sale-wrapp">
					<?php the_field('home_shop_shortcode') ?>
					<div class="col-12 col-xl-11">
						<div class="swiper swiper_product-sale">
							<div class="swiper-wrapper">
								<?php
								$product_ids_on_sale = wc_get_product_ids_on_sale();

								$args = array(
									'post_type' => 'product',
									'post__in' => array_merge(array(0), $product_ids_on_sale)
								);
								$loop = new WP_Query($args);
								if ($loop->have_posts()) {
									while ($loop->have_posts()) : $loop->the_post();
										$categories = get_the_terms($post->ID, "product_cat");
										$product_vending = array(25, 110, 113, 111, 114, 112, 115, 116);
										$product_coffee_drinks = array(104, 24, 109, 107, 105, 108, 106, 103);
										$product_healthy = array(119, 120, 121, 117, 118);
										foreach ($categories as $category) {
											$cat_ids = $category->term_id;
											global $product;
											if ($cat_ids == 23) { ?>
												<div class="swiper-slide">
													<?php wc_get_template_part('content', 'archive-coffe'); ?>
												</div>
											<?php }

											if (in_array($cat_ids, $product_vending)) { ?>
												<div class="swiper-slide">
													<?php wc_get_template_part('content', 'archive-vending'); ?>
												</div>
											<?php }

											if (in_array($cat_ids, $product_coffee_drinks)) { ?>
												<div class="swiper-slide">
													<?php wc_get_template_part('content', 'archive-tea-healthy'); ?>
												</div>
											<?php }

											if (in_array($cat_ids, $product_healthy)) { ?>
												<div class="swiper-slide">
													<?php wc_get_template_part('content', 'archive-tea-healthy'); ?>
												</div>
								<?php }
										}
									endwhile;
								}
								wp_reset_postdata();
								?>

							</div>
							<div class="swiper-pagination swiper-pagination_product-cofe"></div>

						</div>
						<div class="swiper-button-wrap">
							<div class="swiper-button-next swiper-button-next_card-next"></div>
							<div class="swiper-button-prev swiper-button-prev_card-prev"></div>
						</div>
					</div>
				</div>
				<?php
				$link_product_all = get_field('home_shop_link');
				if ($link_product_all) :
					$link_url = $link_product_all['url'];
					$link_title = $link_product_all['title'];
					$link_target = $link_product_all['target'] ? $link_product_all['target'] : '_self';
				?>
					<a class="see-all" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
				<?php endif; ?>
				<span class="see-all__bottom-line"></span>
				</a>
			</div>
		</div>
	</div>
</section>

<section class="advantage">
	<div class="container">
		<div class="row">
			<div class="advantage-wrapper">

				<?php if (have_rows('home_peculiarities_group')) : ?>
					<?php while (have_rows('home_peculiarities_group')) :
						the_row();

						$image_bg = get_sub_field('home_peculiarities_img_left_bg');
						$image = get_sub_field('home_peculiarities_img_left');
						$title = get_sub_field('home_peculiarities_section_title');
					?>

						<div class="col-lg-4">
							<div class="advantage-img">
								<?php echo wp_get_attachment_image($image_bg['ID'], 'large', false, array('class' => 'advantage-img__coffe')); ?>
								<?php echo wp_get_attachment_image($image['ID'], 'large', false, array('class' => 'advantage-img__grain')); ?>
							</div>
						</div>
						<div class="col-12 col-xl-6 offset-xl-2">
							<div class="advantage-info">
								<h2 class="advantage-title">
									<?php echo $title; ?>
								</h2>

								<?php if (have_rows('home_peculiarities')) : ?>
									<?php while (have_rows('home_peculiarities')) :
										the_row();
										$image = get_sub_field('home_peculiarities_img');
										$title = get_sub_field('home_peculiarities_title');
										$text = get_sub_field('home_peculiarities_text');
									?>

										<div class="advantage-inner">
											<?php echo wp_get_attachment_image($image['ID'], 'full', false, array('class' => 'advantage-icon', 'width' => '84', 'height' => '84')); ?>
											<div class="advantage-list">
												<h3 class="advantage-list__title">
													<?php echo $title; ?>
												</h3>
												<p class="advantage-list__desc">
													<?php echo $text; ?>
												</p>
											</div>
										</div>

									<?php endwhile; ?>
								<?php endif; ?>

							</div>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<section class="info-coffe" style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),url(<?php the_field('home_info_coffe_img'); ?>) no-repeat center;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php
				$title_info_coffee = get_field('home_info_coffe_title');
				$text_info_coffee = get_field('home_info_coffe_text');
				$link_info_coffee = get_field('home_info_coffe_btn_name');
				?>
				<div class="roasting-coffee">
					<?php if ($title_info_coffee) : ?>
						<h2 class="roasting-coffee__title">
							<?php echo $title_info_coffee;  ?>
						</h2>
					<?php endif; ?>
					<?php if ($text_info_coffee) : ?>
						<div class="roasting-coffee__text">
							<?php echo $text_info_coffee ?>
						</div>
					<?php endif;
					if ($link_info_coffee) :
						$link_url = $link_info_coffee['url'];
						$link_title = $link_info_coffee['title'];
						$link_target = $link_info_coffee['target'] ? $link_info_coffee['target'] : '_self';
					?>
						<a class="roasting-coffee__btn" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="companys-news">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="companys-news-wrapp">
					<h2><?php esc_html_e('Новини компанії', 'millor'); ?></h2>
					<a href="/blog?_sft_category=tag-1" class="see-all"><?php esc_html_e('Дивитись усі', 'millor'); ?>
						<span class="see-all__bottom-line"></span>
					</a>
				</div>
			</div>

			<div class="col-12">
				<div class="news-home">

					<?php
					global $post;

					$myposts = get_posts([
						'include' => [125, 84, 123, 127],
						'orderby' => 'post__in',
					]);

					if ($myposts) {
						foreach ($myposts as $post) {
							setup_postdata($post);
							$post_thumbnail_id = get_post_thumbnail_id($post); // 123
					?>

							<div class="news-card">
								<?php if (has_post_thumbnail()) echo wp_get_attachment_image($post_thumbnail_id, 'large', false, array('class' => 'news-card__photo')); ?>

								<div class="news-card__info">
									<h3 class="news-card__title">
										<?php the_title(); ?>

									</h3>
									<div class="news-card__excerpt">
										<?php the_excerpt(); ?>
									</div>
									<a href="<?php the_permalink(); ?>" class="more"><?php esc_html_e('Детальніше', 'millor'); ?></a>
								</div>
							</div>
					<?php
						}
					}
					wp_reset_postdata();
					?>



				</div>
			</div>
		</div>
	</div>
</section>
<section class="social-instagram">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="instagram-title">
					<h2><?php esc_html_e('Ми в Instagram', 'millor'); ?></h2>
					<img src="<?php echo get_template_directory_uri() ?>/assets/img/social-instagram/instagram-icon.svg" alt="instagram-icon" width="86" height="86">
				</div>
			</div>
			<div class="social-instagram-wrapper">
				<div class="col-12 col-xl-4">
					<div class="apple-wrapp">
						<picture>
							<source srcset="<?php echo get_template_directory_uri() ?>/assets/img/social-instagram/айфон1.webp" type="image/webp">
							<img src="<?php echo get_template_directory_uri() ?>/assets/img/social-instagram/айфон1.png" alt="айфон1" width="399" height="755">
						</picture>
						<picture class="apple-two">
							<source srcset="<?php echo get_template_directory_uri() ?>/assets/img/social-instagram/айфон2.webp" type="image/webp">
							<img src="<?php echo get_template_directory_uri() ?>/assets/img/social-instagram/айфон2.png" alt="айфон2" class="apple-two" width="319" height="604">
						</picture>
					</div>
				</div>
				<div class="col-12 col-xl-8">
					<div class="swiper swiper_social-instagram">
						<div class="swiper-wrapper">
							<div class="swiper-slide swiper-slide_insta ">

								<div class="slider-img">1</div>
							</div>

							<div class="swiper-slide swiper-slide_insta">
								<div class="slider-img">2</div>
							</div>

							<div class="swiper-slide swiper-slide_insta">
								<div class="slider-img">3</div>
							</div>

							<div class="swiper-slide swiper-slide_insta">
								<div class="slider-img">4</div>
							</div>

							<div class="swiper-slide swiper-slide_insta">
								<div class="slider-img">5</div>
							</div>

							<div class="swiper-slide swiper-slide_insta">
								<div class="slider-img">6</div>
							</div>

							<div class="swiper-slide swiper-slide_insta">
								<div class="slider-img">7</div>
							</div>

							<div class="swiper-slide swiper-slide_insta">
								<div class="slider-img">8</div>
							</div>

							<div class="swiper-slide swiper-slide_insta">
								<div class="slider-img">9</div>
							</div>
						</div>
						<div class="swiper-button-wrap">
							<div class="swiper-button-next swiper-button-next_card-next s-b--n_insta"></div>
						</div>
						<div class="swiper-pagination swiper-pagination_instagram"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?php
get_footer();
?>