<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($agenda) ? 'Edit Agenda' : 'Tambah Agendal' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-zinc-100 dark:bg-zinc-900 text-zinc-800 dark:text-zinc-100">

    <div class="min-h-screen flex flex-col">

        <x-layouts.app.header />

        <div class="flex flex-1">
            <x-layouts.app.sidebar />

            <main class="flex-1 px-6 py-8 max-w-4xl mx-auto w-full">

                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-xl font-semibold">
                        {{ isset($agenda) ? 'Edit Agenda' : 'Tambah Agenda' }}
                    </h1>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ isset($agenda) ? 'Perbarui agenda' : 'Buat agenda baru' }}
                    </p>
                </div>

                <!-- Alert -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-500 text-white rounded-lg">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST"
                    action="{{ isset($agenda) ? route('agenda.update', $agenda->id) : route('agenda.store') }}"
                    enctype="multipart/form-data" class="bg-white dark:bg-zinc-800 border border-zinc-200
                         dark:border-zinc-700 rounded-md p-6 space-y-5">

                    @csrf
                    @if(isset($agenda))
                        @method('PUT')
                    @endif

                    <!-- Judul -->
                    <div>
                        <label class="block text-sm mb-1">Judul</label>
                        <input type="text" name="Judul" value="{{ old('Judul', $agenda->Judul ?? '') }}" class="w-full px-3 py-2 rounded-md border
                                  border-zinc-300 dark:border-zinc-600
                                  bg-white dark:bg-zinc-900">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm mb-1">Deskripsi</label>
                        <input type="text" name="Deskripsi" value="{{ old('Deskripsi', $agenda->Deskripsi ?? '') }}"
                            class="w-full px-3 py-2 rounded-md border
                                  border-zinc-300 dark:border-zinc-600
                                  bg-white dark:bg-zinc-900">
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label class="block text-sm mb-1">Tanggal_Mulai</label>
                        <input type="date" name="Tanggal_Mulai"
                            value="{{ old('Tanggal_Mulai', $agenda->Tanggal_Mulai ?? '') }}" class="w-full px-3 py-2 rounded-md border
                                  border-zinc-300 dark:border-zinc-600
                                  bg-white dark:bg-zinc-900">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label class="block text-sm mb-1">Tanggal_Selesai</label>
                        <input type="date" name="Tanggal_Selesai"
                            value="{{ old('Tanggal_Selesai', $agenda->Tanggal_Selesai ?? '') }}" class="w-full px-3 py-2 rounded-md border
                                  border-zinc-300 dark:border-zinc-600
                                  bg-white dark:bg-zinc-900">
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label class="block text-sm mb-1">Lokasi</label>
                        <input type="text" name="Lokasi" value="{{ old('Lokasi', $agenda->Lokasi ?? '') }}" class="w-full px-3 py-2 rounded-md border
                                  border-zinc-300 dark:border-zinc-600
                                  bg-white dark:bg-zinc-900">
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Gambar</label>

                        @if(isset($artikel) && $artikel->Gambar)
                            <!-- Preview Gambar -->
                            <div class="mb-3">
                                <p class="text-xs mb-1 text-zinc-500 dark:text-zinc-400">
                                    Gambar saat ini:
                                </p>
                                <div class="w-40 aspect-video rounded-md overflow-hidden border
                                            border-zinc-300 dark:border-zinc-600">
                                    <img src="{{ asset($artikel->Gambar) }}" alt="Gambar"
                                        class="w-full h-full object-cover">

                                </div>
                            </div>
                        @endif

                        <!-- Upload Box -->
                        <label class="flex flex-col items-center justify-center w-full px-4 py-6
                                border-2 border-dashed border-zinc-300 dark:border-zinc-600
                                rounded-md cursor-pointer
                                hover:bg-zinc-100 dark:hover:bg-zinc-700
                                transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8 mb-2 text-zinc-500 dark:text-zinc-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16V8m10 8V8m-5 8V4m0 0L9 7m3-3l3 3" />
                            </svg>

                            <span class="text-sm text-zinc-600 dark:text-zinc-300">
                                Klik untuk upload gambar
                            </span>

                            <span class="text-xs mt-1 text-zinc-500">
                                PNG, JPG, JPEG (Max 2MB)
                            </span>

                            <input type="file" name="Gambar" class="hidden">
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 justify-end">
                        <a href="{{ route('agenda.index') }}" class="px-4 py-2 text-sm rounded-md
                              border border-zinc-300 dark:border-zinc-600">
                            Batal
                        </a>

                        <button type="submit" class="px-5 py-2 text-sm text-white
                                   bg-zinc-800 dark:bg-zinc-700 rounded-md">
                            Simpan
                        </button>
                    </div>

                </form>

            </main>
        </div>
    </div>

</body>

</html>