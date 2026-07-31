document.addEventListener('DOMContentLoaded', () => {
    // Menambahkan class stop-scrolling ke body segera setelah DOM siap
    document.body.classList.add('stop-scrolling');

    const navbar = document.getElementById('navbar');
    const navItems = document.querySelectorAll('.nav-links .nav-item');
    const sections = document.querySelectorAll('section, footer');
    const reveals = document.querySelectorAll('.reveal');
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('nav-links');
    const menuIcon = menuToggle ? menuToggle.querySelector('i') : null;
    const loaderWrapper = document.getElementById('loader-wrapper');

    // Identifikasi apakah ini Landing Page
    const isLandingPage = document.getElementById('produk');

    // =========================================
    // FUNGSI MENGHILANGKAN LOADER (SAFE & SMOOTH)
    // =========================================
    let loaderHidden = false;

    function hideLoader() {
        if (loaderHidden) return; // Mencegah dipanggil dua kali
        loaderHidden = true;

        if (loaderWrapper) {
            loaderWrapper.classList.add('fade-out');
        }
        
        // Izinkan scroll kembali
        document.body.classList.remove('stop-scrolling');

        // Pemicu pengecekan elemen ter-reveal & scrollspy
        handleScrollSpyAndReveals();
        if (isLandingPage) {
            initializeScrollSpy();
        }
    }

    // A. Hilangkan loader saat seluruh halaman (gambar/aset) selesai dimuat
    window.addEventListener('load', () => {
        setTimeout(hideLoader, 500); // Jeda 0.5 detik agar transisi lebih alami
    });

    // B. FALLBACK PENGAMAN: Paksa hilang maksimal dalam 3 detik 
    // (Penting agar web tidak stuck jika ada gambar/iframe peta yang lambat)
    setTimeout(hideLoader, 25000);


    // =========================================
    // FUNGSI UMUM
    // =========================================

    function handleScrollSpyAndReveals() {
        const windowHeight = window.innerHeight;
        const scrollY = window.scrollY;

        // 1. Efek Navbar Saat Digulir
        if (navbar) {
            if (scrollY > 40) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }

        // 2. Trigger Reveal Animation
        reveals.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 120;
            
            if (elementTop < windowHeight - elementVisible) {
                element.classList.add('active');
            }
        });
    }

    function initializeScrollSpy() {
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
        
        updateActiveNavLink(currentSectionId);
    }

    function updateActiveNavLink(id) {
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href') === `#${id}`) {
                item.classList.add('active');
            }
        });
    }

    // =========================================
    // EVENT LISTENER
    // =========================================

    window.addEventListener('scroll', () => {
        if (loaderWrapper && loaderWrapper.classList.contains('fade-out')) {
            handleScrollSpyAndReveals();

            if (isLandingPage) {
                let currentSectionId = "";
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (window.scrollY >= (sectionTop - 160)) {
                        currentSectionId = section.getAttribute('id');
                    }
                });
                updateActiveNavLink(currentSectionId);
            }
        }
    });

    if (menuToggle && navLinks && menuIcon) {
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
    }
});