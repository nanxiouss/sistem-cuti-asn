<x-layouts.kabid.app>
    <x-slot:title>Daftar Antrean Berkas - Kabid</x-slot:title>

    @php
        // Proses pemisahan data menggunakan collection filter
        $pengajuanPegawai = $pengajuan->filter(fn($item) => !empty($item->ttd_kasi));
        $pengajuanKasi = $pengajuan->filter(fn($item) => empty($item->ttd_kasi));
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            {{-- Header Title --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-2">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-950 tracking-tight">Persetujuan Cuti</h1>
                    <p class="text-sm text-slate-500 mt-1">Daftar verifikasi berkas tahap kedua sebelum diteruskan ke bagian Umum.</p>
                </div>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm">
                <i class="fas fa-check-circle text-lg text-emerald-500"></i>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            @endif

            {{-- BAGIAN ATAS: TABEL PEGAWAI BIASA / STAF --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2.5">
                        <i class="fas fa-users text-indigo-500 text-lg"></i>
                        Antrean Berkas Pegawai / Pelaksana 
                        <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs rounded-md font-extrabold">{{ $pengajuanPegawai->count() }}</span>
                    </h3>
                </div>

                <div class="overflow-x-auto hide-scrollbar">
                    <table class="w-full text-left text-sm whitespace-nowrap border-collapse">
                        <thead class="bg-slate-50/70 text-slate-500 font-bold uppercase text-xs tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Nama Pegawai</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 text-center">Durasi</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($pengajuanPegawai as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $item->user->nama ?? '-' }}</div>
                                    <div class="text-xs text-slate-400 font-medium">NIP. {{ $item->user->nip ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold border border-indigo-100/70">
                                        {{ $item->jenisCuti->nama_cuti ?? 'Cuti Tahunan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-600">
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-extrabold text-slate-900 text-center text-base">
                                    {{ $item->lama_cuti }} <span class="text-xs text-slate-400 font-normal">Hari</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kabid.persetujuan.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                                        Review Permohonan <i class="fas fa-chevron-right text-[10px] text-lime-400"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <p class="text-xs font-medium text-slate-500">Tidak ada berkas antrean dari Staf/Pegawai Pelaksana.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- BAGIAN BAWAH: TABEL KASI (KEPALA SEKSI) --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2.5">
                        <i class="fas fa-user-shield text-amber-500 text-lg"></i>
                        Antrean Berkas Kepala Seksi (Kasi) 
                        <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-xs rounded-md font-extrabold">{{ $pengajuanKasi->count() }}</span>
                    </h3>
                </div>

                <div class="overflow-x-auto hide-scrollbar">
                    <table class="w-full text-left text-sm whitespace-nowrap border-collapse">
                        <thead class="bg-slate-50/70 text-slate-500 font-bold uppercase text-xs tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Nama Pengaju</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 text-center">Durasi</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($pengajuanKasi as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $item->user->nama ?? '-' }}</div>
                                    <div class="text-xs text-amber-600 font-semibold bg-amber-50 border border-amber-100 px-1.5 py-0.5 rounded inline-block mt-0.5 text-[10px]">
                                        {{ $item->user->pegawai->jabatan ?? 'Kepala Seksi' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-bold border border-amber-100/70">
                                        {{ $item->jenisCuti->nama_cuti ?? 'Cuti Tahunan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-600">
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-extrabold text-slate-900 text-center text-base">
                                    {{ $item->lama_cuti }} <span class="text-xs text-slate-400 font-normal">Hari</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kabid.persetujuan.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                                        Review Permohonan <i class="fas fa-chevron-right text-[10px] text-lime-400"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <p class="text-xs font-medium text-slate-500">Tidak ada berkas antrean dari Kepala Seksi (Kasi).</p>
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