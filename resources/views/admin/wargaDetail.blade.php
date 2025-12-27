<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Detail Warga - {{ $warga->Nama }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
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
                <h1 class="text-xl font-semibold">Detail Warga</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Informasi lengkap data warga
                </p>
            </div>

            <!-- Card -->
            <div class="bg-white dark:bg-zinc-800
                border border-zinc-200 dark:border-zinc-700
                rounded-lg shadow-sm p-6 space-y-6">

                <!-- Nama -->
                <div>
                    <p class="text-sm text-zinc-500">Nama Lengkap</p>
                    <p class="text-lg font-semibold">{{ $warga->Nama }}</p>
                </div>

                <!-- Grid Data -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-zinc-500">NIK</p>
                        <p class="font-medium">{{ $warga->NIK }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-zinc-500">Jenis Kelamin</p>
                        <p class="font-medium">{{ $warga->Jenis_Kelamin }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-zinc-500">No HP</p>
                        <p class="font-medium">{{ $warga->No_HP }}</p>
                    </div>

                     <!-- STATUS IURAN (Baru Ditambahkan) -->
                    <div>
                        <p class="text-sm text-zinc-500">Status Iuran Bulan Ini</p>

                        @if($warga->iuran_bulan_ini)
                            <p class="inline-block mt-1 px-3 py-1 text-xs rounded-full
                            bg-green-600 text-white">
                                Sudah Bayar
                            </p>
                        @else
                            <p class="inline-block mt-1 px-3 py-1 text-xs rounded-full
                            bg-red-600 text-white">
                                Belum Bayar
                            </p>
                        @endif
                    </div>

                </div>

                <!-- Alamat -->
                <div>
                    <p class="text-sm text-zinc-500">Alamat</p>
                    <p class="font-medium leading-relaxed">
                        {{ $warga->Alamat }}
                    </p>
                </div>

                <!-- Action -->
                <div class="flex justify-between items-center pt-4 border-t
                    border-zinc-200 dark:border-zinc-700">

                    <a href="{{ route('warga.index') }}"
                       class="text-sm text-indigo-500 hover:underline">
                        ← Kembali ke daftar warga
                    </a>

                    <div class="flex gap-2">
                        <a href="{{ route('warga.edit', $warga) }}"
                           class="px-4 py-2 text-sm rounded-md
                           bg-amber-500 hover:bg-amber-600 text-white">
                            Ubah Data
                        </a>

                        <form method="POST"
                              action="{{ route('warga.destroy', $warga) }}"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="px-4 py-2 text-sm rounded-md
                                bg-rose-600 hover:bg-rose-700 text-white">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>

</body>
</html>
