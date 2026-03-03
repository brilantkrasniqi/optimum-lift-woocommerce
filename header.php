<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo("charset"); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <div class="bg-slate-950">
    <div class="custom-container">
      <div class="flex h-fit flex-wrap items-center justify-center gap-2 px-4 py-1">
        <span class="hidden text-center text-white sm:block">Not sure which program is the right for you?</span>
        <a href="#" class="font-primary btn-primary p-1 whitespace-nowrap sm:p-2">Look through Programs</a>
      </div>
    </div>
  </div>
  <div class="sticky top-0 z-10 bg-slate-950">
    <div class="custom-container grid grid-cols-2 py-4 md:grid-cols-[auto_1fr_auto]">
      <?php
      $custom_logo_id = get_theme_mod("custom_logo");
      $logo_url = "";
      $site_name = get_bloginfo("name");

      if ($custom_logo_id) {
        $logo_url = wp_get_attachment_image_url($custom_logo_id, "full");
      }

      if ($logo_url) {
        echo '<a href="' .
          home_url() .
          '"><img src="' .
          esc_url($logo_url) .
          '" alt="' .
          esc_attr($site_name) .
          '"></a>';
      } else {
        echo '<a class="text-slate-200" href="' .
          home_url() .
          '"><span>' .
          esc_html($site_name) .
          "</span></a>";
      }
      ?>
      <ul id="mobile-menu" class="fixed top-0 -right-[100vw] z-10 flex h-full w-1/2 flex-col items-start justify-start gap-4 bg-slate-950 p-4 pt-10 transition-[right] duration-300 ease-in-out md:relative md:top-auto md:right-auto md:h-auto md:w-auto md:flex-row md:items-center md:justify-center md:bg-transparent md:p-0">
        <img class="menu-close absolute top-4 right-4 block cursor-pointer md:hidden" src="<?php echo get_template_directory_uri(); ?>/assets/images/close.svg" width="24" height="24" alt="Close">
        <?php
        $locations = get_nav_menu_locations();
        if (isset($locations["primary"]) && $locations["primary"]) {
          $menu_id = $locations["primary"];
          $items = wp_get_nav_menu_items($menu_id);
          if ($items) {
            foreach ($items as $item) {
              echo '<li><a class="font-primary font-medium text-slate-200" href="' .
                esc_url($item->url) .
                '">' .
                esc_html($item->title) .
                "</a></li>";
            }
          }
        }
        ?>
      </ul>
      <div class="flex items-center justify-end gap-4">
        <?php
        $account_url = function_exists("wc_get_page_permalink")
          ? wc_get_page_permalink("myaccount")
          : home_url("/my-account/");
        ?>
        <button class="cursor-pointer"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/search-dark.svg" width="22" height="22" alt="Search"></button>
        <a href="<?php echo esc_url($account_url); ?>" class="flex items-center" aria-label="My Account">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/person-dark.svg" width="24" height="24" alt="">
        </a>
        <button type="button" class="cart-drawer-trigger flex cursor-pointer items-center border-0 bg-transparent p-0" aria-label="Open cart">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/cart-dark.svg" width="22" height="22" alt="">
        </button>
        <button class="menu-toggle cursor-pointer md:hidden"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu-dark.svg" width="24" height="24" alt="Menu"></button>
      </div>
    </div>
  </div>
  <main class="min-h-screen">