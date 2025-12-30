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

<body class="bg-zinc-100 dark:bg-[#0f0f12] text-zinc-800 dark:text-zinc-100">

<div class="min-h-screen flex flex-col">

    <x-layouts.app.header />

    <div class="flex flex-1">
        <x-layouts.app.sidebar />

        <main class="flex-1 px-6 py-8 max-w-7xl mx-auto w-full">

            {{-- HEADER --}}
            <div class="mb-6">
                <h1 class="text-xl font-semibold">Pesan & Laporan Warga</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Aspirasi, laporan, dan saran dari warga RT
                </p>
            </div>

            {{-- ALERT --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-2 p-4
                            bg-emerald-100 text-emerald-800
                            dark:bg-emerald-500/15 dark:text-emerald-300
                            rounded-lg">
                    ✔️ <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- GRID --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($pesan as $p)
                    <div class="relative
                                bg-white dark:bg-[#18181b]
                                border border-zinc-200 dark:border-zinc-700/60
                                rounded-2xl p-5 shadow-sm
                                hover:shadow-md hover:-translate-y-0.5 transition">

                        {{-- STATUS --}}
                        <div class="absolute top-4 right-4">
                            <span class="px-2 py-0.5 text-xs rounded-full
                                {{ $p->Status === 'Baru'
                                    ? 'bg-zinc-200 text-zinc-700 dark:bg-zinc-700/40 dark:text-zinc-300'
                                    : ($p->Status === 'Dibaca'
                                        ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300'
                                        : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300') }}">
                                {{ $p->Status }}
                            </span>
                        </div>

                        {{-- JENIS --}}
                        <span class="inline-block mb-3 px-3 py-1 text-xs rounded-full
                            {{ $p->Jenis === 'Laporan'
                                ? 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300'
                                : ($p->Jenis === 'Kritik'
                                    ? 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300'
                                    : 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-300') }}">
                            {{ $p->Jenis }}
                        </span>

                        {{-- PESAN --}}
                        <p class="text-sm text-zinc-700 dark:text-zinc-100
                                  leading-relaxed line-clamp-3">
                            {{ $p->Pesan }}
                        </p>

                        {{-- META --}}
                        <div class="mt-3 text-xs text-zinc-500 dark:text-zinc-400">
                            {{ $p->Nama ?? 'Anonim' }} • {{ $p->created_at->format('d M Y') }}
                        </div>

                        {{-- ACTION --}}
                        <div class="mt-5 flex justify-between items-center">

                            <div class="flex gap-2">
                                <button
                                    class="px-3 py-1.5 text-xs rounded-md
                                           bg-indigo-50 text-indigo-700 hover:bg-indigo-100
                                           dark:bg-indigo-500/15 dark:text-indigo-300
                                           hover:dark:bg-indigo-500/25"
                                    onclick="openDetail(
                                        '{{ $p->Jenis }}',
                                        '{{ $p->Nama ?? 'Anonim' }}',
                                        '{{ $p->Email ?? '' }}',
                                        `{{ $p->Pesan }}`,
                                        '{{ $p->created_at->format('d M Y • H:i') }}'
                                    )">
                                    Detail
                                </button>

                                <button
                                    class="px-3 py-1.5 text-xs rounded-md
                                           bg-emerald-50 text-emerald-700 hover:bg-emerald-100
                                           dark:bg-emerald-500/15 dark:text-emerald-300
                                           hover:dark:bg-emerald-500/25"
                                    onclick="openStatusModal('{{ $p->id }}', '{{ $p->Status }}')">
                                    Ubah Status
                                </button>
                            </div>

                            <form method="POST" action="{{ route('pesan.destroy', $p->id) }}"
                                  onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1.5 text-xs rounded-md
                                               bg-rose-600 text-white hover:bg-rose-700
                                               dark:bg-rose-500/80 dark:hover:bg-rose-500">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center py-10 text-zinc-500 dark:text-zinc-400">
                        Belum ada pesan
                    </p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $pesan->links() }}
            </div>

        </main>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div id="detailModal" class="fixed inset-0 hidden z-50 items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-[#1c1c21]
                border border-zinc-200 dark:border-zinc-700
                rounded-xl w-full max-w-lg p-6">
        <button onclick="closeDetail()" class="float-right">✕</button>

        <h3 class="font-semibold mb-3 border-b border-zinc-200 dark:border-zinc-700 pb-2">
            Detail Pesan
        </h3>

        <p><b>Jenis:</b> <span id="dJenis"></span></p>
        <p><b>Nama:</b> <span id="dNama"></span></p>
        <p id="dEmailWrap"><b>Email:</b> <span id="dEmail"></span></p>

        <p class="mt-3 text-sm" id="dPesan"></p>
        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-3" id="dTanggal"></p>
    </div>
</div>

{{-- MODAL STATUS --}}
<div id="statusModal" class="fixed inset-0 hidden z-50 items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-[#1c1c21]
                border border-zinc-200 dark:border-zinc-700
                rounded-xl w-full max-w-sm p-6">

        <h3 class="font-semibold mb-4 border-b border-zinc-200 dark:border-zinc-700 pb-2">
            Ubah Status Pesan
        </h3>

        <form method="POST" action="{{ route('pesan.updateStatus') }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="statusId">

            <select name="status"
                    class="w-full mb-4 px-3 py-2 rounded-md
                           bg-white dark:bg-zinc-900
                           border border-zinc-300 dark:border-zinc-700">
                <option value="Baru">Baru</option>
                <option value="Dibaca">Dibaca</option>
                <option value="Ditindaklanjuti">Ditindaklanjuti</option>
            </select>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeStatusModal()"
                        class="px-3 py-2 border rounded-md
                               border-zinc-300 dark:border-zinc-700">
                    Batal
                </button>
                <button class="px-4 py-2 bg-emerald-600 text-white rounded-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDetail(jenis, nama, email, pesan, tanggal) {
        dJenis.innerText = jenis;
        dNama.innerText = nama;
        dPesan.innerText = pesan;
        dTanggal.innerText = tanggal;

        if (email) {
            dEmail.innerText = email;
            dEmailWrap.style.display = 'block';
        } else {
            dEmailWrap.style.display = 'none';
        }

        detailModal.classList.remove('hidden');
        detailModal.classList.add('flex');
    }

    function closeDetail() {
        detailModal.classList.add('hidden');
        detailModal.classList.remove('flex');
    }

    function openStatusModal(id, status) {
        statusId.value = id;
        document.querySelector('#statusModal select').value = status;
        statusModal.classList.remove('hidden');
        statusModal.classList.add('flex');
    }

    function closeStatusModal() {
        statusModal.classList.add('hidden');
        statusModal.classList.remove('flex');
    }
</script>

</body>
</html>
