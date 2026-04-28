@extends('layouts.admin.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Data Pegawai</h2>
        <p class="text-slate-500 text-sm">Manajemen akun dan profil detail pegawai.</p>
    </div>
    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-full text-sm font-bold transition shadow-lg shadow-indigo-200 flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Pegawai
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pegawai</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jabatan / Unit</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Sisa Cuti</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status Akun</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $u)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                {{ substr($u->nama, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $u->nama }}</p>
                                <p class="text-xs text-slate-500">{{ $u->nip }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-700">{{ $u->pegawai->jabatan ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">{{ $u->pegawai->unit_kerja ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-bold text-slate-700">{{ $u->pegawai->sisa_cuti_tahunan ?? 0 }} Hari</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $u->role == 'pegawai' ? 'bg-blue-50 text-blue-600' : 'bg-rose-50 text-rose-600' }}">
                            {{ $u->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                            <a href="#" class="p-2 text-slate-400 hover:text-indigo-600 transition"><i class="fas fa-edit"></i></a>
                            <button class="p-2 text-slate-400 hover:text-rose-600 transition"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Belum ada data pegawai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection