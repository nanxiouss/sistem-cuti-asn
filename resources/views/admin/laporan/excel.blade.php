<!DOCTYPE html>
<html>
<head>
    <title>Export Laporan Cuti</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="11" style="font-weight: bold; font-size: 16px; text-align: center;">
                    LAPORAN PENGAJUAN CUTI PEGAWAI<br>
                    DINAS ENERGI DAN SUMBER DAYA MINERAL PROV. SUMSEL
                </th>
            </tr>
            <tr>
                <th colspan="11">Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</th>
            </tr>
            <tr>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">No</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">Nama Pegawai</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">NIP</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">Jabatan</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">Unit Kerja Penempatan</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">No Surat Cuti</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">Tanggal Surat Cuti</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">TMT Cuti</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">Lama Cuti</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">Jenis Cuti</th>
                <th style="background-color: #d1d5db; font-weight: bold; text-align: center;">Sisa Cuti</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $item)
                @php
                    // 1. FORMAT NOMOR SURAT CUTI SECARA DINAMIS BERDASARKAN ROLE
                    $role = strtolower($item->user->role ?? 'pegawai');
                    // Jika kasi atau kasubbag umum berkode 800.1.11.4, selain itu (pegawai biasa) berkode 800.1.11.3
                    $kodeSurat = in_array($role, ['kasi', 'kasubbag_umum']) ? '800.1.11.4' : '800.1.11.3';
                    $tahunSurat = \Carbon\Carbon::parse($item->tgl_mulai)->format('Y');
                    $noSuratCuti = $kodeSurat . '/' . $item->id . '/DESDM/' . $tahunSurat;

                    // 2. TANGGAL SURAT CUTI (Waktu selesai disetujui / diproses di pemberkasan admin)
                    $tglSuratCuti = $item->status == 'Selesai' ? \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') : 'Belum Selesai';

                    // 3. LOGIKA SISA CUTI BERDASARKAN JENIS CUTI YANG DIAJUKAN
                    $sisaCutiTeks = '-';
                    if ($item->jenis_cuti_id == 1) {
                        // Menggunakan data snapshot simpanan admin jika sudah 'Selesai', jika belum pakai data profile riil
                        $sisaCutiTeks = ($item->snapshot_sisa_n ?? $item->user->pegawai->sisa_cuti_tahunan ?? 0) . ' Hari';
                    } elseif ($item->jenis_cuti_id == 2) {
                        $sisaCutiTeks = ($item->user->pegawai->sisa_cuti_besar ?? 0) . ' Hari';
                    } elseif ($item->jenis_cuti_id == 4) {
                        $sisaCutiTeks = ($item->user->pegawai->sisa_cuti_melahirkan ?? 0) . ' Hari';
                    }
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $item->user->nama ?? '-' }}</td>
                    {{-- Format string Excel agar NIP tidak berantakan/berubah format --}}
                    <td style="font-family: monospace; text-align: center;">{{ $item->user->pegawai->nip ?? $item->user->nip ?? '-' }}</td>
                    <td>{{ $item->user->pegawai->jabatan ?? '-' }}</td>
                    <td>{{ $item->user->pegawai->bidang->nama_bidang ?? '-' }}</td>
                    <td style="text-align: center;">{{ $noSuratCuti }}</td>
                    <td style="text-align: center;">{{ $tglSuratCuti }}</td>
                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') }}
                    </td>
                    <td style="text-align: center;">{{ $item->lama_cuti }} Hari</td>
                    <td>{{ $item->jenisCuti->nama ?? '-' }}</td>
                    <td style="text-align: center;">{{ $sisaCutiTeks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>