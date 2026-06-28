<x-layouts.kasumum.app>
    <x-slot:title>Detail & Tracking Riwayat Cuti - Kasubbag Umum</x-slot:title>

    <div class="py-12">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Tombol Kembali & Judul Manual (Sesuai dengan struktur layout kasumum) --}}
            <div class="mb-6">
                <a href="{{ route('kasumum.riwayat.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
                    &larr; Kembali ke Daftar Riwayat
                </a>
            </div>

            <div class="flex items-center gap-3 mb-8">
                <div>
                    <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                        Detail & Tracking Riwayat Cuti
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Melihat arsip detail data pengajuan beserta rekam jejak
                        persetujuan berkas.</p>
                </div>
            </div>

            {{-- Alert Error Validasi --}}
            @if ($errors->any())
            <div
                class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm font-medium shadow-sm">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan:
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 opacity-90">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- KONTEN SEBELAH KIRI (Ambil 2 Kolom) --}}
                <div class="md:col-span-2 space-y-6">

                    {{-- Informasi Pegawai --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center gap-2">
                            <i class="fas fa-user-circle text-lime-500"></i> Informasi Pegawai
                        </h3>

                        <div class="flex items-center gap-5 mb-5 border-b border-slate-100 pb-5">
                            {{-- Container Foto Profil --}}
                            <div
                                class="w-16 h-16 rounded-full overflow-hidden bg-slate-100 shrink-0 border-2 border-white shadow-sm">
                                @if($pengajuan->user->pegawai && $pengajuan->user->pegawai->foto_profil)
                                <img src="{{ asset('storage/' . $pengajuan->user->pegawai->foto_profil) }}"
                                    alt="Foto Profil" class="w-full h-full object-cover">
                                @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($pengajuan->user->nama ?? 'User') }}&background=E2E8F0&color=475569"
                                    alt="Default Profil" class="w-full h-full object-cover">
                                @endif
                            </div>

                            {{-- Info Utama --}}
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">{{ $pengajuan->user->nama ?? '-' }}</h4>
                                <p class="text-sm text-slate-500 font-medium">NIP. {{ $pengajuan->user->pegawai->nip ??
                                    $pengajuan->user->nip ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- Info Tambahan Bidang & Jabatan --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Bidang</p>
                                <p class="font-medium text-slate-800">{{ $pengajuan->user->pegawai->bidang->nama_bidang
                                    ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Jabatan
                                </p>
                                <p class="font-medium text-slate-800">{{ $pengajuan->user->pegawai->jabatan ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Pengajuan Cuti --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-file-alt text-lime-500"></i> Detail Pengajuan Cuti
                        </h3>

                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 mb-5">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-slate-600">Jenis Cuti</span>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 font-bold rounded-lg text-sm">
                                    {{ $pengajuan->jenisCuti->nama ?? $pengajuan->jenisCuti->nama ?? '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-slate-600">Tanggal Pelaksanaan</span>
                                <span class="font-medium text-slate-800 text-sm">
                                    {{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->translatedFormat('d M Y') }} s/d
                                    {{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->translatedFormat('d M Y') }}
                                    <span class="text-indigo-600 font-semibold">({{ $pengajuan->lama_cuti }} Hari
                                        Kerja)</span>
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5 border-b border-slate-100 pb-5 text-sm">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">No.
                                    WhatsApp / Telepon</p>
                                <p class="font-medium text-slate-800 flex items-center gap-1">
                                    <i class="fab fa-whatsapp text-emerald-500 text-base"></i>
                                    {{ $pengajuan->no_telepon ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Alamat
                                    Selama Cuti</p>
                                <p class="font-medium text-slate-800">{{ $pengajuan->alamat_cuti ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="mb-4 text-sm">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Alasan Cuti
                            </p>
                            <p class="text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200 italic">
                                "{{ $pengajuan->alasan ?? 'Tidak ada alasan yang dicantumkan.' }}"
                            </p>
                        </div>

                        @if($pengajuan->file_bukti)
                        <div class="mt-4">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-2">Dokumen
                                Lampiran</p>
                            <a href="{{ asset('storage/' . $pengajuan->file_bukti) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors border border-slate-200">
                                <i class="fas fa-paperclip text-slate-500"></i> Lihat Lampiran Bukti
                            </a>
                        </div>
                        @endif
                    </div>

                    <div
                        class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm transition-all hover:shadow-md">

                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-slate-800">
                                <i class="fas fa-tasks text-emerald-500 mr-2"></i>
                                Status Verifikasi Tanda Tangan
                            </h3>

                            <span class="text-xs text-slate-400 font-semibold uppercase">
                                Tracking Approval
                            </span>
                        </div>

                        {{-- ====================== PEGAWAI ====================== --}}
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-5 border-b border-slate-200">
                            <div class="flex items-center gap-4">
                                <div class="relative flex items-center justify-center w-10 h-10">
                                    <div class="absolute w-10 h-10 rounded-full bg-emerald-500 blur-md opacity-50">
                                    </div>
                                    <div
                                        class="relative w-5 h-5 rounded-full bg-emerald-400 border-2 border-white shadow-lg shadow-emerald-500">
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-800">
                                        {{ !empty($pengajuan->ttd_pegawai) ? 'Tanda Tangan Pegawai Valid' : 'Menunggu
                                        Tanda Tangan Pegawai' }}
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-1">
                                        Diajukan : {{ $pengajuan->created_at ?
                                        \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d M Y H:i') . '
                                        WIB' : '-' }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-center mt-4 sm:mt-0">
                                <span class="text-[10px] font-bold uppercase text-slate-400">Spesimen TTD</span>
                                <div class="mt-2">
                                    @if(!empty($pengajuan->ttd_pegawai))
                                    <img src="{{ asset('storage/' . $pengajuan->ttd_pegawai) }}"
                                        class="h-24 object-contain mix-blend-multiply">
                                    @else
                                    <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- KONDISI CHECK: Hanya tampilkan TTD Kasi jika pengaju BUKAN merupakan seorang Kasi --}}
                        @if(($pengajuan->user->role ?? '') !== 'kasi')

                        {{-- ====================== KASI ====================== --}}
                        <div class="py-5 border-b border-slate-200">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div class="flex items-center gap-4">
                                    <div class="relative flex items-center justify-center w-10 h-10">
                                        <div class="absolute w-10 h-10 rounded-full bg-emerald-500 blur-md opacity-50">
                                        </div>
                                        <div
                                            class="relative w-5 h-5 rounded-full bg-emerald-400 border-2 border-white shadow-lg shadow-emerald-500">
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-800">
                                            {{ !empty($pengajuan->ttd_kasi) ? 'Tanda Tangan Kasi Valid' : 'Menunggu
                                            Tanda Tangan Kasi' }}
                                        </h4>
                                        <p class="text-xs text-slate-500 mt-1">
                                            Disetujui : {{ $pengajuan->tgl_ttd_kasi ?
                                            \Carbon\Carbon::parse($pengajuan->tgl_ttd_kasi)->translatedFormat('d M Y
                                            H:i') . ' WIB' : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="text-center mt-4 sm:mt-0">
                                    <span class="text-[10px] font-bold uppercase text-slate-400">Spesimen TTD</span>
                                    <div class="mt-2">
                                        @if(!empty($pengajuan->ttd_kasi))
                                        <img src="{{ asset('storage/' . $pengajuan->ttd_kasi) }}"
                                            class="h-24 object-contain mix-blend-multiply">
                                        @else
                                        <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($pengajuan->catatan_kasi)
                            <div class="mt-4 ml-14 bg-slate-50 border border-slate-200 rounded-xl p-3">
                                <p class="text-xs font-bold text-slate-500 mb-1">
                                    <i class="fas fa-comment-alt mr-1"></i> Catatan Kasi
                                </p>
                                <p class="text-sm text-slate-700 leading-relaxed break-words">
                                    {{ $pengajuan->catatan_kasi }}
                                </p>
                            </div>
                            @endif
                        </div>

                        @endif

                        {{-- ====================== KABID ====================== --}}
                        <div class="py-5">

                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">

                                <div class="flex items-center gap-4">

                                    <div class="relative flex items-center justify-center w-10 h-10">
                                        <div class="absolute w-10 h-10 rounded-full bg-emerald-500 blur-md opacity-50">
                                        </div>
                                        <div
                                            class="relative w-5 h-5 rounded-full bg-emerald-400 border-2 border-white shadow-lg shadow-emerald-500">
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-800">
                                            {{ !empty($pengajuan->ttd_kabid) ? 'Tanda Tangan Kabid Valid' : 'Menunggu
                                            Tanda Tangan Kabid' }}
                                        </h4>

                                        <p class="text-xs text-slate-500 mt-1">
                                            Disetujui :
                                            {{ $pengajuan->tgl_ttd_kabid ?
                                            \Carbon\Carbon::parse($pengajuan->tgl_ttd_kabid)->translatedFormat('d M Y
                                            H:i') . ' WIB' : '-' }}
                                        </p>
                                    </div>

                                </div>

                                <div class="text-center mt-4 sm:mt-0">
                                    <span class="text-[10px] font-bold uppercase text-slate-400">
                                        Spesimen TTD
                                    </span>

                                    <div class="mt-2">
                                        @if(!empty($pengajuan->ttd_kabid))
                                        <img src="{{ asset('storage/' . $pengajuan->ttd_kabid) }}"
                                            class="h-24 object-contain mix-blend-multiply">
                                        @else
                                        <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($pengajuan->catatan_kabid)
                            <div class="mt-4 ml-14 bg-slate-50 border border-slate-200 rounded-xl p-3">
                                <p class="text-xs font-bold text-slate-500 mb-1">
                                    <i class="fas fa-comment-alt mr-1"></i>
                                    Catatan Kabid
                                </p>

                                <p class="text-sm text-slate-700 leading-relaxed break-words">
                                    {{ $pengajuan->catatan_kabid }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- KONTEN SEBELAH KANAN (Panel Tracking Status Terproses) --}}
                <div class="space-y-6">
                    <div class="bg-slate-900 rounded-2xl p-6 shadow-md text-white border border-slate-800">
                        <h3
                            class="text-lg font-bold text-white mb-2 border-b border-slate-800 pb-3 flex items-center gap-2">
                            <i class="fas fa-stream text-lime-400"></i> Status Alur Berkas
                        </h3>

                        {{-- Badge Posisi Berkas Global --}}
                        <div class="mb-6 mt-2">
                            <label
                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Posisi
                                Terkini</label>
                            @if($pengajuan->status == 'Disetujui')
                            <div
                                class="px-4 py-3 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl text-xs font-bold text-center uppercase tracking-wider">
                                🎉 Disetujui (Selesai/Final)
                            </div>
                            @elseif($pengajuan->status == 'Ditolak')
                            <div
                                class="px-4 py-3 bg-rose-500/10 border border-rose-500/30 text-rose-400 rounded-xl text-xs font-bold text-center uppercase tracking-wider">
                                ❌ Pengajuan Ditolak
                            </div>
                            @else
                            <div
                                class="px-4 py-3 bg-amber-500/10 border border-amber-500/30 text-amber-400 rounded-xl text-xs font-bold text-center animate-pulse uppercase tracking-wider">
                                ⏳ {{ $pengajuan->status }}
                            </div>
                            @endif
                        </div>

                        {{-- Riwayat Tindakan Akun Kasubbag Umum Ini --}}
                        <div class="border-t border-slate-800 pt-4 space-y-4">
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tindakan
                                    Anda (Kasubbag Umum)</label>
                                <div class="flex items-center gap-2 text-xs text-emerald-400 font-bold">
                                    <i class="fas fa-signature text-sm"></i>
                                    Telah Ditandatangani Digital
                                </div>
                                <span class="text-[11px] text-slate-500 block mt-1 font-mono">
                                    Pada: {{ $pengajuan->tgl_ttd_kasubbag_umum ?
                                    \Carbon\Carbon::parse($pengajuan->tgl_ttd_kasubbag_umum)->translatedFormat('d M Y,
                                    H:i') . ' WIB' : '-' }}
                                </span>
                            </div>

                            {{-- Tampilan Catatan Internal Kasubbag Umum --}}
                            @if($pengajuan->catatan_kasubbag)
                            <div class="bg-slate-800/50 rounded-xl p-3 border border-slate-800 text-xs">
                                <span class="block font-bold text-slate-400 mb-1"><i
                                        class="fas fa-comment-alt text-[10px]"></i> Catatan Anda:</span>
                                <p class="text-slate-300 italic">"{{ $pengajuan->catatan_kasubbag }}"</p>
                            </div>
                            @endif

                            {{-- QR Code TTD Kasubbag Umum --}}
                            <div class="border-t border-slate-800/80 pt-4 flex flex-col items-center justify-center">
                                <span
                                    class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500 block mb-2">Spesimen
                                    TTD Anda (QR Kasubbag)</span>
                                <div
                                    class="flex items-center gap-3 relative p-2 bg-white rounded-xl shadow-inner min-h-[65px] w-full justify-center">
                                    @if(!empty($pengajuan->ttd_kasubbag))
                                    <img src="{{ asset('storage/' . $pengajuan->ttd_kasubbag) }}"
                                        alt="Tanda Tangan QR Kasubbag" class="h-35 w-35 object-contain max-w-[140px]">
                                    @else
                                    <span class="text-[10px] text-slate-400 italic">(QR TTD Belum Tergenerate)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.kasumum.app>