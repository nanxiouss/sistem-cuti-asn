<x-layouts.admin.app>
    <x-slot:title>Detail Informasi Pegawai - E-CUTI</x-slot:title>

    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.pegawai.index') }}" class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition flex items-center gap-2 mb-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <h2 class="text-2xl font-bold text-slate-800">Profil Detail Pegawai</h2>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.pegawai.edit', $user->id) }}" class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 font-semibold text-sm transition flex items-center gap-2">
                <i class="fas fa-edit"></i> Edit Akun
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KARTU UTAMA MINI PROFIL --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center text-center">
            <div class="w-24 h-24 rounded-2xl bg-indigo-50 text-indigo-600 font-extrabold text-3xl flex items-center justify-center shadow-xs mb-4">
                {{ substr($user->nama, 0, 1) }}
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $user->nama }}</h3>
            <p class="text-sm text-slate-400 font-mono mb-4">{{ $user->nip }}</p>
            
            <span class="px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider border border-indigo-100 mb-6">
                Role: {{ str_replace('_', ' ', $user->role) }}
            </span>

            <div class="w-full border-t border-slate-100 pt-6 grid grid-cols-2 gap-4">
                <div class="bg-slate-50 p-3 rounded-2xl text-center">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mb-1">Sisa Cuti Tahunan</p>
                    <p class="text-lg font-bold text-slate-700">{{ $user->pegawai->sisa_cuti_tahunan ?? 0 }} <span class="text-xs font-normal text-slate-400">Hari</span></p>
                </div>
                <div class="bg-slate-50 p-3 rounded-2xl text-center">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mb-1">Sisa Cuti Besar</p>
                    <p class="text-lg font-bold text-slate-700">{{ $user->pegawai->sisa_cuti_besar ?? 0 }} <span class="text-xs font-normal text-slate-400">Hari</span></p>
                </div>
                <div class="bg-slate-50 p-3 rounded-2xl text-center">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mb-1">Sisa Cuti Melahirkan</p>
                    <p class="text-lg font-bold text-slate-700">{{ $user->pegawai->sisa_cuti_melahirkan ?? 0 }} <span class="text-xs font-normal text-slate-400">Hari</span></p>
                </div>
                <div class="bg-slate-50 p-3 rounded-2xl text-center">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mb-1">Masa Kerja CPNS</p>
                    <p class="text-sm font-bold text-slate-700 mt-1">
                        {{ $user->pegawai?->masa_kerja ? \Carbon\Carbon::parse($user->pegawai->masa_kerja)->translatedFormat('M Y') : '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- DETAIL DATA STRUKTURAL --}}
        <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <h3 class="font-bold text-slate-800 text-base flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fas fa-id-card text-indigo-500"></i> Informasi Lengkap Kepegawaian
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $user->nama }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Induk Pegawai (NIP)</p>
                    <p class="text-sm font-mono font-semibold text-slate-800">{{ $user->nip }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jabatan Struktural</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $user->pegawai->jabatan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kluster Penempatan Bidang Kerja</p>
                    <p class="text-sm font-semibold text-indigo-600">{{ $user->pegawai->bidang->nama_bidang ?? 'Instansi Utama / Tanpa Bidang' }}</p>
                </div>
                
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pangkat / Golongan</p>
                    <p class="text-sm font-semibold text-slate-800">
                        @if($user->pegawai?->pangkat)
                            {{ $user->pegawai->pangkat->nama_pangkat }} ({{ $user->pegawai->pangkat->golongan }}/{{ $user->pegawai->pangkat->ruang }})
                        @else
                            <span class="text-slate-400 italic">-</span>
                        @endif
                    </p>
                </div>
                
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Atasan Penanggung Jawab Cuti</p>
                    <p class="text-sm font-semibold text-slate-700">
                        @if($user->pegawai?->atasan)
                            <span class="text-slate-800 font-bold">{{ $user->pegawai->atasan->nama }}</span> 
                            <span class="text-xs text-slate-400">({{ strtoupper($user->pegawai->atasan->role) }})</span>
                        @else
                            <span class="text-slate-400 italic">Tidak terikat atasan (Otomatisasi Mandiri)</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Mulai Kerja CPNS</p>
                    <p class="text-sm font-semibold text-slate-800">
                        {{ $user->pegawai?->masa_kerja ? \Carbon\Carbon::parse($user->pegawai->masa_kerja)->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Kontak HP/WA</p>
                    <p class="text-sm font-semibold text-slate-800">
                        @if($user->pegawai?->no_telepon)
                            @php
                                $nomorWa = preg_replace('/[^0-9]/', '', $user->pegawai->no_telepon);
                                if (str_starts_with($nomorWa, '0')) {
                                    $nomorWa = '62' . substr($nomorWa, 1);
                                } elseif (!str_starts_with($nomorWa, '62')) {
                                    $nomorWa = '62' . $nomorWa;
                                }
                            @endphp
                            <a href="https://wa.me/{{ $nomorWa }}" target="_blank" class="text-emerald-600 hover:underline flex items-center gap-1">
                                <i class="fab fa-whatsapp"></i> +62 {{ preg_replace('/^62|^0/', '', $user->pegawai->no_telepon) }}
                            </a>
                        @else
                            <span class="text-slate-400 italic">-</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
    </div>
</x-layouts.admin.app>