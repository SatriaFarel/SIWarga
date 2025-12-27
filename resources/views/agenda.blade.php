@extends('components.layouts.app')

@section('content')

    <!-- HERO -->
    <section class="bg-gradient-to-br from-teal-600 to-cyan-700 text-white">
        <div class="max-w-7xl mx-auto px-6 py-24 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-sm uppercase tracking-widest opacity-80">
                    Portal RT
                </span>

                <h1 class="text-4xl md:text-5xl font-bold mt-4 leading-tight">
                    Agenda Kegiatan
                </h1>

                <p class="mt-6 max-w-xl opacity-90 leading-relaxed">
                    Daftar agenda dan kegiatan RT yang akan maupun telah
                    dilaksanakan. Informasi disajikan ringkas dan jelas
                    agar mudah dipahami warga.
                </p>
            </div>

            <div class="hidden lg:block text-right text-9xl font-black opacity-20">
                📅
            </div>
        </div>
    </section>

    <!-- AGENDA TERDEKAT -->
    @if ($agenda->count())
        <section class="-mt-20 relative z-10">
            <div class="max-w-7xl mx-auto px-6">
                <div
                    class="bg-white dark:bg-zinc-800
                           rounded-3xl shadow-xl overflow-hidden">

                    <div class="grid md:grid-cols-3">
                        <div
                            class="bg-teal-600 text-white
                                   p-8 flex flex-col justify-center">

                            <span class="text-sm uppercase opacity-80">
                                Agenda Terdekat
                            </span>

                            <h2 class="text-3xl font-bold mt-3">
                                {{ $agenda[0]->Judul }}
                            </h2>

                            <p class="mt-4 text-sm opacity-90">
                                {{ \Carbon\Carbon::parse($agenda[0]->Tanggal_Mulai)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="md:col-span-2 p-10">
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                {{ $agenda[0]->Deskripsi }}
                            </p>

                            <div class="mt-6 flex flex-wrap gap-4 text-sm text-gray-500">
                                <span>📍 {{ $agenda[0]->Lokasi ?? 'Lingkungan RT' }}</span>
                                <span>
                                    ⏰
                                    {{ \Carbon\Carbon::parse($agenda[0]->Tanggal_Mulai)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    <!-- LIST AGENDA -->
    <section class="py-24">
        <div class="max-w-6xl mx-auto px-6">

            <h2 class="text-2xl font-bold mb-10">
                Semua Agenda
            </h2>

            @if ($agenda->count() > 1)
                <div class="space-y-6">
                    @foreach ($agenda->skip(1) as $a)
                        <div
                            class="group flex flex-col md:flex-row gap-6
                                   bg-white dark:bg-zinc-800
                                   rounded-2xl shadow
                                   hover:shadow-xl transition
                                   p-6">

                            <!-- TANGGAL -->
                            <div
                                class="w-full md:w-32
                                       flex md:flex-col justify-between
                                       md:justify-center
                                       text-teal-600 font-bold">

                                <span class="text-3xl">
                                    {{ \Carbon\Carbon::parse($a->Tanggal_Mulai)->format('d') }}
                                </span>
                                <span class="uppercase text-sm">
                                    {{ \Carbon\Carbon::parse($a->Tanggal_Mulai)->format('M Y') }}
                                </span>
                            </div>

                            <!-- ISI -->
                            <div class="flex-1">
                                <h3
                                    class="text-lg font-semibold
                                           group-hover:text-teal-600">
                                    {{ $a->Judul }}
                                </h3>

                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $a->Deskripsi }}
                                </p>

                                <div class="mt-4 text-sm text-gray-500 flex gap-6">
                                    <span>📍 {{ $a->Lokasi ?? 'Lingkungan RT' }}</span>
                                    <span>
                                        📅
                                        {{ \Carbon\Carbon::parse($a->Tanggal_Mulai)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 text-gray-500">
                    Belum ada agenda lain 📭
                </div>
            @endif

        </div>
    </section>

@endsection
