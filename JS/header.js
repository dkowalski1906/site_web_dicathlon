function checkVisible() {
    var rect = document.getElementById("main").getBoundingClientRect();
    var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
    return !(rect.bottom < 0 || rect.top - viewHeight >= 0);    
}


document.addEventListener("scroll", (event) => {
    const header = document.getElementById("header");
    console.log(checkVisible());
    if(checkVisible() === false){
        console.log(header);
        header.style.position = "fixed";
    }

    else{
        header.style.position = "relative";
    }
});
