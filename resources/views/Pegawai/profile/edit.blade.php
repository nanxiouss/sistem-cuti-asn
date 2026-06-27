<x-layouts.pegawai.app>
    <div class="w-full max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8" x-data="{
            profilePreview: '{{ Auth::user()->pegawai && Auth::user()->pegawai->foto_profil ? asset('storage/' . Auth::user()->pegawai->foto_profil) : '' }}',
            ttdPreview: '{{ Auth::user()->pegawai && Auth::user()->pegawai->foto_ttd ? asset('storage/' . Auth::user()->pegawai->foto_ttd) : '' }}',
            previewFile(event, type) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        if (type === 'profile') this.profilePreview = e.target.result;
                        if (type === 'ttd') this.ttdPreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
         }">

        {{-- Breadcrumb Dinamis & Responsive --}}
        <nav class="flex mb-6 text-xs sm:text-sm text-slate-500 font-medium overflow-x-auto hide-scrollbar whitespace-nowrap pb-2">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-lime-600 transition-colors">Home</a></li>
                <li><span class="mx-2 text-slate-400">/</span></li>
                <li><a href="{{ route('profile.index') }}" class="hover:text-lime-600 transition-colors">Profil Saya</a></li>
                <li><span class="mx-2 text-slate-400">/</span></li>
                <li class="text-slate-800 font-bold">Edit Profil & TTD</li>
            </ol>
        </nav>

        {{-- Notifikasi Sukses Berhasil Simpan --}}
        @if(session('status') === 'profile-updated')
        <div class="mb-6 p-4 sm:p-5 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-medium flex items-start sm:items-center gap-3 shadow-sm">
            <div class="p-1.5 bg-emerald-100 rounded-full shrink-0 mt-0.5 sm:mt-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="leading-relaxed">Profil dan berkas kedinasan Anda berhasil diperbarui!</span>
        </div>
        @endif

        {{-- Notifikasi Error Global --}}
        @if($errors->any())
        <div class="mb-6 p-4 sm:p-5 bg-red-50 border border-red-200 rounded-2xl text-red-800 text-sm flex items-start gap-3 shadow-sm">
            <div class="p-1.5 bg-red-100 rounded-full shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <span class="font-bold text-red-700 block mb-1">Gagal memperbarui data:</span>
                <ul class="list-disc list-inside text-xs sm:text-sm space-y-1 text-red-600">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- FORM UTAMA --}}
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col lg:flex-row gap-6 xl:gap-8 items-start">
            @csrf
            @method('PATCH')

            {{-- KOLOM KIRI: Upload Media (Foto & TTD) --}}
            <div class="w-full lg:w-80 flex-shrink-0 space-y-6">

                {{-- Card Upload Foto Profil --}}
                <div class="bg-white rounded-3xl shadow-lg shadow-slate-200/40 border border-slate-200/60 p-6 sm:p-8 text-center relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-lime-400 to-amber-300"></div>
                    
                    <h3 class="text-sm font-bold text-slate-800 mb-5 tracking-tight uppercase flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Foto Profil
                    </h3>

                    <div class="relative w-32 h-32 sm:w-36 sm:h-36 mx-auto mb-6">
                        <div class="w-full h-full rounded-full ring-4 ring-lime-100 p-1 bg-white overflow-hidden shadow-inner flex items-center justify-center border border-slate-200 transition-all duration-300 group-hover:ring-lime-200">
                            <template x-if="profilePreview">
                                <img :src="profilePreview" class="w-full h-full rounded-full object-cover">
                            </template>
                            <template x-if="!profilePreview">
                                <div class="w-full h-full bg-slate-100 rounded-full flex items-center justify-center">
                                    <span class="text-4xl sm:text-5xl font-bold text-slate-300">{{ Str::upper(substr(Auth::user()->nama, 0, 1)) }}</span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <label for="foto_profil" class="block w-full cursor-pointer bg-lime-50 hover:bg-lime-500 text-lime-700 hover:text-white font-bold text-xs sm:text-sm py-2.5 px-4 rounded-xl border border-lime-200 hover:border-lime-500 transition-all shadow-sm">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Pilih Foto Baru
                        </span>
                    </label>
                    <input type="file" id="foto_profil" name="foto_profil" class="hidden" accept="image/png, image/jpeg, image/jpg" @change="previewFile($event, 'profile')">
                    <p class="text-[11px] text-slate-400 mt-3">Format: JPG, JPEG, PNG. Maks: 5MB</p>
                    @error('foto_profil')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Card Upload Tanda Tangan Digital --}}
                <div class="bg-white rounded-3xl shadow-lg shadow-slate-200/40 border border-slate-200/60 p-6 sm:p-8 text-center relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-300 to-lime-400"></div>

                    <h3 class="text-sm font-bold text-slate-800 mb-2 tracking-tight uppercase flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Tanda Tangan
                    </h3>
                    <p class="text-xs text-slate-500 mb-5 leading-relaxed">Gunakan gambar berlatar transparan (PNG).</p>

                    <div class="w-full h-32 sm:h-36 border-2 border-dashed border-slate-200 hover:border-lime-300 transition-colors rounded-2xl bg-white mb-5 p-4 flex items-center justify-center overflow-hidden relative">
                        <template x-if="ttdPreview">
                            <img :src="ttdPreview" class="max-h-full max-w-full object-contain mix-blend-multiply drop-shadow-sm">
                        </template>
                        <template x-if="!ttdPreview">
                            <div class="text-slate-400 text-xs flex flex-col items-center gap-2">
                                <div class="p-2 bg-slate-50 rounded-full shadow-sm border border-slate-100">
                                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span>Belum ada file TTD</span>
                            </div>
                        </template>
                    </div>

                    <label for="foto_ttd" class="block w-full cursor-pointer bg-slate-50 hover:bg-slate-800 text-slate-600 hover:text-white font-bold text-xs sm:text-sm py-2.5 px-4 rounded-xl border border-slate-200 transition-all shadow-sm">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Unggah Gambar TTD
                        </span>
                    </label>
                    <input type="file" id="foto_ttd" name="foto_ttd" class="hidden" accept="image/png, image/jpeg, image/jpg" @change="previewFile($event, 'ttd')">
                    @error('foto_ttd')
                        <p class="text-xs text-red-500 mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- KOLOM KANAN: Formulir Data Kontekstual --}}
            <div class="flex-1 min-w-0 w-full flex flex-col gap-6">

                {{-- Card Data Utama (Bisa Diedit) --}}
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-200/60 p-5 sm:p-6 xl:p-8">
                    <div class="border-b border-slate-100 pb-4 mb-6 flex items-center gap-3">
                        <div class="p-2.5 bg-lime-50 rounded-xl">
                            <svg class="w-5 h-5 text-lime-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-slate-800 tracking-tight">Informasi Akun Pegawai</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Edit kontak, dan password Anda di sini.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                        {{-- Input Nama --}}
                        <div class="flex flex-col gap-1.5 md:col-span-2 opacity-70">
                            <label for="nama" class="text-xs font-bold text-slate-700 ml-1">Nama Lengkap Pegawai </label>
                            <input type="text" id="nama" name="nama" value="{{ Auth::user()->nama }}" 
                            class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 sm:py-3 text-sm font-bold text-slate-500 cursor-not-allowed select-none outline-none" readonly>
                        </div>

                        {{-- Input No Telepon --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="no_telepon" class="text-xs font-bold text-slate-700 ml-1">Nomor WhatsApp / Telepon <span class="text-red-500">*</span></label>
                            
                            {{-- Memproses nomor lama agar otomatis 08 jika awalnya 62 atau +62 --}}
                            @php
                                $no_telepon = old('no_telepon', Auth::user()->pegawai->no_telepon ?? '');
                                if (str_starts_with($no_telepon, '+62')) {
                                    $no_telepon = '0' . substr($no_telepon, 3);
                                } elseif (str_starts_with($no_telepon, '62')) {
                                    $no_telepon = '0' . substr($no_telepon, 2);
                                }
                            @endphp

                            <input type="text" id="no_telepon" name="no_telepon" value="{{ $no_telepon }}" placeholder="Contoh: 081234567890" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^62/, '0')"
                                class="w-full bg-slate-50 border @error('no_telepon') border-red-400 focus:border-red-500 focus:ring-red-500/10 @else border-slate-200 focus:border-lime-500 focus:ring-lime-500/10 @enderror rounded-xl px-4 py-2.5 sm:py-3 text-sm font-semibold text-slate-800 focus:bg-white transition-all outline-none shadow-sm" required>
                            @error('no_telepon')
                                <span class="text-xs text-red-500 ml-1 font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- NIP (Read Only) --}}
                        <div class="flex flex-col gap-1.5 opacity-70">
                            <label for="nip" class="text-xs font-bold text-slate-600 flex items-center gap-1.5 ml-1">NIP (Nomor Induk Pegawai)</label>
                            <input type="text" id="nip" value="{{ Auth::user()->nip }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 sm:py-3 text-sm font-bold text-slate-500 cursor-not-allowed select-none outline-none" readonly>
                        </div>
                    </div>
                    
                    <hr class="border-slate-100 my-6">

                    {{-- Section Ubah Password --}}
                    <h4 class="text-sm font-bold text-slate-700 mb-4">Ubah Password (Opsional)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                        <div class="flex flex-col gap-1.5">
                            <label for="password" class="text-xs font-bold text-slate-700 ml-1">Password Baru</label>
                            <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin diubah" 
                                class="w-full bg-slate-50 border @error('password') border-red-400 focus:border-red-500 focus:ring-red-500/10 @else border-slate-200 focus:border-lime-500 focus:ring-lime-500/10 @enderror rounded-xl px-4 py-2.5 sm:py-3 text-sm font-semibold text-slate-800 focus:bg-white transition-all outline-none shadow-sm">
                            @error('password')
                                <span class="text-xs text-red-500 ml-1 font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label for="password_confirmation" class="text-xs font-bold text-slate-700 ml-1">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" 
                                class="w-full bg-slate-50 border border-slate-200 focus:border-lime-500 focus:ring-4 focus:ring-lime-500/10 rounded-xl px-4 py-2.5 sm:py-3 text-sm font-semibold text-slate-800 focus:bg-white transition-all outline-none shadow-sm">
                        </div>
                    </div>
                </div>

                {{-- Card Data Kepegawaian (Terkunci / Read-Only) --}}
                <div class="bg-slate-50/70 rounded-2xl sm:rounded-3xl shadow-sm border border-slate-200/60 p-5 sm:p-6 xl:p-8">
                    <div class="border-b border-slate-200/80 pb-4 mb-6 flex items-center gap-3">
                        <div class="p-2.5 bg-slate-200/50 rounded-xl">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-slate-700 tracking-tight">Struktur Kedinasan (Terkunci)</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Data di bawah ini hanya dapat diubah oleh Admin Kepegawaian.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 opacity-80 pointer-events-none">
                        {{-- Pangkat / Golongan --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-600 ml-1">Pangkat / Golongan Ruang</label>
                            <input type="text" value="{{ Auth::user()->pegawai->pangkat->nama_pangkat ?? Auth::user()->pegawai->pangkat_golongan ?? '-' }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 sm:py-3 text-sm font-bold text-slate-500 cursor-not-allowed outline-none select-none" readonly>
                        </div>

                        {{-- Nama Jabatan --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-600 ml-1">Nama Jabatan Resmi</label>
                            <input type="text" value="{{ Auth::user()->pegawai->jabatan ?? '-' }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 sm:py-3 text-sm font-bold text-slate-500 cursor-not-allowed outline-none select-none" readonly>
                        </div>

                        {{-- Bidang --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-600 ml-1">Bidang / Sub Bagian</label>
                            <input type="text" value="{{ Auth::user()->pegawai->bidang->nama_bidang ?? Auth::user()->pegawai->bidang ?? '-' }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 sm:py-3 text-sm font-bold text-slate-500 cursor-not-allowed outline-none select-none" readonly>
                        </div>

                        {{-- Masa Mulai Kerja CPNS --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-600 ml-1">Masa Mulai Kerja CPNS</label>
                            <input type="text" value="{{ Auth::user()->pegawai && Auth::user()->pegawai->masa_kerja ? \Carbon\Carbon::parse(Auth::user()->pegawai->masa_kerja)->translatedFormat('d F Y') : '-' }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 sm:py-3 text-sm font-bold text-slate-500 cursor-not-allowed outline-none select-none" readonly>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi Simpan Form --}}
                <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 mt-2">
                    <a href="{{ route('profile.index') }}" class="w-full sm:w-auto px-6 py-2.5 text-sm font-semibold text-slate-500 hover:text-slate-800 hover:bg-slate-200 rounded-xl transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-lime-600 to-lime-500 hover:from-lime-500 hover:to-lime-400 text-white text-sm font-bold py-2.5 px-8 rounded-xl shadow-md shadow-lime-600/20 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>

    </div>

    {{-- Style Sembunyikan Scrollbar --}}
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-layouts.pegawai.app>