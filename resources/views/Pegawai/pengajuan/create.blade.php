@extends('layouts.pegawai.app')

@section('title', 'Formulir Pengajuan Cuti')

@section('content')
<main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    {{-- Notifikasi Error Validasi --}}
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="font-bold">Terjadi Kesalahan:</span>
        </div>
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-bold text-slate-900">Formulir Permintaan Cuti</h1>
        <p class="text-slate-500 mt-1">Lengkapi formulir sesuai data yang benar untuk diproses oleh atasan.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8">
            <form action="{{ route('pegawai.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Bagian Saldo Cuti --}}
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wide">
                            Saldo Cuti Tahunan ({{ $tahun_skrg }})
                        </h2>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-center opacity-60">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Tahun {{ $tahun_skrg-2 }}
                                (N-2)</p>
                            <p class="text-xl font-bold text-slate-400">{{ $sisa_n2 }}</p>
                            <p class="text-[9px] text-slate-400 mt-1 italic">Hangus</p>
                        </div>
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-center">
                            <p class="text-[10px] text-blue-500 font-bold uppercase mb-1">Tahun {{ $tahun_skrg-1 }}
                                (N-1)</p>
                            <p class="text-xl font-bold text-blue-600">{{ $sisa_n1 }}</p>
                        </div>
                        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-3 text-center">
                            <p class="text-[10px] text-indigo-500 font-bold uppercase mb-1">Tahun {{ $tahun_skrg }} (N)
                            </p>
                            <p class="text-xl font-bold text-indigo-700">{{ $sisa_n }}</p>
                        </div>
                        <div
                            class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 text-center group hover:border-emerald-300 transition shadow-sm">
                            <p class="text-[10px] text-emerald-600 font-bold uppercase mb-1">Total Tersedia</p>
                            <p class="text-xl font-extrabold text-emerald-600">{{ $sisa_total }}</p>
                            <p class="text-[9px] text-emerald-500 mt-1 font-semibold">Siap Digunakan</p>
                        </div>
                    </div>
                </div>

                {{-- SEKSI I: Data Pegawai --}}
                <div class="mb-8 border-b border-slate-200 pb-6">
                    <h3 class="text-sm font-bold text-blue-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-blue-100 flex items-center justify-center text-xs">I</span>
                        Data Pegawai
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Nama</label>
                            <input type="text" value="{{ $user->nama }}"
                                class="w-full bg-slate-100 border-0 rounded-lg px-3 py-2 text-slate-700 font-bold text-sm cursor-not-allowed"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">NIP</label>
                            <input type="text" value="{{ $user->nip }}"
                                class="w-full bg-slate-100 border-0 rounded-lg px-3 py-2 text-slate-700 text-sm cursor-not-allowed"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Jabatan</label>
                            <input type="text" value="{{ $user->pegawai->jabatan ?? 'Belum Diatur' }}"
                                class="w-full bg-slate-100 border-0 rounded-lg px-3 py-2 text-slate-700 text-sm cursor-not-allowed"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Unit Kerja</label>
                            <input type="text" value="{{ $user->pegawai->unit_kerja ?? 'Belum Diatur' }}"
                                class="w-full bg-slate-100 border-0 rounded-lg px-3 py-2 text-slate-700 text-sm cursor-not-allowed"
                                readonly>
                        </div>
                    </div>
                </div>

                {{-- SEKSI II: Detail Pengajuan --}}
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-blue-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-blue-100 flex items-center justify-center text-xs">II</span>
                        Detail Pengajuan
                    </h3>

                    {{-- Dropdown Jenis Cuti --}}
                    <div class="mb-6 relative">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Cuti <span
                                class="text-red-500">*</span></label>
                        <input type="hidden" name="id_jenis_cuti" id="input_jenis_cuti"
                            value="{{ old('id_jenis_cuti') }}" required>
                        <button type="button" onclick="toggleCutiDropdown()"
                            class="w-full inline-flex items-center justify-between text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 font-medium rounded-lg text-sm px-4 py-3 transition shadow-sm focus:ring-2 focus:ring-blue-500">
                            <span id="label_jenis_cuti">-- Pilih Jenis Cuti --</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 9-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="dropdown_jenis_cuti"
                            class="hidden absolute z-10 w-full bg-white border border-slate-200 rounded-lg shadow-xl mt-1 max-h-60 overflow-y-auto border-t-4 border-t-blue-500">
                            <ul class="p-2 text-sm text-slate-700 font-medium">
                                @foreach($jenis_cutis as $j)
                                <li>
                                    <button type="button" onclick="pilihJenisCuti('{{ $j->id }}', '{{ $j->nama }}')"
                                        class="w-full px-4 py-2 hover:bg-blue-50 hover:text-blue-700 rounded-lg text-left flex justify-between items-center transition">
                                        <span>{{ $j->nama }}</span>
                                        @if(isset($j->kuota) && $j->kuota > 0)
                                        <span class="text-[10px] bg-blue-100 text-blue-600 px-2 py-1 rounded-md">Kuota:
                                            {{ $j->kuota }}</span>
                                        @endif
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alasan Cuti <span
                                class="text-red-500">*</span></label>
                        <textarea name="alasan" rows="3"
                            class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3"
                            placeholder="Jelaskan alasan pengajuan anda..." required>{{ old('alasan') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Mulai <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tgl_mulai" id="tgl_mulai" min="{{ $min_date }}"
                                value="{{ old('tgl_mulai') }}"
                                class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg p-3"
                                required onchange="hitungDurasi()">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Selesai <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tgl_selesai" id="tgl_selesai" min="{{ $min_date }}"
                                value="{{ old('tgl_selesai') }}"
                                class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg p-3"
                                required onchange="hitungDurasi()">
                        </div>
                    </div>

                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl mb-6">
                        <span class="text-xs font-bold text-blue-800 uppercase">Kalkulasi Durasi:</span>
                        <p id="durasi_teks" class="text-sm text-blue-900 font-medium mt-1 italic">- Masukkan tanggal
                            untuk menghitung hari kerja -</p>
                    </div>
                </div>

                {{-- SEKSI III: Kontak & Alamat (TAMBAHAN PENTING) --}}
                <div class="mb-8 border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-bold text-blue-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-blue-100 flex items-center justify-center text-xs">III</span>
                        Alamat Selama Cuti
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="2"
                                class="w-full border border-slate-300 rounded-lg p-3 text-sm"
                                placeholder="Alamat saat menjalankan cuti..." required>{{ old('alamat') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. Telepon/WA</label>
                            <input type="text" name="no_telepon" value="{{ $user->pegawai->no_telepon ?? 'Belum Diatur' }}"
                                class="w-full border border-slate-300 rounded-lg p-3 text-sm cursor-not-allowed"
                                readonly>
                        </div>
                    </div>
                </div>

                {{-- SEKSI IV: Pejabat Penilai --}}
                <div class="mb-8 border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-bold text-blue-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-blue-100 flex items-center justify-center text-xs">IV</span>
                        Pejabat Penilai (Atasan)
                    </h3>

                    <div class="relative">
                        <input type="hidden" name="id_atasan" id="input_id_atasan"
                            value="{{ old('id_atasan', $atasan_sekarang->id ?? '') }}" required>
                        <button type="button" onclick="toggleAtasanDropdown()"
                            class="w-full inline-flex items-center justify-between text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 font-medium rounded-lg text-sm px-4 py-3 transition shadow-sm">
                            <span id="label_id_atasan" class="truncate pr-4">
                                @if($atasan_sekarang)
                                {{ $atasan_sekarang->nama }} | {{ $atasan_sekarang->nip }}
                                @else
                                -- Pilih Pejabat --
                                @endif
                            </span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 9-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="dropdown_id_atasan"
                            class="hidden absolute z-10 w-full bg-white border border-slate-200 rounded-lg shadow-xl mt-1 max-h-64 overflow-y-auto border-t-4 border-t-blue-500">
                            <ul class="p-2 text-sm text-slate-700">
                                @foreach($atasans as $boss)
                                <li>
                                    <button type="button"
                                        onclick="pilihAtasan('{{ $boss->id }}', '{{ $boss->nama }} | {{ $boss->nip }}')"
                                        class="w-full px-4 py-3 hover:bg-blue-50 rounded-xl text-left flex items-center gap-3 transition mb-1">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shrink-0 shadow-sm">
                                            {{ strtoupper(substr($boss->nama, 0, 1)) }}
                                        </div>
                                        <div class="flex flex-col overflow-hidden">
                                            <span class="font-bold text-slate-900 truncate leading-tight">{{ $boss->nama
                                                }}</span>
                                            <span
                                                class="text-[11px] text-slate-500 font-medium uppercase tracking-tighter">{{
                                                $boss->pegawai->jabatan ?? '-' }}</span>
                                            <span class="text-[10px] text-blue-600 font-mono">{{ $boss->nip }}</span>
                                        </div>
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Seksi V: Verifikasi dan Tanda Tangan --}}
                <div class="mb-8 border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-bold text-blue-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-blue-100 flex items-center justify-center text-xs">V</span>
                        Verifikasi & Tanda Tangan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- signature pad --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanda Tangan Digital <span
                                    class="text-red-500">*</span></label>
                            <div class="border-2 border-dashed border-s-slate-300 rounded-xl p-2 bg-slate-50">
                                <canvas id="signature-pad"
                                    class="w-full h-40 bg-white rounded-lg border border-slate-200"></canvas>
                            </div>
                            <button type="button" id="clear-signature"
                                class="mt-2 text-xs font-semibold text-red-500 hover:text-red-700">
                                ❌ Hapus & Tanda Tangan Ulang
                            </button>

                            {{-- input hidden untuk menyimpan data gambar ttd --}}
                            <input type="hidden" name="ttd_image" id="ttd_image" value="{{ old('ttd_image') }}">
                        </div>

                        {{-- password verification --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password <span
                                    class="text-red-500">*</span></label>
                            <p class="text-xs text-slate-500 mb-3 italic">Silahkan masukkan password akun Anda untuk
                                mengonfirmasi pengajuan ini.</p>
                            <input type="password" name="password_verifikasi"
                                class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan password Anda..." required>
                        </div>
                    </div>
                </div>

                {{-- Lampiran --}}
                <div class="mb-8 border-t border-slate-200 pt-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lampiran Dokumen Pendukung (PDF/JPG, Maks
                        2MB)</label>
                    <input type="file" name="bukti"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition" />
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('pegawai.dashboard') }}"
                        class="px-6 py-3 bg-white text-slate-700 font-bold rounded-xl border border-slate-300 hover:bg-slate-50 transition">Batal</a>
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition transform hover:-translate-y-1">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    // Inisiasi Signature pad
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgba(255, 255, 255, 0)',
        penColor: 'rgb(0, 0, 0)'
    });

    function resizeCanvas(){
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
    
        // Simpan data tanda tangan jika sudah ada isinya
        const data = signaturePad.toData();
        
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        
        // Kembalikan data tanda tangan setelah resize agar tidak hilang
        signaturePad.clear();
        signaturePad.fromData(data);
    }

    window.onresize = resizeCanvas;
    resizeCanvas();

    signaturePad.addEventListener("endStroke", () => {
        const dataURL = signaturePad.toDataURL('image/png');
        document.getElementById('ttd_image').value = dataURL;
    });

    // tombol hapus ttd
    document.getElementById('clear-signature').addEventListener('click', () => {
        signaturePad.clear();
        document.getElementById('ttd_image').value = ''; // Kosongkan input
    });

    // data ttd ke input hidden
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        // Jika canvas kosong DAN input hidden kosong
        if (signaturePad.isEmpty() && document.getElementById('ttd_image').value === '') {
            e.preventDefault(); // Stop form dikirim
            alert("Harap bubuhkan tanda tangan terlebih dahulu!");
            return false;
        }

        // Jika lolos, pastikan sekali lagi nilainya terisi sebelum benar-benar terkirim
        document.getElementById('ttd_image').value = signaturePad.toDataURL('image/png');
    });

    // Toggle Dropdown Jenis Cuti
    function toggleCutiDropdown() {
        const dd = document.getElementById("dropdown_jenis_cuti");
        dd.classList.toggle("hidden");
        document.getElementById("dropdown_id_atasan").classList.add("hidden");
    }

    function pilihJenisCuti(id, nama) {
        document.getElementById("input_jenis_cuti").value = id;
        document.getElementById("label_jenis_cuti").innerText = nama;
        document.getElementById("dropdown_jenis_cuti").classList.add("hidden");
    }

    // Toggle Dropdown Atasan
    function toggleAtasanDropdown() {
        const dd = document.getElementById("dropdown_id_atasan");
        dd.classList.toggle("hidden");
        document.getElementById("dropdown_jenis_cuti").classList.add("hidden");
    }

    function pilihAtasan(id, text) {
        document.getElementById("input_id_atasan").value = id;
        document.getElementById("label_id_atasan").innerText = text;
        document.getElementById("dropdown_id_atasan").classList.add("hidden");
    }

    // Hitung Durasi (Skip Akhir Pekan)
    function hitungDurasi() {
        const start = document.getElementById("tgl_mulai").value;
        const end = document.getElementById("tgl_selesai").value;
        const teks = document.getElementById("durasi_teks");
        
        if (start && end) {
            let dStart = new Date(start);
            let dEnd = new Date(end);
            let count = 0;

            if (dEnd < dStart) {
                teks.innerText = "Tanggal selesai tidak valid!";
                teks.classList.add("text-red-600");
                teks.classList.remove("text-blue-900");
                return;
            }

            teks.classList.remove("text-red-600");
            teks.classList.add("text-blue-900");
            let cur = new Date(dStart);
            while (cur <= dEnd) {
                let day = cur.getDay();
                if (day !== 0 && day !== 6) count++; 
                cur.setDate(cur.getDate() + 1);
            }
            teks.innerText = `Total: ${count} Hari Kerja (Senin - Jumat).`;
        }
    }

    // Tutup dropdown klik luar
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.getElementById("dropdown_jenis_cuti").classList.add("hidden");
            document.getElementById("dropdown_id_atasan").classList.add("hidden");
        }
    });
</script>
@endpush