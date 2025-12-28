<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Iuran Warga</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        .line {
            border-top: 2px solid #000;
            margin: 8px 0 12px;
        }

        .meta {
            margin-bottom: 12px;
        }

        .meta table {
            width: 100%;
            font-size: 12px;
        }

        .meta td {
            padding: 2px 0;
        }

        .summary {
            margin: 12px 0;
            border: 1px solid #000;
            padding: 8px;
        }

        .summary table {
            width: 100%;
        }

        .summary td {
            padding: 4px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 6px;
        }

        table.data th {
            text-align: center;
            background: #eaeaea;
        }

        .footer {
            margin-top: 32px;
            width: 100%;
        }

        .footer td {
            width: 50%;
            text-align: center;
        }

        @media print {
            @page {
                size: A4;
                margin: 20mm;
            }
        }
    </style>
</head>

<body onload="handlePrint()">

    <!-- HEADER -->
    <div class="header">
        <h1>Laporan Iuran Warga</h1>
        <p>Rukun Tetangga (RT)</p>
    </div>

    <div class="line"></div>

    <!-- META -->
    <div class="meta">
        <table>
            <tr>
                <td width="120">Periode</td>
                <td>:
                    {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                    {{ $tahun }}
                    <span style="font-size:11px">(Sejak November 2025)</span>
                </td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ now()->translatedFormat('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- RINGKASAN -->
    <div class="summary">
        <table>
            <tr>
                <td width="50%">Total Warga</td>
                <td>: {{ $totalWarga }} Orang</td>
            </tr>
            <tr>
                <td>Warga Lunas</td>
                <td>: {{ $sudahBayar }} Orang</td>
            </tr>
            <tr>
                <td>Persentase Kepatuhan</td>
                <td>: {{ $persentase }}%</td>
            </tr>
            <tr>
                <td>Total Pemasukan</td>
                <td>:
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    <span style="font-size:11px">(Rp 20.000 / transaksi)</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- TABEL DATA (RINGKAS) -->
    <table class="data">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Warga</th>
                <th width="80">Status</th>
                <th width="110">Jumlah Bayar</th>
                <th width="130">Total Iuran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataPrint as $i => $row)
                <tr>
                    <td align="center">{{ $i + 1 }}</td>
                    <td>{{ $row->nama }}</td>
                    <td align="center">{{ $row->status }}</td>
                    <td align="center">{{ $row->total_bayar }}x</td>
                    <td>
                        Rp {{ number_format($row->total_nominal, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" align="center">Tidak ada data iuran</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <table class="footer">
        <tr>
            <td></td>
            <td>
                Mengetahui,<br>
                Ketua RT
                <br><br><br>
                ( ____________________ )
            </td>
        </tr>
    </table>




    <script>
        function handlePrint() {
            window.print();

            // Setelah dialog print ditutup
            window.onafterprint = function () {
                window.history.back();
            };
        }
    </script>


</body>

</html>