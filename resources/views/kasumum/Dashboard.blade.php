<x-layouts.kasumum.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    Dashboard Kasubbag Umum dan Kepegawaian
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Monitoring & verifikasi berkas cuti lintas seluruh bidang kerja.</p>
            </div>
            <div class="px-3 py-1.5 bg-slate-100 rounded-xl text-xs font-semibold text-slate-600 flex items-center gap-2 border border-slate-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Mode Akses: Semua Bidang
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HERO BANNER PREMIUM ALA ADMIN --}}
            <div class="relative rounded-3xl overflow-hidden bg-slate-900 shadow-2xl shadow-slate-200/50 mb-10 -mt-2">
                <div class="absolute inset-0">
                    <div class="absolute inset-0 bg-gradient-to-br from-lime-500/10 to-emerald-500/20 mix-blend-overlay"></div>
                    <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover opacity-10 mix-blend-luminosity" alt="Office bg">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/95 to-slate-900/50"></div>
                </div>

                <div class="relative z-10 p-8 md:p-12 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-lime-500/10 border border-lime-400/20 text-lime-300 text-xs font-semibold backdrop-blur-md cursor-default">
                            <span class="w-2 h-2 rounded-full bg-lime-400 shadow-[0_0_8px_rgba(163,230,53,0.8)] animate-pulse"></span>
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </div>

                        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                           <span class="text-transparent bg-clip-text bg-slate-50">{{ $sapaan ?? 'Selamat Datang' }},</span> <br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-lime-300">
                                    {{ explode(' ', Auth::user()->nama)[0] }}
                                </span>

                                <span class="text-white opacity-80 font-light mx-2">-</span>

                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-300 via-yellow-300 to-amber-300">
                                    {{ Auth::user()->pegawai->jabatan ?? '' }}
                                </span>
                        </h1>

                        <p class="text-slate-400 text-base md:text-lg max-w-lg leading-relaxed">
                            Hari ini status kehadiran Anda tercatat sebagai
                            @if($is_cuti)
                            <span class="text-amber-400 font-extrabold underline decoration-wavy decoration-amber-400/50">Sedang Cuti</span>.
                            @else
                            <span class="text-lime-400 font-extrabold inline-flex items-center gap-1.5">
                                Hadir Kerja
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-lime-500"></span>
                                </span>
                            </span>.
                            @endif
                            Pantau pergerakan berkas, lakukan verifikasi, dan validasi kuota secara real-time.
                        </p>

                        <div class="flex flex-wrap gap-4 pt-2">
                            <a href="{{ route('kasumum.persetujuan.index') }}" class="px-6 py-3 bg-lime-400 hover:bg-lime-500 text-slate-900 rounded-xl font-bold shadow-lg shadow-lime-400/20 transition-all duration-300 ease-out transform hover:-translate-y-1">
                                Cek Antrean Berkas
                            </a>
                        </div>
                    </div>

                    {{-- SIDE PANEL INFO SISTEM / MEJA KERJA --}}
                    <div class="lg:col-span-5 relative hidden md:block">
                        <div class="absolute -inset-1 bg-gradient-to-r from-lime-500 to-emerald-500 rounded-3xl blur opacity-10"></div>
                        <div class="relative bg-slate-800/60 backdrop-blur-xl border border-white/10 p-7 rounded-3xl text-white shadow-xl">
                            <div class="flex items-center justify-between mb-5 border-b border-white/10 pb-4">
                                <h3 class="font-bold text-lg flex items-center gap-2">
                                    <i class="fas fa-info-circle text-lime-400"></i> Meja Kerja Validasi
                                </h3>
                                <span class="text-[10px] bg-lime-500/20 text-lime-300 px-2 py-1 rounded md:uppercase tracking-wider font-bold border border-lime-500/20">
                                    SOP Kasubbag
                                </span>
                            </div>
                            <ul class="space-y-5">
                                <li class="flex gap-4">
                                    <div class="mt-0.5 w-7 h-7 rounded-full bg-slate-700/50 border border-white/10 flex items-center justify-center text-xs font-bold text-lime-400 shrink-0">1</div>
                                    <div>
                                        <span class="block text-sm font-semibold text-slate-200">Verifikasi Lintas Bidang</span>
                                        <p class="text-xs text-slate-400 leading-relaxed mt-1">Periksa kelayakan berkas usulan cuti dari seluruh bidang yang telah diparaf oleh masing-masing Kabid.</p>
                                    </div>
                                </li>
                                <li class="flex gap-4">
                                    <div class="mt-0.5 w-7 h-7 rounded-full bg-slate-700/50 border border-white/10 flex items-center justify-center text-xs font-bold text-lime-400 shrink-0">2</div>
                                    <div>
                                        <span class="block text-sm font-semibold text-slate-200">Validasi Kuota Cuti</span>
                                        <p class="text-xs text-slate-400 leading-relaxed mt-1">Pastikan sisa kuota cuti tahunan pegawai dihitung dengan tepat sebelum diteruskan ke tahapan Sekdin/Kadin.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GRID STATISTIK UTAMA --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Card 1: Antrean Berkas --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Antrian Review</p>
                            <h3 class="text-3xl font-black text-slate-800 tracking-tight mt-1">{{ $statistik['menunggu_aksi'] }}</h3>
                            <p class="text-[11px] text-amber-600 font-medium flex items-center gap-1 pt-2">
                                <i class="fas fa-clock"></i> Perlu verifikasi Anda
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-xl shadow-inner border border-amber-100/50">
                            <i class="fas fa-folder-open"></i>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Pegawai Cuti Hari Ini --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Cuti Hari Ini</p>
                            <h3 class="text-3xl font-black text-slate-800 tracking-tight mt-1">{{ $statistik['pegawai_cuti'] }}</h3>
                            <p class="text-[11px] text-emerald-600 font-medium flex items-center gap-1 pt-2">
                                <i class="fas fa-user-check"></i> Pegawai sedang tidak di kantor
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-xl shadow-inner border border-emerald-100/50">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Disetujui Bulan Ini --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Disetujui Bulan Ini</p>
                            <h3 class="text-3xl font-black text-slate-800 tracking-tight mt-1">{{ $statistik['disetujui_bulan_ini'] }}</h3>
                            <p class="text-[11px] text-indigo-600 font-medium flex items-center gap-1 pt-2">
                                <i class="fas fa-calendar-check"></i> Akumulasi bulan berjalan
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center text-xl shadow-inner border border-indigo-100/50">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CATATAN: BAGIAN "POSISI BERKAS BERJALAN" TELAH DIHAPUS SESUAI PERMINTAAN --}}

            {{-- STRUKTUR DUA KOLOM: MEJA KERJA UTAMA & DETAIL SIDEBAR --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: DAFTAR ANTRIAN MASUK --}}
                <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                            <h3 class="font-bold text-slate-800">Menunggu Tindakan (Meja Kerja Kasubbag)</h3>
                        </div>
                        <a href="{{ route('kasumum.persetujuan.index') }}" class="text-lime-600 text-sm font-bold hover:text-lime-700 transition">Lihat Semua</a>
                    </div>

                    <div class="p-0">
                        @if(isset($pengajuanButuhAksi) && $pengajuanButuhAksi->count() > 0)
                        <ul class="divide-y divide-slate-100">
                            @foreach($pengajuanButuhAksi as $item)
                            <li class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex shrink-0 items-center justify-center text-slate-700 font-black shadow-inner border border-slate-200/40">
                                        {{ strtoupper(substr($item->user->nama ?? 'P', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 leading-snug">{{ $item->user->nama ?? '-' }}</p>
                                        <p class="text-[11px] text-slate-400 mb-1">NIP. {{ $item->user->nip ?? '-' }}</p>

                                        <div class="flex flex-wrap items-center gap-2 mt-1">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100/30">
                                                <i class="fas fa-layer-group text-[9px] opacity-70"></i>
                                                {{ $item->user->pegawai->bidang->nama_bidang ?? 'Umum / Global' }}
                                            </span>
                                            <span class="text-xs text-slate-600 font-medium">
                                                {{-- Perbaikan: Menampilkan jenis cuti murni dari database tanpa override default 'Cuti Tahunan' --}}
                                                Mengajukan <span class="text-emerald-600 font-bold">{{ $item->jenisCuti->nama ?? '-' }}</span>
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-slate-400 font-medium mt-1">
                                            <i class="far fa-calendar-alt text-[10px]"></i>
                                            {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                            <span class="text-indigo-600 font-bold">({{ $item->lama_cuti }} Hari)</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between sm:justify-end gap-3 border-t sm:border-t-0 pt-3 sm:pt-0">
                                    <a href="{{ route('kasumum.persetujuan.show', $item->id) }}" class="inline-flex items-center px-3 py-2 bg-lime-400 hover:bg-lime-500 text-slate-900 font-extrabold rounded-xl text-xs uppercase tracking-wider transition-all shadow-sm">
                                        Review Permohonan<i class="fas fa-chevron-right text-[10px]"></i>
                                    </a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <div class="py-16 text-center">
                            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                                <i class="fas fa-folder-open text-xl opacity-60"></i>
                            </div>
                            <p class="text-slate-500 text-sm font-bold">Meja bersih! Belum ada berkas antrian baru dari bidang mana pun.</p>
                            <p class="text-xs text-slate-400 mt-0.5">Semua berkas masuk telah selesai Anda verifikasi.</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- KOLOM KANAN: RINGKASAN MONITORING CUTI --}}
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
                        <div class="py-12 text-center text-slate-400 text-sm italic">
                            <i class="fas fa-user-check block text-3xl text-slate-200 mb-2"></i>
                            Hari ini semua pegawai terdata hadir penuh di kantor.
                        </div>
                        @endif

                        <div class="mt-6 pt-6 border-t border-slate-100 flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Total Cuti Bulan Ini:</span>
                            <span class="px-3 py-1 rounded-full font-bold bg-lime-50 text-lime-700 border border-lime-100">
                                {{ $statistik['disetujui_bulan_ini'] }} Pegawai
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-layouts.kasumum.app>
