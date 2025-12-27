<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Warga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-zinc-100 text-zinc-800">
<div class="max-w-5xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="flex justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold">Dashboard Warga</h1>
            <p class="text-sm text-zinc-500">Login sebagai {{ $warga->Nama }}</p>
        </div>
        <form method="POST" action="{{ route('warga.logout') }}">
            @csrf
            <button class="text-sm text-red-600 hover:underline">Logout</button>
        </form>
    </div>

    {{-- INFO --}}
    <div class="bg-white p-5 rounded-xl shadow mb-8">
        <p class="text-sm text-zinc-500">Identitas</p>
        <p class="font-semibold">{{ $warga->Nama }}</p>
        <p class="text-sm text-zinc-500">
            NIK: ****{{ substr($warga->NIK, -4) }}
        </p>
    </div>

    {{-- STATUS --}}
    <div class="grid md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-zinc-500">Status Iuran Bulan Ini</p>
            <p class="mt-2 text-xl font-semibold">
                @if ($iuranBulanIni)
                    @if ($iuranBulanIni->Status === 'Lunas')
                        ✅ Lunas
                    @elseif ($iuranBulanIni->Status === 'Menunggu Konfirmasi')
                        ⏳ Menunggu Konfirmasi
                    @else
                        ❌ Belum Bayar
                    @endif
                @else
                    ❌ Belum Bayar
                @endif
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-zinc-500">Total Tunggakan</p>
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
    <div class="mb-10">
        <button onclick="openModal({{ $totalTunggakan }})"
            class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg font-semibold">
            Bayar Iuran
        </button>
    </div>

    {{-- RIWAYAT --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="font-semibold mb-4">Riwayat Pembayaran</h2>
        <table class="w-full text-sm">
            <thead class="text-left text-zinc-500">
                <tr>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($riwayat as $item)
                <tr class="border-t">
                    <td class="py-2">
                        {{ \Carbon\Carbon::parse($item->Tanggal_Bayar)->format('d M Y') }}
                    </td>
                    <td class="py-2">
                        {{ $item->Status }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="py-4 text-center text-zinc-500">
                        Belum ada data
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MODAL ================= --}}
<div id="paymentModal"
     class="fixed inset-0 bg-black/50 hidden justify-center items-center">

    <div class="bg-white p-6 w-80 rounded-lg">

        <h2 class="text-lg font-semibold mb-4">Bayar Iuran</h2>

        <form method="POST"
              action="{{ route('iuran.bayar') }}"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="total_bulan" id="totalBulan" value="1">

            {{-- OPSI TUNGGAKAN --}}
            <div id="opsiTunggakan" class="space-y-2 mb-4 hidden">
                <label class="flex gap-2 text-sm">
                    <input type="radio"
                           name="mode_bayar"
                           checked
                           onclick="setMode(1)">
                    Bulan ini
                </label>

                <label class="flex gap-2 text-sm">
                    <input type="radio"
                           name="mode_bayar"
                           onclick="setMode({{ $totalTunggakan }})">
                    Semua tunggakan ({{ $totalTunggakan }} bulan)
                </label>
            </div>

            {{-- TOTAL --}}
            <div class="mb-4">
                <p class="text-sm">Total Bayar</p>
                <p class="font-semibold">
                    Rp <span id="totalNominal">20.000</span>
                </p>
            </div>

            {{-- QRIS --}}
            <div class="mb-4">
                <p class="text-sm mb-1">Scan QRIS</p>
                <img src="{{ asset('qris/qris-rt.png') }}"
                     class="w-40 mx-auto border rounded">
            </div>

            {{-- UPLOAD --}}
            <div class="mb-4">
                <label class="text-sm">Upload Bukti</label>
                <input type="file"
                       name="bukti_bayar"
                       required
                       class="w-full text-sm">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeModal()"
                        class="px-3 py-2 bg-zinc-500 text-white text-sm rounded">
                    Batal
                </button>
                <button type="submit"
                        class="px-3 py-2 bg-indigo-600 text-white text-sm rounded">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
function openModal(tunggakan) {
    const modal = document.getElementById('paymentModal');
    const opsi  = document.getElementById('opsiTunggakan');

    // default: selalu bisa bayar 1 bulan
    setMode(1);

    if (tunggakan > 0) {
        opsi.classList.remove('hidden');
    } else {
        opsi.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('paymentModal');
    const opsi  = document.getElementById('opsiTunggakan');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    opsi.classList.add('hidden');
    setMode(1);
}

function setMode(bulan) {
    document.getElementById('totalBulan').value = bulan;
    document.getElementById('totalNominal').innerText =
        (bulan * 20000).toLocaleString('id-ID');
}
</script>

</body>
</html>
