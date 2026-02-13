<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SITI ESDM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-900">

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
        style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1920&auto=format&fit=crop');">

        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/90 to-gray-900/80"></div>

        <div class="relative z-10 bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl m-4">

            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Instansi" class="w-20 h-20 object-contain">
                </div>
                <h2 class="text-3xl font-bold text-gray-800">SITI DESDM</h2>
                <p class="text-gray-500 text-sm mt-1">Sistem Informasi Cuti Pegawai DESDM</p>
                <p class="text-gray-500 text-sm mt-0">Provinsi Sumatera Selatan</p>
            </div>

            @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-6 text-sm rounded" role="alert">
                <p class="font-bold">Gagal Masuk</p>
                <p>Silakan periksa NIP dan Password Anda.</p>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Id Pengguna (NIP)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="nip" value="{{ old('nip') }}"
                            class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-m @error('nip') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Masukan NIP" required autofocus>
                    </div>
                    @error('nip')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="password" name="password"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-m"
                            placeholder="Masukan kata sandi Anda" required>
                    </div>
                    @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-yellow-400 to-yellow-400 text-gray-700 font-bold py-3 px-4 rounded-lg hover:from-yellow-500 hover:to-yellow-500 focus:outline-none focus:shadow-outline transform hover:-translate-y-0.5 transition duration-200 shadow-lg">
                    MASUK
                </button>

            </form>

            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} Dinas ESDM. All rights reserved.<br>
                    Dikembangkan oleh Tim IT
                </p>
            </div>
        </div>
    </div>

</body>

</html>