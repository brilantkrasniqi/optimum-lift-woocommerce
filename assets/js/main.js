/**
 * Mobile Menu Toggle Functionality
 */
(function () {
  "use strict";
  // Wait for DOM to be ready
  document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const menuClose = document.querySelector(".menu-close");
    const mobileMenu = document.getElementById("mobile-menu");
    const menuOverlay = document.querySelector(".menu-overlay");

    if (!menuToggle || !mobileMenu) {
      return; // Exit if required elements don't exist
    }

    /**
     * Open the menu
     */
    function openMenu() {
      mobileMenu.classList.add("right-0");
      mobileMenu.classList.remove("-right-[100vw]");
      if (menuOverlay) menuOverlay.classList.remove("hidden");
      document.body.style.overflow = "hidden"; // Prevent body scroll when menu is open
    }

    /**
     * Close the menu
     */
    function closeMenu() {
      mobileMenu.classList.remove("right-0");
      mobileMenu.classList.add("-right-[100vw]");
      if (menuOverlay) menuOverlay.classList.add("hidden");
      document.body.style.overflow = ""; // Restore body scroll
    }

    /**
     * Toggle the menu
     */
    function toggleMenu() {
      if (mobileMenu.classList.contains("right-0")) {
        closeMenu();
      } else {
        openMenu();
      }
    }

    // Toggle menu when menu button is clicked
    menuToggle.addEventListener("click", function (e) {
      e.preventDefault();
      toggleMenu();
    });

    // Close menu when close button is clicked
    if (menuClose) {
      menuClose.addEventListener("click", function (e) {
        e.preventDefault();
        closeMenu();
      });
    }

    // Close menu when overlay is clicked
    if (menuOverlay) {
      menuOverlay.addEventListener("click", function () {
        closeMenu();
      });
    }

    // Close menu when clicking outside (on document)
    document.addEventListener("click", function (e) {
      const isMenuOpen = mobileMenu.classList.contains("left-0");
      if (
        isMenuOpen &&
        !mobileMenu.contains(e.target) &&
        !menuToggle.contains(e.target)
      ) {
        closeMenu();
      }
    });

    // Close menu on Escape key press
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && mobileMenu.classList.contains("left-0")) {
        closeMenu();
      }
    });
  });
})();

// Slider Initialization
function initSlider(el, options, extension = null) {
  const sliderEl = document.querySelector(el);
  if (!sliderEl) return;
  const slider = new Splide(sliderEl, options);
  if (extension) {
    slider.mount(window.splide.Extensions);
  } else {
    slider.mount();
  }
}
/**
 * Cart Drawer
 */
document.addEventListener("DOMContentLoaded", function () {
  const cartDrawer = document.getElementById("cart-drawer");
  const cartTrigger = document.querySelector(".cart-drawer-trigger");
  const cartClose = document.querySelector(".cart-drawer-close");
  const cartOverlay = document.querySelector(".cart-drawer-overlay");

  function openCartDrawer() {
    if (cartDrawer) {
      cartDrawer.classList.remove("pointer-events-none", "opacity-0");
      cartDrawer.classList.add("pointer-events-auto", "opacity-100");
      cartDrawer
        .querySelector(".cart-drawer-panel")
        ?.classList.remove("translate-x-full");
      cartDrawer.setAttribute("aria-hidden", "false");
      document.body.style.overflow = "hidden";
    }
  }

  function closeCartDrawer() {
    if (cartDrawer) {
      cartDrawer.classList.add("pointer-events-none", "opacity-0");
      cartDrawer.classList.remove("pointer-events-auto", "opacity-100");
      cartDrawer
        .querySelector(".cart-drawer-panel")
        ?.classList.add("translate-x-full");
      cartDrawer.setAttribute("aria-hidden", "true");
      document.body.style.overflow = "";
    }
  }

  if (cartTrigger) {
    cartTrigger.addEventListener("click", function (e) {
      e.preventDefault();
      openCartDrawer();
    });
  }
  if (cartClose) {
    cartClose.addEventListener("click", closeCartDrawer);
  }
  if (cartOverlay) {
    cartOverlay.addEventListener("click", closeCartDrawer);
  }
  if (cartDrawer) {
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && !cartDrawer.classList.contains("hidden")) {
        closeCartDrawer();
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  initSlider("#hero-slider", {
    type: "fade",
    perPage: 1,
    perMove: 1,
    autoplay: true,
    interval: 3000,
    pauseOnHover: false,
    pauseOnFocus: false,
    pauseOnScroll: false,
    pauseOnMouseEnter: false,
    pauseOnMouseLeave: false,
    arrows: false,
    // maybe add pagination later
    pagination: false,
  });
  initSlider(
    "#stats-slider",
    {
      type: "loop",
      drag: "free",
      arrows: false,
      gap: "1rem",
      pagination: false,
      focus: "center",
      fixedWidth: "12.5rem",
      autoScroll: {
        speed: 0.4,
      },
    },
    "auto-scroll",
  );
  initSlider("#before-after-slider", {
    type: "loop",
    perPage: 1,
    perMove: 1,
    fixedWidth: "28rem",
    gap: "2rem",
    pagination: true,
    arrows: true,
    breakpoints: {
      768: {
        fixedWidth: "22.5rem",
        gap: "1rem",
        focus: "center",
      },
    },
  });
  initSlider("#reviews-slider", {
    type: "loop",
    perPage: 3,
    perMove: 1,
    gap: "1.5rem",
    pagination: true,
    arrows: true,
    autoplay: true,
    interval: 4000,
    pauseOnHover: true,
    breakpoints: {
      640: {
        perPage: 1,
      },
      1024: {
        perPage: 2,
      },
    },
  });
  initSlider("#featured-products-slider", {
    type: "loop",
    perPage: 1,
    perMove: 1,
    fixedWidth: "22rem",
    gap: "1.5rem",
    pagination: true,
    arrows: true,
    breakpoints: {
      640: {
        perPage: 1,
        fixedWidth: null,
      },
      1024: {
        perPage: 3,
        fixedWidth: null,
      },
    },
  });

  // Product gallery slider with thumbnail sync
  var galleryEl = document.querySelector("#product-gallery-slider");
  if (galleryEl) {
    var gallerySlider = new Splide(galleryEl, {
      type: "fade",
      perPage: 1,
      arrows: true,
      pagination: true,
      rewind: true,
    });
    gallerySlider.mount();

    var thumbs = document.querySelectorAll(".product-thumb");
    thumbs.forEach(function (thumb) {
      thumb.addEventListener("click", function () {
        gallerySlider.go(parseInt(thumb.dataset.index, 10));
      });
    });

    gallerySlider.on("moved", function (newIndex) {
      thumbs.forEach(function (t, i) {
        if (i === newIndex) {
          t.classList.add("border-brand-500");
          t.classList.remove("border-transparent", "opacity-60");
        } else {
          t.classList.remove("border-brand-500");
          t.classList.add("border-transparent", "opacity-60");
        }
      });
    });
  }

  // Sticky mobile CTA for single product
  var stickyBar = document.getElementById("sticky-product-bar");
  if (stickyBar) {
    window.addEventListener(
      "scroll",
      function () {
        if (window.scrollY > 600) {
          stickyBar.classList.remove("translate-y-full");
        } else {
          stickyBar.classList.add("translate-y-full");
        }
      },
      { passive: true },
    );
  }
});

// Observer for fade-up animation
function fadeUpObserver() {
  const fadeUpElements = document.querySelectorAll(".fade-up");
  const config = {
    threshold: 0.1,
    rootMargin: "0px 0px -40px 0px",
  };
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("fade-up-visible");
        observer.unobserve(entry.target);
      }
    });
  }, config);
  fadeUpElements.forEach((element) => {
    observer.observe(element);
  });
}
fadeUpObserver();

// FAQ
var faqTriggers = document.querySelectorAll(".faq-trigger");
faqTriggers.forEach(function (trigger) {
  trigger.addEventListener("click", function () {
    var item = trigger.closest(".faq-item");
    var answer = item.querySelector(".faq-answer");
    var chevron = item.querySelector(".faq-chevron");
    var isOpen = answer.classList.contains("open");

    // Close all
    document.querySelectorAll(".faq-answer").forEach(function (a) {
      a.classList.remove("open");
    });
    document.querySelectorAll(".faq-chevron").forEach(function (c) {
      c.classList.remove("rotate");
    });
    document.querySelectorAll(".faq-trigger").forEach(function (t) {
      t.setAttribute("aria-expanded", "false");
    });

    // Toggle current
    if (!isOpen) {
      answer.classList.add("open");
      chevron.classList.add("rotate");
      trigger.setAttribute("aria-expanded", "true");
    }
  });
});
