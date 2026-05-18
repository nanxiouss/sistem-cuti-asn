<x-layouts.kabid.app>
    <x-slot name="header">
        <a href="{{ route('kabid.dashboard') }}" class="text-slate-400 hover:text-slate-600 mr-4"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h2 class="font-bold text-xl text-slate-800 leading-tight inline">Review Berkas Pengajuan Cuti (Kabid)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Informasi Pegawai & Cuti</h3>
                        <p><strong>Nama:</strong> {{ $pengajuan->user->nama ?? '-' }}</p>
                        <p><strong>Jenis Cuti:</strong> {{ $pengajuan->jenisCuti->nama_cuti ?? '-' }}</p>
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->format('d M Y') }}</p>
                        <p><strong>Alasan:</strong> {{ $pengajuan->alasan ?? '-' }}</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-slate-900 rounded-2xl p-6 shadow-md text-white">
                        <h3 class="text-lg font-bold mb-4 border-b border-slate-700 pb-3">Tindakan Kabid</h3>
                        <form action="{{ route('kabid.persetujuan.update', $pengajuan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-5">
                                <label class="block text-sm text-slate-300 mb-2">Catatan Tambahan</label>
                                <textarea name="catatan" rows="3" class="w-full bg-slate-800 border-slate-700 rounded-xl text-sm text-white"></textarea>
                            </div>
                            <div class="flex flex-col gap-3">
                                <button type="submit" name="status" value="Disetujui" class="w-full py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl">
                                    SETUJUI PENGAJUAN
                                </button>
                                <button type="submit" name="status" value="Ditolak" class="w-full py-3 bg-slate-800 hover:bg-rose-600 text-white font-bold rounded-xl border border-slate-700">
                                    TOLAK BERKAS
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.kabid.app>