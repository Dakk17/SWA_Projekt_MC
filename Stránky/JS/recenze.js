// Přidání funkcionality pro přepínání recenzí
const reviewGallery = document.getElementById('reviewGallery');
const prevButton = document.getElementById('prevButton');
const nextButton = document.getElementById('nextButton');
let currentIndex = 0;

prevButton.addEventListener('click', () => changeReview(-1));
nextButton.addEventListener('click', () => changeReview(1));

function changeReview(direction) {
    const reviewItems = document.querySelectorAll('.reviewItem');
    const totalReviews = reviewItems.length;

    currentIndex = (currentIndex + direction + totalReviews) % totalReviews;

    const displacement = -currentIndex * 320; // Šířka recenze + odstup
    reviewGallery.style.transform = `translateX(${displacement}px)`;
}
