<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Agenda</title>

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
                <div class="mb-5 flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-semibold">Agenda</h1>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            Kelola agenda RT
                        </p>
                    </div>

                    <a href="{{ route('agenda.create') }}"
                        class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                        + Tambah Agenda
                    </a>
                </div>

                <!-- Filter -->
                <form method="GET" class="flex flex-wrap gap-3 mb-5">

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul / deskripsi" class="px-3 py-2 text-sm rounded-md border
                    border-zinc-300 dark:border-zinc-600
                    bg-white dark:bg-zinc-800">

                    {{-- <select name="jk" class="px-3 py-2 text-sm rounded-md border
                    border-zinc-300 dark:border-zinc-600
                    bg-white dark:bg-zinc-800">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="Laki-laki" {{ request('jk')=='Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="Perempuan" {{ request('jk')=='Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select> --}}

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

                <!-- Grid Card Agenda -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse($agenda as $item)

                        <div class="group relative bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 
                                        rounded-2xl p-5 shadow-sm hover:shadow-xl hover:-translate-y-1 
                                        transition-all duration-300">

                            <!-- Header Title -->
                            <h2
                                class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 group-hover:text-indigo-600 transition">
                                {{ $item->Judul }}
                            </h2>

                            <!-- Description -->
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-3">
                                {{ $item->Deskripsi }}
                            </p>

                            <!-- Info Section -->
                            <div class="mt-4 space-y-2 text-xs text-zinc-600 dark:text-zinc-300">

                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900/40 
                                                    text-indigo-700 dark:text-indigo-300 rounded-full text-[10px]">
                                        Mulai
                                    </span>
                                    {{ $item->Tanggal_Mulai }}
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 bg-teal-100 dark:bg-teal-900/40 
                                                    text-teal-700 dark:text-teal-300 rounded-full text-[10px]">
                                        Selesai
                                    </span>
                                    {{ $item->Tanggal_Selesai }}
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 bg-orange-100 dark:bg-orange-900/40 
                                                    text-orange-700 dark:text-orange-300 rounded-full text-[10px]">
                                        Lokasi
                                    </span>
                                    {{ $item->Lokasi }}
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-5 flex gap-2">

                                <a href="{{ route('agenda.edit', $item->id) }}" class="px-3 py-1 text-xs bg-amber-500 hover:bg-amber-600 
                                            text-white rounded-md transition">
                                    Ubah
                                </a>

                                <form method="POST" action="{{ route('agenda.destroy', $item->id) }}"
                                    onsubmit="return confirm('Hapus agenda ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 text-xs bg-rose-600 hover:bg-rose-700 
                                                    text-white rounded-md transition">
                                        Hapus
                                    </button>
                                </form>

                            </div>

                        </div>

                    @empty
                        <p class="col-span-3 text-center py-6 text-zinc-500">
                            Agenda belum tersedia
                        </p>
                    @endforelse

                </div>

                <div class="mt-4">
                    {{ $agenda->links() }}
                </div>

            </main>
        </div>
    </div>

</body>

</html>