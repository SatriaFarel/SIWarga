<nav
    class="fixed top-0 w-full z-30
           bg-white/80 dark:bg-gray-900/80
           backdrop-blur border-b
           border-gray-200 dark:border-gray-700">

    <div class="max-w-7xl mx-auto px-6 h-16
                flex items-center justify-between">

        <!-- Logo -->
        <a href="/"
           class="text-xl font-bold
                  text-teal-700 dark:text-teal-400">
            SIWarga
        </a>

        <!-- Hamburger -->
        <button id="menuBtn"
            class="md:hidden inline-flex items-center justify-center
                   p-2 rounded-lg
                   text-gray-700 dark:text-gray-200
                   hover:bg-gray-100 dark:hover:bg-gray-800">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Menu Desktop -->
        <div class="hidden md:flex items-center gap-6
                    text-sm font-medium
                    text-gray-700 dark:text-gray-200">

            <a href="/" class="hover:text-teal-600 dark:hover:text-teal-400">Beranda</a>
            <a href="/informasi" class="hover:text-teal-600 dark:hover:text-teal-400">Informasi</a>
            <a href="/agenda" class="hover:text-teal-600 dark:hover:text-teal-400">Agenda</a>
            <a href="/artikel" class="hover:text-teal-600 dark:hover:text-teal-400">Artikel</a>
            <a href="/profil" class="hover:text-teal-600 dark:hover:text-teal-400">Profil RT</a>

            <a href="{{ route('warga.login') }}"
               class="ml-4 px-4 py-2 rounded-lg
                      bg-teal-600 dark:bg-teal-500
                      text-white text-sm font-semibold
                      hover:bg-teal-700 dark:hover:bg-teal-400
                      transition">
                Login
            </a>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div id="mobileMenu"
         class="md:hidden hidden
                bg-white dark:bg-gray-900
                border-t border-gray-200 dark:border-gray-700">

        <div class="px-6 py-4 space-y-3
                    text-sm font-medium
                    text-gray-700 dark:text-gray-200">

            <a href="/" class="block hover:text-teal-600 dark:hover:text-teal-400">Beranda</a>
            <a href="/informasi" class="block hover:text-teal-600 dark:hover:text-teal-400">Informasi</a>
            <a href="/agenda" class="block hover:text-teal-600 dark:hover:text-teal-400">Agenda</a>
            <a href="/artikel" class="block hover:text-teal-600 dark:hover:text-teal-400">Artikel</a>
            <a href="/profil" class="block hover:text-teal-600 dark:hover:text-teal-400">Profil RT</a>

            <a href="{{ route('warga.login') }}"
               class="block mt-3 text-center
                      px-4 py-2 rounded-lg
                      bg-teal-600 dark:bg-teal-500
                      text-white font-semibold
                      hover:bg-teal-700 dark:hover:bg-teal-400">
                Login
            </a>
        </div>
    </div>
</nav>

<!-- Toggle Script -->
<script>
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
