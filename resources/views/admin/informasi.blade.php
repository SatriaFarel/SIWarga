<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Informasi</title>

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
                        <h1 class="text-xl font-semibold">Informasi</h1>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            Kelola pengumuman & informasi RT
                        </p>
                    </div>

                    <a href="{{ route('informasi.create') }}" class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700
                          text-white rounded-md">
                        + Tambah Informasi
                    </a>
                </div>

                <!-- Filter -->
                <form method="GET" class="flex flex-wrap gap-3 mb-6">

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul / ringkasan" class="px-3 py-2 text-sm rounded-md border
                              border-zinc-300 dark:border-zinc-600
                              bg-white dark:bg-zinc-800">

                    <select name="Is_penting" class="px-3 py-2 text-sm rounded-md border
                               border-zinc-300 dark:border-zinc-600
                               bg-white dark:bg-zinc-800">
                        <option value="">Semua</option>
                        <option value="1" {{ request('penting') == '1' ? 'selected' : '' }}>
                            Penting
                        </option>
                        <option value="0" {{ request('penting') === '0' ? 'selected' : '' }}>
                            Tidak Penting
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

                <!-- Grid Card Informasi -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse($informasi as $item)

                                    <div class="group bg-white dark:bg-zinc-800
                                               border border-zinc-200 dark:border-zinc-700
                                               rounded-2xl p-5 shadow-sm
                                               hover:shadow-xl hover:-translate-y-1
                                               transition-all duration-300
                                               {{ $item->Is_penting ? 'border-l-4 border-rose-500' : '' }}">

                                        <!-- Accent -->
                                        <div class="h-1 w-10 bg-indigo-500 rounded mb-3"></div>

                                        <!-- Judul -->
                                        <h2 class="text-lg font-semibold
                                                   group-hover:text-indigo-600 transition">
                                            {{ $item->Judul }}
                                        </h2>

                                        <!-- Ringkasan -->
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400
                                                   mt-1 line-clamp-3">
                                            {{ $item->Ringkasan }}
                                        </p>

                                        <!-- Info -->
                                        <div class="mt-4 space-y-2 text-xs text-zinc-600 dark:text-zinc-300">

                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5
                                                           bg-indigo-100 dark:bg-indigo-900/40
                                                           text-indigo-700 dark:text-indigo-300
                                                           rounded-full text-[10px]">
                                                    Tanggal
                                                </span>
                                                {{ $item->created_at->format('d M Y') }}
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded-full text-[10px]
                                                           {{ $item->Is_penting
                        ? 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300'
                        : 'bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300' }}">
                                                    {{ $item->Is_penting ? '⚠ Penting' : 'Biasa' }}
                                                </span>
                                            </div>

                                        </div>

                                        <!-- Action -->
                                        <div class="mt-5 flex gap-2">

                                            <a href="{{ route('informasi.edit', $item->id) }}" class="px-3 py-1 text-xs
                                                      bg-amber-500 hover:bg-amber-600
                                                      text-white rounded-md transition">
                                                Ubah
                                            </a>

                                            <form method="POST" action="{{ route('informasi.destroy', $item->id) }}"
                                                onsubmit="return confirm('Hapus informasi ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="px-3 py-1 text-xs
                                                           bg-rose-600 hover:bg-rose-700
                                                           text-white rounded-md transition">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                    @empty
                        <p class="col-span-3 text-center py-6 text-zinc-500">
                            Informasi belum tersedia
                        </p>
                    @endforelse

                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $informasi->links() }}
                </div>

            </main>
        </div>
    </div>

</body>

</html>