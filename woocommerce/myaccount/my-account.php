<?php
/**
 * My Account page wrapper
 *
 * @package OptimumLift
 */

defined("ABSPATH") || exit;
?>

<div class="custom-container py-10">
  <div class="flex flex-col gap-8 lg:flex-row lg:gap-12">
    <?php do_action("woocommerce_account_navigation"); ?>

    <div class="woocommerce-MyAccount-content min-w-0 flex-1">
      <?php do_action("woocommerce_account_content"); ?>
    </div>
  </div>
</div>
