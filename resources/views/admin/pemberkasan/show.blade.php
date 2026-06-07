<x-layouts.admin.app>
    <!-- Header Page & Tombol Kembali -->
    <div class="mb-6 flex items-center justify-between no-print">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Pemberkasan Surat Cuti</h2>
            <p class="text-slate-500 text-sm">Formulir BKN otomatis selesai di-generate. Rilis dokumen agar dapat dicetak oleh pegawai.</p>
        </div>
        <a href="{{ route('admin.pemberkasan.index') }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-lg hover:bg-slate-50 transition shadow-sm text-sm">
            &larr; Kembali
        </a>
    </div>

    {{-- Kondisi 1: JIKA STATUS BELUM SELESAI (Tampilkan Tombol Simpan & Rilis) --}}
    @if($pengajuan->status !== 'Selesai')
    <div class="mb-6 p-6 bg-white rounded-2xl border border-amber-200 shadow-sm bg-gradient-to-r from-amber-50/40 to-transparent no-print">
        <h3 class="font-bold text-amber-800 text-base mb-2 flex items-center gap-2">
            Finalisasi & Rilis Dokumen
        </h3>
        <p class="text-sm text-slate-600 mb-4">
            Seluruh draf penilaian birokrasi dan tanda tangan kedinasan telah terisi otomatis di bawah. Klik tombol di bawah untuk merilis dokumen ini ke akun pegawai dan mengubah status menjadi <strong>Selesai</strong>.
        </p>
        
        <form action="{{ route('admin.pemberkasan.proses', $pengajuan->id) }}" method="POST">
            @csrf
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition text-sm flex items-center gap-2">
                Simpan & Rilis ke Pegawai
            </button>
        </form>
    </div>
    
    {{-- Kondisi 2: JIKA STATUS SUDAH SELESAI (Tampilkan Tombol Cetak) --}}
    @else
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between no-print">
        <div class="text-sm">
            <strong>Status Selesai:</strong> Surat cuti ini telah difinalisasi dan dirilis. Pegawai saat ini sudah dapat melihat dan mencetak dokumen ini secara mandiri melalui berkas mereka.
        </div>
        <button onclick="window.print()" class="px-5 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-lg hover:bg-slate-800 transition flex items-center gap-1.5 shadow-md">
            Cetak Formulir Cuti
        </button>
    </div>
    @endif

    {{-- ========================================================================= --}}
    {{-- KANVAS PREVIEW FORMULIR BKN (MENYERUPAI KERTAS DOKUMEN ASLI) --}}
    {{-- ========================================================================= --}}
    <div class="bg-white p-8 md:p-12 shadow-sm border border-slate-200 rounded-2xl mx-auto print:shadow-none print:border-none print:p-0 font-serif text-[11px] text-black leading-relaxed max-w-[800px] antialiased">
        
        <!-- Header Dokumen Lampiran BKN -->
        <div class="flex justify-end mb-4 text-right font-sans text-[9px] tracking-tight uppercase">
            <div>
                <p class="font-bold">Anak Lampiran 1.b</p>
                <p>Peraturan Badan Kepegawaian Negara</p>
                <p>Republik Indonesia</p>
                <p>Nomor 24 Tahun 2017</p>
                <p>Tentang Tata Cara Pemberian Cuti Pegawai Negeri Sipil</p>
            </div>
        </div>

        <!-- Tujuan Surat -->
        <div class="flex justify-end mb-4 font-sans text-[10px]">
            <div class="w-1/2 text-left space-y-0.5">
                <p>Palembang, {{ \Carbon\Carbon::parse($pengajuan->updated_at)->translatedFormat('d F Y') }}</p>
                <p>Kepada Yth.</p>
                <p class="font-bold">Kepala Dinas Energi dan Sumber Daya Mineral</p>
                <p>Provinsi Sumatera Selatan</p>
                <p>di - Palembang</p>
            </div>
        </div>

        <h1 class="text-center font-bold text-xs tracking-wide mb-4 uppercase font-sans">
            Formulir Permintaan dan Pemberian Cuti
        </h1>

        <!-- I. DATA PEGAWAI -->
        <table class="w-full border-collapse border border-black mb-2 text-[10px]">
            <tr class="bg-slate-100 font-sans font-bold text-[9px]">
                <td colspan="4" class="border border-black px-2 py-0.5">I. DATA PEGAWAI</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5 w-24">1. Nama</td>
                <td class="border border-black px-2 py-0.5 w-1/3 font-sans font-bold uppercase">{{ $pengajuan->user->nama ?? '-' }}</td>
                <td class="border border-black px-2 py-0.5 w-24">2. NIP</td>
                <td class="border border-black px-2 py-0.5 font-mono">{{ $pengajuan->user->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5">3. Jabatan</td>
                <td class="border border-black px-2 py-0.5">{{ $pengajuan->user->pegawai->jabatan ?? '-' }}</td>
                <td class="border border-black px-2 py-0.5">4. Masa Kerja</td>
                <td class="border border-black px-2 py-0.5 font-sans font-bold">
                    @if(!empty($pengajuan->user->pegawai->tmt_kerja))
                        {{ floor(\Carbon\Carbon::parse($pengajuan->user->pegawai->tmt_kerja)->diffInYears(\Carbon\Carbon::now())) }} Tahun
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5">5. Unit Kerja</td>
                <td colspan="3" class="border border-black px-2 py-0.5">Dinas Energi dan Sumber Daya Mineral Provinsi Sumatera Selatan</td>
            </tr>
        </table>

        <!-- II. JENIS CUTI YANG DIAMBIL -->
        <table class="w-full border-collapse border border-black mb-2 text-center text-[10px]">
            <tr class="bg-slate-100 font-sans font-bold text-left text-[9px]">
                <td colspan="4" class="border border-black px-2 py-0.5">II. JENIS CUTI YANG DIAMBIL**</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5 text-left w-2/5">1. Cuti Tahunan</td>
                <td class="border border-black px-2 py-0.5 w-12 font-bold text-xs">{{ $pengajuan->jenis_cuti_id == 1 ? '✓' : '' }}</td>
                <td class="border border-black px-2 py-0.5 text-left w-2/5">2. Cuti Besar</td>
                <td class="border border-black px-2 py-0.5 w-12 font-bold text-xs">{{ $pengajuan->jenis_cuti_id == 2 ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5 text-left">3. Cuti Sakit</td>
                <td class="border border-black px-2 py-0.5 font-bold text-xs">{{ $pengajuan->jenis_cuti_id == 3 ? '✓' : '' }}</td>
                <td class="border border-black px-2 py-0.5 text-left">4. Cuti Melahirkan</td>
                <td class="border border-black px-2 py-0.5 font-bold text-xs">{{ $pengajuan->jenis_cuti_id == 4 ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5 text-left">5. Cuti Karena Alasan Penting</td>
                <td class="border border-black px-2 py-0.5 font-bold text-xs">{{ $pengajuan->jenis_cuti_id == 5 ? '✓' : '' }}</td>
                <td class="border border-black px-2 py-0.5 text-left">6. Cuti di Luar Tanggungan Negara</td>
                <td class="border border-black px-2 py-0.5 font-bold text-xs">{{ $pengajuan->jenis_cuti_id == 6 ? '✓' : '' }}</td>
            </tr>
        </table>

        <!-- III. ALASAN CUTI -->
        <table class="w-full border-collapse border border-black mb-2 text-[10px]">
            <tr class="bg-slate-100 font-sans font-bold text-[9px]">
                <td class="border border-black px-2 py-0.5">III. ALASAN CUTI</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-2 italic text-slate-800">{{ $pengajuan->alasan }}</td>
            </tr>
        </table>

        <!-- IV. LAMANYA CUTI -->
        <table class="w-full border-collapse border border-black mb-2 text-[10px]">
            <tr class="bg-slate-100 font-sans font-bold text-[9px]">
                <td colspan="6" class="border border-black px-2 py-0.5">IV. LAMANYA CUTI</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5 w-16">Selama</td>
                <td class="border border-black px-2 py-0.5 font-bold w-32 text-center bg-slate-50">{{ $pengajuan->lama_cuti }} Hari Kerja</td>
                <td class="border border-black px-2 py-0.5 w-24 text-center">Mulai Tanggal</td>
                <td class="border border-black px-2 py-0.5 text-center font-sans font-semibold">{{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->translatedFormat('d F Y') }}</td>
                <td class="border border-black px-2 py-0.5 w-8 text-center">s/d</td>
                <td class="border border-black px-2 py-0.5 text-center font-sans font-semibold">{{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->translatedFormat('d F Y') }}</td>
            </tr>
        </table>

        <!-- V. CATATAN CUTI & PARAF VALIDASI BIROKRASI -->
        <table class="w-full border-collapse border border-black mb-2 text-[9px]">
            <tr class="bg-slate-100 font-sans font-bold">
                <td colspan="5" class="border border-black px-2 py-0.5">V. CATATAN CUTI***</td>
            </tr>
            <tr class="font-sans font-semibold text-center">
                <td colspan="3" class="border border-black px-2 py-0.5 w-1/2 bg-slate-50/50">1. DETAIL KUOTA CUTI TAHUNAN</td>
                <td colspan="2" class="border border-black px-2 py-0.5 text-left bg-slate-50/50">2. PARAF VALIDASI KASUBBAG UMUM & KASI</td>
            </tr>
            <tr class="text-center text-[8px]">
                <td class="border border-black px-1 py-0.5 w-12">Tahun</td>
                <td class="border border-black px-1 py-0.5 w-12">Sisa Kuota</td>
                <td class="border border-black px-1 py-0.5">Keterangan Administrasi</td>
                <td class="border border-black px-2 py-0.5 text-left" valign="top">
                    <strong>Kasubbag Umum & Kasi:</strong><br>
                    <span class="text-[7px] text-slate-500 block">Catatan: {{ $pengajuan->catatan_kasubbag ?? '-' }}</span>
                    {{-- TTD DIGITAL KASUBBAG --}}
                    @if($pengajuan->ttd_kasubbag)
                    <div class="my-1 flex justify-start">
                        <img src="{{ asset('storage/' . $pengajuan->ttd_kasubbag) }}" class="h-8 object-contain mix-blend-multiply" alt="TTD Kasubbag">
                    </div>
                    @endif
                </td>
                <td class="border border-black px-2 py-0.5 text-left" valign="top">
                    <strong>Kasi Check:</strong><br>
                    <span class="text-[7px] text-slate-500 block">{{ $pengajuan->catatan_kasi ?? '-' }}</span>
                    {{-- TTD DIGITAL KASI --}}
                    @if($pengajuan->ttd_kasi)
                    <div class="my-1 flex justify-start">
                        <img src="{{ asset('storage/' . $pengajuan->ttd_kasi) }}" class="h-8 object-contain mix-blend-multiply" alt="TTD Kasi">
                    </div>
                    @endif
                </td>
            </tr>
            <tr class="text-center">
                <td>N-2 (2024)</td>
                <td class="border-l border-r border-black font-bold text-slate-500">0 Hari</td>
                <td class="border-r border-black text-left px-2 text-[8px] text-slate-400">Hangus (Sistem)</td>
                <td colspan="2" class="border-t border-black bg-slate-50/30 text-left px-2 font-sans text-[8px]">
                    <strong>3. CATATAN PERTIMBANGAN SEKRETARIS DINAS (SEKDIN):</strong><br>
                    <span class="italic text-slate-700">"{{ $pengajuan->catatan_sekdin ?? 'Disetujui untuk diteruskan.' }}"</span>
                    {{-- TTD DIGITAL SEKDIN --}}
                    @if($pengajuan->ttd_sekdin)
                    <div class="my-1 flex justify-end">
                        <img src="{{ asset('storage/' . $pengajuan->ttd_sekdin) }}" class="h-8 object-contain mix-blend-multiply" alt="TTD Sekdin">
                    </div>
                    @endif
                </td>
            </tr>
            <tr class="text-center">
                <td class="border-t border-black">N-1 (2025)</td>
                <td class="border border-black font-bold text-slate-500">0 Hari</td>
                <td class="border-t border-black text-left px-2 text-[8px]">Tidak Ada Sisa</td>
                <td colspan="2" class="border-t border-black text-right px-2 font-sans text-[8px]">
                    <span class="font-bold underline block">SEKRETARIS DINAS</span>
                    <span class="text-[7px] text-slate-400 block">Tanggal TTD: {{ $pengajuan->tgl_ttd_sekdin ? \Carbon\Carbon::parse($pengajuan->tgl_ttd_sekdin)->translatedFormat('d/m/Y') : '-' }}</span>
                </td>
            </tr>
            <tr class="text-center font-bold">
                <td class="border-t border-black">N (2026)</td>
                <td class="border border-black text-blue-600">{{ $pengajuan->user->pegawai->sisa_cuti_tahun_ini ?? 12 }} Hari</td>
                <td class="border-t border-black font-normal text-left px-2 text-[8px]">Diambil Sesuai SK: {{ $pengajuan->lama_cuti }} Hari</td>
                <td colspan="2" class="border-t border-black bg-slate-50/50 text-left px-2 font-sans text-[8px]">
                    <strong>Admin Verifikator:</strong> <span class="text-slate-600">{{ $pengajuan->catatan_admin ?? 'Berkas Valid' }}</span>
                </td>
            </tr>
        </table>

        <!-- VI. ALAMAT SELAMA MENJALANKAN CUTI (TTD PEGAWAI ASLI) -->
        <table class="w-full border-collapse border border-black mb-2 text-[10px]">
            <tr class="bg-slate-100 font-sans font-bold text-[9px]">
                <td colspan="2" class="border border-black px-2 py-1">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
            </tr>
            <tr>
                <td class="border border-black px-3 py-3 w-3/5 align-top italic">
                    {{ $pengajuan->alamat_cuti }}
                </td>
                <td class="border border-black px-3 py-2 w-2/5 align-top">
                    <div class="flex flex-col justify-between h-full space-y-2">
                        <div>
                            <span class="font-bold">TELP/HP:</span> {{ $pengajuan->no_telepon }}
                        </div>
                        <div class="text-center font-sans text-[9px]">
                            <p class="mb-1">Hormat saya,</p>
                            
                            {{-- TTD DIGITAL PEGAWAI DARI DATA TABEL PENGAJUAN --}}
                            <div class="flex justify-center my-1">
                                @if($pengajuan->ttd_pegawai)
                                    <img src="{{ asset('storage/' . $pengajuan->ttd_pegawai) }}" class="h-10 object-contain mix-blend-multiply" alt="TTD Pegawai">
                                @else
                                    <div class="h-10 flex items-center justify-center text-[8px] text-slate-400 italic">[Belum TTD]</div>
                                @endif
                            </div>

                            <p class="font-bold underline uppercase">{{ $pengajuan->user->nama ?? '-' }}</p>
                            <p class="text-[8px] font-mono">NIP. {{ $pengajuan->user->nip ?? '-' }}</p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- VII. PERTIMBANGAN ATASAN LANGSUNG (KABID) -->
        <table class="w-full border-collapse border border-black mb-2 text-[10px]">
            <tr class="bg-slate-100 font-sans font-bold text-[9px]">
                <td colspan="4" class="border border-black px-2 py-0.5">VII. PERTIMBANGAN ATASAN LANGSUNG (KABID)**</td>
            </tr>
            <tr class="text-center font-sans font-semibold text-[9px]">
                <td class="border border-black px-2 py-0.5 w-1/4 bg-slate-50 font-bold text-slate-900">✓ DISETUJUI</td>
                <td class="border border-black px-2 py-0.5 w-1/4 text-slate-300">PERUBAHAN****</td>
                <td class="border border-black px-2 py-0.5 w-1/4 text-slate-300">DITANGGUHKAN****</td>
                <td class="border border-black px-2 py-0.5 w-1/4 text-slate-300">TIDAK DISETUJUI****</td>
            </tr>
            <tr>
                <td colspan="4" class="border border-black p-3 flex justify-between items-center">
                    <div class="text-left font-sans text-[8px] text-slate-600 max-w-md italic">
                        "Catatan Kabid: {{ $pengajuan->catatan_kabid ?? 'Tidak ada catatan tambahan.' }}"
                    </div>
                    <div class="text-center font-sans w-64 text-[9px]">
                        <p class="text-[8px] text-emerald-700 italic mb-1">✓ Ditandatangani Elektronik</p>
                        
                        {{-- TTD DIGITAL KABID --}}
                        <div class="flex justify-center my-1">
                            @if($pengajuan->ttd_kabid)
                                <img src="{{ asset('storage/' . $pengajuan->ttd_kabid) }}" class="h-10 object-contain mix-blend-multiply" alt="TTD Kabid">
                            @else
                                <div class="h-10 flex items-center justify-center text-[8px] text-slate-400 italic">[Belum TTD Kabid]</div>
                            @endif
                        </div>

                        <p class="font-bold underline uppercase">SUPERVISOR / KABID</p>
                        <span class="text-[7px] text-slate-400 block">Tanggal: {{ $pengajuan->tgl_ttd_kabid ? \Carbon\Carbon::parse($pengajuan->tgl_ttd_kabid)->translatedFormat('d/m/Y') : '-' }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <!-- VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI (KEPALA DINAS) -->
        <table class="w-full border-collapse border border-black text-[10px]">
            <tr class="bg-slate-100 font-sans font-bold text-[9px]">
                <td colspan="4" class="border border-black px-2 py-0.5">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI (KEPALA DINAS)**</td>
            </tr>
            <tr class="text-center font-sans font-semibold text-[9px]">
                <td class="border border-black px-2 py-0.5 w-1/4 bg-slate-50 font-bold text-slate-900">✓ DISETUJUI</td>
                <td class="border border-black px-2 py-0.5 w-1/4 text-slate-300">PERUBAHAN****</td>
                <td class="border border-black px-2 py-0.5 w-1/4 text-slate-300">DITANGGUHKAN****</td>
                <td class="border border-black px-2 py-0.5 w-1/4 text-slate-300">TIDAK DISETUJUI****</td>
            </tr>
            <tr>
                <td colspan="4" class="border border-black p-3 flex justify-between items-center">
                    <div class="text-left font-sans text-[8px] text-slate-600 max-w-md italic">
                        "Catatan Kadin: {{ $pengajuan->catatan_kadin ?? 'Disetujui sepenuhnya.' }}"
                    </div>
                    <div class="text-center font-sans w-64 text-[9px]">
                        <p class="text-[8px] text-emerald-700 italic mb-1">✓ Disahakan & Disetujui Kadin</p>
                        
                        {{-- TTD DIGITAL KEPALA DINAS (KADIN) --}}
                        <div class="flex justify-center my-1">
                            @if($pengajuan->ttd_kadin)
                                <img src="{{ asset('storage/' . $pengajuan->ttd_kadin) }}" class="h-10 object-contain mix-blend-multiply" alt="TTD Kadin">
                            @else
                                <div class="h-10 flex items-center justify-center text-[8px] text-slate-400 italic">[Belum TTD Kadin]</div>
                            @endif
                        </div>

                        <p class="font-bold underline uppercase">KEPALA DINAS ESDM PROV. SUMSEL</p>
                        <span class="text-[7px] text-slate-400 block">Tanggal: {{ $pengajuan->tgl_ttd_kadin ? \Carbon\Carbon::parse($pengajuan->tgl_ttd_kadin)->translatedFormat('d/m/Y') : '-' }}</span>
                    </div>
                </td>
            </tr>
        </table>

    </div>

    {{-- CSS Kustom Khusus Mode Cetak (Print) --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .no-print {
                display: none !important;
            }
            .print\:shadow-none {
                box-shadow: none !important;
            }
            .print\:border-none {
                border: none !important;
            }
            .print\:p-0 {
                padding: 0 !important;
            }
            div.font-serif, div.font-serif * {
                visibility: visible;
            }
            div.font-serif {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</x-layouts.admin.app>