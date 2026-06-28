<x-layouts.kasi.app>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Daftar Persetujuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Alert Flash Message jika ada error/success --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-lime-100 border border-lime-200 text-lime-800 rounded-xl font-medium text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-rose-100 border border-rose-200 text-rose-800 rounded-xl font-medium text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        <i class="fas fa-inbox text-lime-500"></i> Antrean Berkas Menunggu
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-bold">
                                <th class="px-6 py-4">Nama Pegawai</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tgl Pelaksanaan</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($pengajuan as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $item->user->nama ?? '-' }}</div>
                                    <div class="text-xs text-slate-500">NIP. {{ $item->user->nip ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-md text-xs font-bold border border-indigo-100">
                                        {{ $item->jenisCuti->nama ?? 'Cuti Tahunan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kasi.persetujuan.show', $item->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-lg transition-colors">
                                        <i class="fas fa-search"></i> Review Permohonan
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <i class="fas fa-check-circle text-4xl mb-3 text-lime-400"></i>
                                    <p class="font-medium">Wah, bersih! Tidak ada antrean persetujuan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.kasi.app>