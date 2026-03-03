<?php
/**
 * Cart drawer - slide-out panel with mini cart
 *
 * @package OptimumLift
 */

if (!function_exists("WC") || !WC()->cart) {
  return;
}
?>

<div id="cart-drawer" class="cart-drawer pointer-events-none fixed inset-0 z-50 opacity-0 transition-opacity duration-300" aria-hidden="true">
  <div class="cart-drawer-overlay absolute inset-0 bg-black/40" aria-hidden="true"></div>
  <div class="cart-drawer-panel absolute top-0 right-0 flex h-full w-full max-w-md translate-x-full flex-col bg-white shadow-xl transition-transform duration-300" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Shopping cart', 'woocommerce'); ?>">
    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-4">
      <h2 class="font-primary text-dark text-lg font-semibold">
        <?php esc_html_e("Your Cart", "woocommerce"); ?>
        <?php if (WC()->cart && !WC()->cart->is_empty()) : ?>
          <span class="text-primary ml-2">(<?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>)</span>
        <?php endif; ?>
      </h2>
      <button type="button" class="cart-drawer-close flex size-10 items-center justify-center rounded-full transition-colors hover:bg-gray-100" aria-label="<?php esc_attr_e('Close cart', 'woocommerce'); ?>">
        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <div class="flex-1 overflow-y-auto p-4">
      <div class="widget_shopping_cart_content">
        <?php woocommerce_mini_cart(); ?>
      </div>
    </div>
  </div>
</div>
