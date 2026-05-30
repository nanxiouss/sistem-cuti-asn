<x-layouts.admin.app>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Daftar Pengajuan Cuti</h2>
        <p class="text-slate-500 text-sm">Verifikasi dan teruskan berkas pengajuan cuti pegawai.</p>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm">
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal & Durasi</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status Berkas</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-800">{{ $p->user->nama }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">{{ $p->user->pegawai->jabatan ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-slate-700">{{ $p->jenisCuti->nama }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($p->tgl_mulai)->format('d/m/Y') }}</p>
                            <p class="text-xs text-slate-500">{{ $p->lama_cuti }} Hari Kerja</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                // Menyesuaikan warna berdasarkan posisi flowchart
                                $badgeClass = 'bg-slate-100 text-slate-500'; // Default (misal: Menunggu Atasan)
                                
                                if($p->status == 'Menunggu Verifikasi Admin') {
                                    $badgeClass = 'bg-amber-100 text-amber-700 border border-amber-200 shadow-sm animate-pulse'; // Butuh aksi admin
                                } elseif($p->status == 'Menunggu Kasi') {
                                    $badgeClass = 'bg-blue-50 text-blue-600 border border-blue-100';
                                } elseif($p->status == 'Disetujui' || $p->status == 'Arsip Admin') {
                                    $badgeClass = 'bg-emerald-50 text-emerald-600 border border-emerald-100';
                                } elseif($p->status == 'Ditolak') {
                                    $badgeClass = 'bg-red-50 text-red-600 border border-red-100';
                                }
                            @endphp
                            <span class="px-3 py-1.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.pengajuan.show', $p->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-900 text-white text-xs font-bold rounded-full hover:bg-indigo-600 transition shadow-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <p class="text-slate-400 font-medium">Belum ada data pengajuan cuti.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin.app>