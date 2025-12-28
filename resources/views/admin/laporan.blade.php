<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Iuran — Sistem Informasi RT</title>

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
    <x-layouts.app.header />

    <div class="flex flex-1">
        <x-layouts.app.sidebar />

        <main class="flex-1 px-6 py-8 max-w-7xl mx-auto w-full">

            <h1 class="text-xl font-semibold mb-1">Laporan Iuran</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-6">
                Rekap pembayaran iuran warga (all periode sejak Nov 2025)
            </p>

            <!-- Filter -->
            <form method="GET" class="flex flex-wrap gap-3 mb-6">
                <select name="bulan"
                    class="border border-zinc-300 dark:border-zinc-700
                           bg-white dark:bg-zinc-800
                           text-zinc-800 dark:text-zinc-100
                           px-3 py-2 rounded text-sm">
                    @for($i=1;$i<=12;$i++)
                        <option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                <select name="tahun"
                    class="border border-zinc-300 dark:border-zinc-700
                           bg-white dark:bg-zinc-800
                           text-zinc-800 dark:text-zinc-100
                           px-3 py-2 rounded text-sm">
                    @for($y=now()->year;$y>=now()->year-5;$y--)
                        <option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>

                <button
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700
                           text-white rounded text-sm">
                    Tampilkan
                </button>

                <a
                    href="{{ route('laporan.print', request()->query()) }}"
                    class="px-4 py-2 rounded text-sm
                           border border-zinc-300 dark:border-zinc-700
                           bg-white dark:bg-zinc-800
                           text-zinc-700 dark:text-zinc-200
                           hover:bg-zinc-100 dark:hover:bg-zinc-700">
                    Print
                </a>
            </form>

            <!-- Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
                <div class="p-5 bg-white dark:bg-zinc-800 border dark:border-zinc-700 rounded">
                    <p class="text-xs uppercase text-zinc-500">Total Pemasukan</p>
                    <p class="text-2xl font-semibold">
                        Rp {{ number_format($totalPemasukan,0,',','.') }}
                    </p>
                </div>

                <div class="p-5 bg-white dark:bg-zinc-800 border dark:border-zinc-700 rounded">
                    <p class="text-xs uppercase text-zinc-500">Persentase</p>
                    <p class="text-2xl font-semibold">
                        {{ $persentase }}%
                    </p>
                </div>
            </div>

            <!-- Tabel -->
            <div class="bg-white dark:bg-zinc-800 border dark:border-zinc-700 rounded overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-100 dark:bg-zinc-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Tanggal Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataLaporan as $iuran)
                            <tr class="border-t dark:border-zinc-700">
                                <td class="px-4 py-2">{{ $iuran->nama }}</td>
                                <td class="px-4 py-2">
                                    @if($iuran->status === 'Lunas')
                                        <span class="text-emerald-600 font-medium">Lunas</span>
                                    @else
                                        <span class="text-red-500">Belum</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    {{ $iuran->tanggal_bayar
                                        ? \Carbon\Carbon::parse($iuran->tanggal_bayar)->translatedFormat('d F Y')
                                        : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-zinc-500">
                                    Tidak ada data iuran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

</body>
</html>
