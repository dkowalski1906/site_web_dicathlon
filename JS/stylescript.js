


var boutonShop = document.querySelectorAll("button.shop");

boutonShop.forEach(bouton => {
    bouton.addEventListener("click", function(){
        bouton.classList.toggle("active");
    })
});