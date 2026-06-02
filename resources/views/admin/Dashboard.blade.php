<x-layouts.admin.app>
    <x-slot:title>Dashboard Admin - E-CUTI ESDM</x-slot:title>

    {{-- HERO SECTION ADMIN (Dark Mode Style) --}}
    <div class="bg-slate-900 rounded-[2rem] p-6 lg:p-8 mb-8 text-white shadow-lg relative overflow-hidden flex flex-col lg:flex-row gap-8 justify-between items-center">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/10 blur-3xl rounded-full translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>

        <div class="z-10 w-full lg:w-3/5">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-slate-800/80 border border-slate-700 rounded-full text-xs font-semibold text-emerald-400 mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>

            {{-- Logic Sapaan Berdasarkan Waktu --}}
            @php
            $hour = now()->format('H');
            if ($hour < 11) $greeting='Pagi' ; elseif ($hour < 15) $greeting='Siang' ; elseif ($hour < 18) $greeting='Sore' ; else $greeting='Malam' ; @endphp <h1 class="text-3xl lg:text-5xl font-bold mb-4 tracking-tight">
                Selamat {{ $greeting }},<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-300 to-amber-300">{{ Auth::user()->nama ?? 'Administrator' }}</span>
                </h1>

                <p class="text-slate-400 mb-8 max-w-xl text-sm lg:text-base leading-relaxed">
                    Kelola seluruh data cuti pegawai, pantau alur birokrasi, dan verifikasi kelengkapan administratif dalam satu dashboard terpusat.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('admin.pengajuan.index') }}" class="px-6 py-3 bg-lime-500 hover:bg-lime-400 text-slate-900 font-bold rounded-xl transition shadow-[0_0_15px_rgba(132,204,22,0.3)] flex items-center gap-2">
                        <i class="fas fa-clipboard-check"></i> Cek Antrean Berkas
                    </a>
                    <a href="#" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-medium rounded-xl transition flex items-center gap-2">
                        <i class="fas fa-users"></i> Kelola Pegawai
                    </a>
                </div>
        </div>

        <div class="z-10 w-full lg:w-2/5">
            <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl p-6 relative backdrop-blur-sm">
                <div class="absolute -top-3 -right-3 px-3 py-1 bg-amber-500/20 border border-amber-500/30 text-amber-400 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                    Fokus Utama
                </div>

                <h3 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">
                    <i class="fas fa-shield-alt text-amber-500"></i> Peran Administrator
                </h3>

                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-slate-700 text-slate-300 flex items-center justify-center shrink-0 text-xs font-bold mt-0.5">1</div>
                        <div>
                            <p class="text-sm font-bold text-slate-200">Verifikasi Administratif</p>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Pastikan seluruh berkas pengajuan lolos pemeriksaan Sub Bagian Umum sebelum diteruskan ke pimpinan.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-slate-700 text-slate-300 flex items-center justify-center shrink-0 text-xs font-bold mt-0.5">2</div>
                        <div>
                            <p class="text-sm font-bold text-slate-200">Kawal Alur Persetujuan</p>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Pantau *Tracking Alur Cuti* di bawah untuk memastikan tidak ada dokumen yang tertahan di satu tahap.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    {{-- KARTU UTAMA INDIKATOR RINGKASAN --}}
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

    {{-- PELACAKAN PIPELINE BERKAS (MONITORING FLOWCHART) --}}
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
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Tahap 3: Kasubbag</p>
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

    {{-- SPLIT GRID: MEJA KERJA ADMIN VS MONITORING REALTIME --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- SISI KIRI: ANTRIAN BUTUH AKSI ADMIN --}}
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
                                {{ substr($aksi->user->nama ?? 'P', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $aksi->user->nama ?? 'Nama Tidak Ditemukan' }}</p>
                                <p class="text-xs text-slate-400 mb-1">{{ $aksi->user->pegawai->bidang->nama_bidang ?? 'Tanpa Bidang' }}</p>
                                <p class="text-xs text-slate-600 font-medium">
                                    Mengajukan <span class="text-indigo-600">{{ $aksi->jenisCuti->nama ?? 'Cuti' }}</span> ({{ $aksi->lama_cuti }} Hari)
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between sm:justify-end gap-3 border-t sm:border-t-0 pt-3 sm:pt-0">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 uppercase tracking-wider">
                                {{ $aksi->status }}
                            </span>
                            {{-- Route diarahkan ke halaman detail verifikasi dokumen --}}
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

        {{-- SISI KANAN: MONITORING PEGAWAI CUTI HARI INI --}}
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
                            <h4 class="text-sm font-bold text-slate-800 truncate">{{ $cuti->user->nama }}</h4>
                            <p class="text-[11px] text-slate-400 truncate mb-1">{{ $cuti->user->pegawai->bidang->nama_bidang ?? 'Tanpa Bidang' }}</p>
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] bg-slate-100 text-slate-600 font-medium">
                                s.d {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->translatedFormat('d M Y') }}
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

                {{-- STATISTIK BULANAN --}}
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
