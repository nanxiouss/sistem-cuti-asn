@extends('layouts.pegawai.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10 items-stretch">

    <div class="flex flex-col justify-start h-full">
        <div>
            <p class="text-sm font-semibold text-slate-500 mb-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>
            <h1 class="text-4xl font-bold text-slate-900 mb-3">
                {{ $sapaan }}, <span class="text-blue-600">{{ explode(' ', $user->nama)[0] }}</span>!
            </h1>
        </div>

        <div class="mt-auto pt-6">
            <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Anda Hari Ini</p>
                    <h3 class="text-lg font-bold text-slate-800">AKTIF / MASUK KERJA</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tidak ada jadwal cuti pada tanggal ini.</p>
                </div>
            </div>
        </div>
    </div>

    <div
        class="bg-pink-50 border border-pink-100 rounded-2xl p-6 relative overflow-hidden shadow-sm flex flex-col h-full">
        <div
            class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-pink-200 rounded-full blur-2xl opacity-50 pointer-events-none">
        </div>
        <div class="relative z-10 mb-3 flex items-center gap-3 border-b border-pink-100 pb-3">
            <div class="p-2 bg-pink-100 text-pink-600 rounded-lg shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-pink-900 text-m">Aturan Lengkap Dasar Pemberian Cuti</h3>
                <p class="text-[10px] text-pink-500 uppercase tracking-wide font-bold">silahkan baca diregulasi</p>
            </div>
        </div>

        <div class="relative z-10 overflow-y-auto max-h-48 pr-2 custom-scrollbar">
            <ul class="text-xs text-slate-700 space-y-3 font-medium">
                <li class="bg-white/60 p-2 rounded-lg border border-pink-100">
                    <span class="block font-bold text-pink-700 mb-0.5">1. Cuti Tahunan</span>
                    Hak 12 hari kerja. Sisa cuti N-2 (2 tahun lalu) dinyatakan <b>hangus</b>.
                </li>
                <li class="bg-white/60 p-2 rounded-lg border border-pink-100">
                    <span class="block font-bold text-pink-700 mb-0.5">2. Cuti Besar</span>
                    Syarat kerja min. 5 tahun. Pengambilan ini <b>menghapus hak Cuti Tahunan</b> tahun berjalan.
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 relative overflow-hidden group">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Sisa Cuti</p>
                <div class="mt-1 flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-slate-900">{{ $sisa_total }}</span>
                    <span class="text-slate-500 text-sm font-medium">Hari</span>
                </div>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-2 border-t border-slate-100 pt-3 mb-3">
            <div class="text-center border-r border-slate-100">
                <p class="text-[10px] text-slate-400">N-2 ({{ $tahun_skrg-2 }})</p>
                <p class="text-sm font-bold text-slate-300">{{ $sisa_n2 }}</p>
            </div>
            <div class="text-center border-r border-slate-100">
                <p class="text-[10px] text-slate-400">N-1 ({{ $tahun_skrg-1 }})</p>
                <p class="text-sm font-bold text-blue-600">{{ $sisa_n1 }}</p>
            </div>
            <div class="text-center">
                <p class="text-[10px] text-slate-400">N ({{ $tahun_skrg }})</p>
                <p class="text-sm font-bold text-blue-600">{{ $sisa_n }}</p>
            </div>
        </div>

        <div class="w-full bg-slate-100 rounded-full h-1.5">
            <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-500"
                style="width: {{ $persentase_sisa }}%"></div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sedang Diproses</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-yellow-600">{{ $jumlah_proses }}</span>
                    <span class="text-slate-500 text-sm font-medium">Pengajuan</span>
                </div>
                <p class="text-xs text-slate-400 mt-2">Menunggu persetujuan</p>
            </div>
            <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Cuti Diambil</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-slate-900">{{ $terpakai }}</span>
                    <span class="text-slate-500 text-sm font-medium">Hari</span>
                </div>
                <p class="text-xs text-slate-400 mt-2">Periode {{ $tahun_skrg }}</p>
            </div>
            <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <h2 class="text-base font-bold text-slate-800">Riwayat Pengajuan Terakhir</h2>
        <a href="#" class="text-sm text-blue-600 font-medium hover:text-blue-700">Lihat Semua &rarr;</a>
    </div>

    @forelse($riwayat as $item)
    @if($loop->first)
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-white text-slate-500 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-semibold">Tgl Pengajuan</th>
                    <th class="px-6 py-4 font-semibold">Jenis Cuti</th>
                    <th class="px-6 py-4 font-semibold">Durasi</th>
                    <th class="px-6 py-4 font-semibold">Status Dokumen</th>
                    <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @endif
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-medium text-slate-900">
                        {{ $item->created_at->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-6 py-4">{{ $item->jenisCuti->nama_cuti ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $item->lama_cuti }} Hari</td>
                    <td class="px-6 py-4">
                        @php
                        $colorClass = match($item->status) {
                        'Disetujui' => 'bg-green-100 text-green-700',
                        'Ditolak' => 'bg-red-100 text-red-700',
                        default => 'bg-yellow-100 text-yellow-700',
                        };
                        $iconColor = ($item->status == 'Disetujui') ? 'text-green-400' : 'text-yellow-400';
                        @endphp
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                            <svg class="mr-1.5 h-2 w-2 {{ $iconColor }}" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-slate-400 hover:text-blue-600 font-medium transition">Detail</button>
                    </td>
                </tr>
                @if($loop->last)
            </tbody>
        </table>
    </div>
    @endif
    @empty
    <div class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-slate-900">Belum ada data</h3>
        <p class="text-slate-500 mt-1">Riwayat pengajuan cuti Anda akan muncul di sini.</p>
    </div>
    @endforelse
</div>
@endsection