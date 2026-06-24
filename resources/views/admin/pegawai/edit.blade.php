<x-layouts.admin.app>
    <x-slot:title>Edit Profil Pegawai - E-CUTI</x-slot:title>

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
        <h2 class="text-2xl font-bold text-slate-800">Ubah Data: {{ $user->nama }}</h2>
        <p class="text-slate-500 text-sm">Perbarui informasi jabatan, pemindahan bidang kerja, atau ubah kata sandi akses.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-600 text-sm">
            <p class="font-bold mb-1">Mohon periksa kembali inputan Anda:</p>
            <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-500">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pegawai.update', $user->id) }}" method="POST" class="space-y-6 max-w-4xl">
        @csrf
        @method('PUT')

        {{-- BLOK 1: AUTENTIKASI --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-600 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fas fa-key"></i> Autentikasi Sistem
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">NIP Pegawai <span class="text-rose-500">*</span></label>
                    <input type="text" 
                           name="nip" 
                           value="{{ old('nip', $user->nip) }}" 
                           class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none" 
                           maxlength="20"
                           pattern="[0-9]*"
                           inputmode="numeric"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Ganti Password</label>
                    <input type="password" name="password" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none" placeholder="Kosongkan jika tidak diubah">
                </div>
            </div>
        </div>

        {{-- BLOK 2: DATA STRUKTURAL --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-600 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fas fa-id-card"></i> Penempatan & Hak Istimewa Dinas
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Role Hak Akses Aplikasi <span class="text-rose-500">*</span></label>
                    <select name="role" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none" required>
                        <option value="pegawai" {{ old('role', $user->role) == 'pegawai' ? 'selected' : '' }}>Pegawai / Staf Pelaksana</option>
                        <option value="kasi" {{ old('role', $user->role) == 'kasi' ? 'selected' : '' }}>Kasi / Kepala Seksi / Kasubbag TU</option>
                        <option value="kabid" {{ old('role', $user->role) == 'kabid' ? 'selected' : '' }}>Kabid / Kepala Bidang / Kepala UPTD</option>
                        <option value="kasubbag_umum" {{ old('role', $user->role) == 'kasubbag_umum' ? 'selected' : '' }}>Kasubbag Umum & Kepegawaian</option>
                        <option value="sekdin" {{ old('role', $user->role) == 'sekdin' ? 'selected' : '' }}>Sekretaris Dinas</option>
                        <option value="kadin" {{ old('role', $user->role) == 'kadin' ? 'selected' : '' }}>Kepala Dinas (Kadin)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Penempatan Kluster Bidang / Seksi Kerja</label>
                    <select name="bidang_id" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none">
                        <option value="">-- Tanpa Bidang Khusus (Misal: Kadin / Sekdin) --</option>
                        @foreach($bidangs as $bidang)
                            <option value="{{ $bidang->id }}" {{ old('bidang_id', $user->pegawai?->bidang_id) == $bidang->id ? 'selected' : '' }}>{{ $bidang->nama_bidang }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Atasan Langsung</label>
                    <select name="atasan_id" id="select-atasan" class="w-full outline-none">
                        <option value="">-- Tanpa Atasan (Tertinggi / Sistem Otomatisasi Mandiri) --</option>
                        
                        <optgroup label="PIMPINAN UTAMA (TANPA BIDANG)">
                            @foreach($atasans->where('pegawai.bidang_id', null) as $atasan)
                                <option value="{{ $atasan->id }}" {{ old('atasan_id', $user->pegawai?->atasan_id) == $atasan->id ? 'selected' : '' }}>
                                    {{ $atasan->nama }} ({{ strtoupper($atasan->role) }}{{ $atasan->pegawai?->jabatan ? ' - ' . $atasan->pegawai->jabatan : '' }})
                                </option>
                            @endforeach
                        </optgroup>

                        @foreach($bidangs as $bidang)
                            <optgroup label="{{ strtoupper($bidang->nama_bidang) }}">
                                @foreach($atasans->where('pegawai.bidang_id', $bidang->id) as $atasan)
                                    <option value="{{ $atasan->id }}" {{ old('atasan_id', $user->pegawai?->atasan_id) == $atasan->id ? 'selected' : '' }}>
                                        {{ $atasan->nama }} (NIP. {{ $atasan->nip }}{{ $atasan->pegawai?->jabatan ? ' - ' . $atasan->pegawai->jabatan : '' }})
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nama Jabatan Struktural / Fungsional</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $user->pegawai?->jabatan) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 pt-2">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Pangkat / Golongan Ruang</label>
                    <select name="pangkat_id" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none">
                        <option value="">-- Pilih Pangkat / Golongan --</option>
                        @foreach($pangkats as $pangkat)
                            <option value="{{ $pangkat->id }}" {{ old('pangkat_id', $user->pegawai?->pangkat_id) == $pangkat->id ? 'selected' : '' }}>
                                {{ $pangkat->nama_pangkat }} ({{ $pangkat->golongan }}/{{ $pangkat->ruang }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Masa Mulai Kerja CPNS</label>
                    <input type="date" name="masa_kerja" value="{{ old('masa_kerja', $user->pegawai?->masa_kerja) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none text-slate-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Sisa Cuti Tahunan <span class="text-rose-500">*</span></label>
                    <input type="number" name="sisa_cuti_tahunan" value="{{ old('sisa_cuti_tahunan', $user->pegawai?->sisa_cuti_tahunan ?? 0) }}" min="0" max="12" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Sisa Cuti Besar <span class="text-rose-500">*</span></label>
                    <input type="number" name="sisa_cuti_besar" value="{{ old('sisa_cuti_besar', $user->pegawai?->sisa_cuti_besar ?? 0) }}" min="0" max="90" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Sisa Cuti Melahirkan <span class="text-rose-500">*</span></label>
                    <input type="number" name="sisa_cuti_melahirkan" value="{{ old('sisa_cuti_melahirkan', $user->pegawai?->sisa_cuti_melahirkan ?? 0) }}" min="0" max="90" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Nomor Telepon / WhatsApp Utama</label>
                    <div class="relative flex items-center">
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->pegawai?->no_telepon ? preg_replace('/^(62|0)?/', '0', $user->pegawai->no_telepon) : '') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition outline-none" placeholder="Contoh: 08123456789">
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL TOMBOL AKSI --}}
        <div class="flex items-center gap-3 justify-end pt-4">
            <a href="{{ route('admin.pegawai.index') }}" class="px-6 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-bold transition">Batal</a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition shadow-md shadow-indigo-100">Perbarui Data</button>
        </div>
    </form>

    {{-- SCRIPTS TOM SELECT BYPASS TAILWIND --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var element = document.getElementById('select-atasan');
            if (element) {
                new TomSelect(element, {
                    create: false,
                    controlInput: '<input>',
                    render: {
                        option: function(data, escape) {
                            return '<div class="option">' + escape(data.text) + '</div>';
                        },
                        item: function(data, escape) {
                            return '<div class="item">' + escape(data.text) + '</div>';
                        }
                    }
                });
            }
        });
    </script>
</x-layouts.admin.app>