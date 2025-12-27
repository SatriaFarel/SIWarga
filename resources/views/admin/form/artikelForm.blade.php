<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($artikel) ? 'Edit Artikel' : 'Tambah Artikel' }}</title>

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

    <!-- CKEditor Dark Mode FIX -->
    <style>
        /* editor area */
        .ck-editor__editable {
            background-color: #020617 !important; /* slate-950 */
            color: #f8fafc !important;
            min-height: 250px;
        }

        /* toolbar */
        .ck-toolbar {
            background-color: #020617 !important;
            border: 1px solid #1e293b !important;
        }

        /* toolbar button */
        .ck-button {
            color: #e5e7eb !important;
        }

        .ck-button:hover,
        .ck-button:focus {
            background-color: #1e293b !important;
        }

        .ck-button.ck-on {
            background-color: #334155 !important;
        }

        /* dropdown panel */
        .ck-dropdown__panel {
            background-color: #020617 !important;
            border: 1px solid #1e293b !important;
        }

        /* dropdown item (INI YANG PENTING) */
        .ck-list__item .ck-button {
            color: #f8fafc !important; /* FIX: biar kelihatan */
        }

        .ck-list__item .ck-button:hover {
            background-color: #1e293b !important;
        }

        /* input dialog (link, image url, dll) */
        .ck-input-text {
            background-color: #020617 !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        /* tooltip */
        .ck-tooltip__text {
            background-color: #020617 !important;
            color: #f8fafc !important;
        }

        /* editor border */
        .ck-editor__main {
            border: 1px solid #1e293b;
        }
    </style>
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
                    {{ isset($artikel) ? 'Edit Artikel' : 'Tambah Artikel' }}
                </h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    {{ isset($artikel) ? 'Perbarui artikel' : 'Buat artikel baru' }}
                </p>
            </div>

            <!-- Error -->
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
                  action="{{ isset($artikel) ? route('artikel.update', $artikel->id) : route('artikel.store') }}"
                  enctype="multipart/form-data"
                  class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md p-6 space-y-5">

                @csrf
                @if(isset($artikel))
                    @method('PUT')
                @endif

                <!-- Judul -->
                <div>
                    <label class="block text-sm mb-1">Judul</label>
                    <input type="text" name="Judul"
                           value="{{ old('Judul', $artikel->Judul ?? '') }}"
                           class="w-full px-3 py-2 rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900">
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm mb-1">Slug</label>
                    <input type="text" name="Slug"
                           value="{{ old('Slug', $artikel->Slug ?? '') }}"
                           class="w-full px-3 py-2 rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900">
                </div>

                <!-- Penulis -->
                <div>
                    <label class="block text-sm mb-1">Penulis</label>
                    <input type="text" name="Penulis"
                           value="{{ old('Penulis', $artikel->Penulis ?? '') }}"
                           class="w-full px-3 py-2 rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900">
                </div>

                <!-- Konten -->
                <textarea id="editor" name="Konten">
{!! old('Konten', $artikel->Konten ?? '') !!}
                </textarea>

                <!-- Thumbnail -->
                <div>
                    <label class="block text-sm font-medium mb-2">Thumbnail</label>

                    @if(isset($artikel) && $artikel->Thumbnail)
                        <div class="mb-3">
                            <p class="text-xs mb-1 text-zinc-500">Thumbnail saat ini:</p>
                            <div class="w-40 aspect-video rounded-md overflow-hidden border">
                                <img src="{{ asset($artikel->Thumbnail) }}"
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endif

                    <label class="flex flex-col items-center justify-center w-full px-4 py-6
                        border-2 border-dashed rounded-md cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700">
                        <span class="text-sm">Klik untuk upload thumbnail</span>
                        <input type="file" name="Thumbnail" class="hidden">
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('artikel.index') }}"
                       class="px-4 py-2 text-sm border rounded-md">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2 text-sm text-white bg-zinc-800 rounded-md">
                        Simpan
                    </button>
                </div>

            </form>
        </main>
    </div>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#editor'), {
        toolbar: [
            'heading',
            '|',
            'bold', 'italic',
            '|',
            'bulletedList', 'numberedList',
            '|',
            'blockQuote',
            '|',
            'undo', 'redo'
        ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraf' },
                { model: 'heading1', view: 'h1', title: 'Judul Besar' },
                { model: 'heading2', view: 'h2', title: 'Sub Judul' }
            ]
        }
    }).catch(console.error);
</script>

</body>
</html>
