<?php

/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if (! defined('ABSPATH')) {
    exit;
}
$default_orderby = '';
?>
<form class="woocommerce-ordering" method="get">
    <select name="orderby" class="orderby orderby_select" aria-label="<?php esc_attr_e('Shop order', 'woocommerce'); ?>">
        <?php foreach ($catalog_orderby_options as $id => $name) : ?>
            <option value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>><?php echo esc_html($name); ?></option>
            <?php $default_orderby =  esc_html($name); ?>
        <?php endforeach; ?>
    </select>
    <!--  -->
    <button class="btn-select-open btn-select-open_orderby" type="button"><?php echo $default_orderby; ?></button>
    <ul class="select-list select-list_orderby" name="orderby" class="orderby" aria-label="<?php esc_attr_e('Shop order', 'woocommerce'); ?>">
        <?php foreach ($catalog_orderby_options as $id => $name) : ?>
            <li class="select-option select-list__item" value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>><?php echo esc_html($name); ?></li>
        <?php endforeach; ?>
    </ul>
    <!--  -->
    <input type="hidden" name="paged" value="1" />
    <?php wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
</form>