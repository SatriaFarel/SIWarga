<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Informasi;
use App\Models\Agenda;
use App\Models\Artikel;
use App\Models\PesanLaporan;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'informasi' => Informasi::latest()->take(3)->get(),
            'agenda' => Agenda::orderBy('Tanggal_Mulai')->take(3)->get(),
            'artikel' => Artikel::latest()->take(3)->get(),
            'kegiatan' => Agenda::where('Tanggal_Selesai', '<', Carbon::today())->orderByDesc('Tanggal_Selesai')->take(3)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama' => 'nullable|string|max:100',
            'Email' => 'required|string',
            'Jenis' => 'required|in:Laporan,Saran,Kritik',
            'Pesan' => 'required',
        ]);

        PesanLaporan::create([
            'Nama' => $request->Nama,
            'Email' => $request->Email,
            'Jenis' => $request->Jenis,
            'Pesan' => $request->Pesan,
            // status otomatis "baru"
        ]);

        return back()->with('success', 'Pesan berhasil dikirim');
    }

    // Menampilkan daftar pesan & laporan warga
    public function view()
    {
        // Ambil data terbaru, pagination biar ringan
        $pesan = PesanLaporan::orderBy('created_at', 'desc')->paginate(9);

        // Kirim ke view
        return view('admin.pesan', compact('pesan'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PesanLaporan $pesan)
    {
        $pesan->delete();

        return redirect()->route('pesan')->with('success', 'Data pesan berhasil dihapus');
    }


}
