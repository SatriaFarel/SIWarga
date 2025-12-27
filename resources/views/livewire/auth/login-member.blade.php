<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="w-full max-w-md bg-white dark:bg-zinc-900
                    rounded-2xl shadow-xl p-8 space-y-6">

            <!-- Header -->
            <div class="text-center space-y-2">
                <div class="w-12 h-12 mx-auto rounded-full
                            bg-teal-600 text-white
                            flex items-center justify-center text-xl font-bold">
                    RT
                </div>

                <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">
                    Login Warga
                </h1>
                <p class="text-sm text-zinc-500">
                    Akses iuran & informasi resmi RT
                </p>
            </div>

            <!-- Form -->
            <form method="POST"
                  action="{{ route('warga.login.process') }}"
                  class="space-y-5">
                @csrf

                <div>
                    <label class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                        NIK
                    </label>
                    <input type="text" name="NIK" required autofocus
                        class="w-full mt-1 rounded-lg border border-zinc-300
                               dark:border-zinc-700
                               bg-white dark:bg-zinc-800
                               px-3 py-2 text-sm
                               focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                        Password
                    </label>
                    <input type="password" name="Password" required
                        class="w-full mt-1 rounded-lg border border-zinc-300
                               dark:border-zinc-700
                               bg-white dark:bg-zinc-800
                               px-3 py-2 text-sm
                               focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <button
                    class="w-full bg-teal-600 hover:bg-teal-700
                           text-white py-2.5 rounded-lg
                           font-semibold transition">
                    Masuk
                </button>
            </form>

            <!-- Footer -->
            <p class="text-xs text-center text-zinc-500">
                Akun hanya dapat dibuat oleh pengurus RT
            </p>

        </div>
    </div>
</x-layouts.auth>
