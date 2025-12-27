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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Warga::query();

        // search nama / NIK
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Nama', 'like', '%' . $request->search . '%')
                    ->orWhere('NIK', 'like', '%' . $request->search . '%');
            });
        }

        // filter jenis kelamin
        if ($request->filled('jk')) {
            $query->where('Jenis_Kelamin', $request->jk);
        }

        $warga = $query
            ->orderBy('Nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.warga', compact('warga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form.wargaForm',);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NIK' => 'required|unique:warga,NIK',
            'No_KK' => 'required',
            'Nama' => 'required',
            'Password' => 'required',
            'Tanggal_Lahir' => 'required',
            'Jenis_Kelamin' => 'required',
            'Alamat' => 'required',
            'No_HP' => 'required|integer',
        ]);

        Warga::create($request->all());

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan');
    }

    public function show(Warga $warga)
    {
        return view('admin.wargaDetail', compact('warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        return view('admin.form.wargaForm', compact('warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'NIK' => 'required',
            'No_KK' => 'required',
            'Nama' => 'required',
            'Password' => 'required',
            'Tanggal_Lahir' => 'required',
            'Jenis_Kelamin' => 'required',
            'Alamat' => 'required',
            'No_HP' => 'required',
        ]);

        // cek NIK unique kecuali data ini sendiri
        $cek = Warga::where('NIK', $request->NIK)
            ->where('id', '!=', $warga->id)
            ->exists();

        if ($cek) {
            return back()->withInput()
                ->with('error', 'NIK sudah terdaftar di warga lain');
        }

        // UPDATE data (ini poin penting)
        $warga->update([
            'NIK' => $request->NIK,
            'No_KK' => $request->No_KK,
            'Password' => $request->Password,
            'Nama' => $request->Nama,
            'Jenis_Kelamin' => $request->Jenis_Kelamin,
            'Alamat' => $request->Alamat,
            'No_HP' => $request->No_HP,
            'Tanggal_Lahir' => $request->Tanggal_Lahir,
        ]);

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil dihapus');
    }

    public function dashboard()
    {
        IuranService::generateBulanan();

        $warga = Warga::find(session('warga_id'));

        // Iuran bulan ini (tanggal 1)
        $iuranBulanIni = Iuran::where('Id_Warga', $warga->id)
            ->whereMonth('Tanggal_Bayar', now()->month)
            ->whereYear('Tanggal_Bayar', now()->year)
            ->first();

        // Hitung tunggakan (Belum Bayar + Menunggu Konfirmasi)
        $totalTunggakan = Iuran::where('Id_Warga', $warga->id)
            ->whereIn('Status', ['Belum Bayar', 'Menunggu Konfirmasi'])
            ->count();

        // Riwayat
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
