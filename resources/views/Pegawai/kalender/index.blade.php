@extends('layouts.pegawai.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header & Keterangan Warna --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Kalender Cuti</h1>
            <p class="text-slate-500 mt-2 text-sm">Pantau jadwal cuti rekan kerja Anda secara real-time.</p>
        </div>

        {{-- Legend (Disempurnakan dengan shadow & nuansa warna modern) --}}
        <div class="flex flex-wrap gap-5 text-xs font-semibold text-slate-600 bg-white/80 backdrop-blur-sm px-5 py-3 rounded-2xl border border-slate-200/60 shadow-sm">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-lime-500 shadow-sm shadow-lime-200"></span> Cuti Tahunan
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-rose-500 shadow-sm shadow-rose-200"></span> Sakit
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-fuchsia-500 shadow-sm shadow-fuchsia-200"></span> Melahirkan
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm shadow-amber-200"></span> Cuti Besar
            </div>
        </div>
    </div>

    {{-- Box Kalender --}}
    <div class="bg-gradient-to-br from-lime-50 to-white rounded-[1.8rem] p-6 h-full border border-lime-300 relative overflow-hidden">
        <div id='calendar'></div>
    </div>
</div>

{{-- Style khusus untuk mempercantik FullCalendar dengan palet warna Lime & Slate --}}
<style>
    .fc {
        font-family: inherit; /* Mengikuti font bawaan Tailwind di app.blade.php */
    }

    .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 800 !important;
        color: #0f172a; /* text-slate-900 */
    }

    /* Kustomisasi Tombol Primary (Tema Lime) */
    .fc-button-primary {
        background-color: #65a30d !important; /* bg-lime-600 */
        border-color: #65a30d !important;
        font-weight: 600 !important;
        text-transform: capitalize !important;
        border-radius: 0.5rem !important; /* rounded-lg */
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        transition: all 0.2s ease !important;
    }

    /* Efek Hover Tombol */
    .fc-button-primary:hover {
        background-color: #4d7c0f !important; /* bg-lime-700 */
        border-color: #4d7c0f !important;
    }

    /* Status Aktif (Misal saat klik bulan/minggu) */
    .fc-button-active {
        background-color: #4d7c0f !important; /* bg-lime-700 */
        border-color: #4d7c0f !important;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05) !important;
    }

    .fc-button-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(101, 163, 13, 0.25) !important;
    }

    .fc-button-primary:disabled {
        background-color: #cbd5e1 !important; /* bg-slate-300 */
        border-color: #cbd5e1 !important;
    }

    /* Desain Event/Jadwal di dalam kalender */
    .fc-daygrid-event {
        border-radius: 0.375rem !important; /* rounded-md */
        padding: 4px 8px !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        border: none !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    /* Efek angkat (lift) saat event di-hover */
    .fc-daygrid-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Header Kolom Hari (Senin, Selasa, dst) */
    .fc-col-header-cell {
        background-color: #f8fafc; /* bg-slate-50 */
        padding: 0.75rem 0 !important;
        border-bottom: 1px solid #e2e8f0 !important; /* border-slate-200 */
    }

    .fc-col-header-cell-cushion {
        color: #475569 !important; /* text-slate-600 */
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        text-decoration: none !important;
    }

    /* Nomor Tanggal */
    .fc-daygrid-day-number {
        color: #334155 !important; /* text-slate-700 */
        font-weight: 600 !important;
        font-size: 0.875rem;
        text-decoration: none !important;
        padding: 8px !important;
    }

/* ---------------------------------------------------
       Desain khusus tombol "Hari Ini" (Outline/Clean Style) 
       --------------------------------------------------- */
    .fc-today-button {
        background-color: #ffffff !important; /* bg-white */
        color: #475569 !important; /* text-slate-600 */
        border: 1px solid #cbd5e1 !important; /* border-slate-300 */
        font-weight: 600 !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important; /* shadow-sm */
        transition: all 0.2s ease !important;
        margin-left: 12px !important; /* Jarak dari tombol Prev/Next */
    }

    /* Efek Hover saat disentuh kursor (Tema Amber/Orange) */
    .fc-today-button:hover:not(:disabled) {
        background-color: #fffbeb !important; /* bg-amber-50 */
        color: #d97706 !important; /* text-amber-600 */
        border-color: #f59e0b !important; /* border-amber-500 */
    }

    /* Saat sedang berada di bulan ini (tombol nonaktif/disabled) */
    .fc-today-button:disabled {
        background-color: #f8fafc !important; /* bg-slate-50 */
        color: #94a3b8 !important; /* text-slate-400 */
        border-color: #e2e8f0 !important; /* border-slate-200 */
        opacity: 0.8 !important;
        cursor: not-allowed !important;
    }
</style>

{{-- Script FullCalendar --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data events dari PHP (Controller)
        const eventsData = @json($events);

        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev next today',
                center: 'title',
                right: 'dayGridMonth listMonth'
            },
            buttonText: { 
                today: 'Hari Ini', 
                month: 'Bulan', 
                list: 'Agenda' 
            },
            height: 750,
            events: eventsData,
            
            // Interaksi saat nama pegawai diklik
            eventClick: function(info) {
                const ket = info.event.extendedProps.keterangan || 'Tidak ada keterangan';
                alert(
                    'Detail Jadwal Cuti\n' +
                    '--------------------------\n' +
                    'Pegawai : ' + info.event.title + '\n' +
                    'Info : ' + ket
                );
            }
        });
        
        calendar.render();
    });
</script>
@endsection