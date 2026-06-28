<x-layouts.admin.app>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Daftar Pengajuan Cuti</h2>
        <p class="text-slate-500 text-sm">Verifikasi dan tentukan arah berkas pengajuan cuti sesuai struktural.</p>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm">
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    @php
        // Filter koleksi data langsung di Blade berdasarkan role pemohon
        $pengajuanPegawai = $pengajuans->filter(function($p) {
            return ($p->user->role ?? '') === 'pegawai';
        });

        $pengajuanStruktural = $pengajuans->filter(function($p) {
            return in_array($p->user->role ?? '', ['kasi', 'kasubbag_umum']);
        });
    @endphp

    {{-- ================= BAGIAN ATAS: PEGAWAI / STAF BIASA ================= --}}
    <div class="mb-10 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <div>
                <h3 class="text-sm font-bold text-slate-700">Kategori Pemohon: Pegawai / Pelaksana</h3>
                <p class="text-xs text-slate-400 mt-0.5">Alur berkas setelah verifikasi: Teruskan ke Kasi.</p>
            </div>
            <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-xs font-bold">
                {{ $pengajuanPegawai->count() }} Berkas
            </span>
        </div>
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
                    @forelse($pengajuanPegawai as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-800">{{ $p->user->nama ?? '-' }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">{{ $p->user->pegawai->jabatan ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-slate-700">{{ $p->jenisCuti->nama ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($p->tgl_mulai)->format('d/m/Y') }}</p>
                            <p class="text-xs text-slate-500">{{ $p->lama_cuti }} Hari Kerja</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badgeClass = 'bg-slate-100 text-slate-500';
                                if($p->status == 'Menunggu Verifikasi Admin') {
                                    $badgeClass = 'bg-amber-100 text-amber-700 border border-amber-200 shadow-sm animate-pulse';
                                } elseif($p->status == 'Menunggu Kasi') {
                                    $badgeClass = 'bg-blue-50 text-blue-600 border border-blue-100';
                                } elseif(in_array($p->status, ['Disetujui', 'Arsip Admin', 'Selesai'])) {
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
                                Review Permohonan
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <p class="text-slate-400 font-medium">Belum ada data pengajuan cuti pegawai / staf.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= BAGIAN BAWAH: KASI & KASUBBAG UMUM ================= --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <div>
                <h3 class="text-sm font-bold text-slate-700">Kategori Pemohon: Pejabat Struktural</h3>
            </div>
            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-md text-xs font-bold">
                {{ $pengajuanStruktural->count() }} Berkas
            </span>
        </div>
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
                    @forelse($pengajuanStruktural as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-800">{{ $p->user->nama ?? '-' }}</p>
                            <p class="text-[10px] text-indigo-600 font-bold uppercase tracking-wide bg-indigo-50 px-2 py-0.5 rounded-md inline-block mt-1">
                                {{ $p->user->pegawai->jabatan ?? '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-slate-700">{{ $p->jenisCuti->nama ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($p->tgl_mulai)->format('d/m/Y') }}</p>
                            <p class="text-xs text-slate-500">{{ $p->lama_cuti }} Hari Kerja</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badgeClass = 'bg-slate-100 text-slate-500';
                                if($p->status == 'Menunggu Verifikasi Admin') {
                                    $badgeClass = 'bg-amber-100 text-amber-700 border border-amber-200 shadow-sm animate-pulse';
                                } elseif($p->status == 'Menunggu Kabid') {
                                    $badgeClass = 'bg-indigo-50 text-indigo-600 border border-indigo-100 font-semibold';
                                } elseif($p->status == 'Menunggu Sekdin') {
                                    $badgeClass = 'bg-purple-50 text-purple-600 border border-purple-100 font-semibold';
                                } elseif(in_array($p->status, ['Disetujui', 'Arsip Admin', 'Selesai'])) {
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
                                Review Permohonan
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <p class="text-slate-400 font-medium">Belum ada data pengajuan cuti Pejabat Struktural.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin.app>