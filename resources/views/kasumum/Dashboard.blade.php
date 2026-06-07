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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- Grid Statistik Utama --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                
                {{-- Card 1: Antrean Berkas --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                    <div class="space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Antrian Review</span>
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $statistik['menunggu_aksi'] }}</h3>
                        <p class="text-[11px] text-amber-600 font-medium flex items-center gap-1 pt-1">
                            <i class="fas fa-clock"></i> Perlu verifikasi Anda
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-xl shadow-inner border border-amber-100/50">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>

                {{-- Card 2: Pegawai Cuti Hari Ini --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                    <div class="space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Cuti Hari Ini</span>
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $statistik['pegawai_cuti'] }}</h3>
                        <p class="text-[11px] text-emerald-600 font-medium flex items-center gap-1 pt-1">
                            <i class="fas fa-user-check"></i> Pegawai sedang tidak ngantor
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-xl shadow-inner border border-emerald-100/50">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>

                {{-- Card 3: Disetujui Bulan Ini --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                    <div class="space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Disetujui Bulan Ini</span>
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $statistik['disetujui_bulan_ini'] }}</h3>
                        <p class="text-[11px] text-indigo-600 font-medium flex items-center gap-1 pt-1">
                            <i class="fas fa-calendar-check"></i> Akumulasi bulan ini
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center text-xl shadow-inner border border-indigo-100/50">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                </div>

            </div>

            {{-- Tabel Antrian Utama (Lintas Bidang) --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                    <div>
                        <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-list text-amber-500"></i> Berkas Masuk Perlu Review
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar pengajuan seluruh bidang yang telah disetujui oleh para Kabid.</p>
                    </div>
                    <a href="{{ route('kasumum.persetujuan.index') }}" class="px-4 py-2 bg-slate-900 text-white hover:bg-slate-800 rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-sm">
                        Lihat Semua Berkas
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase font-bold tracking-widest border-b border-slate-100">
                                <th class="py-4 px-6">Pegawai / Pemohon</th>
                                <th class="py-4 px-6">Asal Bidang</th>
                                <th class="py-4 px-6">Jenis & Durasi Cuti</th>
                                <th class="py-4 px-6">Tanggal Masuk</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($pengajuanButuhAksi as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    {{-- Nama & NIP --}}
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs shadow-inner">
                                                {{ strtoupper(substr($item->user->nama ?? 'P', 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 leading-tight">{{ $item->user->nama ?? '-' }}</p>
                                                <p class="text-[11px] text-slate-400 mt-0.5">NIP. {{ $item->user->nip ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- Badge Asal Bidang Kerja --}}
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100/50">
                                            <i class="fas fa-layer-group text-[10px] opacity-70"></i>
                                            {{ $item->user->pegawai->bidang->nama_bidang ?? 'Umum / Global' }}
                                        </span>
                                    </td>
                                    {{-- Detail Jenis Cuti --}}
                                    <td class="py-4 px-6">
                                        <p class="font-semibold text-slate-700 leading-tight">{{ $item->jenisCuti->nama_cuti ?? 'Cuti Tahunan' }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5 font-medium">
                                            {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }} 
                                            <span class="text-indigo-600 font-bold">({{ $item->lama_cuti }} Hari)</span>
                                        </p>
                                    </td>
                                    {{-- Tanggal Submit Form --}}
                                    <td class="py-4 px-6 text-slate-500 font-medium text-xs">
                                        {{ $item->created_at ? $item->created_at->translatedFormat('d M Y H:i') . ' WIB' : '-' }}
                                    </td>
                                    {{-- Tombol Aksi Review --}}
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('kasumum.persetujuan.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-lime-400 hover:bg-lime-500 text-slate-900 font-extrabold rounded-xl text-xs uppercase tracking-wider transition-all shadow-sm shadow-lime-400/10">
                                            <i class="fas fa-search-plus text-[10px]"></i> Review
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 px-6 text-center">
                                        <div class="flex flex-col items-center justify-center gap-2 opacity-50">
                                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 text-lg">
                                                <i class="fas fa-folder-open"></i>
                                            </div>
                                            <p class="text-xs font-bold text-slate-500">Tidak ada berkas antrian baru dari bidang mana pun.</p>
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
</x-layouts.kasumum.app>