<header class="w-full bg-white dark:bg-zinc-800
        border-b border-zinc-200 dark:border-zinc-700 px-4 py-3">

    <div class="flex items-center justify-between max-w-7xl mx-auto">

        {{-- LEFT --}}
        <div class="flex items-center gap-3">

            {{-- HAMBURGER (MOBILE ONLY) --}}
            <a href="#mobile-sidebar"
               class="md:hidden p-2 rounded-md
                      hover:bg-zinc-100 dark:hover:bg-zinc-700">
                ☰
            </a>

            <div class="w-9 h-9 rounded-md bg-indigo-700 text-white
                        flex items-center justify-center font-semibold">
                RT
            </div>

            <div class="hidden sm:block">
                <p class="text-sm font-semibold leading-tight">
                    Sistem Informasi RT
                </p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    Administrasi & Informasi Warga
                </p>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                 class="w-9 h-9 rounded-full" alt="avatar">

            <div class="hidden sm:block text-right">
                <p class="text-sm font-medium">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    Administrator
                </p>
            </div>
        </div>

    </div>
</header>
