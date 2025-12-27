<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Agenda::query();

        // search nama / NIK
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Judul', 'like', '%' . $request->search . '%')
                    ->orWhere('Deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $agenda = $query
            ->orderBy('Judul')
            ->paginate(9)
            ->withQueryString();

        return view('admin.agenda', compact('agenda'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form.agendaForm');
    }

    /**
     * Store a newly created resource in storage.
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

        Agenda::create($request->all());

        return redirect()->route('agenda.index')
            ->with('success', 'Data agenda berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function viewAllAgenda(Agenda $agenda)
    {
        $agenda = Agenda::orderBy('Tanggal_Mulai', 'asc')->get();
        return view('agenda', compact('agenda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        return view('admin.form.agendaForm', compact('agenda'));
    }

    /**
     * Update the specified resource in storage.
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

        // UPDATE data (ini poin penting)
        $agenda->update([
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Deskripsi,
            'Tanggal_Mulai' => $request->Tanggal_Mulai,
            'Tanggal_Selesai' => $request->Tanggal_Selesai,
            'Lokasi' => $request->Lokasi,
        ]);

        return redirect()->route('agenda.index')
            ->with('success', 'Data agenda berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('success', 'Data agenda berhasil dihapus');
    }
}
