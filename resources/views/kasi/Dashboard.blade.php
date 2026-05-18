<x-layouts.kasi.app>
<div class="mb-8">
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-slate-900 rounded-[2rem] p-8 md:p-10 mb-8 shadow-xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-lime-500/10 rounded-full blur-3xl"></div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative z-10">

                    <div class="flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800/80 border border-slate-700 mb-6">
                            <span class="w-2 h-2 rounded-full bg-lime-500 animate-pulse"></span>
                            <span class="text-xs font-semibold text-slate-300">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-3">
                            Selamat Pagi,<br>
                            <span class="text-lime-400">{{ explode(' ', Auth::user()->nama)[0] }}</span>
                        </h1>

                        <p class="text-slate-400 text-sm md:text-base max-w-lg mb-8 leading-relaxed">
                            Pantau persetujuan cuti tim Anda. Hari ini terdapat <strong class="text-white">{{ $statistik['menunggu_aksi'] ?? 0 }} pengajuan</strong> yang memerlukan persetujuan (ACC) Anda.
                        </p>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('kasi.persetujuan.index') }}" class="px-6 py-3 bg-lime-500 hover:bg-lime-600 text-slate-900 font-bold rounded-xl transition-all shadow-[0_0_20px_rgba(132,204,22,0.3)]">
                                Review Pengajuan
                            </a>
                            <a href="#" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-xl transition-all border border-slate-700">
                                Lihat Tim Saya
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
                                <span class="text-sm text-slate-400">Menunggu ACC Kasi</span>
                                <span class="text-lg font-bold text-rose-400">{{ $statistik['menunggu_aksi'] ?? 0 }}</span>
                            </li>
                            <li class="flex justify-between items-center pb-1">
                                <span class="text-sm text-slate-400">Pegawai Sedang Cuti</span>
                                <span class="text-lg font-bold text-lime-400">{{ $statistik['pegawai_cuti'] ?? 0 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-amber-50 rounded-2xl p-6 border border-amber-100/50 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-amber-500">
                        <i class="fas fa-file-signature text-8xl"></i>
                    </div>
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Butuh Tindakan</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $statistik['menunggu_aksi'] ?? 0 }} <span class="text-base font-medium text-slate-500">Berkas</span></h4>
                    <p class="text-sm text-slate-600">Menunggu *Review* Anda</p>
                </div>

                <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100/50 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-blue-500">
                        <i class="fas fa-users text-8xl"></i>
                    </div>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Tim Sedang Cuti</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $statistik['pegawai_cuti'] ?? 0 }} <span class="text-base font-medium text-slate-500">Orang</span></h4>
                    <p class="text-sm text-slate-600">Pada seksi Anda hari ini</p>
                </div>

                <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100/50 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-emerald-500">
                        <i class="fas fa-check-circle text-8xl"></i>
                    </div>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Total Di-ACC</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $statistik['disetujui_bulan_ini'] ?? 0 }} <span class="text-base font-medium text-slate-500">Berkas</span></h4>
                    <p class="text-sm text-slate-600">Disetujui bulan ini</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Menunggu Persetujuan Anda</h2>
                        <p class="text-sm text-slate-500">Daftar pengajuan cuti yang telah divalidasi oleh admin dan menunggu ACC Kasi.</p>
                    </div>
                    <a href="#" class="text-sm font-semibold text-lime-600 hover:text-lime-700">Lihat Semua &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-slate-50 text-slate-600 font-medium">
                            <tr>
                                <th class="px-6 py-4">Nama Pegawai</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4">Lama</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($pengajuanButuhAksi as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $item->user->nama ?? 'Nama Tidak Ditemukan' }}</div>
                                    <div class="text-xs text-slate-500">NIP. {{ $item->user->nip ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-md text-xs font-bold border border-indigo-100">
                                        {{ $item->jenisCuti->nama_cuti ?? 'Cuti Tahunan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-semibold">
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->diffInDays(\Carbon\Carbon::parse($item->tgl_selesai)) + 1 }} Hari
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Tombol ini nanti diarahkan ke halaman detail persetujuan Kasi --}}
                                    <a href="{{ route('kasi.persetujuan.show', $item->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                                        <i class="fas fa-search"></i> Proses
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-4xl mb-3 text-slate-300"></i>
                                        <p class="font-medium">Tidak ada pengajuan cuti yang menunggu ACC saat ini.</p>
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
</div>
</x-layouts.kasi.app>
