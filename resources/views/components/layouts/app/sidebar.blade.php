<style>
    /* MOBILE SIDEBAR TARGET */
    #mobile-sidebar {
        display: none;
    }

    #mobile-sidebar:target {
        display: block;
    }
</style>

{{-- ======================
SIDEBAR DESKTOP
====================== --}}
<aside class="hidden md:block w-60 bg-white dark:bg-zinc-800
            border-r border-zinc-200 dark:border-zinc-700
            px-4 py-6">

    <nav class="space-y-6 text-sm">

        {{-- UTAMA --}}
        <div class="space-y-1">
            <p class="px-4 text-xs font-semibold text-zinc-400 uppercase">
                Utama
            </p>

            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-md
               {{ request()->routeIs('dashboard')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                Dashboard
            </a>
        </div>

        {{-- DATA --}}
        <div class="space-y-1">
            <p class="px-4 text-xs font-semibold text-zinc-400 uppercase">
                Data
            </p>

            <a href="{{ route('warga.index') }}" class="block px-4 py-2 rounded-md
               {{ request()->routeIs('warga.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                Data Warga
            </a>
        </div>

        {{-- KONTEN --}}
        <div class="space-y-1">
            <p class="px-4 text-xs font-semibold text-zinc-400 uppercase">
                Konten
            </p>

            <a href="{{ route('artikel.index') }}" class="block px-4 py-2 rounded-md
               {{ request()->routeIs('artikel.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                Artikel
            </a>

            <a href="{{ route('agenda.index') }}" class="block px-4 py-2 rounded-md
               {{ request()->routeIs('agenda.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                Agenda
            </a>

            <a href="{{ route('informasi.index') }}" class="block px-4 py-2 rounded-md
               {{ request()->routeIs('informasi.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                Informasi
            </a>
        </div>

        {{-- ADMIN --}}
        <div class="space-y-1">
            <p class="px-4 text-xs font-semibold text-zinc-400 uppercase">
                Administrasi
            </p>

            <a href="{{ route('arsip.index') }}" class="block px-4 py-2 rounded-md
               {{ request()->routeIs('arsip.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                Arsip Dokumen
            </a>

            <a href="{{ route('laporan.iuran') }}" class="block px-4 py-2 rounded-md
               {{ request()->routeIs('laporan.iuran*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                Laporan Iuran
            </a>
        </div>

        {{-- LOGOUT --}}
        <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-sm px-4 py-2 rounded-md
                               bg-zinc-100 dark:bg-zinc-700
                               hover:bg-zinc-200 dark:hover:bg-zinc-600 transition">
                    Logout
                </button>
            </form>
        </div>

    </nav>
</aside>

{{-- ======================
SIDEBAR MOBILE (DRAWER)
====================== --}}
<div id="mobile-sidebar" class="fixed inset-0 z-50 md:hidden">

    {{-- OVERLAY --}}
    <a href="#" class="absolute inset-0 bg-black/40"></a>

    {{-- DRAWER --}}
    <aside class="absolute left-0 top-0 h-full w-64
                 bg-white dark:bg-zinc-800
                 border-r border-zinc-200 dark:border-zinc-700
                 px-4 py-5 overflow-y-auto">

        {{-- CLOSE --}}
        <a href="#" class="mb-6 inline-flex items-center gap-2
                  text-sm text-zinc-500 hover:text-zinc-700">
            ✕ <span>Tutup</span>
        </a>

        <nav class="space-y-8 text-sm">

            {{-- UTAMA --}}
            <section class="space-y-1">
                <p class="px-3 text-[11px] font-semibold tracking-wider
                          text-zinc-400 uppercase">
                    Utama
                </p>

                <a href="{{ route('dashboard') }}" class="block px-3 py-2.5 rounded-md
                   {{ request()->routeIs('dashboard')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    Dashboard
                </a>
            </section>

            {{-- DATA --}}
            <section class="space-y-1">
                <p class="px-3 text-[11px] font-semibold tracking-wider
                          text-zinc-400 uppercase">
                    Data
                </p>

                <a href="{{ route('warga.index') }}" class="block px-3 py-2.5 rounded-md
                   {{ request()->routeIs('warga.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    Data Warga
                </a>
            </section>

            {{-- KONTEN --}}
            <section class="space-y-1">
                <p class="px-3 text-[11px] font-semibold tracking-wider
                          text-zinc-400 uppercase">
                    Konten
                </p>

                <a href="{{ route('artikel.index') }}" class="block px-3 py-2.5 rounded-md
                   {{ request()->routeIs('artikel.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    Artikel
                </a>

                <a href="{{ route('agenda.index') }}" class="block px-3 py-2.5 rounded-md
                   {{ request()->routeIs('agenda.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    Agenda
                </a>

                <a href="{{ route('informasi.index') }}" class="block px-3 py-2.5 rounded-md
                   {{ request()->routeIs('informasi.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    Informasi
                </a>
            </section>

            {{-- ADMIN --}}
            <section class="space-y-1">
                <p class="px-3 text-[11px] font-semibold tracking-wider
                          text-zinc-400 uppercase">
                    Administrasi
                </p>

                <a href="{{ route('arsip.index') }}" class="block px-3 py-2.5 rounded-md
                   {{ request()->routeIs('arsip.*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    Arsip Dokumen
                </a>

                <a href="{{ route('laporan.iuran') }}" class="block px-3 py-2.5 rounded-md
                   {{ request()->routeIs('laporan.iuran*')
    ? 'bg-indigo-100 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 font-medium'
    : 'hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    Laporan Iuran
                </a>
            </section>

            {{-- LOGOUT --}}
            <section class="pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-3 py-2.5 text-sm rounded-md
                               bg-zinc-100 dark:bg-zinc-700
                               hover:bg-zinc-200 dark:hover:bg-zinc-600 transition">
                        Logout
                    </button>
                </form>
            </section>

        </nav>
    </aside>
</div>