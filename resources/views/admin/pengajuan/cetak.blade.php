<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Izin Cuti - {{ $pengajuan->user->nama }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; margin: 2cm; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        
        /* Kop Surat */
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center;}
        .kop-surat h2, .kop-surat h3, .kop-surat p { margin: 0; }
        .kop-surat h2 { font-size: 16pt; text-transform: uppercase; }
        
        /* Tabel Data */
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table.data-table td { padding: 4px; vertical-align: top; }
        .col-label { width: 30%; }
        .col-separator { width: 2%; text-align: center; }
        
        /* Tabel Signatures */
        table.sig-table { width: 100%; margin-top: 30px; text-align: center; }
        table.sig-table td { width: 50%; padding-top: 20px; }
        .ttd-img { max-height: 70px; margin: 10px 0; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>PEMERINTAH PROVINSI SUMATERA SELATAN</h2>
        <h3>DINAS LINGKUNGAN HIDUP DAN PERTANAHAN</h3>
        <p>UPTD LABORATORIUM LINGKUNGAN</p>
        <p style="font-size: 10pt;">Jalan ... (Sesuaikan Alamat Instansi)</p>
    </div>

    <div class="text-center" style="margin-bottom: 20px;">
        <span class="font-bold uppercase text-center" style="text-decoration: underline; font-size: 14pt;">
            SURAT IZIN {{ strtoupper($pengajuan->jenisCuti->nama) }}
        </span>
        <br>
        <span>Nomor: ........ / ........ / UPTD-LAB / {{ date('Y') }}</span>
    </div>

    <p>Diberikan {{ $pengajuan->jenisCuti->nama }} kepada Pegawai Negeri Sipil / Pegawai:</p>

    <table class="data-table">
        <tr>
            <td class="col-label">Nama</td>
            <td class="col-separator">:</td>
            <td><b>{{ $pengajuan->user->nama }}</b></td>
        </tr>
        <tr>
            <td class="col-label">NIP</td>
            <td class="col-separator">:</td>
            <td>{{ $pengajuan->user->nip }}</td>
        </tr>
        <tr>
            <td class="col-label">Pangkat/Golongan</td>
            <td class="col-separator">:</td>
            <td>{{ $pengajuan->user->pegawai->pangkat_golongan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Jabatan</td>
            <td class="col-separator">:</td>
            <td>{{ $pengajuan->user->pegawai->jabatan ?? '-' }}</td>
        </tr>
    </table>

    <p style="text-align: justify;">
        Selama <b>{{ $pengajuan->lama_cuti }} ({{ ucwords((new \NumberFormatter("id", \NumberFormatter::SPELLOUT))->format($pengajuan->lama_cuti)) }}) hari kerja</b>, 
        terhitung mulai tanggal <b>{{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->translatedFormat('d F Y') }}</b> 
        sampai dengan tanggal <b>{{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->translatedFormat('d F Y') }}</b>, 
        dengan ketentuan sebagai berikut:
    </p>

    <ol style="text-align: justify; padding-left: 20px;">
        <li>Sebelum menjalankan cuti, wajib menyerahkan pekerjaannya kepada atasan langsungnya atau pejabat lain yang ditunjuk.</li>
        <li>Setelah selesai menjalankan cuti, wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.</li>
    </ol>

    <p>Alamat selama menjalankan cuti: <b>{{ $pengajuan->alamat }}</b> (No. Telp: {{ $pengajuan->no_telepon }})</p>
    <p>Demikian surat izin cuti ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

    {{-- Tabel Tanda Tangan --}}
    <table class="sig-table">
        <tr>
            <td>
                Menyetujui,<br>
                <b>Atasan Langsung</b>
                <br>
                @if($pengajuan->atasan->pegawai->foto_ttd)
                    <img src="{{ public_path('storage/' . $pengajuan->atasan->pegawai->foto_ttd) }}" class="ttd-img">
                @else
                    <br><br><br>
                @endif
                <br>
                <b><u>{{ $pengajuan->atasan->nama }}</u></b><br>
                NIP. {{ $pengajuan->atasan->nip }}
            </td>
            <td>
                Palembang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                <b>Pejabat Yang Berwenang (Kasi / Kepala)</b>
                <br>
                {{-- Anggap Kasi adalah penandatangan utama, ini bisa diganti logikanya --}}
                <br><br><br><br>
                <b><u>NAMA PEJABAT KASI</u></b><br>
                NIP. 198XXXXXXXXXXX
            </td>
        </tr>
    </table>

</body>
</html>