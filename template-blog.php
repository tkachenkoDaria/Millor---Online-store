<?php
/*
Template Name: Blog
Template Post Type: page
*/

get_header();
?>

<!-- Breadcrumb -->
<section class="offer-header-section offer-header-section_color">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
					<?php if (function_exists('bcn_display')) {
						bcn_display();
					} ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End breadcrumb -->

<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="ancor-wrapp">
					<a class="ancor" href="#learn"><?php esc_html_e('Навчання', 'millor'); ?></a>
					<a class="ancor" href="#filter-news"><?php esc_html_e('Новини', 'millor'); ?></a>
					<a class="ancor" href="#faq"><?php esc_html_e('Часті запитання', 'millor'); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="cooking">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2>
					<?php the_field('blog_all_title') ?>
				</h2>

			</div>

		</div>
		<?php get_template_part('template-file/content', 'cooking'); ?>
	</div>
</section>



<section id="learn">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="wrap-block-text-desc">
					<?php
					global $post;
					$myposts = get_posts([
						'numberposts' => 1,
						'category'    => 3
					]);

					if ($myposts) {
						foreach ($myposts as $post) {
							setup_postdata($post);

							the_content();
						}
					} else {
						esc_html_e('Записів не знайдено', 'millor');
					}

					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="filter-news" id="filter-news">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="wrapp-filter-news">
					<h3 class="filter-news-title"><?php esc_html_e('Новини:', 'millor'); ?></h3>
					<?php
					$all_categories = get_categories('hide_empty=0');
					$category_link_array = array();
					echo '<div class="news-category">';
					$first_category = true;
					foreach ($all_categories as $single_cat) {
						$active_class = $first_category ? 'class="active"' : '';
						$category_link_array[] = '<button ' . $active_class . ' value="' . $single_cat->term_id . '">' . $single_cat->name . '</button>';
						$first_category = false;
					}
					echo implode('', $category_link_array);
					echo '</div>';
					?>
				</div>

				<div class="wrapp-filter-news-posts">
					<?php
					global $post;
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

					$args = array(
						'posts_per_page' => 2,
						'paged' => $paged,
						'category__in' => 4,
					);
					$query = new WP_Query($args);

					if ($query->have_posts()) {
						while ($query->have_posts()) {
							$query->the_post();
							get_template_part('template-parts/content-filter-news', get_post_type());
						}
						$big = 999999999;
						echo '<div class="pagination-news">';
						echo wp_kses_post(paginate_links([
							'base'    => str_replace(
								$big,
								'%#%',
								esc_url(get_pagenum_link($big))
							),
							'current' => max(1, get_query_var('paged')),
							'total'   => $query->max_num_pages,
							'prev_text' => __('«', 'millor'),
							'next_text' => __('»', 'millor'),
						]));
						echo '</div>';
					}
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
</section>

<?php get_template_part('template-file/content', 'faq'); ?>

<?php
get_footer();
?>