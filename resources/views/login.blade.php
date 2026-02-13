<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-CUTI | Dinas ESDM Sumsel</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        :root {
            --esdm-green: #97C93E;
            --esdm-yellow: #F1B320;
        }

        /* --- BUTTON STYLE --- */
        .btn-glow-yellow {
            background: var(--esdm-yellow);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(241, 179, 32, 0.3);
        }

        .btn-glow-yellow:hover {
            transform: translateY(-2px);
            background: #ffc333;
            box-shadow: 0 10px 25px rgba(241, 179, 32, 0.5), 0 0 15px rgba(241, 179, 32, 0.3);
        }

        /* --- FORM INPUT STYLES --- */
        .form-input {
            width: 100%;
            background-color: #f8fafc;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            background-color: #ffffff;
            border-color: var(--esdm-green);
            box-shadow: 0 0 0 4px rgba(151, 201, 62, 0.1);
            outline: none;
        }

        /* Error State (Laravel Validation) */
        .form-input.is-invalid {
            border-color: #ef4444; /* Red-500 */
            background-color: #fef2f2;
        }
        
        .form-input:focus + .input-icon {
            color: var(--esdm-green);
        }

        .login-image-overlay {
            background: linear-gradient(to top, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.4));
        }
    </style>
</head>
<body class="bg-white h-screen overflow-hidden">

    <div class="flex h-full w-full">
        
        <div class="w-full lg:w-[45%] h-full flex flex-col justify-center px-8 sm:px-16 lg:px-24 bg-white relative z-10 overflow-y-auto">
            
            <div class="mb-12" data-aos="fade-down">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/10/Coat_of_arms_of_South_Sumatra.svg/1200px-Coat_of_arms_of_South_Sumatra.svg.png" 
                         alt="Logo" class="h-12 group-hover:scale-110 transition-transform duration-300">
                    <div class="leading-tight border-l-2 border-slate-200 pl-4">
                        <span class="text-2xl font-black tracking-tighter text-slate-800 block group-hover:text-esdm-green transition-colors">E-CUTI</span>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Dinas ESDM Sumsel</p>
                    </div>
                </a>
            </div>

            <div class="mb-10" data-aos="fade-up" data-aos-delay="100">
                <h1 class="text-4xl font-black text-slate-800 mb-3 tracking-tight">Selamat Datang</h1>
                <p class="text-slate-500 text-lg font-medium">Silakan login untuk mengakses dashboard.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6" data-aos="fade-up" data-aos-delay="200">
                @csrf <div class="space-y-2">
                    <label for="nip" class="text-xs font-bold text-slate-600 uppercase tracking-wider ml-1">NIP / Username</label>
                    <div class="relative group">
                        <input type="text" name="nip" id="nip" 
                               value="{{ old('nip') }}" required autofocus
                               placeholder="Masukkan 18 digit NIP" 
                               class="form-input py-4 pl-12 pr-4 rounded-xl text-slate-700 font-medium placeholder:text-slate-400 @error('nip') is-invalid @enderror">
                        
                        <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg input-icon"></i>
                    </div>
                    @error('nip')
                        <p class="text-red-500 text-xs mt-1 ml-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label for="password" class="text-xs font-bold text-slate-600 uppercase tracking-wider">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#97C93E] hover:underline">Lupa Password?</a>
                        @endif
                    </div>
                    <div class="relative group">
                        <input type="password" name="password" id="password" required
                               placeholder="Masukkan kata sandi" 
                               class="form-input py-4 pl-12 pr-12 rounded-xl text-slate-700 font-medium placeholder:text-slate-400 @error('password') is-invalid @enderror">
                        
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg input-icon"></i>
                        
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                     @error('password')
                        <p class="text-red-500 text-xs mt-1 ml-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center ml-1">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-[#97C93E] border-gray-300 rounded focus:ring-[#97C93E]">
                    <label for="remember_me" class="ml-2 block text-sm text-slate-500">
                        Ingat Saya
                    </label>
                </div>

                <button type="submit" class="w-full btn-glow-yellow py-4 rounded-xl font-bold text-sm tracking-[0.2em] uppercase mt-4">
                    Masuk Sekarang <i class="fas fa-arrow-right ml-2"></i>
                </button>

            </form>

            <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="300">
                <p class="text-xs text-slate-400 font-medium">
                    Belum punya akun? <a href="#" class="text-slate-800 font-bold hover:text-[#97C93E] transition">Hubungi Admin</a>
                </p>
                <div class="mt-8 text-[10px] text-slate-300 uppercase tracking-widest font-bold">
                    © 2026 Dinas ESDM Provinsi Sumatera Selatan
                </div>
            </div>
        </div>

        <div class="hidden lg:block lg:w-[55%] relative h-full bg-slate-900 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover opacity-80" 
                 alt="Office Building">
            
            <div class="absolute inset-0 login-image-overlay"></div>
            
            <div class="absolute top-0 right-0 p-12 opacity-20">
                <i class="fas fa-fingerprint text-9xl text-white"></i>
            </div>

            <div class="absolute bottom-0 left-0 w-full p-16 z-10">
                <div class="bg-white/10 backdrop-blur-md border border-white/10 p-8 rounded-3xl max-w-lg" data-aos="fade-right" data-aos-delay="400">
                    <div class="text-[#F1B320] text-3xl mb-4">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="text-white text-xl font-light leading-relaxed mb-6">
                        "Transformasi digital bukan sekadar tentang teknologi, tetapi tentang kemudahan, kecepatan, dan transparansi dalam pelayanan publik."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm uppercase tracking-wider">Kepala Dinas</h4>
                            <p class="text-slate-300 text-xs">ESDM Provinsi Sumatera Selatan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>