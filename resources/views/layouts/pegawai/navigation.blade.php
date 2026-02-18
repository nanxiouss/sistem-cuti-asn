<nav x-data="{ open: false, profileOpen: false }"
    class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50 transition-all duration-300 supports-[backdrop-filter]:bg-white/60">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">

            <div class="flex items-center gap-4">
                <a href="{{ route('pegawai.dashboard') }}" class="flex-shrink-0 flex items-center gap-3 group">

                    <div class="relative w-10 h-10">
                        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="w-full h-full drop-shadow-sm">
                            <path d="M20 2L35.5885 11V29L20 38L4.41154 29V11L20 2Z"
                                class="fill-slate-900 group-hover:fill-blue-900 transition-colors duration-300" />
                            <path
                                d="M20 8C13.3726 8 8 13.3726 8 20C8 26.6274 13.3726 32 20 32C26.6274 32 32 26.6274 32 20"
                                stroke="white" stroke-width="2.5" stroke-linecap="round" />
                            <path d="M22 14L17 20H21L18 26" stroke="#FBBF24" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>

                    <div class="flex flex-col">
                        <h1
                            class="text-lg font-bold text-slate-900 tracking-tight leading-none group-hover:text-blue-700 transition-colors">
                            SITI ESDM
                        </h1>
                        <span class="text-[10px] font-bold text-slate-400 tracking-widest uppercase mt-0.5">
                            Kepegawaian
                        </span>
                    </div>
                </a>

                <div class="h-8 w-px bg-slate-300 hidden md:block"></div>
            </div>


            <div
                class="hidden md:flex items-center gap-1 bg-white/50 backdrop-blur-sm p-1 rounded-full border border-white/40 shadow-sm self-center">
                @php
                $navClass = "px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 relative group
                overflow-hidden";
                $activeClass = "bg-slate-900 text-white shadow-md";
                $inactiveClass = "text-slate-600 hover:text-blue-700 hover:bg-white";
                @endphp

                <a href="{{ route('pegawai.dashboard') }}"
                    class="{{ $navClass }} {{ request()->routeIs('pegawai.dashboard') ? $activeClass : $inactiveClass }}">
                    Dashboard
                </a>
                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">Ajukan Cuti</a>
                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">Kalender</a>
                <a href="#" class="{{ $navClass }} {{ $inactiveClass }}">Riwayat</a>
                <a href="{{ route('pegawai.regulasi.index') }}"
                    class="{{ $navClass }} {{ request()->routeIs('regulasi.*') ? $activeClass : $inactiveClass }}">
                    Regulasi
                </a>
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
                            <div
                                class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                                <span class="font-bold text-sm text-blue-700">
                                    {{ substr(Auth::user()->nama, 0, 1) }}
                                </span>
                            </div>
                        </div>

                        <div class="hidden sm:flex flex-col items-start justify-center text-left pr-1">
                            <span
                                class="text-sm font-bold text-slate-700 group-hover:text-blue-700 transition leading-tight">
                                {{ Auth::user()->nama }}
                            </span>
                            <span
                                class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-blue-50 text-blue-600 tracking-wider uppercase border border-blue-100 mt-1">
                                {{ Auth::user()->jabatan ?? 'Pegawai' }}
                            </span>
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
                            <p class="text-sm font-bold text-slate-800">{{ Auth::user()->nama }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->nip }}</p>
                        </div>

                        <div class="py-1">
                            <a href="#"
                                class="flex items-center px-5 py-2.5 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <i class="fas fa-user-edit w-4 h-4 mr-3"></i> Edit Profile
                            </a>
                        </div>

                        <div class="py-1 border-t border-slate-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center px-5 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i> Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</nav>