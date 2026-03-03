<?php
/**
 * My Account navigation
 *
 * @package OptimumLift
 */

defined("ABSPATH") || exit;

do_action("woocommerce_before_account_navigation");
?>

<nav class="woocommerce-MyAccount-navigation shrink-0 lg:w-56" aria-label="<?php esc_attr_e("Account pages", "woocommerce"); ?>">
  <ul class="flex flex-wrap gap-2 lg:flex-col lg:gap-0 lg:border-r lg:border-gray-200 lg:pr-8">
    <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
      <li class="<?php echo esc_attr(wc_get_account_menu_item_classes($endpoint)); ?>">
        <a
          href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"
          class="<?php echo wc_is_current_account_menu_item($endpoint) ? block rounded-lg px-4 py-2 font-medium transition-colors hover:bg-gray-100 lg:py-2.5"bg-primary/10 text-primary" : "text-dark"; ?>"
          <?php echo wc_is_current_account_menu_item($endpoint) ? 'aria-current="page"' : ""; ?>
        >
          <?php echo esc_html($label); ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>

<?php do_action("woocommerce_after_account_navigation"); ?>
