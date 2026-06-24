<!DOCTYPE html>
<html>
<head>
    <title>Export Laporan Cuti</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="8" style="font-weight: bold; font-size: 16px; text-align: center;">
                    LAPORAN PENGAJUAN CUTI PEGAWAI<br>
                    DINAS ENERGI DAN SUMBER DAYA MINERAL PROV. SUMSEL
                </th>
            </tr>
            <tr>
                <th colspan="8">Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</th>
            </tr>
            <tr>
                <th style="background-color: #d1d5db; font-weight: bold;">No</th>
                <th style="background-color: #d1d5db; font-weight: bold;">Nama Pegawai</th>
                <th style="background-color: #d1d5db; font-weight: bold;">NIP</th>
                <th style="background-color: #d1d5db; font-weight: bold;">Bidang / Jabatan</th>
                <th style="background-color: #d1d5db; font-weight: bold;">Jenis Cuti</th>
                <th style="background-color: #d1d5db; font-weight: bold;">Tanggal Pelaksanaan</th>
                <th style="background-color: #d1d5db; font-weight: bold;">Lama Cuti</th>
                <th style="background-color: #d1d5db; font-weight: bold;">Status Berkas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->user->nama ?? '-' }}</td>
                <td>{{ $item->user->pegawai->nip ?? $item->user->nip ?? '-' }}</td>
                <td>
                    {{ $item->user->pegawai->bidang->nama_bidang ?? '-' }} <br>
                    ({{ $item->user->pegawai->jabatan ?? '-' }})
                </td>
                <td>{{ $item->jenisCuti->nama ?? $item->jenisCuti->nama_cuti ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') }}</td>
                <td>{{ $item->lama_cuti }} Hari</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>