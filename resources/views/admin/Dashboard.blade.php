<x-layouts.admin.app>
    <x-slot:title>Dashboard Admin - E-CUTI ESDM</x-slot:title>

    <div class="relative rounded-3xl overflow-hidden bg-slate-900 shadow-2xl shadow-slate-200/50 mb-10 -mt-2">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 mix-blend-overlay"></div>
            <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1600&q=80"
                class="w-full h-full object-cover opacity-20 mix-blend-luminosity" alt="Office bg">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/90 to-slate-900/40"></div>
        </div>

        <div class="relative z-10 p-8 md:p-12 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-6">

                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-200 text-xs font-semibold backdrop-blur-md cursor-default">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 shadow-[0_0_8px_rgba(99,102,241,0.8)] animate-pulse"></span>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>

                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-indigo-200">{{ $sapaan ?? 'Selamat Datang' }},</span> <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-200 to-purple-300">
                        {{ Auth::user()->nama ?? Auth::user()->name ?? 'Administrator' }}
                    </span>
                    <span class="text-white opacity-80 font-light mx-2">-</span>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-purple-500">
                        Pusat Kendali
                    </span>
                </h1>

                <p class="text-slate-400 text-lg max-w-lg leading-relaxed">
                    Kelola data kepegawaian, pantau pergerakan berkas, dan verifikasi persetujuan cuti secara real-time dari satu dashboard terintegrasi.
                </p>

                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('admin.pengajuan.index') }}"
                        class="px-6 py-3 bg-indigo-500 hover:bg-indigo-400 text-white rounded-xl font-bold shadow-lg shadow-indigo-500/30 transition-all duration-300 ease-out transform hover:-translate-y-1">
                        Cek Antrean Berkas
                    </a>
                    <a href="{{ route('admin.pemberkasan.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white/10 hover:bg-white/20 text-white border border-white/10 rounded-xl font-medium backdrop-blur-md transition-all duration-300 ease-out transform hover:-translate-y-1">
                        Pemberkasan
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5 relative hidden md:block">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-3xl blur opacity-20"></div>
                <div class="relative bg-slate-800/60 backdrop-blur-xl border border-white/10 p-7 rounded-3xl text-white shadow-xl">
                    <div class="flex items-center justify-between mb-5 border-b border-white/10 pb-4">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            Info Sistem
                        </h3>
                        <span class="text-[10px] bg-indigo-500/20 text-indigo-300 px-2 py-1 rounded md:uppercase tracking-wider font-bold border border-indigo-500/20">
                            Meja Kerja
                        </span>
                    </div>
                    <ul class="space-y-5">
                        <li class="flex gap-4">
                            <div class="mt-0.5 w-7 h-7 rounded-full bg-slate-700/50 border border-white/10 flex items-center justify-center text-xs font-bold text-slate-300 shrink-0">1</div>
                            <div>
                                <span class="block text-sm font-semibold text-indigo-400">Verifikasi Subbag Umum</span>
                                <p class="text-xs text-slate-400 leading-relaxed mt-1">Pastikan sisa kuota cuti tahunan pegawai dihitung dengan benar sebelum berkas diteruskan ke Kasi/Kabid.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="mt-0.5 w-7 h-7 rounded-full bg-slate-700/50 border border-white/10 flex items-center justify-center text-xs font-bold text-slate-300 shrink-0">2</div>
                            <div>
                                <span class="block text-sm font-semibold text-indigo-400">Pemberkasan Akhir</span>
                                <p class="text-xs text-slate-400 leading-relaxed mt-1">Berkas yang berstatus "Selesai" harus diterbitkan nomor Surat Izin/SK agar dapat diunduh oleh pegawai terkait.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                    <i class="fas fa-file-signature text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Butuh Verifikasi Admin</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $statistik['menunggu_admin'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Pegawai</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $statistik['total_pegawai'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Disetujui</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $statistik['disetujui'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Ditolak / Gagal</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $statistik['total_ditolak'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm mb-8">
        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-route text-indigo-500"></i> Posisi Berkas Berjalan (Tracking Alur Cuti)
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center">
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Tahap 1: Kasi</p>
                <div class="text-xl font-bold text-slate-700">{{ $statistik['proses_kasi'] ?? 0 }} <span class="text-xs font-normal text-slate-400">Berkas</span></div>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center">
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Tahap 2: Kabid</p>
                <div class="text-xl font-bold text-slate-700">{{ $statistik['proses_kabid'] ?? 0 }} <span class="text-xs font-normal text-slate-400">Berkas</span></div>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center">
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Tahap 3: Kasubbag Umum</p>
                <div class="text-xl font-bold text-slate-700">{{ $statistik['proses_kasubbag'] ?? 0 }} <span class="text-xs font-normal text-slate-400">Berkas</span></div>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center">
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Tahap 4: Sekdin</p>
                <div class="text-xl font-bold text-slate-700">{{ $statistik['proses_sekdin'] ?? 0 }} <span class="text-xs font-normal text-slate-400">Berkas</span></div>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center col-span-2 sm:col-span-1">
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Tahap 5: Kadin</p>
                <div class="text-xl font-bold text-indigo-600">{{ $statistik['proses_kadin'] ?? 0 }} <span class="text-xs font-normal text-slate-400">Berkas</span></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                    <h3 class="font-bold text-slate-800">Menunggu Tindakan (Meja Kerja Admin)</h3>
                </div>
                <a href="{{ route('admin.pengajuan.index') }}" class="text-indigo-600 text-sm font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="p-0">
                @if(isset($butuhAksi) && $butuhAksi->count() > 0)
                <ul class="divide-y divide-slate-100">
                    @foreach($butuhAksi as $aksi)
                    <li class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex shrink-0 items-center justify-center text-amber-600 font-bold">
                                {{ substr($aksi->user->nama ?? $aksi->user->name ?? 'P', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $aksi->user->nama ?? $aksi->user->name ?? 'Nama Tidak Ditemukan' }}</p>
                                <p class="text-xs text-slate-400 mb-1">{{ $aksi->user->pegawai->bidang->nama_bidang ?? 'Tanpa Bidang' }}</p>
                                <p class="text-xs text-slate-600 font-medium">
                                    Mengajukan <span class="text-indigo-600">{{ $aksi->jenisCuti->nama ?? 'Cuti' }}</span> ({{ $aksi->lama_cuti ?? 0 }} Hari)
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between sm:justify-end gap-3 border-t sm:border-t-0 pt-3 sm:pt-0">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 uppercase tracking-wider">
                                {{ $aksi->status }}
                            </span>
                            <a href="{{ route('admin.pengajuan.show', $aksi->id) }}" class="p-2 bg-slate-50 hover:bg-indigo-50 text-slate-400 hover:text-indigo-600 rounded-xl transition" title="Verifikasi Berkas">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="py-12 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" class="w-16 h-16 mx-auto opacity-20 mb-3" alt="Empty">
                    <p class="text-slate-400 text-sm italic">Meja bersih! Belum ada berkas baru masuk ke Admin.</p>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-calendar-day text-emerald-500"></i> Sedang Cuti (Hari Ini)
                </h3>
            </div>
            <div class="p-6">
                @if(isset($cutiHariIni) && $cutiHariIni->count() > 0)
                <div class="space-y-4">
                    @foreach($cutiHariIni as $cuti)
                    <div class="p-4 rounded-2xl border border-slate-100 bg-white shadow-xs flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 text-xs">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="text-sm font-bold text-slate-800 truncate">{{ $cuti->user->nama ?? $cuti->user->name ?? 'Pegawai' }}</h4>
                            <p class="text-[11px] text-slate-400 truncate mb-1">{{ $cuti->user->pegawai->bidang->nama_bidang ?? 'Tanpa Bidang' }}</p>
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] bg-slate-100 text-slate-600 font-medium">
                                s.d {{ $cuti->tgl_selesai ? \Carbon\Carbon::parse($cuti->tgl_selesai)->translatedFormat('d M Y') : '-' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="py-8 text-center text-slate-400 text-sm italic">
                    <i class="fas fa-user-check block text-2xl text-slate-200 mb-2"></i>
                    Semua pegawai hadir penuh hari ini.
                </div>
                @endif
                
                <div class="mt-6 pt-6 border-t border-slate-100 flex justify-between items-center text-sm">
                    <span class="text-slate-500 font-medium">Total Cuti Bulan Ini:</span>
                    <span class="px-3 py-1 rounded-full font-bold bg-indigo-50 text-indigo-600">
                        {{ $cutiBulanIni ?? 0 }} Pegawai
                    </span>
                </div>
            </div>
        </div>

    </div>
</x-layouts.admin.app>