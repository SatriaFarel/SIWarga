<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display artikel list (Admin)
     *
     * Features:
     * - Search by Judul or Slug
     * - Pagination
     * - Ordered by Judul
     * - Load existing image files (for picker / preview)
     */
    public function index(Request $request)
    {
        $query = Artikel::query();

        /**
         * Search artikel
         * Keyword matched to Judul or Slug
         */
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Judul', 'like', '%' . $request->search . '%')
                  ->orWhere('Slug', 'like', '%' . $request->search . '%');
            });
        }

        /**
         * Paginated artikel data
         */
        $artikel = $query
            ->orderBy('Judul')
            ->paginate(10)
            ->withQueryString();

        /**
         * Load all artikel images from public folder
         * Used for image selection / management
         */
        $path = public_path('assets/artikel');

        $gambarArtikel = File::exists($path)
            ? collect(File::files($path))->filter(function ($file) {
                return in_array(
                    strtolower($file->getExtension()),
                    ['jpg', 'jpeg', 'png', 'webp']
                );
            })
            : collect();

        return view('admin.artikel', compact('artikel', 'gambarArtikel'));
    }

    /**
     * Show create artikel form
     */
    public function create()
    {
        return view('admin.form.artikelForm');
    }

    /**
     * Store new artikel
     *
     * Handle:
     * - Validation
     * - Thumbnail upload
     * - Save artikel data
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'Judul'     => 'required|string|max:255',
            'Slug'      => 'required|string|max:255|unique:artikel,Slug',
            'Penulis'   => 'required|string|max:255',
            'Konten'    => 'required',
            'Thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /**
         * Upload thumbnail image
         */
        if ($request->hasFile('Thumbnail')) {
            $file = $request->file('Thumbnail');
            $namaFile = time() . '-' . $file->getClientOriginalName();

            $file->move(public_path('assets/artikel'), $namaFile);

            $data['Thumbnail'] = 'assets/artikel/' . $namaFile;
        }

        Artikel::create($data);

        return redirect()
            ->route('artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan');
    }

    /**
     * Display single artikel (Public)
     */
    public function show($slug)
    {
        $artikel = Artikel::where('Slug', $slug)->firstOrFail();

        return view('viewArtikel', compact('artikel'));
    }

    /**
     * Show edit artikel form
     */
    public function edit(Artikel $artikel)
    {
        return view('admin.form.artikelForm', compact('artikel'));
    }

    /**
     * Update artikel data
     *
     * Handle:
     * - Validation
     * - Replace thumbnail if new image uploaded
     */
    public function update(Request $request, Artikel $artikel)
    {
        $data = $request->validate([
            'Judul'     => 'required|string|max:255',
            'Slug'      => 'required|string|max:255',
            'Penulis'   => 'required|string|max:255',
            'Konten'    => 'required',
            'Thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /**
         * If new thumbnail uploaded:
         * - Delete old thumbnail
         * - Upload new thumbnail
         */
        if ($request->hasFile('Thumbnail')) {

            if ($artikel->Thumbnail && File::exists(public_path($artikel->Thumbnail))) {
                File::delete(public_path($artikel->Thumbnail));
            }

            $file = $request->file('Thumbnail');
            $namaFile = time() . '-' . $file->getClientOriginalName();

            $file->move(public_path('assets/artikel'), $namaFile);

            $data['Thumbnail'] = 'assets/artikel/' . $namaFile;
        }

        $artikel->update($data);

        return redirect()
            ->route('artikel.index')
            ->with('success', 'Artikel berhasil diperbarui');
    }

    /**
     * Delete artikel
     *
     * Also delete thumbnail file if exists
     */
    public function destroy(Artikel $artikel)
    {
        if ($artikel->Thumbnail && File::exists(public_path($artikel->Thumbnail))) {
            File::delete(public_path($artikel->Thumbnail));
        }

        $artikel->delete();

        return redirect()
            ->route('artikel.index')
            ->with('success', 'Data artikel berhasil dihapus');
    }

    /**
     * Display all artikel (Public page)
     *
     * Structure:
     * - 1 featured article
     * - 6 latest articles
     * - 10 older articles (archive)
     */
    public function viewAllArtikel()
    {
        $featured = Artikel::latest()->first();

        $artikel = Artikel::latest()
            ->when($featured, function ($query) use ($featured) {
                $query->where('id', '!=', $featured->id);
            })
            ->take(6)
            ->get();

        $artikelLama = Artikel::latest()
            ->when($featured, function ($query) use ($featured) {
                $query->where('id', '!=', $featured->id);
            })
            ->skip(6)
            ->take(10)
            ->get();

        return view('artikelAll', compact('featured', 'artikel', 'artikelLama'));
    }

    /**
     * Upload image only (for editor / gallery)
     */
    public function uploadGambar(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $file = $request->file('gambar');
        $nama = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('assets/artikel'), $nama);

        return back()->with('success', 'Gambar berhasil diupload');
    }

    /**
     * Delete uploaded image file
     */
    public function hapusGambar(Request $request)
    {
        $path = public_path('assets/artikel/' . $request->nama);

        if (File::exists($path)) {
            File::delete($path);
            return back()->with('success', 'Gambar berhasil dihapus');
        }

        return back()->with('error', 'File tidak ditemukan');
    }
}
