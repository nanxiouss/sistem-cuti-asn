@extends('layouts.pegawai.app')

@section('content')
{{-- max-w-[1500px] agar bisa sangat lebar di monitor besar tapi tidak pecah --}}
<div class="w-full max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-6" x-data="{ activeTab: 'Data Utama' }">

    {{-- Breadcrumb Dinamis --}}
    <nav class="flex mb-6 text-sm text-slate-500 font-medium">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('pegawai.dashboard') }}" class="hover:text-lime-600 transition-colors">Home</a></li>
            <li><span class="mx-2 text-slate-400">/</span></li>
            <li><a href="#" class="hover:text-lime-600 transition-colors">Profil Saya</a></li>
            <li><span class="mx-2 text-slate-400">/</span></li>
            <li class="text-slate-800 font-bold" x-text="activeTab"></li>
        </ol>
    </nav>

    {{-- FLEXBOX LAYOUT (Kiri Tetap - Tengah Cair - Kanan Tetap) --}}
    <div class="flex flex-col lg:flex-row gap-6 xl:gap-8 items-start">

        {{-- KOLOM 1: Card Profil & Menu Sidebar (KIRI) --}}
        <div class="w-full lg:w-[280px] xl:w-[300px] flex-shrink-0">
            <div class="bg-white rounded-3xl shadow-xl shadow-lime-500/20 border border-lime-200/60 overflow-hidden sticky top-28">
                <div class="px-6 pt-8 pb-6 text-center">
                    
                    {{-- Foto Profil --}}
                    <div class="relative inline-block">
                        <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-lime-500 to-lime-700 p-1 mx-auto shadow-md">
                            <div class="w-full h-full rounded-full border-4 border-white overflow-hidden bg-slate-100 flex items-center justify-center">
                                <span class="text-3xl font-bold text-slate-400">
                                    {{ substr(Auth::user()->nama ?? 'Bambang', 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="absolute bottom-1 right-1 bg-amber-300 text-white p-1.5 rounded-full border-2 border-white shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>

                    {{-- Info Singkat --}}
                    <h2 class="mt-5 text-xl font-bold text-slate-900 tracking-tight">{{ Auth::user()->nama ?? 'Bambang Pamungkas' }}</h2>
                    <p class="mt-1 text-sm font-bold text-lime-600 bg-lime-50 inline-block px-3 py-1 rounded-full border border-lime-100">
                        {{ Auth::user()->nip ?? '198501012010011001' }}
                    </p>
                    <p class="mt-4 text-xs text-slate-500 leading-relaxed font-medium uppercase tracking-wide">
                        {{ Auth::user()->unit_kerja ?? 'Bidang Ketenagalistrikan' }}
                    </p>

                    {{-- Tombol Aksi --}}
                    <div class="mt-6 flex flex-col gap-3">
                        {{-- TOMBOL DIUBAH DI SINI: Ditambahkan fungsi scroll ke tengah --}}
                        <button @click="document.getElementById('kolom-tengah').scrollIntoView({ behavior: 'smooth' }); activeTab = 'Data Utama'" class="w-full bg-lime-600 hover:bg-lime-500 text-white font-semibold py-2.5 px-4 rounded-xl shadow-lime-500/30 transition-all duration-300 shadow-sm shadow-lime-200 flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat Profil
                        </button>
                        <a href="#" class="w-full bg-white hover:bg-slate-50 text-slate-700 font-semibold py-2.5 px-4 rounded-xl border border-slate-300 transition-all flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Profil
                        </a>
                    </div>
                </div>

                <div class="border-t border-slate-100 bg-slate-50/50 p-4">
                    <nav class="flex flex-col gap-1.5">
                        <a href="{{ route('pegawai.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl text-slate-600 hover:bg-white hover:text-lime-600 hover:shadow-sm transition-all border border-transparent hover:border-slate-200">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl text-slate-600 hover:bg-white hover:text-lime-600 hover:shadow-sm transition-all border border-transparent hover:border-slate-200">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Layanan ASN
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl text-slate-600 hover:bg-white hover:text-lime-600 hover:shadow-sm transition-all border border-transparent hover:border-slate-200">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                            Layanan Lainnya
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        {{-- KOLOM 2: Konten Utama & Tabs (TENGAH) --}}
        {{-- WRAPPER DIUBAH DI SINI: Ditambahkan id="kolom-tengah" --}}
        <div id="lihat-profil" class="flex-1 min-w-0 flex flex-col w-full">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 px-2 pt-2 mb-6 overflow-hidden">
                <ul class="flex overflow-x-auto hide-scrollbar whitespace-nowrap text-sm font-semibold text-slate-500">
                    <template x-for="tab in ['Data Utama', 'Golongan', 'Jabatan', 'Posisi', 'Pendidikan', 'Profesi', 'Keluarga', 'Kontrak PPPK']">
                        <li class="px-1">
                            <button 
                                @click="activeTab = tab"
                                :class="activeTab === tab ? 'text-lime-700 border-lime-600' : 'border-transparent hover:text-slate-800 hover:border-slate-300'"
                                class="px-4 py-3 border-b-2 transition-all duration-200"
                                x-text="tab">
                            </button>
                        </li>
                    </template>
                </ul>
            </div>

            <div x-show="activeTab === 'Jabatan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-2" style="display: none;">
                <div class="flex flex-col">
                    <div class="flex items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors rounded-t-2xl">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-600">Jenis Jabatan</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900 text-right">Jabatan Fungsional</span>
                    </div>

                    <div class="flex items-center justify-between p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-lime-50 text-lime-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-600">Nama Jabatan</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900 text-right">Pranata Komputer Ahli Pertama</span>
                    </div>

                    <div class="flex items-center justify-between p-4 hover:bg-slate-50 transition-colors rounded-b-2xl">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-300 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-600">TMT Jabatan</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900 text-right">1 Maret 2024</span>
                    </div>
                </div>
            </div>

            <div x-show="activeTab !== 'Jabatan'" style="display: none;" class="bg-slate-50 rounded-3xl border border-slate-200 border-dashed p-10 text-center mt-2">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                <p class="text-slate-500 font-medium">Informasi <span x-text="activeTab" class="font-bold text-slate-700"></span> akan ditampilkan di sini.</p>
            </div>
        </div>

        {{-- KOLOM 3: Panel Informasi (KANAN) --}}
        <div class="w-full lg:w-[260px] xl:w-[280px] flex-shrink-0">
            <div class="bg-slate-50 rounded-3xl border border-amber-200/60 shadow-xl shadow-amber-500/20 p-6 sticky top-28">
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Lihat Profil
                </h3>
                <div class="space-y-4 text-xs text-slate-600 leading-relaxed break-words">
                    <p>Halaman ini menampilkan informasi pokok ASN yang bersumber dari SIASN.</p>
                    <p>Data yang ditampilkan mencakup:</p>
                    <ul class="space-y-2">
                        <li><strong class="text-slate-800">Data Utama:</strong> Informasi dasar ASN seperti nama lengkap, NIP, tempat dan tanggal lahir, jenis kelamin, dan status kepegawaian.</li>
                        <li><strong class="text-slate-800">Golongan:</strong> Riwayat pangkat dan golongan ASN termasuk tanggal pengangkatan.</li>
                        <li><strong class="text-slate-800">Jabatan:</strong> Informasi mengenai jabatan struktural atau fungsional yang pernah atau sedang diemban.</li>
                    </ul>
                    <div class="mt-4 pt-4 border-t border-slate-200">
                        <p class="text-red-500 font-medium italic">Jika terdapat data yang tidak sesuai, silakan hubungi administrator instansi Anda.</p>
                    </div>
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
@endsection