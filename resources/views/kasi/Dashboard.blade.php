<x-layouts.kasi.app>
    <div class="mb-8">
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
                {{-- Jumbotron Welcome Card --}}
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
                                Pantau persetujuan cuti bidang Anda. Hari ini terdapat <strong class="text-white">{{ $statistik['menunggu_aksi'] ?? 0 }} pengajuan</strong> yang memerlukan validasi (ACC) Anda selaku Kepala Seksi.
                            </p>
    
                            <div class="flex items-center gap-4">
                                <a href="{{ route('kasi.persetujuan.index') }}" class="px-6 py-3 bg-lime-500 hover:bg-lime-600 text-slate-900 font-bold rounded-xl transition-all shadow-[0_0_20px_rgba(132,204,22,0.3)]">
                                    Review Pengajuan
                                </a>
                                <a href="{{ route('kasi.persetujuan.index') }}?status=disetujui" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-xl transition-all border border-slate-700">
                                    Lihat Riwayat Cuti
                                </a>
                            </div>
                        </div>
    
                        {{-- Widget Ringkasan Cepat --}}
                        <div class="w-full md:w-80 bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-2xl p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center text-rose-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <h3 class="font-bold text-slate-200 text-sm">Urgensi Hari Ini</h3>
                            </div>
    
                            <ul class="space-y-4">
                                <li class="flex justify-between items-center border-b border-slate-700/50 pb-3">
                                    <span class="text-sm text-slate-400">Menunggu ACC Kasi</span>
                                    <span class="text-lg font-bold text-rose-400">{{ $statistik['menunggu_aksi'] ?? 0 }}</span>
                                </li>
                                <li class="flex justify-between items-center pb-1">
                                    <span class="text-sm text-slate-400">Bawahan Sedang Cuti</span>
                                    <span class="text-lg font-bold text-lime-400">{{ $statistik['pegawai_cuti'] ?? 0 }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
    
                {{-- Tiga Grid Informasi Stat Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-amber-50 rounded-2xl p-6 border border-amber-100/50 relative overflow-hidden">
                        <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Butuh Tindakan</p>
                        <h4 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $statistik['menunggu_aksi'] ?? 0 }} <span class="text-base font-medium text-slate-500">Berkas</span></h4>
                        <p class="text-sm text-slate-600">Menunggu verifikasi Anda</p>
                    </div>
    
                    <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100/50 relative overflow-hidden">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Tim Sedang Cuti</p>
                        <h4 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $statistik['pegawai_cuti'] ?? 0 }} <span class="text-base font-medium text-slate-500">Orang</span></h4>
                        <p class="text-sm text-slate-600">Aktif meninggalkan kantor hari ini</p>
                    </div>
    
                    <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100/50 relative overflow-hidden">
                        <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Total Di-ACC</p>
                        <h4 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $statistik['disetujui_bulan_ini'] ?? 0 }} <span class="text-base font-medium text-slate-500">Berkas</span></h4>
                        <p class="text-sm text-slate-600">Disetujui sistem bulan ini</p>
                    </div>
                </div>
    
                {{-- Tabel Data Antrean Utama --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Menunggu Persetujuan Anda</h2>
                            <p class="text-sm text-slate-500">Daftar berkas permohonan cuti staff di lingkup sub-bagian Anda.</p>
                        </div>
                        <a href="{{ route('kasi.persetujuan.index') }}" class="text-sm font-semibold text-lime-600 hover:text-lime-700 flex items-center gap-1 shrink-0">
                            Lihat Semua Antrean <span>&rarr;</span>
                        </a>
                    </div>
    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-slate-50 text-slate-600 font-medium border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4">Nama Pegawai</th>
                                    <th class="px-6 py-4">Jenis Cuti</th>
                                    <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                                    <th class="px-6 py-4">Durasi</th>
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
                                        {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }} s/d
                                        {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-800">
                                        {{ \Carbon\Carbon::parse($item->tgl_mulai)->diffInDays(\Carbon\Carbon::parse($item->tgl_selesai)) + 1 }} Hari
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('kasi.persetujuan.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Proses Berkas
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            <p class="font-medium text-sm">Tidak ada permohonan cuti yang memerlukan ACC saat ini.</p>
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