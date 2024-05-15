<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package millor
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="news-card">
            <?php
         
            if (has_post_thumbnail()) {
            ?>
                <img class="news-card__photo" src="<?php the_post_thumbnail_url(); ?>">
            <?php
            } else {
                echo '<img style="display:none;" class="news-card__photo" src="#">';
            }
            ?>
            <div class="news-card__info" style="max-width: 97%;">
                <h5 class="news-card__title">
                    <?php the_title(); ?>
                </h5>
                <div class="news-card__excerpt">
                    <?php the_excerpt(); ?>
                </div>
                <div class="news-card__inner">
                    <p><?php esc_html_e( 'Автор статті:', 'millor' ); ?> <?php the_author(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="more"><?php esc_html_e( 'Детальніше:', 'millor' ); ?></a>
                </div>

            </div>
        </div>
</article><!-- #post-<?php the_ID(); ?> -->