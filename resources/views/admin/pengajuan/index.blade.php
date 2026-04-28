@extends('layouts.admin.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-slate-800">Daftar Pengajuan Cuti</h2>
    <p class="text-slate-500 text-sm">Verifikasi dan teruskan berkas pengajuan cuti pegawai.</p>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pemohon</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Cuti</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal & Durasi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status Saat Ini</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Opsi Berkas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pengajuans as $p)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-800">{{ $p->user->nama }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">{{ $p->user->pegawai->jabatan ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-slate-700">{{ $p->jenisCuti->nama }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-700">{{ $p->tgl_mulai->format('d/m/Y') }}</p>
                        <p class="text-xs text-slate-500">{{ $p->lama_cuti }} Hari Kerja</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider 
                            {{ $p->status == 'Menunggu Verifikasi Admin' ? 'bg-amber-50 text-amber-600' : 'bg-indigo-50 text-indigo-600' }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.pengajuan.show', $p->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-900 text-white text-xs font-bold rounded-full hover:bg-indigo-600 transition">
                            Detail / Verifikasi
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Tidak ada pengajuan cuti.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection