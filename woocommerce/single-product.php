<?php
/**
 * Single product page template
 *
 * @package OptimumLift
 */

defined("ABSPATH") || exit;

get_header();

while (have_posts()) :
  the_post();

  global $product;
  if (!is_a($product, WC_Product::class)) {
    $product = wc_get_product(get_the_ID());
  }
  if (!$product) continue;

  $product_id   = $product->get_id();
  $template_uri = get_template_directory_uri() . '/assets/images/';
  $currency     = get_woocommerce_currency_symbol();

  // WooCommerce native data
  $title         = $product->get_name();
  $regular_price = $product->get_regular_price();
  $sale_price    = $product->get_sale_price();
  $on_sale       = $sale_price !== '' && $sale_price !== $regular_price;
  $display_price = $on_sale ? $sale_price : $regular_price;
  $rating        = (float) $product->get_average_rating();
  $review_count  = (int) $product->get_review_count();

  // Categories
  $categories = [];
  $terms = get_the_terms($product_id, 'product_cat');
  if ($terms && !is_wp_error($terms)) {
    $categories = wp_list_pluck($terms, 'name');
  }

  // Experience levels & goals from attributes
  $levels_raw = $product->get_attribute('Experience Level');
  $levels     = $levels_raw ? array_map('trim', explode(',', $levels_raw)) : [];
  $goals_raw  = $product->get_attribute('Goal');
  $goals      = $goals_raw ? array_map('trim', explode(',', $goals_raw)) : [];

  // Duration
  $duration       = '';
  $duration_field  = get_field('duration', $product_id);
  if (is_array($duration_field)) {
    $min = $duration_field['min'] ?? null;
    $max = $duration_field['max'] ?? null;
    if ($min !== null && $max !== null && $min !== $max) {
      $duration = sprintf('%d–%d Weeks', (int) $min, (int) $max);
    } elseif ($min !== null) {
      $duration = sprintf('%d Weeks', (int) $min);
    } elseif ($max !== null) {
      $duration = sprintf('%d Weeks', (int) $max);
    }
  } elseif (is_numeric($duration_field)) {
    $duration = sprintf('%d Weeks', (int) $duration_field);
  }

  // ACF fields
  $badge              = get_field('product_badge', $product_id) ?: '';
  $hero_desc          = get_field('product_long_description', $product_id) ?: $product->get_short_description();
  $days_per_week      = get_field('days_per_week', $product_id) ?: '';
  $guarantee_label    = get_field('product_guarantee', $product_id) ?: '';

  // Gallery images
  $main_image_id  = $product->get_image_id();
  $gallery_ids    = $product->get_gallery_image_ids();
  $all_image_ids  = $main_image_id ? array_merge([$main_image_id], $gallery_ids) : $gallery_ids;

  // Sections
  $stats_heading     = get_field('product_stats_heading', $product_id) ?: "What You'll Achieve";
  $stats_description = get_field('product_stats_description', $product_id) ?: '';
  $stats             = get_field('achievement_stats', $product_id) ?: [];

  $inside_heading     = get_field('whats_inside_heading', $product_id) ?: 'Everything Inside the Program';
  $inside_description = get_field('whats_inside_description', $product_id) ?: '';
  $features           = get_field('whats_inside_features', $product_id) ?: [];

  $wif_heading     = get_field('who_its_for_heading', $product_id) ?: 'Is This Program Right for You?';
  $wif_description = get_field('who_its_for_description', $product_id) ?: '';
  $for_items       = get_field('for_you_items', $product_id) ?: [];
  $not_for_items   = get_field('not_for_you_items', $product_id) ?: [];

  $testimonials_heading = get_field('product_testimonials_heading', $product_id) ?: 'What Members Are Saying';
  $testimonials         = get_field('product_testimonials', $product_id) ?: [];

  $pricing_heading     = get_field('pricing_heading', $product_id) ?: 'Get ' . $title;
  $pricing_description = get_field('pricing_description', $product_id) ?: 'One-time payment. Lifetime access. Instant download.';
  $pricing_features    = get_field('pricing_features', $product_id) ?: [];

  $faq_heading = get_field('product_faq_heading', $product_id) ?: 'Questions About This Program';
  $faqs        = get_field('product_faqs', $product_id) ?: [];

  $cta_label = 'Get This Program — ' . $currency . $display_price;
?>

<!-- ======================== PRODUCT HERO ======================== -->
<section class="relative overflow-hidden bg-slate-950">
  <div class="absolute inset-0">
    <div class="bg-brand-500/[0.05] absolute top-1/3 left-1/2 h-[700px] w-[700px] -translate-x-1/2 -translate-y-1/2 rounded-full blur-3xl"></div>
  </div>
  <div class="relative mx-auto max-w-7xl px-5 pt-8 pb-16 sm:px-6 lg:px-8 lg:pt-12 lg:pb-24">
    <div class="items-center lg:grid lg:grid-cols-2 lg:gap-16">
      <!-- Left: Copy -->
      <div class="max-w-xl">
        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="group mb-6 inline-flex items-center gap-2 text-sm text-slate-400 transition-colors hover:text-white">
          <svg class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
          All Programs
        </a>
        <div class="mb-5 flex flex-wrap items-center gap-2">
          <?php foreach ($categories as $cat) : ?>
            <span class="rounded-full bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-400"><?php echo esc_html($cat); ?></span>
          <?php endforeach; ?>
          <?php if ($badge) : ?>
            <span class="bg-brand-500/10 text-brand-400 rounded-full px-3 py-1 text-xs font-semibold"><?php echo esc_html($badge); ?></span>
          <?php endif; ?>
        </div>
        <h1 class="text-3xl font-extrabold leading-[1.15] tracking-tight text-white sm:text-4xl lg:text-5xl">
          <?php echo esc_html($title); ?>
        </h1>
        <?php if ($hero_desc) : ?>
          <p class="mt-5 text-lg leading-relaxed text-slate-400"><?php echo wp_kses_post($hero_desc); ?></p>
        <?php endif; ?>
        <!-- Meta tags -->
        <div class="mt-6 flex flex-wrap gap-3">
          <?php if ($duration) : ?>
            <div class="flex items-center gap-2 rounded-lg border border-white/[0.06] bg-white/5 px-3.5 py-2 text-sm text-slate-300">
              <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
              <?php echo esc_html($duration); ?>
            </div>
          <?php endif; ?>
          <?php foreach ($levels as $level) : ?>
            <div class="flex items-center gap-2 rounded-lg border border-white/[0.06] bg-white/5 px-3.5 py-2 text-sm text-slate-300">
              <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
              <?php echo esc_html($level); ?>
            </div>
          <?php endforeach; ?>
          <?php foreach ($goals as $goal) : ?>
            <div class="flex items-center gap-2 rounded-lg border border-white/[0.06] bg-white/5 px-3.5 py-2 text-sm text-slate-300">
              <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/></svg>
              <?php echo esc_html($goal); ?>
            </div>
          <?php endforeach; ?>
          <?php if ($days_per_week) : ?>
            <div class="flex items-center gap-2 rounded-lg border border-white/[0.06] bg-white/5 px-3.5 py-2 text-sm text-slate-300">
              <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              <?php echo esc_html($days_per_week); ?>
            </div>
          <?php endif; ?>
        </div>
        <!-- Desktop CTA -->
        <div class="mt-8 hidden lg:block" id="hero-cta">
          <div class="flex items-center gap-5">
            <a href="#buy" class="shadow-brand-500/25 hover:shadow-brand-500/30 bg-brand-500 hover:bg-brand-600 inline-flex items-center gap-2 rounded-xl px-8 py-4 text-lg font-semibold text-white shadow-lg transition-all hover:-translate-y-0.5 hover:shadow-xl">
              <?php echo esc_html($cta_label); ?>
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
            <?php if ($guarantee_label) : ?>
              <div class="text-sm text-slate-500">
                <div class="flex items-center gap-1.5">
                  <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                  <?php echo esc_html($guarantee_label); ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
          <div class="mt-4 flex items-center gap-4 text-sm text-slate-500">
            <?php if ($rating > 0) : ?>
              <div class="flex items-center gap-1">
                <svg class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="text-slate-400"><?php echo number_format($rating, 1); ?>/5</span>
              </div>
              <span class="text-slate-700">&middot;</span>
            <?php endif; ?>
            <?php if ($review_count > 0) : ?>
              <span class="text-slate-400"><?php echo number_format($review_count); ?>+ reviews</span>
              <span class="text-slate-700">&middot;</span>
            <?php endif; ?>
            <span class="text-slate-400">Instant access</span>
          </div>
        </div>
      </div>
      <!-- Right: Product Image Gallery -->
      <div class="mt-10 lg:mt-0">
        <?php if (!empty($all_image_ids)) : ?>
          <div class="splide overflow-hidden rounded-2xl border border-white/[0.06]" id="product-gallery-slider">
            <div class="splide__track">
              <ul class="splide__list">
                <?php foreach ($all_image_ids as $img_id) :
                  $img_url = wp_get_attachment_image_url($img_id, 'large');
                  $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $title;
                ?>
                  <li class="splide__slide">
                    <img class="aspect-[4/3] w-full object-cover" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>">
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <?php if (count($all_image_ids) > 1) : ?>
            <div class="mt-3 grid grid-cols-<?php echo min(count($all_image_ids), 5); ?> gap-2" id="product-gallery-thumbs">
              <?php foreach ($all_image_ids as $idx => $img_id) :
                $thumb_url = wp_get_attachment_image_url($img_id, 'thumbnail');
              ?>
                <button class="product-thumb cursor-pointer overflow-hidden rounded-lg border-2 transition-all <?php echo $idx === 0 ? 'border-brand-500' : 'border-transparent opacity-60 hover:opacity-100'; ?>" data-index="<?php echo (int) $idx; ?>">
                  <img class="aspect-square w-full object-cover" src="<?php echo esc_url($thumb_url); ?>" alt="">
                </button>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        <?php else : ?>
          <div class="flex aspect-[4/3] items-center justify-center rounded-2xl border border-white/[0.06] bg-slate-900">
            <svg class="h-16 w-16 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a2.25 2.25 0 002.25-2.25V5.25a2.25 2.25 0 00-2.25-2.25H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
          </div>
        <?php endif; ?>
        <!-- Mobile CTA -->
        <div class="mt-6 lg:hidden">
          <a href="#buy" class="shadow-brand-500/25 bg-brand-500 hover:bg-brand-600 flex w-full items-center justify-center gap-2 rounded-xl px-6 py-4 text-lg font-semibold text-white shadow-lg transition-all">
            <?php echo esc_html($cta_label); ?>
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
          </a>
          <div class="mt-3 flex items-center justify-center gap-4 text-xs text-slate-500">
            <?php if ($guarantee_label) : ?>
              <span><?php echo esc_html($guarantee_label); ?></span>
              <span>&middot;</span>
            <?php endif; ?>
            <?php if ($rating > 0) : ?>
              <span><?php echo number_format($rating, 1); ?>/5 rating</span>
              <span>&middot;</span>
            <?php endif; ?>
            <span>Instant access</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ======================== SOCIAL PROOF BAR ======================== -->
<?php if ($rating > 0 || $review_count > 0) : ?>
  <section class="border-y border-slate-200 bg-slate-50">
    <div class="mx-auto max-w-7xl px-5 py-5 sm:px-6 lg:px-8">
      <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-sm text-slate-500">
        <?php if ($review_count > 0) : ?>
          <div class="flex items-center gap-2">
            <span><strong class="text-slate-700"><?php echo number_format($review_count); ?></strong> people completed this program</span>
          </div>
          <span class="hidden text-slate-300 sm:inline">|</span>
        <?php endif; ?>
        <?php if ($rating > 0) : ?>
          <div class="flex items-center gap-1.5">
            <div class="flex gap-0.5">
              <?php
              $full  = (int) floor($rating);
              $empty = 5 - $full;
              for ($i = 0; $i < $full; $i++) {
                echo '<svg class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
              }
              for ($i = 0; $i < $empty; $i++) {
                echo '<svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
              }
              ?>
            </div>
            <span><strong class="text-slate-700"><?php echo number_format($rating, 1); ?></strong> average rating</span>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- ======================== WHAT YOU'LL ACHIEVE ======================== -->
<?php if (!empty($stats)) : ?>
  <section class="section-spacing bg-white">
    <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
      <div class="fade-up mx-auto max-w-3xl text-center">
        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl"><?php echo highlight_text($stats_heading); ?></h2>
        <?php if ($stats_description) : ?>
          <p class="mt-4 text-lg leading-relaxed text-slate-600"><?php echo esc_html($stats_description); ?></p>
        <?php endif; ?>
      </div>
      <div class="fade-up mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-<?php echo min(count($stats), 4); ?>">
        <?php foreach ($stats as $stat) : ?>
          <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6 text-center">
            <div class="text-3xl font-extrabold text-slate-900"><?php echo esc_html($stat['stat_value']); ?></div>
            <div class="mt-1 text-sm text-slate-500"><?php echo esc_html($stat['stat_label']); ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- ======================== WHAT'S INSIDE ======================== -->
<?php if (!empty($features)) : ?>
  <section class="section-spacing bg-slate-50">
    <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
      <div class="fade-up mx-auto max-w-3xl text-center">
        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl"><?php echo highlight_text($inside_heading); ?></h2>
        <?php if ($inside_description) : ?>
          <p class="mt-4 text-lg text-slate-600"><?php echo esc_html($inside_description); ?></p>
        <?php endif; ?>
      </div>
      <div class="fade-up mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($features as $feature) :
          $icon  = $feature['feature_icon'] ?? '';
          $ftitle = $feature['feature_title'] ?? '';
          $fdesc  = $feature['feature_description'] ?? '';
        ?>
          <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <?php if ($icon) : ?>
              <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">
                <img class="h-5 w-5" src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($ftitle); ?>">
              </div>
            <?php endif; ?>
            <h3 class="mb-1 font-bold text-slate-900"><?php echo esc_html($ftitle); ?></h3>
            <p class="text-sm leading-relaxed text-slate-500"><?php echo esc_html($fdesc); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- ======================== WHO IT'S FOR ======================== -->
<?php if (!empty($for_items) || !empty($not_for_items)) : ?>
  <section class="section-spacing bg-slate-950">
    <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
      <div class="items-start gap-12 lg:grid lg:grid-cols-2 lg:gap-20">
        <div class="fade-up">
          <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl"><?php echo highlight_text($wif_heading); ?></h2>
          <?php if ($wif_description) : ?>
            <p class="mt-4 text-lg leading-relaxed text-slate-400"><?php echo esc_html($wif_description); ?></p>
          <?php endif; ?>
        </div>
        <div class="fade-up mt-10 space-y-6 lg:mt-0">
          <?php if (!empty($for_items)) : ?>
            <div>
              <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-400">This is for you if:</h3>
              <ul class="space-y-3">
                <?php foreach ($for_items as $item) : ?>
                  <li class="flex items-start gap-3 text-slate-300">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <?php echo esc_html($item['item_text']); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          <?php if (!empty($not_for_items)) : ?>
            <div>
              <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-red-400">This is not for you if:</h3>
              <ul class="space-y-3">
                <?php foreach ($not_for_items as $item) : ?>
                  <li class="flex items-start gap-3 text-slate-400">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-400/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    <?php echo esc_html($item['item_text']); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- ======================== TESTIMONIALS ======================== -->
<?php if (!empty($testimonials)) : ?>
  <section class="section-spacing bg-slate-50">
    <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
      <div class="fade-up text-center">
        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl"><?php echo highlight_text($testimonials_heading); ?></h2>
      </div>
      <div class="fade-up mt-12 grid gap-6 md:grid-cols-3">
        <?php foreach ($testimonials as $t) :
          $t_rating = min(5, max(0, (int) ($t['review_rating'] ?? 5)));
        ?>
          <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <div class="mb-3 flex gap-0.5">
              <?php
              for ($i = 0; $i < $t_rating; $i++) {
                echo '<img src="' . esc_url($template_uri . 'star-filled.svg') . '" width="14" height="14" alt="" class="size-3.5">';
              }
              for ($i = $t_rating; $i < 5; $i++) {
                echo '<img src="' . esc_url($template_uri . 'star-empty.svg') . '" width="14" height="14" alt="" class="size-3.5">';
              }
              ?>
            </div>
            <blockquote class="text-sm leading-relaxed text-slate-700">&ldquo;<?php echo esc_html($t['review_text']); ?>&rdquo;</blockquote>
            <div class="mt-4 border-t border-slate-100 pt-4">
              <div class="text-sm font-semibold text-slate-900"><?php echo esc_html($t['reviewer_name']); ?></div>
              <?php if (!empty($t['reviewer_info'])) : ?>
                <div class="text-xs text-slate-500"><?php echo esc_html($t['reviewer_info']); ?></div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- ======================== PRICING CTA ======================== -->
<section id="buy" class="section-spacing bg-white">
  <div class="fade-up mx-auto max-w-2xl px-5 text-center sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl"><?php echo highlight_text($pricing_heading); ?></h2>
    <p class="mt-4 text-lg text-slate-600"><?php echo esc_html($pricing_description); ?></p>
    <div class="border-brand-500 shadow-brand-500/10 mt-10 rounded-2xl border-2 bg-white p-8 shadow-xl sm:p-10">
      <div class="flex items-center justify-center gap-3">
        <?php if ($on_sale) : ?>
          <span class="text-5xl font-extrabold text-slate-900 sm:text-6xl"><?php echo esc_html($currency . $sale_price); ?></span>
          <div class="text-left">
            <div class="text-sm text-slate-500">one-time</div>
            <div class="text-sm text-slate-400 line-through"><?php echo esc_html($currency . $regular_price); ?></div>
          </div>
        <?php else : ?>
          <span class="text-5xl font-extrabold text-slate-900 sm:text-6xl"><?php echo esc_html($currency . $regular_price); ?></span>
          <div class="text-left">
            <div class="text-sm text-slate-500">one-time</div>
          </div>
        <?php endif; ?>
      </div>
      <?php if (!empty($pricing_features)) : ?>
        <ul class="mx-auto mt-8 max-w-sm space-y-3 text-left">
          <?php foreach ($pricing_features as $pf) : ?>
            <li class="flex items-center gap-3 text-sm text-slate-700">
              <svg class="text-brand-500 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              <?php echo esc_html($pf['feature_text']); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <?php
      $add_to_cart_url = $product->add_to_cart_url();
      ?>
      <a href="<?php echo esc_url($add_to_cart_url); ?>" class="shadow-brand-500/25 hover:shadow-brand-500/30 bg-brand-500 hover:bg-brand-600 mt-8 flex w-full items-center justify-center gap-2 rounded-xl px-8 py-4 text-lg font-bold text-white shadow-lg transition-all hover:-translate-y-0.5 hover:shadow-xl">
        Get Instant Access
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
      </a>
      <?php if ($guarantee_label) : ?>
        <div class="mt-5 flex items-center justify-center gap-2 text-sm text-slate-500">
          <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
          <?php echo esc_html($guarantee_label); ?> — no questions asked
        </div>
      <?php endif; ?>
    </div>
    <p class="mt-6 text-sm text-slate-500">Secure checkout. Instant access after purchase. Works on all devices.</p>
  </div>
</section>

<!-- ======================== FAQ ======================== -->
<?php if (!empty($faqs)) : ?>
  <section class="section-spacing bg-slate-50">
    <div class="mx-auto max-w-3xl px-5 sm:px-6 lg:px-8">
      <div class="fade-up text-center">
        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl"><?php echo highlight_text($faq_heading); ?></h2>
      </div>
      <div class="mt-10 space-y-2">
        <?php foreach ($faqs as $faq) : ?>
          <div class="fade-up faq-item overflow-hidden rounded-xl border border-slate-200 bg-white">
            <button class="faq-trigger flex w-full cursor-pointer items-center justify-between px-6 py-5 text-left" aria-expanded="false">
              <span class="pr-4 font-semibold text-slate-900"><?php echo esc_html($faq['question']); ?></span>
              <svg class="faq-chevron h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-answer px-6">
              <p class="pb-5 text-sm leading-relaxed text-slate-600"><?php echo esc_html($faq['answer']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- ======================== RELATED PRODUCTS ======================== -->
<?php
$related_ids = wc_get_related_products($product_id, 3);
if (!empty($related_ids)) :
?>
  <section class="section-spacing bg-white">
    <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
      <div class="fade-up text-center">
        <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">You Might Also Like</h2>
      </div>
      <div class="fade-up mt-10 grid gap-6 sm:grid-cols-3">
        <?php
        foreach ($related_ids as $rid) :
          $rp = wc_get_product($rid);
          if (!$rp) continue;
          $args = optimumlift_get_plan_product_args($rp);
          if (!$args) continue;
        ?>
          <?php get_template_part('template-parts/product-card-plan', null, $args); ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- ======================== STICKY MOBILE CTA ======================== -->
<div id="sticky-product-bar" class="fixed bottom-0 left-0 right-0 z-40 translate-y-full border-t border-slate-200 bg-white/95 p-3 backdrop-blur-lg transition-transform duration-300 lg:hidden">
  <a href="#buy" class="shadow-brand-500/20 bg-brand-500 hover:bg-brand-600 flex w-full items-center justify-center gap-2 rounded-xl py-3.5 text-base font-semibold text-white shadow-lg transition-colors">
    <?php echo esc_html($cta_label); ?>
  </a>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
