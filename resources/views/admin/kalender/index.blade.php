<x-layouts.admin.app> 
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header & Keterangan Warna --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
            <div>
                {{-- 2. MODIFIKASI: Mengubah indikator bidang spesifik menjadi indikator Global --}}
                <div class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full mb-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    Akses: Seluruh Bidang (Global Dinas)
                </div>
                
                {{-- 3. MODIFIKASI: Mengubah Judul dan Deskripsi --}}
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Kalender Cuti Dinas</h1>
                <p class="text-slate-500 mt-1 text-sm">Pantau seluruh jadwal, intensitas, dan aktivitas cuti pegawai di lingkungan Dinas ESDM.</p>
            </div>

            {{-- Legend (Muncul jelas di mode Agenda) --}}
            <div class="flex flex-wrap gap-5 text-xs font-semibold text-slate-600 bg-white/80 backdrop-blur-sm px-5 py-3 rounded-2xl border border-slate-200/60 shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500 shadow-sm shadow-blue-200"></span> Cuti Tahunan
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
        <div class="bg-gradient-to-br from-slate-50 to-white rounded-[1.8rem] p-6 h-full border border-slate-200 relative overflow-hidden">
            <div id='calendar'></div>
        </div>
    </div>

    <style>
        .fc { font-family: inherit; }

        .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            color: #0f172a;
        }

        /* 4. MODIFIKASI WARNA: Mengubah nuansa lime (hijau kekuningan) menjadi emerald/slate agar lebih cocok untuk tema admin/manajemen */
        .fc-button-primary {
            background-color: #059669 !important; /* Emerald 600 */
            border-color: #059669 !important;
            font-weight: 600 !important;
            text-transform: capitalize !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease !important;
        }

        .fc-button-primary:hover, .fc-button-active {
            background-color: #047857 !important; /* Emerald 700 */
            border-color: #047857 !important;
        }

        .fc-button-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25) !important;
        }

        .fc-button-primary:disabled {
            background-color: #cbd5e1 !important;
            border-color: #cbd5e1 !important;
        }

        .fc-dayGridMonth-view .fc-daygrid-event-harness {
            display: none !important;
        }

        .fc-daygrid-day-frame {
            position: relative !important;
        }

        .fc-list-event-title {
            font-weight: 600 !important;
        }

        .fc-col-header-cell {
            background-color: #f8fafc;
            padding: 0.75rem 0 !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        .fc-col-header-cell-cushion {
            color: #475569 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            text-decoration: none !important;
        }

        .fc-daygrid-day-number {
            color: #334155 !important;
            font-weight: 600 !important;
            font-size: 0.875rem;
            text-decoration: none !important;
            padding: 8px !important;
        }

        .fc-today-button {
            background-color: #ffffff !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1 !important;
            font-weight: 600 !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            margin-left: 12px !important;
        }

        .fc-today-button:hover:not(:disabled) {
            background-color: #f0fdf4 !important; /* Hijau pudar */
            color: #166534 !important;
            border-color: #15803d !important;
        }

        .fc-today-button:disabled {
            background-color: #f8fafc !important;
            color: #94a3b8 !important;
            border-color: #e2e8f0 !important;
            cursor: not-allowed !important;
        }
    </style>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eventsData = @json($events);
            const dailyCounts = @json($dailyCounts);

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

                dayCellDidMount: function(arg) {
                    const date = arg.date;
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const dateStr = `${year}-${month}-${day}`;
                    
                    if (dailyCounts[dateStr]) {
                        let badgeContainer = document.createElement('div');
                        badgeContainer.className = 'absolute bottom-1.5 right-1.5 z-10';
                        
                        let badge = document.createElement('span');
                        badge.className = 'bg-rose-50 border border-rose-200 text-rose-600 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm';
                        badge.innerText = 'Total Cuti: ' + dailyCounts[dateStr]; // Diubah menjadi Total Cuti Dinas
                        
                        badgeContainer.appendChild(badge);
                        
                        const frame = arg.el.querySelector('.fc-daygrid-day-frame');
                        if (frame) {
                            frame.appendChild(badgeContainer);
                        }
                    }
                },
                
                eventClick: function(info) {
                    const ket = info.event.extendedProps.keterangan || 'Tidak ada alasan dicantumkan';
                    const bidangPegawai = info.event.extendedProps.nama_bidang || 'Tidak Diketahui';
                    const namaPegawai = info.event.extendedProps.nama_pegawai || info.event.title;

                    alert(
                        'Detail Jadwal Cuti Pegawai (Global)\n' +
                        '-----------------------------------------\n' +
                        'Pegawai : ' + namaPegawai + '\n' +
                        'Seksi/Bidang : ' + bidangPegawai + '\n' + 
                        'Alasan : ' + ket
                    );
                }
            });
            
            calendar.render();
        });
    </script>
</x-layouts.admin.app>