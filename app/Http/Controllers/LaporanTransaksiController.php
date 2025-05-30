<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTransaksiExport;
use App\Models\LaporanTransaksi;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class LaporanTransaksiController extends Controller
{
    public function index()
    {
        $model = LaporanTransaksi::latest('id')->get();
        return view('admin.laporan_transaksi.index', compact('model'));
    }

    public function create()
    {
        try {
            $bulan = date('m', strtotime('-1 month'));
            $tahun = date('Y', strtotime('-1 month'));

            $bulanIniSudahAda = LaporanTransaksi::where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->exists();

            if ($bulanIniSudahAda) {
                return redirect()->route('admin.laporan_transaksi.index')->with('error', 'Laporan transaksi bulan kemarin sudah dibuat.');
            }

            $filename = 'laporan_transaksi_bulan_' . $this->convertBulan($bulan) . '_' . $tahun . '.xlsx';
            $filePath = 'laporan_transaksi/' . $filename;

            $laporanTransaksi = new LaporanTransaksi();
            $laporanTransaksi->bulan = $bulan;
            $laporanTransaksi->tahun = $tahun;
            $laporanTransaksi->url_laporan = $filePath;
            $laporanTransaksi->save();

            $tglAwal = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-01'));
            $tglAkhir = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-01 +1 month -1 day'));
            Excel::store(new LaporanTransaksiExport($bulan, $tahun, $tglAwal, $tglAkhir), $filePath);

            return redirect()->route('admin.laporan_transaksi.index')->with('success', 'Laporan transaksi berhasil dibuat');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('admin.laporan_transaksi.index')->with('error', 'Laporan transaksi gagal dibuat');
        }
    }

    public function download($id)
    {
        $laporanTransaksi = LaporanTransaksi::find($id);
        return Storage::download($laporanTransaksi->url_laporan);
    }

    public function convertBulan($bulan)
    {
        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        return $namaBulan[$bulan];
    }
}
