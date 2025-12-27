<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Sistem Informasi RT</title>

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

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-zinc-100 dark:bg-zinc-900 text-zinc-800 dark:text-zinc-100">

<div class="min-h-screen flex flex-col">

    <!-- Top Bar -->
    <x-layouts.app.header />

    <div class="flex flex-1">
        <x-layouts.app.sidebar />

        <!-- Main Content -->
        <main class="flex-1 px-6 py-8 max-w-7xl mx-auto w-full">

            <h1 class="text-xl font-semibold mb-1">Dashboard</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-6">
                Ringkasan informasi wilayah RT
            </p>

            <!-- Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">

                <div class="p-5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md">
                    <p class="text-xs uppercase text-zinc-500">Jumlah Warga</p>
                    <p class="text-2xl font-semibold">{{ $warga }}</p>
                </div>

                <div class="p-5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md">
                    <p class="text-xs uppercase text-zinc-500">Artikel</p>
                    <p class="text-2xl font-semibold">{{ $artikel }}</p>
                </div>

                <div class="p-5 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md">
                    <p class="text-xs uppercase text-zinc-500">Pengumuman Terbaru</p>
                    <p class="text-sm font-medium mt-1">
                        {{ $informasi->Judul ?? 'Belum ada pengumuman' }}
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Artikel Terbaru -->
                <section class="lg:col-span-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md p-6">
                    <h2 class="text-sm font-semibold uppercase mb-4">Artikel Terbaru</h2>

                    @if($artikelTerbaru->isEmpty())
                        <p class="text-sm text-zinc-500">Belum ada artikel.</p>
                    @else
                        <div class="divide-y dark:divide-zinc-700">
                            @foreach($artikelTerbaru as $item)
                                <div class="py-3 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">{{ $item->Judul }}</p>
                                        <p class="text-xs text-zinc-500">
                                            {{ $item->created_at->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('artikel.show', $item->Slug) }}"
                                       class="text-blue-600 text-xs hover:underline">
                                        Visit →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Sidebar Kanan -->
                <div class="space-y-6">

                    <!-- Info RT -->
                    <section class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md p-6">
                        <h2 class="text-sm font-semibold uppercase mb-4">Info RT</h2>

                        @if(!$profilRT)
                            <p class="text-sm text-zinc-500">Profil RT belum diisi.</p>
                        @else
                            <div class="space-y-2 text-sm">
                                <p><span class="text-zinc-500">Ketua RT:</span> {{ $profilRT->ketua_rt ?? "RT" }}</p>
                                <p><span class="text-zinc-500">Periode:</span> {{ $profilRT->periode ?? "2020-2025" }}</p>
                                <p><span class="text-zinc-500">Jumlah KK:</span> {{ $profilRT->jumlah_kk ?? "200" }}</p>
                                <p><span class="text-zinc-500">Kontak:</span> {{ $profilRT->kontak ?? "200" }}</p>
                            </div>
                        @endif
                    </section>

                    <!-- Agenda Terdekat -->
                    <section class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md p-6">
                        <h2 class="text-sm font-semibold uppercase mb-4">Agenda Terdekat</h2>

                        @if($agendaTerdekat->isEmpty())
                            <p class="text-sm text-zinc-500">Tidak ada agenda terdekat.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($agendaTerdekat as $agenda)
                                    @php
                                        $isToday = \Carbon\Carbon::parse($agenda->Tanggal_Mulai)->isToday();
                                    @endphp

                                    <div class="p-3 border border-zinc-200 dark:border-zinc-700 rounded-md">
                                        <div class="flex items-start justify-between">
                                            <p class="font-medium text-sm">{{ $agenda->Judul }}</p>

                                            @if($isToday)
                                                <span class="text-[10px] px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300">
                                                    Hari ini
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-xs text-zinc-500 mt-1">
                                            {{ \Carbon\Carbon::parse($agenda->Tanggal_Mulai)->translatedFormat('d F Y') }}
                                            • {{ $agenda->Lokasi }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>

                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>
