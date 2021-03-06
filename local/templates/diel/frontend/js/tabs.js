(function() {
  if (document.querySelector(".tabs")) {
    showActiveTab();
  
    document.addEventListener("click", function(evt) {
      if (evt.target.classList.contains("tabs__button")) {
        let tabsItem = document.querySelectorAll(".tabs__item");
  
        tabsItem.forEach(function(el) {
          el.classList.remove("tabs__item--active");
        });
  
        evt.target.parentNode.classList.add("tabs__item--active");
        showActiveTab();
      }
    });
  
    function showActiveTab() {
      let tabs = document.querySelector(".tabs"),
          tabsItem = tabs.querySelectorAll(".tabs__item"),
          tabsContent = document.querySelector(".tabs__content");

      let flag = false;

      
        tabsItem.forEach(function(el) {
          if (el.classList.contains("tabs__item--active")) {
            flag = true;
          }
        });

      if (flag) {
        tabsItem.forEach(function(el) {
          if (el.classList.contains("tabs__item--active")) {
            let tabsItemContent = el.querySelector(".tabs__item-content");
                clone = tabsItemContent.cloneNode(true);
            
            clone.style.display = "initial";
    
            tabsContent.innerHTML = "";
            tabsContent.appendChild(clone);
          }
        });
      } else {
        tabsItem[0].classList.add("tabs__item--active");
      
        tabsItem.forEach(function(el) {
          if (el.classList.contains("tabs__item--active")) {
            let tabsItemContent = el.querySelector(".tabs__item-content");
                clone = tabsItemContent.cloneNode(true);
            
            clone.style.display = "initial";
    
            tabsContent.innerHTML = "";
            tabsContent.appendChild(clone);
          }
        });
      }
    }
  }
})();