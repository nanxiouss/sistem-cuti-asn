<x-layouts.admin.app>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Pemberkasan Surat Cuti</h2>
        <p class="text-slate-500 text-sm">Daftar pengajuan yang telah disetujui Kepala Dinas. Rilis dokumen agar dapat diakses dan dicetak oleh pegawai.</p>
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
                        <th class="p-4">Pegawai</th>
                        <th class="p-4">Jenis Cuti</th>
                        <th class="p-4">Durasi</th>
                        <th class="p-4">Status Kedinasan</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($pemberkasans as $item)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4">
                            <div class="font-semibold text-slate-800">{{ $item->user->nama }}</div>
                            <div class="text-xs text-slate-400">{{ $item->user->nip }}</div>
                        </td>
                        <td class="p-4 font-medium">{{ $item->jenisCuti->nama }}</td>
                        <td class="p-4 text-xs">
                            <span class="font-bold text-blue-600 block">{{ $item->lama_cuti }} Hari Kerja</span>
                            <span class="text-slate-400">{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }}</span>
                        </td>
                        <td class="p-4">
                            @if($item->status === 'Selesai')
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-xs font-bold border border-emerald-200 shadow-sm">
                                    Selesai (Sudah Dirilis)
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 rounded-md text-xs font-bold border border-amber-200">
                                    Approved Kadin (Menunggu Rilis)
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            @if($item->status === 'Selesai')
                                <a href="{{ route('admin.pemberkasan.show', $item->id) }}" class="px-3 py-1.5 bg-slate-900 text-white font-bold text-xs rounded-md hover:bg-slate-800 transition shadow-sm inline-flex items-center gap-1">
                                    Lihat / Cetak
                                </a>
                            @else
                                <a href="{{ route('admin.pemberkasan.show', $item->id) }}" class="px-3 py-1.5 bg-blue-600 text-white font-bold text-xs rounded-md hover:bg-blue-700 transition shadow-sm inline-flex items-center gap-1">
                                    Proses & Rilis &rarr;
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400 italic">
                            Tidak ada antrean pemberkasan cuti saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin.app>