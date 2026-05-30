<x-layouts.pegawai.app>
    <x-slot:title>Dashboard Pegawai E-CUTI ESDM</x-slot:title>

    <div class="pt-24 pb-12 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="relative rounded-3xl overflow-hidden bg-slate-900 shadow-2xl shadow-slate-200/50 mb-10 -mt-12">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-lime-500/20 to-amber-500/20 mix-blend-overlay"></div>
                <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1600&q=80"
                    class="w-full h-full object-cover opacity-20 mix-blend-luminosity" alt="Office bg">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/90 to-slate-900/40"></div>
            </div>

            <div class="relative z-10 p-8 md:p-12 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-7 space-y-6">

                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $is_cuti ? 'bg-rose-500/20 border border-rose-400/30 text-rose-200' : 'bg-lime-500/20 border border-lime-400/30 text-lime-200' }} text-xs font-semibold backdrop-blur-md cursor-default">
                        <span class="w-2 h-2 rounded-full {{ $is_cuti ? 'bg-rose-400 shadow-rose-500' : 'bg-lime-400 shadow-lime-500' }} animate-pulse shadow-[0_0_8px_rgba(0,0,0,0.5)]"></span>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>

                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-500 to-lime-300">{{ $sapaan }},</span> <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-300 to-amber-300">
                            {{ $user->name ?? $user->nama }}
                        </span>
                        <span class="text-white opacity-80 font-light mx-2">-</span>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-amber-500">
                            {{ $user->pegawai->jabatan ?? 'Pegawai' }}
                        </span>
                    </h1>

                    <p class="text-slate-400 text-lg max-w-lg leading-relaxed">
                        Pantau kinerja dan cuti Anda dalam satu dashboard terintegrasi.
                        Hari ini status Anda tercatat 
                        @if($is_cuti)
                        <span class="text-rose-400 font-bold drop-shadow-md">Cuti</span>
                        @else
                        <span class="text-lime-400 font-bold drop-shadow-md">Hadir</span>
                        @endif.
                    </p>

                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="{{ route('pegawai.pengajuan.create') }}"
                            class="px-6 py-3 bg-lime-500 hover:bg-lime-400 text-slate-900 rounded-xl font-bold shadow-lg shadow-lime-500/30 transition-all duration-300 ease-out transform hover:-translate-y-1">
                            Ajukan Cuti Baru
                        </a>
                        <a href="{{ route('pegawai.kalender.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-white/10 hover:bg-white/20 text-white border border-white/10 rounded-xl font-medium backdrop-blur-md transition-all duration-300 ease-out transform hover:-translate-y-1">
                            Lihat Kalender
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5 relative hidden md:block">
                    <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-3xl blur opacity-20"></div>
                    <div class="relative bg-slate-800/60 backdrop-blur-xl border border-white/10 p-7 rounded-3xl text-white shadow-xl">
                        <div class="flex items-center justify-between mb-5 border-b border-white/10 pb-4">
                            <h3 class="font-bold text-lg flex items-center gap-2">
                                <span>⚠️</span> Aturan Cuti
                            </h3>
                            <span class="text-[10px] bg-amber-500/20 text-amber-300 px-2 py-1 rounded md:uppercase tracking-wider font-bold border border-amber-500/20">
                                Penting
                            </span>
                        </div>
                        <ul class="space-y-5">
                            <li class="flex gap-4">
                                <div class="mt-0.5 w-7 h-7 rounded-full bg-slate-700/50 border border-white/10 flex items-center justify-center text-xs font-bold text-slate-300 shrink-0">1</div>
                                <div>
                                    <span class="block text-sm font-semibold text-amber-400">Cuti Tahunan Hak N-2</span>
                                    <p class="text-xs text-slate-400 leading-relaxed mt-1">Sisa cuti jatah dua tahun lalu (N-2) otomatis hangus apabila tidak digunakan pada masa tahun berjalan aktif.</p>
                                </div>
                            </li>
                            <li class="flex gap-4">
                                <div class="mt-0.5 w-7 h-7 rounded-full bg-slate-700/50 border border-white/10 flex items-center justify-center text-xs font-bold text-slate-300 shrink-0">2</div>
                                <div>
                                    <span class="block text-sm font-semibold text-amber-400">Verifikasi Berkas</span>
                                    <p class="text-xs text-slate-400 leading-relaxed mt-1">Setiap pengajuan wajib lolos pemeriksaan administratif oleh Sub Bagian Umum sebelum diteruskan ke Pejabat Penilai.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="group bg-white rounded-3xl p-1.5 shadow-sm hover:shadow-xl hover:shadow-lime-500/10 transition-all duration-300">
                <div class="bg-gradient-to-br from-lime-50/50 to-white rounded-[1.4rem] p-6 h-full border border-lime-100/50 relative overflow-hidden">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Sisa Cuti</p>
                            <h2 class="text-5xl font-extrabold text-slate-800 mt-2 tracking-tight">{{ $sisa_total }}<span class="text-lg text-slate-400 font-semibold ml-1">Hari</span></h2>
                        </div>
                        <div class="w-12 h-12 bg-lime-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-lime-500/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="space-y-2.5">
                        <div class="flex justify-between text-xs font-semibold text-slate-500">
                            <span>Sisa Kuota Aktif</span>
                            <span class="text-lime-600">{{ round($persentase_sisa) }}% Tersedia</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-lime-500 h-full rounded-full transition-all duration-1000 ease-out" style="width: {{ $persentase_sisa }}%"></div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between items-center bg-white p-3 rounded-2xl border border-slate-100 shadow-sm">
                        <div class="text-center px-2 flex-1">
                            <div class="text-[10px] text-slate-400 font-medium">Jatah N-2</div>
                            <div class="font-bold text-slate-700 mt-0.5">{{ $sisa_n2 }}</div>
                        </div>
                        <div class="w-px h-8 bg-slate-100"></div>
                        <div class="text-center px-2 flex-1">
                            <div class="text-[10px] text-slate-400 font-medium">Jatah N-1</div>
                            <div class="font-bold text-slate-700 mt-0.5">{{ $sisa_n1 }}</div>
                        </div>
                        <div class="w-px h-8 bg-slate-100"></div>
                        <div class="text-center px-2 flex-1">
                            <div class="text-[10px] text-slate-400 font-medium">Tahun {{ $tahun_skrg }}</div>
                            <div class="font-bold text-lime-600 mt-0.5">{{ $sisa_n }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 border border-slate-100/80">
                <div class="flex flex-col h-full justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 bg-amber-50 rounded-2xl text-amber-500 transition-transform duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 border border-amber-100 text-xs font-bold rounded-full">Proses</span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-800 mb-1 tracking-tight">{{ $jumlah_proses }}</h3>
                        <p class="text-slate-500 font-medium text-sm">Pengajuan Aktif</p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <p class="text-[11px] text-slate-400 leading-relaxed">Berkas dalam tahap tinjauan administrasi kepegawaian atau persetujuan pimpinan.</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl hover:shadow-lime-500/10 transition-all duration-300 border border-slate-100/80">
                <div class="flex flex-col h-full justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 bg-lime-50 rounded-2xl text-lime-600 transition-transform duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="px-3 py-1 bg-lime-50 text-lime-600 border border-lime-100 text-xs font-bold rounded-full">Used</span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-slate-800 mb-1 tracking-tight">{{ $terpakai }}</h3>
                        <p class="text-slate-500 font-medium text-sm">Hari Terpakai</p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <p class="text-[11px] text-slate-400 leading-relaxed">Total akumulasi kuota cuti yang disetujui resmi sepanjang tahun {{ $tahun_skrg }}.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-10">
            <div class="px-6 md:px-8 py-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-800">Riwayat Pengajuan Cuti</h2>
                    <p class="text-sm text-slate-500 mt-1">Pantau pergerakan posisi lembar dokumen pengajuan cuti Anda.</p>
                </div>
                <a href="#" class="group inline-flex items-center justify-center px-4 py-2 bg-amber-50 hover:bg-lime-100 rounded-xl text-sm font-semibold text-slate-600 transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-2 text-slate-400 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            @forelse($riwayat as $item)
            @if($loop->first)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 md:px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal & Waktu</th>
                            <th class="px-6 md:px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis Cuti</th>
                            <th class="px-6 md:px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Durasi</th>
                            <th class="px-6 md:px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Status Berkas</th>
                            <th class="px-6 md:px-8 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @endif
                        <tr class="group hover:bg-slate-50/80 transition-colors duration-200">
                            <td class="px-6 md:px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ $item->created_at->translatedFormat('d F Y') }}</span>
                                    <span class="text-xs text-slate-400 mt-0.5">{{ $item->created_at->format('H:i') }} WIB</span>
                                </div>
                            </td>
                            <td class="px-6 md:px-8 py-5">
                                <span class="text-sm font-semibold text-slate-700">{{ $item->jenisCuti->nama ?? '-' }}</span>
                            </td>
                            <td class="px-6 md:px-8 py-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-slate-50 text-slate-600 border border-slate-200/60">
                                    {{ $item->lama_cuti }} Hari
                                </span>
                            </td>
                            <td class="px-6 md:px-8 py-5">
                                @php
                                $statusStyles = match($item->status) {
                                    'Disetujui' => 'bg-lime-50 text-lime-700 border-lime-200',
                                    'Ditolak'   => 'bg-rose-50 text-rose-700 border-rose-200',
                                    'Dibatalkan'=> 'bg-slate-50 text-slate-600 border-slate-200',
                                    default     => 'bg-amber-50 text-amber-700 border-amber-200',
                                };
                                $dotColor = match($item->status) {
                                    'Disetujui' => 'bg-lime-500',
                                    'Ditolak'   => 'bg-rose-500',
                                    'Dibatalkan'=> 'bg-slate-400',
                                    default     => 'bg-amber-500',
                                };
                                @endphp
                                <span class="inline-flex items-center pl-2.5 pr-3.5 py-1.5 rounded-full text-[11px] font-bold border {{ $statusStyles }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $dotColor }}"></span>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 md:px-8 py-5 text-right">
                                <a href="#" class="inline-flex items-center justify-center text-slate-400 hover:text-lime-600 transition-colors p-2 hover:bg-lime-50 rounded-xl" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @if($loop->last)
                    </tbody>
                </table>
            </div>
            @endif
            @empty
            <div class="py-16 text-center flex flex-col items-center justify-center">
                <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mb-5 border border-slate-100 shadow-sm">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-slate-700 font-extrabold text-lg">Belum Ada Riwayat Pengajuan</h3>
                <p class="text-slate-500 mt-2 text-sm max-w-sm mx-auto leading-relaxed">Anda belum pernah melakukan pengajuan cuti. Gunakan tombol "Ajukan Cuti Baru" di atas untuk memulai.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-layouts.pegawai.app>