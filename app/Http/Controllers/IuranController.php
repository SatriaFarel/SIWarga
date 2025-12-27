<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Warga;
use App\Models\Iuran;
use Carbon\Carbon;

class IuranController extends Controller
{


    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // ===============================
        // KONFIGURASI MULAI IURAN
        // ===============================
        $startMonth = 11; // November
        $startYear  = 2025;

        $isAktif =
            ($tahun > $startYear) ||
            ($tahun == $startYear && $bulan >= $startMonth);

        // ===============================
        // JIKA BELUM AKTIF → TIDAK ADA TAGIHAN
        // ===============================
        if (! $isAktif) {
            $warga = Warga::paginate(10);

            return view('admin.iuran', compact(
                'warga',
                'bulan',
                'tahun',
                'isAktif'
            ));
        }

        // ===============================
        // SUDAH AKTIF → GENERATE IURAN
        // ===============================
        \App\Services\IuranService::generateBulanan($bulan, $tahun);

        $warga = Warga::select('warga.*')
            ->selectSub(function ($q) use ($bulan, $tahun) {
                $q->from('iuran')
                    ->select('Status')
                    ->whereColumn('Id_Warga', 'warga.id')
                    ->whereMonth('Tanggal_Bayar', $bulan)
                    ->whereYear('Tanggal_Bayar', $tahun)
                    ->limit(1);
            }, 'status_iuran')
            ->selectSub(function ($q) use ($bulan, $tahun) {
                $q->from('iuran')
                    ->select('Bukti')
                    ->whereColumn('Id_Warga', 'warga.id')
                    ->whereMonth('Tanggal_Bayar', $bulan)
                    ->whereYear('Tanggal_Bayar', $tahun)
                    ->limit(1);
            }, 'bukti')
            ->selectSub(function ($q) use ($bulan, $tahun) {
                $q->from('iuran')
                    ->select('id')
                    ->whereColumn('Id_Warga', 'warga.id')
                    ->whereMonth('Tanggal_Bayar', $bulan)
                    ->whereYear('Tanggal_Bayar', $tahun)
                    ->limit(1);
            }, 'iuran_id')
            ->paginate(10);

        return view('admin.iuran', compact(
            'warga',
            'bulan',
            'tahun',
            'isAktif'
        ));
    }


    public function showB($id)
    {
        $iuran = Iuran::with('warga')->findOrFail($id);
        return view('admin.iuranBukti', compact('iuran'));
    }

    public function acc($id)
    {
        $iuran = Iuran::findOrFail($id);

        $iuran->Status = 'Lunas';
        $iuran->save();

        return back()->with('success', 'Iuran berhasil dikonfirmasi');
    }

    public function tolak($id)
    {
        $iuran = Iuran::findOrFail($id);

        $iuran->Status = 'Belum Bayar';
        $iuran->Bukti = null; // opsional, kalau mau hapus bukti
        $iuran->save();

        return back()->with('success', 'Pembayaran ditolak');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function bayar(Request $request)
    {
        $warga = Warga::find(session('warga_id'));

        $request->validate([
            'total_bulan' => 'required|integer|min:1',
            'bukti_bayar' => 'required|image|max:2048'
        ]);

        $totalBulan = (int) $request->total_bulan;
        $totalNominal = $totalBulan * 20000;

        $path = $request->file('bukti_bayar')
            ->store('bukti-iuran', 'public');

        for ($i = 0; $i < $totalBulan; $i++) {
            $tanggal = now()->subMonths($i)->startOfMonth();

            Iuran::updateOrCreate(
                [
                    'Id_Warga' => $warga->id,
                    'Tanggal_Bayar' => $tanggal
                ],
                [
                    'Status' => 'Menunggu Konfirmasi',
                    'Bukti'  => $path
                ]
            );
        }

        return redirect()->route('iuran.struk')->with('struk', [
            'nama' => $warga->Nama,
            'bulan' => $totalBulan,
            'total' => $totalNominal,
            'tanggal' => now()->format('d M Y'),
        ]);
    }

    public function bayarManual(Request $request, $wargaId)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if (!$bulan || !$tahun) {
            return back()->with('error', 'Periode iuran tidak valid.');
        }

        $tanggalIuran = Carbon::create($tahun, $bulan, 1)->startOfMonth();

        Iuran::updateOrCreate(
            [
                'Id_Warga'      => $wargaId,
                'Tanggal_Bayar' => $tanggalIuran->toDateString(),
            ],
            [
                'Status' => 'Lunas',
                'Bukti'  => null,
            ]
        );

        return back()->with('success', 'Iuran berhasil dikonfirmasi (manual).');
    }

    public function laporan(Request $request)
    {
        $data = $this->getLaporanData($request);

        return view('admin.laporan', $data);
    }
    private function getLaporanData(Request $request)
    {
        $bulan = (int) ($request->bulan ?? now()->month);
        $tahun = (int) ($request->tahun ?? now()->year);


        $awalIuran = Carbon::create(2025, 11, 1);
        $akhirPeriode = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $totalWarga = DB::table('warga')->count();

        if ($akhirPeriode->lt($awalIuran)) {
            return [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'totalWarga' => $totalWarga,
                'sudahBayar' => 0,
                'totalPemasukan' => 0,
                'persentase' => 0,
                'dataLaporan' => collect(),
                'dataPrint' => collect(),
            ];
        }

        // ===== Statistik =====
        $sudahBayar = DB::table('iuran')
            ->where('Status', 'Lunas')
            ->whereBetween('Tanggal_Bayar', [$awalIuran, $akhirPeriode])
            ->distinct('Id_Warga')
            ->count('Id_Warga');

        $totalTransaksi = DB::table('iuran')
            ->where('Status', 'Lunas')
            ->whereBetween('Tanggal_Bayar', [$awalIuran, $akhirPeriode])
            ->count();

        $nominalIuran = 20000;
        $totalPemasukan = $totalTransaksi * $nominalIuran;

        $persentase = $totalWarga > 0
            ? round(($sudahBayar / $totalWarga) * 100)
            : 0;

        // ===== DATA UNTUK HALAMAN LAPORAN =====
        $dataLaporan = DB::table('warga')
            ->leftJoin('iuran', function ($join) use ($awalIuran, $akhirPeriode) {
                $join->on('warga.id', '=', 'iuran.Id_Warga')
                    ->where('iuran.Status', 'Lunas')
                    ->whereBetween('iuran.Tanggal_Bayar', [$awalIuran, $akhirPeriode]);
            })
            ->select(
                'warga.id',
                'warga.Nama as nama',
                DB::raw('COUNT(iuran.id) as total_bayar'),
                DB::raw('MAX(iuran.Tanggal_Bayar) as tanggal_bayar')
            )
            ->groupBy('warga.id', 'warga.Nama')
            ->orderBy('warga.Nama')
            ->get()
            ->map(function ($row) {
                $row->status = $row->total_bayar > 0 ? 'Lunas' : 'Belum';
                $row->total_nominal = $row->total_bayar * 20000;
                return $row;
            });


        // ===== DATA UNTUK PRINT (LEBIH RINGKAS & SINKRON) =====
        $dataPrint = $dataLaporan->map(function ($row) {
            return (object) [
                'nama'          => $row->nama,
                'status'        => $row->status,
                'total_bayar'   => $row->total_bayar,   // JUMLAH BAYAR (x)
                'total_nominal' => $row->total_nominal, // UANG
            ];
        });


        return compact(
            'bulan',
            'tahun',
            'totalWarga',
            'sudahBayar',
            'totalPemasukan',
            'persentase',
            'dataLaporan',
            'dataPrint'
        );
    }


    public function print(Request $request)
    {
        $data = $this->getLaporanData($request);

        return view('admin.laporanPrint', $data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}



    /**
     * Display the specified resource.
     */
    public function show(Iuran $iuran) {}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit() {}

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request,) {}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}
}
