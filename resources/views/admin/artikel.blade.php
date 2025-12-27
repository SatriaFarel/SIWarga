<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Artikel</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'media',
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

            <main class="flex-1 px-6 py-8 max-w-7xl mx-auto w-full">

                <!-- Header -->
                <div class="mb-5 flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-semibold">Artikel</h1>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            Kelola artikel dan pengumuman RT
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <button onclick="openModal()" class="px-4 py-2 text-sm bg-zinc-700 text-white rounded-md">
                            Kelola Gambar
                        </button>

                        <a href="{{ route('artikel.create') }}"
                            class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-md">
                            + Tambah Artikel
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-500 text-white rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-500 text-white rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- TABLE ARTIKEL (PUNYA LU, TIDAK DIUBAH LOGIC-NYA) -->
                <!-- Table -->
                <div
                    class="overflow-x-auto bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md">
                    <table class="min-w-full text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-700">
                            <tr class="text-left text-zinc-600 dark:text-zinc-200">
                                <th class="px-4 py-3">Judul</th>
                                <th class="px-4 py-3">Slug</th>
                                <th class="px-4 py-3">Thumbnail</th>
                                <th class="px-4 py-3">Penulis</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-zinc-700"> @forelse($artikel as $item) <tr
                            class="hover:bg-zinc-50 dark:hover:bg-zinc-700/30">
                            <td class="px-4 py-3 font-medium"> {{ $item->Judul }} </td>
                            <td class="px-4 py-3 text-xs text-zinc-500"> {{ $item->Slug }} </td>
                            <td class="px-4 py-3"> @if($item->Thumbnail) <img src="{{asset($item->Thumbnail) }}"
                            class="w-16 h-10 object-cover rounded"> @else <span
                                    class="text-zinc-400 text-xs">Tidak ada</span> @endif </td>
                            <td class="px-4 py-3"> {{ $item->Penulis }} </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2"> <!-- View --> <a
                                        href="{{ route('artikel.show', $item->Slug) }}" target="_blank"
                                        class="px-3 py-1 text-xs bg-sky-600 hover:bg-sky-700 text-white rounded-md">
                                        Lihat </a> <!-- Edit --> <a href="{{ route('artikel.edit', $item->id) }}"
                                        class="px-3 py-1 text-xs bg-amber-500 hover:bg-amber-600 text-white rounded-md">
                                        Ubah </a> <!-- Delete -->
                                    <form method="POST" action="{{ route('artikel.destroy', $item->id) }}"
                                        onsubmit="return confirm('Hapus artikel ini?')"> @csrf @method('DELETE')
                                        <button
                                            class="px-3 py-1 text-xs bg-rose-600 hover:bg-rose-700 text-white rounded-md">
                                            Hapus </button> </form>
                                </div>
                            </td>
                        </tr> @empty <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-zinc-500"> Artikel belum tersedia
                                </td>
                            </tr> @endforelse </tbody>
                    </table>
                </div>
                <div class="mt-4"> {{ $artikel->links() }} </div>
            </main>
        </div>
    </div>

    <div class="mt-4">
        {{ $artikel->links() }}
    </div>

    </main>
    </div>
    </div>

    <!-- MODAL GAMBAR -->
    <div id="modalGambar" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">

        <div class="bg-white dark:bg-zinc-800 w-full max-w-4xl p-6 rounded-lg relative">

            <button onclick="closeModal()" class="absolute top-3 right-3 text-zinc-500">✕</button>

            <h2 class="text-lg font-semibold mb-4">Kelola Gambar Artikel</h2>

            <!-- Upload -->
            <form action="{{ route('artikel.gambar.upload') }}" method="POST" enctype="multipart/form-data"
                class="flex gap-3 mb-4">
                @csrf
                <input type="file" name="gambar" required class="text-sm">
                <button class="px-4 py-2 text-sm bg-indigo-600 text-white rounded">
                    Upload
                </button>
            </form>

            <!-- Grid Gambar -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-h-[55vh] overflow-y-auto">
                @foreach($gambarArtikel as $img)
                    <div class="border rounded p-2">
                        <img src="{{ asset('assets/artikel/' . $img->getFilename()) }}"
                            class="w-full h-24 object-cover rounded mb-2">

                        <p class="text-[11px] text-zinc-500 break-all mb-2">
                            {{ $img->getFilename() }}
                        </p>

                        <form method="POST" action="{{ route('artikel.gambar.hapus') }}"
                            onsubmit="return confirm('Hapus gambar ini?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="nama" value="{{ $img->getFilename() }}">
                            <button class="w-full text-xs bg-rose-600 text-white py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modalGambar').classList.remove('hidden')
        }
        function closeModal() {
            document.getElementById('modalGambar').classList.add('hidden')
        }
    </script>

</body>

</html>