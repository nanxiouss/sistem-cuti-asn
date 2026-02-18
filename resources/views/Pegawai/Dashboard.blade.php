@extends('layouts.pegawai.app')

@section('content')
<div class="pt-24 pb-12 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="relative rounded-[2.5rem] overflow-hidden bg-slate-900 shadow-2xl shadow-slate-200 mb-10">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-purple-600/20 mix-blend-overlay"></div>
            <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1600&q=80"
                class="w-full h-full object-cover opacity-20 mix-blend-luminosity" alt="Office bg">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/90 to-transparent"></div>
        </div>

        <div class="relative z-10 p-8 md:p-12 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-6">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs font-medium backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>

                <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    {{ $sapaan }}, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-indigo-200">{{
                        $user->nama }}</span>
                </h1>

                <p class="text-slate-400 text-lg max-w-lg leading-relaxed">
                    Pantau kinerja dan cuti Anda dalam satu dashboard terintegrasi. Hari ini status Anda tercatat <span
                        class="text-emerald-400 font-bold">Hadir</span>.
                </p>

                <div class="flex flex-wrap gap-4 pt-2">
                    <button
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-semibold shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-1">
                        Ajukan Cuti Baru
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white border border-white/10 rounded-xl font-medium backdrop-blur-md transition-all">
                        Lihat Kalender
                    </button>
                </div>
            </div>

            <div class="lg:col-span-5 relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl blur opacity-30">
                </div>
                <div
                    class="relative bg-slate-800/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl text-white">
                    <div class="flex items-center justify-between mb-4 border-b border-white/10 pb-4">
                        <h3 class="font-bold text-lg">⚠️ Aturan Cuti</h3>
                        <span
                            class="text-[10px] bg-pink-500/20 text-pink-300 px-2 py-1 rounded uppercase tracking-wider font-bold">Penting</span>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex gap-3">
                            <div
                                class="mt-1 w-6 h-6 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold shrink-0">
                                1</div>
                            <div>
                                <span class="block text-sm font-semibold text-pink-300">Cuti Tahunan Hangus</span>
                                <p class="text-xs text-slate-400 leading-relaxed mt-0.5">Sisa cuti N-2 (2 tahun lalu)
                                    otomatis hangus jika tidak dipakai.</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <div
                                class="mt-1 w-6 h-6 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold shrink-0">
                                2</div>
                            <div>
                                <span class="block text-sm font-semibold text-pink-300">Cuti Besar</span>
                                <p class="text-xs text-slate-400 leading-relaxed mt-0.5">Min 5 tahun kerja. Mengambil
                                    ini menghapus jatah tahunan.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div
            class="group bg-white rounded-[2rem] p-1 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-2xl transition-all duration-300">
            <div
                class="bg-gradient-to-br from-blue-50 to-white rounded-[1.8rem] p-6 h-full border border-blue-100 relative overflow-hidden">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Sisa Cuti</p>
                        <h2 class="text-5xl font-extrabold text-slate-900 mt-2">{{ $sisa_total }}<span
                                class="text-lg text-slate-400 font-medium ml-1">Hari</span></h2>
                    </div>
                    <div
                        class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-600/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between text-xs font-medium text-slate-500">
                        <span>Progress Penggunaan</span>
                        <span>{{ round($persentase_sisa) }}% Tersedia</span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-1000"
                            style="width: {{ $persentase_sisa }}%"></div>
                    </div>
                </div>

                <div
                    class="mt-6 flex justify-between items-center bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                    <div class="text-center px-2">
                        <div class="text-[10px] text-slate-400">N-2</div>
                        <div class="font-bold text-slate-700">{{ $sisa_n2 }}</div>
                    </div>
                    <div class="w-px h-6 bg-slate-100"></div>
                    <div class="text-center px-2">
                        <div class="text-[10px] text-slate-400">N-1</div>
                        <div class="font-bold text-blue-600">{{ $sisa_n1 }}</div>
                    </div>
                    <div class="w-px h-6 bg-slate-100"></div>
                    <div class="text-center px-2">
                        <div class="text-[10px] text-slate-400">Tahun Ini</div>
                        <div class="font-bold text-blue-600">{{ $sisa_n }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="group bg-white rounded-[2rem] p-6 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-2xl transition-all duration-300 border border-slate-100">
            <div class="flex flex-col h-full justify-between">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-amber-50 rounded-2xl text-amber-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">Proses</span>
                    </div>
                    <h3 class="text-4xl font-bold text-slate-900 mb-1">{{ $jumlah_proses }}</h3>
                    <p class="text-slate-500 font-medium">Pengajuan Pending</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50">
                    <p class="text-xs text-slate-400">Menunggu persetujuan atasan atau verifikasi admin.</p>
                </div>
            </div>
        </div>

        <div
            class="group bg-white rounded-[2rem] p-6 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-2xl transition-all duration-300 border border-slate-100">
            <div class="flex flex-col h-full justify-between">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span
                            class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">Used</span>
                    </div>
                    <h3 class="text-4xl font-bold text-slate-900 mb-1">{{ $terpakai }}</h3>
                    <p class="text-slate-500 font-medium">Hari Terpakai</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50">
                    <p class="text-xs text-slate-400">Total akumulasi cuti yang telah diambil pada tahun {{ $tahun_skrg
                        }}.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
        <div
            class="px-8 py-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Riwayat Pengajuan</h2>
                <p class="text-sm text-slate-500">Pantau status pengajuan cuti terakhir Anda.</p>
            </div>
            <a href="#" class="group inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700">
                Lihat Semua Riwayat
                <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>

        @forelse($riwayat as $item)
        @if($loop->first)
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal & Waktu
                        </th>
                        <th class="px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Durasi</th>
                        <th class="px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @endif
                    <tr class="group hover:bg-slate-50/80 transition-colors duration-200">
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-900">{{ $item->created_at->translatedFormat('d
                                    F Y') }}</span>
                                <span class="text-xs text-slate-500">{{ $item->created_at->format('H:i') }} WIB</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-medium text-slate-700">{{ $item->jenisCuti->nama_cuti ?? '-'
                                }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                {{ $item->lama_cuti }} Hari
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            @php
                            $statusStyles = match($item->status) {
                            'Disetujui' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'Ditolak' => 'bg-rose-100 text-rose-700 border-rose-200',
                            default => 'bg-amber-100 text-amber-700 border-amber-200',
                            };
                            $dotColor = match($item->status) {
                            'Disetujui' => 'bg-emerald-500',
                            'Ditolak' => 'bg-rose-500',
                            default => 'bg-amber-500',
                            };
                            @endphp
                            <span
                                class="inline-flex items-center pl-2 pr-3 py-1 rounded-full text-xs font-bold border {{ $statusStyles }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $dotColor }}"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button
                                class="text-slate-400 hover:text-blue-600 transition-colors p-2 hover:bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @if($loop->last)
                </tbody>
            </table>
        </div>
        @endif
        @empty
        <div class="py-16 text-center">
            <div
                class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <h3 class="text-slate-900 font-bold text-lg">Tidak ada riwayat</h3>
            <p class="text-slate-500 mt-1 max-w-sm mx-auto">Anda belum pernah mengajukan cuti. Klik tombol ajukan di
                atas untuk memulai.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection