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
        // Hide the loader after a small delay
        document.querySelector('.loader-container').style.display = 'none';

        // Show alert and wait for user confirmation
        alert('Ceci est un site fictif, il ne s\'agit en aucun cas du site officiel et tous documents géneres sont faux.');

        // After alert confirmation, trigger the text animation
        document.querySelector('.home-present-text').classList.add('animate-slideUp');
    }, 100); // Loader hides after 100ms
});

const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function (e) {
    // Toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    // Toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});

const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
const confirmPassword = document.querySelector('#password_c');

toggleConfirmPassword.addEventListener('click', function (e) {
    // Toggle the type attribute
    const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPassword.setAttribute('type', type);

    // Toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});

function toggleMenu() {
    var navbarNav = document.getElementById("navbarNav");
    navbarNav.classList.toggle("show");
}
