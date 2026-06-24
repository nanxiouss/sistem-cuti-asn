<x-layouts.pegawai.app>
    <x-slot:title>Formulir Pengajuan Cuti</x-slot:title>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Peringatan Belum 1 Tahun (Desain Tailwind) --}}
        @if($belumSatuTahun)
        <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 text-amber-700 rounded-r-xl shadow-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong class="font-bold">Peringatan!</strong> Anda belum bisa mengajukan cuti karena belum memenuhi syarat minimal 1 tahun masa kerja CPNS.
            </div>
        </div>
        @endif

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
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
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-bold">Terjadi Kesalahan:</span>
            </div>
            <ul class="list-disc list-inside text-sm font-medium">
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
                {{-- SATU FORM UTAMA --}}
                <form action="{{ route('pegawai.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Dashboard Kecil Saldo Cuti Gabungan --}}
                    <div class="mb-8">
                        <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wide mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Informasi Sisa Saldo Cuti Anda
                        </h2> 

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            {{-- Blok Cuti Tahunan --}}
                            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                                <p class="text-[11px] font-bold text-slate-500 uppercase mb-3">Cuti Tahunan ({{ $tahun_skrg }})</p>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-2 text-center opacity-60">
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">N-2 ({{ $tahun_skrg-2 }})</p>
                                        <p class="text-lg font-bold text-slate-400">{{ $sisa_n2 }}</p>
                                    </div>
                                    <div class="bg-lime-50 border border-lime-300 rounded-lg p-2 text-center">
                                        <p class="text-[10px] text-lime-600 font-bold uppercase mb-1">N-1 ({{ $tahun_skrg-1 }})</p>
                                        <p class="text-lg font-bold text-lime-700">{{ $sisa_n1 }}</p>
                                    </div>
                                    <div class="bg-lime-50 border border-lime-300 rounded-lg p-2 text-center">
                                        <p class="text-[10px] text-lime-600 font-bold uppercase mb-1">N ({{ $tahun_skrg }})</p>
                                        <p class="text-lg font-bold text-lime-700">{{ $sisa_n }}</p>
                                    </div>
                                    <div class="bg-amber-50 border border-amber-300 rounded-lg p-2 text-center group hover:border-amber-500 transition">
                                        <p class="text-[10px] text-amber-600 font-bold uppercase mb-1">Total</p>
                                        <p class="text-lg font-extrabold text-amber-600">{{ $sisa_total }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Blok Cuti Khusus --}}
                            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex flex-col justify-center gap-3">
                                <p class="text-[11px] font-bold text-slate-500 uppercase mb-1">Kategori Cuti Khusus</p>
                                <div class="flex items-center justify-between p-2.5 bg-purple-50 rounded-lg border border-purple-100">
                                    <span class="text-xs font-bold text-purple-700">Cuti Besar</span>
                                    <span class="text-sm font-extrabold text-purple-800">{{ $user->pegawai->sisa_cuti_besar ?? 0 }} <span class="text-[10px] font-medium">Hari</span></span>
                                </div>
                                <div class="flex items-center justify-between p-2.5 bg-pink-50 rounded-lg border border-pink-100">
                                    <span class="text-xs font-bold text-pink-700">Cuti Melahirkan</span>
                                    <span class="text-sm font-extrabold text-pink-800">{{ $user->pegawai->sisa_cuti_melahirkan ?? 0 }} <span class="text-[10px] font-medium">Hari</span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI I: Data Pegawai --}}
                    <div class="mb-8 border-t border-slate-200 pt-6">
                        <h3 class="text-sm font-bold text-lime-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-lime-100 flex items-center justify-center text-xs font-bold">I</span>
                            Data Pegawai
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Nama</label>
                                <input type="text" value="{{ $user->nama }}" class="w-full bg-slate-100 border-0 rounded-lg px-3 py-2 text-slate-700 font-bold text-sm cursor-not-allowed" readonly>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">NIP</label>
                                <input type="text" value="{{ $user->nip }}" class="w-full bg-slate-100 border-0 rounded-lg px-3 py-2 text-slate-700 text-sm cursor-not-allowed" readonly>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Jabatan</label>
                                <input type="text" value="{{ $user->pegawai->jabatan ?? 'Belum Diatur' }}" class="w-full bg-slate-100 border-0 rounded-lg px-3 py-2 text-slate-700 text-sm cursor-not-allowed" readonly>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Bidang</label>
                                <input type="text" value="{{ $user->pegawai->bidang->nama_bidang ?? 'Belum Diatur' }}" class="w-full bg-slate-100 border-0 rounded-lg px-3 py-2 text-slate-700 text-sm cursor-not-allowed" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI II: Detail Pengajuan --}}
                    <div class="mb-8 border-t border-slate-200 pt-6">
                        <h3 class="text-sm font-bold text-lime-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-lime-100 flex items-center justify-center text-xs font-bold">II</span>
                            Detail Pengajuan
                        </h3>

                        {{-- Dropdown Jenis Cuti --}}
                        <div class="mb-6 relative parent-dropdown">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Cuti <span class="text-red-500">*</span></label>
                            <input type="hidden" name="id_jenis_cuti" id="input_jenis_cuti" value="{{ old('id_jenis_cuti') }}" required>
                            <button type="button" @if($belumSatuTahun) disabled @endif onclick="toggleCutiDropdown(event)" class="w-full inline-flex items-center justify-between text-slate-700 bg-white border border-slate-300 {{ $belumSatuTahun ? 'bg-slate-100 cursor-not-allowed opacity-70' : 'hover:bg-slate-50' }} font-medium rounded-lg text-sm px-4 py-3 transition shadow-sm focus:ring-2 focus:ring-blue-500">
                                @php
                                $selectedJenisCuti = collect($jenis_cutis)->firstWhere('id', old('id_jenis_cuti'));
                                @endphp
                                <span id="label_jenis_cuti">{{ $selectedJenisCuti ? $selectedJenisCuti->nama : '-- Pilih Jenis Cuti --' }}</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                                </svg>
                            </button>
                            
                            @if(!$belumSatuTahun)
                            <div id="dropdown_jenis_cuti" class="hidden absolute z-10 w-full bg-white border border-slate-200 rounded-lg shadow-xl mt-1 max-h-64 overflow-y-auto border-t-4 border-t-blue-500">
                                <ul class="p-2 text-sm text-slate-700 font-medium">
                                    @foreach($jenis_cutis as $j)
                                    <li>
                                        <button type="button" onclick="pilihJenisCuti('{{ $j->id }}', '{{ $j->nama }}')" class="w-full px-4 py-2.5 hover:bg-blue-50 hover:text-blue-700 rounded-lg text-left flex justify-between items-center transition">
                                            <span>{{ $j->nama }}</span>
                                            @if(isset($j->kuota))
                                                @if($j->kuota > 0)
                                                <span class="text-[10px] bg-blue-100 text-blue-700 px-2.5 py-1 rounded-md font-bold tracking-wide">Sisa: {{ $j->kuota }} Hari</span>
                                                @else
                                                <span class="text-[10px] bg-red-100 text-red-600 px-2.5 py-1 rounded-md font-bold tracking-wide">Habis (0)</span>
                                                @endif
                                            @endif
                                        </button>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alasan Cuti <span class="text-red-500">*</span></label>
                            <textarea name="alasan" rows="3" @if($belumSatuTahun) disabled class="w-full bg-slate-100 border border-slate-300 text-slate-400 text-sm rounded-lg block p-3 cursor-not-allowed" @else class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3 shadow-sm" placeholder="Jelaskan alasan pengajuan anda secara singkat dan jelas..." @endif required>{{ old('alasan') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                                <input type="date" name="tgl_mulai" id="tgl_mulai" min="{{ $min_date }}" value="{{ old('tgl_mulai') }}" @if($belumSatuTahun) disabled class="w-full bg-slate-100 border border-slate-300 text-slate-400 text-sm rounded-lg p-3 cursor-not-allowed" @else class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg p-3 shadow-sm" @endif required onchange="hitungDurasi()">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Selesai <span class="text-red-500">*</span></label>
                                <input type="date" name="tgl_selesai" id="tgl_selesai" min="{{ $min_date }}" value="{{ old('tgl_selesai') }}" @if($belumSatuTahun) disabled class="w-full bg-slate-100 border border-slate-300 text-slate-400 text-sm rounded-lg p-3 cursor-not-allowed" @else class="w-full bg-white border border-slate-300 text-slate-900 text-sm rounded-lg p-3 shadow-sm" @endif required onchange="hitungDurasi()">
                            </div>
                        </div>

                        <div class="p-4 bg-lime-50 border border-lime-200 rounded-xl mb-6">
                            <span class="text-xs font-bold text-lime-800 uppercase">Kalkulasi Durasi Pengajuan:</span>
                            <p id="durasi_teks" class="text-sm text-lime-900 font-medium mt-1 italic">- Masukkan rentang tanggal di atas untuk menghitung otomatis hari kerja -</p>
                        </div>
                    </div>

                    {{-- SEKSI III: Kontak & Alamat --}}
                    <div class="mb-8 border-t border-slate-200 pt-6">
                        <h3 class="text-sm font-bold text-lime-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-lime-100 flex items-center justify-center text-xs font-bold">III</span>
                            Alamat Selama Cuti
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat" rows="2" @if($belumSatuTahun) disabled class="w-full bg-slate-100 border border-slate-300 text-slate-400 text-sm rounded-lg p-3 cursor-not-allowed" @else class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Alamat rumah/lokasi saat menjalankan cuti..." @endif required>{{ old('alamat') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">No. Telepon / WhatsApp <span class="text-red-500">*</span></label>
                                <div class="flex shadow-sm rounded-xl overflow-hidden border @error('no_telepon') border-red-400 focus-within:border-red-500 focus-within:ring-2 focus-within:ring-red-500/10 @else border-slate-200 focus-within:border-lime-500 focus-within:ring-2 focus-within:ring-lime-500/10 @enderror transition-all">
                                    <span class="inline-flex items-center px-4 bg-slate-100 border-r border-slate-200 text-sm font-semibold text-slate-500 select-none">
                                        +62
                                    </span>
                                    @php
                                        $no_telepon = old('no_telepon', Auth::user()->pegawai->no_telepon ?? '');
                                        if (str_starts_with($no_telepon, '+62')) {
                                            $no_telepon = '0' . substr($no_telepon, 3);
                                        } elseif (str_starts_with($no_telepon, '62')) {
                                            $no_telepon = '0' . substr($no_telepon, 2);
                                        }
                                    @endphp
                                    <input type="text" id="no_telepon" name="no_telepon" value="{{ $no_telepon }}" placeholder="Contoh: 081234567890" 
                                        @if($belumSatuTahun) disabled class="w-full bg-slate-100 px-4 py-2.5 sm:py-3 text-sm font-semibold text-slate-400 outline-none border-0 m-0 cursor-not-allowed" @else class="w-full bg-slate-50 px-4 py-2.5 sm:py-3 text-sm font-semibold text-slate-800 focus:bg-white outline-none border-0 m-0" @endif
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^62/, '0')" required>
                                </div>
                                @error('no_telepon')
                                    <span class="text-xs text-red-500 block mt-1 ml-1 font-medium">{{ $message }}</span>
                                @enderror
                                <p class="text-[11px] text-slate-400 mt-1 italic">Ditarik otomatis dari profil. Ubah jika ada nomor khusus selama masa cuti.</p>
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI IV: Pejabat Penilai --}}
                    <div class="mb-8 border-t border-slate-200 pt-6">
                        <h3 class="text-sm font-bold text-lime-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-lime-100 flex items-center justify-center text-xs font-bold">IV</span>
                            Pejabat Penilai (Atasan)
                        </h3>

                        <div class="relative parent-dropdown">
                            <input type="hidden" name="id_atasan" id="input_id_atasan" value="{{ old('id_atasan', $atasan_sekarang->id ?? '') }}" required>
                            <button type="button" @if($belumSatuTahun) disabled @endif onclick="toggleAtasanDropdown(event)" class="w-full inline-flex items-center justify-between text-slate-700 bg-white border border-slate-300 {{ $belumSatuTahun ? 'bg-slate-100 cursor-not-allowed opacity-70' : 'hover:bg-slate-50' }} font-medium rounded-lg text-sm px-4 py-3 transition shadow-sm focus:ring-2 focus:ring-amber-300">
                                @php
                                $selectedAtasanId = old('id_atasan', $atasan_sekarang->id ?? '');
                                $selectedAtasan = collect($atasans)->firstWhere('id', $selectedAtasanId);
                                @endphp
                                <span id="label_id_atasan" class="truncate pr-4">
                                    @if($selectedAtasan)
                                    {{ $selectedAtasan->nama }} | {{ $selectedAtasan->nip }}
                                    @else
                                    -- Pilih Pejabat yang akan memverifikasi berkas Anda --
                                    @endif
                                </span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                                </svg>
                            </button>
                            
                            @if(!$belumSatuTahun)
                            <div id="dropdown_id_atasan" class="hidden absolute z-10 w-full bg-white border border-slate-200 rounded-lg shadow-xl mt-1 max-h-64 overflow-y-auto border-t-4 border-t-amber-400">
                                <ul class="p-2 text-sm text-slate-700">
                                    @foreach($atasans as $boss)
                                    <li>
                                        <button type="button" onclick="pilihAtasan('{{ $boss->id }}', '{{ $boss->nama }} | {{ $boss->nip }}')" class="w-full px-4 py-3 hover:bg-blue-50 rounded-xl text-left flex items-center gap-3 transition mb-1 border border-transparent hover:border-blue-100">
                                            <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-bold shrink-0 shadow-sm">
                                                {{ strtoupper(substr($boss->nama, 0, 1)) }}
                                            </div>
                                            <div class="flex flex-col overflow-hidden">
                                                <span class="font-bold text-slate-900 truncate leading-tight">{{ $boss->nama }}</span>
                                                <span class="text-[11px] text-slate-500 font-medium uppercase tracking-tighter">{{ $boss->pegawai->jabatan ?? '-' }}</span>
                                                <span class="text-[10px] text-amber-600 font-mono">{{ $boss->nip }}</span>
                                            </div>
                                        </button>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Seksi V: Verifikasi dan Tanda Tangan --}}
                    <div class="mb-8 border-t border-slate-200 pt-6">
                        <h3 class="text-sm font-bold text-lime-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-lime-100 flex items-center justify-center text-xs font-bold">V</span>
                            Verifikasi & Tanda Tangan Digital
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Checkbox Penggunaan TTD QR dari Profil --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Tanda Tangan <span class="text-red-500">*</span></label>
                                @if($user->pegawai && $user->pegawai->foto_ttd)
                                <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition shadow-sm">
                                    <input type="checkbox" name="konfirmasi_ttd" id="konfirmasi_ttd" value="1" @if($belumSatuTahun) disabled class="w-5 h-5 text-amber-600 border-slate-300 rounded cursor-not-allowed" @else class="w-5 h-5 text-amber-600 border-slate-300 rounded focus:ring-amber-500 cursor-pointer" @endif required>
                                    <label for="konfirmasi_ttd" class="text-sm font-semibold text-slate-700 cursor-pointer flex-1">
                                        Saya menyetujui dokumen ini diterbitkan menggunakan **QR Code Tanda Tangan Digital** aktif dari profil saya.
                                    </label>
                                    <div class="w-16 h-16 bg-white border border-slate-200 rounded-lg flex items-center justify-center p-1 shadow-sm shrink-0">
                                        <img src="{{ asset('storage/' . $user->pegawai->foto_ttd) }}" alt="QR Code Tanda Tangan" class="max-w-full max-h-full object-contain">
                                    </div>
                                </div>
                                @else
                                <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl shadow-sm flex flex-col gap-2">
                                    <div class="flex items-center gap-2 font-bold text-sm text-amber-900">
                                        <span>⚠️ Tanda Tangan Belum Diunggah!</span>
                                    </div>
                                    <p class="text-xs text-amber-700 leading-relaxed">
                                        Anda belum mengunggah spesimen tanda tangan digital (.png) di profil Anda. Unggah tanda tangan Anda terlebih dahulu untuk membuka kunci fitur pengajuan ini.
                                    </p>
                                    <a href="/profile" target="_blank" class="text-xs font-bold text-blue-600 hover:underline mt-1 flex items-center gap-1">
                                        Pergi ke Pengaturan Profil Saya &rarr;
                                    </a>
                                </div>
                                @endif
                            </div>

                            {{-- Password Verification --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Akun <span class="text-red-500">*</span></label>
                                <p class="text-xs text-slate-500 mb-3 italic">Silahkan masukkan password login Anda untuk mengesahkan identitas pengajuan ini.</p>
                                <input type="password" name="password_verifikasi" @if($belumSatuTahun) disabled class="w-full bg-slate-100 border border-slate-300 text-slate-400 rounded-lg p-3 text-sm cursor-not-allowed" @else class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Masukkan password Anda..." @endif required>
                            </div>
                        </div>
                    </div>

                    {{-- Lampiran --}}
                    <div class="mb-8 border-t border-slate-200 pt-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lampiran Dokumen Pendukung (Opsional)</label>
                        <p class="text-[11px] text-slate-500 mb-3 italic">Format PDF/JPG/PNG maksimal 5MB. Cth: Surat Keterangan Dokter (Jika Sakit) / Bukti Pendukung Lainnya.</p>
                        <input type="file" name="bukti" accept=".pdf,.jpg,.jpeg,.png" @if($belumSatuTahun) disabled class="block w-full text-sm text-slate-400 cursor-not-allowed" @else class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition shadow-sm cursor-pointer" @endif />
                    </div>

                    {{-- ACTION BUTTONS DENGAN LOGIKA BERGANTUNG KONDISI USER --}}
                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('pegawai.dashboard') }}" class="px-6 py-3 bg-white text-slate-700 font-bold rounded-xl border border-slate-300 hover:bg-slate-50 transition">Batalkan</a>

                        @if($belumSatuTahun)
                            <button type="button" disabled class="px-6 py-3 bg-slate-300 text-slate-500 font-bold rounded-xl cursor-not-allowed shadow-none">
                                Fitur Terkunci (Belum 1 Tahun Kerja)
                            </button>
                        @elseif($user->pegawai && $user->pegawai->foto_ttd)
                            <button type="submit" class="px-6 py-3 bg-lime-600 text-white font-bold rounded-xl hover:bg-lime-700 shadow-lg shadow-lime-200 transition transform hover:-translate-y-1">
                                Kirim Formulir Pengajuan
                            </button>
                        @else
                            <button type="button" disabled class="px-6 py-3 bg-slate-300 text-slate-500 font-bold rounded-xl cursor-not-allowed shadow-none">
                                Kunci Pengajuan Terbuka Jika Ada TTD
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </main>

    @push('scripts')
    <script>
        // Toggle Dropdown Jenis Cuti
        function toggleCutiDropdown(e) {
            e.stopPropagation();
            const dd = document.getElementById("dropdown_jenis_cuti");
            if(dd) dd.classList.toggle("hidden");
            const ddAtasan = document.getElementById("dropdown_id_atasan");
            if(ddAtasan) ddAtasan.classList.add("hidden");
        }

        function pilihJenisCuti(id, nama) {
            document.getElementById("input_jenis_cuti").value = id;
            document.getElementById("label_jenis_cuti").innerText = nama;
            document.getElementById("dropdown_jenis_cuti").classList.add("hidden");
        }

        // Toggle Dropdown Atasan
        function toggleAtasanDropdown(e) {
            e.stopPropagation();
            const dd = document.getElementById("dropdown_id_atasan");
            if(dd) dd.classList.toggle("hidden");
            const ddCuti = document.getElementById("dropdown_jenis_cuti");
            if(ddCuti) ddCuti.classList.add("hidden");
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
                    teks.innerText = "Tanggal selesai tidak valid (mundur dari tanggal mulai)!";
                    teks.classList.add("text-red-600");
                    teks.classList.remove("text-blue-700", "text-lime-900", "font-bold");
                    return;
                }

                teks.classList.remove("text-red-600", "text-lime-900");
                teks.classList.add("text-blue-700", "font-bold");
                let cur = new Date(dStart);
                
                while (cur <= dEnd) {
                    let day = cur.getDay();
                    if (day !== 0 && day !== 6) count++;
                    cur.setDate(cur.getDate() + 1);
                }
                teks.innerText = `Total Kalkulasi: ${count} Hari Kerja (Libur Sabtu & Minggu Diabaikan).`;
            }
        }

        document.addEventListener("DOMContentLoaded", hitungDurasi);

        // Tutup dropdown jika klik di luar komponen
        window.addEventListener('click', function(e) {
            const dropdownCuti = document.getElementById("dropdown_jenis_cuti");
            const dropdownAtasan = document.getElementById("dropdown_id_atasan");

            if (dropdownCuti && !e.target.closest('#dropdown_jenis_cuti') && !e.target.closest('button[onclick*="toggleCutiDropdown"]')) {
                dropdownCuti.classList.add("hidden");
            }
            if (dropdownAtasan && !e.target.closest('#dropdown_id_atasan') && !e.target.closest('button[onclick*="toggleAtasanDropdown"]')) {
                dropdownAtasan.classList.add("hidden");
            }
        });
    </script>
    @endpush
</x-layouts.pegawai.app>