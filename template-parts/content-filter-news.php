<div class="news-card">
    <?php if (has_post_thumbnail()) echo wp_get_attachment_image($post_thumbnail_id, 'large', false, array('class' => 'news-card__photo')); ?>

    <div class="news-card__info" style="max-width: 97%;">
        <h5 class="news-card__title">
            <?php the_title(); ?>
        </h5>
        <div class="news-card__excerpt">
            <?php the_excerpt(); ?>
        </div>
        <div class="news-card__inner">
            <p><?php esc_html_e('Автор статті:', 'millor'); ?> <?php the_author(); ?></p>
            <a href="<?php the_permalink(); ?>" class="more"><?php esc_html_e('Детальніше:', 'millor'); ?></a>
        </div>

    </div>
</div>