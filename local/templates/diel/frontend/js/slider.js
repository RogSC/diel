(function(){
  if (!document.querySelector(".jumping-slider__slider-wrapper")) return;

  let wrapper = document.querySelectorAll(".jumping-slider__slider-wrapper");

  wrapper.forEach(el => {
    initSlider(el);
  });

  function initSlider(el) {
    let jumpingSlider = tns({
      container: el.querySelector(".jumping-slider"),
      items: 1,
      controls: false,
      nav: false,
      navContainer: el.querySelector(".jumping-slider-options__nav"),
      touch: true,
      mouseDrag: true,

      speed: 1200,

      responsive: {
        "320": {
          fixedWidth: 263,
          gutter: 30
        },
        "768": {
          fixedWidth: 296,
        },
        "1200": {
          fixedWidth: 450,
          gutter: 0
        }
      }
    });

    // var customizedFunction = function (info, eventName) {
    //   console.log(info);
    //   let n = document.querySelector(".jumping-slider__item.tns-slide-active"),
    //       n2 = document.querySelector(".jumping-slider__item.tns-slide-active:nth-child(2n)");

    //   n.style.zIndex = "1";
    //   n2.style.zIndex = "2";
    // }

    // jumpingSlider.events.on('indexChanged', customizedFunction);
    // setInterval(function() {
    //   let n = document.querySelectorAll(".jumping-slider__item.tns-slide-active");

    //   for (let i = 0; i < n.length; i++) {
    //     if (i % 2) {
    //       n[i].style.zIndex = "2";
    //     } else {
    //       n[i].style.zIndex = "1";
    //     }
    //   }
    // }, 1);

    jumpingSlider.events.on('transitionEnd', function(info, eventName) {
      let n = document.querySelectorAll(".jumping-slider__slider-wrapper .jumping-slider__item.tns-slide-active");

      for (let i = 0; i < n.length; i++) {
        if (i == 1) {
          n[i].style.zIndex = "2";
          n[i].style.marginTop = "20px";
        } else if (i == 3) {
          n[i].style.zIndex = "0";
          n[i].style.marginTop = "20px";
        } else {
          n[i].style.zIndex = "1";
          n[i].style.marginTop = "140px";
        }
      }

      if (document.querySelector(".collection-information__slider-wrapper") || document.querySelector(".card-item__slider-wrapper")) {
        for (let i = 0; i < n.length; i++) {
          if (i == 1) {
            n[i].style.zIndex = "1";
            n[i].style.marginTop = "140px";
            n[i].style.opacity = ".6";
          } else if (i == 3) {
            n[i].style.zIndex = "0";
            n[i].style.marginTop = "140px";
          } else {
            n[i].style.zIndex = "2";
            n[i].style.marginTop = "20px";
            n[i].style.opacity = "1";
          }
        }
      }
    });

    let info, displays;

    if (el.querySelector(".jumping-slider__item")) {
      info = jumpingSlider.getInfo(),
          displays = info.slideCount;
    } else {
      el.querySelector(".jumping-slider-options").style.display = "none";
      return;
    }

    if (displays <= 1) {
      el.querySelector(".jumping-slider-options").style.display = "none";
    }


    // Добавить элементы
    let nav = el.querySelector(".jumping-slider-options__nav");

    for (let i = 0; i < displays; i++) {
      let item = document.createElement("div");
      item.classList.add("jumping-slider-options__item");
      if (i == 0) {
        item.classList.add("jumping-slider-options__item--active");
        item.classList.add("jumping-slider-options__item--current");
      }
      nav.appendChild(item);
    }

    let box = el.querySelector(".jumping-slider-options"),
        line = el.querySelector(".jumping-slider-options__progress-line"),
        navItems = el.querySelectorAll(".jumping-slider-options__item");


    initOptions();


    jumpingSlider.events.on('transitionStart', customizedFunction);

    function customizedFunction(info) {
      let i = info.displayIndex - 1,
          item = navItems[i],
          X = item.offsetLeft;

      removeCurrent();
      checkActive(X);
      item.classList.add("jumping-slider-options__item--current");
      item.classList.add("jumping-slider-options__item--active");
      moveLine(X);
    }

    function initOptions() {
      navItems.forEach((el, index) => {
        el.addEventListener("click", evt => {
          jumpingSlider.goTo(index);

          removeCurrent();
          checkActive(el.offsetLeft);
          evt.target.classList.add("jumping-slider-options__item--current");
          evt.target.classList.add("jumping-slider-options__item--active");
          moveLine(el.offsetLeft);
        });
      });
    }


    function moveLine(X) {
      line.style.width = X + "px";
    }

    // Выделить все элементы за активным
    function checkActive(X) {
      navItems.forEach(el => {
        let itemX = el.offsetLeft;

        el.classList.remove("jumping-slider-options__item--active");

        if (itemX <= X) {
          el.classList.add("jumping-slider-options__item--active");
        }
      });
    }

    // Снять все Current
    function removeCurrent() {
      navItems.forEach(el => {
        el.classList.remove("jumping-slider-options__item--current");
      });
    }
  }


  let wrapperFaq = document.querySelector(".jumping-slider__slider-wrapper-faq");

  if (wrapperFaq) {
    initSliderFaq(wrapperFaq);
  }

  function initSliderFaq(el) {
    let jumpingSlider = tns({
      container: el.querySelector(".jumping-slider"),
      items: 1,
      controls: false,
      nav: false,
      navContainer: el.querySelector(".jumping-slider-options__nav"),
      touch: true,
      mouseDrag: true,

      speed: 1200,

      responsive: {
        "320": {
          fixedWidth: 263,
          gutter: 30
        },
        "768": {
          fixedWidth: 296,
        },
        "1200": {
          fixedWidth: 700,
          gutter: 0
        }
      }
    });

    jumpingSlider.events.on('transitionEnd', function(info, eventName) {
      let n = document.querySelectorAll(".jumping-slider__slider-wrapper-faq .jumping-slider__item.tns-slide-active");

      for (let i = 0; i < n.length; i++) {
        if (i == 1) {
          n[i].style.zIndex = "2";
          n[i].style.marginTop = "20px";
        } else if (i == 3) {
          n[i].style.zIndex = "0";
          n[i].style.marginTop = "20px";
        } else {
          n[i].style.zIndex = "1";
          n[i].style.marginTop = "140px";
        }
      }

      if (document.querySelector(".collection-information__slider-wrapper-faq") || document.querySelector(".card-item__slider-wrapper")) {
        for (let i = 0; i < n.length; i++) {
          if (i == 1) {
            n[i].style.zIndex = "1";
            n[i].style.marginTop = "140px";
            n[i].style.opacity = ".6";
          } else if (i == 3) {
            n[i].style.zIndex = "0";
            n[i].style.marginTop = "140px";
          } else {
            n[i].style.zIndex = "2";
            n[i].style.marginTop = "20px";
            n[i].style.opacity = "1";
          }
        }
      }
    });

    let info, displays;

    if (el.querySelector(".jumping-slider__item")) {
      info = jumpingSlider.getInfo();
          displays = info.slideCount;
    } else {
      el.querySelector(".jumping-slider-options").style.display = "none";
      return;
    }

    if (displays <= 1) {
      el.querySelector(".jumping-slider-options").style.display = "none";
    }


    // Добавить элементы
    let nav = el.querySelector(".jumping-slider-options__nav");

    for (let i = 0; i < displays; i++) {
      let item = document.createElement("div");
      item.classList.add("jumping-slider-options__item");
      if (i == 0) {
        item.classList.add("jumping-slider-options__item--active");
        item.classList.add("jumping-slider-options__item--current");
      }
      nav.appendChild(item);
    }

    let box = el.querySelector(".jumping-slider-options"),
        line = el.querySelector(".jumping-slider-options__progress-line"),
        navItems = el.querySelectorAll(".jumping-slider-options__item");


    initOptions();


    jumpingSlider.events.on('transitionStart', customizedFunction);

    function customizedFunction(info) {
      let i = info.displayIndex - 1,
          item = navItems[i],
          X = item.offsetLeft;

      removeCurrent();
      checkActive(X);
      item.classList.add("jumping-slider-options__item--current");
      item.classList.add("jumping-slider-options__item--active");
      moveLine(X);
    }

    function initOptions() {
      navItems.forEach((el, index) => {
        el.addEventListener("click", evt => {
          jumpingSlider.goTo(index);

          removeCurrent();
          checkActive(el.offsetLeft);
          evt.target.classList.add("jumping-slider-options__item--current");
          evt.target.classList.add("jumping-slider-options__item--active");
          moveLine(el.offsetLeft);
        });
      });
    }


    function moveLine(X) {
      line.style.width = X + "px";
    }

    // Выделить все элементы за активным
    function checkActive(X) {
      navItems.forEach(el => {
        let itemX = el.offsetLeft;

        el.classList.remove("jumping-slider-options__item--active");

        if (itemX <= X) {
          el.classList.add("jumping-slider-options__item--active");
        }
      });
    }

    // Снять все Current
    function removeCurrent() {
      navItems.forEach(el => {
        el.classList.remove("jumping-slider-options__item--current");
      });
    }
  }


})();


$(document).ready(function () {
  let slider = $('.product-slider'),
      sliderNav = $('.product-slider-nav'),
      slides = $('.product-slide');

  slider.slick({
    dots: false,
    arrows: false,
    variableWidth: true,
    infinite: false,
    asNavFor: '.product-slider-nav'
  });
  sliderNav.slick({
    dots: false,
    arrows: false,
    asNavFor: '.product-slider',
    slidesToShow: slides.length,
    slidesToScroll: slides.length,
    infinite: false,
    focusOnSelect: true,
    draggable: false
    /*responsive: [
      {
        breakpoint: 1920,
        settings: {
          slidesToShow: slides.length,
          slidesToScroll: slides.length
        }
      }
    ]*/
  });

  $(document).on('click', function (e) {
    let target = $(e.target),
        prevArrow = $('.prev'),
        nextArrow = $('.next');

    if (target.is(prevArrow)) {
      slider.slick('slickPrev');
    }
    if (target.is(nextArrow)) {
      slider.slick('slickNext');
    }
  });

  slider.on('afterChange', function () {
    $('.product-slide.slick-current').children().append('<div class="prev"></div><div class="next"></div>')
  });

  slider.on('beforeChange', function () {
    $('.next').remove();
    $('.prev').remove();

  });


  let navItem = $('.product-slider-nav__item');

  navItem.eq(0).addClass('active');
  $('.product-slide').each(function () {
    $(this).show();
  });

  navItem.on('click', function () {
    $(this).addClass('active');
    $(this).parent().prevAll().children().removeClass('active');
    $(this).parent().nextAll().children().removeClass('active');
    $(this).parent().prevAll().children().addClass('prev_active');
    $(this).parent().prevAll('.product-slider-nav__item-wrap').addClass('active');
    $(this).parent().nextAll('.product-slider-nav__item-wrap').removeClass('active');
    $(this).parent().removeClass('active');
  });

  navItem.hover(function () {
    $(this).parent().prev().addClass('active');
  }, function () {
    if (!$(this).hasClass('prev_active') && !$(this).hasClass('active')) {
      $(this).parent().prev().removeClass('active');
    }
  });

  sliderNav.on('afterChange', function () {
    let curSlideNav = $('.product-slider-nav__item-wrap.slick-current');

    curSlideNav.prev().addClass('active');
    curSlideNav.removeClass('active');

    curSlideNav.children().addClass('active');
    curSlideNav.nextAll().children().removeClass('active');
    curSlideNav.prevAll().children().removeClass('active');
    curSlideNav.prevAll().children().addClass('prev_active');
  });



  let slideText = $('.stocks-slider__text');

  slideText.eq(0).show().css('opacity', 1);

  slider.on('afterChange', function () {
    slideText.fadeTo(300, 0);
    slides.each(function (i, e) {
      if ($(this).hasClass('slick-current')) {
        slideText.eq(i).show().fadeTo(300, 1);
      }
    });
  });
});