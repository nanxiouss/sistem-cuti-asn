<x-layouts.admin.app>
    @php
        // Filter data berdasarkan role pemohon
        $pemberkasanPegawai = $pemberkasans->filter(function($item) {
            return !in_array($item->user->role ?? '', ['kasi', 'kasubbag_umum']);
        });

        $pemberkasanStruktural = $pemberkasans->filter(function($item) {
            return in_array($item->user->role ?? '', ['kasi', 'kasubbag_umum']);
        });
    @endphp

    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Pemberkasan Surat Cuti</h2>
            <p class="text-slate-500 text-sm">Daftar pengajuan yang telah disetujui Kepala Dinas. Rilis dokumen agar dapat diakses dan dicetak oleh pegawai.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm font-medium text-sm">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-xl shadow-sm font-medium text-sm">
        {{ session('error') }}
    </div>
    @endif

    <div class="space-y-8">
        
        {{-- ====================== BAGIAN ATAS: PEMBERKASAN PEGAWAI ====================== --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2.5">
                    <i class="fas fa-users text-indigo-500 text-lg"></i>
                    Pemberkasan Pegawai / Staf <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs rounded-md font-extrabold">{{ $pemberkasanPegawai->count() }}</span>
                </h3>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4 px-6">Pegawai</th>
                            <th class="p-4 px-6">Jenis Cuti</th>
                            <th class="p-4 px-6">Durasi</th>
                            <th class="p-4 px-6">Status Kedinasan</th>
                            <th class="p-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($pemberkasanPegawai as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 px-6">
                                <div class="font-semibold text-slate-800">{{ $item->user->nama }}</div>
                                <div class="text-xs text-slate-400">NIP. {{ $item->user->nip }}</div>
                            </td>
                            <td class="p-4 px-6 font-medium">{{ $item->jenisCuti->nama ?? $item->jenisCuti->nama_cuti ?? '-' }}</td>
                            <td class="p-4 px-6 text-xs">
                                <span class="font-bold text-blue-600 block">{{ $item->lama_cuti }} Hari Kerja</span>
                                <span class="text-slate-400">{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }}</span>
                            </td>
                            <td class="p-4 px-6">
                                @if($item->status === 'Selesai')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-[10px] uppercase font-bold border border-emerald-200 shadow-sm">
                                        Selesai (Sudah Dirilis)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 rounded-md text-[10px] uppercase font-bold border border-amber-200">
                                        Approved Kadin
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 px-6 text-center">
                                @if($item->status === 'Selesai')
                                    <a href="{{ route('admin.pemberkasan.show', $item->id) }}" class="px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-slate-800 transition shadow-sm inline-flex items-center gap-1.5">
                                        Lihat / Cetak
                                    </a>
                                @else
                                    <a href="{{ route('admin.pemberkasan.show', $item->id) }}" class="px-4 py-2 bg-blue-600 text-white font-bold text-xs rounded-xl hover:bg-blue-700 transition shadow-sm inline-flex items-center gap-1.5">
                                        Proses & Rilis &rarr;
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 italic">
                                Tidak ada antrean pemberkasan cuti pegawai saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ====================== BAGIAN BAWAH: PEMBERKASAN KASI & KASUBBAG ====================== --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2.5">
                    <i class="fas fa-user-shield text-amber-600 text-lg"></i>
                    Pemberkasan Pejabat Struktural <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-xs rounded-md font-extrabold">{{ $pemberkasanStruktural->count() }}</span>
                </h3>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4 px-6">Nama Pejabat</th>
                            <th class="p-4 px-6">Jenis Cuti</th>
                            <th class="p-4 px-6">Durasi</th>
                            <th class="p-4 px-6">Status Kedinasan</th>
                            <th class="p-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($pemberkasanStruktural as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 px-6">
                                <div class="font-semibold text-slate-800">{{ $item->user->nama }}</div>
                                <div class="text-[10px] text-amber-700 font-bold uppercase tracking-wide bg-amber-50 px-2 py-0.5 rounded-md inline-block mt-1">
                                    {{ $item->user->pegawai->jabatan ?? '-' }}
                                </div>
                            </td>
                            <td class="p-4 px-6 font-medium">{{ $item->jenisCuti->nama ?? $item->jenisCuti->nama_cuti ?? '-' }}</td>
                            <td class="p-4 px-6 text-xs">
                                <span class="font-bold text-blue-600 block">{{ $item->lama_cuti }} Hari Kerja</span>
                                <span class="text-slate-400">{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }}</span>
                            </td>
                            <td class="p-4 px-6">
                                @if($item->status === 'Selesai')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-[10px] uppercase font-bold border border-emerald-200 shadow-sm">
                                        Selesai (Sudah Dirilis)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 rounded-md text-[10px] uppercase font-bold border border-amber-200">
                                        Approved Kadin
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 px-6 text-center">
                                @if($item->status === 'Selesai')
                                    <a href="{{ route('admin.pemberkasan.show', $item->id) }}" class="px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-slate-800 transition shadow-sm inline-flex items-center gap-1.5">
                                        Lihat / Cetak
                                    </a>
                                @else
                                    <a href="{{ route('admin.pemberkasan.show', $item->id) }}" class="px-4 py-2 bg-blue-600 text-white font-bold text-xs rounded-xl hover:bg-blue-700 transition shadow-sm inline-flex items-center gap-1.5">
                                        Proses & Rilis &rarr;
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 italic">
                                Tidak ada antrean pemberkasan cuti pejabat struktural saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.admin.app>