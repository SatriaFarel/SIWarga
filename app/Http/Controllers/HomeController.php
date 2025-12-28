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
    /**
     * Homepage Controller
     *
     * Handle data for public landing page (welcome page)
     * Show latest informasi, agenda, artikel, and past activities.
     */
    public function index()
    {
        return view('welcome', [
            // Latest 3 informasi / announcements
            'informasi' => Informasi::latest()
                                    ->take(3)
                                    ->get(),

            // Upcoming agenda (sorted by start date)
            'agenda' => Agenda::orderBy('Tanggal_Mulai')
                              ->take(3)
                              ->get(),

            // Latest 3 articles
            'artikel' => Artikel::latest()
                                ->take(3)
                                ->get(),

            // Past activities (already finished)
            'kegiatan' => Agenda::where('Tanggal_Selesai', '<', Carbon::today())
                                ->orderByDesc('Tanggal_Selesai')
                                ->take(3)
                                ->get(),
        ]);
    }

    /**
     * Store pesan / laporan from public form
     *
     * Used by warga to send:
     * - Laporan
     * - Saran
     * - Kritik
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nama'  => 'nullable|string|max:100',
            'Email' => 'required|string',
            'Jenis' => 'required|in:Laporan,Saran,Kritik',
            'Pesan' => 'required',
        ]);

        /**
         * Save pesan laporan
         * Status will be set automatically (default: "baru")
         */
        PesanLaporan::create([
            'Nama'  => $request->Nama,
            'Email' => $request->Email,
            'Jenis' => $request->Jenis,
            'Pesan' => $request->Pesan,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim');
    }

    /**
     * Display pesan & laporan list (Admin)
     *
     * Features:
     * - Ordered by newest
     * - Pagination for performance
     */
    public function view()
    {
        // Get latest messages with pagination
        $pesan = PesanLaporan::orderBy('created_at', 'desc')
                             ->paginate(9);

        return view('admin.pesan', compact('pesan'));
    }

    /**
     * Delete pesan / laporan
     */
    public function destroy(PesanLaporan $pesan)
    {
        $pesan->delete();

        return redirect()
            ->route('pesan')
            ->with('success', 'Data pesan berhasil dihapus');
    }
}
