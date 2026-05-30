<x-layouts.admin.app>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Detail Pengajuan Cuti</h2>
            <p class="text-slate-500 text-sm">Tinjau kelengkapan berkas sebelum diteruskan ke Kepala UPTD.</p>
        </div>
        <a href="{{ route('admin.pengajuan.index') }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-lg hover:bg-slate-50 transition shadow-sm">
            &larr; Kembali
        </a>
    </div>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
        <ul class="list-disc list-inside text-sm font-medium">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Data Pengajuan --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Info Pegawai --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="border-b border-slate-100 bg-slate-50/50 p-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center text-xs">I</span>
                        Data Pegawai
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->user->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">NIP</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->user->nip }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jabatan</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->user->pegawai->jabatan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Bidang</p>
                        @php
                            $bidangData = is_string($pengajuan->user->pegawai->bidang) ? json_decode($pengajuan->user->pegawai->bidang) : $pengajuan->user->pegawai->bidang;
                            $namaBidang = $bidangData->nama_bidang ?? ($pengajuan->user->pegawai->bidang ?? '-');
                        @endphp
                        <p class="font-semibold text-slate-800">{{ $namaBidang }}</p>
                    </div>
                </div>
            </div>

            {{-- Info Detail Cuti --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="border-b border-slate-100 bg-slate-50/50 p-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center text-xs">II</span>
                        Detail Cuti
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis Cuti</p>
                            <p class="font-semibold text-slate-800">{{ $pengajuan->jenisCuti->nama }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Durasi</p>
                            <p class="font-semibold text-blue-600">{{ $pengajuan->lama_cuti }} Hari Kerja</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Mulai</p>
                            <p class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Selesai</p>
                            <p class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->format('d F Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alasan Cuti</p>
                        <p class="text-sm font-medium text-slate-700 bg-slate-50 p-3 rounded-lg">{{ $pengajuan->alasan }}</p>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat & Kontak Selama Cuti</p>
                        <p class="text-sm font-medium text-slate-700">{{ $pengajuan->alamat }}</p>
                        <p class="text-sm font-medium text-slate-700 mt-1">📞 {{ $pengajuan->no_telepon }}</p>
                    </div>

                    @if($pengajuan->bukti)
                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Lampiran Berkas</p>
                        <a href="{{ asset('storage/' . $pengajuan->bukti) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-bold rounded-lg hover:bg-blue-100 transition">
                            Lihat Lampiran File
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Aksi & Status --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6">
                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Status Penilaian</h3>
                
                {{-- Tracker Status --}}
                <div class="space-y-4 mb-6 relative before:absolute before:inset-0 before:ml-2 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                    
                    {{-- ACC Atasan --}}
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-5 h-5 rounded-full border-2 border-emerald-500 bg-emerald-500 text-white shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <div class="w-[calc(100%-2rem)] md:w-[calc(50%-1.5rem)] p-3 rounded border border-emerald-100 bg-emerald-50 shadow-sm">
                            <h4 class="font-bold text-emerald-800 text-xs">Atasan Langsung</h4>
                            <p class="text-[10px] text-emerald-600 font-medium">{{ $pengajuan->atasan->nama }}</p>
                        </div>
                    </div>

                    {{-- Admin / Kasubag --}}
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        @php
                            $isAdminDone = in_array($pengajuan->status, ['Menunggu Kasi', 'Disetujui', 'Arsip Admin']);
                            $adminColor = $isAdminDone ? 'emerald' : 'amber';
                        @endphp
                        <div class="flex items-center justify-center w-5 h-5 rounded-full border-2 border-{{$adminColor}}-500 bg-{{ $isAdminDone ? 'emerald-500 text-white' : 'white' }} shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow">
                            @if($isAdminDone)
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            @else
                                <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                            @endif
                        </div>
                        <div class="w-[calc(100%-2rem)] md:w-[calc(50%-1.5rem)] p-3 rounded border border-{{$adminColor}}-200 bg-{{$adminColor}}-50 shadow-sm">
                            <h4 class="font-bold text-{{$adminColor}}-800 text-xs">Admin / Kasubag</h4>
                            <p class="text-[10px] text-{{$adminColor}}-600 font-medium">Verifikasi Berkas</p>
                        </div>
                    </div>
                </div>

                {{-- Action Area --}}
                <div class="pt-6 border-t border-slate-100">
                    @if($pengajuan->status == 'Menunggu Verifikasi Admin')
                        <form action="{{ route('admin.pengajuan.teruskan', $pengajuan->id) }}" method="POST">
                            @csrf
                            <p class="text-xs text-slate-500 mb-3 italic">Pastikan data dan lampiran (jika ada) sudah valid sebelum diteruskan ke Kepala UPTD.</p>
                            <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition transform hover:-translate-y-1 flex justify-center items-center gap-2">
                                <span>Teruskan ke Kasi &rarr;</span>
                            </button>
                        </form>
                    @elseif(in_array($pengajuan->status, ['Disetujui', 'Arsip Admin']))
                        <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-200 text-center">
                            <p class="text-sm font-bold text-emerald-700 mb-3">Pengajuan telah disetujui penuh.</p>
                            <a href="{{ route('admin.pengajuan.cetak', $pengajuan->id) }}" target="_blank" class="w-full inline-block py-2 bg-slate-900 text-white text-sm font-bold rounded-lg hover:bg-slate-800 transition">
                                🖨️ Cetak Surat Cuti
                            </a>
                        </div>
                    @else
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-center">
                            <p class="text-sm font-bold text-slate-600">Status Saat Ini:</p>
                            <span class="inline-block mt-1 px-3 py-1 bg-white border border-slate-300 rounded-md text-xs font-bold text-slate-700">
                                {{ $pengajuan->status }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin.app>