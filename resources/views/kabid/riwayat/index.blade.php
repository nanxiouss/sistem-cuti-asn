<x-layouts.kabid.app>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Halaman --}}
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Riwayat & Tracking Cuti</h1>
                <p class="text-slate-500 text-sm">Lacak posisi dokumen dan riwayat pengajuan cuti staf yang telah Anda beri persetujuan.</p>
            </div>

            {{-- Section Form Filter --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
                <form action="{{ route('kabid.riwayat.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    
                    {{-- Filter Status (Disesuaikan Alur Multi-level) --}}
                    <div class="w-full md:w-1/4">
                        <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Tracking</label>
                        <select name="status" id="status" class="w-full bg-slate-50 border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-lime-500 focus:border-lime-500 p-3 transition-all">
                            <option value="">Semua Berkas Terproses</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Sedang Diproses Atasan Tingkat Atas</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui (Selesai/Final)</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    {{-- Filter Bulan --}}
                    <div class="w-full md:w-1/4">
                        <label for="bulan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bulan</label>
                        <select name="bulan" id="bulan" class="w-full bg-slate-50 border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-lime-500 focus:border-lime-500 p-3 transition-all">
                            <option value="">Semua Bulan</option>
                            @foreach([
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ] as $key => $bulanName)
                                <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $bulanName }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Tahun --}}
                    <div class="w-full md:w-1/4">
                        <label for="tahun" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun</label>
                        <select name="tahun" id="tahun" class="w-full bg-slate-50 border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-lime-500 focus:border-lime-500 p-3 transition-all">
                            <option value="">Semua Tahun</option>
                            @foreach($daftarTahun as $thn)
                                <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="w-full md:w-1/4 flex gap-2">
                        <button type="submit" class="w-full text-center px-6 py-3 bg-lime-500 hover:bg-lime-600 text-slate-900 font-bold rounded-xl transition-all shadow-md">
                            Cari Berkas
                        </button>
                        @if(request()->anyFilled(['status', 'bulan', 'tahun']))
                            <a href="{{ route('kabid.riwayat.index') }}" class="px-4 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-xl transition-all flex items-center justify-center" title="Reset Filter">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.253 8H18"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Tabel Riwayat Utama --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-slate-50 text-slate-600 font-medium border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">NIP</th>
                                <th class="px-6 py-4">Nama Pegawai</th>
                                <th class="px-6 py-4">Jabatan</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Mulai - Akhir</th>
                                <th class="px-6 py-4 text-center">Posisi Berkas / Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($riwayatPengajuan as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-600">
                                        {{ $item->user->nip ?? 'NIP.' . $item->user_id }}
                                    </td>
                                    
                                    <td class="px-6 py-4 font-bold text-slate-800">
                                        {{ $item->user->nama ?? 'Nama Tidak Ditemukan' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $item->user->pegawai->jabatan ?? '-' }}
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-md text-xs font-bold border border-indigo-100">
                                            {{ $item->jenisCuti->nama ?? 'Cuti' }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <div class="font-medium">
                                            {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }} s/d
                                            {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="text-xs text-slate-400 mt-0.5">
                                            Durasi: {{ $item->lama_cuti ?? 0 }} Hari
                                        </div>
                                    </td>
                                    
                                    {{-- Kolom Status Dinamis Mengikuti Posisi Alur Berkas --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'Disetujui')
                                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold shadow-sm">
                                                Disetujui (Final)
                                            </span>
                                        @elseif($item->status == 'Ditolak')
                                            <span class="px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-bold shadow-sm">
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-bold shadow-sm animate-pulse">
                                                {{ $item->status }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Button Detail Tracking Baru --}}
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('kabid.riwayat.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-lg transition-all shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="font-medium text-sm">Belum ada riwayat pengajuan staf yang Anda proses.</p>
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
</x-layouts.kabid.app>