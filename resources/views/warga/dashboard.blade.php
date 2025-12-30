<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Warga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#14b8a6'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-zinc-100 text-zinc-800 dark:bg-zinc-900 dark:text-zinc-100 transition-colors">

    <div class="max-w-5xl mx-auto px-6 py-10">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold">Dashboard Warga</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Login sebagai {{ $warga->Nama }}
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p id="clock" class="font-semibold text-sm"></p>
                    <p id="date" class="text-xs text-zinc-500 dark:text-zinc-400"></p>
                </div>

                <button onclick="document.documentElement.classList.toggle('dark')" class="text-sm px-3 py-1 border rounded
                       border-zinc-300 dark:border-zinc-600">
                    🌙 / ☀️
                </button>

                <form method="POST" action="{{ route('warga.logout') }}">
                    @csrf
                    <button class="text-sm text-red-600 hover:underline">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- IDENTITAS --}}
        <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700
                p-5 rounded-xl shadow-sm mb-8">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Identitas</p>
            <p class="font-semibold">{{ $warga->Nama }}</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                NIK: ****{{ substr($warga->NIK, -4) }}
            </p>
        </div>

        {{-- STATUS --}}
        <div class="grid md:grid-cols-2 gap-6 mb-10">

            <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700
                    p-6 rounded-xl shadow-sm">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Status Iuran Bulan Ini</p>

                <p class="mt-3">
                    @if ($iuranBulanIni && $iuranBulanIni->Status === 'Lunas')
                        <span class="px-3 py-1 rounded-full text-sm
                                                 bg-green-100 text-green-700
                                                 dark:bg-green-500/20 dark:text-green-300">
                            ✅ Lunas
                        </span>
                    @elseif ($iuranBulanIni && $iuranBulanIni->Status === 'Menunggu Konfirmasi')
                        <span class="px-3 py-1 rounded-full text-sm
                                                 bg-yellow-100 text-yellow-700
                                                 dark:bg-yellow-500/20 dark:text-yellow-300">
                            ⏳ Menunggu Konfirmasi
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-sm
                                                 bg-red-100 text-red-700
                                                 dark:bg-red-500/20 dark:text-red-300">
                            ❌ Belum Bayar
                        </span>
                    @endif
                </p>
            </div>

            <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700
                    p-6 rounded-xl shadow-sm">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Tunggakan</p>
                <p class="mt-2 text-xl font-semibold">
                    {{ $totalTunggakan }} bulan
                </p>
            </div>

        </div>

        {{-- ALERT --}}
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

        {{-- CTA --}}
        @php
            $statusMenunggu = $iuranBulanIni &&
                $iuranBulanIni->Status === 'Menunggu Konfirmasi';
        @endphp

        <div class="mb-10">
            @if($totalTunggakan > 0 && !$statusMenunggu)
                <button onclick="openModal({{ $totalTunggakan }})" class="bg-primary hover:bg-teal-700
                                       text-white px-6 py-3 rounded-lg font-semibold transition">
                    Bayar Iuran
                </button>
            @else
                <button disabled class="bg-zinc-400 dark:bg-zinc-600 cursor-not-allowed
                                       text-white px-6 py-3 rounded-lg font-semibold">
                    Bayar Iuran
                </button>

                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ $statusMenunggu ? 'Pembayaran menunggu konfirmasi ⏳' : 'Tidak ada tunggakan 🎉' }}
                </p>
            @endif
        </div>

        {{-- RIWAYAT --}}
        <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700
                p-6 rounded-xl shadow-sm">
            <h2 class="font-semibold mb-4">Riwayat Pembayaran</h2>

            <table class="w-full text-sm">
                <thead class="text-left text-zinc-500 dark:text-zinc-400">
                    <tr>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr class="border-t border-zinc-200 dark:border-zinc-700">
                            <td class="py-2">
                                {{ \Carbon\Carbon::parse($item->Tanggal_Bayar)->format('d M Y') }}
                            </td>
                            <td class="py-2">{{ $item->Status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-4 text-center text-zinc-500 dark:text-zinc-400">
                                Belum ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- MODAL --}}
    <div id="paymentModal" class="fixed inset-0 bg-black/50 hidden
            items-center justify-center overflow-y-auto z-50">>

        <!-- wrapper tengah -->
        <div class="min-h-screen flex items-center justify-center p-4">

            <!-- CARD MODAL (SATU SAJA) -->
            <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700
                    p-6 w-full max-w-md rounded-xl shadow-lg
                    max-h-[90vh] overflow-y-auto">

                <h2 class="text-lg font-semibold mb-1">Pembayaran Iuran</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                    Silakan selesaikan pembayaran sesuai pilihan di bawah
                </p>

                <form method="POST" action="{{ route('iuran.bayar') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="total_bulan" id="totalBulan" value="1">

                    {{-- PILIHAN PEMBAYARAN --}}
                    <div id="opsiTunggakan" class="mb-5 space-y-3 hidden">
                        <p class="text-sm font-medium">Pilih periode pembayaran</p>

                        <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer
                                 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                            <input type="radio" name="mode_bayar" checked onclick="setMode(1)">
                            <span class="text-sm">
                                Bayar bulan ini
                                <span class="block text-xs text-zinc-500">1 bulan</span>
                            </span>
                        </label>

                        <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer
                                 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                            <input type="radio" name="mode_bayar" onclick="setMode({{ $totalTunggakan }})">
                            <span class="text-sm">
                                Bayar semua tunggakan
                                <span class="block text-xs text-zinc-500">
                                    {{ $totalTunggakan }} bulan
                                </span>
                            </span>
                        </label>
                    </div>

                    {{-- TOTAL --}}
                    <div class="mb-5 p-4 rounded-lg bg-zinc-100 dark:bg-zinc-700/50">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Total yang harus dibayar</p>
                        <p class="text-2xl font-bold text-primary">
                            Rp <span id="totalNominal">20.000</span>
                        </p>
                    </div>

                    {{-- QRIS --}}
                    <div class="mb-5 text-center">
                        <p class="text-sm mb-2">Scan QRIS berikut untuk membayar</p>

                        <img src="{{ asset('assets/QRIS.png') }}" class="w-40 mx-auto border rounded-lg mb-3">

                        <a href="{{ asset('assets/QRIS.png') }}" download class="inline-block text-sm px-4 py-2
              bg-zinc-200 dark:bg-zinc-700
              rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600">
                            ⬇️ Download QRIS
                        </a>
                    </div>

                    {{-- UPLOAD --}}
                    <div class="mb-5">
                        <label class="block text-sm mb-1">Upload bukti pembayaran</label>
                        <input type="file" name="bukti_bayar" required class="w-full text-sm
                                  file:bg-primary file:text-white
                                  file:border-0 file:px-4 file:py-2
                                  file:rounded-lg cursor-pointer">
                        <p class="text-xs text-zinc-500 mt-1">
                            Format JPG / PNG, foto harus jelas
                        </p>
                    </div>

                    {{-- ACTION --}}
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm border rounded-lg">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white text-sm rounded-lg font-semibold">
                            Kirim Pembayaran
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script>
        function openModal(tunggakan) {
            setMode(1)
            document.getElementById('opsiTunggakan').classList.toggle('hidden', tunggakan <= 0)
            document.getElementById('paymentModal').classList.remove('hidden')
            document.getElementById('paymentModal').classList.add('flex')
        }

        function closeModal() {
            document.getElementById('paymentModal').classList.add('hidden')
            document.getElementById('paymentModal').classList.remove('flex')
        }

        function setMode(bulan) {
            document.getElementById('totalBulan').value = bulan
            document.getElementById('totalNominal').innerText =
                (bulan * 20000).toLocaleString('id-ID')
        }

        function updateClock() {
            const now = new Date()

            document.getElementById('clock').innerText =
                now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                })

            document.getElementById('date').innerText =
                now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                })
        }

        updateClock()
        setInterval(updateClock, 1000)
    </script>

</body>

</html>