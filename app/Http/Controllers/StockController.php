<?php

namespace App\Http\Controllers;

use App\Exports\LiveStockExport;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class StockController extends Controller
{
    public function index()
    {
        $model = Stock::latest('id')->get();
        return view('admin.stock.index', compact('model'));
    }

    public function create()
    {
        $item = Item::latest('id')->get();
        $warehouse = Warehouse::latest('id')->get();
        return view('admin.stock.create', compact('item', 'warehouse'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'warehouse_id' => 'required',
            'initial_stock' => 'required|numeric',
            'final_stock' => 'required|numeric',
        ]);

        $stock = new Stock();
        $stock->item_id = $request->item_id;
        $stock->warehouse_id = $request->warehouse_id;
        $stock->initial_stock = $request->initial_stock;
        $stock->final_stock = $request->final_stock;
        $stock->date_opname = now();
        $stock->created_by = Auth::user()->id;
        $stock->updated_by = Auth::user()->id;
        $stock->save();

        return redirect()->route('admin.stock.index')->with('success', 'Data stok berhasil disimpan');
    }

    public function cekStokAkhir(Request $request)
    {
        $existingStock = Stock::where('item_id', $request->item_id)
            ->where('warehouse_id', $request->warehouse_id)
            ->exists();

        if ($existingStock) {
            return response()->json([
                'status' => 2,
                'msg' => 'Barang sudah pernah di stock awal di lokasi ini.',
            ]);
        }
        $item_id = $request->item_id;
        $warehouse_id = $request->warehouse_id;
        $stokAkhir = Stock::liveStock($item_id, $warehouse_id);
        if ($stokAkhir) {
            $data = [
                'status' => 1,
                'stokAkhir' => $stokAkhir,
            ];
        } else {
            $data = [
                'status' => 0,
                'stokAkhir' => 0,
            ];
        }
        return response()->json($data);
    }

    public function live_stock()
    {
        $model = Stock::select('item_id', 'warehouse_id')
            ->groupBy('item_id', 'warehouse_id')
            ->get();
        return view('admin.live_stock.index', compact('model'));
    }

    public function export_excel()
    {
        $current_time = now()->format('Ymd_His');
        return Excel::download(new LiveStockExport(), 'live_stock_' . $current_time . '.xlsx');
    }

    public function export_pdf()
    {
        $mpdf = new Mpdf();

        $model = Stock::select('item_id', 'warehouse_id')
            ->groupBy('item_id', 'warehouse_id')
            ->get();

        $data = [
            'model' => $model,
            'title' => 'Laporan Live Stock',
        ];

        $html = view('admin.live_stock.pdf', $data)->render();
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('', 'S'))
            ->header('Content-Type', 'application/pdf');
    }
}
