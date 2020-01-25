$(document).ready(function () {
  let selectBtn = $(".diel-select__button");

  $(document).on("click", function (evt) {
    let target = $(evt.target);

    selectBtn.each(function () {
      if (target.is($(this)) || target.is($(this).find('*'))) {
        if ($(this).parent().hasClass('diel-select--active')) {
          $(this).parent().removeClass("diel-select--active");
        } else {
          $(this).parent().addClass("diel-select--active");
        }
      } else {
        $(this).parent().removeClass("diel-select--active");
      }
    });
  });
});



if (document.querySelector(".diel-select")) {
  let selectWrapper = document.querySelectorAll(".diel-select");

    selectWrapper.forEach(function(el) {
      let option = el.querySelectorAll(".filter__diel-option-js");

      if (option.length > 0) {
        el.querySelector(".diel-select__button-text").textContent = option[0].textContent;
      }
    });

  window.addEventListener("load", showSelect);

  window.addEventListener("resize", showSelect);

  function showSelect() {
    selectWrapper.forEach(function(el) {
      if (el.querySelector(".diel-select-list") && el.querySelector(".filter__diel-option-js")) {

        let option = el.querySelectorAll(".filter__diel-option-js");
    
        el.querySelector(".diel-select-list").innerHTML = "";
        for (let i = 0; i < option.length; i++) {
          let li = document.createElement("li");
    
          li.classList.add("diel-select-list__item");
          li.textContent = option[i].textContent;

          el.querySelector(".diel-select-list").appendChild(li);
        }

        el.querySelectorAll(".diel-select-list__item").forEach(function(el, index) {
          el.dataset.id = index;

          el.addEventListener("click", function() {
            this.parentElement.parentElement.querySelector(".filter__diel-js").selectedIndex = this.dataset.id;

            this.parentElement.parentElement.querySelector(".diel-select__button-text").textContent = option[this.dataset.id].textContent;

            this.parentElement.parentElement.querySelector(".filter__diel-js").dispatchEvent(new Event('change'));
          });
        });

        setSize();
      }
    });
  }

  function setSize() {
    selectWrapper.forEach(function(el) {
      let btn = el.querySelector(".diel-select__button"),
          btnText = btn.querySelector(".diel-select__button-text"),
          li = el.querySelectorAll(".diel-select-list__item"),
          option = el.querySelectorAll(".filter__diel-option-js"),
          selectedIndex = el.querySelector(".filter__diel-js").selectedIndex;

      let width = 0;

      li.forEach(function(el) {
        if (el.textContent.length > width) {
          width = el.textContent.length;
          btnText.textContent = el.textContent;
        }
      });

      // width = getComputedStyle(btn).width;
      width = btn.offsetWidth;
      btn.style.minWidth = `${width}px`;

      btnText.textContent = option[selectedIndex].textContent;
    });
  }

  // window.addEventListener("resize", function(evt) {
  //   console.log(a);
  //   selectWrapper.forEach(function(el) {
  //     let btn = el.querySelector(".diel-select__button"),
  //         btnText = btn.querySelector(".diel-select__button-text"),
  //         li = el.querySelectorAll(".diel-select-list__item");

  //     let width = 0;

  //     li.forEach(function(el) {
  //       btnText.textContent = el.textContent;

  //       if (btn.offsetWidth > width) width = btn.offsetWidth;
  //     });

  //     el.querySelector(".diel-select__button").style.width = width -  + 17 + "px";
  //   });
  // });

  window.addEventListener("reset", function(evt) {
    let selectWrapper = evt.target.querySelectorAll(".diel-select");

    selectWrapper.forEach(function(el) {
      let option = el.querySelectorAll(".filter__diel-option-js");

      let selectedIndex = el.querySelector(".filter__diel-js").selectedIndex;

      if (option.length > 0) {
        el.querySelector(".diel-select__button-text").textContent = option[selectedIndex].textContent;
      }
    });
  });
}




$(document).ready(function () {
  let minPriceRange = $(".filter__price-min").data("min");
  let maxPriceRange = $(".filter__price-max").data("max");

  let inputsRy = {
    sliderWidth: $(".filter__price-slider").width(),
    minRange: minPriceRange,
    maxRange: maxPriceRange,
    thumbWidth: $(".filter__price-slider-thumb").width(),
    theValue: [$(".filter__price-min").val(), $(".filter__price-max").val()] // theValue[0] < theValue[1]
  };

  let isDragging0 = false;
  let isDragging1 = false;

  let range = inputsRy.maxRange - inputsRy.minRange;
  let rangeK = inputsRy.sliderWidth / range;
  let container = $(".filter__price-slider-container");


  let slider = $(".filter__price-slider");
  slider.css('padding-left', (inputsRy.theValue[0] - inputsRy.minRange) * rangeK + "px");
  slider.css('padding-right', inputsRy.sliderWidth - inputsRy.theValue[1] * rangeK + "px");

  let track = $(".filter__price-slider-area");
  track.width(inputsRy.theValue[1] * rangeK - inputsRy.theValue[0] * rangeK + "px");

  let thumbs = $(".filter__price-slider-thumb");
  thumbs.each(function (i, e) {
    thumbs.eq(i).css('left', (inputsRy.theValue[i] - inputsRy.minRange) * rangeK - (inputsRy.thumbWidth / 2) + "px");
  });

  let outputs = $(".filter__price-input");
  outputs.each(function (i, e) {
    outputs.eq(i).val(inputsRy.theValue[i]);
  });


  thumbs.eq(0).on("mousedown", function () {
    isDragging0 = true;
  });
  thumbs.eq(1).on("mousedown", function () {
    isDragging1 = true;
  });
  container.on("mouseup", function () {
    isDragging0 = false;
    isDragging1 = false;
  });
  container.on("mouseout", function () {
    isDragging0 = false;
    isDragging1 = false;
  });

  container.on("mousemove", function (evt) {
    let mousePos = oMousePos(this, evt);
    let theValue0 = (isDragging0) ? Math.round(mousePos.x / rangeK) + inputsRy.minRange : inputsRy.theValue[0];
    let theValue1 = (isDragging1) ? Math.round(mousePos.x / rangeK) + inputsRy.minRange : inputsRy.theValue[1];

    if (isDragging0) {
      if (theValue0 < theValue1 - (inputsRy.thumbWidth / 2) &&
          theValue0 >= inputsRy.minRange) {
        inputsRy.theValue[0] = theValue0;
        thumbs.eq(0).css('left', (theValue0 - inputsRy.minRange) * rangeK - (inputsRy.thumbWidth / 2) + "px");
        outputs.eq(0).val(theValue0);
        slider.css('padding-left', (theValue0 - inputsRy.minRange) * rangeK + "px");
        track.width((theValue1 - theValue0) * rangeK + "px");
      }
    } else if (isDragging1) {

      if (theValue1 > theValue0 + (inputsRy.thumbWidth / 2) &&
          theValue1 <= inputsRy.maxRange) {
        inputsRy.theValue[1] = theValue1;
        thumbs.eq(1).css('left', (theValue1 - inputsRy.minRange) * rangeK - (inputsRy.thumbWidth / 2) + "px");
        outputs.eq(1).val(theValue1);
        slider.css('padding-right', (inputsRy.maxRange - theValue1) * rangeK + "px");
        track.width((theValue1 - theValue0) * rangeK + "px");
      }
    }
  });

  function oMousePos(el, evt) {
    let ClientRect = el.getBoundingClientRect();
    return {
      x: Math.round(evt.clientX - ClientRect.left),
      y: Math.round(evt.clientY - ClientRect.top)
    }
  }
});

