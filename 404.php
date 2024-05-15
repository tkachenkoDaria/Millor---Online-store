<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package millor
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">

		<div class="error-404">
			<h1 class="not-found">404</h1>
			<h2 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'millor'); ?></h2>

			<div class="page-content">
				<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'millor'); ?></p>

				</section><!-- .error-404 -->
			</div>
</main><!-- #main -->

<?php
get_footer();
