<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package millor
 */

get_header();
?>

<main id="primary" class="site-main">
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

	<section class="single-blog">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php
					while (have_posts()) :
						the_post();
					?>
						<h1>
							<?php the_title(); ?>
						</h1>
						<?php the_content(); ?>

					<?php endwhile;  ?>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part('template-file/content', 'faq'); ?>


</main><!-- #main -->



<?php
get_footer();
