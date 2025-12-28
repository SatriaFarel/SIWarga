@extends('components.layouts.app')

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-gradient-to-br from-teal-600 to-cyan-700 text-white">
    <div class="max-w-7xl mx-auto px-6 py-28 grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <span class="text-sm uppercase tracking-widest opacity-80">
                Portal RT
            </span>

            <h1 class="text-4xl md:text-5xl font-bold mt-4 leading-tight">
                Artikel & Edukasi Warga
            </h1>

            <p class="mt-6 max-w-xl opacity-90 leading-relaxed">
                Kumpulan artikel terbaru seputar kegiatan, edukasi,
                dan informasi lingkungan RT yang disusun ringkas,
                jelas, dan mudah dipahami warga.
            </p>
        </div>

        <div class="hidden lg:block opacity-20 text-right text-9xl font-black select-none">
            RT
        </div>
    </div>
</section>

<!-- FEATURED -->
@if ($featured)
<section class="-mt-20 relative z-10">
    <div class="max-w-7xl mx-auto px-6">
        <a href="/artikel/{{ $featured->Slug }}"
           class="block bg-white dark:bg-zinc-800 rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition">

            <div class="flex flex-col md:flex-row">

                <!-- GAMBAR -->
                <div class="w-full md:w-1/2 h-56 md:h-72 overflow-hidden">
                    @if ($featured->Thumbnail)
                        <img src="{{ asset($featured->Thumbnail) }}"
                             alt="{{ $featured->Judul }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-teal-600/10 flex items-center justify-center text-teal-700 font-semibold">
                            Portal Warga
                        </div>
                    @endif
                </div>

                <!-- KONTEN -->
                <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
                    <span class="inline-block mb-3 px-3 py-1 rounded-full bg-teal-100 text-teal-700 text-xs font-semibold">
                        Featured
                    </span>

                    <h2 class="text-3xl font-bold leading-tight hover:text-teal-600 transition">
                        {{ $featured->Judul }}
                    </h2>

                    <p class="mt-4 text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ Str::limit(strip_tags($featured->Konten), 220) }}
                    </p>

                    <p class="mt-6 text-sm text-gray-400">
                        {{ \Carbon\Carbon::parse($featured->created_at)->format('d M Y') }}
                    </p>
                </div>

            </div>
        </a>
    </div>
</section>
@endif

<!-- GRID ARTIKEL -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-2xl font-bold mb-10">
            Artikel Terbaru
        </h2>

        @if ($artikel->count())
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($artikel as $item)
                    <a href="/artikel/{{ $item->Slug }}"
                       class="group bg-white dark:bg-zinc-800 rounded-2xl shadow hover:-translate-y-1 hover:shadow-xl transition overflow-hidden">

                        <div class="h-44 overflow-hidden">
                            @if ($item->Thumbnail)
                                <img src="{{ asset($item->Thumbnail) }}"
                                     alt="{{ $item->Judul }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-teal-600/10 flex items-center justify-center text-teal-700 font-semibold">
                                    Portal Warga
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <h3 class="font-semibold text-lg leading-snug group-hover:text-teal-600 transition">
                                {{ $item->Judul }}
                            </h3>

                            <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ Str::limit(strip_tags($item->Konten), 110) }}
                            </p>

                            <p class="mt-5 text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-10 text-center shadow">
                <p class="text-gray-500">
                    Belum ada artikel yang dipublikasikan.
                </p>
            </div>
        @endif

    </div>
</section>

<!-- ARSIP ARTIKEL -->
<section class="py-24 bg-gray-100 dark:bg-zinc-900">
    <div class="max-w-5xl mx-auto px-6">

        <h2 class="text-2xl font-bold mb-10">
            Arsip Artikel
        </h2>

        @if ($artikelLama->count())
            <div class="space-y-4">
                @foreach ($artikelLama as $old)
                    <a href="/artikel/{{ $old->Slug }}"
                       class="group flex items-start gap-6 bg-white dark:bg-zinc-800 p-6 rounded-xl shadow hover:shadow-lg transition">

                        <span class="text-sm font-semibold text-teal-600 w-20 shrink-0">
                            {{ \Carbon\Carbon::parse($old->created_at)->format('d M') }}
                        </span>

                        <div>
                            <h3 class="font-semibold leading-snug group-hover:text-teal-600 transition">
                                {{ $old->Judul }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($old->created_at)->format('Y') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-8 text-center shadow">
                <p class="text-gray-500">
                    Arsip artikel masih kosong.
                </p>
            </div>
        @endif

    </div>
</section>

@endsection
