document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbar');
    const navItems = document.querySelectorAll('.nav-links .nav-item');
    const sections = document.querySelectorAll('section, footer');
    const reveals = document.querySelectorAll('.reveal');
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('nav-links');
    const menuIcon = menuToggle.querySelector('i');

    // Identifikasi apakah ini Landing Page dengan mengecek keberadaan section ber-ID "produk"
    const isLandingPage = document.getElementById('produk');

    // 1. Efek Pengecilan & Shadow Navbar Saat Layar Digulir (Tetap jalan di semua halaman)
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        // 2. Efek Scroll Spy (HANYA JALAN DI LANDING PAGE)
        if (isLandingPage) {
            let currentSectionId = "";
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= (sectionTop - 160)) {
                    currentSectionId = section.getAttribute('id');
                }
            });

            navItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href') === `#${currentSectionId}`) {
                    item.classList.add('active');
                }
            });
        }

        // 3. Trigger Reveal Animation saat Elemen Mulai Masuk Layar (Tetap jalan di semua halaman)
        reveals.forEach(element => {
            const windowHeight = window.innerHeight;
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 120; 
            
            if (elementTop < windowHeight - elementVisible) {
                element.classList.add('active');
            }
        });
    });

    // 4. Logika Menu Mobile (Hamburger Menu)
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        
        if (navLinks.classList.contains('active')) {
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-xmark');
        } else {
            menuIcon.classList.remove('fa-xmark');
            menuIcon.classList.add('fa-bars');
        }
    });

    const navItemsMobile = document.querySelectorAll('.nav-links .nav-item');
    navItemsMobile.forEach(item => {
        item.addEventListener('click', () => {
            navLinks.classList.remove('active');
            menuIcon.classList.remove('fa-xmark');
            menuIcon.classList.add('fa-bars');
        });
    });

    // 5. Pengecekan Scroll Spy Sekali Saat Halaman Dimuat (HANYA JALAN DI LANDING PAGE)
    if (isLandingPage) {
        let currentSectionId = "";
        const isBottom = (window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 20;
        
        if (isBottom) {
            currentSectionId = "kontak";
        } else {
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (window.scrollY >= (sectionTop - 160)) {
                    currentSectionId = section.getAttribute('id');
                }
            });
        }
        
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href') === `#${currentSectionId}`) {
                item.classList.add('active');
            }
        });
    }

    // Memicu pengecekan elemen ter-reveal langsung saat pertama kali web dibuka
    window.dispatchEvent(new Event('scroll'));
});