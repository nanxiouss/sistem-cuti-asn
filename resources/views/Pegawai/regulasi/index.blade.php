@extends('layouts.pegawai.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-slate-900">Regulasi & Dasar Hukum</h1>
        <p class="text-slate-500 mt-2">Kumpulan peraturan terkait kepegawaian dan tata cara cuti.</p>
    </div>

    <div class="space-y-4">
        @foreach($regulasi as $group)
        <details
            class="group bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden open:ring-2 open:ring-{{ $group['icon_color'] }}-100 transition-all">
            <summary
                class="flex items-center justify-between p-5 cursor-pointer bg-slate-50 group-hover:bg-{{ $group['icon_color'] }}-50/50 transition select-none">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-{{ $group['icon_color'] }}-100 text-{{ $group['icon_color'] }}-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">{{ $group['kategori'] }}</h3>
                        <p class="text-xs text-slate-500">{{ $group['deskripsi'] }}</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </summary>

            <div class="p-5 border-t border-slate-100 bg-white">
                @if(count($group['items']) > 0)
                <ul class="space-y-3">
                    @foreach($group['items'] as $item)
                    <li
                        class="flex items-center justify-between p-3 rounded-lg border border-slate-100 hover:border-blue-300 hover:bg-blue-50 transition group/item">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                            </svg>
                            <div>
                                <p class="font-bold text-sm text-slate-700">{{ $item['judul'] }}</p>
                                <p class="text-xs text-slate-400">{{ $item['sub'] }}</p>
                            </div>
                        </div>
                        <a href="{{ asset($item['file']) }}" target="_blank"
                            class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-blue-600 hover:text-white transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-sm text-slate-400 italic text-center py-2">Belum ada dokumen yang diunggah.</p>
                @endif
            </div>
        </details>
        @endforeach
    </div>

</div>

<style>
    details>summary {
        list-style: none;
    }

    details>summary::-webkit-details-marker {
        display: none;
    }

    details[open] summary~* {
        animation: sweep .3s ease-in-out;
    }

    @keyframes sweep {
        0% {
            opacity: 0;
            transform: translateY(-10px)
        }

        100% {
            opacity: 1;
            transform: translateY(0)
        }
    }
</style>
@endsection