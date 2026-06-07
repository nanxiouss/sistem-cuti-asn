<x-layouts.pegawai.app>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Riwayat Pengajuan Cuti</h2>
            <p class="text-slate-500 text-sm">Pantau daftar pengajuan cuti Anda beserta ringkasan status birokrasi saat ini.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm font-medium text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="p-4">Jenis Cuti</th>
                        <th class="p-4">Tanggal Pelaksanaan</th>
                        <th class="p-4">Durasi</th>
                        <th class="p-4">Status Saat Ini</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($pengajuans as $item)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4">
                            <div class="font-bold text-slate-800">{{ $item->jenisCuti->nama }}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Diajukan pada: {{ $item->created_at->format('d/m/Y H:i') }} WIB</div>
                        </td>
                        
                        <td class="p-4 font-medium text-slate-600">
                            <div class="flex flex-col gap-0.5">
                                <span>{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d M Y') }}</span>
                                <span class="text-xs text-slate-400 font-normal">s.d {{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d M Y') }}</span>
                            </div>
                        </td>

                        <td class="p-4">
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold border border-blue-100">
                                {{ $item->lama_cuti }} Hari Kerja
                            </span>
                        </td>

                        <td class="p-4">
                            @if($item->status === 'Selesai')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-xs font-bold border border-emerald-200 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Selesai (Arsip Dirilis)
                                </span>
                            @elseif($item->status === 'Ditolak')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-700 rounded-md text-xs font-bold border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Ditolak Pimpinan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 rounded-md text-xs font-bold border border-amber-200 animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    {{ $item->status }}
                                </span>
                            @endif
                        </td>

                        <td class="p-4 text-center">
                            <a href="{{ route('pegawai.riwayat.show', $item->id) }}" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg transition inline-flex items-center gap-1.5 shadow-sm shadow-slate-100">
                                📦 Lacak Posisi &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-slate-400 italic">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <span class="text-2xl">📋</span>
                                <span class="text-sm font-medium text-slate-400">Anda belum pernah mengajukan usulan cuti.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.pegawai.app>