<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Arsip;
use App\Models\Informasi;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Arsip::query();

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->akses) {
            $query->where('akses', $request->akses);
        }

        $arsip = $query->latest()->paginate(9);

        return view('admin.arsip', compact('arsip'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form.arsipForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'tanggal_dokumen' => 'required',
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB
        ]);

        $file = $request->file('file');
        $path = $file->store('arsip', 'public');

        Arsip::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'nama_file' => $file->getClientOriginalName(),
            'path_file' => $path,
            'tipe_file' => $file->extension(),
            'ukuran_file' => round($file->getSize() / 1024),
            'akses' => $request->akses,
            'uploaded_by' => auth()->id()
        ]);

        return redirect()->route('arsip.index')->with('success', 'Arsip ditambahkan');
    }

    public function edit(Arsip $arsip)
    {
        return view('admin.form.informasiForm', compact('arsip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Arsip $arsip)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'tanggal_dokumen' => 'required',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Data dasar (selalu diupdate)
        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'akses' => $request->akses,
            'uploaded_by' => auth()->id(),
        ];

        // ❗ Kalau ada file baru → update file
        if ($request->hasFile('file')) {

            // (opsional tapi bagus) hapus file lama
            if ($arsip->path_file && Storage::disk('public')->exists($arsip->path_file)) {
                Storage::disk('public')->delete($arsip->path_file);
            }

            $file = $request->file('file');
            $path = $file->store('arsip', 'public');

            $data['nama_file']   = $file->getClientOriginalName();
            $data['path_file']   = $path;
            $data['tipe_file']   = $file->extension();
            $data['ukuran_file'] = round($file->getSize() / 1024);
        }

        // Update sekali, rapi
        $arsip->update($data);

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Data arsip berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Arsip $arsip)
    {
        // 1. Hapus file jika ada
        if ($arsip->path_file && Storage::disk('public')->exists($arsip->path_file)) {
            Storage::disk('public')->delete($arsip->path_file);
        }
        $arsip->delete();

        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil dihapus');
    }



    public function download(Arsip $arsip)
    {
        // proteksi akses
        if ($arsip->akses === 'Admin' && !auth()->check()) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($arsip->path_file)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download(
            $arsip->path_file,
            $arsip->nama_file
        );
    }
}
