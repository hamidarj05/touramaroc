// Navbar change when scroll
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Annimation Hero 
document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.hero-slide');
    let currentSlideIndex = 0;

    function showNextSlide() {
        slides[currentSlideIndex].classList.remove('active');
        currentSlideIndex = (currentSlideIndex + 1) % slides.length;
        slides[currentSlideIndex].classList.add('active');
    }

    setInterval(showNextSlide, 5000);
});

// Destinations
document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('destinations-carousel');
    const dotsContainer = document.getElementById('destinations-dots');
    const cards = carousel.querySelectorAll('.destination-card');

    dotsContainer.innerHTML = '';

    const firstClone = cards[0].cloneNode(true);
    const lastClone = cards[cards.length - 1].cloneNode(true);

    carousel.appendChild(firstClone);
    carousel.insertBefore(lastClone, cards[0]);

    const allCards = carousel.querySelectorAll('.destination-card');
    const totalCards = allCards.length;

    let currentCardIndex = 1; 

    const card = allCards[0];
    const gap = parseFloat(window.getComputedStyle(card).marginRight) || 25;
    const cardWidth = card.getBoundingClientRect().width + gap;

    carousel.style.transform = `translateX(${-cardWidth * currentCardIndex}px)`;

    // Create ndots
    for (let i = 0; i < cards.length; i++) {
        const dot = document.createElement('span');
        dot.dataset.index = i;
        if (i === 0) dot.classList.add('active');

        dot.addEventListener('click', () => {
            currentCardIndex = i + 1; 
            moveCarousel();
            updateDots();
        });

        dotsContainer.appendChild(dot);
    }

    function moveCarousel() {
        carousel.style.transition = 'transform 0.5s ease-in-out';
        carousel.style.transform = `translateX(${-cardWidth * currentCardIndex}px)`;
    }

    function updateDots() {
        const dots = dotsContainer.querySelectorAll('span');
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentCardIndex - 1);
        });
    }

    // Loop
    carousel.addEventListener('transitionend', () => {
        if (currentCardIndex === 0) {
            carousel.style.transition = 'none';
            currentCardIndex = totalCards - 2; 
            carousel.style.transform = `translateX(${-cardWidth * currentCardIndex}px)`;
        } else if (currentCardIndex === totalCards - 1) {
            carousel.style.transition = 'none';
            currentCardIndex = 1; 
            carousel.style.transform = `translateX(${-cardWidth * currentCardIndex}px)`;
        }
    });

    setInterval(() => {
        currentCardIndex++;
        moveCarousel();
        updateDots();
    }, 5000);
});




// Activities
document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('activities-carousel');
    const dotsContainer = document.getElementById('activities-dots');
    const cards = carousel.querySelectorAll('.activity-card');  
    const prevBtn = document.querySelector('.carousel-prev');  
    const nextBtn = document.querySelector('.carousel-next');
    const filterButtons = document.querySelectorAll('.category-btn');

    dotsContainer.innerHTML = '';

    let currentIndex = 1;
    const cardWidth = cards[0].offsetWidth + 25;

    const firstClone = cards[0].cloneNode(true);
    const lastClone = cards[cards.length - 1].cloneNode(true);

    carousel.appendChild(firstClone);
    carousel.insertBefore(lastClone, cards[0]);

    const allCards = carousel.querySelectorAll('.activity-card');
    const totalCards = allCards.length;

    carousel.style.transform = `translateX(-${cardWidth * currentIndex}px)`;

    // Create dots 
    for (let i = 0; i < cards.length; i++) {
        const dot = document.createElement('span');
        dot.dataset.index = i;
        if (i === 0) dot.classList.add('active');

        dot.addEventListener('click', () => {
            currentIndex = i + 1;
            moveCarousel();
            updateDots();
        });

        dotsContainer.appendChild(dot);
    }

    function moveCarousel() {
        carousel.style.transition = 'transform 0.5s ease';
        carousel.style.transform = `translateX(-${cardWidth * currentIndex}px)`;
    }

    function updateDots() {
        const dots = dotsContainer.querySelectorAll('span');
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex - 1);
        });
    }

    // Loop 
    carousel.addEventListener('transitionend', () => {
        if (currentIndex === 0) {
            carousel.style.transition = 'none';
            currentIndex = totalCards - 2;
            carousel.style.transform = `translateX(-${cardWidth * currentIndex}px)`;
        } else if (currentIndex === totalCards - 1) {
            carousel.style.transition = 'none';
            currentIndex = 1;
            carousel.style.transform = `translateX(-${cardWidth * currentIndex}px)`;
        }
    });

    // Prev and Next button 
    prevBtn.addEventListener('click', () => {
        if (currentIndex <= 0) return;
        currentIndex--;
        moveCarousel();
        updateDots();
    });

    nextBtn.addEventListener('click', () => {
        if (currentIndex >= totalCards - 1) return;
        currentIndex++;
        moveCarousel();
        updateDots();
    });

    // Auto-scroll
    setInterval(() => {
        currentIndex++;
        moveCarousel();
        updateDots();
    }, 5000);

    // Filtering cards
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const category = btn.dataset.category;

            cards.forEach(card => {
                card.style.display = (category === 'all' || card.dataset.category === category) ? 'block' : 'none';
            });

            currentIndex = 1;
            moveCarousel();
            updateDots();
        });
    });
});



// Countdown
document.querySelectorAll('.countdown').forEach(timer => {
    const endTime = new Date(timer.dataset.end);

    setInterval(() => {
        const now = new Date();
        const timeLeft = endTime - now;
        const days = Math.max(Math.floor(timeLeft / (1000 * 60 * 60 * 24)), 0);
        timer.textContent = `${days} day${days !== 1 ? 's' : ''}`;
    }, 1000);
});
