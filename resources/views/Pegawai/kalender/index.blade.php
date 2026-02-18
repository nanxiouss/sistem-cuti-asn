@extends('layouts.pegawai.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header & Keterangan Warna --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Kalender Cuti Pegawai</h1>
            <p class="text-slate-500 mt-2">Pantau jadwal cuti rekan kerja Anda secara real-time.</p>
        </div>

        {{-- Legend --}}
        <div class="flex flex-wrap gap-3 text-xs font-medium bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span> Cuti Tahunan
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-red-500"></span> Sakit
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-pink-500"></span> Melahirkan
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-yellow-500"></span> Cuti Besar
            </div>
        </div>
    </div>

    {{-- Box Kalender --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div id='calendar'></div>
    </div>
</div>

{{-- Style khusus untuk mempercantik FullCalendar agar matching dengan Tailwind --}}
<style>
    .fc {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 700;
        color: #1e293b;
    }

    .fc-button-primary {
        background-color: #2563EB !important;
        border-color: #2563EB !important;
        font-weight: 500 !important;
        text-transform: capitalize !important;
    }

    .fc-button-primary:disabled {
        background-color: #94a3b8 !important;
        border-color: #94a3b8 !important;
    }

    .fc-daygrid-event {
        border-radius: 6px !important;
        padding: 3px 6px !important;
        font-size: 0.75rem !important;
        border: none !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .fc-col-header-cell {
        background-color: #f8fafc;
        py-3;
    }

    .fc-col-header-cell-cushion {
        color: #64748b !important;
        font-weight: 600 !important;
        text-decoration: none !important;
    }

    .fc-daygrid-day-number {
        color: #1e293b !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        padding: 8px !important;
    }

    /* Menghilangkan garis biru saat tanggal diklik */
    .fc-daygrid-day:focus {
        background-color: transparent !important;
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
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
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