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
                    Informasi & Pengumuman
                </h1>

                <p class="mt-6 max-w-xl opacity-90 leading-relaxed">
                    Kumpulan informasi, pengumuman, dan pemberitahuan resmi RT
                    yang disampaikan secara jelas, singkat, dan transparan
                    untuk seluruh warga.
                </p>
            </div>

            <div class="hidden lg:block text-right text-9xl font-black opacity-20">
                🔔
            </div>
        </div>
    </section>

    <!-- INFORMASI PENTING -->
    @php
        $informasiPenting = $informasi->where('Is_penting', 1);
        $informasiLain = $informasi->where('Is_penting', 0);
    @endphp

    @if ($informasiPenting->count())
        <section class="-mt-20 relative z-10">
            <div class="max-w-7xl mx-auto px-6">
                <div class="bg-white dark:bg-zinc-800
                               rounded-2xl shadow-xl
                               p-8 flex flex-col md:flex-row
                               items-start md:items-center
                               gap-8">

                    <!-- ICON -->
                    <div class="flex-shrink-0
                                   w-16 h-16 rounded-2xl
                                   bg-red-100 text-red-600
                                   flex items-center justify-center
                                   text-3xl">
                        !
                    </div>

                    <!-- ISI -->
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <span class="inline-block px-3 py-1 rounded-full
                                           text-xs font-semibold
                                           bg-red-100 text-red-600">
                                Informasi Penting
                            </span>

                            <span class="text-sm text-gray-400">
                                {{ \Carbon\Carbon::parse($informasiPenting->first()->created_at)->format('d M Y') }}
                            </span>
                        </div>

                        <h2 class="text-2xl font-bold leading-snug">
                            {{ $informasiPenting->first()->Judul }}
                        </h2>

                        <p class="mt-2 text-gray-600 dark:text-gray-300 leading-relaxed">
                            {{ $informasiPenting->first()->Ringkasan }}
                        </p>
                    </div>

                    <!-- CTA -->
                    {{-- <div class="mt-4 md:mt-0">
                        <a href="#" class="inline-flex items-center gap-2
                                       px-5 py-2.5 rounded-xl
                                       bg-red-600 text-white
                                       font-semibold
                                       hover:bg-red-700 transition">
                            Lihat
                            →
                        </a>
                    </div> --}}

                </div>
            </div>
        </section>
    @endif


    <!-- LIST INFORMASI -->
    <section class="py-24">
        <div class="max-w-6xl mx-auto px-6">

            <h2 class="text-2xl font-bold mb-10">
                Semua Informasi
            </h2>

            @if ($informasiLain->count())
                <div class="space-y-6">
                    @foreach ($informasiLain as $item)
                        <div class="group flex flex-col md:flex-row gap-6
                                               bg-white dark:bg-zinc-800
                                               rounded-2xl shadow
                                               hover:shadow-xl transition
                                               p-6">

                            <!-- BADGE -->
                            <div class="w-full md:w-32 flex items-start">
                                <span class="inline-block px-3 py-1 rounded-full
                                                       text-xs font-semibold
                                                       {{ $item->Is_penting
                        ? 'bg-red-100 text-red-600'
                        : 'bg-teal-100 text-teal-700' }}">
                                    {{ $item->Is_penting ? 'Penting' : 'Informasi' }}
                                </span>
                            </div>

                            <!-- ISI -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold
                                                       group-hover:text-teal-600">
                                    {{ $item->Judul }}
                                </h3>

                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $item->Ringkasan }}
                                </p>

                                <p class="mt-4 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                </p>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 text-gray-500">
                    Belum ada informasi 📭
                </div>
            @endif

        </div>
    </section>

@endsection