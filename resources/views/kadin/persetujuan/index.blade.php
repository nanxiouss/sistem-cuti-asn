<x-layouts.kadin.app>
    <x-slot:title>Daftar Antrean Berkas - Kepala Dinas</x-slot:title>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Title --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-950 tracking-tight">Persetujuan Cuti (Kepala Dinas)</h1>
                    <p class="text-sm text-slate-500 mt-1">Daftar verifikasi akhir berkas yang telah diproses Sekretaris Dinas sebelum diteruskan ke tahap pemberkasan.</p>
                </div>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm">
                <i class="fas fa-check-circle text-lg text-emerald-500"></i>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            @endif

            {{-- Alert Error --}}
            @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-center gap-3 shadow-sm">
                <i class="fas fa-exclamation-circle text-lg text-rose-500"></i>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
            @endif

            {{-- Main Card/Table --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2.5">
                        <i class="fas fa-folder-open text-red-500 text-lg"></i> 
                        Meja Kerja Kepala Dinas <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-xs rounded-md font-extrabold">{{ $pengajuan->count() }}</span>
                    </h3>
                </div>

                <div class="overflow-x-auto hide-scrollbar">
                    <table class="w-full text-left text-sm whitespace-nowrap border-collapse">
                        <thead class="bg-slate-50/70 text-slate-500 font-bold uppercase text-xs tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Nama Pegawai / Pemohon</th>
                                <th class="px-6 py-4">Asal Bidang</th>
                                <th class="px-6 py-4">Jenis Cuti</th>
                                <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                                <th class="px-6 py-4 text-center">Durasi</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($pengajuan as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $item->user->nama ?? '-' }}</div>
                                    <div class="text-xs text-slate-400 font-medium">NIP. {{ $item->user->nip ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold border border-slate-200/60">
                                        {{ $item->user->pegawai->bidang->nama_bidang ?? 'Global' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold border border-indigo-100/70">
                                        {{ $item->jenisCuti->nama_cuti ?? 'Cuti Tahunan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-600">
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->translatedFormat('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tgl_selesai)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-extrabold text-slate-900 text-center text-base">
                                    {{ $item->lama_cuti }} <span class="text-xs text-slate-400 font-normal">Hari</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kadin.persetujuan.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                                        Tinjau Berkas Kadin <i class="fas fa-chevron-right text-[10px] text-red-400"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <i class="fas fa-circle-check text-5xl text-slate-200"></i>
                                        <p class="font-medium text-slate-700">Semua berkas meja Kepala Dinas selesai diproses</p>
                                        <p class="text-xs text-slate-400">Tidak ada pengajuan baru yang tertahan di meja Kadin.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-layouts.kadin.app>