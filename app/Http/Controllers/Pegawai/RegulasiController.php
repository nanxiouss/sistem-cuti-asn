<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegulasiController extends Controller
{
    public function index()
    {

        $regulasi = [
            [
                'kategori' => 'Peraturan Badan Kepegawaian Negara (BKN)',
                'deskripsi' => 'Juknis Tata Cara Cuti ASN',
                'icon_color' => 'blue',
                'items' => [
                    [
                        'judul' => 'Peraturan Kepala BKN No 24 Tahun 2017',
                        'sub'   => 'Tata Cara Pemberian Cuti PNS',
                        'file'  => 'doc/perka BKN No 24 Tahun 2017.pdf'
                    ],
                    [
                        'judul' => 'Peraturan Kepala BKN No 7 Tahun 2021',
                        'sub'   => 'Perubahan atas Perka BKN 24/2017',
                        'file'  => 'doc/perka BKN No 7 Tahun 2021.pdf'
                    ],
                    [
                        'judul' => 'Peraturan Kepala BKN No 7 Tahun 2022',
                        'sub'   => 'Tata Cara Pemberian Cuti PPPK',
                        'file'  => 'doc/perka BKN No 7 Tahun 2022.pdf'
                    ],
                ]
            ],
            [
                'kategori' => 'Surat Edaran & Kebijakan Internal',
                'deskripsi' => 'Aturan internal Dinas ESDM',
                'icon_color' => 'orange',
                'items' => [] // Kosong, nanti akan muncul pesan "Belum ada dokumen"
            ]
        ];

        return view('pegawai.regulasi.index', compact('regulasi'));
    }
}
