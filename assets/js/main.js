"use strict";

// setTimeout(function () {
//   if (
//     document.getElementsByTagName("html")[0].classList.contains("typesquare_option") !=
//     true
//   ) {
//     document.body.classList.remove("fadeout");
//   }
// }, 2000);

// const myInterval = setInterval(doStuff, 500);
// function doStuff() {
//   if (
//     document.getElementsByTagName("body")[0].classList.contains("typesquare_option")
//   ) {
//     clearInterval(myInterval);
//     document.body.classList.remove("fadeout");
//   }
// }

/* ------------------------------ refresh page ------------------------------ */

$(window).on("pageshow load", function () {
  setTimeout(function () {
    $("body").removeClass("fadeout");
  }, 1000);
});

/* --------------------------- resize mobile 100vh -------------------------- */

const appHeight = () => {
  const doc = document.documentElement;
  doc.style.setProperty(
    "--app-height",
    `${document.documentElement.clientHeight}px`
  );

  var windowHeight = Math.max(
    document.documentElement.clientHeight,
    window.innerHeight || 0
  );

  document.querySelector(".c-header__menu").style.height = windowHeight + "px";
};
window.addEventListener("resize", appHeight);
appHeight();

/* ------------------------------- check lang ------------------------------- */
const myBogo = setInterval(doBogo, 500);
const langBogo = document.querySelector(".bogo-language-switcher .current");

function doBogo() {
  if (langBogo.classList.contains("ja")) {
    langBogo.innerText = "JP";
    clearInterval(myBogo);
  } else {
    langBogo.innerText = "EN";
    clearInterval(myBogo);
  }
}

/* ---------------------------- lick link fadeout --------------------------- */

$(document).on("click", 'a[href^="#"]', function (e) {
  e.preventDefault();
});

$(document).on(
  "click",
  'a:not([href^="#"]):not([target]):not([href^="mailto"])',
  function (e) {
    e.preventDefault();
    const url = $(this).attr("href");

    if (url !== "") {
      const idx = url.indexOf("#");
      const hash = idx != -1 ? url.substring(idx) : "";

      if ($(hash).length > 0) {
        $("html, body").animate(
          {
            scrollTop: $(hash).offset().top,
          },
          300
        );
        return false;
      }

      $("body").addClass("fadeout");
      setTimeout(function () {
        window.location = url;
      }, 600);
    }
    return false;
  }
);

/* ----------------------------- scroll logo scale ----------------------------- */

const logoScale = document.querySelector(".c-header__logo.js-scale");

window.onscroll = function () {
  if (logoScale) {
    scrollFunction();
  }
};

const scrollFunction = () => {
  if (
    document.body.scrollTop > 100 ||
    document.documentElement.scrollTop > 100
  ) {
    logoScale.classList.add("is-scale");
  } else {
    logoScale.classList.remove("is-scale");
  }
};

/* ---------------------- add event on multiple element --------------------- */

const addEventOnElements = function (elements, eventType, callback) {
  for (let i = 0; i < elements.length; i++) {
    elements[i].addEventListener(eventType, callback);
  }
};

/* ------------------------- mobile nav menu toggle ------------------------- */

const [navTogglers, navLinks, navbar, navIcon, langSP] = [
  document.querySelectorAll("[data-nav-toggler]"),
  document.querySelectorAll("[data-nav-link]"),
  document.querySelector("[data-navbar]"),
  document.querySelector("[data-icon]"),
  document.querySelector("[data-lang-sp]"),
];

const toggleNav = () => {
  navbar.classList.toggle("active");
  navIcon.classList.toggle("active");
  langSP.classList.toggle("active");
  document.body.classList.toggle("active");
  document.body.classList.toggle("active");
};

addEventOnElements(navTogglers, "click", toggleNav);

const closeNav = () => {
  navbar.classList.remove("active");
  navIcon.classList.remove("active");
  document.body.classList.remove("active");
};

addEventOnElements(navLinks, "click", closeNav);

/* ------------------------------- tab switch ------------------------------- */
$(document).on("click", ".tab-link", function () {
  let tabID = $(this).attr("data-tab");

  $(this).addClass("active").siblings().removeClass("active");
  $("#tab-" + tabID)
    .addClass("active")
    .siblings()
    .removeClass("active");
});

/* --------------------------------- swiper --------------------------------- */
const deactiveButton = () => {
  if ($(".button-swiper").hasClass("swiper-button-disabled")) {
    $(".button-swiper").removeClass("swiper-button-disabled");
    $(".button-swiper").attr("aria-disabled", "false");
    $(".button-swiper").removeAttr("disabled");
  }
};

const swiperFunction = () => {
  if (document.querySelector(".swiperDetail")) {
    const swiper = new Swiper(".swiperDetail", {
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      speed: 600,
      slidesPerView: "auto",
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
          let numOfSlides =
            this.wrapperEl.querySelectorAll(".swiper-slide").length;
          document.querySelector(".slider-total").innerHTML =
            "/ " + numOfSlides;
        },
      },
    });

    // deactive button control
    deactiveButton();
    swiper.on("slideNextTransitionStart", function () {
      deactiveButton();
    });
    swiper.on("slidePrevTransitionStart", function () {
      deactiveButton();
    });
  }
};

swiperFunction();

/* ------------------------------ custom cursor ----------------------------- */

const cursorPrev = document.querySelector(".cursor-prev");
const cursorNext = document.querySelector(".cursor-next");

function mousemoveHandler(e) {
  const target = e.target;
  const tl = gsap.timeline({
    defaults: {
      x: e.clientX,
      y: e.clientY,
      ease: "power2.out",
    },
  });

  if (
    document.querySelector(".swiper-button-next") &&
    document.querySelector(".swiper-button-prev")
  ) {
    // hover section slider
    if (
      target.tagName.toLowerCase() === "button" &&
      target.closest(".swiper-button-next")
    ) {
      tl.to(cursorPrev, {
        opacity: 0,
      }).to(
        cursorNext,
        {
          opacity: 1,
        },
        "-=0.5"
      );
    } else if (
      target.tagName.toLowerCase() === "button" &&
      target.closest(".swiper-button-prev")
    ) {
      tl.to(cursorPrev, {
        opacity: 1,
      }).to(
        cursorNext,
        {
          opacity: 0,
        },
        "-=0.5"
      );
    } else {
      tl.to(".cursor", {
        opacity: 0,
      });
    }
  }
}

function mouseleaveHandler() {
  if (document.querySelector(".cursor")) {
    gsap.to(".cursor", {
      opacity: 0,
    });
  }
}

document.addEventListener("mousemove", mousemoveHandler);
document.addEventListener("mouseleave", mouseleaveHandler);

/* ---------------------- catch select href not working --------------------- */

$(function () {
  let isIOS =
    (/iPad|iPhone|iPod/.test(navigator.platform) ||
      (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1)) &&
    !window.MSStream;
  if (isIOS) {
    $("a").on("click touchend", function () {
      let link = $(this).attr("href");
      let target = $(this).attr("target");
      if (target === "_blank") {
        window.open(link, "blank"); // opens in new window as requested
        return false; // prevent anchor click
      }
    });
  }
});

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

  // deactive button control
  deactiveButton();
  swiperLb.on("slideNextTransitionStart", function () {
    deactiveButton();
  });
  swiperLb.on("slidePrevTransitionStart", function () {
    deactiveButton();
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

addEventOnElements(textTogglers, "click", toggleText);

/* ---------------------------- people accordion ---------------------------- */

let accordion = document.getElementsByClassName("js-accordion");
let panel = document.getElementsByClassName("p-people__panel");

if (panel) {
  for (let i = 0; i < accordion.length; i++) {
    accordion[i].addEventListener("click", function () {
      this.classList.toggle("active");
      $(this).next(".p-people__panel").slideToggle(300);
    });
  }
}

/* ---------------------------- english page ---------------------------- */

$(window).bind("load", function () {
  // URLにhogehogeが含まれていたら実行
  if (document.URL.match("/en/")) {
    $("body").addClass("en");
  }
});
