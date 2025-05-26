<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Stock;
use App\Models\StockTransaction;
use App\Models\StockTransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokInController extends Controller
{
    public function index()
    {
        $model = StockTransaction::where('type', 'in')->orderBy('id', 'desc')->get();
        return view('admin.stock_in.index', compact('model'));
    }

    public function create()
    {
        $item = Item::whereHas('stocks')->get();
        return view('admin.stock_in.create', compact('item'));
    }

    public function getHargaSatuan(Request $request)
    {
        $item = Item::find($request->item_id);
        $price = $item->price;
        return response()->json(['harga_satuan' => $price]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'item' => 'required|array',
                'item.*.item_id' => 'required|exists:items,id',
                'item.*.warehouse_id' => 'required|exists:warehouses,id',
                'item.*.harga_satuan' => 'required|string',
                'item.*.quantity' => 'required|string|min:1',
                'item.*.total_harga_item' => 'required|string',
                'item.*.description' => 'nullable|string',
                'total_harga_keseluruhan' => 'required|string',
            ]);

            $stock = StockTransaction::create([
                'type' => 'in',
                'total_harga_keseluruhan' => str_replace([',', '.'], ['.', ''], $request->total_harga_keseluruhan),
                'date' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);

            foreach ($request->item as $value) {
                $modDetail = StockTransactionDetail::create([
                    'stock_transaction_id' => $stock->id,
                    'item_id' => $value['item_id'],
                    'warehouse_id' => $value['warehouse_id'],
                    'quantity' => str_replace(',', '.', $value['quantity']),
                    'harga_satuan' => str_replace([',', '.'], ['.', ''], $value['harga_satuan']),
                    'total_harga' => str_replace([',', '.'], ['.', ''], $value['total_harga_item']),
                    'description' => $value['description'],
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);

                $modItem = Item::where('id', $value['item_id'])->first();
                $modItem->price = $modDetail->harga_satuan;
                $modItem->updated_by = Auth::user()->id;
                $modItem->save();
            }

            DB::commit();
            return redirect()->route('admin.in_stock.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getWarehouse(Request $request)
    {
        $warehouse = Stock::select('warehouse_id')
            ->where('item_id', $request->item_id)
            ->groupBy('warehouse_id')
            ->get();

        $data = '';
        if (count($warehouse) == 0) {
            $data = '<option value="" disabled selected>-- Lokasi Item tidak ditemukan --</option>';
            return response()->json($data);
        }

        foreach ($warehouse as $row) {
            $data .= '<option value="'.$row->warehouse_id.'">'.$row->warehouse->name.'</option>';
        }
        return response()->json($data);
    }
}
