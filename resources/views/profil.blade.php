@extends('components.layouts.app')

@section('content')

<!-- HERO -->
<section class="bg-gradient-to-br from-teal-600 to-cyan-700 text-white">
    <div class="max-w-7xl mx-auto px-6 py-24">
        <span class="text-sm uppercase tracking-widest opacity-80">
            Profil Resmi
        </span>

        <h1 class="text-4xl md:text-5xl font-bold mt-4">
            Rukun Tetangga 05 / RW 03
        </h1>

        <p class="mt-6 max-w-3xl opacity-90 leading-relaxed">
            Halaman ini berisi gambaran umum mengenai kepengurusan,
            visi misi, serta kondisi wilayah RT sebagai bentuk transparansi
            dan keterbukaan informasi kepada seluruh warga.
        </p>

        <div class="mt-8 flex flex-wrap gap-6 text-sm">
            <span class="px-4 py-2 rounded-xl bg-white/20">📍 Jakarta Timur</span>
            <span class="px-4 py-2 rounded-xl bg-white/20">🏘️ Permukiman Warga</span>
            <span class="px-4 py-2 rounded-xl bg-white/20">👥 ±120 KK</span>
        </div>
    </div>
</section>

<!-- TENTANG RT -->
<section class="py-24">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-start">

        <div>
            <h2 class="text-2xl font-bold mb-4">
                Tentang RT
            </h2>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                RT 05 merupakan bagian dari RW 03 yang berperan sebagai
                penghubung antara warga dan pengurus wilayah.
                Kegiatan RT meliputi pelayanan administrasi warga,
                koordinasi keamanan lingkungan, serta pengelolaan
                kegiatan sosial dan kemasyarakatan.
            </p>
        </div>

        <div class="space-y-4">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-5 shadow">
                🛡️ Fokus pada keamanan & ketertiban
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-5 shadow">
                🤝 Mengedepankan musyawarah warga
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-5 shadow">
                📢 Transparansi informasi & kegiatan
            </div>
        </div>

    </div>
</section>

<!-- STRUKTUR RT -->
<section class="py-24 bg-zinc-100 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-2xl font-bold mb-12">
            Struktur Kepengurusan
        </h2>

        <div class="grid lg:grid-cols-3 gap-10">

            <!-- Ketua -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl p-8 shadow">
                <h3 class="text-lg font-bold mb-1">Ketua RT</h3>
                <p class="text-teal-600 font-semibold">Budi Santoso</p>
                <p class="text-sm text-gray-500 mt-3">
                    Bertanggung jawab atas koordinasi kegiatan RT,
                    pengambilan keputusan, dan hubungan dengan RW.
                </p>
            </div>

            <!-- Sekretaris -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl p-8 shadow">
                <h3 class="text-lg font-bold mb-1">Sekretaris</h3>
                <p class="text-teal-600 font-semibold">Siti Aisyah</p>
                <p class="text-sm text-gray-500 mt-3">
                    Mengelola administrasi, surat-menyurat,
                    serta dokumentasi kegiatan RT.
                </p>
            </div>

            <!-- Bendahara -->
            <div class="bg-white dark:bg-zinc-800 rounded-2xl p-8 shadow">
                <h3 class="text-lg font-bold mb-1">Bendahara</h3>
                <p class="text-teal-600 font-semibold">Rina Lestari</p>
                <p class="text-sm text-gray-500 mt-3">
                    Mengelola keuangan RT secara transparan
                    dan bertanggung jawab.
                </p>
            </div>

        </div>

    </div>
</section>

<!-- VISI & MISI -->
<section class="py-24">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12">

        <div>
            <h2 class="text-2xl font-bold mb-4">Visi</h2>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                Mewujudkan lingkungan RT yang aman, tertib,
                harmonis, dan aktif melalui partisipasi
                serta kebersamaan seluruh warga.
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">Misi</h2>
            <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                <li>✔ Memberikan pelayanan yang cepat dan adil</li>
                <li>✔ Menjaga keamanan dan ketertiban lingkungan</li>
                <li>✔ Mendorong kegiatan sosial dan gotong royong</li>
                <li>✔ Menyampaikan informasi secara terbuka</li>
            </ul>
        </div>

    </div>
</section>

<!-- DATA WILAYAH -->
<section class="py-24 bg-zinc-100 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-2xl font-bold mb-12">
            Data Singkat Wilayah
        </h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow">
                <p class="text-sm text-gray-500">Jumlah KK</p>
                <p class="text-3xl font-bold mt-1">120</p>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow">
                <p class="text-sm text-gray-500">Jumlah Warga</p>
                <p class="text-3xl font-bold mt-1">380</p>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow">
                <p class="text-sm text-gray-500">Wilayah</p>
                <p class="text-lg font-semibold mt-2">Permukiman</p>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow">
                <p class="text-sm text-gray-500">RW</p>
                <p class="text-lg font-semibold mt-2">03</p>
            </div>
        </div>

    </div>
</section>

@endsection
