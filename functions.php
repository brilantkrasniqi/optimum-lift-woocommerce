<?php

/**
 * Optimum Lift Theme Functions
 *
 * @package OptimumLift
 */

if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly
}

/**
 * Theme Setup
 */
function optimumlift_setup()
{
    // Add theme support for automatic feed links
    add_theme_support("automatic-feed-links");

    // Add theme support for title tag (WordPress 4.1+)
    add_theme_support("title-tag");

    // Add theme support for post thumbnails
    add_theme_support("post-thumbnails");

    // Add theme support for HTML5 markup
    add_theme_support("html5", [
        "search-form",
        "comment-form",
        "comment-list",
        "gallery",
        "caption",
        "style",
        "script",
    ]);

    // Add theme support for custom logo
    add_theme_support("custom-logo", [
        "height" => 100,
        "width" => 400,
        "flex-height" => true,
        "flex-width" => true,
    ]);

    // Add theme support for custom background
    add_theme_support(
        "custom-background",
        apply_filters("optimumlift_custom_background_args", [
            "default-color" => "ffffff",
            "default-image" => "",
        ]),
    );

    // Add theme support for selective refresh for widgets
    add_theme_support("customize-selective-refresh-widgets");

    // Add theme support for editor styles
    add_theme_support("editor-styles");
    add_editor_style("assets/css/output.css");

    // Add theme support for responsive embeds
    add_theme_support("responsive-embeds");

    // Add theme support for wide and full alignments
    add_theme_support("align-wide");

    // Register navigation menus
    register_nav_menus([
        "primary" => esc_html__("Primary Menu", "optimumlift"),
        "footer" => esc_html__("Footer Menu", "optimumlift"),
    ]);

    // Set the default content width
    $GLOBALS["content_width"] = apply_filters(
        "optimumlift_content_width",
        1200,
    );
}
add_action("after_setup_theme", "optimumlift_setup");

/**
 * Add Google Fonts Preconnect
 */
function optimumlift_google_fonts_preconnect()
{
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' .
        "\n";
}
add_action("wp_head", "optimumlift_google_fonts_preconnect", 1);

/**
 * Enqueue Google Fonts
 */
function optimumlift_enqueue_google_fonts()
{
    wp_enqueue_style(
        "optimumlift-google-fonts",
        "https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap",
        [],
        null,
    );
}
add_action("wp_enqueue_scripts", "optimumlift_enqueue_google_fonts");

/**
 * Enqueue Styles and Scripts
 */
function optimumlift_enqueue_assets()
{
    // Get theme version for cache busting
    $theme_version = wp_get_theme()->get("Version");

    // Enqueue main stylesheet
    wp_enqueue_style(
        "optimumlift-style",
        get_stylesheet_uri(),
        [],
        $theme_version,
    );

    // Enqueue Tailwind CSS output
    wp_enqueue_style(
        "optimumlift-tailwind",
        get_template_directory_uri() . "/assets/css/output.css",
        [],
        $theme_version,
    );

    // Enqueue Splide CSS
    wp_enqueue_style(
        "optimumlift-splide",
        get_template_directory_uri() . "/assets/css/splide-core.min.css",
        [],
        $theme_version,
    );

    // Enqueue Splide JS
    wp_enqueue_script(
        "optimumlift-splide",
        get_template_directory_uri() . "/assets/js/splide.min.js",
        [],
        $theme_version,
        true,
    );

    // Enqueue Splide Auto Scroll Extension
    wp_enqueue_script(
        "optimumlift-splide-auto-scroll",
        get_template_directory_uri() .
            "/assets/js/splide-extension-auto-scroll.min.js",
        ["optimumlift-splide"],
        $theme_version,
        true,
    );

    // Enqueue main theme JavaScript
    wp_enqueue_script(
        "optimumlift-main",
        get_template_directory_uri() . "/assets/js/main.js",
        ["optimumlift-splide-auto-scroll"],
        $theme_version,
        true,
    );

    // Enqueue comment reply script on single posts with comments
    if (is_singular() && comments_open() && get_option("thread_comments")) {
        wp_enqueue_script("comment-reply");
    }
}
add_action("wp_enqueue_scripts", "optimumlift_enqueue_assets");

/**
 * Register Widget Areas
 */
// function optimumlift_widgets_init()
// {
//   register_sidebar(array(
//     'name' => esc_html__('Sidebar', 'optimumlift'),
//     'id' => 'sidebar-1',
//     'description' => esc_html__('Add widgets here.', 'optimumlift'),
//     'before_widget' => '<section id="%1$s" class="widget %2$s">',
//     'after_widget' => '</section>',
//     'before_title' => '<h2 class="widget-title">',
//     'after_title' => '</h2>',
//   ));

//   register_sidebar(array(
//     'name' => esc_html__('Footer Widget Area 1', 'optimumlift'),
//     'id' => 'footer-1',
//     'description' => esc_html__('Add widgets here.', 'optimumlift'),
//     'before_widget' => '<section id="%1$s" class="widget %2$s">',
//     'after_widget' => '</section>',
//     'before_title' => '<h2 class="widget-title">',
//     'after_title' => '</h2>',
//   ));

//   register_sidebar(array(
//     'name' => esc_html__('Footer Widget Area 2', 'optimumlift'),
//     'id' => 'footer-2',
//     'description' => esc_html__('Add widgets here.', 'optimumlift'),
//     'before_widget' => '<section id="%1$s" class="widget %2$s">',
//     'after_widget' => '</section>',
//     'before_title' => '<h2 class="widget-title">',
//     'after_title' => '</h2>',
//   ));

//   register_sidebar(array(
//     'name' => esc_html__('Footer Widget Area 3', 'optimumlift'),
//     'id' => 'footer-3',
//     'description' => esc_html__('Add widgets here.', 'optimumlift'),
//     'before_widget' => '<section id="%1$s" class="widget %2$s">',
//     'after_widget' => '</section>',
//     'before_title' => '<h2 class="widget-title">',
//     'after_title' => '</h2>',
//   ));
// }
// add_action('widgets_init', 'optimumlift_widgets_init');

/**
 * WooCommerce Support
 */
function optimumlift_woocommerce_support()
{
    add_theme_support("woocommerce");
    add_theme_support("wc-product-gallery-zoom");
    add_theme_support("wc-product-gallery-lightbox");
}
add_action("after_setup_theme", "optimumlift_woocommerce_support");

/**
 * Remove WooCommerce sidebar from shop, product, and account pages
 */
function optimumlift_remove_woocommerce_sidebar()
{
    remove_action("woocommerce_sidebar", "woocommerce_get_sidebar");
}
add_action("wp", "optimumlift_remove_woocommerce_sidebar");

/**
 * Get product card args for plan products (shared by content-product and sliders)
 *
 * @param WC_Product|int $product Product object or ID
 * @return array|null Args for product-card-plan, or null if invalid
 */
function optimumlift_get_plan_product_args($product)
{
    if (is_numeric($product)) {
        $product = wc_get_product($product);
    }
    if (!is_a($product, WC_Product::class) || !$product->is_visible()) {
        return null;
    }

    $product_id = $product->get_id();

    // Product categories (actual names from WooCommerce)
    $categories = [];
    $terms = get_the_terms($product_id, "product_cat");
    if ($terms && !is_wp_error($terms)) {
        $categories = wp_list_pluck($terms, "name");
    }

    // Duration from ACF range field
    $duration = "";
    $duration_field = get_field("duration", $product_id);
    if (is_array($duration_field)) {
        $min = $duration_field["min"] ?? null;
        $max = $duration_field["max"] ?? null;
        if ($min !== null && $max !== null && $min !== $max) {
            $duration = sprintf("%d–%d weeks", (int) $min, (int) $max);
        } elseif ($min !== null) {
            $duration = sprintf("%d weeks", (int) $min);
        } elseif ($max !== null) {
            $duration = sprintf("%d weeks", (int) $max);
        }
    } elseif (is_numeric($duration_field)) {
        $duration = sprintf("%d weeks", (int) $duration_field);
    }

    // Experience Levels from product attribute (supports multiple)
    $levels_raw = $product->get_attribute("Experience Level");
    $levels = $levels_raw ? array_map("trim", explode(",", $levels_raw)) : [];

    // Goals from product attribute
    $goals_raw = $product->get_attribute("Goal");
    $goals = $goals_raw ? array_map("trim", explode(",", $goals_raw)) : [];

    // Individual price components
    $regular_price = $product->get_regular_price();
    $sale_price    = $product->get_sale_price();
    $currency       = get_woocommerce_currency_symbol();

    return [
        "image_url"      => get_the_post_thumbnail_url($product_id, "medium_large"),
        "title"          => $product->get_name(),
        "regular_price"  => $regular_price,
        "sale_price"     => $sale_price,
        "currency"       => $currency,
        "categories"     => $categories,
        "duration"       => $duration,
        "levels"         => $levels,
        "link"           => get_permalink($product_id),
        "excerpt"        => has_excerpt($product_id) ? get_the_excerpt($product_id) : "",
        "goals"          => $goals,
        "rating"         => (float) $product->get_average_rating(),
        "review_count"   => (int) $product->get_review_count(),
    ];
}

/**
 * Custom Excerpt Length
 */
function optimumlift_excerpt_length($length)
{
    return 20;
}
add_filter("excerpt_length", "optimumlift_excerpt_length", 999);

/**
 * Custom Excerpt More
 */
function optimumlift_excerpt_more($more)
{
    return "...";
}
add_filter("excerpt_more", "optimumlift_excerpt_more");

/**
 * Add async/defer attributes to enqueued scripts
 */
function optimumlift_script_loader_tag($tag, $handle, $src)
{
    // Add defer to Splide scripts
    if (strpos($handle, "optimumlift-splide") !== false) {
        return str_replace(" src", " defer src", $tag);
    }
    return $tag;
}
add_filter("script_loader_tag", "optimumlift_script_loader_tag", 10, 3);

function highlight_text($text, $delimiter = '**')
{
    $text = esc_html($text);
    $escaped = preg_quote($delimiter, '/');
    $pattern = '/' . $escaped . '(.+?)' . $escaped . '/';
    return preg_replace($pattern, '<span class="text-brand-500">$1</span>', $text);
}

function allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');
