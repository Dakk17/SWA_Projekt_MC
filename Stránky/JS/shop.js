let currentIndex = 0;
const items = document.querySelectorAll('.carousel-item');

items.forEach((item, index) => {
    if (index === currentIndex) {
        item.style.display = 'block';
    } else {
        item.style.display = 'none';
    }
});

document.querySelector('.carousel-arrow.left').addEventListener('click', () => {
    currentIndex--;
    if (currentIndex < 0) {
        currentIndex = items.length - 1;
    }
    updateCarousel();
});

document.querySelector('.carousel-arrow.right').addEventListener('click', () => {
    currentIndex++;
    if (currentIndex >= items.length) {
        currentIndex = 0;
    }
    updateCarousel();
});

function updateCarousel() {
    items.forEach((item, index) => {
        if (index === currentIndex) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
