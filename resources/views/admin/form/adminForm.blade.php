<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($user) ? 'Edit Admin' : 'Tambah Admin' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
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

<body class="bg-zinc-100 dark:bg-zinc-900 text-zinc-800 dark:text-zinc-100">

<div class="min-h-screen flex flex-col">

    <x-layouts.app.header />

    <div class="flex flex-1">
        <x-layouts.app.sidebar />

        <main class="flex-1 px-6 py-8 max-w-4xl mx-auto w-full">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-xl font-semibold">
                    {{ isset($user) ? 'Edit Admin' : 'Tambah Admin' }}
                </h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    {{ isset($user) ? 'Perbarui data admin' : 'Buat akun admin baru' }}
                </p>
            </div>

            <!-- Alert -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-500 text-white rounded-lg">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST"
                  action="{{ isset($user) ? route('admin.update', $user->id)
                : route('admin.store') }}"
                  class="bg-white dark:bg-zinc-800 border border-zinc-200
                         dark:border-zinc-700 rounded-md p-6 space-y-5">

                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <!-- Nama -->
                <div>
                    <label class="block text-sm mb-1">Nama</label>
                    <input type="text" name="name"
                           value="{{ old('name', $user->name ?? '') }}"
                           class="w-full px-3 py-2 rounded-md border
                                  border-zinc-300 dark:border-zinc-600
                                  bg-white dark:bg-zinc-900">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $user->email ?? '') }}"
                           class="w-full px-3 py-2 rounded-md border
                                  border-zinc-300 dark:border-zinc-600
                                  bg-white dark:bg-zinc-900">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm mb-1">Role</label>
                    <select name="role"
                            class="w-full px-3 py-2 rounded-md border
                                   border-zinc-300 dark:border-zinc-600
                                   bg-white dark:bg-zinc-900">
                        <option value="admin"
                            {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="super_admin"
                            {{ old('role', $user->role ?? '') === 'super_admin' ? 'selected' : '' }}>
                            Super Admin
                        </option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm mb-1">
                        Password
                        @if(isset($user))
                            <span class="text-xs text-zinc-500">(kosongkan jika tidak diubah)</span>
                        @endif
                    </label>
                    <input type="password" name="password"
                           class="w-full px-3 py-2 rounded-md border
                                  border-zinc-300 dark:border-zinc-600
                                  bg-white dark:bg-zinc-900">
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 justify-end">
                    <a href="{{ route('admin.index') }}"
                       class="px-4 py-2 text-sm rounded-md
                              border border-zinc-300 dark:border-zinc-600">
                        Batal
                    </a>

                    <button type="submit"
                            class="px-5 py-2 text-sm text-white
                                   bg-zinc-800 dark:bg-zinc-700 rounded-md">
                        Simpan
                    </button>
                </div>

            </form>

        </main>
    </div>
</div>

</body>
</html>
