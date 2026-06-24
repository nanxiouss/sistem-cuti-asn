<x-layouts.kabid.app>
    <x-slot:title>Dashboard Kepala Bidang - E-CUTI ESDM</x-slot:title>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Welcome Banner --}}
            <div class="bg-slate-900 rounded-[2rem] p-8 md:p-10 mb-8 shadow-xl relative overflow-hidden border border-slate-800">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-lime-500/10 rounded-full blur-3xl"></div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative z-10">

                    <div class="flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800/80 border border-slate-700 mb-6">
                            <span class="w-2 h-2 rounded-full bg-lime-500 animate-pulse"></span>
                            <span class="text-xs font-semibold text-slate-300">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        </div>

                        {{-- PERBAIKAN: Memanggil variabel sapaan dinamis waktu dan nama user yang aman --}}
                        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-3">
                            {{ $sapaan }},<br>
                            <span class="text-lime-400">{{ explode(' ', $user->nama ?? $user->name ?? '')[0] }}</span>
                        </h1>

                        <p class="text-slate-400 text-sm md:text-base max-w-lg mb-8 leading-relaxed">
                            Pantau persetujuan cuti tim Bidang Anda. Hari ini terdapat <strong class="text-white">{{ $statistik['menunggu_aksi'] }} berkas</strong> yang memerlukan tanda tangan digital (ACC) Anda.
                        </p>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('kabid.persetujuan.index') }}" class="px-6 py-3 bg-lime-500 hover:bg-lime-600 text-slate-900 font-bold rounded-xl transition-all shadow-[0_0_20px_rgba(132,204,22,0.3)] transform hover:-translate-y-0.5">
                                Review Antrean Berkas
                            </a>
                        </div>
                    </div>

                    {{-- Urgensi Card --}}
                    <div class="w-full md:w-80 bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-3xl p-6 shadow-inner">
                        <div class="flex items-center gap-3 mb-5 border-b border-slate-700 pb-4">
                            <div class="w-9 h-9 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-400">
                                <i class="fas fa-exclamation-circle text-lg"></i>
                            </div>
                            <h3 class="font-bold text-slate-200">Urgensi Hari Ini</h3>
                        </div>

                        <ul class="space-y-4">
                            <li class="flex justify-between items-center">
                                <span class="text-sm text-slate-400">Menunggu ACC Kabid</span>
                                <span class="text-2xl font-extrabold text-rose-400">{{ $statistik['menunggu_aksi'] }}</span>
                            </li>
                            <li class="flex justify-between items-center border-t border-slate-700/50 pt-4">
                                <span class="text-sm text-slate-400">Bawahan Sedang Cuti</span>
                                <span class="text-2xl font-extrabold text-lime-400">{{ $statistik['pegawai_cuti'] }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-amber-50 rounded-2xl p-6 border border-amber-100/50 relative overflow-hidden shadow-sm">
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-amber-500">
                        <i class="fas fa-file-signature text-8xl"></i>
                    </div>
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Butuh Tindakan</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $statistik['menunggu_aksi'] }} <span class="text-base font-medium text-slate-500">Berkas</span></h4>
                    <p class="text-sm text-slate-600">Menunggu *Review* & TTD Anda</p>
                </div>

                <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100/50 relative overflow-hidden shadow-sm">
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-blue-500">
                        <i class="fas fa-users text-8xl"></i>
                    </div>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Tim Sedang Cuti</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $statistik['pegawai_cuti'] }} <span class="text-base font-medium text-slate-500">Orang</span></h4>
                    <p class="text-sm text-slate-600">Dari Bidang Anda hari ini</p>
                </div>

                <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100/50 relative overflow-hidden shadow-sm">
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-emerald-500">
                        <i class="fas fa-check-circle text-8xl"></i>
                    </div>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Total Di-ACC</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $statistik['disetujui_bulan_ini'] }} <span class="text-base font-medium text-slate-500">Berkas</span></h4>
                    <p class="text-sm text-slate-600">Disetujui Bulan Ini ({{ \Carbon\Carbon::now()->translatedFormat('F') }})</p>
                </div>
            </div>

            {{-- Tabel Antrean Berkas --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Menunggu Persetujuan Anda (Tahap 2)</h2>
                        <p class="text-sm text-slate-500">5 Daftar pengajuan cuti terbaru yang telah divalidasi oleh kasi dan menunggu ACC Kabid.</p>
                    </div>
                    <a href="{{ route('kabid.persetujuan.index') }}" class="text-sm font-semibold text-lime-600 hover:text-lime-700 whitespace-nowrap bg-lime-50 px-4 py-2 rounded-lg border border-lime-100 transition-colors">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto hide-scrollbar">
                    <table class="w-full text-left text-sm whitespace-nowrap border-collapse">
                        <thead class="bg-slate-50/50 text-slate-600 font-bold uppercase text-xs tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Nama Pegawai / Seksi</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 text-center">Durasi (Hari Kerja)</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($pengajuanButuhAksi as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $item->user->nama ?? $item->user->name ?? 'Nama Tidak Ditemukan' }}</div>
                                    <div class="text-xs text-lime-600 font-semibold uppercase">{{ $item->user->pegawai->bidang->nama_bidang ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- PERBAIKAN BUG: Memanggil properti ->nama sesuai dengan nama kolom asli database --}}
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold border border-indigo-100">
                                        {{ $item->jenisCuti->nama ?? 'Cuti Tahunan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900 text-center text-lg">
                                    {{ $item->lama_cuti }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kabid.persetujuan.show', $item->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all shadow-lg transform hover:-translate-y-0.5">
                                        <i class="fas fa-search text-lime-400"></i> Review Berkas
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <i class="fas fa-inbox text-5xl text-slate-200"></i>
                                        <p class="font-medium text-slate-600">Alhamdulillah bersih!</p>
                                        <p class="text-sm text-slate-400">Tidak ada pengajuan cuti bawahan yang menunggu ACC Anda saat ini.</p>
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