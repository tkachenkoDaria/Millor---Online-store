<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package millor
 */

get_header();
if (is_cart()) : ?>
	<div class="cart-woo">
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
			<?php
			while (have_posts()) :
				the_post();

				get_template_part('template-parts/content', 'page');

				// If comments are open or we have at least one comment, load up the comment template.
				if (comments_open() || get_comments_number()) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</div>
	</div>
<?php else : ?>


	<main id="primary" class="site-main">
		<div class="container">


			<?php
			while (have_posts()) :
				the_post();

				get_template_part('template-parts/content', 'page');

				// If comments are open or we have at least one comment, load up the comment template.
				if (comments_open() || get_comments_number()) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
		</div>
	</main><!-- #main -->

<?php
endif;
get_sidebar();
get_footer();
