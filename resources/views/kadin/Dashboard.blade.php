<x-layouts.kadin.app>
    <x-slot:title>Dashboard Kepala Dinas E-CUTI ESDM</x-slot:title>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-slate-900 rounded-[2rem] p-8 md:p-10 mb-8 shadow-xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative z-10">
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800/80 border border-slate-700 mb-6">
                            <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></span>
                            <span class="text-xs font-semibold text-slate-300">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-3">
                            Selamat Pagi,<br>
                            <span class="text-purple-400">Bapak/Ibu Kepala Dinas</span>
                        </h1>

                        <p class="text-slate-400 text-sm md:text-base max-w-lg mb-8 leading-relaxed">
                            Selamat datang di panel penandatanganan utama. Hari ini terdapat <strong class="text-white">{{ $statistik['menunggu_aksi'] ?? 0 }} pengajuan</strong> yang memerlukan keputusan final Anda.
                        </p>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('kadin.persetujuan.index') }}" class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-bold rounded-xl transition-all shadow-[0_0_20px_rgba(168,85,247,0.3)]">
                                Tinjau Berkas Masuk
                            </a>
                        </div>
                    </div>

                    <div class="w-full md:w-80 bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center text-rose-400">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <h3 class="font-bold text-slate-200">Ringkasan Keputusan</h3>
                        </div>

                        <ul class="space-y-4">
                            <li class="flex justify-between items-center border-b border-slate-700/50 pb-3">
                                <span class="text-sm text-slate-400">Menunggu ACC Anda</span>
                                <span class="text-lg font-bold text-rose-400">{{ $statistik['menunggu_aksi'] ?? 0 }}</span>
                            </li>
                            <li class="flex justify-between items-center pb-1">
                                <span class="text-sm text-slate-400">Total Pegawai Cuti</span>
                                <span class="text-lg font-bold text-purple-400">{{ $statistik['pegawai_cuti'] ?? 0 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Menunggu Keputusan Final</h2>
                        <p class="text-sm text-slate-500">Daftar pengajuan cuti pegawai yang telah disetujui berjenjang oleh Kasi, Kabid, dan Sekdin.</p>
                    </div>
                    <a href="{{ route('kadin.persetujuan.index') }}" class="text-sm font-semibold text-purple-600 hover:text-purple-700">Lihat Semua &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-slate-50 text-slate-600 font-medium">
                            <tr>
                                <th class="px-6 py-4">Nama Pegawai</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($pengajuanButuhAksi as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $item->user->nama ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->jenisCuti->nama_cuti ?? 'Cuti Tahunan' }}</td>
                                <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kadin.persetujuan.show', $item->id) }}" class="px-4 py-2 bg-gradient-to-r from-purple-400 to-purple-500 hover:from-purple-500 hover:to-purple-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-purple-500/30">
                                        Buka Berkas
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <p class="font-medium">Meja kerja Anda bersih. Tidak ada berkas cuti yang mengantre.</p>
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
