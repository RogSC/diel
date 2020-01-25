if (document.querySelector(".popup-request-call__form")) {
  ajaxForm(document.querySelector(".popup-request-call__form"));
}

if (document.querySelector(".main-search")) {
  document.querySelector(".main-search").addEventListener("submit", function(evt) {
    evt.preventDefault();

    let action = document.querySelector(".main-search").action,
        inputValue = document.querySelector(".main-search .main-search__input").value;

    fetch(action + inputValue);

    window.location = action + inputValue;
  });
  document.querySelector(".main-search").action += document.querySelector(".main-search__input").value;

}

function ajaxForm(form) {
	form.addEventListener('submit', function(e) {
    e.preventDefault();

    if (document.querySelector(".popup-successful") && form.classList.contains("popup-request-call__form")) {
      let popup = new Popup(".popup-successful");
      popup.showPopup();
    }

    fetch(
      form.getAttribute('action'),
        {
          method: 'POST', 
          body: new FormData(form),
          headers : { 
            'Content-Type': 'application/json',
            'Accept': 'application/json'
           }
        }
    	)
      .then(res => res.json())
      .then(res => {
        if (res.error) {

          console.log("Ошибка");
        }
        if(res.success) {

          console.log("Отправлено");
        }
      });
  });
}

function initTextarea(formID) {
    let textarea = document.querySelectorAll('#form_id_' + formID + " .textarea");

    for (let i = 0; i < textarea.length; i++) {
      addDiv(textarea[i]);
      console.log(textarea[i]);
    }

    function addDiv(node) {
        let div = document.createElement("div");
        
        div.classList.add("textarea-box");
        div.setAttribute("contenteditable", "true");
        div.innerText = node.placeholder;
        
        div.addEventListener("focus", focusDiv);
        div.addEventListener("blur", blurDiv);
        
        div.addEventListener("input", inputDiv);
        
        node.insertAdjacentElement("afterEnd", div);
        node.hidden = true;

        function focusDiv() {
            if (div.textContent == node.placeholder) {
                div.innerText = "";
                div.classList.add("textarea-box--focus");
                div.classList.remove("textarea-box--blur");
            }
        }
        
        function blurDiv() {
            if (div.textContent.length === 0) {
                div.innerText = node.placeholder;
                div.classList.add("textarea-box--blur");
                div.classList.remove("textarea-box--focus");
            }
        }
        
        function inputDiv() {
            node.value = div.innerText;
        }
    }
}

$(document).ready(function () {
    $("input[type=tel]").live('focus', function(){
        $("input[type=tel]").inputmask({
            mask: "+7(999)-999-99-99",
            showMaskOnHover: false
        });
    });
});
