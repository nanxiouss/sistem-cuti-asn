@extends('layouts.pegawai.app')

@section('content')
<div class="relative overflow-hidden bg-white border border-slate-200 rounded-3xl p-8 mb-10 shadow-sm">
    <div
        class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-full blur-3xl opacity-60">
    </div>
    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-pink-50 rounded-full blur-3xl opacity-60"></div>

    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <div>
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-50 border border-slate-100 text-xs font-medium text-slate-500 mb-3">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
                {{ $sapaan }}, <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">{{ explode(' ',
                    $user->nama)[0] }}</span>! 👋
            </h1>
            <p class="text-slate-500 text-lg">Semoga harimu produktif dan menyenangkan.</p>

            <div class="mt-6 inline-flex items-center gap-3 p-3 bg-emerald-50/50 border border-emerald-100 rounded-2xl">
                <div
                    class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Status Kehadiran</p>
                    <p class="text-sm font-bold text-slate-800">AKTIF / MASUK KERJA</p>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-rose-50 to-pink-50 border border-pink-100 rounded-2xl p-6 relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-white text-rose-500 rounded-xl shadow-sm ring-1 ring-rose-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Informasi Penting</h3>
                        <p class="text-xs text-rose-600 font-medium">Aturan Dasar Cuti</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 space-y-3">
                <div
                    class="bg-white/60 backdrop-blur-sm p-3 rounded-xl border border-pink-100 hover:bg-white/80 transition cursor-help">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                        <span class="font-bold text-slate-800 text-sm">Cuti Tahunan (12 Hari)</span>
                    </div>
                    <p class="text-xs text-slate-600 pl-3.5 leading-relaxed">
                        Sisa cuti N-2 (2 tahun lalu) akan <b class="text-rose-600">hangus</b> otomatis jika tidak
                        digunakan.
                    </p>
                </div>
                <div
                    class="bg-white/60 backdrop-blur-sm p-3 rounded-xl border border-pink-100 hover:bg-white/80 transition cursor-help">
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                        <span class="font-bold text-slate-800 text-sm">Cuti Besar</span>
                    </div>
                    <p class="text-xs text-slate-600 pl-3.5 leading-relaxed">
                        Syarat min. 5 tahun kerja. Pengambilan ini <b class="text-rose-600">menghapus</b> jatah cuti
                        tahunan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <div
        class="bg-white p-6 rounded-3xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-start mb-6">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Sisa Cuti Tersedia</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-5xl font-extrabold text-slate-900 tracking-tight">{{ $sisa_total }}</span>
                    <span class="text-sm font-medium text-slate-500">Hari</span>
                </div>
            </div>
            <div
                class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-0 border border-slate-100 rounded-xl overflow-hidden bg-slate-50/50 mb-4">
            <div class="py-2 text-center border-r border-slate-100 group/item hover:bg-white transition">
                <p class="text-[10px] text-slate-400 font-bold">N-2</p>
                <p class="text-sm font-bold text-slate-400">{{ $sisa_n2 }}</p>
            </div>
            <div class="py-2 text-center border-r border-slate-100 group/item hover:bg-white transition">
                <p class="text-[10px] text-blue-400 font-bold">N-1</p>
                <p class="text-sm font-bold text-blue-600">{{ $sisa_n1 }}</p>
            </div>
            <div class="py-2 text-center group/item hover:bg-white transition">
                <p class="text-[10px] text-blue-400 font-bold">N ({{ $tahun_skrg }})</p>
                <p class="text-sm font-bold text-blue-600">{{ $sisa_n }}</p>
            </div>
        </div>

        <div class="relative w-full h-2 bg-slate-100 rounded-full overflow-hidden">
            <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full transition-all duration-1000 ease-out"
                style="width: {{ $persentase_sisa }}%"></div>
        </div>
    </div>

    <div
        class="bg-white p-6 rounded-3xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 group hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-start h-full flex-col">
            <div class="w-full flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Sedang Diproses</p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold text-amber-500 tracking-tight">{{ $jumlah_proses }}</span>
                        <span class="text-sm font-medium text-slate-500">Pengajuan</span>
                    </div>
                </div>
                <div
                    class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-auto w-full">
                <div class="flex items-center gap-2 px-3 py-2 bg-amber-50 rounded-lg border border-amber-100">
                    <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-medium text-amber-700">Menunggu persetujuan atasan</span>
                </div>
            </div>
        </div>
    </div>

    <div
        class="bg-white p-6 rounded-3xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 group hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-start h-full flex-col">
            <div class="w-full flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Cuti Diambil</p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold text-slate-900 tracking-tight">{{ $terpakai }}</span>
                        <span class="text-sm font-medium text-slate-500">Hari</span>
                    </div>
                </div>
                <div
                    class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-auto w-full">
                <p class="text-xs text-slate-400 font-medium text-right">Periode Tahun {{ $tahun_skrg }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Riwayat Pengajuan Terakhir</h2>
            <p class="text-sm text-slate-500 mt-1">Status pengajuan cuti terkini Anda.</p>
        </div>
        <a href="#"
            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition duration-200">
            Lihat Semua
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>

    @forelse($riwayat as $item)
    @if($loop->first)
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50 text-slate-500">
                <tr>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-wider">Tgl Pengajuan</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-wider">Jenis Cuti</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-wider">Durasi</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-wider">Status Dokumen</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @endif
                <tr class="hover:bg-blue-50/30 transition duration-150 group">
                    <td class="px-8 py-5">
                        <span class="text-sm font-semibold text-slate-900 block">{{
                            $item->created_at->translatedFormat('d F Y') }}</span>
                        <span class="text-xs text-slate-400">{{ $item->created_at->format('H:i') }} WIB</span>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-600 font-medium">
                        {{ $item->jenisCuti->nama_cuti ?? '-' }}
                    </td>
                    <td class="px-8 py-5">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-600">
                            {{ $item->lama_cuti }} Hari
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        @php
                        $statusConfig = match($item->status) {
                        'Disetujui' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' =>
                        'bg-emerald-500'],
                        'Ditolak' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'dot' => 'bg-rose-500'],
                        default => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                        };
                        @endphp
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button
                            class="text-slate-400 hover:text-blue-600 font-medium text-sm transition flex items-center justify-end gap-1 ml-auto group-hover:translate-x-[-4px]">
                            Detail
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </td>
                </tr>
                @if($loop->last)
            </tbody>
        </table>
    </div>
    @endif
    @empty
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 ring-8 ring-slate-50/50">
            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                </path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-900">Belum ada pengajuan</h3>
        <p class="text-slate-500 mt-1 max-w-xs mx-auto">Riwayat pengajuan cuti Anda akan muncul di sini setelah Anda
            melakukan pengajuan.</p>
        <button
            class="mt-6 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-blue-600/20">
            Ajukan Cuti Sekarang
        </button>
    </div>
    @endforelse
</div>
@endsection