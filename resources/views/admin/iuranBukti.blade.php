<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Bukti Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-zinc-100 dark:bg-zinc-900 text-zinc-800 dark:text-zinc-100">

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow max-w-xl w-full p-6">

        <h1 class="text-lg font-semibold mb-2">Bukti Pembayaran</h1>
        <p class="text-sm text-zinc-500 mb-4">
            {{ $iuran->warga->Nama }} — {{ $iuran->bulan }}/{{ $iuran->tahun }}
        </p>

        @if ($iuran->bukti_pembayaran)
            <div class="mb-4 rounded overflow-hidden border">
                <img src="{{ asset($iuran->bukti_pembayaran) }}"
                     class="w-full object-contain">
            </div>
        @else
            <p class="text-center text-red-500 mb-4">
                Bukti pembayaran tidak ditemukan
            </p>
        @endif

        <div class="flex justify-end gap-3">
            <form method="POST" action="{{ route('admin.iuran.tolak', $iuran->id) }}">
                @csrf
                <button onclick="return confirm('Tolak pembayaran ini?')"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded">
                    Tolak
                </button>
            </form>

            <form method="POST" action="{{ route('admin.iuran.acc', $iuran->id) }}">
                @csrf
                <button onclick="return confirm('Konfirmasi pembayaran ini?')"
                        class="px-4 py-2 text-sm bg-green-600 text-white rounded">
                    ACC Pembayaran
                </button>
            </form>
        </div>

        <a href="{{ route('admin.iuran.index') }}"
           class="inline-block mt-4 text-sm text-zinc-500 hover:underline">
            ← Kembali
        </a>
    </div>
</div>

</body>
</html>
