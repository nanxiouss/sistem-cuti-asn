<x-layouts.sekdin.app>
    <div class="w-full max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8" x-data="{ activeTab: 'Data Utama' }">

        {{-- Breadcrumb Dinamis --}}
        <nav class="flex mb-6 text-xs sm:text-sm text-slate-500 font-medium overflow-x-auto hide-scrollbar whitespace-nowrap pb-2">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('sekdin.dashboard') }}" class="hover:text-lime-600 transition-colors">Home</a></li>
                <li><span class="mx-2 text-slate-400">/</span></li>
                <li><a href="{{ route('profile.index') }}" class="hover:text-lime-600 transition-colors">Profil Saya</a></li>
                <li><span class="mx-2 text-slate-400">/</span></li>
                <li class="text-slate-800 font-bold" x-text="activeTab"></li>
            </ol>
        </nav>

        {{-- FLEXBOX LAYOUT (RESPONSIVE) --}}
        <div class="flex flex-col lg:flex-row gap-6 xl:gap-8 items-start">

            {{-- KOLOM 1: Card Profil & Menu Sidebar (KIRI) --}}
            <div class="w-full lg:w-[280px] xl:w-[300px] flex-shrink-0">
                <div class="bg-white rounded-3xl shadow-xl shadow-lime-500/10 border border-slate-200/60 overflow-hidden lg:sticky lg:top-28">
                    <div class="px-5 sm:px-6 pt-8 pb-6 text-center">

                        {{-- Foto Profil --}}
                        <div class="relative inline-block">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-gradient-to-tr from-lime-300 via-lime-500 to-amber-300 p-1 mx-auto shadow-md">
                                <div class="w-full h-full rounded-full border-4 border-white overflow-hidden bg-slate-100 flex items-center justify-center">

                                    @if(Auth::user()->pegawai && Auth::user()->pegawai->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->pegawai->foto_profil) }}" alt="Foto Profil {{ Auth::user()->nama }}" class="w-full h-full object-cover">
                                    @else
                                    <span class="text-2xl sm:text-3xl font-bold text-slate-400">
                                        {{ substr(Auth::user()->nama ?? 'U', 0, 1) }}
                                    </span>
                                    @endif

                                </div>
                            </div>
                            <div class="absolute bottom-1 right-1 bg-lime-500 text-white p-1.5 rounded-full border-2 border-white shadow-sm">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Info Singkat --}}
                        <h2 class="mt-5 text-lg sm:text-xl font-bold text-slate-900 tracking-tight">{{ Auth::user()->nama }}</h2>
                        <p class="mt-1 text-xs sm:text-sm font-bold text-lime-700 bg-lime-100 inline-block px-3 py-1 rounded-full border border-lime-200">
                            {{ Auth::user()->nip }}
                        </p>
                        <p class="mt-4 text-[11px] sm:text-xs text-slate-500 font-semibold uppercase tracking-wide">
                            {{ Auth::user()->pegawai->bidang->nama_bidang ?? 'Bidang Belum Di-set' }}
                        </p>

                        {{-- Tombol Aksi --}}
                        <div class="mt-6 flex flex-col gap-3">
                            <a href="{{ route('profile.edit') }}" class="w-full bg-gradient-to-r from-lime-300 to-amber-300 hover:from-lime-400 hover:to-amber-400 text-slate-900 font-bold py-2.5 px-4 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 text-sm transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                Edit Profil / TTD
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 bg-slate-50 p-3 sm:p-4">
                        <nav class="flex flex-col gap-1.5">
                            <a href="{{ route('sekdin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl text-slate-600 hover:bg-white hover:text-lime-600 hover:shadow-sm transition-all border border-transparent hover:border-slate-200">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                                Dashboard
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            {{-- KOLOM 2: Konten Utama & Tabs (TENGAH) --}}
            <div id="lihat-profil" class="flex-1 min-w-0 flex flex-col w-full">

                {{-- Navigasi Tab (Responsive scroll) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-2 pt-2 mb-6 overflow-hidden">
                    <ul class="flex overflow-x-auto hide-scrollbar whitespace-nowrap text-sm font-bold text-slate-500 snap-x snap-mandatory">
                        <template x-for="tab in ['Data Utama', 'Pangkat & Golongan', 'Jabatan & Bidang', 'Tanda Tangan']">
                            <li class="px-1 snap-start">
                                <button @click="activeTab = tab" :class="activeTab === tab ? 'text-lime-700 border-lime-500 bg-lime-50' : 'border-transparent hover:text-slate-800 hover:border-slate-300 hover:bg-slate-50'" class="px-4 sm:px-5 py-3 border-b-2 rounded-t-xl transition-all duration-200" x-text="tab">
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>

                {{-- TAB 1: DATA UTAMA --}}
                <div x-show="activeTab === 'Data Utama'" class="bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-200 p-1 sm:p-2">
                    <div class="flex flex-col">
                        {{-- PERBAIKAN: flex-col di mobile, flex-row di desktop --}}
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors rounded-t-2xl gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-500 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">Nama Lengkap</span>
                            </div>
                            <span class="text-sm font-bold text-slate-900 sm:text-right pl-11 sm:pl-0">{{ Auth::user()->nama }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-500 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">NIP (Nomor Induk Pegawai)</span>
                            </div>
                            <span class="text-sm font-bold text-slate-900 sm:text-right pl-11 sm:pl-0">{{ Auth::user()->nip }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-500 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">No. Telepon Aktif</span>
                            </div>
                            <span class="text-sm font-bold text-slate-900 sm:text-right pl-11 sm:pl-0">{{ Auth::user()->pegawai->no_telepon ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-500 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">Hak Akses Sistem (Role)</span>
                            </div>
                            <div class="pl-11 sm:pl-0">
                                <span class="text-[11px] font-bold uppercase tracking-wider bg-slate-800 px-3 py-1.5 rounded-md text-white shadow-sm inline-block">{{ Auth::user()->role }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 hover:bg-slate-50 transition-colors rounded-b-2xl gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-lime-100 border border-lime-200 rounded-lg text-lime-600 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">Sisa Kuota Cuti Tahunan</span>
                            </div>
                            <div class="pl-11 sm:pl-0">
                                <span class="text-sm font-bold text-lime-700 bg-lime-100 px-4 py-1.5 rounded-full border border-lime-300 shadow-sm inline-block">
                                    {{ Auth::user()->pegawai->sisa_cuti_tahunan ?? 12 }} Hari
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: PANGKAT & GOLONGAN --}}
                <div x-show="activeTab === 'Pangkat & Golongan'" class="bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-200 p-1 sm:p-2" style="display: none;">
                    <div class="flex flex-col">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors rounded-t-2xl gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-500 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">Pangkat / Golongan Ruang</span>
                            </div>
                            <span class="text-sm font-bold text-slate-900 sm:text-right pl-11 sm:pl-0">{{ Auth::user()->pegawai->pangkat_golongan ?? 'Belum Diisi' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 hover:bg-slate-50 transition-colors rounded-b-2xl gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-500 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">TMT Kerja <span class="hidden sm:inline">(Terhitung Mulai Tanggal)</span></span>
                            </div>
                            <span class="text-sm font-bold text-slate-900 sm:text-right pl-11 sm:pl-0">
                                {{ Auth::user()->pegawai->tmt_kerja ? \Carbon\Carbon::parse(Auth::user()->pegawai->tmt_kerja)->translatedFormat('d F Y') : 'Belum Diisi' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- TAB 3: JABATAN & BIDANG --}}
                <div x-show="activeTab === 'Jabatan & Bidang'" class="bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-200 p-1 sm:p-2" style="display: none;">
                    <div class="flex flex-col">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors rounded-t-2xl gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-500 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">Nama Jabatan</span>
                            </div>
                            <span class="text-sm font-bold text-slate-900 sm:text-right pl-11 sm:pl-0">{{ Auth::user()->pegawai->jabatan ?? 'Belum Diisi' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-500 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">Bidang / Sub Bagian</span>
                            </div>
                            <span class="text-sm font-bold text-slate-900 sm:text-right pl-11 sm:pl-0">{{ Auth::user()->pegawai->bidang->nama_bidang ?? 'Belum Diisi' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 hover:bg-slate-50 transition-colors rounded-b-2xl gap-2 sm:gap-0">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 border border-blue-200 rounded-lg text-blue-600 shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                                <span class="text-sm font-semibold text-slate-600">Atasan Penilai Langsung</span>
                            </div>
                            <div class="pl-11 sm:pl-0">
                                <span class="text-[13px] sm:text-sm font-bold text-blue-700 bg-blue-50 px-3 py-1.5 rounded-full border border-blue-200 inline-block mt-1 sm:mt-0 text-center">
                                    {{ Auth::user()->pegawai->atasan->nama ?? 'Sistem Penentuan Otomatis' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB 4: BERKAS TANDA TANGAN DIGITAL --}}
                <div x-show="activeTab === 'Tanda Tangan'" class="bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-200 p-5 sm:p-6 text-center" style="display: none;">
                    @if(!empty(Auth::user()->pegawai->foto_ttd))
                    <div class="inline-flex p-2 bg-lime-50 rounded-full mb-3 text-lime-600 justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <p class="text-slate-700 font-bold mb-4 text-sm">Tanda Tangan Digital Tersedia</p>
                    <div class="w-full max-w-xs mx-auto border-2 border-dashed border-lime-300 rounded-2xl bg-slate-50 p-4 sm:p-6 shadow-inner relative group">
                        <img src="{{ asset('storage/' . Auth::user()->pegawai->foto_ttd) }}" alt="Tanda Tangan Elektronik" class="max-h-24 sm:max-h-32 mx-auto mix-blend-multiply opacity-80 group-hover:opacity-100 transition-opacity w-auto object-contain">
                    </div>
                    <p class="text-[11px] sm:text-xs text-slate-400 mt-4 px-2">Pratinjau tanda tangan Anda untuk validasi formulir cuti resmi.</p>
                    @else
                    <div class="p-4 sm:p-5 bg-amber-50 border border-amber-200 rounded-2xl text-amber-800 text-xs sm:text-sm max-w-md mx-auto mb-4 flex items-start gap-3 text-left shadow-sm">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <span class="font-bold block mb-1">Tanda Tangan Belum Tersedia!</span>
                            <span class="leading-relaxed">Anda belum mengunggah file tanda tangan elektronik. Menu pembuatan cuti tidak dapat diakses sebelum berkas ini dilengkapi.</span>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

            {{-- KOLOM 3: Panel Informasi (KANAN) --}}
            <div class="w-full lg:w-[260px] xl:w-[280px] flex-shrink-0 mb-8 lg:mb-0">
                <div class="bg-gradient-to-b from-amber-50 to-orange-50/30 rounded-3xl border border-amber-200 shadow-lg shadow-amber-500/10 p-5 sm:p-6 lg:sticky lg:top-28">
                    <h3 class="text-sm font-bold text-amber-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Penting
                    </h3>
                    <div class="space-y-4 text-xs sm:text-[13px] text-amber-800/80 leading-relaxed break-words font-medium">
                        <p>Seluruh ringkasan informasi pada halaman ini terintegrasi langsung dengan database internal E-Cuti.</p>
                        <div class="h-px w-full bg-amber-200/60"></div>
                        <p class="text-red-600 font-bold bg-red-50 p-3 rounded-xl border border-red-100">
                            Pastikan data Bidang, Jabatan, dan Berkas Tanda Tangan sudah terisi dengan benar untuk menghindari kendala kegagalan validasi sistem saat mengajukan cuti baru.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-layouts.sekdin.app>