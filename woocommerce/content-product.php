<?php
/**
 * Product card in loops (shop, category)
 *
 * Uses product-card-plan design with WooCommerce product data.
 *
 * @package OptimumLift
 */

defined("ABSPATH") || exit;

global $product;

$args = optimumlift_get_plan_product_args($product);
if (!$args) {
  return;
}
?>

<li <?php wc_product_class("", $product); ?>>
  <?php get_template_part("template-parts/product-card-plan", null, $args); ?>
</li>
