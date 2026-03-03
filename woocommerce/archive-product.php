<?php
/**
 * Shop page template
 *
 * @package OptimumLift
 */

defined("ABSPATH") || exit;

get_header();
?>

<?php
/**
 * Hook: woocommerce_before_main_content
 */
do_action("woocommerce_before_main_content");
?>

<?php
/**
 * Hook: woocommerce_shop_loop_header (archive title, description)
 */
do_action("woocommerce_shop_loop_header");
?>

<?php if (woocommerce_product_loop()) : ?>

  <?php do_action("woocommerce_before_shop_loop"); ?>

  <?php woocommerce_product_loop_start(); ?>

  <?php
  while (have_posts()) {
    the_post();
    do_action("woocommerce_shop_loop");
    wc_get_template_part("content", "product");
  }
  ?>

  <?php woocommerce_product_loop_end(); ?>

  <?php do_action("woocommerce_after_shop_loop"); ?>

<?php else : ?>
  <?php do_action("woocommerce_no_products_found"); ?>
<?php endif; ?>

<?php do_action("woocommerce_after_main_content"); ?>

<?php
get_footer();
