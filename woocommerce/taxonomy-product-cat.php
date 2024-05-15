<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$product_cat = get_queried_object();

$array_coffee = array('tea-and-coffee-drinks' , 'green-tea' , 'coffee-drinks' , 'matcha' , 'milk-oolong' , 'puer' ,'herb-tea' , 'black-tea');

$array_vending = array('products-for-vending' , 'granulated-coffee' , 'granulated-cocoa' , 'granular-chicory' , 'granulated-coffee-drinks' , 'coffee-beans' , 'powdered-coffee' , 'powdered-milk-granulated');

$array_healthy = array('healthy-eating', 'chicory-and-chicory-root', 'barley-drinks', 'drinks-for-health', 'protein-mixtures', 'porridge-porridge');

if ( $product_cat->slug == 'freshly-roasted-coffee' ) {
	get_template_part( 'woocommerce/taxonomy-product-cat/freshly-roasted-coffee' );

} elseif ( in_array($product_cat->slug, $array_coffee)) {
	get_template_part( 'woocommerce/taxonomy-product-cat/tea-and-coffee-drinks' );

} elseif (  in_array($product_cat->slug, $array_vending)) {
	get_template_part( 'woocommerce/taxonomy-product-cat/products-for-vending' );

} elseif ( in_array($product_cat->slug, $array_healthy) ) {
	get_template_part( 'woocommerce/taxonomy-product-cat/healthy-eating' );

} else {
	wc_get_template( 'archive-product.php' );

}