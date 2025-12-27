<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'SIRT' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN (dark mode ikut device) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body
    class="bg-gray-50 dark:bg-gray-900
           text-gray-800 dark:text-gray-200
           transition-colors duration-300">

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- CONTENT -->
    <main class="pt-24 min-h-screen">
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('components.footer')

</body>
</html>
