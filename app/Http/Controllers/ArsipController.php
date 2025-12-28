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
     * Display list of arsip (Admin)
     *
     * Features:
     * - Search by judul
     * - Filter by kategori
     * - Filter by akses
     * - Pagination
     */
    public function index(Request $request)
    {
        $query = Arsip::query();

        // Search by judul
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter by kategori
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by akses (Admin / Publik)
        if ($request->akses) {
            $query->where('akses', $request->akses);
        }

        // Latest arsip with pagination
        $arsip = $query->latest()->paginate(9);

        return view('admin.arsip', compact('arsip'));
    }

    /**
     * Show create arsip form
     */
    public function create()
    {
        return view('admin.form.arsipForm');
    }

    /**
     * Store new arsip data
     *
     * Handle:
     * - Validation
     * - File upload to storage (public disk)
     * - Save metadata to database
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required',
            'kategori'        => 'required',
            'tanggal_dokumen' => 'required',
            'file'            => 'required|file|mimes:pdf,doc,docx|max:5120', // max 5MB
        ]);

        // Store file to storage/app/public/arsip
        $file = $request->file('file');
        $path = $file->store('arsip', 'public');

        // Save arsip data
        Arsip::create([
            'judul'          => $request->judul,
            'kategori'       => $request->kategori,
            'tanggal_dokumen'=> $request->tanggal_dokumen,
            'nama_file'      => $file->getClientOriginalName(),
            'path_file'      => $path,
            'tipe_file'      => $file->extension(),
            'ukuran_file'    => round($file->getSize() / 1024), // KB
            'akses'          => $request->akses,
            'uploaded_by'    => auth()->id(),
        ]);

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Arsip ditambahkan');
    }

    /**
     * Show edit arsip form
     */
    public function edit(Arsip $arsip)
    {
        return view('admin.form.informasiForm', compact('arsip'));
    }

    /**
     * Update arsip data
     *
     * Handle:
     * - Update basic fields
     * - Replace file if new file uploaded
     */
    public function update(Request $request, Arsip $arsip)
    {
        $request->validate([
            'judul'           => 'required',
            'kategori'        => 'required',
            'tanggal_dokumen' => 'required',
            'file'            => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        /**
         * Base data (always updated)
         */
        $data = [
            'judul'           => $request->judul,
            'kategori'        => $request->kategori,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'akses'           => $request->akses,
            'uploaded_by'     => auth()->id(),
        ];

        /**
         * If new file uploaded:
         * - Delete old file (if exists)
         * - Store new file
         * - Update file metadata
         */
        if ($request->hasFile('file')) {

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

        // Single update call
        $arsip->update($data);

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Data arsip berhasil diperbarui');
    }

    /**
     * Delete arsip data
     *
     * Also delete file from storage
     */
    public function destroy(Arsip $arsip)
    {
        if ($arsip->path_file && Storage::disk('public')->exists($arsip->path_file)) {
            Storage::disk('public')->delete($arsip->path_file);
        }

        $arsip->delete();

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Data arsip berhasil dihapus');
    }

    /**
     * Download arsip file
     *
     * Access rule:
     * - If akses = Admin → user must be logged in
     */
    public function download(Arsip $arsip)
    {
        // Access protection
        if ($arsip->akses === 'Admin' && !auth()->check()) {
            abort(403);
        }

        // File existence check
        if (!Storage::disk('public')->exists($arsip->path_file)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download(
            $arsip->path_file,
            $arsip->nama_file
        );
    }
}
