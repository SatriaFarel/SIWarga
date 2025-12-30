<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use App\Models\Iuran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\IuranService;

class WargaController extends Controller
{
    /**
     * Display warga list (Admin)
     *
     * Features:
     * - Search by Nama or NIK
     * - Filter by Jenis Kelamin
     * - Pagination
     */
    public function index(Request $request)
    {
        $query = Warga::query();

        /**
         * Search warga
         * Keyword matched to Nama or NIK
         */
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Nama', 'like', '%' . $request->search . '%')
                    ->orWhere('NIK', 'like', '%' . $request->search . '%');
            });
        }

        /**
         * Filter by gender (Jenis_Kelamin)
         */
        if ($request->filled('jk')) {
            $query->where('Jenis_Kelamin', $request->jk);
        }

        // Paginated warga data
        $warga = $query
            ->orderBy('Nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.warga', compact('warga'));
    }

    /**
     * Show create warga form
     */
    public function create()
    {
        return view('admin.form.wargaForm');
    }

    /**
     * Store new warga data
     *
     * Handle:
     * - Validation
     * - Create warga record
     */
    public function store(Request $request)
    {
        $request->validate([
            'NIK'            => 'required|unique:warga,NIK',
            'No_KK'          => 'required',
            'Nama'           => 'required',
            'Password'       => 'required',
            'Tanggal_Lahir'  => 'required',
            'Jenis_Kelamin'  => 'required',
            'Alamat'         => 'required',
            'No_HP'          => 'required|integer',
        ]);

        Warga::create($request->all());

        return redirect()
            ->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan');
    }

    /**
     * Show detail warga (Admin)
     */
    public function show(Warga $warga)
    {
        $bulan = now()->month;
        $tahun = now()->year;

        // Ambil iuran bulan ini (kalau ada)
        $iuranBulanIni = Iuran::where('Id_Warga', $warga->id)
            ->whereMonth('Tanggal_Bayar', $bulan)
            ->whereYear('Tanggal_Bayar', $tahun)
            ->first();

        return view('admin.wargaDetail', compact(
            'warga',
            'iuranBulanIni'
        ));
    }

    /**
     * Show edit warga form
     */
    public function edit(Warga $warga)
    {
        return view('admin.form.wargaForm', compact('warga'));
    }

    /**
     * Update warga data
     *
     * Handle:
     * - Validation
     * - Manual NIK uniqueness check
     */
    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'NIK'            => 'required',
            'No_KK'          => 'required',
            'Nama'           => 'required',
            'Password'       => 'required',
            'Tanggal_Lahir'  => 'required',
            'Jenis_Kelamin'  => 'required',
            'Alamat'         => 'required',
            'No_HP'          => 'required',
        ]);

        /**
         * Check NIK uniqueness except current warga
         */
        $cek = Warga::where('NIK', $request->NIK)
            ->where('id', '!=', $warga->id)
            ->exists();

        if ($cek) {
            return back()
                ->withInput()
                ->with('error', 'NIK sudah terdaftar di warga lain');
        }

        /**
         * Update warga fields
         */
        $warga->update([
            'NIK'           => $request->NIK,
            'No_KK'         => $request->No_KK,
            'Password'      => $request->Password,
            'Nama'          => $request->Nama,
            'Jenis_Kelamin' => $request->Jenis_Kelamin,
            'Alamat'        => $request->Alamat,
            'No_HP'         => $request->No_HP,
            'Tanggal_Lahir' => $request->Tanggal_Lahir,
        ]);

        return redirect()
            ->route('warga.index')
            ->with('success', 'Data warga berhasil diperbarui');
    }

    /**
     * Delete warga data
     */
    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()
            ->route('warga.index')
            ->with('success', 'Data warga berhasil dihapus');
    }

    /**
     * Warga dashboard
     *
     * Show:
     * - Current month iuran
     * - Total tunggakan
     * - Payment history
     */
    public function dashboard()
    {
        /**
         * Ensure iuran data is generated
         */
        IuranService::generateBulanan();

        $warga = Warga::find(session('warga_id'));

        /**
         * Current month iuran
         */
        $iuranBulanIni = Iuran::where('Id_Warga', $warga->id)
            ->whereMonth('Tanggal_Bayar', now()->month)
            ->whereYear('Tanggal_Bayar', now()->year)
            ->first();

        /**
         * Total unpaid & pending iuran
         */
        $totalTunggakan = Iuran::where('Id_Warga', $warga->id)
            ->whereIn('Status', ['Belum Bayar', 'Menunggu Konfirmasi'])
            ->count();

        /**
         * Payment history
         */
        $riwayat = Iuran::where('Id_Warga', $warga->id)
            ->orderBy('Tanggal_Bayar', 'desc')
            ->get();

        return view('warga.dashboard', compact(
            'warga',
            'iuranBulanIni',
            'totalTunggakan',
            'riwayat'
        ));
    }
}
