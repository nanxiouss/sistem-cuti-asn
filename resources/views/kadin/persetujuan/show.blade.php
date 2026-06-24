<x-layouts.kadin.app>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('kadin.persetujuan.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                Review Berkas Pengajuan Cuti (Kepala Dinas)
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Alert Error Validasi Internal Form --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm font-medium shadow-sm">
                    <div class="font-bold mb-1 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i> Gagal Memproses Berkas:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- KONTEN SEBELAH KIRI (Detail Informasi Berkas) --}}
                <div class="md:col-span-2 space-y-6">
                    
                    {{-- Informasi Pegawai --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center gap-2">
                            <i class="fas fa-user-circle text-lime-500"></i> Informasi Pegawai
                        </h3>
                        
                        <div class="flex items-center gap-5 mb-5 border-b border-slate-100 pb-5">
                            {{-- Container Foto Profil --}}
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-slate-100 shrink-0 border-2 border-white shadow-sm">
                                @if($pengajuan->user->pegawai && $pengajuan->user->pegawai->foto_profil)
                                    <img src="{{ asset('storage/' . $pengajuan->user->pegawai->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($pengajuan->user->nama ?? 'User') }}&background=E2E8F0&color=475569" alt="Default Profil" class="w-full h-full object-cover">
                                @endif
                            </div>
                            
                            {{-- Info Utama --}}
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">{{ $pengajuan->user->nama ?? '-' }}</h4>
                                <p class="text-sm text-slate-500 font-medium">NIP/NIK. {{ $pengajuan->user->pegawai->nip ?? $pengajuan->user->nip ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- Info Tambahan Bidang & Jabatan --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Asal Bidang</p>
                                <p class="font-medium text-slate-800">
                                    @if($pengajuan->user->pegawai->bidang?->parent)
                                        {{ $pengajuan->user->pegawai->bidang->nama_bidang }} 
                                        <span class="text-slate-400 font-normal">({{ $pengajuan->user->pegawai->bidang->parent->nama_bidang }})</span>
                                    @else
                                        {{ $pengajuan->user->pegawai->bidang->nama_bidang ?? '-' }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Jabatan</p>
                                <p class="font-medium text-slate-800">{{ $pengajuan->user->pegawai->jabatan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Pengajuan Cuti --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-file-alt text-lime-500"></i> Detail Pengajuan Cuti
                        </h3>
                        
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 mb-5">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-slate-600">Jenis Cuti</span>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 font-bold rounded-lg text-sm">
                                    {{ $pengajuan->jenisCuti->nama ?? $pengajuan->jenisCuti->nama_cuti ?? 'Cuti Tidak Diketahui' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-slate-600">Tanggal Pelaksanaan</span>
                                <span class="font-medium text-slate-800 text-sm">
                                    {{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->translatedFormat('d M Y') }} s/d 
                                    {{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->translatedFormat('d M Y') }}
                                    <span class="text-indigo-600 font-semibold">({{ $pengajuan->lama_cuti }} Hari Kerja)</span>
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5 border-b border-slate-100 pb-5 text-sm">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">No. WhatsApp</p>
                                <p class="font-medium text-slate-800 flex items-center gap-1">
                                    <i class="fab fa-whatsapp text-emerald-500 text-base"></i>
                                    {{ $pengajuan->no_telepon ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Alamat Selama Cuti</p>
                                <p class="font-medium text-slate-800">{{ $pengajuan->alamat_cuti ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="mb-4 text-sm">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Alasan Cuti</p>
                            <p class="text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200 italic">
                                "{{ $pengajuan->alasan ?? 'Tidak ada alasan yang dicantumkan.' }}"
                            </p>
                        </div>

                        @if($pengajuan->file_bukti)
                        <div class="mt-4">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-2">Dokumen Lampiran</p>
                            <a href="{{ asset('storage/' . $pengajuan->file_bukti) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors border border-slate-200">
                                <i class="fas fa-paperclip text-slate-500"></i> Lihat Lampiran Bukti
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- Tracking Riwayat TTD Validasi Berkas Sebelum Kadin --}}
                    
                    {{-- 1. TTD Pemohon / Pegawai --}}
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 shadow-sm transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full {{ !empty($pengajuan->ttd_pegawai) ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                <i class="fas {{ !empty($pengajuan->ttd_pegawai) ? 'fa-check-double' : 'fa-clock' }} text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-900 tracking-tight">1. Tanda Tangan Pemohon</h4>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">Status Berkas: Sudah Valid / Diajukan</p>
                            </div>
                        </div>
                        
                        <div class="text-left sm:text-right flex flex-col items-start sm:items-end w-full sm:w-auto">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-1">Spesimen TTD Pemohon</span>
                            <div class="flex items-center gap-3 mt-1 relative justify-end w-full min-h-[50px]">
                                @if(!empty($pengajuan->ttd_pegawai))
                                    <img src="{{ asset('storage/' . $pengajuan->ttd_pegawai) }}" alt="Tanda Tangan Pegawai" class="h-25 object-contain mix-blend-multiply max-w-[120px]">
                                @else
                                    <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- 2. Persetujuan Kabid --}}
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 shadow-sm transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full {{ !empty($pengajuan->ttd_kabid) ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                <i class="fas {{ !empty($pengajuan->ttd_kabid) ? 'fa-check-double' : 'fa-clock' }} text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-900 tracking-tight">2. Persetujuan Kabid</h4>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">
                                    @if($pengajuan->tgl_ttd_kabid)
                                        Disetujui pada: {{ \Carbon\Carbon::parse($pengajuan->tgl_ttd_kabid)->translatedFormat('d M Y H:i') }} WIB
                                    @else
                                        Status: Disetujui
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-left sm:text-right flex flex-col items-start sm:items-end w-full sm:w-auto">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-1">Spesimen TTD Kabid</span>
                            <div class="flex items-center gap-3 mt-1 relative justify-end w-full min-h-[50px]">
                                @if(!empty($pengajuan->ttd_kabid))
                                    <img src="{{ asset('storage/' . $pengajuan->ttd_kabid) }}" alt="Tanda Tangan Kabid" class="h-25 object-contain mix-blend-multiply max-w-[120px]">
                                @else
                                    <span class="text-[10px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded font-bold">Sistem</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($pengajuan->catatan_kabid)
                    <div class="p-4 bg-amber-50/60 border border-amber-100 rounded-2xl text-xs text-amber-900 shadow-sm">
                        <span class="font-bold flex items-center gap-1 mb-1"><i class="fas fa-comment-dots text-amber-500"></i> Catatan Kabid:</span>
                        <p class="italic">"{{ $pengajuan->catatan_kabid }}"</p>
                    </div>
                    @endif

                    {{-- 3. Persetujuan Kasubbag Umum --}}
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 shadow-sm transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full {{ !empty($pengajuan->ttd_kasubbag) ?? !empty($pengajuan->ttd_kasumum) ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                <i class="fas {{ !empty($pengajuan->ttd_kasubbag) ?? !empty($pengajuan->ttd_kasumum) ? 'fa-check-double' : 'fa-clock' }} text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-900 tracking-tight">3. Validasi Kasubbag Umum</h4>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">
                                    @if($pengajuan->tgl_ttd_kasubbag)
                                        Valid pada: {{ \Carbon\Carbon::parse($pengajuan->tgl_ttd_kasubbag)->translatedFormat('d M Y H:i') }} WIB
                                    @elseif($pengajuan->tgl_ttd_kasumum)
                                        Valid pada: {{ \Carbon\Carbon::parse($pengajuan->tgl_ttd_kasumum)->translatedFormat('d M Y H:i') }} WIB
                                    @else
                                        Status: Valid / Diteruskan
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-left sm:text-right flex flex-col items-start sm:items-end w-full sm:w-auto">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-1">Spesimen TTD Kasubbag</span>
                            <div class="flex items-center gap-3 mt-1 relative justify-end w-full min-h-[50px]">
                                @if(!empty($pengajuan->ttd_kasubbag))
                                    <img src="{{ asset('storage/' . $pengajuan->ttd_kasubbag) }}" alt="Tanda Tangan Kasubbag" class="h-25 object-contain mix-blend-multiply max-w-[120px]">
                                @elseif(!empty($pengajuan->ttd_kasumum))
                                    <img src="{{ asset('storage/' . $pengajuan->ttd_kasumum) }}" alt="Tanda Tangan Kasubbag" class="h-25 object-contain mix-blend-multiply max-w-[120px]">
                                @else
                                    <span class="text-[10px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded font-bold">Sistem</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @php 
                        $catatanKasubbag = $pengajuan->catatan_kasubbag ?? $pengajuan->catatan_kasumum; 
                    @endphp
                    @if($catatanKasubbag)
                    <div class="p-4 bg-amber-50/60 border border-amber-100 rounded-2xl text-xs text-amber-900 shadow-sm">
                        <span class="font-bold flex items-center gap-1 mb-1"><i class="fas fa-comment-dots text-amber-500"></i> Catatan Kasubbag Umum:</span>
                        <p class="italic">"{{ $catatanKasubbag }}"</p>
                    </div>
                    @endif

                    {{-- 4. Persetujuan Sekretaris Dinas (Sekdin) --}}
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 shadow-sm transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full {{ !empty($pengajuan->ttd_sekdin) ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                <i class="fas {{ !empty($pengajuan->ttd_sekdin) ? 'fa-check-double' : 'fa-clock' }} text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-900 tracking-tight">4. Persetujuan Sekretaris Dinas</h4>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">
                                    @if($pengajuan->tgl_ttd_sekdin)
                                        Disetujui pada: {{ \Carbon\Carbon::parse($pengajuan->tgl_ttd_sekdin)->translatedFormat('d M Y H:i') }} WIB
                                    @else
                                        Status: Disetujui
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-left sm:text-right flex flex-col items-start sm:items-end w-full sm:w-auto">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-1">Spesimen TTD Sekdin</span>
                            <div class="flex items-center gap-3 mt-1 relative justify-end w-full min-h-[50px]">
                                @if(!empty($pengajuan->ttd_sekdin))
                                    <img src="{{ asset('storage/' . $pengajuan->ttd_sekdin) }}" alt="Tanda Tangan Sekdin" class="h-25 object-contain mix-blend-multiply max-w-[120px]">
                                @else
                                    <span class="text-[10px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded font-bold">Sistem</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($pengajuan->catatan_sekdin)
                    <div class="p-4 bg-amber-50/60 border border-amber-100 rounded-2xl text-xs text-amber-900 shadow-sm">
                        <span class="font-bold flex items-center gap-1 mb-1"><i class="fas fa-comment-dots text-amber-500"></i> Catatan Sekdin:</span>
                        <p class="italic">"{{ $pengajuan->catatan_sekdin }}"</p>
                    </div>
                    @endif

                </div>

                {{-- KONTEN SEBELAH KANAN (Panel Aksi Form Kadin) --}}
                <div class="space-y-6">
                    <div class="bg-slate-900 rounded-2xl p-6 shadow-md text-white border border-slate-800">
                        <h3 class="text-lg font-bold text-white mb-2 border-b border-slate-800 pb-3 flex items-center gap-2">
                            <i class="fas fa-gavel text-lime-400"></i> Keputusan Akhir Kadin
                        </h3>
                        <p class="text-xs text-slate-400 mb-5 leading-relaxed">
                            Persetujuan Anda merupakan keputusan mutlak terakhir. Berkas yang disetujui akan langsung membubuhkan spesimen TTD Anda dan siap dicetak sebagai Surat Izin Cuti resmi.
                        </p>

                        <form action="{{ route('kadin.persetujuan.update', $pengajuan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-6 border-t border-slate-800 pt-4">
                                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                                    Password Verifikasi <span class="text-[10px] text-lime-400 font-normal lowercase">(wajib jika setuju)</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500 text-xs">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input type="password" name="password_verifikasi" class="w-full bg-slate-800 border-slate-700 text-white rounded-xl pl-9 pr-4 py-2 focus:ring-lime-500 focus:border-lime-500 text-xs placeholder-slate-500" placeholder="Masukkan password login Anda...">
                                </div>
                                <p class="text-[10px] text-slate-500 mt-1 leading-normal">*Guna memberikan tanda tangan elektronik hukum yang sah pada sistem.</p>
                            </div>

                            <div class="flex flex-col gap-2.5">
                                <button type="submit" name="status" value="Disetujui" class="w-full flex items-center justify-center gap-2 py-3 bg-lime-400 hover:bg-lime-500 text-slate-900 font-extrabold rounded-xl text-xs uppercase tracking-wider transition-all shadow-lg shadow-lime-400/20">
                                    <i class="fas fa-check-circle text-sm"></i> SETUJUI & BERIKAN IZIN
                                </button>
                                <button type="submit" name="status" value="Ditolak" class="w-full flex items-center justify-center gap-2 py-3 bg-slate-800 hover:bg-rose-600 text-slate-400 hover:text-white font-bold rounded-xl text-xs uppercase tracking-wider transition-all border border-slate-700 hover:border-rose-600">
                                    <i class="fas fa-times-circle text-sm"></i> Tolak Pengajuan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.kadin.app>