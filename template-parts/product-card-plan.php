<?php

/**
 * Product Card for Workout/Diet Plans
 *
 * All product data is fetched from WooCommerce via optimumlift_get_plan_product_args().
 * Only "badge" is passed manually (e.g. "Best Seller").
 *
 * @param array $args {
 *   @type string   $image_url      Product thumbnail URL (from WC)
 *   @type string   $title          Product name (from WC)
 *   @type string   $regular_price  Regular price value (from WC)
 *   @type string   $sale_price     Sale price value, empty if not on sale (from WC)
 *   @type string   $currency       Currency symbol e.g. "$" (from WC)
 *   @type array    $categories     Product category names (from product_cat taxonomy)
 *   @type string   $duration       e.g. "12 weeks" (from ACF range field)
 *   @type array    $levels         Experience level terms (from "Experience Level" attribute)
 *   @type string   $link           Product permalink (from WC)
 *   @type string   $excerpt        Short description (from WC)
 *   @type array    $goals          Goal tags (from "Goal" attribute)
 *   @type float    $rating         Average rating 0-5 (from WC)
 *   @type int      $review_count   Number of reviews (from WC)
 *   @type string   $badge          Optional static badge e.g. "Best Seller"
 * }
 */
$args = wp_parse_args($args ?? [], [
  "image_url"      => "",
  "title"          => "",
  "regular_price"  => "",
  "sale_price"     => "",
  "currency"       => "$",
  "categories"     => [],
  "duration"       => "",
  "levels"         => [],
  "link"           => "#",
  "excerpt"        => "",
  "goals"          => [],
  "rating"         => 0,
  "review_count"   => 0,
  "badge"          => "",
]);

$on_sale = $args["sale_price"] !== "" && $args["sale_price"] !== $args["regular_price"];
$save_pct = $on_sale && (float) $args["regular_price"] > 0
  ? round((1 - (float) $args["sale_price"] / (float) $args["regular_price"]) * 100)
  : 0;
$rating = min(5, max(0, round((float) $args["rating"] * 2) / 2));
$full_stars = (int) floor($rating);
$half_star = ($rating - $full_stars) >= 0.5;
$empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
$template_uri = get_template_directory_uri() . '/assets/images/';
?>

<a href="<?php echo esc_url($args["link"]); ?>" class="group flex h-full flex-col rounded-2xl border border-slate-200 bg-white transition-all duration-300 hover:border-slate-300 hover:shadow-lg">
  <div class="relative overflow-hidden rounded-t-2xl before:absolute before:inset-0 before:z-10 before:bg-black/20 before:content-['']">
    <?php if (!empty($args["image_url"])) : ?>
      <img loading="lazy" class="h-64 w-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?php echo esc_url($args["image_url"]); ?>" alt="<?php echo esc_attr($args["title"]); ?>">
    <?php endif; ?>
    <?php if (!empty($args["categories"])) : ?>
      <div class="absolute top-3 left-3 z-10 flex flex-wrap gap-1">
        <?php foreach ($args["categories"] as $category) : ?>
          <div class="rounded-md bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-blue-600"><?php echo esc_html($category); ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <?php if (!empty($args["badge"])) : ?>
      <div class="absolute top-3 right-3 z-10">
        <div class="text-brand-700 bg-brand-50 rounded-full px-2.5 py-1 text-xs font-bold"><?php echo esc_html($args["badge"]); ?></div>
      </div>
    <?php endif; ?>
    <div class="absolute bottom-3 left-3 z-10 flex items-center gap-1">
      <?php if (!empty($args["duration"])) : ?>
        <div class="flex items-center gap-1 rounded-md bg-slate-100 px-1 py-0.5 text-xs font-medium text-slate-500"> <span><img src="<?php echo esc_url($template_uri . 'clock.svg'); ?>" width="14" height="14" alt="" class="size-3.5"></span><?php echo esc_html($args["duration"]); ?></div>
      <?php endif; ?>
      <?php foreach ($args["levels"] as $level) : ?>
        <div class="rounded-md bg-slate-100 px-1 py-0.5 text-xs font-medium text-slate-500"><?php echo esc_html($level); ?></div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="flex min-h-0 flex-1 flex-col p-6">
    <div class="flex-1">
      <?php if (!empty($args["title"])) : ?>
        <h3 class="group-hover:text-brand-600 line-clamp-2 text-lg font-bold text-slate-900 transition-colors"><?php echo esc_html($args["title"]); ?></h3>
      <?php endif; ?>
      <?php if ($args["rating"] > 0) : ?>
        <div class="mt-1.5 flex items-center gap-1.5">
          <div class="flex items-center gap-0.5" role="img" aria-label="<?php echo esc_attr($rating); ?> out of 5 stars">
            <?php
            for ($i = 0; $i < $full_stars; $i++) {
              echo '<img src="' . esc_url($template_uri . 'star-filled.svg') . '" width="14" height="14" alt="" class="size-3.5">';
            }
            if ($half_star) {
              echo '<img src="' . esc_url($template_uri . 'star-filled.svg') . '" width="14" height="14" alt="" class="size-3.5 opacity-50">';
            }
            for ($i = 0; $i < $empty_stars; $i++) {
              echo '<img src="' . esc_url($template_uri . 'star-empty.svg') . '" width="14" height="14" alt="" class="size-3.5">';
            }
            ?>
          </div>
          <?php if ($args["review_count"] > 0) : ?>
            <span class="text-xs text-slate-400">(<?php echo (int) $args["review_count"]; ?>)</span>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($args["excerpt"])) : ?>
        <p class="mt-2 line-clamp-4 text-sm leading-relaxed text-slate-500"><?php echo esc_html($args["excerpt"]); ?></p>
      <?php endif; ?>
      <?php if (!empty($args["goals"])) : ?>
        <div class="no-scrollbar mt-3 flex items-center gap-1.5 overflow-x-auto">
          <?php foreach ($args["goals"] as $goal) : ?>
            <span class="rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium whitespace-nowrap text-slate-500"><?php echo esc_html($goal); ?></span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="mt-5 flex shrink-0 items-center justify-between border-t border-slate-100 pt-4">
      <div class="flex items-baseline gap-2">
        <?php if ($on_sale) : ?>
          <span class="text-brand-600 text-2xl font-extrabold"><?php echo esc_html($args["currency"] . $args["sale_price"]); ?></span>
          <span class="text-sm text-slate-400 line-through"><?php echo esc_html($args["currency"] . $args["regular_price"]); ?></span>
          <?php if ($save_pct > 0) : ?>
            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-700">Save <?php echo $save_pct; ?>%</span>
          <?php endif; ?>
        <?php else : ?>
          <span class="text-2xl font-extrabold text-slate-900"><?php echo esc_html($args["currency"] . $args["regular_price"]); ?></span>
        <?php endif; ?>
      </div>
      <span class="btn-primary group-hover:shadow-brand-500/30 px-4! py-2! text-sm transition-all duration-200 group-hover:-translate-y-0.5 group-hover:shadow-lg">
        Buy Now
      </span>
    </div>
  </div>
</a>