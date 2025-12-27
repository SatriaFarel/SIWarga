<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Iuran Warga</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .modal {
            display: none;
        }

        .modal:target {
            display: flex;
        }
    </style>
</head>

<body class="bg-zinc-100 dark:bg-zinc-900 text-zinc-800 dark:text-zinc-100">

    @php
        $startMonth = 11;
        $startYear = 2025;

        $isAktif =
            ($tahun > $startYear) ||
            ($tahun == $startYear && $bulan >= $startMonth);
    @endphp

    <div class="min-h-screen flex flex-col">

        <x-layouts.app.header />

        <div class="flex flex-1">
            <x-layouts.app.sidebar />

            <main class="flex-1 px-6 py-8 max-w-7xl mx-auto w-full">

                {{-- HEADER --}}
                <div class="mb-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-semibold">Iuran Warga</h1>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            Iuran bulanan tetap Rp 20.000 / warga
                        </p>
                    </div>

                    <a href="{{ route('warga.index') }}" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-md">
                        ← Kembali ke Warga
                    </a>
                </div>

                {{-- FILTER --}}
                <form method="GET" class="flex gap-3 mb-5">
                    <select name="bulan" class="px-3 py-2 text-sm rounded-md border bg-white dark:bg-zinc-800">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $bulan == sprintf('%02d', $m) ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endfor
                    </select>

                    <select name="tahun" class="px-3 py-2 text-sm rounded-md border bg-white dark:bg-zinc-800">
                        @for ($t = 2025; $t <= date('Y') + 1; $t++)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endfor
                    </select>

                    <button class="px-4 py-2 text-sm bg-zinc-800 text-white rounded-md">
                        Filter
                    </button>
                </form>

                {{-- TABLE --}}
                <div class="overflow-x-auto bg-white dark:bg-zinc-800 border rounded-md">
                    <table class="min-w-full text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-700">
                            <tr>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">NIK</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y dark:divide-zinc-700">

                            @if (!$isAktif)
                                <tr>
                                    <td colspan="4" class="px-4 py-10 text-center text-zinc-500">
                                        Tidak ada tagihan sebelum November 2025
                                    </td>
                                </tr>
                            @else
                                @foreach ($warga as $item)
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/30">

                                        <td class="px-4 py-3 font-medium">{{ $item->Nama }}</td>
                                        <td class="px-4 py-3">****{{ substr($item->NIK, -4) }}</td>

                                        <td class="px-4 py-3">
                                            @if ($item->status_iuran === 'Lunas')
                                                <span class="px-2 py-1 text-xs bg-green-600 text-white rounded">Lunas</span>
                                            @elseif ($item->status_iuran === 'Menunggu Konfirmasi')
                                                <span class="px-2 py-1 text-xs bg-yellow-500 text-white rounded">
                                                    Menunggu Konfirmasi
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-red-600 text-white rounded">
                                                    Belum Bayar
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-center space-x-1">

                                            @if ($item->status_iuran === 'Menunggu Konfirmasi' && $item->iuran_id)
                                                <a href="#bukti-{{ $item->iuran_id }}"
                                                    class="px-3 py-1 text-xs bg-indigo-600 text-white rounded">
                                                    Cek Bukti
                                                </a>
                                            @endif

                                            @if ($item->status_iuran === 'Belum Bayar')
                                                <form method="POST" action="{{ route('admin.iuran.manual', $item->id) }}"
                                                    class="inline">
                                                    @csrf
                                                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                                                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                                                    <button type="submit" onclick="return confirm('Bayar iuran langsung?')"
                                                        class="px-3 py-1 text-xs bg-green-600 text-white rounded">
                                                        Bayar Langsung
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- MODAL CEK BUKTI --}}
                                    @if ($item->status_iuran === 'Menunggu Konfirmasi' && $item->iuran_id)
                                        <div id="bukti-{{ $item->iuran_id }}"
                                            class="modal fixed inset-0 z-50 items-center justify-center bg-black/50">

                                            <div class="bg-white dark:bg-zinc-800 rounded-lg w-full max-w-lg p-5 relative">

                                                <a href="#" class="absolute top-3 right-3 text-zinc-500 hover:text-zinc-700">
                                                    ✕
                                                </a>

                                                <h2 class="text-lg font-semibold mb-1">
                                                    Bukti Pembayaran
                                                </h2>
                                                <p class="text-sm text-zinc-500 mb-4">
                                                    {{ $item->Nama }} — {{ $bulan }}/{{ $tahun }}
                                                </p>

                                                @if ($item->bukti)
                                                    <div class="mb-4 border rounded overflow-hidden">
                                                        <img src="{{ asset("storage/" . $item->bukti) }}" class="w-full object-contain">
                                                    </div>
                                                @else
                                                    <p class="text-center text-red-500 mb-4">
                                                        Bukti tidak ditemukan
                                                    </p>
                                                @endif

                                                <div class="flex justify-end gap-2">
                                                    <form method="POST" action="{{ route('admin.iuran.tolak', $item->iuran_id) }}">
                                                        @csrf
                                                        <button onclick="return confirm('Tolak pembayaran ini?')"
                                                            class="px-4 py-2 text-sm bg-red-600 text-white rounded">
                                                            Tolak
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('admin.iuran.acc', $item->iuran_id) }}">
                                                        @csrf
                                                        <button onclick="return confirm('Konfirmasi pembayaran ini?')"
                                                            class="px-4 py-2 text-sm bg-green-600 text-white rounded">
                                                            ACC
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

</body>

</html>