<x-layouts.sekdin.app>
    <x-slot:title>Dashboard Sekretaris Dinas E-CUTI ESDM</x-slot:title>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-slate-900 rounded-[2rem] p-8 md:p-10 mb-8 shadow-xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative z-10">
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800/80 border border-slate-700 mb-6">
                            <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                            <span class="text-xs font-semibold text-slate-300">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-3">
                            Selamat Pagi,<br>
                            <span class="text-teal-400">Bapak/Ibu {{ explode(' ', Auth::user()->nama ?? 'Sekdin')[0] }}</span>
                        </h1>

                        <p class="text-slate-400 text-sm md:text-base max-w-lg mb-8 leading-relaxed">
                            Pantau persetujuan cuti tingkat kedinasan. Hari ini terdapat <strong class="text-white">{{ $statistik['menunggu_aksi'] ?? 0 }} pengajuan</strong> yang memerlukan persetujuan (ACC) Anda.
                        </p>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('sekdin.persetujuan.index') }}" class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-bold rounded-xl transition-all shadow-[0_0_20px_rgba(20,184,166,0.3)]">
                                Review Pengajuan
                            </a>
                        </div>
                    </div>

                    <div class="w-full md:w-80 bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center text-rose-400">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <h3 class="font-bold text-slate-200">Urgensi Hari Ini</h3>
                        </div>

                        <ul class="space-y-4">
                            <li class="flex justify-between items-center border-b border-slate-700/50 pb-3">
                                <span class="text-sm text-slate-400">Menunggu ACC Sekdin</span>
                                <span class="text-lg font-bold text-rose-400">{{ $statistik['menunggu_aksi'] ?? 0 }}</span>
                            </li>
                            <li class="flex justify-between items-center pb-1">
                                <span class="text-sm text-slate-400">Pegawai Sedang Cuti</span>
                                <span class="text-lg font-bold text-teal-400">{{ $statistik['pegawai_cuti'] ?? 0 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Menunggu Persetujuan Anda</h2>
                        <p class="text-sm text-slate-500">Daftar pengajuan cuti yang telah melalui verifikasi sebelumnya.</p>
                    </div>
                    <a href="{{ route('sekdin.persetujuan.index') }}" class="text-sm font-semibold text-teal-600 hover:text-teal-700">Lihat Semua &rarr;</a>
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
                                    <a href="{{ route('sekdin.persetujuan.show', $item->id) }}" class="px-4 py-2 bg-gradient-to-r from-teal-400 to-teal-500 hover:from-teal-500 hover:to-teal-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-teal-500/30">
                                        Review
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <p class="font-medium">Tidak ada pengajuan cuti yang menunggu ACC saat ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-layouts.sekdin.app>