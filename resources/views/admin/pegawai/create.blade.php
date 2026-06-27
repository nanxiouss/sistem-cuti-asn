<x-layouts.admin.app>
    <x-slot:title>Tambah Pegawai Baru - E-CUTI</x-slot:title>

    {{-- BYPASS CUSTOM STYLING TOM SELECT UNTUK TAILWIND CDN --}}
    <style>
        .ts-wrapper .ts-control {
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            border-radius: 0.75rem !important;
            border: 1px solid #e2e8f0 !important;
            background-color: rgba(248, 250, 252, 0.5) !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.875rem !important;
            color: #1e293b !important;
            min-height: 46px !important;
        }

        .ts-wrapper.focus .ts-control {
            background-color: #ffffff !important;
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
        }

        .ts-wrapper .ts-control input {
            font-size: 0.875rem !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            background: transparent !important;
            width: 100% !important;
        }

        .ts-wrapper .ts-control input:focus {
            ring: none !important;
            box-shadow: none !important;
            outline: none !important;
        }

        .ts-dropdown {
            position: absolute !important;
            z-index: 9999 !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            border-radius: 1rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            margin-top: 5px !important;
            padding: 4px !important;
        }

        .ts-dropdown .optgroup-header {
            font-size: 0.75rem !important;
            font-weight: 800 !important;
            letter-spacing: 0.05em !important;
            color: #4f46e5 !important;
            background: #f8fafc !important;
            padding: 6px 10px !important;
            border-radius: 0.5rem !important;
            margin-top: 4px !important;
        }

        .ts-dropdown .option {
            padding: 8px 12px !important;
            font-size: 0.875rem !important;
            color: #334155 !important;
            cursor: pointer !important;
            border-radius: 0.5rem !important;
        }

        .ts-dropdown .active {
            background-color: #4f46e5 !important;
            color: #ffffff !important;
        }

        .ts-wrapper .items {
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
        }

    </style>

    <div class="mb-8">
        <a href="{{ route('admin.pegawai.index') }}" class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition inline-flex items-center gap-2 mb-2 group">
            <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i> Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Tambah Pegawai Baru</h2>
        <p class="text-slate-500 text-sm">Daftarkan akun autentikasi sistem beserta informasi struktural dinas pegawai.</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-600 text-sm">
        <div class="flex items-center gap-2 font-bold mb-1.5 text-rose-700">
            <i class="fas fa-exclamation-circle text-base"></i>
            <span>Gagal Menyimpan Pegawai Baru:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-500 pl-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.pegawai.store') }}" method="POST" class="space-y-6 max-w-4xl">
        @csrf

        {{-- BLOK 1: AUTENTIKASI --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-600 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fas fa-key"></i> Data Kredensial Login (Akun)
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">NIP Pegawai <span class="text-rose-500">*</span></label>
                    <input type="text" name="nip" value="{{ old('nip') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden" placeholder="Contoh: 199001..." maxlength="20" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden" placeholder="Contoh: Ahmad Fauzi, S.T." required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Password Akun <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden" placeholder="Minimal 6 karakter" required>
                </div>
            </div>
        </div>

        {{-- BLOK 2: DATA STRUKTURAL & DINAS --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-600 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fas fa-id-card"></i> Informasi Struktur Dinas & Kepegawaian
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Role Hak Akses Aplikasi <span class="text-rose-500">*</span></label>
                    <select name="role" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden" required>
                        <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai / Pelaksana</option>
                        <option value="kasi" {{ old('role') == 'kasi' ? 'selected' : '' }}>Kasi / Kepala Seksi</option>
                        <option value="kabid" {{ old('role') == 'kabid' ? 'selected' : '' }}>Kabid / Kepala Bidang</option>
                        <option value="kasubbag_umum" {{ old('role') == 'kasubbag_umum' ? 'selected' : '' }}>Kasubbag Umum & Kepegawaian</option>
                        <option value="sekdin" {{ old('role') == 'sekdin' ? 'selected' : '' }}>Sekretaris Dinas</option>
                        <option value="kadin" {{ old('role') == 'kadin' ? 'selected' : '' }}>Kepala Dinas (Kadin)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Unit Kerja Penempatan</label>
                    <select name="bidang_id" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden">
                        <option value="">-- Tanpa Bidang Khusus --</option>
                        @foreach($bidangs as $bidang)
                        <option value="{{ $bidang->id }}" {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>{{ $bidang->nama_bidang }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- DROP DOWN ATASAN LANGSUNG --}}
                <div class="w-full">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Atasan Langsung</label>
                    <div class="w-full">
                        <select name="atasan_id" id="select-atasan" class="w-full">
                            <option value="">-- Tanpa Atasan (Tertinggi / Sistem Otomatisasi Mandiri) --</option>
                            {{-- PIMPINAN UTAMA --}}
                            <optgroup label="PIMPINAN UTAMA (TANPA BIDANG)">
                                @foreach($atasans->where('pegawai.bidang_id', null) as $atasan)
                                <option value="{{ $atasan->id }}" {{ old('atasan_id') == $atasan->id ? 'selected' : '' }}>
                                    {{ $atasan->nama }} ({{ strtoupper($atasan->role) }}{{ $atasan->pegawai?->jabatan ? ' - ' . $atasan->pegawai->jabatan : '' }})
                                </option>
                                @endforeach
                            </optgroup>

                            {{-- GROUP BERDASARKAN BIDANG --}}
                            @foreach($bidangs as $bidang)
                            <optgroup label="{{ strtoupper($bidang->nama_bidang) }}">
                                @foreach($atasans->where('pegawai.bidang_id', $bidang->id) as $atasan)
                                <option value="{{ $atasan->id }}" {{ old('atasan_id') == $atasan->id ? 'selected' : '' }}>
                                    {{ $atasan->nama }} (NIP. {{ $atasan->nip }}{{ $atasan->pegawai?->jabatan ? ' - ' . $atasan->pegawai->jabatan : '' }})
                                </option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nama Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden" placeholder="Contoh: Analisis Ketenagalistrikan Ahli Muda">
                </div>
            </div>

            {{-- BAGIAN YANG DIRAPIKAN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                <div class="w-full">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Pangkat / Golongan Ruang</label>
                    <select name="pangkat_id" id="select-pangkat" class="w-full">
                        <option value="">-- Pilih Pangkat & Golongan Ruang --</option>
                        @foreach($pangkats as $pangkat)
                        <option value="{{ $pangkat->id }}" {{ old('pangkat_id') == $pangkat->id ? 'selected' : '' }}>
                            {{ $pangkat->nama_lengkap }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Masa Mulai Kerja CPNS</label>
                    <input type="date" name="masa_kerja" value="{{ old('masa_kerja') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden text-slate-500">
                </div>
            </div>

            {{-- BLOK KUOTA CUTI PEGAWAI --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Sisa Cuti Tahunan <span class="text-rose-500">*</span></label>
                    <input type="number" name="sisa_cuti_tahunan" value="{{ old('sisa_cuti_tahunan', 12) }}" min="0" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Kuota Cuti Besar <span class="text-rose-500">*</span></label>
                    <input type="number" name="sisa_cuti_besar" value="{{ old('sisa_cuti_besar', 90) }}" min="0" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Kuota Cuti Melahirkan <span class="text-rose-500">*</span></label>
                    <input type="number" name="sisa_cuti_melahirkan" value="{{ old('sisa_cuti_melahirkan', 90) }}" min="0" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nomor Telepon / WhatsApp Utama</label>
                    <div class="relative flex items-center">
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-hidden" placeholder="Contoh: 08123456789">
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL TOMBOL AKSI --}}
        <div class="flex items-center gap-3 justify-end pt-4">
            <a href="{{ route('admin.pegawai.index') }}" class="px-6 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-bold transition">Batal</a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition shadow-md shadow-indigo-100">Simpan Akun Pegawai</button>
        </div>
    </form>

    {{-- SCRIPTS TOM SELECT BYPASS TAILWIND --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var elementAtasan = document.getElementById('select-atasan');
            if (elementAtasan) {
                new TomSelect(elementAtasan, {
                    create: false
                    , controlInput: '<input>'
                    , render: {
                        option: function(data, escape) {
                            return '<div class="option">' + escape(data.text) + '</div>';
                        }
                        , item: function(data, escape) {
                            return '<div class="item">' + escape(data.text) + '</div>';
                        }
                    }
                });
            }

            var elementPangkat = document.getElementById('select-pangkat');
            if (elementPangkat) {
                new TomSelect(elementPangkat, {
                    create: false
                    , controlInput: '<input>'
                    , render: {
                        option: function(data, escape) {
                            return '<div class="option">' + escape(data.text) + '</div>';
                        }
                        , item: function(data, escape) {
                            return '<div class="item">' + escape(data.text) + '</div>';
                        }
                    }
                });
            }
        });

    </script>
</x-layouts.admin.app>
