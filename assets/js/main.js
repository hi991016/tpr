"use strict";

// ===== init =====
const init = () => {
  // # load fonts
  loadFonts();
  // # app height
  appHeight();
  // # header logo
  handleHeaderLogo();
  // # initTabs
  initTabs();
  // # lazy load
  initLazyLoad();
  // # init custom cursor
  initCustomCursor();
};

// ===== load fonts =====
const loadFonts = () => {
  // when page en add class "en"
  if (document.URL.match("/en/")) {
    document.body.classList.add("en");
  }
  // wait font loaded
  if (typeof Ts !== "undefined" && Ts.onComplete) {
    Ts.onComplete(() => {
      document.querySelectorAll(".typesquare_option").forEach((el) => {
        el.classList.remove("typesquare_option");
        document.body.classList.remove("fadeout");
      });
    });
  } else {
    // Fallback: remove class after 2 second if Ts.onComplete null
    setTimeout(() => {
      document.querySelectorAll(".typesquare_option").forEach((el) => {
        el.classList.remove("typesquare_option");
        document.body.classList.remove("fadeout");
      });
    }, 2000);
  }
};

// ===== lazy load =====
const initLazyLoad = function () {
  const images = document.querySelectorAll(
    'img[loading="lazy"], img.cld-responsive, img.cld-lazy, img[src^="data:image/svg+xml"]'
  );

  const observer = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = entry.target;
          if (
            img.complete &&
            img.naturalWidth !== 0 &&
            !img.src.startsWith("data:image/svg+xml")
          ) {
            img.classList.add("loaded");
          } else {
            img.addEventListener(
              "load",
              () => {
                if (!img.src.startsWith("data:image/svg+xml")) {
                  img.classList.add("loaded");
                }
              },
              { once: true }
            );
          }

          observer.unobserve(img);
        }
      });
    },
    { rootMargin: "0px 0px 100px 0px" }
  ); // preload 100px before entering viewport

  images.forEach((img) => observer.observe(img));
};

// ===== app height =====
const appHeight = () => {
  const doc = document.documentElement;
  doc.style.setProperty(
    "--app-height",
    `${document.documentElement.clientHeight}px`
  );

  if (window.innerWidth < 1024) {
    const windowHeight = Math.max(
      document.documentElement.clientHeight,
      window.innerHeight || 0
    );
    document.querySelector("[data-navbar]").style.height = windowHeight + "px";
  }
};
window.addEventListener("resize", appHeight);

// ===== href fadeout =====
document.addEventListener("click", function (e) {
  const link = e.target.closest(
    'a:not([href^="#"]):not([target]):not([href^="mailto"]):not([href^="tel"])'
  );
  if (!link) return;

  e.preventDefault();
  const url = link.getAttribute("href");

  if (url && url !== "") {
    const idx = url.indexOf("#");
    const hash = idx !== -1 ? url.substring(idx) : "";

    if (hash && hash !== "#") {
      try {
        const targetElement = document.querySelector(hash);
        if (targetElement) {
          targetElement.scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
          return false;
        }
      } catch (err) {
        console.error("Invalid hash selector:", hash, err);
      }
    }

    document.body.classList.add("fadeout");
    setTimeout(function () {
      window.location = url;
    }, 500);
  }

  return false;
});

// ===== scroll logo scale =====
const throttle = (func, limit) => {
  let lastFunc;
  let lastRan;
  return function () {
    const context = this;
    const args = arguments;
    if (!lastRan) {
      func.apply(context, args);
      lastRan = Date.now();
    } else {
      clearTimeout(lastFunc);
      lastFunc = setTimeout(function () {
        if (Date.now() - lastRan >= limit) {
          func.apply(context, args);
          lastRan = Date.now();
        }
      }, limit - (Date.now() - lastRan));
    }
  };
};

const headerLogo = document.querySelector("[data-header-logo]");
const handleHeaderLogo = function () {
  const scrollPosition = window.scrollY || document.documentElement.scrollTop;
  if (!headerLogo.classList.contains("js-scale")) {
    return;
  }
  headerLogo.classList.toggle("is-scale", scrollPosition > 100);
};
window.addEventListener("scroll", throttle(handleHeaderLogo, 100));

// ===== menu toggle =====
const [navTogglers, navbar] = [
  document.querySelectorAll("[data-nav-toggler]"),
  document.querySelectorAll("[data-navbar]"),
];
navTogglers.forEach((btn) => {
  btn.addEventListener("click", () => {
    const shouldBeActive = !btn.classList.contains("active");
    btn.classList.toggle("active");
    navbar.forEach((nav) => nav.classList.toggle("active", shouldBeActive));
    window.innerWidth < 1024 &&
      document.body.classList.toggle("active", shouldBeActive);
  });
});

// ===== accordion =====
const accordions = document.querySelectorAll("[data-accordion]");
for (let i = 0; i < accordions.length; i++) {
  accordions[i].addEventListener("click", function () {
    this.classList.toggle("active");
    const panel = this.nextElementSibling;
    if (panel) {
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    }
  });
}

// ===== handle tabs change =====
const initTabs = () => {
  const tabs = document.querySelectorAll("[data-tabs-items]");
  const contents = document.querySelectorAll("[data-tabs-content]");

  tabs.forEach((tab, index) => {
    tab.addEventListener("click", () => {
      // remove all class items/content
      tabs.forEach((t) => t.classList.remove("active"));
      contents.forEach((c) => c.classList.remove("active"));

      // add class item/click show/content
      tab.classList.add("active");
      contents[index].classList.add("active");
    });
  });
};

// ===== single projects =====
const swiperProjects = new Swiper("[data-projects-swiper]", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  speed: 600,
  slidesPerView: "auto",
  preloadImages: false,
  lazy: {
    loadPrevNext: true,
  },
  watchSlidesVisibility: true,
  breakpoints: {
    0: {
      spaceBetween: 10,
      draggable: true,
    },
    1024: {
      spaceBetween: 20,
      draggable: false,
    },
  },
  on: {
    beforeInit: function () {
      let numOfSlides = this.wrapperEl.querySelectorAll(".swiper-slide").length;
      document.querySelector(".slider-total").innerHTML = "/ " + numOfSlides;
    },
  },
});

// ===== init custom cursor =====
const initCustomCursor = () => {
  const cursorPrev = document.querySelector(".cursor-prev");
  const cursorNext = document.querySelector(".cursor-next");
  const swiper = document.querySelector("[data-projects-swiper]");

  if (!cursorPrev || !cursorNext || !swiper) return;

  document.addEventListener("mousemove", (e) => {
    cursorPrev.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
    cursorNext.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;

    const target = e.target;
    if (target.closest(".swiper-button-next")) {
      cursorNext.classList.add("active");
      cursorPrev.classList.remove("active");
    } else if (target.closest(".swiper-button-prev")) {
      cursorPrev.classList.add("active");
      cursorNext.classList.remove("active");
    } else {
      cursorPrev.classList.remove("active");
      cursorNext.classList.remove("active");
    }
  });

  swiper.addEventListener("mouseleave", () => {
    cursorPrev.classList.remove("active");
    cursorNext.classList.remove("active");
  });
};

// ### ===== DOM ===== ###
window.addEventListener("DOMContentLoaded", init);

/* -------------------------------- lightbox -------------------------------- */

const lightBox = document.querySelector(".p-detail__lightbox");
const imgLightbox = document.querySelectorAll(".p-detail__items img");
const iconClose = document.querySelector(".lightbox-icon");
const totalLightBox = document.querySelector(".lightbox-counter .total");
const swiperLightBox = document.getElementById("swiper-lightbox");
let currentLightBox = document.querySelector(".lightbox-counter .current");
let index = 0;
let swiperLb;

function swiperImages() {
  swiperLb = new Swiper(".lightbox-swiper", {
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    speed: 600,
    centeredSlides: true,
    slidesPerView: 1,
    loop: true,
    // initialSlide: index,
    on: {
      slideChange: function () {
        let currentSlide = this.realIndex + 1;
        document.querySelector(".lightbox-counter .current").innerHTML =
          currentSlide;
      },
      beforeInit: function () {
        totalLightBox.innerHTML = imgLightbox.length;

        let swiper = this;
        setTimeout(function () {
          let currentCaption = $(swiper.slides[swiper.activeIndex]).attr(
            "data-caption"
          );
          let currentTitle = $(swiper.slides[swiper.activeIndex]).attr(
            "data-title"
          );
          let currentContent = $(swiper.slides[swiper.activeIndex]).attr(
            "data-content"
          );

          if (currentTitle == "" && currentContent == "") {
            $(".lightbox-info").fadeOut();
          } else {
            $(".lightbox-info").fadeIn();
          }

          $(".lightbox-caption").html(function () {
            return "<h3>" + currentCaption + "</h3>";
          });
          $(".text-content h3").html(function () {
            return currentTitle;
          });
          $(".text-content .text-desc").html(function () {
            return currentContent;
          });
        }, 500);
      },
      slideChangeTransitionStart: function () {
        // Slide captions
        let swiper = this;
        setTimeout(function () {
          let currentCaption = $(swiper.slides[swiper.activeIndex]).attr(
            "data-caption"
          );
          let currentTitle = $(swiper.slides[swiper.activeIndex]).attr(
            "data-title"
          );
          let currentContent = $(swiper.slides[swiper.activeIndex]).attr(
            "data-content"
          );
        }, 500);
      },
      slideChangeTransitionEnd: function () {
        // Slide captions
        let swiper = this;
        let currentCaption = $(swiper.slides[swiper.activeIndex]).attr(
          "data-caption"
        );
        let currentTitle = $(swiper.slides[swiper.activeIndex]).attr(
          "data-title"
        );
        let currentContent = $(swiper.slides[swiper.activeIndex]).attr(
          "data-content"
        );

        if (currentTitle == "" && currentContent == "") {
          $(".lightbox-info").fadeOut();
        } else {
          $(".lightbox-info").fadeIn();
        }

        $(".lightbox-caption").html(function () {
          return "<h3>" + currentCaption + "</h3>";
        });
        $(".text-content h3").html(function () {
          return currentTitle;
        });
        $(".text-content .text-desc").html(function () {
          return currentContent;
        });
      },
    },
  });
}

swiperImages();
imgLightbox.forEach((item) => item.addEventListener("click", handleZoomImage));

function handleZoomImage(event) {
  document.body.classList.add("active");

  let image = event.target.getAttribute("key-items");
  index = [...imgLightbox].findIndex(
    (item) => item.getAttribute("key-items") === image
  );

  // console.log('index', index);
  swiperLb.slideTo(index + 1, 0);

  lightBox.classList.add("active");
}

// close lightbox
if (iconClose) {
  iconClose.addEventListener("click", function () {
    lightBox.classList.remove("active");
    document.body.classList.remove("active");
  });
}

const [textTogglers, text, close, hide] = [
  document.querySelectorAll("[data-text-toggler]"),
  document.querySelector("[data-text]"),
  document.querySelector("[data-text-close]"),
  document.querySelector("[hide]"),
];

const toggleText = function () {
  text.classList.toggle("active");
  hide.classList.toggle("hide");

  if (close.innerHTML == "info") {
    close.innerHTML = "close";
  } else {
    close.innerHTML = "info";
  }
};

// addEventOnElements(textTogglers, "click", toggleText);
