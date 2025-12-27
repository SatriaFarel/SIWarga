<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            body {
                background: white;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-zinc-100 flex justify-center items-center min-h-screen">

<div class="bg-white w-96 p-6 rounded-xl shadow border">
    <h2 class="text-xl font-bold mb-4 text-center">Struk Pembayaran Iuran</h2>

    <div class="text-sm space-y-2">
        <div class="flex justify-between">
            <span>Nama</span>
            <span>{{ session('struk.nama') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Jumlah Bulan</span>
            <span>{{ session('struk.bulan') }} bulan</span>
        </div>
        <div class="flex justify-between font-semibold">
            <span>Total Bayar</span>
            <span>Rp {{ number_format(session('struk.total'),0,',','.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Tanggal</span>
            <span>{{ session('struk.tanggal') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Status</span>
            <span class="text-yellow-600">Menunggu Konfirmasi</span>
        </div>
    </div>

    {{-- BUTTON --}}
    <div class="mt-6 flex justify-center gap-3 no-print">
        <button onclick="window.print()"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
            Download / Print
        </button>

        <a href="{{ route('warga.dashboard') }}"
           class="bg-teal-600 text-white px-4 py-2 rounded-lg">
            Dashboard
        </a>
    </div>
</div>

</body>
</html>
