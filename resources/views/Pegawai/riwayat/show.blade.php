<x-layouts.pegawai.app>
    <div class="mb-6">
        <a href="{{ route('pegawai.riwayat.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            &larr; Kembali ke Daftar Riwayat
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lembar Dokumen Kontrol</span>
                            <h2 class="text-xl font-bold text-slate-800 mt-0.5">Detail Formulir Cuti</h2>
                        </div>
                        <div class="text-right sm:text-right">
                            <span class="text-xs text-slate-400 block">ID Registrasi</span>
                            <span class="text-sm font-mono font-bold text-slate-700">#REG-00{{ $pengajuan->id }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase block mb-1">Jenis Cuti Yang Diambil</label>
                            <p class="text-sm font-bold text-slate-800 bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
                                {{ $pengajuan->jenisCuti->nama }}
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase block mb-1">Durasi / Masa Waktu</label>
                            <p class="text-sm font-bold text-blue-700 bg-blue-50/50 px-3 py-2 rounded-xl border border-blue-100">
                                {{ $pengajuan->lama_cuti }} Hari Kerja
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase block mb-1">Tanggal Mulai Efektif</label>
                            <p class="text-sm font-medium text-slate-700 bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
                                📅 {{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->format('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase block mb-1">Tanggal Selesai Cuti</label>
                            <p class="text-sm font-medium text-slate-700 bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
                                🏁 {{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->format('d F Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-4">
                        <label class="text-xs font-bold text-slate-400 uppercase block mb-1">Alasan Pengajuan / Keterangan</label>
                        <div class="text-sm text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-100 leading-relaxed italic">
                            "{{ $pengajuan->alasan ?? 'Tidak ada alasan khusus yang dicantumkan.' }}"
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                    📝 Lembar Disposisi & Catatan Struktural
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block mb-1">Persetujuan Kepala Seksi (Kasi)</span>
                        <p class="text-xs text-slate-700 font-medium">{{ $pengajuan->catatan_kasi ?? 'Belum ada catatan atau disposisi.' }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block mb-1">Pertimbangan Kepala Bidang (Kabid)</span>
                        <p class="text-xs text-slate-700 font-medium">{{ $pengajuan->catatan_kabid ?? 'Belum ada catatan atau pertimbangan.' }}</p>
                    </div>
                </div>

                @if($pengajuan->status === 'Selesai')
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between">
                        <div class="text-sm">
                            <strong>Surat Cuti Siap Dicetak:</strong> Dokumen formulir permintaan cuti Anda telah disetujui penuh oleh pimpinan dan difinalisasi oleh Admin.
                        </div>
                        <a href="{{ route('pegawai.riwayat.cetak', $pengajuan->id) }}" target="_blank" class="px-5 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-lg hover:bg-slate-800 transition flex items-center gap-1.5 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Buka Lembar Cetak
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between min-h-[500px]">
            <div>
                <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                        📦 Lacak Alur Birokrasi Dokumen
                    </h3>
                    <span class="text-[10px] bg-emerald-50 text-emerald-600 font-bold px-2 py-0.5 rounded border border-emerald-200 animate-pulse">Live Tracking</span>
                </div>
                
                <div class="relative pl-8 border-l-2 border-slate-100 space-y-6 ml-3">
                    
                    @foreach($tracingLogs as $log)
                        <div class="relative group">
                            
                            @if($log['status'] === 'done')
                                <div class="absolute -left-[43px] top-0 w-6 h-6 rounded-full bg-emerald-500 border-4 border-emerald-100 flex items-center justify-center z-10 shadow-sm">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @elseif($log['status'] === 'process')
                                <div class="absolute -left-[43px] top-0 w-6 h-6 rounded-full bg-amber-500 border-4 border-amber-100 flex items-center justify-center z-10 animate-pulse shadow">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                </div>
                            @elseif($log['status'] === 'rejected')
                                <div class="absolute -left-[43px] top-0 w-6 h-6 rounded-full bg-rose-500 border-4 border-rose-100 flex items-center justify-center z-10 shadow">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="absolute -left-[40px] top-1 w-4 h-4 rounded-full bg-slate-200 border-2 border-white z-10 group-hover:bg-slate-300 transition-colors"></div>
                            @endif

                            <div class="p-3 rounded-xl transition-all duration-200 
                                {{ $log['status'] === 'process' ? 'bg-amber-50/60 border border-amber-100 shadow-sm' : 
                                   ($log['status'] === 'done' ? 'bg-slate-50/40 hover:bg-slate-50/80 border border-transparent' : 'opacity-50') }}">
                                
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                                    <h4 class="text-xs font-bold 
                                        {{ $log['status'] === 'done' ? 'text-emerald-600' : 
                                           ($log['status'] === 'process' ? 'text-amber-600' : 
                                           ($log['status'] === 'rejected' ? 'text-rose-600' : 'text-slate-700')) }}">
                                        {{ $log['title'] }}
                                    </h4>
                                    @if($log['time'])
                                        <span class="text-[10px] text-slate-400 font-semibold whitespace-nowrap bg-white px-1.5 py-0.5 rounded border border-slate-100 shadow-2xs">
                                            {{ $log['time'] }}
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-[11px] text-slate-500 leading-relaxed">
                                    {{ $log['desc'] }}
                                </p>
                            </div>

                        </div>
                    @endforeach

                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block mb-1.5">Posisi Berkas Saat Ini:</span>
                <div class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-bold rounded-full border
                    {{ $pengajuan->status === 'Selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                       ($pengajuan->status === 'Ditolak' ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-amber-50 text-amber-700 border-amber-200') }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $pengajuan->status === 'Selesai' ? 'bg-emerald-500' : ($pengajuan->status === 'Ditolak' ? 'bg-rose-500' : 'bg-amber-500') }}"></span>
                    {{ $pengajuan->status }}
                </div>
            </div>
        </div>

    </div>
</x-layouts.pegawai.app>