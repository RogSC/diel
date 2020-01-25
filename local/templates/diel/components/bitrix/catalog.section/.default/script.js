if (document.querySelector(".page-filter")) {
  let select = document.querySelectorAll(".page-filter .filter__diel-js");

  select.forEach(el => {
    el.addEventListener("change", () => {
      fetch(window.location.origin + el.value);
      window.location = el.value;
    });

  });
}

window.addEventListener("load", function() {
  let div = document.querySelectorAll(".filter__diel-select");
  
  
  div.forEach(function(el) {
    if (el.querySelector(".filter__diel-js")) {
      let id = el.querySelector(".filter__diel-js").selectedIndex;
      el.querySelector(".diel-select__button-text").textContent = el.querySelectorAll(".filter__diel-option-js")[id].textContent;
    }
  });
});