<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('kasi.dashboard') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                Review Berkas Pengajuan Cuti
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-user-circle text-lime-500"></i> Informasi Pegawai
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Nama Lengkap</p>
                                <p class="font-medium text-slate-800">{{ $pengajuan->user->nama ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">NIP / NIK</p>
                                <p class="font-medium text-slate-800">{{ $pengajuan->user->nip ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Unit Kerja / Seksi</p>
                                <p class="font-medium text-slate-800">{{ $pengajuan->user->pegawai->unit_kerja ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Jabatan</p>
                                <p class="font-medium text-slate-800">{{ $pengajuan->user->pegawai->jabatan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-file-alt text-lime-500"></i> Detail Pengajuan Cuti
                        </h3>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-slate-600">Jenis Cuti</span>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 font-bold rounded-lg text-sm">
                                    {{ $pengajuan->jenisCuti->nama_cuti ?? 'Cuti Tahunan' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-slate-600">Tanggal Pelaksanaan</span>
                                <span class="font-medium text-slate-800">
                                    {{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->translatedFormat('d M Y') }} s/d 
                                    {{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Alasan Cuti</p>
                            <p class="text-sm text-slate-700 bg-white p-3 rounded-lg border border-slate-200">
                                {{ $pengajuan->alasan ?? 'Tidak ada alasan yang dicantumkan.' }}
                            </p>
                        </div>

                        @if($pengajuan->file_lampiran)
                        <div class="mt-4">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-2">Dokumen Lampiran</p>
                            <a href="{{ asset('storage/' . $pengajuan->file_lampiran) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors border border-slate-200">
                                <i class="fas fa-paperclip"></i> Lihat Lampiran
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-slate-900 rounded-2xl p-6 shadow-md text-white">
                        <h3 class="text-lg font-bold text-white mb-2 border-b border-slate-700 pb-3">
                            Tindakan Kasi
                        </h3>
                        <p class="text-sm text-slate-400 mb-6">
                            Silakan berikan keputusan untuk pengajuan berkas ini. Tindakan tidak dapat dibatalkan.
                        </p>

                        <form action="{{ route('kasi.persetujuan.update', $pengajuan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-5">
                                <label class="block text-sm font-medium text-slate-300 mb-2">Catatan Tambahan (Opsional)</label>
                                <textarea name="catatan" rows="3" class="w-full bg-slate-800 border-slate-700 text-white rounded-xl focus:ring-lime-500 focus:border-lime-500 text-sm placeholder-slate-500" placeholder="Tambahkan catatan jika ditolak..."></textarea>
                            </div>

                            <div class="flex flex-col gap-3">
                                <button type="submit" name="status" value="Disetujui" class="w-full flex items-center justify-center gap-2 py-3 bg-lime-500 hover:bg-lime-600 text-slate-900 font-bold rounded-xl transition-all shadow-lg shadow-lime-500/30">
                                    <i class="fas fa-check-circle"></i> SETUJUI PENGAJUAN
                                </button>

                                <button type="submit" name="status" value="Ditolak" class="w-full flex items-center justify-center gap-2 py-3 bg-slate-800 hover:bg-rose-600 text-white font-bold rounded-xl transition-colors border border-slate-700 hover:border-rose-600">
                                    <i class="fas fa-times-circle"></i> TOLAK BERKAS
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>