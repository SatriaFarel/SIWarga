<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan & Laporan Warga</title>

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
            <div class="mb-6">
                <h1 class="text-xl font-semibold">Pesan & Laporan Warga</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Aspirasi, laporan, dan saran dari warga RT
                </p>
            </div>

            <!-- Alert -->
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3
                            bg-emerald-50 dark:bg-emerald-900/30
                            border border-emerald-200 dark:border-emerald-800
                            rounded-xl p-4">
                    <span class="font-bold text-emerald-600">✓</span>
                    <span class="text-sm text-emerald-700 dark:text-emerald-300">
                        {{ session('success') }}
                    </span>
                </div>
            @endif

            <!-- Grid Pesan -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($pesan as $p)
                    <div
                        class="bg-white dark:bg-zinc-800
                               border border-zinc-200 dark:border-zinc-700
                               rounded-2xl p-5 shadow-sm
                               hover:shadow-xl transition">

                        <!-- Badge Jenis -->
                        <span
                            class="inline-block mb-3 px-3 py-1 text-xs font-semibold rounded-full
                            {{ $p->Jenis === 'Laporan'
                                ? 'bg-rose-100 text-rose-700'
                                : ($p->Jenis === 'Kritik'
                                    ? 'bg-amber-100 text-amber-700'
                                    : 'bg-indigo-100 text-indigo-700') }}">
                            {{ $p->Jenis }}
                        </span>

                        <!-- Preview Pesan -->
                        <p class="text-sm text-zinc-700 dark:text-zinc-300 line-clamp-3">
                            {{ $p->Pesan }}
                        </p>

                        <!-- Meta -->
                        <div class="mt-4 text-xs text-zinc-500">
                            {{ $p->Nama ?? 'Anonim' }} •
                            {{ $p->created_at->format('d M Y') }}
                        </div>

                        <!-- Action -->
                        <div class="mt-4 flex justify-between">
                            <button
                                class="text-xs font-semibold text-indigo-600 hover:underline"
                                onclick="openModal(
                                    '{{ $p->Jenis }}',
                                    '{{ $p->Nama ?? 'Anonim' }}',
                                    '{{ $p->Email ?? '' }}',
                                    `{{ $p->Pesan }}`,
                                    '{{ $p->created_at->format('d M Y • H:i') }}'
                                )">
                                Detail
                            </button>

                            <form method="POST"
                                  action="{{ route('pesan.destroy', $p->id) }}"
                                  onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="px-3 py-1 text-xs
                                           bg-rose-600 hover:bg-rose-700
                                           text-white rounded-md">
                                    Hapus
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <p class="col-span-3 text-center py-10 text-zinc-500">
                        Belum ada pesan 📭
                    </p>
                @endforelse

            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $pesan->links() }}
            </div>

        </main>
    </div>
</div>

<!-- MODAL DETAIL -->
<div id="modal"
     class="fixed inset-0 z-50 hidden items-center justify-center
            bg-black/40 backdrop-blur-sm">

    <div class="bg-white dark:bg-zinc-900
                rounded-2xl max-w-lg w-full
                p-6 shadow-xl relative">

        <button
            onclick="closeModal()"
            class="absolute top-4 right-4
                   text-zinc-400 hover:text-zinc-600">
            ✕
        </button>

        <h3 class="text-lg font-semibold mb-4">
            Detail Pesan Warga
        </h3>

        <div class="space-y-3 text-sm">
            <p><b>Jenis:</b> <span id="mJenis"></span></p>
            <p><b>Nama:</b> <span id="mNama"></span></p>

            <p id="emailRow" class="hidden">
                <b>Email:</b> <span id="mEmail"></span>
            </p>

            <p class="pt-3 border-t leading-relaxed" id="mPesan"></p>

            <p class="text-xs text-zinc-500" id="mTanggal"></p>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script>
    function openModal(jenis, nama, email, pesan, tanggal) {
        document.getElementById('mJenis').innerText = jenis;
        document.getElementById('mNama').innerText = nama;
        document.getElementById('mPesan').innerText = pesan;
        document.getElementById('mTanggal').innerText = tanggal;

        if (email) {
            document.getElementById('emailRow').classList.remove('hidden');
            document.getElementById('mEmail').innerText = email;
        } else {
            document.getElementById('emailRow').classList.add('hidden');
        }

        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('modal').classList.remove('flex');
    }
</script>

</body>
</html>
