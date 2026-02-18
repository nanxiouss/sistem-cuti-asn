<nav x-data="{ open: false, profileOpen: false }"
    class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50 transition-all duration-300 supports-[backdrop-filter]:bg-white/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">

            <div class="flex items-center gap-4">
                <div class="relative group">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl blur opacity-25 group-hover:opacity-50 transition duration-200">
                    </div>
                    <div
                        class="relative w-11 h-11 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>

                <div class="flex flex-col">
                    <h1 class="text-lg font-bold text-slate-900 tracking-tight leading-none">SITI ESDM</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span
                            class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-blue-50 text-blue-600 tracking-wider uppercase border border-blue-100">
                            {{ Auth::user()->jabatan ?? 'Pegawai' }}
                        </span>
                        <span class="text-xs font-semibold text-slate-500 truncate max-w-[150px]">
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-1">
                @php
                $navClass = "px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 flex items-center
                gap-2 border border-transparent";
                $activeClass = "bg-blue-50 text-blue-700 border-blue-100 shadow-sm shadow-blue-100/50";
                $inactiveClass = "text-slate-500 hover:text-slate-900 hover:bg-slate-50";
                @endphp

                <a href="{{ route('pegawai.dashboard') }}"
                    class="{{ $navClass }} {{ request()->routeIs('pegawai.dashboard') ? $activeClass : $inactiveClass }}">
                    Dashboard
                </a>
                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">Ajukan Cuti</a>
                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">Kalender</a>
                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">Riwayat</a>
                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">Regulasi</a>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <button
                    class="relative p-2.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all duration-200 focus:outline-none">
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </button>

                <div class="h-6 w-px bg-slate-200 mx-1 hidden sm:block"></div>

                <div class="relative" @click.outside="profileOpen = false">
                    <button @click="profileOpen = !profileOpen"
                        class="flex items-center gap-3 cursor-pointer group focus:outline-none p-1 rounded-full hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 p-[2px]">
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                <span class="font-bold text-sm text-blue-700">{{ substr(Auth::user()->name, 0, 1)
                                    }}</span>
                            </div>
                        </div>
                        <div class="hidden sm:block text-left pr-2">
                            <p class="text-xs font-bold text-slate-700 group-hover:text-blue-700 transition">Akun Saya
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div x-show="profileOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 py-2 z-50 origin-top-right"
                        style="display: none;">

                        <div class="px-5 py-3 border-b border-slate-50">
                            <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center px-5 py-2.5 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Edit Profile
                            </a>
                        </div>

                        <div class="py-1 border-t border-slate-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center px-5 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>