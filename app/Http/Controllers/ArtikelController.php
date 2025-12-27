<?php

namespace App\Http\Controllers;


use App\Models\Artikel;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Artikel::query();

        // search nama / NIK
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Judul', 'like', '%' . $request->search . '%')
                    ->orWhere('Slug', 'like', '%' . $request->search . '%');
            });
        }

        $artikel = $query
            ->orderBy('Judul')
            ->paginate(10)
            ->withQueryString();

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form.artikelForm',);
    }

    /**
     * Store a newly created resource in storage.
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

        // Upload thumbnail
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
     * Display the specified resource.
     */
    public function show($slug)
    {
        $artikel = Artikel::where('Slug', $slug)->firstOrFail();

        return view('viewArtikel', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        return view('admin.form.artikelForm', compact('artikel'));
    }

    /**
     * Update the specified resource in storage.
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

        // Kalau upload thumbnail baru
        if ($request->hasFile('Thumbnail')) {

            // Hapus thumbnail lama
            if ($artikel->Thumbnail && File::exists(public_path($artikel->Thumbnail))) {
                File::delete(public_path($artikel->Thumbnail));
            }

            // Upload thumbnail baru
            $file = $request->file('Thumbnail');
            $namaFile = time() . '-' . $file->getClientOriginalName();

            $file->move(public_path('assets/artikel'), $namaFile);

            $data['Thumbnail'] = 'assets/artikel/' . $namaFile;
        }

        // Update data artikel
        $artikel->update($data);

        return redirect()
            ->route('artikel.index')
            ->with('success', 'Artikel berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        // Hapus thumbnail lama
        if ($artikel->Thumbnail && File::exists(public_path($artikel->Thumbnail))) {
            File::delete(public_path($artikel->Thumbnail));
        }
        $artikel->delete();

        return redirect()->route('artikel.index')
            ->with('success', 'Data artikel berhasil dihapus');
    }

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
