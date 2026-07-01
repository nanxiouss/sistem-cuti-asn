<nav x-data="{ open: false, profileOpen: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50 transition-all duration-300 supports-[backdrop-filter]:bg-white/60">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex justify-between h-20">

            <!-- Bagian Kiri: Logo & Title -->
            <div class="flex items-center gap-2 sm:gap-5">
                <a href="/" class="flex-shrink-0 flex items-center gap-3 sm:gap-4 group min-w-0">
                    <img src="/images/logo.png" alt="Logo Sumsel DESDM" class="h-8 sm:h-10 w-auto object-contain shrink-0">
                    <div class="leading-tight border-l-2 border-slate-200 pl-3 sm:pl-4 truncate">
                        <span class="text-lg sm:text-xl font-extrabold tracking-tighter text-slate-800 block">E-CUTI</span>
                        <p class="text-[8px] sm:text-[9px] font-bold text-rose-500 tracking-widest uppercase truncate">PANEL Kasubbag Umum & Kepegawaian</p>
                    </div>
                </a>
            </div>

            <!-- Bagian Tengah: Desktop Menu -->
            <div class="hidden md:flex items-center gap-1 bg-white/50 backdrop-blur-sm p-1 rounded-full border border-white/40 shadow-sm self-center">
                @php
                $navClass = "px-3 py-2 rounded-full text-sm font-medium transition-all duration-300 relative group overflow-hidden";
                $activeClass = "bg-slate-900 text-white shadow-md";
                $inactiveClass = "text-slate-600 hover:text-lime-500 hover:bg-white";
                @endphp

                <a href="{{ route('kasumum.dashboard') }}" class="{{ $navClass }} {{ request()->routeIs('kasumum.dashboard') ? $activeClass : $inactiveClass }}">Dashboard</a>
                <a href="{{ route('kasumum.persetujuan.index') }}" class="{{ $navClass }} {{ request()->routeIs('kasumum.persetujuan*') ? $activeClass : $inactiveClass }}">Persetujuan Cuti</a>
                <a href="{{ route('kasumum.pengajuan.create') }}" class="{{ $navClass }} {{ request()->routeIs('kasumum.pengajuan*') ? $activeClass : $inactiveClass }}">Pengajuan Cuti</a>
                <a href="{{ route('kasumum.riwayat.index') }}" class="{{ $navClass }} {{ request()->routeIs('kasumum.riwayat*') ? $activeClass : $inactiveClass }}">Riwayat</a>
                <a href="{{ route('kasumum.kalender.index') }}" class="{{ $navClass }} {{ request()->routeIs('kasumum.kalender*') ? $activeClass : $inactiveClass }}">Kalender</a>
            </div>

            <!-- Bagian Kanan: Profile & Mobile Menu Button -->
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                
                <!-- 1. Profile -->
                <div class="relative" @click.outside="profileOpen = false">
                    <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 cursor-pointer group focus:outline-none p-1 rounded-full hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-rose-500 to-rose-600 p-[2px]">
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                                <span class="font-bold text-sm text-rose-600">{{ substr(Auth::user()->nama, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="hidden sm:flex flex-col items-start justify-center text-left pr-1">
                            <span class="text-sm font-bold text-slate-700 group-hover:text-rose-600 transition leading-tight">{{ Auth::user()->nama }}</span>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-rose-50 text-rose-600 tracking-wider uppercase border border-rose-100 mt-1">Kasubbag Umum</span>
                        </div>
                    </button>
                    <!-- Dropdown Profile -->
                    <div x-show="profileOpen" x-transition class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/60 z-50 overflow-hidden" x-cloak>
                        <div class="px-5 py-4 bg-slate-50/50 border-b border-slate-100">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->nama }}</p>
                            <span class="text-[11px] font-semibold text-slate-500 bg-amber-50/80 px-2 py-0.5 rounded-md mt-1.5 inline-block">NIP. {{ Auth::user()->nip }}</span>
                        </div>
                        <div class="p-2"><a href="{{ route('profile.index') }}" class="block px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 hover:text-lime-600">Edit Profile</a></div>
                        <div class="p-2 border-t border-slate-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-rose-50 hover:text-rose-600">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 2. Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="open = !open" class="p-2 -mr-2 rounded-lg hover:bg-slate-100 transition text-slate-600">
                        <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        <svg x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="open" @click.away="open = false" class="md:hidden absolute top-full left-0 w-full bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xl z-40" x-cloak>
        <div class="px-4 pt-2 pb-4 space-y-2">
            <a href="{{ route('kasumum.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-600 hover:bg-slate-50">Dashboard</a>
            <a href="{{ route('kasumum.persetujuan.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-600 hover:bg-slate-50">Persetujuan Cuti</a>
            <a href="{{ route('kasumum.pengajuan.create') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-600 hover:bg-slate-50">Pengajuan Cuti</a>
            <a href="{{ route('kasumum.riwayat.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-600 hover:bg-slate-50">Riwayat</a>
            <a href="{{ route('kasumum.kalender.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-600 hover:bg-slate-50">Kalender</a>
        </div>
    </div>
</nav>