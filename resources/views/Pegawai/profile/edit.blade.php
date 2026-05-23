<x-layouts.pegawai.app>
    <div class="w-full max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-6" x-data="{
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

        {{-- Breadcrumb --}}
        <nav class="flex mb-6 text-sm text-slate-500 font-medium">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('pegawai.dashboard') }}" class="hover:text-lime-600 transition-colors">Home</a></li>
                <li><span class="mx-2 text-slate-400">/</span></li>
                <li><a href="#" class="hover:text-lime-600 transition-colors">Profil Saya</a></li>
                <li><span class="mx-2 text-slate-400">/</span></li>
                <li class="text-slate-800 font-bold">Edit Profil & TTD</li>
            </ol>
        </nav>

        {{-- Notifikasi Sukses Berhasil Simpan --}}
        @if(session('status') === 'profile-updated')
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-medium flex items-center gap-3 shadow-sm shadow-emerald-100">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Profil dan berkas kedinasan Anda berhasil diperbarui!</span>
        </div>
        @endif

        {{-- Notifikasi Error/Sukses Umum --}}
        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-800 text-sm font-medium flex flex-col gap-1 shadow-sm shadow-red-100">
            <span class="font-bold flex items-center gap-2 text-red-700 text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Gagal memperbarui data:
            </span>
            <ul class="list-disc list-inside pl-1 text-xs space-y-0.5 text-red-600">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- FORM UTAMA --}}
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col lg:flex-row gap-6 xl:gap-8 items-start">
            @csrf
            @method('PATCH') {{-- DIUBAH MENJADI PATCH AGAR SESUAI DENGAN WEB.PHP --}}

            {{-- KOLOM KIRI: Upload Media (Foto & TTD) --}}
            <div class="w-full lg:w-[320px] xl:w-[350px] flex-shrink-0 space-y-6">

                {{-- Card Upload Foto Profil --}}
                <div class="bg-white rounded-3xl shadow-xl shadow-lime-500/5 border border-slate-200/60 p-6 text-center">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 tracking-tight uppercase">Foto Profil</h3>

                    <div class="relative w-32 h-32 mx-auto mb-4">
                        {{-- Batasan Tampilan Preview Foto --}}
                        <div class="w-full h-full rounded-full ring-4 ring-lime-500/20 p-1 bg-white overflow-hidden shadow-inner flex items-center justify-center border border-slate-200">
                            <template x-if="profilePreview">
                                <img :src="profilePreview" class="w-full h-full rounded-full object-cover">
                            </template>
                            <template x-if="!profilePreview">
                                <div class="w-full h-full bg-slate-100 rounded-full flex items-center justify-center">
                                    <span class="text-4xl font-bold text-slate-300">{{ substr(Auth::user()->nama, 0, 1) }}</span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <label class="block cursor-pointer bg-slate-50 hover:bg-lime-50 hover:text-lime-700 text-slate-600 font-semibold text-xs py-2 px-4 rounded-xl border border-dashed border-slate-300 hover:border-lime-400 transition-all">
                        <span class="flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Pilih Foto Baru
                        </span>
                        <input type="file" name="foto_profil" class="hidden" accept="image/png, image/jpeg, image/jpg" @change="previewFile($event, 'profile')">
                    </label>
                    <p class="text-[10px] text-slate-400 mt-2">Format: JPG, JPEG, PNG. Maks: 2MB</p>
                </div>

                {{-- Card Upload Tanda Tangan Digital --}}
                <div class="bg-white rounded-3xl shadow-xl shadow-lime-500/5 border border-slate-200/60 p-6 text-center">
                    <h3 class="text-sm font-bold text-slate-800 mb-2 tracking-tight uppercase">Berkas Tanda Tangan</h3>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed">Gunakan gambar berlatar belakang transparan/putih bersih.</p>

                    <div class="w-full h-36 border border-dashed border-slate-200 rounded-2xl bg-slate-50/50 mb-4 p-4 flex items-center justify-center overflow-hidden">
                        <template x-if="ttdPreview">
                            <img :src="ttdPreview" class="max-h-full max-w-full object-contain mix-blend-multiply">
                        </template>
                        <template x-if="!ttdPreview">
                            <div class="text-slate-400 text-xs flex flex-col items-center gap-1.5">
                                <svg class="w-8 h-8 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                <span>Belum ada tanda tangan</span>
                            </div>
                        </template>
                    </div>

                    <label class="block cursor-pointer bg-slate-50 hover:bg-lime-50 hover:text-lime-700 text-slate-600 font-semibold text-xs py-2 px-4 rounded-xl border border-dashed border-slate-300 hover:border-lime-400 transition-all">
                        <span class="flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Unggah Gambar TTD
                        </span>
                        <input type="file" name="foto_ttd" class="hidden" accept="image/png, image/jpeg, image/jpg" @change="previewFile($event, 'ttd')">
                    </label>
                    <p class="text-[10px] text-slate-400 mt-2">Format: PNG disukai (tanpa background). Maks: 2MB</p>
                </div>

            </div>

            {{-- KOLOM KANAN: Formulir Data Kontekstual (Isian Teks) --}}
            <div class="flex-1 min-w-0 w-full space-y-6">

                {{-- Card Data Utama --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-6 xl:p-8">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h3 class="text-base font-bold text-slate-800 tracking-tight">Informasi Utama Pegawai</h3>
                        <p class="text-xs text-slate-500">Isian data dasar akun dan komunikasi aktif Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Input Nama --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-700">Nama Lengkap Pegawai <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', Auth::user()->nama) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:border-lime-500 focus:ring-4 focus:ring-lime-500/10 transition-all outline-none" required>
                        </div>

                        {{-- Input No Telepon --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-700">Nomor WhatsApp / Telepon Aktif <span class="text-red-500">*</span></label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon', Auth::user()->pegawai->no_telepon ?? '') }}" placeholder="Contoh: 081234567890" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:border-lime-500 focus:ring-4 focus:ring-lime-500/10 transition-all outline-none" required>
                        </div>

                        {{-- NIP (Read Only) --}}
                        <div class="flex flex-col gap-1.5 opacity-70">
                            <label class="text-xs font-bold text-slate-600 flex items-center gap-1.5">
                                NIP (Nomor Induk Pegawai)
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </label>
                            <input type="text" value="{{ Auth::user()->nip }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-500 cursor-not-allowed select-none outline-none" readonly>
                        </div>

                        {{-- Role Hak Akses (Read Only) --}}
                        <div class="flex flex-col gap-1.5 opacity-70">
                            <label class="text-xs font-bold text-slate-600 flex items-center gap-1.5">
                                Hak Akses Sistem (Role)
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </label>
                            <input type="text" value="{{ strtoupper(Auth::user()->role) }}" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-500 cursor-not-allowed select-none outline-none" readonly>
                        </div>
                    </div>
                </div>

                {{-- Card Data Kepegawaian --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-6 xl:p-8">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h3 class="text-base font-bold text-slate-800 tracking-tight">Struktur Kedinasan</h3>
                        <p class="text-xs text-slate-500">Lengkapi data kepangkatan resmi Anda demi sinkronisasi format surat cuti instansi.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Pangkat / Golongan --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-700">Pangkat / Golongan Ruang</label>
                            <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan', Auth::user()->pegawai->pangkat_golongan ?? '') }}" placeholder="Contoh: Penata / III c" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:border-lime-500 focus:ring-4 focus:ring-lime-500/10 transition-all outline-none">
                        </div>

                        {{-- Nama Jabatan --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-700">Nama Jabatan Resmi</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan', Auth::user()->pegawai->jabatan ?? '') }}" placeholder="Contoh: Pranata Komputer Ahli Pertama" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:border-lime-500 focus:ring-4 focus:ring-lime-500/10 transition-all outline-none">
                        </div>

                        {{-- Unit Kerja --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-700">Unit Kerja / Bidang / Seksi</label>
                            <input type="text" name="unit_kerja" value="{{ old('unit_kerja', Auth::user()->pegawai->unit_kerja ?? '') }}" placeholder="Contoh: Sub Bagian Umum dan Kepegawaian" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:border-lime-500 focus:ring-4 focus:ring-lime-500/10 transition-all outline-none">
                        </div>

                        {{-- TMT Kerja --}}
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-700">TMT Kerja (Terhitung Mulai Tanggal)</label>
                            <input type="date" name="tmt_kerja" value="{{ old('tmt_kerja', Auth::user()->pegawai->tmt_kerja ?? '') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:border-lime-500 focus:ring-4 focus:ring-lime-500/10 transition-all outline-none">
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi Simpan Form --}}
                <div class="flex items-center justify-end gap-3 bg-slate-50 border border-slate-200/60 p-4 rounded-2xl">
                    <a href="{{ route('pegawai.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-lime-600 hover:bg-lime-500 text-white text-sm font-bold py-2.5 px-6 rounded-xl shadow-md shadow-lime-600/10 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan Profil
                    </button>
                </div>

            </div>
        </form>

    </div>
</x-layouts.pegawai.app>
