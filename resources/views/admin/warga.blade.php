<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga</title>

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

        <!-- Header -->
        <x-layouts.app.header />

        <div class="flex flex-1">

            <!-- Sidebar -->
            <x-layouts.app.sidebar />

            <!-- Main Content -->
            <main class="flex-1 px-6 py-8 max-w-7xl mx-auto w-full">
                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-semibold">Data Warga</h1>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            Daftar penduduk wilayah RT
                        </p>
                    </div>

                    <div class="flex items-center gap-2">

                        <!-- Navigasi ke Iuran -->
                        <a href="{{ route('iuran.index') }}"
                        class="px-4 py-2 text-sm bg-yellow-600 hover:bg-yellow-500 text-white rounded-md">
                            Kelola Iuran
                        </a>

                        <!-- Tombol Tambah Warga -->
                        <a href="{{ route('warga.create') }}" 
                        class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700
                        text-white rounded-md transition">
                            + Tambah Warga
                        </a>

                    </div>
                </div>


                <!-- Filter -->
                <form method="GET" class="flex flex-wrap gap-3 mb-5">

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIK"
                        class="px-3 py-2 text-sm rounded-md border
                    border-zinc-300 dark:border-zinc-600
                    bg-white dark:bg-zinc-800">

                    <select name="jk" class="px-3 py-2 text-sm rounded-md border
                    border-zinc-300 dark:border-zinc-600
                    bg-white dark:bg-zinc-800">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="Laki-laki" {{ request('jk') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="Perempuan" {{ request('jk') == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>

                    <button class="px-4 py-2 text-sm bg-zinc-800 dark:bg-zinc-700
                    text-white rounded-md">
                        Filter
                    </button>

                </form>

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

                <!-- Table -->
                <div class="overflow-x-auto bg-white dark:bg-zinc-800
    border border-zinc-200 dark:border-zinc-700 rounded-md">

                    <table class="min-w-full text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-700">
                            <tr class="text-left text-zinc-600 dark:text-zinc-200">
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">NIK</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Jenis Kelamin</th>
                                <th class="px-4 py-3">No HP</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y dark:divide-zinc-700">
                            @forelse($warga as $i => $item)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/30">
                                    <td class="px-4 py-3 font-medium">
                                        {{ $i + 1 }}
                                    </td>

                                    <td class="px-4 py-3 font-medium">
                                        {{ substr($item->NIK, 0 )}}
                                    </td>

                                    <td class="px-4 py-3 font-medium">
                                        {{ $item->Nama }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $item->Jenis_Kelamin }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $item->No_HP }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-2">

                                            <!-- Detail -->
                                            <a href="{{ route('warga.show', $item->id) }}" class="px-3 py-1 text-xs rounded-md
                                   bg-sky-500 hover:bg-sky-600 text-white">
                                                Detail
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('warga.edit', $item->id) }}" class="px-3 py-1 text-xs rounded-md
                                   bg-amber-500 hover:bg-amber-600 text-white">
                                                Ubah
                                            </a>

                                            <!-- Delete -->
                                            <form method="POST" action="{{ route('warga.destroy', $item->id) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="px-3 py-1 text-xs rounded-md
                                        bg-rose-600 hover:bg-rose-700 text-white">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-zinc-500">
                                        Data warga belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <!-- Pagination -->
                <div class="mt-4">
                    {{ $warga->links() }}
                </div>

            </main>
        </div>
    </div>

</body>

</html>