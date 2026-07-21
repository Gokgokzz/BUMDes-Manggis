document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbar');
    const navItems = document.querySelectorAll('.nav-links .nav-item');
    const sections = document.querySelectorAll('section, footer');
    const reveals = document.querySelectorAll('.reveal');
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('nav-links');
    const menuIcon = menuToggle.querySelector('i');

    // 1. Efek Pengecilan & Shadow Navbar Saat Layar Digulir
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        // 2. Efek Scroll Spy (Menu Otomatis Menyala Mengikuti Section Layar Aktif)
        let currentSectionId = "";
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            // Deteksi jika area layar sedang aktif di sepertiga atas window
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

        // 3. Trigger Reveal Animation saat Elemen Mulai Masuk Layar
        reveals.forEach(element => {
            const windowHeight = window.innerHeight;
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 120; // memicu transisi 120px sebelum objek terlihat penuh
            
            if (elementTop < windowHeight - elementVisible) {
                element.classList.add('active');
            }
        });
    });

        menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        
        // Mengubah ikon hamburger menjadi ikon 'X' saat menu terbuka
        if (navLinks.classList.contains('active')) {
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-xmark');
        } else {
            menuIcon.classList.remove('fa-xmark');
            menuIcon.classList.add('fa-bars');
        }
    });

    // Otomatis menutup menu kembali ketika salah satu link menunya di-klik
    const navItemsMobile = document.querySelectorAll('.nav-links .nav-item');
    navItemsMobile.forEach(item => {
        item.addEventListener('click', () => {
            navLinks.classList.remove('active');
            menuIcon.classList.remove('fa-xmark');
            menuIcon.classList.add('fa-bars');
        });
    });

    // 2. Efek Scroll Spy (Menu Otomatis Menyala Mengikuti Section Layar Aktif)
    let currentSectionId = "";
    
    // Cek apakah posisi scroll sudah mentok ke bagian paling bawah halaman
    const isBottom = (window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 20;
    if (isBottom) {
        // Jika mentok bawah, langsung setel ke kontak
        currentSectionId = "kontak";
    } else {
        // Jika belum mentok, gunakan deteksi posisi seperti biasa
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            // Deteksi jika area layar sedang aktif di sepertiga atas window
            if (window.scrollY >= (sectionTop - 160)) {
                currentSectionId = section.getAttribute('id');
            }
        });
    }
    // Terapkan class active ke menu yang sesuai
    navItems.forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('href') === `#${currentSectionId}`) {
            item.classList.add('active');
        }
    });

    // Memicu pengecekan elemen ter-reveal langsung saat pertama kali web dibuka
    window.dispatchEvent(new Event('scroll'));
});

