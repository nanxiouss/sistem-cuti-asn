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
</head>

<body class="bg-white text-slate-900" style="font-family: 'Inter', sans-serif;">

    <nav class="fixed w-full z-50 transition-all duration-300 ease-in-out" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="h-10">
                    <div class="leading-tight border-l-2 border-slate-200 pl-4">
                        <span class="text-xl font-extrabold tracking-tighter text-slate-800 block">E-CUTI</span>
                        <p class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.2em]">Dinas ESDM Sumsel</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="#beranda" class="text-xs font-bold uppercase tracking-widest nav-link-btn active relative text-slate-600 px-4 py-2 rounded-full transition-all duration-300 no-underline hover:text-[#97C93E] hover:bg-[#97C93E]/10 hover:-translate-y-[1px]">Beranda</a>
                    <a href="#layanan" class="text-xs font-bold uppercase tracking-widest nav-link-btn relative text-slate-600 px-4 py-2 rounded-full transition-all duration-300 no-underline hover:text-[#97C93E] hover:bg-[#97C93E]/10 hover:-translate-y-[1px]">Layanan</a>
                    <a href="#kontak" class="text-xs font-bold uppercase tracking-widest nav-link-btn relative text-slate-600 px-4 py-2 rounded-full transition-all duration-300 no-underline hover:text-[#97C93E] hover:bg-[#97C93E]/10 hover:-translate-y-[1px]">Kontak</a>
                    <a href="/login" class="ml-6 px-8 py-2.5 rounded-lg text-xs font-black tracking-widest uppercase bg-[#F1B320] text-white transition-all duration-300 ease-out hover:-translate-y-[3px] hover:bg-[#ffc333] hover:shadow-[0_10px_25px_rgba(241,179,32,0.5),0_0_15px_rgba(241,179,32,0.3)]" style="box-shadow: 0 4px 15px rgba(241, 179, 32, 0.3);">LOGIN</a>
                </div>

                <button id="mobile-menu-btn" class="md:hidden text-slate-700 hover:text-[#97C93E] focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="icon-bars" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path id="icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full">
            <div class="px-6 pt-4 pb-6 space-y-4 flex flex-col">
                <a href="#beranda" class="mobile-link text-sm font-bold uppercase tracking-widest text-slate-700 hover:text-[#97C93E]">Beranda</a>
                <a href="#layanan" class="mobile-link text-sm font-bold uppercase tracking-widest text-slate-700 hover:text-[#97C93E]">Layanan</a>
                <a href="#kontak" class="mobile-link text-sm font-bold uppercase tracking-widest text-slate-700 hover:text-[#97C93E]">Kontak</a>
                <a href="/login" class="text-center px-8 py-3 rounded-lg text-sm font-black tracking-widest uppercase mt-4 block bg-[#F1B320] text-white transition-all duration-300 ease-out hover:-translate-y-[3px] hover:bg-[#ffc333] hover:shadow-[0_10px_25px_rgba(241,179,32,0.5),0_0_15px_rgba(241,179,32,0.3)]" style="box-shadow: 0 4px 15px rgba(241, 179, 32, 0.3);">LOGIN</a>
            </div>
        </div>
    </nav>

    <section id="beranda" class="relative h-screen flex items-center justify-center text-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="/images/gedung-hero.jpg" class="w-full h-full object-cover" alt="Background">
            <div class="absolute inset-0 bg-slate-500/75"></div>
            <div class="absolute bottom-0 left-0 w-full z-[2]" style="height: 150px; background: linear-gradient(to bottom, transparent, #ffffff);"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 flex flex-col items-center">
            <div class="max-w-4xl">

                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-8 rounded-full bg-white/10 backdrop-blur-md border border-white/20" data-aos="fade-up" data-aos-duration="1000">
                    <span class="flex h-2 w-2 rounded-full bg-[#97C93E]"></span>
                    <span class="text-white text-[10px] font-bold tracking-[0.3em] uppercase">Official Internal Portal</span>
                </div>

                <div class="bg-black/40 backdrop-blur-md px-6 py-8 md:px-12 md:py-10 rounded-3xl border border-white/10 shadow-2xl mb-10">

                    <h1 class="text-5xl md:text-7xl font-bold text-white leading-[1.1] mb-6 tracking-tight" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        Sistem Informasi <br>
                        <span class="bg-gradient-to-r from-[#b3e853] to-[#f4d046] text-transparent bg-clip-text">Cuti Pegawai</span>
                    </h1>
                    <p class="text-lg md:text-xl text-slate-200 leading-relaxed max-w-2xl mx-auto font-light" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        Transformasi birokrasi digital untuk kemudahan pengelolaan administrasi cuti di lingkungan Dinas ESDM Provinsi Sumatera Selatan.
                    </p>

                </div>

                <div class="flex flex-col sm:flex-row gap-5 justify-center" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                    <a href="/login" class="px-10 py-4 rounded-xl text-white font-bold text-sm tracking-widest uppercase bg-[#F1B320] transition-all duration-300 ease-out hover:-translate-y-[3px] hover:bg-[#ffc333] hover:shadow-[0_10px_25px_rgba(241,179,32,0.5),0_0_15px_rgba(241,179,32,0.3)]" style="box-shadow: 0 4px 15px rgba(241, 179, 32, 0.3);">
                        Mulai Sekarang
                    </a>
                    <a href="#kontak" class="bg-white/10 text-white px-10 py-4 rounded-xl font-bold text-sm tracking-widest uppercase border border-white/30 transition-all duration-300 hover:bg-white/15 hover:border-white hover:-translate-y-[3px]">
                        Hubungi Kami
                    </a>
                </div>

            </div>
        </div>
    </section>

    <section id="layanan" class="relative py-32 bg-white">
        <div class="absolute top-0 left-0 w-full pointer-events-none" style="height: 100px; background: linear-gradient(to top, transparent, #ffffff);"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20 -mt-10" data-aos="fade-up">
                <h2 class="text-xs font-black text-[#97C93E] uppercase tracking-[0.4em] mb-4">KEUNGGULAN</h2>
                <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight">Layanan Digital Terpadu</h3>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-10 rounded-[2rem] shadow-sm group transition-all duration-[400ms] ease-[cubic-bezier(0.175,0.885,0.32,1.275)] hover:-translate-y-[15px] hover:scale-[1.02] hover:bg-white hover:shadow-2xl hover:border-t-[#F1B320]" style="border-top: 5px solid #97C93E; background: #f8fafc;" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-[#F1B320]/10 flex items-center justify-center rounded-2xl mb-8 transition-colors duration-300 group-hover:bg-[#F1B320]/20">
                        <i class="fas fa-file-signature text-3xl text-[#F1B320] transition-transform duration-300 group-hover:scale-[1.2] group-hover:rotate-[10deg]"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-slate-800">Pengajuan Mandiri</h4>
                    <p class="text-slate-500 leading-relaxed font-medium">Input data, pilih jenis cuti, dan unggah dokumen pendukung dalam hitungan menit secara digital.</p>
                </div>

                <div class="p-10 rounded-[2rem] shadow-sm group transition-all duration-[400ms] ease-[cubic-bezier(0.175,0.885,0.32,1.275)] hover:-translate-y-[15px] hover:scale-[1.02] hover:bg-white hover:shadow-2xl hover:border-t-[#F1B320]" style="border-top: 5px solid #97C93E; background: #f8fafc;" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-[#97C93E]/10 flex items-center justify-center rounded-2xl mb-8 transition-colors duration-300 group-hover:bg-[#97C93E]/20">
                        <i class="fas fa-tasks text-3xl text-[#97C93E] transition-transform duration-300 group-hover:scale-[1.2] group-hover:rotate-[10deg]"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-slate-800">Tracking Real-time</h4>
                    <p class="text-slate-500 leading-relaxed font-medium">Pantau status persetujuan pengajuan Anda mulai dari atasan langsung hingga tahap final secara transparan.</p>
                </div>

                <div class="p-10 rounded-[2rem] shadow-sm group transition-all duration-[400ms] ease-[cubic-bezier(0.175,0.885,0.32,1.275)] hover:-translate-y-[15px] hover:scale-[1.02] hover:bg-white hover:shadow-2xl hover:border-t-[#F1B320]" style="border-top: 5px solid #97C93E; background: #f8fafc;" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-slate-800/10 flex items-center justify-center rounded-2xl mb-8 transition-colors duration-300 group-hover:bg-slate-800/20">
                        <i class="fas fa-qrcode text-3xl text-slate-800 transition-transform duration-300 group-hover:scale-[1.2] group-hover:rotate-[10deg]"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-slate-800">Dokumen Sah</h4>
                    <p class="text-slate-500 leading-relaxed font-medium">Surat Izin Cuti diterbitkan otomatis lengkap dengan verifikasi digital yang sah dan siap cetak.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="w-full bg-white">
        <div class="h-32 bg-gradient-to-b from-white to-[#bcc0c0]"></div>
    </div>

    <footer id="kontak" class="bg-[#bcc0c0] text-white pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-16 mb-20">
                <div class="col-span-1 lg:col-span-1">
                    <div class="flex items-center gap-3 mb-8">
                        <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="h-10">
                        <span class="text-xl font-black tracking-tighter">E-CUTI</span>
                    </div>
                    <p class="text-slate-100 text-sm leading-relaxed font-medium">
                        Mewujudkan sistem administrasi kepegawaian yang modern, cepat, dan akuntabel di Sumatera Selatan.
                    </p>
                </div>

                <div>
                    <h5 class="text-sm font-black uppercase tracking-[0.2em] mb-8 text-[#5c5e58]">Hubungi Kami</h5>
                    <ul class="space-y-4 text-sm text-slate-100 font-medium">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt mt-1 text-[#5c5e58]"></i>
                            <span>Jl. Angkatan 45 No.2440, Demang Lebar Daun, Kec. Ilir Bar. I, Kota Palembang, Sumatera Selatan 30137</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-[#5c5e58]"></i>
                            <span>desdm@sumselprov.go.id</span>
                        </li>
                        <li class="flex items-end gap-3">
                            <i class="fas fa-phone text-[#5c5e58]"></i>
                            <span>(0711) 379040</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-sm font-black uppercase tracking-[0.2em] mb-8 text-[#5c5e58]">Tautan Cepat</h5>
                    <ul class="space-y-4 text-sm text-slate-100 font-medium">
                        <li><a href="#" class="scroll-link hover:text-white transition-colors duration-300">Beranda</a></li>
                        <li><a href="https://desdm.sumselprov.go.id" class="hover:text-white transition-colors duration-300">Website ESDM</a></li>
                        <li><a href="https://sumselprov.go.id" class="hover:text-white transition-colors duration-300">Portal Pemprov</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-sm font-black uppercase tracking-[0.2em] mb-8 text-[#5c5e58]">Lokasi Kantor</h5>
                    <div class="rounded-2xl overflow-hidden grayscale contrast-125 opacity-60 hover:opacity-100 transition-all duration-700">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1357.8803449734191!2d104.74257601074501!3d-2.9747395036781397!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75dd77fa7bad%3A0x7c3787e83297c183!2sDinas%20Energi%20Dan%20Sumber%20Daya%20Mineral!5e0!3m2!1sid!2sid!4v1770950657533!5m2!1sid!2sid" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
            once: true
            , duration: 1000
            , easing: 'ease-out'
        });

        // --- SCRIPT CUSTOM SMOOTH SCROLL & ACTIVE STATE ---
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('.nav-link-btn, a[href^="#"]');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');

                    if (href.startsWith('#') && href.length > 1) {
                        e.preventDefault();
                        const targetId = href.substring(1);
                        const targetElement = document.getElementById(targetId);

                        if (targetElement) {
                            const headerOffset = 90;
                            const elementPosition = targetElement.getBoundingClientRect().top;
                            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                            smoothScrollTo(offsetPosition, 1000);
                        }
                    }
                });
            });

            function smoothScrollTo(targetPosition, duration) {
                const startPosition = window.pageYOffset;
                const distance = targetPosition - startPosition;
                let startTime = null;

                function animation(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    const timeElapsed = currentTime - startTime;
                    const run = easeInOutCubic(timeElapsed, startPosition, distance, duration);
                    window.scrollTo(0, run);
                    if (timeElapsed < duration) requestAnimationFrame(animation);
                }

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

        // --- SCRIPT UNTUK MOBILE MENU ---
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconBars = document.getElementById('icon-bars');
        const iconClose = document.getElementById('icon-close');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            iconBars.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });

        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
                iconBars.classList.remove('hidden');
                iconClose.classList.add('hidden');
            });
        });

    </script>
</body>

</html>
