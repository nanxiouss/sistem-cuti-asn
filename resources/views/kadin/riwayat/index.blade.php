<x-layouts.kadin.app>
    <x-slot:title>Riwayat Proses Berkas - Kepala Dinas</x-slot:title>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Title --}}
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-950 tracking-tight">Riwayat Berkas Pengajuan</h1>
                <p class="text-sm text-slate-500 mt-1">Daftar seluruh berkas pengajuan cuti yang telah Anda proses, setujui, atau putuskan.</p>
            </div>

            {{-- Form Filter Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 mb-6">
                <form action="{{ route('kadin.riwayat.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    {{-- Filter Status --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Berkas</label>
                        <select name="status" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-slate-900">
                            <option value="">Semua Status Riwayat</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Sedang Diproses (Belum Final)</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Disetujui (Selesai/Final)</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak / Dikembalikan</option>
                        </select>
                    </div>

                    {{-- Filter Bulan --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bulan Pelaksanaan</label>
                        <select name="bulan" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-slate-900">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Tahun --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun</label>
                        <select name="tahun" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-slate-900">
                            <option value="">Semua Tahun</option>
                            @foreach($daftarTahun as $th)
                                <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Aksi Filter --}}
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-filter text-xs"></i> Cari Berkas
                        </button>
                        @if(request()->anyFilled(['status', 'bulan', 'tahun']))
                        <a href="{{ route('kadin.riwayat.index') }}" class="px-4 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-xl transition-all flex items-center justify-center" title="Reset Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.253 8H18"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Main Card/Table --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2.5">
                        <i class="fas fa-history text-slate-500 text-lg"></i> 
                        Arsip Riwayat Proses <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-xs rounded-md font-extrabold">{{ $riwayatPengajuan->count() }}</span>
                    </h3>
                </div>

                <div class="overflow-x-auto hide-scrollbar">
                    <table class="w-full text-left text-sm whitespace-nowrap border-collapse">
                        <thead class="bg-slate-50/70 text-slate-500 font-bold uppercase text-xs tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Nama Pegawai / Pemohon</th>
                                <th class="px-6 py-4">Asal Bidang</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 text-center">Status Akhir</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($riwayatPengajuan as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $item->user->nama ?? '-' }}</div>
                                    <div class="text-xs text-slate-400 font-medium">NIP. {{ $item->user->nip ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold border border-slate-200/60">
                                        {{ $item->user->pegawai->bidang->nama_bidang ?? 'Global' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold border border-indigo-100/70">
                                        {{ $item->jenisCuti->nama ?? $item->jenisCuti->nama_cuti ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-600">
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->status == 'Disetujui' || $item->status == 'Selesai')
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-extrabold rounded-full">Disetujui (Selesai)</span>
                                    @elseif($item->status == 'Ditolak')
                                        <span class="px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200 text-xs font-extrabold rounded-full">Ditolak</span>
                                    @else
                                        <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-extrabold rounded-full">Diproses ({{ $item->status }})</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kadin.riwayat.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-xl transition-all border border-slate-200">
                                        Detail Berkas <i class="fas fa-eye text-[10px] text-slate-500"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <i class="fas fa-history text-5xl text-slate-200"></i>
                                        <p class="font-medium text-slate-700">Belum ada riwayat proses berkas</p>
                                        <p class="text-xs text-slate-400">Berkas yang Anda setujui atau tolak akan diarsipkan di halaman ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-layouts.kadin.app>