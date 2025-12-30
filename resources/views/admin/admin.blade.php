<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Admin</title>

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
                    <h1 class="text-xl font-semibold">Admin</h1>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        Kelola akun admin sistem
                    </p>
                </div>

                <a href="{{ route('admin.create') }}"
                   class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                    + Tambah Admin
                </a>
            </div>

            <!-- Filter -->
            <form method="GET" class="flex flex-wrap gap-3 mb-5">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama / email"
                       class="px-3 py-2 text-sm rounded-md border
                              border-zinc-300 dark:border-zinc-600
                              bg-white dark:bg-zinc-800">

                <button class="px-4 py-2 text-sm bg-zinc-800 dark:bg-zinc-700 text-white rounded-md">
                    Filter
                </button>
            </form>

            {{-- Alert --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-500 text-white rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-500 text-white rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Grid Card Admin -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($users as $user)

                    <div class="group bg-white dark:bg-zinc-800
                                border border-zinc-200 dark:border-zinc-700
                                rounded-2xl p-5 shadow-sm
                                hover:shadow-xl hover:-translate-y-1
                                transition-all duration-300">

                        <h2 class="text-lg font-semibold">
                            {{ $user->name }}
                        </h2>

                        <p class="text-sm text-zinc-500 mt-1">
                            {{ $user->email }}
                        </p>

                        <div class="mt-3">
                            <span class="inline-block px-2 py-1 text-xs rounded-full
                                {{ $user->role === 'super_admin'
                                    ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300'
                                    : 'bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-200' }}">
                                {{ strtoupper($user->role) }}
                            </span>
                        </div>

                        <!-- Action -->
                        <div class="mt-5 flex gap-2">
                            <a href="{{ route('admin.edit', $user->id) }}"
                               class="px-3 py-1 text-xs bg-amber-500 hover:bg-amber-600
                                      text-white rounded-md">
                                Ubah
                            </a>

                            @if(auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('admin.destroy', $user->id) }}"
                                      onsubmit="return confirm('Hapus admin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-1 text-xs bg-rose-600 hover:bg-rose-700
                                               text-white rounded-md">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>

                @empty
                    <p class="col-span-3 text-center py-6 text-zinc-500">
                        Data admin belum tersedia
                    </p>
                @endforelse

            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>

        </main>
    </div>
</div>

</body>
</html>
