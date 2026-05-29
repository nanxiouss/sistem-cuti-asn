<x-layouts.admin.app>
    <x-slot:title>Data Pegawai - E-CUTI</x-slot:title>

    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Data Pegawai</h2>
            <p class="text-slate-500 text-sm">Manajemen akun, peran, dan pengelompokan bidang kerja pegawai.</p>
        </div>
        <a href="{{ route('admin.pegawai.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-full text-sm font-bold transition shadow-lg shadow-indigo-200 flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Pegawai
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 text-sm font-semibold">
        <i class="fas fa-check-circle text-lg"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Alert Error --}}
    @if($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-semibold">
        <div class="flex items-center gap-3 mb-1">
            <i class="fas fa-exclamation-circle text-lg"></i>
            <span>Terjadi kesalahan pengolahan data:</span>
        </div>
        <ul class="list-disc pl-8 font-normal">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jabatan / Bidang</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">TMT Kerja</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Sisa Cuti</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Role Akses</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($user as $u)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex shrink-0 items-center justify-center text-indigo-600 font-bold text-sm">
                                    {{ substr($u->nama, 0, 1) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.pegawai.show', $u->id) }}" class="text-sm font-bold text-slate-800 hover:text-indigo-600 transition">{{ $u->nama }}</a>
                                    <p class="text-xs text-slate-400 font-mono">{{ $u->nip }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-700">{{ $u->pegawai->jabatan ?? '-' }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">
                                {{ $u->pegawai->bidang->nama_bidang ?? 'Tanpa Bidang/Instansi Utama' }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">
                                {{ $u->pegawai->tmt_kerja ? \Carbon\Carbon::parse($u->pegawai->tmt_kerja)->translatedFormat('d M Y') : '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                {{ $u->pegawai->sisa_cuti_tahunan ?? 0 }} Hari
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $roleClasses = [
                                    'admin' => 'bg-purple-50 text-purple-600 border-purple-100',
                                    'kadin' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'sekdin' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                    'kabid' => 'bg-sky-50 text-sky-600 border-sky-100',
                                    'kasubbag_umum' => 'bg-pink-50 text-pink-600 border-pink-100',
                                    'kasi' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'pegawai' => 'bg-slate-50 text-slate-600 border-slate-100',
                                ];
                                $currentClass = $roleClasses[$u->role] ?? 'bg-slate-50 text-slate-600';
                            @endphp
                            <span class="px-3 py-1 border rounded-full text-[10px] font-bold uppercase tracking-wider {{ $currentClass }}">
                                {{ str_replace('_', ' ', $u->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{-- PERUBAHAN: Bagian Aksi Menjadi Tombol Teks --}}
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('admin.pegawai.show', $u->id) }}" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 rounded-lg text-xs font-bold transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.pegawai.edit', $u->id) }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 rounded-lg text-xs font-bold transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.pegawai.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pegawai ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 rounded-lg text-xs font-bold transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">
                            <i class="fas fa-users block text-3xl text-slate-200 mb-2"></i>
                            Belum ada data pegawai yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin.app>