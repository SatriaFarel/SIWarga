@extends('components.layouts.app')

@section('content')

    <!-- HERO -->
    <section class="relative overflow-hidden bg-gradient-to-br from-teal-700 to-cyan-800 text-white">
        <div class="max-w-7xl mx-auto px-6 py-28 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block mb-4 px-4 py-1 text-xs font-semibold
                             rounded-full bg-white/20 tracking-widest">
                    PORTAL RESMI RT
                </span>

                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
                    Sistem Informasi Warga
                </h1>

                <p class="mt-6 max-w-xl text-white/90 leading-relaxed">
                    Media resmi RT untuk menyampaikan pengumuman,
                    agenda kegiatan, dan artikel edukasi warga
                    secara transparan dan terstruktur.
                </p>
            </div>

            <div class="hidden lg:flex justify-end">
                <div class="text-[9rem] font-black opacity-10 select-none">
                    RT
                </div>
            </div>
        </div>
    </section>

    <!-- INFORMASI -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-12">
                <h2 class="text-3xl font-bold">Informasi Terbaru</h2>
                <p class="text-sm text-zinc-500 mt-2">
                    Pengumuman dan pemberitahuan resmi RT
                </p>
            </div>

            @if ($informasi->count())
                <div class="grid md:grid-cols-2 gap-8">
                    @foreach ($informasi as $item)
                        <div class="bg-white dark:bg-zinc-800
                                            rounded-2xl p-7 shadow-sm
                                            hover:shadow-lg transition">

                            <h3 class="font-semibold text-lg mb-2">
                                {{ $item->Judul }}
                            </h3>

                            <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                {{ $item->Ringkasan }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-14 text-zinc-500">
                    Belum ada informasi 📢
                </div>
            @endif

        </div>
    </section>

    <!-- AGENDA -->
    <section class="py-24 bg-zinc-100 dark:bg-zinc-900">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-12">
                <h2 class="text-3xl font-bold">Agenda Terdekat</h2>
                <p class="text-sm text-zinc-500 mt-2">
                    Kegiatan yang akan dilaksanakan
                </p>
            </div>

            @if ($agenda->count())
                <div class="space-y-6">
                    @foreach ($agenda as $a)
                        <div class="bg-white dark:bg-zinc-800
                                            rounded-2xl p-7 shadow-sm
                                            hover:shadow-lg transition">

                            <div class="flex justify-between items-start gap-6">
                                <div>
                                    <h3 class="font-semibold text-lg">
                                        {{ $a->Judul }}
                                    </h3>

                                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">
                                        {{ $a->Deskripsi }}
                                    </p>
                                </div>

                                <span class="shrink-0 text-sm font-semibold text-teal-600">
                                    {{ \Carbon\Carbon::parse($a->Tanggal_Mulai)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-14 text-zinc-500">
                    Belum ada agenda 📅
                </div>
            @endif

        </div>
    </section>

    <!-- KEGIATAN -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-12">
                <h2 class="text-3xl font-bold">Kegiatan Terlaksana</h2>
                <p class="text-sm text-zinc-500 mt-2">
                    Dokumentasi kegiatan RT yang telah dilaksanakan
                </p>
            </div>

            @if ($kegiatan->count())
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($kegiatan as $k)
                        <div class="bg-white dark:bg-zinc-800
                                            rounded-2xl overflow-hidden
                                            shadow-sm hover:shadow-lg transition">

                            @if ($k->Gambar)
                                <img src="{{ asset($k->Gambar) }}" class="w-full h-44 object-cover">
                            @else
                                <div class="w-full h-44 bg-zinc-200 dark:bg-zinc-700
                                                        flex items-center justify-center
                                                        text-zinc-500 text-sm">
                                    Tidak ada gambar
                                </div>
                            @endif

                            <div class="p-6">
                                <h3 class="font-semibold text-lg mb-2">
                                    {{ $k->Judul }}
                                </h3>

                                <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-4">
                                    {{ $k->Deskripsi }}
                                </p>

                                <p class="text-xs font-semibold text-teal-600">
                                    {{ \Carbon\Carbon::parse($k->Tanggal_Mulai)->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-14 text-zinc-500">
                    Belum ada kegiatan terlaksana
                </div>
            @endif

        </div>
    </section>

    <!-- ARTIKEL -->
    <section class="py-24 bg-zinc-100 dark:bg-zinc-900">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-12">
                <h2 class="text-3xl font-bold">Artikel Warga</h2>
                <p class="text-sm text-zinc-500 mt-2">
                    Edukasi, informasi, dan wawasan lingkungan
                </p>
            </div>

            @if ($artikel->count())
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($artikel as $art)
                        <a href="/artikel/{{ $art->Slug }}" class="group bg-white dark:bg-zinc-800
                                          rounded-2xl overflow-hidden
                                          shadow-sm hover:shadow-xl transition">

                            {{-- Thumbnail --}}
                            @if ($art->Thumbnail)
                                <img src="{{ asset($art->Thumbnail) }}" class="w-full h-44 object-cover
                                                        group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-44 bg-teal-600/10
                                                        flex items-center justify-center
                                                        text-teal-700 font-bold text-xl">
                                    RT
                                </div>
                            @endif

                            {{-- Konten --}}
                            <div class="p-6">

                                <h3 class="font-semibold text-lg leading-snug
                                                   group-hover:text-teal-600 transition">
                                    {{ $art->Judul }}
                                </h3>

                                {{-- META --}}
                                <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1
                                                    text-xs text-zinc-500">

                                    <span>
                                        ✍️ {{ $art->Penulis ?? 'Admin RT' }}
                                    </span>

                                    <span>
                                        📅 {{ $art->created_at->format('d M Y') }}
                                    </span>
                                </div>

                                @if(!empty($art->Ringkasan))
                                    <p class="mt-4 text-sm text-zinc-600 dark:text-zinc-300 line-clamp-3">
                                        {{ $art->Ringkasan }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="py-14 text-zinc-500">
                    Belum ada artikel 📚
                </div>
            @endif

        </div>
    </section>



@endsection