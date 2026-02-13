<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-CUTI | Dinas ESDM Provinsi Sumatera Selatan</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            /* scroll-behavior: smooth; <-- DIHAPUS agar JS yang handle */
        }
        
        :root {
            --esdm-green: #97C93E;
            --esdm-yellow: #F1B320;
            --esdm-black: #1E1E1E;
            --esdm-gray: #9D9D9C;
        }

        /* Navbar Glassmorphism */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        /* --- NAV LINKS --- */
        .nav-link-btn {
            position: relative;
            color: #475569;
            padding: 8px 16px;
            border-radius: 99px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .nav-link-btn:hover,
        .nav-link-btn.active { /* State Aktif */
            color: var(--esdm-green);
            background-color: rgba(151, 201, 62, 0.1);
            transform: translateY(-1px);
        }

        /* Hero Text Shadow */
        .hero-text {
            text-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        /* --- BUTTONS --- */
        .btn-glow-yellow {
            background: var(--esdm-yellow);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(241, 179, 32, 0.3);
        }

        .btn-glow-yellow:hover {
            transform: translateY(-3px);
            background: #ffc333;
            box-shadow: 0 10px 25px rgba(241, 179, 32, 0.5), 0 0 15px rgba(241, 179, 32, 0.3);
        }

        .btn-outline-hover {
            transition: all 0.3s ease;
        }

        .btn-outline-hover:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: white;
            transform: translateY(-3px);
        }

        /* --- GRADIENTS --- */
        .hero-gradient-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(to bottom, transparent, #ffffff);
            z-index: 2;
        }

        .section-gradient-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(to top, transparent, #ffffff);
            pointer-events: none;
        }

        /* --- CARDS --- */
        .card-feature {
            border-top: 5px solid var(--esdm-green);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: #f8fafc;
        }

        .card-feature:hover {
            transform: translateY(-15px) scale(1.02);
            background: white;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border-top-color: var(--esdm-yellow);
        }

        .card-feature:hover i {
            transform: scale(1.2) rotate(10deg);
        }

        /* --- AOS SUBTLE TRANSITION --- */
        [data-aos="fade-up-subtle"] {
            transform: translateY(20px);
            opacity: 0;
            transition-property: transform, opacity;
        }
        [data-aos="fade-up-subtle"].aos-animate {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</head>
<body class="bg-white text-slate-900">

    <nav class="fixed w-full z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/10/Coat_of_arms_of_South_Sumatra.svg/1200px-Coat_of_arms_of_South_Sumatra.svg.png" alt="Logo" class="h-10">
                    <div class="leading-tight border-l-2 border-slate-200 pl-4">
                        <span class="text-xl font-extrabold tracking-tighter text-slate-800 block">E-CUTI</span>
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.2em]">Dinas ESDM Sumsel</p>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-4">
                    <a href="#beranda" class="text-xs font-bold uppercase tracking-widest nav-link-btn active">Beranda</a>
                    <a href="#layanan" class="text-xs font-bold uppercase tracking-widest nav-link-btn">Layanan</a>
                    <a href="#kontak" class="text-xs font-bold uppercase tracking-widest nav-link-btn">Kontak</a>
                    
                    <a href="/login" class="ml-6 btn-glow-yellow px-8 py-2.5 rounded-lg text-xs font-black tracking-widest uppercase">LOGIN</a>
                </div>
            </div>
        </div>
    </nav>

    <section id="beranda" class="relative h-screen flex items-center justify-center text-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80" class="w-full h-full object-cover" alt="Background">
            <div class="absolute inset-0 bg-slate-900/75"></div>
            <div class="hero-gradient-bottom"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10 flex flex-col items-center">
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-8 rounded-full bg-white/10 backdrop-blur-md border border-white/20"
                     data-aos="fade-up-subtle" data-aos-duration="1000">
                    <span class="flex h-2 w-2 rounded-full bg-esdm-green"></span>
                    <span class="text-white text-[10px] font-bold tracking-[0.3em] uppercase">Official Internal Portal</span>
                </div>
                
                <h1 class="text-5xl md:text-8xl font-black text-white leading-[1.1] hero-text mb-8 tracking-tighter"
                    data-aos="fade-up-subtle" data-aos-duration="1000" data-aos-delay="200">
                    Sistem Manajemen <br> 
                    <span class="text-[#97C93E]">Cuti ASN Digital</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-200 mb-12 leading-relaxed max-w-2xl mx-auto font-light"
                   data-aos="fade-up-subtle" data-aos-duration="1000" data-aos-delay="400">
                    Transformasi birokrasi digital untuk kemudahan pengelolaan administrasi cuti di lingkungan Dinas ESDM Provinsi Sumatera Selatan.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-5 justify-center" 
                     data-aos="fade-up-subtle" data-aos-duration="1000" data-aos-delay="600">
                    <a href="#layanan" class="btn-glow-yellow px-10 py-4 rounded-xl text-white font-bold text-sm tracking-widest uppercase">
                        Mulai Sekarang
                    </a>
                    <a href="#kontak" class="btn-outline-hover bg-white/10 text-white px-10 py-4 rounded-xl font-bold text-sm tracking-widest uppercase border border-white/30">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="relative py-32 bg-white">
        <div class="section-gradient-top"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-xs font-black text-esdm-green uppercase tracking-[0.4em] mb-4">Core Excellence</h2>
                <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight">Layanan Digital Terpadu</h3>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="card-feature p-10 rounded-[2rem] shadow-sm group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-[#F1B320]/10 flex items-center justify-center rounded-2xl mb-8 transition-colors duration-300 group-hover:bg-[#F1B320]/20">
                        <i class="fas fa-file-signature text-3xl text-[#F1B320] transition-transform duration-300"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-slate-800">Pengajuan Mandiri</h4>
                    <p class="text-slate-500 leading-relaxed font-medium">Input data, pilih jenis cuti, dan unggah dokumen pendukung dalam hitungan menit secara digital.</p>
                </div>

                <div class="card-feature p-10 rounded-[2rem] shadow-sm group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-[#97C93E]/10 flex items-center justify-center rounded-2xl mb-8 transition-colors duration-300 group-hover:bg-[#97C93E]/20">
                        <i class="fas fa-tasks text-3xl text-[#97C93E] transition-transform duration-300"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-slate-800">Tracking Real-time</h4>
                    <p class="text-slate-500 leading-relaxed font-medium">Pantau status persetujuan pengajuan Anda mulai dari atasan langsung hingga tahap final secara transparan.</p>
                </div>

                <div class="card-feature p-10 rounded-[2rem] shadow-sm group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-slate-800/10 flex items-center justify-center rounded-2xl mb-8 transition-colors duration-300 group-hover:bg-slate-800/20">
                        <i class="fas fa-qrcode text-3xl text-slate-800 transition-transform duration-300"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-slate-800">E-Certificate</h4>
                    <p class="text-slate-500 leading-relaxed font-medium">Surat Izin Cuti diterbitkan otomatis lengkap dengan verifikasi digital yang sah dan siap cetak.</p>
                </div>
            </div>
        </div>
    </section>

    <footer id="kontak" class="bg-[#1A1A1A] text-white pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-16 mb-20">
                <div class="col-span-1 lg:col-span-1">
                    <div class="flex items-center gap-3 mb-8">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/10/Coat_of_arms_of_South_Sumatra.svg/1200px-Coat_of_arms_of_South_Sumatra.svg.png" class="h-10">
                        <span class="text-xl font-black tracking-tighter">E-CUTI</span>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">
                        Mewujudkan sistem administrasi kepegawaian yang modern, cepat, dan akuntabel di Sumatera Selatan.
                    </p>
                </div>

                <div>
                    <h5 class="text-sm font-black uppercase tracking-[0.2em] mb-8 text-esdm-green">Hubungi Kami</h5>
                    <ul class="space-y-4 text-sm text-slate-400 font-medium">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt mt-1 text-esdm-yellow"></i>
                            <span>Jl. Demang Lebar Daun No.225, Palembang, Sumsel</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-esdm-yellow"></i>
                            <span>desdm@sumselprov.go.id</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-sm font-black uppercase tracking-[0.2em] mb-8 text-esdm-green">Tautan Cepat</h5>
                    <ul class="space-y-4 text-sm text-slate-400 font-medium">
                        <li><a href="#" class="scroll-link hover:text-white transition-colors duration-300">Beranda</a></li>
                        <li><a href="https://desdm.sumselprov.go.id" class="hover:text-white transition-colors duration-300">Website ESDM</a></li>
                        <li><a href="https://sumselprov.go.id" class="hover:text-white transition-colors duration-300">Portal Pemprov</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-sm font-black uppercase tracking-[0.2em] mb-8 text-esdm-green">Lokasi Kantor</h5>
                    <div class="rounded-2xl overflow-hidden grayscale contrast-125 opacity-60 hover:opacity-100 transition-all duration-700">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.456382173614!2d104.73352731475685!3d-2.9710329978366477!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75df69167331%3A0xc3f98018e697394!2sDinas%20ESDM%20Provinsi%20Sumatera%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                            width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/5 pt-12 flex flex-col md:flex-row justify-between items-center text-[10px] font-bold text-slate-600 tracking-[0.3em] uppercase">
                <p>© 2026 Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</p>
                <div class="flex gap-8 mt-6 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init AOS
        AOS.init({ 
            once: true, 
            duration: 1000,
            easing: 'ease-out'
        });

        // --- SCRIPT CUSTOM SMOOTH SCROLL & ACTIVE STATE ---
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('.nav-link-btn, a[href^="#"]');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    
                    // Hanya jalankan jika link adalah internal anchor (#)
                    if (href.startsWith('#') && href.length > 1) {
                        e.preventDefault();
                        const targetId = href.substring(1);
                        const targetElement = document.getElementById(targetId);

                        if (targetElement) {
                            // Hitung posisi scroll dikurangi tinggi navbar (80px) agar judul tidak ketutup
                            const headerOffset = 90;
                            const elementPosition = targetElement.getBoundingClientRect().top;
                            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                            smoothScrollTo(offsetPosition, 1000); // Durasi 1200ms (1.2 detik)
                        }
                    }
                });
            });

            // Fungsi Smooth Scroll dengan Easing (easeInOutCubic)
            function smoothScrollTo(targetPosition, duration) {
                const startPosition = window.pageYOffset;
                const distance = targetPosition - startPosition;
                let startTime = null;

                function animation(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    const timeElapsed = currentTime - startTime;
                    
                    // Easing function: easeInOutCubic
                    const run = easeInOutCubic(timeElapsed, startPosition, distance, duration);
                    
                    window.scrollTo(0, run);

                    if (timeElapsed < duration) requestAnimationFrame(animation);
                }

                // Rumus matematika Easing
                function easeInOutCubic(t, b, c, d) {
                    t /= d / 2;
                    if (t < 1) return c / 2 * t * t * t + b;
                    t -= 2;
                    return c / 2 * (t * t * t + 2) + b;
                }

                requestAnimationFrame(animation);
            }

            // --- ACTIVE LINK HIGHLIGHTER ON SCROLL ---
            const sections = document.querySelectorAll('section, footer');
            const navItems = document.querySelectorAll('.nav-link-btn');

            window.addEventListener('scroll', () => {
                let current = '';
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    // Aktif jika scroll sudah melewati 1/3 section
                    if (pageYOffset >= (sectionTop - sectionHeight / 3)) {
                        current = section.getAttribute('id');
                    }
                });

                navItems.forEach(li => {
                    li.classList.remove('active');
                    if (li.getAttribute('href').includes(current)) {
                        li.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>