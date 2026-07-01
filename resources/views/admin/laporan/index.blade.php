<x-layouts.admin.app>
    <x-slot:title>Laporan Pengajuan Cuti - Admin</x-slot:title>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-950 tracking-tight">Laporan & Rekapitulasi Cuti</h1>
                <p class="text-sm text-slate-500 mt-1">Saring data pengajuan cuti pegawai berdasarkan kalender dan ekspor menjadi file Excel.</p>
            </div>

            {{-- Form Filter Berdasarkan Tanggal Kalender --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 mb-6">
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status</label>
                        <select name="status" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5">
                            <option value="">Semua Status</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai (Disetujui Admin)</option>
                            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    {{-- Kalender Tanggal Awal --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Dari Tanggal</label>
                        <input type="date" name="tgl_awal" value="{{ request('tgl_awal') }}" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                    </div>

                    {{-- Kalender Tanggal Akhir --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" value="{{ request('tgl_akhir') }}" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold h-10 px-4 rounded-xl transition">
                            Filter
                        </button>
                        <a href="{{ route('admin.laporan.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold h-10 px-4 rounded-xl flex items-center justify-center transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tombol Aksi Ekspor --}}
            <div class="mb-4 flex justify-end">
                <a href="{{ route('admin.laporan.excel', request()->all()) }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold py-2.5 px-5 rounded-xl shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Ekspor ke Excel
                </a>
            </div>

            {{-- Tabel Tampilan Preview --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 uppercase text-xs font-bold border-b border-slate-200 tracking-wider">
                                <th class="px-6 py-4">Nama Pegawai</th>
                                <th class="px-6 py-4">Bidang</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 text-center">Lama Cuti</th>
                                <th class="px-6 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($laporan as $item)
                            <tr>
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $item->user->nama ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->user->pegawai->bidang->nama_bidang ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->jenisCuti->nama ?? '-' }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-center font-bold">{{ $item->lama_cuti }} Hari</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">Data tidak ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-layouts.admin.app>