<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artikel->Judul }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'media',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- STYLE KONTEN ARTIKEL (WAJIB KARENA CDN) -->
    <style>
        .artikel-konten h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin: 2rem 0 1rem;
        }

        .artikel-konten h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 1.75rem 0 0.75rem;
        }

        .artikel-konten h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 1.5rem 0 0.5rem;
        }

        .artikel-konten p {
            margin: 1rem 0;
            line-height: 1.75;
        }

        .artikel-konten ul,
        .artikel-konten ol {
            margin: 1rem 0 1rem 1.5rem;
            padding-left: 1rem;
        }

        .artikel-konten ul {
            list-style: disc;
        }

        .artikel-konten ol {
            list-style: decimal;
        }

        .artikel-konten li {
            margin: 0.4rem 0;
        }

        .artikel-konten blockquote {
            border-left: 4px solid #d4d4d8;
            padding-left: 1rem;
            color: #52525b;
            margin: 1.5rem 0;
            font-style: italic;
        }

        .artikel-konten img {
            max-width: 100%;
            border-radius: 0.75rem;
            margin: 1.5rem 0;
        }

        @media (prefers-color-scheme: dark) {
            .artikel-konten blockquote {
                border-color: #52525b;
                color: #a1a1aa;
            }
        }
    </style>
</head>

<body class="bg-zinc-100 dark:bg-zinc-900 text-zinc-800 dark:text-zinc-100">

    <main class="max-w-4xl mx-auto px-6 py-14">

        <!-- Thumbnail -->
        @if($artikel->Thumbnail)
            <div class="mb-10 rounded-2xl overflow-hidden shadow">
                <img src="{{ asset($artikel->Thumbnail) }}" alt="{{ $artikel->Judul }}"
                    class="w-full h-[380px] object-cover">
            </div>
        @endif

        <!-- Judul -->
        <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-4">
            {{ $artikel->Judul }}
        </h1>

        <!-- Meta -->
        <div class="flex flex-wrap items-center gap-3 text-sm text-zinc-500 mb-10">
            <span>
                {{ \Carbon\Carbon::parse($artikel->created_at)->format('d M Y') }}
            </span>
            <span>•</span>
            <span>
                {{ $artikel->Penulis ?? 'Admin RT' }}
            </span>
        </div>

        <!-- KONTEN ARTIKEL -->
        <div class="artikel-konten">
            {!! $artikel->Konten !!}
        </div>

        <!-- Divider -->
        <hr class="my-14 border-zinc-200 dark:border-zinc-700">

        <!-- Back -->
        @auth
            <a href="{{ route('artikel.index') }}" class="inline-flex items-center text-sm font-medium
                          text-teal-600 hover:text-teal-700 transition">
                ← Kembali ke manajemen artikel
            </a>
        @else
            <a href="{{ route('artikel.all') }}" class="inline-flex items-center text-sm font-medium
                          text-teal-600 hover:text-teal-700 transition">
                ← Kembali ke daftar artikel
            </a>
        @endauth

    </main>

    @extends("components.footer")
</body>

</html>