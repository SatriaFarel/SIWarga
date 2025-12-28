<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informasi;

class InformasiController extends Controller
{
    /**
     * Display informasi list (Admin)
     *
     * Features:
     * - Search by Judul or Ringkasan
     * - Filter by Is_penting
     * - Pagination
     */
    public function index(Request $request)
    {
        $query = Informasi::query();

        /**
         * Search informasi
         * Keyword matched to Judul or Ringkasan
         */
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Judul', 'like', '%' . $request->search . '%')
                  ->orWhere('Ringkasan', 'like', '%' . $request->search . '%');
            });
        }

        /**
         * Filter by importance flag
         * Is_penting = 1 (important), 0 (normal)
         */
        if ($request->filled('Is_penting')) {
            $query->where('Is_penting', $request->Is_penting);
        }

        // Paginated informasi data
        $informasi = $query
            ->orderBy('created_at')
            ->paginate(9)
            ->withQueryString();

        return view('admin.informasi', compact('informasi'));
    }

    /**
     * Show create informasi form
     */
    public function create()
    {
        return view('admin.form.informasiForm');
    }

    /**
     * Store new informasi data
     *
     * Handle:
     * - Validation
     * - Boolean handling for Is_penting
     */
    public function store(Request $request)
    {
        $request->validate([
            'Judul'       => 'required',
            'Ringkasan'   => 'required',
            'Isi'         => 'required',
            'Is_penting'  => 'nullable|boolean',
        ]);

        /**
         * Save informasi data
         * Checkbox Is_penting handled as boolean
         */
        Informasi::create([
            'Judul'      => $request->Judul,
            'Ringkasan'  => $request->Ringkasan,
            'Isi'        => $request->Isi,
            'Is_penting' => $request->has('Is_penting') ? 1 : 0,
        ]);

        return redirect()
            ->route('informasi.index')
            ->with('success', 'Data informasi berhasil ditambahkan');
    }

    /**
     * Show edit informasi form
     */
    public function edit(Informasi $informasi)
    {
        return view('admin.form.informasiForm', compact('informasi'));
    }

    /**
     * Update informasi data
     *
     * Handle:
     * - Validation
     * - Update boolean Is_penting
     */
    public function update(Request $request, Informasi $informasi)
    {
        $request->validate([
            'Judul'       => 'required',
            'Ringkasan'   => 'required',
            'Isi'         => 'required',
            'Is_penting'  => 'nullable|boolean',
        ]);

        /**
         * Update informasi fields
         */
        $informasi->update([
            'Judul'      => $request->Judul,
            'Ringkasan'  => $request->Ringkasan,
            'Isi'        => $request->Isi,
            'Is_penting' => $request->has('Is_penting') ? 1 : 0,
        ]);

        return redirect()
            ->route('informasi.index')
            ->with('success', 'Data informasi berhasil diperbarui');
    }

    /**
     * Delete informasi data
     */
    public function destroy(Informasi $informasi)
    {
        $informasi->delete();

        return redirect()
            ->route('informasi.index')
            ->with('success', 'Data informasi berhasil dihapus');
    }

    /**
     * Display all informasi (Public page)
     */
    public function viewAllInformasi()
    {
        $informasi = Informasi::latest()->get();
        return view('informasi', compact('informasi'));
    }
}
