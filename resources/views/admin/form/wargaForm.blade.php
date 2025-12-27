<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Warga — Sistem Informasi RT</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'media',
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

                <div class="mb-6">
                    <h1 class="text-xl font-semibold">
                        {{ isset($warga) ? 'Update Data Warga' : 'Tambah Data Warga' }}
                    </h1>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ isset($warga) ? 'Update data penduduk' : 'Isi data penduduk baru' }}
                    </p>
                </div>

                {{-- Alert sukses --}}
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-500 text-white rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Alert error --}}
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-500 text-white rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Error validasi --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-500 text-white rounded-lg">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORM -->
                <form method="POST" action="{{ isset($warga) ? route('warga.update', $warga) : route('warga.store') }}"
                    class="bg-white dark:bg-zinc-800 border
                 border-zinc-200 dark:border-zinc-700
                 rounded-md p-6 space-y-5">

                    @csrf
                    @if (isset($warga))
                        @method('PUT')
                    @endif

                    <!-- NIK -->
                    <div>
                        <label class="block text-sm mb-1">NIK</label>
                        <input type="text" name="NIK" value="{{ old('NIK', $warga->NIK ?? '') }}" class="w-full px-3 py-2 rounded-md border
                          border-zinc-300 dark:border-zinc-600
                          bg-white dark:bg-zinc-900">
                    </div>

                    <!-- No KK -->
                    <div>
                        <label class="block text-sm mb-1">No KK</label>
                        <input type="text" name="No_KK" value="{{ old('No_KK', $warga->No_KK ?? '') }}" class="w-full px-3 py-2 rounded-md border
                          border-zinc-300 dark:border-zinc-600
                          bg-white dark:bg-zinc-900">
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm mb-1">Nama Lengkap</label>
                        <input type="text" name="Nama" value="{{ old('Nama', $warga->Nama ?? '') }}" class="w-full px-3 py-2 rounded-md border
                          border-zinc-300 dark:border-zinc-600
                          bg-white dark:bg-zinc-900">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm mb-1">Password</label>
                        <input type="text" name="Password" value="{{ old('Password', $warga->Password ?? '') }}" class="w-full px-3 py-2 rounded-md border
                          border-zinc-300 dark:border-zinc-600
                          bg-white dark:bg-zinc-900">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-sm mb-1">Tanggal Lahir</label>
                        <input type="date" name="Tanggal_Lahir"
                            value="{{ old('Tanggal_Lahir', $warga->Tanggal_Lahir ?? '') }}" class="w-full px-3 py-2 rounded-md border
                          border-zinc-300 dark:border-zinc-600
                          bg-white dark:bg-zinc-900">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm mb-1">Jenis Kelamin</label>
                        <select name="Jenis_Kelamin" class="w-full px-3 py-2 rounded-md border
                           border-zinc-300 dark:border-zinc-600
                           bg-white dark:bg-zinc-900">

                            <option value="">-- Pilih --</option>

                            <option value="Laki Laki" {{ old('Jenis_Kelamin', $warga->Jenis_Kelamin ?? '') == 'Laki Laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="Perempuan" {{ old('Jenis_Kelamin', $warga->Jenis_Kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm mb-1">Alamat</label>
                        <textarea name="Alamat" rows="3" class="w-full px-3 py-2 rounded-md border
                       border-zinc-300 dark:border-zinc-600
                       bg-white dark:bg-zinc-900">{{ old('Alamat', $warga->Alamat ?? '') }}</textarea>
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="block text-sm mb-1">No HP</label>
                        <input type="text" name="No_HP" value="{{ old('No_HP', $warga->No_HP ?? '') }}" class="w-full px-3 py-2 rounded-md border
                          border-zinc-300 dark:border-zinc-600
                          bg-white dark:bg-zinc-900">
                    </div>

                    <!-- BUTTON -->
                    <div class="flex gap-3 justify-end">
                        <a href="{{ route('warga.index') }}" class="px-4 py-2 text-sm rounded-md
                      border border-zinc-300 dark:border-zinc-600">
                            Batal
                        </a>

                        <button type="submit" class="px-5 py-2 text-sm text-white
                           bg-zinc-800 dark:bg-zinc-700 rounded-md">
                            {{ isset($warga) ? 'Update' : 'Simpan' }}
                        </button>
                    </div>

                </form>

            </main>

        </div>
    </div>

</body>

</html>