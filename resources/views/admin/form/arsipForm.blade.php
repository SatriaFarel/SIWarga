<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Arsip</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
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

            <main class="flex-1 px-6 py-8 max-w-3xl mx-auto w-full">

                <h1 class="text-xl font-semibold mb-6">Tambah Arsip Dokumen</h1>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-500 text-white rounded">
                        <ul class="list-disc ml-4">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                    action="{{ isset($arsip) ? route('arsip.update', $arsip->id) : route('arsip.store') }}"
                    enctype="multipart/form-data" class="bg-white dark:bg-zinc-800 border rounded-md p-6 space-y-5">

                    @csrf
                    @isset($arsip)
                        @method('PUT')
                    @endisset

                    <!-- Judul -->
                    <div>
                        <label class="text-sm">Judul Dokumen</label>
                        <input type="text" name="judul" value="{{ old('judul', $arsip->judul ?? '') }}"
                            class="w-full px-3 py-2 rounded border dark:bg-zinc-900">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="text-sm">Kategori</label>
                        <select name="kategori" class="w-full px-3 py-2 rounded border dark:bg-zinc-900">
                            @foreach(['undangan', 'edaran', 'laporan', 'sk', 'lainnya'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $arsip->kategori ?? '') == $kat ? 'selected' : '' }}>
                                    {{ ucfirst($kat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="text-sm">Tanggal Dokumen</label>
                        <input type="date" name="tanggal_dokumen"
                            value="{{ old('tanggal_dokumen', $arsip->tanggal_dokumen ?? '') }}"
                            class="w-full px-3 py-2 rounded border dark:bg-zinc-900">
                    </div>

                    <!-- File -->
                    <div>
                        <label class="text-sm">Upload File (PDF / DOC / DOCX)</label>
                        <input type="file" name="file" class="w-full px-3 py-2 rounded border dark:bg-zinc-900">
                        @isset($arsip)
                            <p class="text-xs mt-1 text-zinc-500">
                                File lama: {{ $arsip->nama_file }}
                            </p>
                        @endisset
                    </div>

                    <!-- Akses -->
                    <div>
                        <label class="text-sm">Akses</label>
                        <select name="akses" class="w-full px-3 py-2 rounded border dark:bg-zinc-900">
                            <option value="admin" {{ old('akses', $arsip->akses ?? '') == 'admin' ? 'selected' : '' }}>
                                Admin Only
                            </option>
                            <option value="publik" {{ old('akses', $arsip->akses ?? '') == 'publik' ? 'selected' : '' }}>
                                Publik
                            </option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('arsip.index') }}" class="px-4 py-2 border rounded">
                            Batal
                        </a>
                        <button class="px-5 py-2 bg-indigo-600 text-white rounded">
                            Simpan
                        </button>
                    </div>
                </form>

            </main>
        </div>
    </div>
</body>

</html>