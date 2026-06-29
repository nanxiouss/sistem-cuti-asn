<x-layouts.kasi.app>
    <div class="mb-6 flex items-center justify-between no-print">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Cetak Formulir Cuti</h2>
            <p class="text-slate-500 text-sm">Pratinjau formulir BKN Anda. Pastikan kertas pada printer diatur ke ukuran F4/Folio.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.close()" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-lg hover:bg-slate-50 transition shadow-sm text-sm">
                Tutup
            </button>
            <button onclick="window.print()" class="px-5 py-2 bg-slate-900 text-white text-sm font-bold rounded-lg hover:bg-slate-800 transition flex items-center gap-1.5 shadow-md">
                <i class="fas fa-print"></i> Print Sekarang (F4)
            </button>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- KANVAS PREVIEW FORMULIR BKN (KHUSUS KASI SEBAGAI PEMOHON) --}}
    {{-- ========================================================================= --}}
    <div class="bg-white p-6 md:p-8 shadow-sm border border-slate-200 mx-auto print:shadow-none print:border-none print:p-0 font-sans text-black leading-snug max-w-[800px] antialiased text-[11px]">

        <div class="flex items-center justify-center border-b-[3px] border-black pb-2 mb-2">
            <div class="w-16">
                {{-- Ganti src ini dengan logo Pemprov Sumsel yang Anda miliki --}}
                <img src="{{ asset('images/logosumsel.png') }}" alt="Logo Sumsel" class="w-14 h-auto opacity-80 mix-blend-multiply">
            </div>
            <div class="text-center flex-1 px-4">
                <h1 class="text-[13px] font-bold tracking-wide uppercase">PEMERINTAH PROVINSI SUMATERA SELATAN</h1>
                <h2 class="text-[15px] font-extrabold uppercase mt-0.5">DINAS ENERGI DAN SUMBER DAYA MINERAL</h2>
                <p class="text-[9px] mt-0.5">Jalan Angkatan 45 Nomor 2440 Palembang Provinsi Sumatera Selatan</p>
                <p class="text-[9px]">Telepon (0711) 379040 Pos-el : desdm.sumselprov@gmail.com</p>
                <p class="text-[9px]">Laman : www.desdm.sumselprov.go.id</p>
            </div>
            <div class="w-16"></div>
        </div>

        <div class="flex justify-end mb-2">
            <div class="w-1/2 text-right pr-4">
                <p>Palembang, {{ \Carbon\Carbon::parse($pengajuan->updated_at)->translatedFormat('d F Y') }}</p>
            </div>
        </div>
        <div class="mb-2 space-y-0 w-1/2 text-[10px]">
            <p>Yth. Kepala Dinas Energi dan Sumber Daya Mineral</p>
            <p>Provinsi Sumatera Selatan</p>
            <p>di-</p>
            <p class="pl-4">Palembang</p>
        </div>

        <div class="text-center mb-2">
            <h3 class="font-bold text-[11px] underline uppercase">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</h3>
            <p class="text-[10px]">Nomor : 800.1.11.4 / &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / DESDM / {{ \Carbon\Carbon::now()->year }}</p>
        </div>

        <table class="w-full border-collapse border border-black mb-1">
            <tr>
                <td colspan="4" class="border border-black px-1.5 py-0.5 bg-slate-100 font-bold text-[10px]">I. DATA PEGAWAI</td>
            </tr>
            <tr class="text-[10px]">
                <td class="border border-black px-1.5 py-0.5 w-[15%]">Nama</td>
                <td class="border border-black px-1.5 py-0.5 w-[35%]">{{ $pengajuan->user->nama ?? '-' }}</td>
                <td class="border border-black px-1.5 py-0.5 w-[15%]">NIP</td>
                <td class="border border-black px-1.5 py-0.5 w-[35%]">{{ $pengajuan->user->pegawai->nip ?? $pengajuan->user->nip ?? '-' }}</td>
            </tr>
            <tr class="text-[10px]">
                <td class="border border-black px-1.5 py-0.5">Jabatan</td>
                <td class="border border-black px-1.5 py-0.5">{{ $pengajuan->jabatan_pegawai ?? $pengajuan->user->pegawai->jabatan ?? '-' }}</td>
                <td class="border border-black px-1.5 py-0.5">Masa Kerja</td>
                <td class="border border-black px-1.5 py-0.5">
                    @if (!empty($pengajuan->user->pegawai->masa_kerja))
                        @php
                            $masaKerja = \Carbon\Carbon::parse($pengajuan->user->pegawai->masa_kerja);
                            $diff = $masaKerja->diff(now());
                            $hasil = [];
                            if ($diff->y > 0) $hasil[] = $diff->y . ' Tahun';
                            if ($diff->m > 0) $hasil[] = $diff->m . ' Bulan';
                            if (empty($hasil)) $hasil[] = '0 Bulan';
                        @endphp
                        {{ implode(' ', $hasil) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr class="text-[10px]">
                <td class="border border-black px-1.5 py-0.5">Unit Kerja</td>
                <td colspan="3" class="border border-black px-1.5 py-0.5">Dinas Energi dan Sumber Daya Mineral Prov. Sumsel</td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1 text-[10px]">
            <tr>
                <td colspan="4" class="border border-black px-1.5 py-0.5 bg-slate-100 font-bold">II. JENIS CUTI YANG DIAMBIL **</td>
            </tr>
            <tr>
                <td class="border border-black px-1.5 py-0.5 w-[40%]">1. Cuti Tahunan</td>
                <td class="border border-black px-1.5 py-0.5 text-center w-[10%] font-bold">{{ $pengajuan->jenis_cuti_id == 1 ? '√' : '' }}</td>
                <td class="border border-black px-1.5 py-0.5 w-[40%]">4. Cuti Melahirkan</td>
                <td class="border border-black px-1.5 py-0.5 text-center w-[10%] font-bold">{{ $pengajuan->jenis_cuti_id == 4 ? '√' : '' }}</td>
            </tr>
            <tr>
                <td class="border border-black px-1.5 py-0.5">2. Cuti Besar</td>
                <td class="border border-black px-1.5 py-0.5 text-center font-bold">{{ $pengajuan->jenis_cuti_id == 2 ? '√' : '' }}</td>
                <td class="border border-black px-1.5 py-0.5">5. Cuti Alasan Penting</td>
                <td class="border border-black px-1.5 py-0.5 text-center font-bold">{{ $pengajuan->jenis_cuti_id == 5 ? '√' : '' }}</td>
            </tr>
            <tr>
                <td class="border border-black px-1.5 py-0.5">3. Cuti Sakit</td>
                <td class="border border-black px-1.5 py-0.5 text-center font-bold">{{ $pengajuan->jenis_cuti_id == 3 ? '√' : '' }}</td>
                <td class="border border-black px-1.5 py-0.5">6. Cuti di Luar Tanggungan Negara</td>
                <td class="border border-black px-1.5 py-0.5 text-center font-bold">{{ $pengajuan->jenis_cuti_id == 6 ? '√' : '' }}</td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1 text-[10px]">
            <tr>
                <td class="border border-black px-1.5 py-0.5 bg-slate-100 font-bold">III. ALASAN CUTI</td>
            </tr>
            <tr>
                <td class="border border-black px-1.5 py-0.5 min-h-[25px]">{{ $pengajuan->alasan }}</td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1 text-[10px]">
            <tr>
                <td class="border border-black px-1.5 py-0.5 bg-slate-100 font-bold">IV. LAMANYA CUTI</td>
            </tr>
            <tr>
                <td class="border border-black px-1.5 py-0.5">
                    {{ $pengajuan->lama_cuti }} hari kerja terhitung mulai tanggal {{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->translatedFormat('d F Y') }} s.d {{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1 text-[10px]">
            <tr>
                <td colspan="5" class="border border-black px-1.5 py-0.5 bg-slate-100 font-bold">V. CATATAN CUTI ***</td>
            </tr>
            <tr>
                <td colspan="3" class="border border-black px-1.5 py-0.5 w-[45%]">1. CUTI TAHUNAN</td>
                <td class="border border-black px-1.5 py-0.5 w-[45%]">2. CUTI BESAR</td>
                <td class="border border-black px-1.5 py-0.5 text-center w-[10%] font-bold">{{ $pengajuan->jenis_cuti_id == 2 ? '√' : '' }}</td>
            </tr>
            <tr class="text-center">
                <td class="border border-black px-1 py-0.5 w-[15%]">Tahun</td>
                <td class="border border-black px-1 py-0.5 w-[10%]">Sisa</td>
                <td class="border border-black px-1 py-0.5 w-[20%]">Keterangan</td>
                <td class="border border-black px-1.5 py-0.5 text-left">3. CUTI SAKIT</td>
                <td class="border border-black px-1.5 py-0.5 font-bold">{{ $pengajuan->jenis_cuti_id == 3 ? '√' : '' }}</td>
            </tr>
            <tr class="text-center">
                <td class="border border-black px-1 py-0.5">N-2</td>
                <td class="border border-black px-1 py-0.5">{{ $sisa_n2 > 0 ? $sisa_n2 : '-' }}</td>
                <td class="border border-black px-1 py-0.5"></td>
                <td class="border border-black px-1.5 py-0.5 text-left">4. CUTI MELAHIRKAN</td>
                <td class="border border-black px-1.5 py-0.5 font-bold">{{ $pengajuan->jenis_cuti_id == 4 ? '√' : '' }}</td>
            </tr>
            <tr class="text-center">
                <td class="border border-black px-1 py-0.5">N-1</td>
                <td class="border border-black px-1 py-0.5">{{ $sisa_n1 > 0 ? $sisa_n1 : '-' }}</td>
                <td class="border border-black px-1 py-0.5"></td>
                <td class="border border-black px-1.5 py-0.5 text-left">5. CUTI ALASAN PENTING</td>
                <td class="border border-black px-1.5 py-0.5 font-bold">{{ $pengajuan->jenis_cuti_id == 5 ? '√' : '' }}</td>
            </tr>
            <tr class="text-center">
                <td class="border border-black px-1 py-0.5">N</td>
                <td class="border border-black px-1 py-0.5">{{ $sisa_n > 0 ? $sisa_n : '-' }}</td>
                <td class="border border-black px-1 py-0.5"></td>
                <td class="border border-black px-1.5 py-0.5 text-left">6. CUTI DILUAR TANGGUNGAN NEGARA</td>
                <td class="border border-black px-1.5 py-0.5 font-bold">{{ $pengajuan->jenis_cuti_id == 6 ? '√' : '' }}</td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1 table-fixed text-[10px]">
            <tr>
                <td colspan="3" class="border border-black px-1.5 py-0.5 bg-slate-100 font-bold">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
            </tr>
            <tr>
                <td colspan="2" class="border border-black px-1.5 py-0.5 align-top w-[70%]">
                    {{ $pengajuan->alamat_cuti }}
                </td>
                <td class="border border-black px-1.5 py-0.5 align-top w-[30%]">
                    Telp: {{ $pengajuan->no_telepon }}
                </td>
            </tr>
            <tr class="h-[65px]">
                
                {{-- KIRI: CATATAN KABID --}}
                <td colspan="2" class="border border-black px-1.5 py-0.5 align-top text-justify w-[70%] relative">
                    <p class="text-[9px] italic text-slate-700 underline mb-0.5">Catatan Kabid {{ $pengajuan->bidang_kabid ?? ($kabid->pegawai->bidang->nama_bidang ?? '') }} :</p>
                    <div class="handwriting text-blue-800 text-[12px] leading-tight">
                        {{ $pengajuan->catatan_kabid ?? 'Disetujui' }}
                    </div>
                </td>
                
                {{-- KANAN: TANDA TANGAN PEMOHON (KASI) --}}
                <td class="border border-black px-1.5 py-0.5 align-top text-justify relative w-[30%]">
                    <p class="text-left text-[9px] my-1 mx-1">Hormat saya,</p>
                    <div class="h-14 flex justify-normal my-1 mx-1 relative">
                        @if($pengajuan->ttd_pegawai)
                        <img src="{{ asset('storage/' . $pengajuan->ttd_pegawai) }}" class="h-14 object-contain mix-blend-multiply" alt="TTD Kasi/Pegawai">
                        @else
                        <span class="text-[9px] text-slate-400 italic">[Belum TTD]</span>
                        @endif
                    </div>
                    <p class="font-bold underline uppercase mx-1 text-[10px]">{{ $pengajuan->user->nama ?? '-' }}</p>
                    <p class="text-[9px] mx-1">NIP. {{ $pengajuan->user->pegawai->nip ?? $pengajuan->user->nip ?? '-' }}</p>
                </td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1 table-fixed text-[10px]">
            <tr>
                <td colspan="4" class="border border-black px-1.5 py-0.5 bg-slate-100 font-bold">VII. PERTIMBANGAN ATASAN LANGSUNG **</td>
            </tr>
            <tr class="text-center text-[9px]">
                <td class="border border-black px-1.5 py-0.5 w-[25%]">DISETUJUI</td>
                <td class="border border-black px-1.5 py-0.5 w-[25%]">PERUBAHAN ****</td>
                <td class="border border-black px-1.5 py-0.5 w-[25%]">DITANGGUHKAN ****</td>
                <td class="border border-black px-1.5 py-0.5 w-[25%]">TIDAK DISETUJUI ****</td>
            </tr>
            <tr class="text-center font-bold">
                <td class="border border-black px-1.5 py-0.5">√</td>
                <td class="border border-black px-1.5 py-0.5"></td>
                <td class="border border-black px-1.5 py-0.5"></td>
                <td class="border border-black px-1.5 py-0.5"></td>
            </tr>
            <tr class="h-[70px]">
                <td colspan="3" class="border border-black px-1.5 py-0.5 align-top relative">
                    <p class="text-[9px] italic text-slate-700 underline mb-0.5">Catatan Kasubbag. Umkep:</p>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="handwriting text-blue-800 text-[12px] ml-2 w-2/3">
                            {{ $pengajuan->catatan_kasubbag ?? 'ACC proses sesuai prosedur' }}
                        </div>
                        @if($pengajuan->ttd_kasubbag)
                        <div class="my-1 -translate-x-2">
                            <img src="{{ asset('storage/' . $pengajuan->ttd_kasubbag) }}" class="h-14 object-contain mix-blend-multiply opacity-90" alt="TTD Kasubbag">
                            <p class="text-[8px] italic text-slate-700 underline mt-0.5 text-center">{{ date('Y-m-d', strtotime($pengajuan->tgl_ttd_kasubbag_umum)) }}</p>
                        </div>
                        @endif
                    </div>
                </td>
                <td class="border border-black px-1.5 py-0.5 align-top text-justify relative">
                    <p class="text-left text-[9px] my-1 mx-1">{{ $pengajuan->jabatan_kabid ?? 'Kabid' }},</p>
                    <div class="h-14 flex justify-normal my-1 mx-1 relative">
                        @if($pengajuan->ttd_kabid)
                        <img src="{{ asset('storage/' . $pengajuan->ttd_kabid) }}" class="h-14 object-contain mix-blend-multiply" alt="TTD Kabid">
                        @else
                        <span class="text-[9px] text-slate-400 italic">[Belum TTD]</span>
                        @endif
                    </div>
                    <p class="font-bold underline uppercase mx-1 text-[10px]">{{ $pengajuan->nama_kabid ?? ($kabid->nama ?? '.......................') }}</p>
                    <p class="text-[9px] mx-1">NIP. {{ $pengajuan->nip_kabid ?? ($kabid->nip ?? '.......................') }}</p>
                </td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1 table-fixed text-[10px]">
            <tr>
                <td colspan="4" class="border border-black px-1.5 py-0.5 bg-slate-100 font-bold">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **</td>
            </tr>
            <tr class="text-center text-[9px]">
                <td class="border border-black px-1.5 py-0.5 w-[25%]">DISETUJUI</td>
                <td class="border border-black px-1.5 py-0.5 w-[25%]">PERUBAHAN ****</td>
                <td class="border border-black px-1.5 py-0.5 w-[25%]">DITANGGUHKAN ****</td>
                <td class="border border-black px-1.5 py-0.5 w-[25%]">TIDAK DISETUJUI ****</td>
            </tr>
            <tr class="text-center font-bold">
                <td class="border border-black px-1.5 py-0.5">√</td>
                <td class="border border-black px-1.5 py-0.5"></td>
                <td class="border border-black px-1.5 py-0.5"></td>
                <td class="border border-black px-1.5 py-0.5"></td>
            </tr>
            <tr class="h-[75px]">
                <td colspan="3" class="border border-black px-1.5 py-0.5 align-top relative">
                    <p class="text-[9px] italic text-slate-700 underline mb-0.5">Catatan Sekretaris Dinas:</p>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="handwriting text-blue-800 text-[12px] ml-2 w-2/3">
                            {{ $pengajuan->catatan_sekdin ?? 'Disetujui untuk diterbitkan' }}
                        </div>
                        @if($pengajuan->ttd_sekdin)
                        <div class="place-items-end my-1 -translate-x-2">
                            <img src="{{ asset('storage/' . $pengajuan->ttd_sekdin) }}" class="h-14 object-contain mix-blend-multiply opacity-90" alt="TTD Sekdin">
                            <p class="text-[8px] italic text-slate-700 underline my-0.5 mx-1">{{ date('Y-m-d', strtotime($pengajuan->tgl_ttd_sekdin)) }}</p>
                        </div>
                        @endif
                    </div>
                </td>
                <td class="border border-black px-1.5 py-0.5 align-top justify-normal relative">
                    <p class="text-left mb-1 mx-1 text-[9px]">Kepala Dinas,</p>
                    <div class="h-14 flex justify-normal my-1 mx-1 relative">
                        @if($pengajuan->ttd_kadin)
                        <img src="{{ asset('storage/' . $pengajuan->ttd_kadin) }}" class="h-14 object-contain mix-blend-multiply opacity-95" alt="TTD Kadin">
                        @else
                        <span class="text-[9px] text-slate-400 italic">[Belum TTD Kadin]</span>
                        @endif
                    </div>
                    <p class="font-bold flex justify-normal mx-1 underline uppercase text-[10px]">{{ $pengajuan->nama_kadin ?? ($kadin->nama ?? '-') }}</p>
                    <p class="text-[9px] flex justify-normal mx-1">NIP. {{ $pengajuan->nip_kadin ?? ($kadin->nip ?? '-') }}</p>
                </td>
            </tr>
        </table>

        <div class="mt-1 text-[9px]">
            <p>Tembusan Yth:</p>
            <p>- Kepala Badan Kepegawaian Daerah Provinsi Sumatera Selatan.</p>
        </div>

    </div>

    {{-- CSS Kustom Khusus Mode Cetak (Print) & Font Tulisan Tangan --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap');

        .handwriting {
            font-family: 'Kalam', cursive;
        }

        /* Set Kertas F4 Murni (Folio) Margin Kecil */
        @page {
            size: 215.9mm 330.2mm; 
            margin: 8mm;
        }

        @media print {
            body {
                background: white;
                /* Ini kunci utamanya supaya tidak pecah ke halaman 2 */
                zoom: 0.88; 
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

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

            div.font-sans, div.font-sans * {
                visibility: visible;
                color: #000 !important;
            }

            div.font-sans {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            table td.bg-slate-100,
            table td.bg-slate-50 {
                background-color: transparent !important;
            }
            
            table, th, td {
                border-color: #000 !important;
            }
        }
    </style>
</x-layouts.kasi.app>