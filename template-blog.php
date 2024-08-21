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
					<?php $all_categories = get_categories('hide_empty=1'); ?>
					<div class="news-category">
						<?php
						$count_button = '';
						foreach ($all_categories as $categories) :
							$count_button++;
						?>
							<button <?php if ($count_button == 1) : ?> class="active" <?php endif; ?> data-category-news="<?php echo $categories->term_id; ?>" data-btn="<?php echo $count_button; ?>"><?php echo $categories->name; ?></button>
						<?php endforeach; ?>
					</div>
				</div>

			</div>

			<?php
			global $wp;
			$count_post_block = '';
			$paged_page = $wp_query->query["paged"];
			foreach ($all_categories as $categories) :
				$count_post_block++;
				$category_news = $categories->term_id;
			?>
				<div class="wrapp-filter-news-posts wrapp-filter-news-posts_<?php echo $count_post_block;
																			if ($count_post_block == 1) : ?> active<?php endif; ?>">
					<?php
					$args = array(
						'posts_per_page' => 2,
						'category__in' => $category_news,
					);
					$query = new WP_Query($args);

					if ($query->have_posts()) {
						while ($query->have_posts()) {
							$query->the_post();
							get_template_part('template-parts/content-filter-news', get_post_type());
						}
						
						pagination_news($query, max(1, get_query_var('paged')));
					}
					wp_reset_postdata();
					?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php get_template_part('template-file/content', 'faq'); ?>

<?php
get_footer();
?>