     // Přidání funkcionality pro přepínání recenzí
const reviewGallery = document.getElementById('reviewGallery');
const prevButton = document.getElementById('prevButton');
const nextButton = document.getElementById('nextButton');
const reviewItem1 = document.querySelector('.reviewItem1');
const reviewItem2 = document.querySelector('.reviewItem2');
let currentIndex = 0;

prevButton.addEventListener('click', function(){
    reviewItem1.style.display = "Block"
    reviewItem2.style.display = "None"
});
nextButton.addEventListener('click', function(){
    reviewItem1.style.display = "None"
    reviewItem2.style.display = "Block"
});