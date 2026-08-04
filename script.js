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

    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightboxModal = document.getElementById('lightbox-modal');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const lightboxClose = document.querySelector('.lightbox-close');

    // Logika Klik Foto untuk Membuka Lightbox
    galleryItems.forEach(item => {
        item.addEventListener('click', () => {
            const img = item.querySelector('img');
            const titleElement = item.querySelector('.gallery-caption h4');
            const title = titleElement ? titleElement.innerText : '';

            if (img && lightboxModal && lightboxImg) {
                lightboxImg.src = img.src;
                if (lightboxCaption) lightboxCaption.innerText = title;
                lightboxModal.classList.add('active');
                document.body.style.overflow = 'hidden'; // Mengunci scroll latar belakang
            }
        });
    });

    // Fungsi Menutup Lightbox
    function closeLightbox() {
        if (lightboxModal) {
            lightboxModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }

    if (lightboxModal) {
        lightboxModal.addEventListener('click', (e) => {
            if (e.target === lightboxModal) {
                closeLightbox();
            }
        });
    }

    // Menutup Lightbox dengan tombol ESC di keyboard
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightboxModal && lightboxModal.classList.contains('active')) {
            closeLightbox();
        }
    });

    // =========================================
    // FITUR 3D TILT EFFECT PADA KARTU PRODUK (SUDAH DIPERBAIKI)
    // =========================================
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left; 
            const y = e.clientY - rect.top;  
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = ((y - centerY) / centerY) * -10; 
            const rotateY = ((x - centerX) / centerX) * 10;

            // PERBAIKAN 1: Tambahkan translateY(-12px) di sini agar sejalan dan tidak bertabrakan dengan CSS .hover-float
            card.style.transform = `perspective(1000px) translateY(-12px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.03, 1.03, 1.03)`;
            
            // PERBAIKAN 2: Gunakan transisi 0.1s (bukan 'none') agar tidak ada efek kedut/getar saat kursor bergerak
            card.style.transition = 'transform 0.1s ease-out'; 
        });

        card.addEventListener('mouseleave', () => {
            // PERBAIKAN 3: Kosongkan nilai transform agar kembali mengikuti style CSS bawaannya dengan natural
            card.style.transform = ''; 
            card.style.transition = 'transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)'; 
        });
    });

    const scrollTopBtn = document.getElementById('scrollTopBtn');
    
    // Munculkan tombol saat di-scroll ke bawah lebih dari 400px
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            if (scrollTopBtn) scrollTopBtn.classList.add('show');
        } else {
            if (scrollTopBtn) scrollTopBtn.classList.remove('show');
        }
    });

    // Perintah kembali ke atas (secara halus) saat tombol diklik
    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});