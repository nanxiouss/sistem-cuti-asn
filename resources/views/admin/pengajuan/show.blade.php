<x-layouts.admin.app>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Detail Pengajuan Cuti</h2>
            <p class="text-slate-500 text-sm">Tinjau kelengkapan berkas serta lacak posisi dokumen pada alur birokrasi dinas.</p>
        </div>
        <a href="{{ route('admin.pengajuan.index') }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-lg hover:bg-slate-50 transition shadow-sm text-sm">
            &larr; Kembali
        </a>
    </div>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
        <ul class="list-disc list-inside text-sm font-medium">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Data Pengajuan --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Info Pegawai --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="border-b border-slate-100 bg-slate-50/50 p-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">I</span>
                        Data Pegawai
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->user->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">NIP</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->user->nip }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jabatan</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->user->pegawai->jabatan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Bidang</p>
                        @php
                            $bidangData = is_string($pengajuan->user->pegawai->bidang) ? json_decode($pengajuan->user->pegawai->bidang) : $pengajuan->user->pegawai->bidang;
                            $namaBidang = $bidangData->nama_bidang ?? ($pengajuan->user->pegawai->bidang ?? '-');
                        @endphp
                        <p class="font-semibold text-slate-800">{{ $namaBidang }}</p>
                    </div>
                </div>
            </div>

            {{-- Info Detail Cuti --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="border-b border-slate-100 bg-slate-50/50 p-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">II</span>
                        Detail Cuti
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis Cuti</p>
                            <p class="font-semibold text-slate-800">{{ $pengajuan->jenisCuti->nama ?? $pengajuan->jenisCuti->nama_cuti }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Durasi</p>
                            <p class="font-semibold text-blue-600">{{ $pengajuan->lama_cuti }} Hari Kerja</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Mulai</p>
                            <p class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Selesai</p>
                            <p class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alasan Cuti</p>
                        <p class="text-sm font-medium text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-150">{{ $pengajuan->alasan }}</p>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat & Kontak Selama Cuti</p>
                        <p class="text-sm font-medium text-slate-700">{{ $pengajuan->alamat ?? $pengajuan->alamat_cuti }}</p>
                        <p class="text-sm font-medium text-slate-700 mt-1">📞 {{ $pengajuan->no_telepon }}</p>
                    </div>

                    @if($pengajuan->bukti || $pengajuan->file_bukti)
                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Lampiran Berkas</p>
                        <a href="{{ asset('storage/' . ($pengajuan->bukti ?? $pengajuan->file_bukti)) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-bold rounded-lg hover:bg-blue-100 transition border border-blue-100">
                            Lihat Lampiran File
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Monitoring Alur Sampai Kadin --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-5 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-route text-slate-400"></i> Alur Persetujuan Cuti
                </h3>
                
                {{-- Tracker Alur Kerja Dinamis --}}
                <div class="relative pl-6 space-y-6 before:absolute before:bottom-2 before:top-2 before:left-2.5 before:w-0.5 before:bg-slate-200">
                    {{-- 1. Kasi / Kepala Seksi --}}
                    @php
                        $kasiActive = ($pengajuan->status === 'Menunggu Kasi');
                        $kasiPassed = in_array($pengajuan->status, ['Menunggu Kabid', 'Menunggu Kasubbag Umum', 'Menunggu Sekdin', 'Menunggu Kadin', 'Menunggu Pemberkasan', 'Selesai']);
                    @endphp
                    <div class="relative flex items-start gap-4">
                        <div class="absolute -left-[22px] flex items-center justify-center w-5 h-5 rounded-full border-2 {{ $kasiPassed ? 'bg-emerald-500 border-emerald-500 text-white' : ($kasiActive ? 'bg-white border-amber-500 ring-4 ring-white' : 'bg-white border-slate-300') }} z-10 shadow">
                            @if($kasiPassed)
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            @elseif($kasiActive)
                                <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            @endif
                        </div>
                        <div class="flex-1 p-3 rounded-xl border {{ $kasiPassed ? 'border-emerald-100 bg-emerald-50/30' : ($kasiActive ? 'border-amber-200 bg-amber-50/50 shadow-sm ring-1 ring-amber-300' : 'border-slate-100 bg-slate-50/30') }}">
                            <h4 class="font-bold {{ $kasiPassed ? 'text-emerald-800' : ($kasiActive ? 'text-amber-800' : 'text-slate-400') }} text-xs">Kasi / Kepala Seksi</h4>
                            <p class="text-[10px] {{ $kasiActive ? 'text-amber-600' : 'text-slate-400' }} font-medium">Persetujuan Tingkat I</p>
                        </div>
                    </div>

                    {{-- 2. Kabid / Kepala Bidang --}}
                    @php
                        $kabidActive = ($pengajuan->status === 'Menunggu Kabid');
                        $kabidPassed = in_array($pengajuan->status, ['Menunggu Kasubbag Umum', 'Menunggu Sekdin', 'Menunggu Kadin', 'Menunggu Pemberkasan', 'Selesai']);
                    @endphp
                    <div class="relative flex items-start gap-4">
                        <div class="absolute -left-[22px] flex items-center justify-center w-5 h-5 rounded-full border-2 {{ $kabidPassed ? 'bg-emerald-500 border-emerald-500 text-white' : ($kabidActive ? 'bg-white border-amber-500 ring-4 ring-white' : 'bg-white border-slate-300') }} z-10 shadow">
                            @if($kabidPassed)
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            @elseif($kabidActive)
                                <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            @endif
                        </div>
                        <div class="flex-1 p-3 rounded-xl border {{ $kabidPassed ? 'border-emerald-100 bg-emerald-50/30' : ($kabidActive ? 'border-amber-200 bg-amber-50/50 shadow-sm ring-1 ring-amber-300' : 'border-slate-100 bg-slate-50/30') }}">
                            <h4 class="font-bold {{ $kabidPassed ? 'text-emerald-800' : ($kabidActive ? 'text-amber-800' : 'text-slate-400') }} text-xs">Kabid / Kepala Bidang</h4>
                            <p class="text-[10px] {{ $kabidActive ? 'text-amber-600' : 'text-slate-400' }} font-medium">Persetujuan Tingkat II</p>
                        </div>
                    </div>
                    
                    {{-- 3. Kasubbag Umum --}}
                    @php
                        $kasumumActive = ($pengajuan->status === 'Menunggu Kasubbag Umum');
                        $kasumumPassed = in_array($pengajuan->status, ['Menunggu Sekdin', 'Menunggu Kadin', 'Menunggu Pemberkasan', 'Selesai']);
                    @endphp
                    <div class="relative flex items-start gap-4">
                        <div class="absolute -left-[22px] flex items-center justify-center w-5 h-5 rounded-full border-2 {{ $kasumumPassed ? 'bg-emerald-500 border-emerald-500 text-white' : ($kasumumActive ? 'bg-white border-amber-500 ring-4 ring-white' : 'bg-white border-slate-300') }} z-10 shadow">
                            @if($kasumumPassed)
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            @elseif($kasumumActive)
                                <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            @endif
                        </div>
                        <div class="flex-1 p-3 rounded-xl border {{ $kasumumPassed ? 'border-emerald-100 bg-emerald-50/30' : ($kasumumActive ? 'border-amber-200 bg-amber-50/50 shadow-sm ring-1 ring-amber-300' : 'border-slate-100 bg-slate-50/30') }}">
                            <h4 class="font-bold {{ $kasumumPassed ? 'text-emerald-800' : ($kasumumActive ? 'text-amber-800' : 'text-slate-400') }} text-xs">Kasubbag Umum</h4>
                            <p class="text-[10px] {{ $kasumumActive ? 'text-amber-600' : 'text-slate-400' }} font-medium">Verifikasi Dokumen</p>
                        </div>
                    </div>

                    {{-- 4. Sekretaris Dinas (Sekdin) --}}
                    @php
                        $sekdinActive = ($pengajuan->status === 'Menunggu Sekdin');
                        $sekdinPassed = in_array($pengajuan->status, ['Menunggu Kadin', 'Menunggu Pemberkasan', 'Selesai']);
                    @endphp
                    <div class="relative flex items-start gap-4">
                        <div class="absolute -left-[22px] flex items-center justify-center w-5 h-5 rounded-full border-2 {{ $sekdinPassed ? 'bg-emerald-500 border-emerald-500 text-white' : ($sekdinActive ? 'bg-white border-amber-500 ring-4 ring-white' : 'bg-white border-slate-300') }} z-10 shadow">
                            @if($sekdinPassed)
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            @elseif($sekdinActive)
                                <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            @endif
                        </div>
                        <div class="flex-1 p-3 rounded-xl border {{ $sekdinPassed ? 'border-emerald-100 bg-emerald-50/30' : ($sekdinActive ? 'border-amber-200 bg-amber-50/50 shadow-sm ring-1 ring-amber-300' : 'border-slate-100 bg-slate-50/30') }}">
                            <h4 class="font-bold {{ $sekdinPassed ? 'text-emerald-800' : ($sekdinActive ? 'text-amber-800' : 'text-slate-400') }} text-xs">Sekretaris Dinas</h4>
                            <p class="text-[10px] {{ $sekdinActive ? 'text-amber-600' : 'text-slate-400' }} font-medium">Persetujuan Tingkat II</p>
                        </div>
                    </div>

                    {{-- 5. Kepala Dinas (Kadin) --}}
                    @php
                        $kadinActive = ($pengajuan->status === 'Menunggu Kadin');
                        $kadinPassed = in_array($pengajuan->status, ['Menunggu Pemberkasan', 'Selesai']);
                    @endphp
                    <div class="relative flex items-start gap-4">
                        <div class="absolute -left-[22px] flex items-center justify-center w-5 h-5 rounded-full border-2 {{ $kadinPassed ? 'bg-emerald-500 border-emerald-500 text-white' : ($kadinActive ? 'bg-white border-amber-500 ring-4 ring-white' : 'bg-white border-slate-300') }} z-10 shadow">
                            @if($kadinPassed)
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            @elseif($kadinActive)
                                <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            @endif
                        </div>
                        <div class="flex-1 p-3 rounded-xl border {{ $kadinPassed ? 'border-emerald-100 bg-emerald-50/30' : ($kadinActive ? 'border-amber-200 bg-amber-50/50 shadow-sm ring-1 ring-amber-300' : 'border-slate-100 bg-slate-50/30') }}">
                            <h4 class="font-bold {{ $kadinPassed ? 'text-emerald-800' : ($kadinActive ? 'text-amber-800' : 'text-slate-400') }} text-xs">Kepala Dinas</h4>
                            <p class="text-[10px] {{ $kadinActive ? 'text-amber-600' : 'text-slate-400' }} font-medium">Keputusan Final Kedinasan</p>
                        </div>
                    </div>

                </div>

                {{-- Bagian Tombol Aksi Kontekstual --}}
                <div class="pt-6 border-t border-slate-100 mt-6">
                    @if($pengajuan->status === 'Menunggu Verifikasi Admin')
                        <form action="{{ route('admin.pengajuan.teruskan', $pengajuan->id) }}" method="POST">
                            @csrf
                            <p class="text-xs text-slate-500 mb-3 italic">Pastikan seluruh data dan kesesuaian lampiran telah valid sebelum dilempar ke Kasi.</p>
                            <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2 text-sm">
                                <span>Verifikasi & Teruskan ke Kasi &rarr;</span>
                            </button>
                        </form>
                    @elseif($pengajuan->status === 'Menunggu Pemberkasan')
                        <div class="bg-amber-50 p-4 rounded-xl border border-amber-200 text-center">
                            <p class="text-xs font-bold text-amber-800 uppercase tracking-wider">Tahap Berikutnya</p>
                            <p class="text-xs text-slate-600 mt-1">Berkas telah disetujui Kepala Dinas. Silakan lakukan penyelesaian berkas fisik pada menu <strong>Pemberkasan</strong>.</p>
                        </div>
                    @elseif($pengajuan->status === 'Selesai')
                        <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-200 text-center">
                            <p class="text-sm font-bold text-emerald-700">Dokumen Berhasil Diarsip & Disetujui Penuh.</p>
                            <p class="text-xs text-emerald-600/90 mt-1">Nomor SK telah terbit dan dokumen fisik siap diambil/dicetak oleh pegawai bersangkutan.</p>
                        </div>
                    @else
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-center">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Status Berkas Saat Ini</p>
                            <span class="inline-block mt-1.5 px-3 py-1 bg-white border border-slate-300 rounded-md text-xs font-extrabold text-slate-700 shadow-sm">
                                {{ $pengajuan->status }}
                            </span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-layouts.admin.app>