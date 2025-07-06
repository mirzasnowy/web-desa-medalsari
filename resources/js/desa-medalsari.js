// Mobile menu toggle
function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('active');
    // Toggle body scroll lock
    if (navLinks.classList.contains('active')) {
        document.body.style.overflow = 'hidden'; // Mencegah scroll saat menu mobile aktif
    } else {
        document.body.style.overflow = ''; // Mengembalikan scroll
    }
}

// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const headerOffset = document.querySelector('.header').offsetHeight;
            const elementPosition = target.getBoundingClientRect().top + window.scrollY;
            const offsetPosition = elementPosition - headerOffset - 10;

            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth"
            });

            const navLinks = document.querySelector('.nav-links');
            if (navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                document.body.style.overflow = ''; // Mengembalikan scroll setelah klik link di menu mobile
            }
        }
    });
});

// Auto-highlight active navigation link based on scroll position
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-links a');

    const options = {
        root: null,
        rootMargin: '-50% 0px -50% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => link.classList.remove('active'));
                const activeSectionId = entry.target.id;
                // Pastikan untuk tidak mengaktifkan link admin atau switch
                if (activeSectionId && activeSectionId !== 'darkModeToggle') {
                    const correspondingLink = document.querySelector(`.nav-links a[href="#${activeSectionId}"]`);
                    if (correspondingLink) {
                        correspondingLink.classList.add('active');
                    }
                }
            }
        });
    }, options);

    sections.forEach(section => {
        observer.observe(section);
    });
});


// Fade in animation on scroll (using IntersectionObserver)
const fadeElements = document.querySelectorAll('.fade-in');

const fadeInObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            // fadeInObserver.unobserve(entry.target); // Uncomment if you want animation only once
        } else {
            // entry.target.classList.remove('visible'); // Uncomment if you want element to hide when out of view
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
});

fadeElements.forEach(element => {
    fadeInObserver.observe(element);
});

// Counter animation for statistics (using IntersectionObserver)
function animateCounter(element, target) {
    let count = 0;
    const increment = target / 100;
    const timer = setInterval(() => {
        count += increment;
        if (count >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(count);
        }
    }, 20);
}

const statsSection = document.querySelector('.stats');
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                animateCounter(counter, target);
            });
            statsObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

if (statsSection) {
    statsObserver.observe(statsSection);
}

// Header background change on scroll (add 'scrolled' class)
window.addEventListener('scroll', () => {
    const header = document.querySelector('.header');
    if (window.scrollY > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Add interactive hover effects to cards (updated to include 3D transform)
const cards = document.querySelectorAll('.umkm-card-link'); // Select the link wrapping the card
cards.forEach(cardLink => {
    const card = cardLink.querySelector('.umkm-card');
    if (card) { // Ensure the card exists within the link
        cardLink.addEventListener('mouseenter', function() {
            // No direct style change here, rely on CSS :hover for transform
            // card.style.transform = 'translateY(-8px) rotateY(3deg)'; // Example 3D transform
            // card.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
        });

        cardLink.addEventListener('mouseleave', function() {
            // card.style.transform = 'translateY(0) rotateY(0)';
        });
    }
});


// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
    const navLinks = document.querySelector('.nav-links');
    const mobileMenu = document.querySelector('.mobile-menu');
    const darkModeSwitchLabel = document.querySelector('.dark-mode-switch'); // Mengambil label switch

    if (
        !navLinks.contains(e.target) &&
        !mobileMenu.contains(e.target) &&
        !darkModeSwitchLabel.contains(e.target) && // Memeriksa apakah klik di luar switch
        navLinks.classList.contains('active')
    ) {
        navLinks.classList.remove('active');
        document.body.style.overflow = ''; // Mengembalikan scroll
    }
});

// Add loading animation (fade in body on load)
window.addEventListener('load', () => {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';

    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});

// --- Fungsionalitas DARK MODE ---
document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle'); // Ini sekarang adalah input checkbox
    const body = document.body;

    // Fungsi untuk menerapkan mode (light/dark)
    function applyTheme(isDarkMode) {
        if (isDarkMode) {
            body.classList.add('dark-mode');
            body.classList.remove('light-mode');
            if (darkModeToggle) { // Periksa apakah elemen ada sebelum mengakses checked
                darkModeToggle.checked = true; // Pastikan checkbox juga checked
            }
            localStorage.setItem('theme', 'dark');
        } else {
            body.classList.remove('dark-mode');
            body.classList.add('light-mode');
            if (darkModeToggle) { // Periksa apakah elemen ada sebelum mengakses checked
                darkModeToggle.checked = false; // Pastikan checkbox juga unchecked
            }
            localStorage.setItem('theme', 'light');
        }
    }

    // Periksa preferensi pengguna dari localStorage saat halaman dimuat
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        applyTheme(true);
    } else if (savedTheme === 'light') {
        applyTheme(false);
    } else {
        // Jika belum ada preferensi, cek preferensi sistem operasi
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            applyTheme(true);
        } else {
            applyTheme(false);
        }
    }

    // Event listener untuk tombol toggle (sekarang checkbox)
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() { // Gunakan 'change' event untuk checkbox
            if (this.checked) { // 'this.checked' langsung memberikan state checkbox
                applyTheme(true);
            } else {
                applyTheme(false);
            }
        });
    }
});