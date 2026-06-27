<x-layouts.pegawai.app>
    <div class="mb-6 flex items-center justify-between no-print">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Cetak Formulir Cuti</h2>
            <p class="text-slate-500 text-sm">Dokumen resmi instansi berdasarkan format baku BKN.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('pegawai.riwayat.index') }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-lg hover:bg-slate-50 transition shadow-sm text-sm">
                &larr; Kembali ke Riwayat
            </a>
            <button onclick="window.print()" class="px-5 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition flex items-center gap-1.5 shadow-md">
                Cetak Dokumen Sekarang
            </button>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- KANVAS PREVIEW FORMULIR BKN (MENYERUPAI KERTAS DOKUMEN ASLI) --}}
    {{-- ========================================================================= --}}
    <div class="bg-white p-8 md:p-10 shadow-sm border border-slate-200 mx-auto print:shadow-none print:border-none print:p-0 font-sans text-black leading-snug max-w-[800px] antialiased text-[11px]">

        <div class="flex items-center justify-center border-b-[3px] border-black pb-3 mb-4">
            <div class="w-20">
                <img src="{{ asset('images/logosumsel.png') }}" alt="Logo Sumsel" class="w-16 h-auto opacity-80 mix-blend-multiply">
            </div>
            <div class="text-center flex-1 px-4">
                <h1 class="text-[14px] font-bold tracking-wide uppercase">PEMERINTAH PROVINSI SUMATERA SELATAN</h1>
                <h2 class="text-[16px] font-extrabold uppercase mt-0.5">DINAS ENERGI DAN SUMBER DAYA MINERAL</h2>
                <p class="text-[10px] mt-1">Jalan Angkatan 45 Nomor 2440 Palembang Provinsi Sumatera Selatan</p>
                <p class="text-[10px]">Telepon (0711) 379040 Pos-el : desdm.sumselprov@gmail.com</p>
                <p class="text-[10px]">Laman : www.desdm.sumselprov.go.id</p>
            </div>
            <div class="w-16"></div>
        </div>

        <div class="flex justify-end mb-4">
            <div class="w-1/2 text-right pr-4">
                <p>Palembang, {{ \Carbon\Carbon::parse($pengajuan->updated_at)->translatedFormat('d F Y') }}</p>
            </div>
        </div>
        <div class="mb-4 space-y-0.5 w-1/2">
            <p>Yth. Kepala Dinas Energi dan Sumber Daya Mineral</p>
            <p>Provinsi Sumatera Selatan</p>
            <p>di-</p>
            <p class="pl-4">Palembang</p>
        </div>

        <div class="text-center mb-4">
            <h3 class="font-bold text-[12px] underline uppercase">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</h3>
            <p class="text-[11px]">Nomor : 800.1.11.3 / &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / DESDM / {{ \Carbon\Carbon::now()->year }}</p>
        </div>

        <table class="w-full border-collapse border border-black mb-1.5">
            <tr>
                <td colspan="4" class="border border-black px-2 py-0.5 bg-slate-100 font-bold">I. DATA PEGAWAI</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5 w-[15%]">Nama</td>
                <td class="border border-black px-2 py-0.5 w-[35%]">{{ $pengajuan->user->nama ?? '-' }}</td>
                <td class="border border-black px-2 py-0.5 w-[15%]">NIP</td>
                <td class="border border-black px-2 py-0.5 w-[35%]">{{ $pengajuan->user->pegawai->nip ?? $pengajuan->user->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5">Jabatan</td>
                <td class="border border-black px-2 py-0.5">{{ $pengajuan->user->pegawai->jabatan ?? '-' }}</td>
                <td class="border border-black px-2 py-0.5">Masa Kerja</td>
                <td class="border border-black px-2 py-0.5">
                    @if(!empty($pengajuan->user->pegawai->masa_kerja))
                    {{ floor(\Carbon\Carbon::parse($pengajuan->user->pegawai->masa_kerja)->diffInYears(\Carbon\Carbon::now())) }} Tahun
                    @else
                    -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5">Unit Kerja</td>
                <td colspan="3" class="border border-black px-2 py-0.5">Dinas Energi dan Sumber Daya Mineral Prov. Sumsel</td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1.5">
            <tr>
                <td colspan="4" class="border border-black px-2 py-0.5 bg-slate-100 font-bold">II. JENIS CUTI YANG DIAMBIL **</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5 w-[40%]">1. Cuti Tahunan</td>
                <td class="border border-black px-2 py-0.5 text-center w-[10%] font-bold">{{ $pengajuan->jenis_cuti_id == 1 ? '√' : '' }}</td>
                <td class="border border-black px-2 py-0.5 w-[40%]">4. Cuti Melahirkan</td>
                <td class="border border-black px-2 py-0.5 text-center w-[10%] font-bold">{{ $pengajuan->jenis_cuti_id == 4 ? '√' : '' }}</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5">2. Cuti Besar</td>
                <td class="border border-black px-2 py-0.5 text-center font-bold">{{ $pengajuan->jenis_cuti_id == 2 ? '√' : '' }}</td>
                <td class="border border-black px-2 py-0.5">5. Cuti Alasan Penting</td>
                <td class="border border-black px-2 py-0.5 text-center font-bold">{{ $pengajuan->jenis_cuti_id == 5 ? '√' : '' }}</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-0.5">3. Cuti Sakit</td>
                <td class="border border-black px-2 py-0.5 text-center font-bold">{{ $pengajuan->jenis_cuti_id == 3 ? '√' : '' }}</td>
                <td class="border border-black px-2 py-0.5">6. Cuti di Luar Tanggungan Negara</td>
                <td class="border border-black px-2 py-0.5 text-center font-bold">{{ $pengajuan->jenis_cuti_id == 6 ? '√' : '' }}</td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1.5">
            <tr>
                <td class="border border-black px-2 py-0.5 bg-slate-100 font-bold">III. ALASAN CUTI</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-1 min-h-[30px]">{{ $pengajuan->alasan }}</td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1.5">
            <tr>
                <td class="border border-black px-2 py-0.5 bg-slate-100 font-bold">IV. LAMANYA CUTI</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-1">
                    {{ $pengajuan->lama_cuti }} hari kerja terhitung mulai tanggal {{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->translatedFormat('d F Y') }} s.d {{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1.5">
            <tr>
                <td colspan="5" class="border border-black px-2 py-0.5 bg-slate-100 font-bold">V. CATATAN CUTI ***</td>
            </tr>
            <tr>
                <td colspan="3" class="border border-black px-2 py-0.5 w-[45%]">1. CUTI TAHUNAN</td>
                <td class="border border-black px-2 py-0.5 w-[45%]">2. CUTI BESAR</td>
                <td class="border border-black px-2 py-0.5 text-center w-[10%] font-bold">{{ $pengajuan->jenis_cuti_id == 2 ? '√' : '' }}</td>
            </tr>
            <tr class="text-center">
                <td class="border border-black px-1 py-0.5 w-[15%]">Tahun</td>
                <td class="border border-black px-1 py-0.5 w-[10%]">Sisa</td>
                <td class="border border-black px-1 py-0.5 w-[20%]">Keterangan</td>
                <td class="border border-black px-2 py-0.5 text-left">3. CUTI SAKIT</td>
                <td class="border border-black px-2 py-0.5 font-bold">{{ $pengajuan->jenis_cuti_id == 3 ? '√' : '' }}</td>
            </tr>

            {{-- PERUBAHAN DIMULAI DARI SINI --}}
            <tr class="text-center">
                <td class="border border-black px-1 py-0.5">N-2</td>
                <td class="border border-black px-1 py-0.5">{{ $sisa_n2 > 0 ? $sisa_n2 : '-' }}</td>
                <td class="border border-black px-1 py-0.5"></td>
                <td class="border border-black px-2 py-0.5 text-left">4. CUTI MELAHIRKAN</td>
                <td class="border border-black px-2 py-0.5 font-bold">{{ $pengajuan->jenis_cuti_id == 4 ? '√' : '' }}</td>
            </tr>
            <tr class="text-center">
                <td class="border border-black px-1 py-0.5">N-1</td>
                <td class="border border-black px-1 py-0.5">{{ $sisa_n1 > 0 ? $sisa_n1 : '-' }}</td>
                <td class="border border-black px-1 py-0.5"></td>
                <td class="border border-black px-2 py-0.5 text-left">5. CUTI ALASAN PENTING</td>
                <td class="border border-black px-2 py-0.5 font-bold">{{ $pengajuan->jenis_cuti_id == 5 ? '√' : '' }}</td>
            </tr>
            <tr class="text-center">
                <td class="border border-black px-1 py-0.5">N</td>
                <td class="border border-black px-1 py-0.5">{{ $sisa_n > 0 ? $sisa_n : '-' }}</td>
                <td class="border border-black px-1 py-0.5"></td>
                <td class="border border-black px-2 py-0.5 text-left">6. CUTI DILUAR TANGGUNGAN NEGARA</td>
                <td class="border border-black px-2 py-0.5 font-bold">{{ $pengajuan->jenis_cuti_id == 6 ? '√' : '' }}</td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1.5 table-fixed">
            <tr>
                <td colspan="3" class="border border-black px-2 py-0.5 bg-slate-100 font-bold">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
            </tr>
            <tr>
                <td colspan="2" class="border border-black px-2 py-1 align-top w-[70%]">
                    {{ $pengajuan->alamat_cuti }}
                </td>
                <td class="border border-black px-2 py-1 align-top w-[30%]">
                    Telp: {{ $pengajuan->no_telepon }}
                </td>
            </tr>
            <tr class="h-24">
                <td class="border border-black px-2 py-1 align-top text-justify w-[35%] relative">
                    <p class="text-[10px] italic text-slate-700 underline mb-1">
                        Catatan Kasi {{ $pengajuan->bidang_kasi ?? ($pengajuan->atasan->pegawai->bidang->nama_bidang ?? '') }} :
                    </p>
                    <div class="handwriting text-blue-800 text-[13px] leading-tight">
                        {{ $pengajuan->catatan_kasi ?? 'Sebelum cuti selesaikan pekerjaan' }}
                    </div>
                </td>
                <td class="border border-black px-2 py-1 align-top text-justify w-[35%] relative">
                    <p class="text-[10px] italic text-slate-700 underline mb-1">
                        Catatan Kabid {{ $pengajuan->bidang_kabid ?? ($kabid->pegawai->bidang->nama_bidang ?? '') }} :</p>
                    <div class="handwriting text-blue-800 text-[13px] leading-tight mt-2">
                        {{ $pengajuan->catatan_kabid ?? 'Disetujui' }}
                    </div>
                    @if($pengajuan->ttd_kabid)
                    <div class="flex flex-col items-center justify-center mt-1 mb-3">
                        <img src="{{ asset('storage/' . $pengajuan->ttd_kabid) }}" class="h-20 object-contain mix-blend-multiply opacity-90" alt="TTD Kabid">
                        <p class="text-[10px] italic text-slate-700 underline my-1 mx-3">
                            {{ date('Y-m-d', strtotime($pengajuan->tgl_ttd_kabid)) }}
                        </p>
                    </div>
                    @endif
                </td>
                <td class="border border-black px-2 py-1 align-top w-[30%] text-center">
                    <p class="text-left mb-1 mx-2">Hormat saya,</p>
                    <div class="h-20 flex justify-normal mt-6 mb-2  mx-2 relative">
                        @if($pengajuan->ttd_pegawai)
                        <img src="{{ asset('storage/' . $pengajuan->ttd_pegawai) }}" class="h-20 object-contain mix-blend-multiply" alt="TTD Pegawai">
                        @else
                        <span class="text-[10px] text-slate-400 italic">[Belum TTD]</span>
                        @endif
                    </div>
                    <p class="font-bold flex justify-normal mx-2 underline uppercase">{{ $pengajuan->user->nama ?? '-' }}</p>
                    <p class="text-[10px] flex justify-normal mx-2">NIP. {{ $pengajuan->user->pegawai->nip ?? $pengajuan->user->nip ?? '-' }}</p>
                </td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1.5 table-fixed">
            <tr>
                <td colspan="4" class="border border-black px-2 py-0.5 bg-slate-100 font-bold">VII. PERTIMBANGAN ATASAN LANGSUNG **</td>
            </tr>
            <tr class="text-center">
                <td class="border border-black px-2 py-0.5 w-[25%]">DISETUJUI</td>
                <td class="border border-black px-2 py-0.5 w-[25%]">PERUBAHAN ****</td>
                <td class="border border-black px-2 py-0.5 w-[25%]">DITANGGUHKAN ****</td>
                <td class="border border-black px-2 py-0.5 w-[25%]">TIDAK DISETUJUI ****</td>
            </tr>
            <tr class="text-center font-bold">
                <td class="border border-black px-2 py-0.5">√</td>
                <td class="border border-black px-2 py-0.5"></td>
                <td class="border border-black px-2 py-0.5"></td>
                <td class="border border-black px-2 py-0.5"></td>
            </tr>
            <tr class="h-24">
                <td colspan="3" class="border border-black px-2 py-1 align-top relative">
                    <p class="text-[10px] italic text-slate-700 underline mb-1">Catatan Kasubbag. Umkep:</p>
                    <div class="flex items-center gap-4 mt-2">
                        <div class="handwriting text-blue-800 text-[14px] ml-4 w-2/3">
                            {{ $pengajuan->catatan_kasubbag ?? 'ACC proses sesuai prosedur' }}
                        </div>
                        @if($pengajuan->ttd_kasubbag)
                        <div class="place-items-end my-2 -translate-x-16">
                            <img src="{{ asset('storage/' . $pengajuan->ttd_kasubbag) }}" class="h-20 object-contain mix-blend-multiply opacity-90" alt="TTD Kasubbag Umum">
                            <p class="text-[10px] italic text-slate-700 underline my-1 mx-2">
                                {{ date('Y-m-d', strtotime($pengajuan->tgl_ttd_kasubbag_umum)) }}
                            </p>
                        </div>
                        @endif
                    </div>
                </td>
                <td class="border border-black px-2 py-1 align-top text-justify relative">
                    <p class="text-left text-[10px] my-2 mx-2">Kasi {{ $pengajuan->jabatan_kasi ?? 'Kasi' }},</p>
                    <div class="h-20 flex justify-normal my-2  mx-2 relative">
                        @if($pengajuan->ttd_kasi)
                        <img src="{{ asset('storage/' . $pengajuan->ttd_kasi) }}" class="h-20 object-contain mix-blend-multiply" alt="TTD Kasi">
                        @else
                        <span class="text-[10px] text-slate-400 italic">[Belum TTD]</span>
                        @endif
                    </div>
                    <p class="font-bold underline uppercase mx-2">{{ $pengajuan->nama_kasi ?? ($pengajuan->atasan->nama ?? '-') }}</p>
                    <p class="text-[10px] mx-2">
                        NIP. {{ $pengajuan->nip_kasi ?? ($pengajuan->atasan->nip ?? '-') }}
                    </p>
                </td>
            </tr>
        </table>

        <table class="w-full border-collapse border border-black mb-1.5 table-fixed">
            <tr>
                <td colspan="4" class="border border-black px-2 py-0.5 bg-slate-100 font-bold">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **</td>
            </tr>
            <tr class="text-center">
                <td class="border border-black px-2 py-0.5 w-[25%]">DISETUJUI</td>
                <td class="border border-black px-2 py-0.5 w-[25%]">PERUBAHAN ****</td>
                <td class="border border-black px-2 py-0.5 w-[25%]">DITANGGUHKAN ****</td>
                <td class="border border-black px-2 py-0.5 w-[25%]">TIDAK DISETUJUI ****</td>
            </tr>
            <tr class="text-center font-bold">
                <td class="border border-black px-2 py-0.5">√</td>
                <td class="border border-black px-2 py-0.5"></td>
                <td class="border border-black px-2 py-0.5"></td>
                <td class="border border-black px-2 py-0.5"></td>
            </tr>
            <tr class="h-28">
                <td colspan="3" class="border border-black px-2 py-1 align-top relative">
                    <p class="text-[10px] italic text-slate-700 underline mb-1">Catatan Sekretaris Dinas:</p>
                    <div class="flex items-center gap-4 mt-2">
                        <div class="handwriting text-blue-800 text-[14px] ml-4 w-2/3">
                            {{ $pengajuan->catatan_sekdin ?? 'Disetujui untuk diterbitkan' }}
                        </div>
                        @if($pengajuan->ttd_sekdin)
                        <div class="my-2 -translate-x-16">
                            <img src="{{ asset('storage/' . $pengajuan->ttd_sekdin) }}" class="h-20 object-contain mix-blend-multiply opacity-90" alt="TTD Sekdin">
                            <p class="text-[10px] italic text-slate-700 underline mt-1 mx-2">
                                {{ date('Y-m-d', strtotime($pengajuan->tgl_ttd_sekdin)) }}
                            </p>
                        </div>
                        @endif
                    </div>
                </td>
                <td class="border border-black px-2 py-1 align-top justify-normal relative">
                    <p class="text-left mb-1 mx-2">Kepala Dinas,</p>
                    <div class="h-20 flex justify-normal my-2 mx-2 relative">
                        @if($pengajuan->ttd_kadin)
                        <img src="{{ asset('storage/' . $pengajuan->ttd_kadin) }}" class="h-20 object-contain mix-blend-multiply opacity-95" alt="TTD Kadin">
                        @else
                        <span class="text-[10px] text-slate-400 italic">[Belum TTD Kadin]</span>
                        @endif
                    </div>
                    <p class="font-bold flex justify-normal mx-2 underline uppercase">{{ $pengajuan->nama_kadin ?? ($kadin->nama ?? '-') }}</p>
                    <p class="text-[10px] flex justify-normal mx-2">NIP. {{ $pengajuan->nip_kadin ?? ($kadin->nip ?? '-') }}</p>
                </td>
            </tr>
        </table>

        <div class="mt-2 text-[10px]">
            <p>Tembusan Yth:</p>
            <p>- Kepala Badan Kepegawaian Daerah Provinsi Sumatera Selatan.</p>
        </div>
    </div>

    {{-- Script untuk memicu dialog print browser secara otomatis ketika tab dibuka --}}
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Memberikan sedikit jeda waktu agar font Google ter-load dengan sempurna
            setTimeout(() => {
                window.print();
            }, 800);
        });

    </script>

    {{-- CSS Kustom Khusus Mode Cetak (Print) & Font Tulisan Tangan --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap');

        .handwriting {
            font-family: 'Kalam', cursive;
        }

        @media print {
            body {
                background: white;
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

            div.font-sans,
            div.font-sans * {
                visibility: visible;
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
        }

    </style>
</x-layouts.pegawai.app>
