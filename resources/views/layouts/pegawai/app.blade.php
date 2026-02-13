<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Pegawai - SITI ESDM</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.5);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(236, 72, 153, 0.3);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(236, 72, 153, 0.5);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    @include('layouts.pegawai.navigation')

    <main class="fade-in min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Dinas ESDM. All rights reserved</p>
                </div>
                <div class="flex gap-4 text-sm text-slate-500">
                    <span class="text-slate-400 text-xs">Sistem Informasi Kepegawaian v1.0</span>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>