<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informasi;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Informasi::query();

        // search judul / ringkasan
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Judul', 'like', '%' . $request->search . '%')->orWhere('Ringkasan', 'like', '%' . $request->search . '%');
            });
        }

        // filter jenis kelamin
        if ($request->filled('Is_penting')) {
            $query->where('Is_penting', $request->Is_penting);
        }

        $informasi = $query->orderBy('created_at')->paginate(9)->withQueryString();

        return view('admin.informasi', compact('informasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form.informasiForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required',
            'Ringkasan' => 'required',
            'Isi' => 'required',
            'Is_penting' => 'nullable|boolean',
        ]);

        Informasi::create([
            'Judul' => $request->Judul,
            'Ringkasan' => $request->Ringkasan,
            'Isi' => $request->Isi,
            'Is_penting' => $request->has('Is_penting') ? 1 : 0,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Data informasi berhasil ditambahkan');
    }

    public function edit(Informasi $informasi)
    {
        return view('admin.form.informasiForm', compact('informasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Informasi $informasi)
    {
        $request->validate([
            'Judul' => 'required',
            'Ringkasan' => 'required',
            'Isi' => 'required',
            'Is_penting' => 'nullable|boolean',
        ]);

        // UPDATE data (ini poin penting)
        $informasi->update([
            'Judul' => $request->Judul,
            'Ringkasan' => $request->Ringkasan,
            'Isi' => $request->Isi,
            'Is_penting' => $request->has('Is_penting') ? 1 : 0,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Data informasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Informasi $informasi)
    {
        $informasi->delete();

        return redirect()->route('informasi.index')->with('success', 'Data informasi berhasil dihapus');
    }

    public function viewAllInformasi()
    {
        $informasi = Informasi::latest()->get();
        return view('informasi', compact('informasi'));
    }
}
