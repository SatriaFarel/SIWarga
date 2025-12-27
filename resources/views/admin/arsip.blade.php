<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Dokumen</title>

    <script src="https://cdn.tailwindcss.com"></script>
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

            <main class="flex-1 px-6 py-8 max-w-7xl mx-auto w-full">

                <!-- Header -->
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-semibold">Arsip Dokumen</h1>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            Arsip internal dokumen RT (PDF / DOC)
                        </p>
                    </div>

                    <a href="{{ route('arsip.create') }}"
                        class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                        + Upload Dokumen
                    </a>
                </div>

                <!-- Filter -->
                <form method="GET" class="flex flex-wrap gap-3 mb-6">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul dokumen"
                        class="px-3 py-2 text-sm rounded-md border
                              border-zinc-300 dark:border-zinc-600
                              bg-white dark:bg-zinc-800">

                    <select name="kategori" class="px-3 py-2 text-sm rounded-md border
                               border-zinc-300 dark:border-zinc-600
                               bg-white dark:bg-zinc-800">
                        <option value="">Semua Kategori</option>
                        @foreach(['undangan', 'edaran', 'laporan', 'sk', 'lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                                {{ ucfirst($kat) }}
                            </option>
                        @endforeach
                    </select>

                    <button class="px-4 py-2 text-sm bg-zinc-800 dark:bg-zinc-700 text-white rounded-md">
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

                <!-- Grid Arsip -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse($arsip as $item)
                                    <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700
                                                    rounded-2xl p-5 shadow-sm hover:shadow-lg transition">

                                        <!-- Kategori -->
                                        <span class="inline-block mb-2 px-2 py-0.5 text-[10px]
                                                         rounded-full bg-indigo-100 text-indigo-700
                                                         dark:bg-indigo-900/40 dark:text-indigo-300">
                                            {{ ucfirst($item->kategori) }}
                                        </span>

                                        <!-- Judul -->
                                        <h2 class="text-lg font-semibold">
                                            {{ $item->judul }}
                                        </h2>

                                        <!-- Info file -->
                                        <div class="mt-3 text-xs text-zinc-500 dark:text-zinc-400 space-y-1">
                                            <div>📄 {{ $item->nama_file }}</div>
                                            <div>📦 {{ number_format($item->ukuran_file) }} KB • {{ strtoupper($item->tipe_file) }}
                                            </div>
                                            <div>📅 {{ \Carbon\Carbon::parse($item->tanggal_dokumen)->format('d M Y') }}</div>
                                            <div>
                                                🔐 {{ $item->akses === 'admin' ? 'Internal' : 'Publik' }}
                                            </div>
                                        </div>

                                        <!-- Action -->
                                        <div class="mt-4 flex gap-2">
                                            <a href="{{ route('arsip.download', $item->id) }}" class="inline-flex items-center gap-1 px-3 py-1 text-xs
                          bg-emerald-600 hover:bg-emerald-700
                          text-white rounded-md">
                                                ⬇ Download
                                            </a>


                                            <form method="POST" action="{{ route('arsip.destroy', $item->id) }}"
                                                onsubmit="return confirm('Hapus dokumen ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-1 text-xs bg-rose-600 text-white rounded-md">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                    @empty
                        <p class="col-span-3 text-center py-6 text-zinc-500">
                            Arsip dokumen belum tersedia
                        </p>
                    @endforelse

                </div>

                <div class="mt-6">
                    {{ $arsip->links() }}
                </div>

            </main>
        </div>
    </div>

</body>

</html>