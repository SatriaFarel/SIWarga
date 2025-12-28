<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AgendaController extends Controller
{
    /**
     * Display agenda list (Admin)
     *
     * Features:
     * - Search by Judul or Deskripsi
     * - Pagination
     * - Ordered by Judul
     */
    public function index(Request $request)
    {
        $query = Agenda::query();

        /**
         * Search agenda
         * Keyword will match Judul or Deskripsi
         */
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Judul', 'like', '%' . $request->search . '%')
                  ->orWhere('Deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        /**
         * Paginate agenda data
         */
        $agenda = $query
            ->orderBy('Judul')
            ->paginate(9)
            ->withQueryString();

        return view('admin.agenda', compact('agenda'));
    }

    /**
     * Show create agenda form
     */
    public function create()
    {
        return view('admin.form.agendaForm');
    }

    /**
     * Store new agenda data
     *
     * Handle:
     * - Validation
     * - Image upload (optional)
     */
    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required',
            'Deskripsi' => 'required',
            'Tanggal_Mulai' => 'required|date',
            'Tanggal_Selesai' => 'required|date',
            'Lokasi' => 'required',
            'Gambar' => 'image|mimes:jpg,jpeg,png'
        ]);

        /**
         * Upload agenda image (if exists)
         */
        if ($request->hasFile('Gambar')) {
            $file = $request->file('Gambar');
            $namaFile = time() . '-' . $file->getClientOriginalName();

            $file->move(public_path('assets/agenda'), $namaFile);

            $data['Gambar'] = 'assets/agenda/' . $namaFile;
        }

        /**
         * Save agenda data to database
         */
        Agenda::create($request->all());

        return redirect()->route('agenda.index')
            ->with('success', 'Data agenda berhasil ditambahkan');
    }

    /**
     * Display all agenda (Public page)
     */
    public function viewAllAgenda(Agenda $agenda)
    {
        $agenda = Agenda::orderBy('Tanggal_Mulai', 'asc')->get();
        return view('agenda', compact('agenda'));
    }

    /**
     * Show edit agenda form
     */
    public function edit(Agenda $agenda)
    {
        return view('admin.form.agendaForm', compact('agenda'));
    }

    /**
     * Update agenda data
     *
     * Handle:
     * - Validation
     * - Replace image if new image uploaded
     */
    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'Judul' => 'required',
            'Deskripsi' => 'required',
            'Tanggal_Mulai' => 'required|date',
            'Tanggal_Selesai' => 'required|date',
            'Lokasi' => 'required',
            'Gambar' => 'image|mimes:jpg,jpeg,png'
        ]);

        /**
         * If new image uploaded
         * - Delete old image
         * - Upload new image
         */
        if ($request->hasFile('Gambar')) {

            if ($agenda->Gambar && File::exists(public_path($agenda->Gambar))) {
                File::delete(public_path($agenda->Gambar));
            }

            $file = $request->file('Gambar');
            $namaFile = time() . '-' . $file->getClientOriginalName();

            $file->move(public_path('assets/agenda'), $namaFile);

            $data['Gambar'] = 'assets/agenda/' . $namaFile;
        }

        /**
         * Update agenda fields
         */
        $agenda->update([
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Deskripsi,
            'Tanggal_Mulai' => $request->Tanggal_Mulai,
            'Tanggal_Selesai' => $request->Tanggal_Selesai,
            'Lokasi' => $request->Lokasi,
            'Gamba' => $data['Gambar'] ?? null
        ]);

        return redirect()->route('agenda.index')
            ->with('success', 'Data agenda berhasil diperbarui');
    }

    /**
     * Delete agenda data
     *
     * Also delete image file if exists
     */
    public function destroy(Agenda $agenda)
    {
        if ($agenda->Gambar && File::exists(public_path($agenda->Gambar))) {
            File::delete(public_path($agenda->Gambar));
        }

        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('success', 'Data agenda berhasil dihapus');
    }
}
