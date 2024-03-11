const image = document.querySelectorAll(".picture")     
var numb = 0

function change(img){
    if(numb == 0){
        for(const [key, val] of Object.entries(image)){
            val.style.pointerEvents = "none";
        };

        img.style.transition = "0.5s"
        img.style.position = "absolute"
        img.style.width = "1280px";
        img.style.height = "768px";
        img.style.zIndex = 100;
        img.style.pointerEvents = "all"
        numb++;


    } else {
        numb--;
        for(const [key, val] of Object.entries(image)){
            val.style.pointerEvents = "all";
            val.style.position = "Inherit";
            val.style.transition = "none";
        };

        img.style.width = "640px";
        img.style.height = "360px";
        img.style.zIndex = 0;
    }
}


console.log(image)

