let currentIndex = 0;
const items = document.querySelectorAll('.custom-card2');
const totalItems = items.length;
const visibleItems = 3;

function updateCarousel() {
    const track = document.querySelector('.carousel-track');
    const itemWidth = items[0].offsetWidth;
    const newPosition = -currentIndex * itemWidth;
    track.style.transform = `translateX(${newPosition}px)`;
}

function nextSlide() {
    if (currentIndex < totalItems - visibleItems) {
        currentIndex++;
    } else {
        currentIndex = 0; // Retour au début si on atteint la fin
    }
    updateCarousel();
}

function prevSlide() {
    if (currentIndex > 0) {
        currentIndex--;
    } else {
        currentIndex = totalItems - visibleItems; // Va à la fin si on est au début
    }
    updateCarousel();
}

window.addEventListener('load', function () {
    setTimeout(function() {
        document.querySelector('.loader-container').style.display = 'none';
    }, 2000); // Le loader sera caché après 2s
});
