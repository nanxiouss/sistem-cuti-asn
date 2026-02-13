<nav x-data="{ open: false, profileOpen: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">

            <div class="flex items-center shrink-0 gap-3">
                <div
                    class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-blue-200 shadow-lg">
                    S
                </div>
                <div class="leading-tight">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">SITI ESDM</h1>
                    <p class="text-[10px] font-bold text-slate-400 tracking-widest uppercase">Kepegawaian</p>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-1">
                @php
                $navClass = "px-4 py-2.5 rounded-xl text-sm font-medium transition-all flex items-center gap-2";
                $activeClass = "bg-blue-50 text-blue-700 font-bold";
                $inactiveClass = "text-slate-500 hover:text-blue-600 hover:bg-slate-50";
                @endphp

                <a href="{{ route('pegawai.dashboard') }}"
                    class="{{ $navClass }} {{ request()->routeIs('pegawai.dashboard') ? $activeClass : $inactiveClass }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>

                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Ajukan Cuti
                </a>

                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Kalender
                </a>

                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat
                </a>

                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Regulasi
                </a>
            </div>

            <div class="flex items-center gap-4">
                <button class="relative p-2 text-slate-400 hover:text-slate-600 transition">
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </button>

                <div class="h-8 w-[1px] bg-slate-200 mx-1 hidden sm:block"></div>

                <div class="relative" @click.outside="profileOpen = false">
                    <button @click="profileOpen = !profileOpen"
                        class="flex items-center gap-3 pl-2 cursor-pointer group focus:outline-none">
                        <div class="text-right hidden sm:block leading-tight">
                            <div class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-slate-500 uppercase">{{ Auth::user()->jabatan ?? 'Pegawai' }}
                            </div>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 font-bold flex items-center justify-center border-2 border-white shadow-sm group-hover:bg-blue-100 group-hover:text-blue-600 transition">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>

                    <div x-show="profileOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50"
                        style="display: none;">

                        <div class="px-4 py-2 border-b border-slate-50 text-xs text-slate-400">
                            Kelola Akun
                        </div>
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600">Profile</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>