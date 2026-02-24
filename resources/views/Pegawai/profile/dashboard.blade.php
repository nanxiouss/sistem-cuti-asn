@extends('layouts.pegawai.app')

@section('content')
<div class="w-full max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="flex flex-col lg:flex-row gap-6 xl:gap-8 items-start">

        {{-- KOLOM KIRI: Card Profil & Sidebar --}}
        <div class="w-full lg:w-[280px] xl:w-[300px] flex-shrink-0">
            <div class="bg-white rounded-3xl shadow-xl shadow-lime-500/20 border border-lime-200/60 overflow-hidden sticky top-28">
                <div class="px-6 pt-8 pb-6 text-center">
                    <div class="relative inline-block">
                        <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-lime-500 to-lime-700 p-1 mx-auto shadow-md">
                            <div class="w-full h-full rounded-full border-4 border-white overflow-hidden bg-slate-100 flex items-center justify-center">
                                <span class="text-3xl font-bold text-slate-400">
                                    {{ substr(Auth::user()->nama ?? 'Zamzami', 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="absolute bottom-1 right-1 bg-amber-300 text-white p-1.5 rounded-full border-2 border-white shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>

                    <h2 class="mt-5 text-xl font-bold text-slate-900 tracking-tight">{{ Auth::user()->nama ?? 'ZAMZAMI ZUER' }}</h2>
                    <p class="mt-1 text-sm font-bold text-blue-600 bg-blue-50 inline-block px-3 py-1 rounded-full border border-blue-100">
                        {{ Auth::user()->nip ?? '199107042024211016' }}
                    </p>
                    <p class="mt-4 text-xs text-slate-500 leading-relaxed font-medium uppercase tracking-wide">
                        {{ Auth::user()->unit_kerja ?? 'Subbagian Umum dan Kepegawaian Pemerintah Provinsi Sumatera Selatan' }}
                    </p>

                    <div class="mt-6 flex flex-col gap-3">
                        <a href="#" class="w-full bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold py-2.5 px-4 rounded-xl border border-slate-200 transition-all flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat Profil
                        </a>
                        <a href="#" class="w-full bg-white hover:bg-slate-50 text-slate-700 font-semibold py-2.5 px-4 rounded-xl border border-slate-300 transition-all flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Profil
                        </a>
                    </div>
                </div>

                <div class="border-t border-slate-100 bg-slate-50/50 p-4">
                    <nav class="flex flex-col gap-1.5">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-white bg-blue-600 shadow-md shadow-blue-500/20 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl text-slate-600 hover:bg-white hover:text-blue-600 hover:shadow-sm transition-all border border-transparent hover:border-slate-200">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Layanan ASN
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl text-slate-600 hover:bg-white hover:text-blue-600 hover:shadow-sm transition-all border border-transparent hover:border-slate-200">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                            Layanan Lainnya
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        {{-- KOLOM UTAMA: Dashboard Area --}}
        <div class="flex-1 min-w-0 flex flex-col xl:flex-row gap-6">
            
            {{-- Bagian Tengah Kiri (Main Content) --}}
            <div class="flex-1 w-full space-y-6">
                
                {{-- Welcome Card --}}
                <div class="bg-blue-50/50 rounded-2xl shadow-sm border border-blue-100 p-6 flex items-center justify-between">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Selamat Datang, ZAMZAMI ZUER</h2>
                            <p class="text-slate-500 text-sm mt-0.5 font-medium">NIP: 199107042024211016</p>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <span class="bg-blue-600 text-white px-4 py-1.5 rounded-full font-bold text-xs tracking-wider shadow-sm">PPPK</span>
                    </div>
                </div>

                {{-- Menu Aksi Cepat --}}
                <div>
                    <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        Aksi Cepat
                    </h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="#" class="bg-white p-4 rounded-xl border-t-4 border-t-blue-400 border-x border-b border-slate-200 shadow-sm hover:bg-slate-50 transition-colors flex flex-col items-center justify-center text-center group">
                            <svg class="w-6 h-6 text-blue-500 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="text-xs font-bold text-slate-700">Update Profil</span>
                        </a>
                        <a href="#" class="bg-white p-4 rounded-xl border-t-4 border-t-green-400 border-x border-b border-slate-200 shadow-sm hover:bg-slate-50 transition-colors flex flex-col items-center justify-center text-center group">
                            <svg class="w-6 h-6 text-green-500 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            <span class="text-xs font-bold text-slate-700">Update Data</span>
                        </a>
                        <a href="#" class="bg-white p-4 rounded-xl border-t-4 border-t-purple-400 border-x border-b border-slate-200 shadow-sm hover:bg-slate-50 transition-colors flex flex-col items-center justify-center text-center group">
                            <svg class="w-6 h-6 text-purple-500 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span class="text-xs font-bold text-slate-700">Layanan ASN</span>
                        </a>
                        <a href="#" class="bg-white p-4 rounded-xl border-t-4 border-t-amber-400 border-x border-b border-slate-200 shadow-sm hover:bg-slate-50 transition-colors flex flex-col items-center justify-center text-center group">
                            <svg class="w-6 h-6 text-amber-500 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span class="text-xs font-bold text-slate-700">Layanan Lainnya</span>
                        </a>
                    </div>
                </div>

                {{-- Grid Status --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-center gap-1">
                        <div class="flex items-center gap-2 text-green-600 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span class="text-xs font-semibold text-slate-500">Status Verifikasi Dukcapil</span>
                        </div>
                        <span class="text-sm font-bold text-slate-800">Terverifikasi</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-center gap-1">
                        <div class="flex items-center gap-2 text-blue-500 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="text-xs font-semibold text-slate-500">Pangkat/Golongan</span>
                        </div>
                        <span class="text-sm font-bold text-slate-800">Penata Muda</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-center gap-1">
                        <div class="flex items-center gap-2 text-purple-500 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs font-semibold text-slate-500">Masa Kerja Golongan</span>
                        </div>
                        <span class="text-sm font-bold text-slate-800">0 Tahun 0 Bulan</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-center gap-1">
                        <div class="flex items-center gap-2 text-amber-500 mb-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="text-xs font-semibold text-slate-500">Unit Kerja</span>
                        </div>
                        <span class="text-xs font-bold text-slate-800 truncate" title="Pemerintah Provinsi Sumatera Selatan">Pemerintah Provinsi Sumatera Selatan</span>
                    </div>
                </div>

                {{-- Jabatan & Pendidikan --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Informasi Jabatan --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2 bg-slate-50/50">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <h3 class="text-sm font-bold text-slate-800">Informasi Jabatan</h3>
                        </div>
                        <div class="p-5 space-y-4 text-sm">
                            <div>
                                <p class="text-slate-500 text-xs font-medium mb-1">Jabatan Saat Ini</p>
                                <p class="font-bold text-slate-800">Pranata Komputer Ahli Pertama</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs font-medium mb-1">Jenis Jabatan</p>
                                <p class="font-bold text-slate-800">Jabatan Fungsional</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs font-medium mb-1">TMT Jabatan</p>
                                <p class="font-bold text-slate-800">1 Maret 2024</p>
                            </div>
                        </div>
                    </div>

                    {{-- Pendidikan Terakhir --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2 bg-slate-50/50">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"></path></svg>
                            <h3 class="text-sm font-bold text-slate-800">Pendidikan Terakhir</h3>
                        </div>
                        <div class="p-5 space-y-4 text-sm">
                            <div>
                                <p class="text-slate-500 text-xs font-medium mb-1">Tingkat Pendidikan</p>
                                <p class="font-bold text-slate-800">S-1/Sarjana</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs font-medium mb-1">Program Studi</p>
                                <p class="font-bold text-slate-800 uppercase">S-1 SISTEM INFORMASI</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs font-medium mb-1">Nama Sekolah</p>
                                <p class="font-bold text-slate-800">Universitas Bina Darma</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs font-medium mb-1">Tahun Lulus</p>
                                <p class="font-bold text-slate-800">2013</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kontak & Personal --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2 bg-slate-50/50">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        <h3 class="text-sm font-bold text-slate-800">Informasi Kontak & Personal</h3>
                    </div>
                    <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-4 text-sm">
                        <div class="flex items-start gap-3 text-slate-500">
                            <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <div>
                                <p class="text-xs font-medium mb-0.5">Email Pribadi</p>
                                <p class="font-bold text-slate-800">zamzamizuer91@gmail.com</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 text-slate-500">
                            <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <div>
                                <p class="text-xs font-medium mb-0.5">No. HP</p>
                                <p class="font-bold text-slate-800">082280322473</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 text-slate-500">
                            <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <div>
                                <p class="text-xs font-medium mb-0.5">Lokasi Kerja</p>
                                <p class="font-bold text-slate-800 uppercase">PALEMBANG</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 text-slate-500">
                            <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <div>
                                <p class="text-xs font-medium mb-0.5">Tanggal Lahir</p>
                                <p class="font-bold text-slate-800">4 Juli 1991</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 text-slate-500">
                            <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                            <div>
                                <p class="text-xs font-medium mb-0.5">Status Perkawinan</p>
                                <p class="font-bold text-slate-800">Menikah</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 text-slate-500">
                            <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <div>
                                <p class="text-xs font-medium mb-0.5">Agama</p>
                                <p class="font-bold text-slate-800">Islam</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Bagian Kanan (Panel Info MyASN) --}}
            <div class="w-full xl:w-[280px] flex-shrink-0">
                <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 sticky top-28">
                    <h3 class="text-sm font-bold text-slate-800 mb-3 text-center border-b border-slate-200 pb-3">
                        Selamat Datang di MyASN
                    </h3>
                    <p class="text-xs text-slate-600 mb-4 leading-relaxed text-justify">
                        Myasn adalah aplikasi resmi dari Badan Kepegawaian Negara (BKN) yang digunakan oleh Aparatur Sipil Negara (ASN) untuk mengakses dan mengelola data kepegawaian secara mandiri.
                    </p>
                    <ul class="space-y-3 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-500 mt-0.5">•</span>
                            <span><strong class="text-slate-800">Pemutakhiran Data:</strong> Memungkinkan ASN memperbarui data pribadi dan riwayat kepegawaiannya, seperti pendidikan, jabatan, pelatihan, dan keluarga.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-500 mt-0.5">•</span>
                            <span><strong class="text-slate-800">Kasus Profil:</strong> Menyediakan informasi lengkap mengenai status kepegawaian, termasuk golongan, jabatan, dan data lainnya.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-500 mt-0.5">•</span>
                            <span><strong class="text-slate-800">Layanan Digital:</strong> Pembuatan Kartu ASN Virtual, Kartu/Kartu Virtual dan lainnya.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-500 mt-0.5">•</span>
                            <span><strong class="text-slate-800">Monitoring Layanan:</strong> ASN dapat memantau proses layanan kepegawaian secara real-time.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-500 mt-0.5">•</span>
                            <span><strong class="text-slate-800">Notifikasi dan Informasi:</strong> Menyampaikan informasi terbaru seputar kepegawaian seperti kenaikan pangkat atau pensiun.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection