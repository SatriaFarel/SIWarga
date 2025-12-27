<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($informasi) ? 'Edit Informasi' : 'Tambah Informasi' }}</title>

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
                    {{ isset($informasi) ? 'Edit Informasi' : 'Tambah Informasi' }}
                </h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    {{ isset($informasi) ? 'Perbarui informasi RT' : 'Buat informasi baru untuk warga' }}
                </p>
            </div>

            <!-- Alert Error -->
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
                  action="{{ isset($informasi) ? route('informasi.update', $informasi->id) : route('informasi.store') }}"
                  class="bg-white dark:bg-zinc-800 border border-zinc-200
                         dark:border-zinc-700 rounded-md p-6 space-y-5">

                @csrf
                @if(isset($informasi))
                    @method('PUT')
                @endif

                <!-- Judul -->
                <div>
                    <label class="block text-sm mb-1">Judul Informasi</label>
                    <input type="text"
                           name="Judul"
                           value="{{ old('Judul', $informasi->Judul ?? '') }}"
                           class="w-full px-3 py-2 rounded-md border
                                  border-zinc-300 dark:border-zinc-600
                                  bg-white dark:bg-zinc-900">
                </div>

                <!-- Ringkasan -->
                <div>
                    <label class="block text-sm mb-1">Ringkasan</label>
                    <textarea name="Ringkasan" rows="3"
                              class="w-full px-3 py-2 rounded-md border
                                     border-zinc-300 dark:border-zinc-600
                                     bg-white dark:bg-zinc-900">{{ old('Ringkasan', $informasi->Ringkasan ?? '') }}</textarea>
                </div>

                <!-- Isi -->
                <div>
                    <label class="block text-sm mb-1">Isi Informasi</label>
                    <textarea name="Isi" rows="6"
                              class="w-full px-3 py-2 rounded-md border
                                     border-zinc-300 dark:border-zinc-600
                                     bg-white dark:bg-zinc-900">{{ old('Isi', $informasi->Isi ?? '') }}</textarea>
                </div>

                <!-- Informasi Penting -->
                <div class="flex items-center gap-2">
                    <input type="checkbox"
                           name="Is_penting"
                           value="1"
                           {{ old('Is_penting', $informasi->Is_penting ?? false) ? 'checked' : '' }}
                           class="rounded border-zinc-300 dark:border-zinc-600">

                    <label class="text-sm">
                        Tandai sebagai <span class="font-semibold text-rose-600">Informasi Penting</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 justify-end pt-4">
                    <a href="{{ route('informasi.index') }}"
                       class="px-4 py-2 text-sm rounded-md
                              border border-zinc-300 dark:border-zinc-600">
                        Batal
                    </a>

                    <button type="submit"
                            class="px-5 py-2 text-sm text-white
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
