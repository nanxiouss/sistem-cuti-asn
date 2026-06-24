<x-layouts.admin.app>
    <x-slot:title>Laporan Pengajuan Cuti - Admin</x-slot:title>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-950 tracking-tight">Laporan & Rekapitulasi Cuti</h1>
                <p class="text-sm text-slate-500 mt-1">Saring data pengajuan cuti pegawai dan ekspor menjadi file Excel.</p>
            </div>

            {{-- Form Filter --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 mb-6">
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status</label>
                        <select name="status" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5">
                            <option value="">Semua Status</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Disetujui / Selesai</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bulan</label>
                        <select name="bulan" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun</label>
                        <select name="tahun" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5">
                            <option value="">Semua Tahun</option>
                            @foreach($daftarTahun as $th)
                                <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        {{-- Tombol Tampilkan Tabel --}}
                        <button type="submit" class="flex-1 bg-slate-900 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-sm">
                            Cari
                        </button>
                        
                        {{-- Tombol Cetak Excel (Ambil param filter & kirim ke rute export) --}}
                        <a href="{{ route('admin.laporan.excel', request()->all()) }}" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl text-center flex items-center justify-center transition-all shadow-sm">
                            <i class="fas fa-file-excel mr-1"></i> Excel
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabel Preview Laporan --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Nama Pegawai</th>
                                <th class="px-6 py-4">Bidang</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Cuti</th>
                                <th class="px-6 py-4 text-center">Durasi</th>
                                <th class="px-6 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($laporan as $item)
                            <tr>
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $item->user->nama ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->user->pegawai->bidang->nama_bidang ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->jenisCuti->nama ?? $item->jenisCuti->nama_cuti ?? '-' }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-center font-bold">{{ $item->lama_cuti }} Hari</td>
                                <td class="px-6 py-4 text-center">{{ $item->status }}</td>
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