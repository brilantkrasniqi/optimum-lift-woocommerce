<?php get_header(); ?>
<!-- HERO -->
<section>
  <?php if (have_rows("hero_slide_images")): ?>
    <div class="splide" id="hero-slider">
      <div class="splide__track">
        <ul class="splide__list">
          <?php while (have_rows("hero_slide_images")):

            the_row();
            $image = get_sub_field("hero_image");
            $heading = get_sub_field("hero_heading");
            $highlight_text = get_sub_field("hero_highlight");
            $subheading = get_sub_field("hero_subheading");
            $cta_1 = get_sub_field("hero_cta_link");
            $cta_2 = get_sub_field("hero_cta_link_2");
          ?>
            <li class="splide__slide relative before:absolute before:inset-0 before:z-10 before:bg-black/40 before:content-['']">
              <img class="h-[80vh] w-full object-cover" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($heading); ?>">
              <div class="absolute top-1/2 left-1/2 z-10 flex w-10/12 max-w-3xl -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-2">
                <h1 class="text-center font-bold text-white"><?php echo $heading; ?> <br> <span class="text-brand-500"><?php echo $highlight_text; ?></span></h1>
                <p class="max-w-2xl text-center text-white"><?php echo esc_html($subheading); ?></p>
                <div class="mt-2 flex items-center gap-2">
                  <a href="<?php echo esc_url($cta_1['url']); ?>" class="btn-primary px-8 py-4 text-lg hover:shadow-brand-500/30 w-fit text-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl"><?php echo esc_html($cta_1['title']); ?></a>
                  <?php if ($cta_2): ?>
                    <a href="<?php echo esc_url($cta_2['url']); ?>" class="btn-secondary px-8 py-4 text-lg w-fit text-center"><?php echo esc_html($cta_2['title']); ?></a>
                  <?php endif; ?>
                </div>
              </div>
            </li>
          <?php
          endwhile; ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>
</section>
<!-- Stats -->
<section class="bg-brand-500">
  <?php if (have_rows("overall_stats")): ?>
    <div class="splide py-4" id="stats-slider">
      <div class="splide__track">
        <ul class="splide__list">
          <?php while (have_rows("overall_stats")):
            the_row();
            $stat = get_sub_field("stat_number");
            $label = get_sub_field("stat_text");
          ?>
            <li class="splide__slide">
              <div class="flex max-w-70 flex-col items-center">
                <h2 class="font-bold text-white"><?php echo esc_html($stat); ?></h2>
                <p class="font-primary w-full text-center text-slate-200"><?php echo esc_html($label); ?></p>
              </div>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>
</section>
<!-- Problem Section -->
<section class="section-spacing">
  <?php
  $problem = get_field("problem_section") ?: [];
  $heading = $problem["section_heading"] ?? "";
  $description = $problem["section_subheading"] ?? "";
  ?>
  <div class="custom-container">
    <div class="fade-up">
      <h2 class="mx-auto max-w-4xl text-center font-bold"><?php echo highlight_text($heading) ?></h2>
      <p class="mx-auto mt-2 max-w-2xl text-center text-slate-900"><?php echo esc_html($description); ?></p>
    </div>
    <div class="fade-up mt-10 grid gap-6 md:grid-cols-3 lg:gap-8">
      <?php
      for ($i = 1; $i <= 3; $i++):
        $card = $problem["problem_card_$i"] ?? [];
        $icon = $card["card_icon"] ?? "";
        $title = $card["card_title"] ?? "";
        $description = $card["card_content"] ?? "";
      ?>
        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-8">
          <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-red-50">
            <img src="<?php echo esc_url($icon); ?>">
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900"><?php echo esc_html($title); ?></h3>
          <p class="leading-relaxed text-slate-600">
            <?php echo esc_html($description); ?>
          </p>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>
<!-- TESTIMONIALS BEFORE/AFTER -->
<section class="section-spacing overflow-visible">
  <?php
  $testimonials = get_field("testimonials_home_section") ?: [];
  $heading = $testimonials["section_heading"] ?? "";
  $description = $testimonials["section_description"] ?? "";
  $reviews = $testimonials["before_after_reviews"] ?? [];
  $template_uri = get_template_directory_uri() . '/assets/images/';
  ?>
  <div class="custom-container overflow-visible">
    <div class="fade-up mx-auto max-w-3xl text-center">
      <h2 class="font-bold"><?php echo highlight_text($heading); ?></h2>
      <p class="mt-2 text-slate-600"><?php echo esc_html($description); ?></p>
    </div>
    <?php if (!empty($reviews)): ?>
      <div class="splide fade-up relative mt-10" id="before-after-slider">
        <div class="splide__arrows z-10">
          <button class="splide__arrow splide__arrow--prev absolute top-1/2 left-[-22px] z-10 flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white shadow-md" aria-label="Previous slide">
            <img src="<?php echo esc_url($template_uri . 'left-arrow.svg'); ?>" width="24" height="24" alt="">
          </button>
          <button class="splide__arrow splide__arrow--next absolute top-1/2 right-[-22px] z-10 flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white shadow-md" aria-label="Next slide">
            <img src="<?php echo esc_url($template_uri . 'right-arrow.svg'); ?>" width="24" height="24" alt="">
          </button>
        </div>
        <div class="splide__track">
          <ul class="splide__list">
            <?php
            foreach ($reviews as $row):
              $before_after_card = $row["before_after_card"] ?? [];
              if (empty($before_after_card)) continue;

              $before_image = $before_after_card["before_image"] ?? [];
              $after_image = $before_after_card["after_image"] ?? [];
              $name = $before_after_card["reviewers_name"] ?? "";
              $stars = $before_after_card["number_of_stars"] ?? 0;
              $weeks = $before_after_card["number_of_weeks"] ?? "";
              $product = $before_after_card["product_used"] ?? null;

              $product_title = $product ? get_the_title($product) : "";
              $product_link = $product ? get_permalink($product) : "#";
              $product_image = $product ? get_the_post_thumbnail_url($product, "full") : "";

              $rating = min(5, max(0, (int) $stars));
            ?>
              <li class="splide__slide">
                <div class="mx-auto max-w-90 overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all duration-300 hover:shadow-lg md:max-w-md">
                  <div class="relative flex items-center">
                    <div class="relative h-60 w-1/2 md:h-80">
                      <img class="h-full w-full object-cover" src="<?php echo esc_url($before_image['url']); ?>" alt="<?php echo esc_attr($before_image['alt']); ?>">
                      <span class="absolute bottom-2 left-2 rounded-md bg-black/50 px-2 py-0.5 text-[11px] font-bold tracking-wide text-white uppercase backdrop-blur-sm">Before</span>
                    </div>
                    <div class="relative h-60 w-1/2 md:h-80">
                      <img class="h-full w-full object-cover" src="<?php echo esc_url($after_image['url']); ?>" alt="<?php echo esc_attr($after_image['alt']); ?>">
                      <span class="bg-brand-500/80 absolute right-2 bottom-2 rounded-md px-2 py-0.5 text-[11px] font-bold tracking-wide text-white uppercase backdrop-blur-sm">After</span>
                    </div>
                  </div>
                  <div class="p-4">
                    <div class="flex items-center justify-between">
                      <p class="text-sm font-semibold text-slate-900"><?php echo esc_html($name); ?></p>
                      <div class="flex items-center gap-0.5" role="img" aria-label="<?php echo esc_attr($rating); ?> out of 5 stars">
                        <?php
                        for ($i = 0; $i < $rating; $i++) {
                          echo '<img src="' . esc_url($template_uri . 'star-filled.svg') . '" width="14" height="14" alt="" class="size-3.5">';
                        }
                        for ($i = $rating; $i < 5; $i++) {
                          echo '<img src="' . esc_url($template_uri . 'star-empty.svg') . '" width="14" height="14" alt="" class="size-3.5">';
                        }
                        ?>
                      </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between gap-4 border-t border-slate-100 pt-3">
                      <span class="flex items-center gap-1.5 rounded-md bg-slate-100 px-2 py-1 text-xs font-medium whitespace-nowrap text-slate-500">
                        <img src="<?php echo esc_url($template_uri . 'clock.svg'); ?>" width="14" height="14" alt="" class="size-3.5">
                        <?php echo esc_html($weeks); ?> weeks
                      </span>
                      <?php if ($product) : ?>
                        <a href="<?php echo esc_url($product_link); ?>" class="flex min-w-0 items-center gap-2">
                          <img class="size-7 shrink-0 rounded-md object-cover" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_title); ?>">
                          <span class="text-brand-600 hover:text-brand-700 truncate text-xs font-semibold transition-colors"><?php echo esc_html($product_title); ?></span>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<!-- HOW IT WORKS -->
<section class="section-spacing bg-slate-50">
  <div class="custom-container">
    <div class="fade-up mx-auto max-w-3xl">
      <?php
      $section = get_field("how_it_works") ?: [];
      $heading = $section["section_heading"] ?? "";
      $description = $section["section_subheading"] ?? "";
      $steps = $section["steps"] ?? [];
      $cta = $section["section_cta"] ?? [];
      ?>
      <h2 class="text-center font-bold"><?php echo highlight_text($heading); ?></h2>
      <p class="mx-auto mt-2 max-w-2xl text-center text-slate-600"><?php echo esc_html($description); ?></p>
    </div>
    <div class="fade-up">
      <?php if (!empty($steps)): ?>
        <div class="mt-16 grid gap-8 md:grid-cols-3 lg:gap-12">
          <?php foreach ($steps as $index => $row):
            $title = $row["step_title"] ?? "";
            $content = $row["step_content"] ?? "";
            $step_num = $index + 1;
          ?>
            <div class="fade-up text-center md:text-left">
              <div class="bg-brand-500 mb-6 inline-flex h-14 w-14 items-center justify-center rounded-2xl text-xl font-extrabold text-white"><?php echo (int) $step_num; ?></div>
              <h3 class="mb-3 text-xl font-bold text-slate-900"><?php echo esc_html($title); ?></h3>
              <p class="leading-relaxed text-slate-600"><?php echo esc_html($content); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="fade-up mt-14 text-center">
      <?php if (!empty($cta)): ?>
        <a href="<?php echo esc_url($cta['url']); ?>" class="btn-primary hover:shadow-brand-500/30 px-8 py-4 text-xl transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl"><?php echo esc_html($cta['title']); ?></a>
      <?php endif; ?>
    </div>
  </div>
</section>
<!-- Featured Products -->
<section class="section-spacing overflow-visible">
  <?php
  $showcase = get_field("showcase_products") ?: [];
  $featured_products = $showcase["featured_products"] ?? get_field("featured_products") ?? [];
  $featured_heading = $showcase["section_heading"] ?? get_field("featured_products_heading") ?: "Our Programs";
  $featured_description = $showcase["section_description"] ?? get_field("featured_products_description") ?: "Choose the plan that fits your goals";
  ?>
  <div class="custom-container overflow-visible">
    <div class="fade-up mx-auto max-w-3xl text-center">
      <h2 class="font-bold"><?php echo highlight_text($featured_heading); ?></h2>
      <p class="mt-2 text-slate-600"><?php echo esc_html($featured_description); ?></p>
    </div>
    <?php if (!empty($featured_products)) : ?>
      <div class="splide fade-up relative mt-12" id="featured-products-slider">
        <div class="splide__arrows z-10">
          <button class="splide__arrow splide__arrow--prev absolute top-1/2 left-[-22px] z-10 flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white shadow-md" aria-label="Previous slide">
            <img src="<?php echo esc_url(get_template_directory_uri() . "/assets/images/left-arrow.svg"); ?>" width="24" height="24" alt="">
          </button>
          <button class="splide__arrow splide__arrow--next absolute top-1/2 right-[-22px] z-10 flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white shadow-md" aria-label="Next slide">
            <img src="<?php echo esc_url(get_template_directory_uri() . "/assets/images/right-arrow.svg"); ?>" width="24" height="24" alt="">
          </button>
        </div>
        <div class="splide__track">
          <ul class="splide__list py-6!">
            <?php
            foreach ($featured_products as $product_post) :
              $product = is_a($product_post, "WC_Product") ? $product_post : wc_get_product($product_post);
              $args = optimumlift_get_plan_product_args($product);
              if (!$args) continue;
            ?>
              <li class="splide__slide">
                <?php get_template_part("template-parts/product-card-plan", null, $args); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<!-- Benifits Section -->
<section class="section-spacing bg-slate-950">
  <?php
  $section = get_field("benifits_section") ?: [];
  $heading = $section["section_title"] ?? "";
  $description = $section["section_description"] ?? "";
  $benefits = $section["benifit_cards"] ?? [];
  ?>
  <div class="custom-container">
    <div class="fade-up mx-auto max-w-3xl text-center">
      <h2 class="text-center font-bold text-white"><?php echo highlight_text($heading); ?></h2>
      <?php if (!empty($description)): ?>
        <p class="mx-auto mt-2 max-w-2xl text-center text-slate-400"><?php echo esc_html($description); ?></p>
      <?php endif; ?>
    </div>
    <?php if (!empty($benefits)): ?>
      <div class="fade-up lg:grid-cold-3 mt-16 grid gap-8 sm:grid-cols-2 lg:gap-10">
        <?php foreach ($benefits as $benefit):
          $image = $benefit["card_image"] ?? "";
          $title = $benefit["card_title"] ?? "";
          $description = $benefit["card_description"] ?? "";
        ?>
          <div class="fade-up">
            <div class="bg-brand-500/10 mb-4 flex h-10 w-10 items-center justify-center rounded-lg">
              <img src="<?php echo esc_url($image["url"]); ?>" alt="<?php echo esc_attr($title); ?>" class="h-5 w-5">
            </div>
            <h3 class="mb-2 text-lg font-bold text-white"><?php echo esc_html($title); ?></h3>
            <p class="leading-relaxed text-slate-400"><?php echo esc_html($description); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<!-- What Our Members Say -->
<section class="section-spacing">
  <?php
  $section = get_field("review_testimonials") ?: [];
  $heading = $section["section_heading"] ?? "";
  $description = $section["section_description"] ?? "";
  $testimonials = $section["review_card"] ?? [];
  ?>
  <div class="custom-container">
    <h2 class="font-extrabold tracking-tight text-center text-slate-900"><?php echo highlight_text($heading); ?></h2>
    <?php if (!empty($description)): ?>
      <p class="mt-6 text-lg leading-relaxed text-center text-slate-600"><?php echo esc_html($description); ?></p>
    <?php endif; ?>
    <?php if (!empty($testimonials)): ?>
      <div class="splide fade-up relative mt-16" id="reviews-slider">
        <div class="splide__arrows z-10">
          <button class="splide__arrow splide__arrow--prev absolute top-1/2 left-[-22px] z-10 flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white shadow-md" aria-label="Previous slide">
            <img src="<?php echo esc_url($template_uri . 'left-arrow.svg'); ?>" width="24" height="24" alt="">
          </button>
          <button class="splide__arrow splide__arrow--next absolute top-1/2 right-[-22px] z-10 flex h-11 w-11 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full bg-white shadow-md" aria-label="Next slide">
            <img src="<?php echo esc_url($template_uri . 'right-arrow.svg'); ?>" width="24" height="24" alt="">
          </button>
        </div>
        <div class="splide__track">
          <ul class="splide__list py-4!">
            <?php foreach ($testimonials as $testimonial):
              $stars = $testimonial["review_rating"] ?? 5;
              $content = $testimonial["card_content"] ?? "";
              $author = $testimonial["card_author"] ?? "";
              $additional_info = $testimonial["author_additional_info"] ?? "";
              $rating = min(5, max(0, (int) $stars));
            ?>
              <li class="splide__slide">
                <div class="flex h-full flex-col rounded-2xl border border-slate-100 bg-white p-8 shadow-sm">
                  <div class="mb-4 flex gap-1">
                    <?php
                    for ($i = 0; $i < $rating; $i++) {
                      echo '<img src="' . esc_url($template_uri . 'star-filled.svg') . '" width="14" height="14" alt="" class="size-3.5">';
                    }
                    for ($i = $rating; $i < 5; $i++) {
                      echo '<img src="' . esc_url($template_uri . 'star-empty.svg') . '" width="14" height="14" alt="" class="size-3.5">';
                    }
                    ?>
                  </div>
                  <blockquote class="flex-1 leading-relaxed text-slate-700">
                    <?php echo esc_html($content); ?>
                  </blockquote>
                  <div class="mt-6 border-t border-slate-100 pt-6">
                    <div class="font-semibold text-slate-900"><?php echo esc_html($author); ?></div>
                    <div class="text-sm text-slate-500"><?php echo esc_html($additional_info); ?></div>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<!-- Guarantee Section -->
<section class="section-spacing from-brand-600 to-brand-500 bg-gradient-to-r">
  <?php
  $section = get_field("guarantee_section") ?: [];
  $heading = $section["section_heading"] ?? "";
  $description = $section["section_description"] ?? "";
  $icon = $section["guarantee_icon"] ?? "";
  ?>
  <div class="custom-container fade-up mx-auto max-w-4xl px-5 text-center sm:px-6 lg:px-8">
    <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20">
      <img src="<?php echo esc_url($icon); ?>" width="24" height="24" alt="<?php echo esc_attr($heading); ?>">
    </div>
    <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl"><?php echo highlight_text($heading); ?></h2>
    <?php if (!empty($description)): ?>
      <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-orange-100"><?php echo esc_html($description); ?></p>
    <?php endif; ?>
  </div>
</section>

<!-- FAQ Section -->
<section class="section-spacing">
  <?php
  $section = get_field("faq_section") ?: [];
  $heading = $section["section_heading"] ?? "";
  $description = $section["section_description"] ?? "";
  $faqs = $section["faq_card"] ?? [];

  ?>
  <div class="custom-container">
    <div class="fade-up text-center">
      <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl"><?php echo highlight_text($heading); ?></h2>
      <p class="mt-6 text-lg text-slate-600"><?php echo esc_html($description); ?></p>
    </div>
    <?php if (!empty($faqs)): ?>
      <div class="mt-14 space-y-3">
        <?php foreach ($faqs as $faq):
          $question = $faq["question"] ?? "";
          $answer = $faq["answer"] ?? "";
        ?>
          <div class="fade-up faq-item rounded-xl border border-slate-200 bg-white">
            <button class="faq-trigger cursor-pointer flex w-full items-center justify-between px-6 py-5 text-left" aria-expanded="false">
              <span class="pr-4 font-semibold text-slate-900"><?php echo esc_html($question); ?></span>
              <svg class="faq-chevron h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-answer px-6">
              <p class="pb-5 leading-relaxed text-slate-600">
                <?php echo esc_html($answer); ?>
              </p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<!-- CTA -->
<section class="section-spacing bg-slate-950 relative">
  <?php
  $section = get_field("cta") ?: [];
  $heading = $section["cta_heading"] ?? "";
  $description = $section["cta_description"] ?? "";
  $cta = $section["cta_link"] ?? [];
  ?>
  <div class="custom-container">
    <div class="absolute inset-0">
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-500/6 rounded-full blur-3xl "></div>
    </div>
    <div class="relative max-w-3xl mx-auto px-5 sm:px-6 lg:px-8 text-center fade-up">
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
        <?php echo highlight_text($heading); ?>
      </h2>
      <p class="mt-6 text-lg text-slate-400 leading-relaxed max-w-2xl mx-auto">
        <?php echo esc_html($description); ?>
      </p>
      <div class="mt-10">
        <a href="<?php echo esc_url($cta['url']); ?>" class="inline-flex items-center gap-2 px-10 py-5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl text-lg transition-all duration-200 shadow-lg shadow-brand-500/25 hover:shadow-xl hover:shadow-brand-500/30 hover:-translate-y-0.5">
          <?php echo esc_html($cta["title"]); ?>
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>