<x-layouts.pegawai.app>
    <div class="w-full max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-6" x-data="{ activeTab: 'Data Utama' }">

        {{-- Breadcrumb Dinamis --}}
        <nav class="flex mb-6 text-sm text-slate-500 font-medium">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('pegawai.dashboard') }}" class="hover:text-lime-600 transition-colors">Home</a></li>
                <li><span class="mx-2 text-slate-400">/</span></li>
                <li><a href="{{ route('profile.index') }}" class="hover:text-lime-600 transition-colors">Profil Saya</a></li>
                <li><span class="mx-2 text-slate-400">/</span></li>
                <li class="text-slate-800 font-bold" x-text="activeTab"></li>
            </ol>
        </nav>

        {{-- FLEXBOX LAYOUT --}}
        <div class="flex flex-col lg:flex-row gap-6 xl:gap-8 items-start">

            {{-- KOLOM 1: Card Profil & Menu Sidebar (KIRI) --}}
            <div class="w-full lg:w-[280px] xl:w-[300px] flex-shrink-0">
                <div class="bg-white rounded-3xl shadow-xl shadow-lime-500/20 border border-lime-200/60 overflow-hidden sticky top-28">
                    <div class="px-6 pt-8 pb-6 text-center">

                        {{-- Foto Profil --}}
                        <div class="relative inline-block">
                            <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-lime-500 to-lime-700 p-1 mx-auto shadow-md">
                                <div class="w-full h-full rounded-full border-4 border-white overflow-hidden bg-slate-100 flex items-center justify-center">

                                    {{-- Cek apakah user memiliki data pegawai dan ada foto profilnya --}}
                                    @if(Auth::user()->pegawai && Auth::user()->pegawai->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->pegawai->foto_profil) }}" alt="Foto Profil {{ Auth::user()->nama }}" class="w-full h-full object-cover">
                                    @else
                                    {{-- Fallback: Tampilkan Inisial jika belum ada foto --}}
                                    <span class="text-3xl font-bold text-slate-400">
                                        {{ substr(Auth::user()->nama ?? 'U', 0, 1) }}
                                    </span>
                                    @endif

                                </div>
                            </div>
                            <div class="absolute bottom-1 right-1 bg-amber-300 text-white p-1.5 rounded-full border-2 border-white shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Info Singkat dari DB --}}
                        <h2 class="mt-5 text-xl font-bold text-slate-900 tracking-tight">{{ Auth::user()->nama }}</h2>
                        <p class="mt-1 text-sm font-bold text-lime-600 bg-lime-50 inline-block px-3 py-1 rounded-full border border-lime-100">
                            {{ Auth::user()->nip }}
                        </p>
                        <p class="mt-4 text-xs text-slate-500 leading-relaxed font-medium uppercase tracking-wide">
                            {{ Auth::user()->pegawai->unit_kerja ?? 'Unit Kerja Belum Di-set' }}
                        </p>

                        {{-- Tombol Aksi --}}
                        <div class="mt-6 flex flex-col gap-3">
                            <a href="{{ route('profile.edit') }}" class="w-full bg-white hover:bg-slate-50 text-slate-700 font-semibold py-2.5 px-4 rounded-xl border border-slate-300 transition-all flex items-center justify-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                Edit Profil / TTD
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 bg-slate-50/50 p-4">
                        <nav class="flex flex-col gap-1.5">
                            <a href="{{ route('pegawai.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl text-slate-600 hover:bg-white hover:text-lime-600 hover:shadow-sm transition-all border border-transparent hover:border-slate-200">
                                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                {{-- Navigasi Tab Sesuai Kolom Database --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 px-2 pt-2 mb-6 overflow-hidden">
                    <ul class="flex overflow-x-auto hide-scrollbar whitespace-nowrap text-sm font-semibold text-slate-500">
                        <template x-for="tab in ['Data Utama', 'Pangkat & Golongan', 'Jabatan & Unit Kerja', 'Tanda Tangan']">
                            <li class="px-1">
                                <button @click="activeTab = tab" :class="activeTab === tab ? 'text-lime-700 border-lime-600' : 'border-transparent hover:text-slate-800 hover:border-slate-300'" class="px-4 py-3 border-b-2 transition-all duration-200" x-text="tab">
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>

                {{-- TAB 1: DATA UTAMA --}}
                <div x-show="activeTab === 'Data Utama'" class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-2 space-y-0">
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors rounded-t-2xl">
                            <span class="text-sm font-semibold text-slate-600">Nama Lengkap</span>
                            <span class="text-sm font-bold text-slate-900">{{ Auth::user()->nama }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <span class="text-sm font-semibold text-slate-600">NIP (Nomor Induk Pegawai)</span>
                            <span class="text-sm font-bold text-slate-900">{{ Auth::user()->nip }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <span class="text-sm font-semibold text-slate-600">No. Telepon Aktif</span>
                            <span class="text-sm font-bold text-slate-900">{{ Auth::user()->pegawai->no_telepon ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <span class="text-sm font-semibold text-slate-600">Hak Akses Sistem (Role)</span>
                            <span class="text-xs font-bold uppercase tracking-wider bg-slate-100 px-2.5 py-1 rounded-md text-slate-700 border border-slate-200">{{ Auth::user()->role }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 hover:bg-slate-50 transition-colors rounded-b-2xl">
                            <span class="text-sm font-semibold text-slate-600">Sisa Kuota Cuti Tahunan</span>
                            <span class="text-sm font-bold text-lime-600 bg-lime-50 px-3 py-1 rounded-full border border-lime-100">
                                {{ Auth::user()->pegawai->sisa_cuti_tahunan ?? 12 }} Hari
                            </span>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: PANGKAT & GOLONGAN --}}
                <div x-show="activeTab === 'Pangkat & Golongan'" class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-2" style="display: none;">
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors rounded-t-2xl">
                            <span class="text-sm font-semibold text-slate-600">Pangkat / Golongan ruang</span>
                            <span class="text-sm font-bold text-slate-900">{{ Auth::user()->pegawai->pangkat_golongan ?? 'Belum Diisi' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 hover:bg-slate-50 transition-colors rounded-b-2xl">
                            <span class="text-sm font-semibold text-slate-600">TMT Kerja (Terhitung Mulai Tanggal)</span>
                            <span class="text-sm font-bold text-slate-900">
                                {{ Auth::user()->pegawai->tmt_kerja ? \Carbon\Carbon::parse(Auth::user()->pegawai->tmt_kerja)->translatedFormat('d F Y') : 'Belum Diisi' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- TAB 3: JABATAN & UNIT KERJA --}}
                <div x-show="activeTab === 'Jabatan & Unit Kerja'" class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-2" style="display: none;">
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors rounded-t-2xl">
                            <span class="text-sm font-semibold text-slate-600">Nama Jabatan</span>
                            <span class="text-sm font-bold text-slate-900">{{ Auth::user()->pegawai->jabatan ?? 'Belum Diisi' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <span class="text-sm font-semibold text-slate-600">Unit Kerja Instansi</span>
                            <span class="text-sm font-bold text-slate-900">{{ Auth::user()->pegawai->unit_kerja ?? 'Belum Diisi' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 hover:bg-slate-50 transition-colors rounded-b-2xl">
                            <span class="text-sm font-semibold text-slate-600">Atasan Penilai Langsung</span>
                            <span class="text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                                {{ Auth::user()->pegawai->atasan->nama ?? 'Sistem Penentuan Otomatis (Berdasarkan Role)' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- TAB 4: BERKAS TANDA TANGAN DIGITAL --}}
                <div x-show="activeTab === 'Tanda Tangan'" class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-6 text-center" style="display: none;">
                    @if(!empty(Auth::user()->pegawai->foto_ttd))
                    <p class="text-slate-600 font-medium mb-4 text-sm">Pratinjau tanda tangan Anda untuk validasi formulir cuti resmi:</p>
                    <div class="max-w-xs mx-auto border border-dashed border-slate-300 rounded-2xl bg-slate-50 p-4">
                        <img src="{{ asset('storage/' . Auth::user()->pegawai->foto_ttd) }}" alt="Tanda Tangan Elektronik" class="max-h-32 mx-auto mix-blend-multiply">
                    </div>
                    @else
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-800 text-sm max-w-md mx-auto mb-4 font-medium flex items-center gap-2 text-left">
                        <svg class="w-6 h-6 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Anda belum mengunggah file tanda tangan elektronik. Menu pembuatan cuti tidak dapat diakses sebelum berkas ini dilengkapi.</span>
                    </div>
                    @endif
                </div>

            </div>

            {{-- KOLOM 3: Panel Informasi (KANAN) --}}
            <div class="w-full lg:w-[260px] xl:w-[280px] flex-shrink-0">
                <div class="bg-slate-50 rounded-3xl border border-amber-200/60 shadow-xl shadow-amber-500/20 p-6 sticky top-28">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Data
                    </h3>
                    <div class="space-y-4 text-xs text-slate-600 leading-relaxed break-words">
                        <p>Seluruh ringkasan informasi pada halaman ini terintegrasi langsung dengan database internal E-Cuti.</p>
                        <p class="text-red-500 font-medium italic">Pastikan data Pangkat, Jabatan, dan Berkas Tanda Tangan sudah terisi dengan benar untuk menghindari kendala kegagalan validasi sistem saat mengajukan cuti baru.</p>
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
</x-layouts.pegawai.app>
