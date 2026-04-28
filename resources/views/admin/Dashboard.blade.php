@extends('layouts.admin.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-slate-800">Ringkasan Sistem</h2>
    <p class="text-slate-500">Selamat Datang di Panel Administrator E-Cuti.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                <i class="fas fa-file-alt text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Total Pengajuan</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $statistik['total_pengajuan'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                <i class="fas fa-file-signature text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Menunggu Verifikasi</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $statistik['menunggu_aksi'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Cuti Disetujui</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $statistik['disetujui'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Menunggu Tindakan (Butuh Aksi)</h3>
        <a href="{{ route('admin.pengajuan.index') }}" class="text-indigo-600 text-sm font-semibold hover:underline">Lihat Semua</a>
    </div>
    <div class="p-0">
        @if(isset($butuhAksi) && $butuhAksi->count() > 0)
            <ul class="divide-y divide-slate-100">
                @foreach($butuhAksi as $aksi)
                    <li class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-amber-100 flex shrink-0 items-center justify-center text-amber-600 font-bold">
                                {{ substr($aksi->user->nama ?? 'P', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $aksi->user->nama ?? 'Nama Tidak Ditemukan' }}</p>
                                <p class="text-xs text-slate-500">
                                    Mengajukan {{ $aksi->jenisCuti->nama ?? 'Cuti' }} ({{ $aksi->lama_cuti }} Hari)
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 uppercase tracking-wider">
                                {{ $aksi->status }}
                            </span>
                            <a href="#" class="p-2 text-slate-400 hover:text-indigo-600 transition" title="Verifikasi">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-slate-500 text-sm italic text-center py-8">Belum ada pengajuan cuti yang perlu diverifikasi.</p>
        @endif
    </div>
</div>
@endsection