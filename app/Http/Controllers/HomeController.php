<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\OrderProduct;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\HistoryHarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tr = Address::where([
            ['user_id', Auth::user()->id],
            ['type', 'UTAMA'],
        ])->get();

        if (auth()->user()->hasRole('admin')) {

            $total = 0;
            $products = Product::with('order_product')->orderBy('id')->get()->groupBy(function($data) { return $data->qty; });;
            $data = OrderProduct::with('product')->orderBy('product_id')->get()->groupBy(function($data) { return $data->product->id; });
            // dd($data);
            // foreach($data as $qty => $product) {
            //     foreach($product as $item) {
            //         if ($item->product_id == $item->product->id) {
            //             $total += $item->qty;
            //         }
            //     }
            // }

            // DONUT CHART
            // $chart1 = Transaction::where('status', 'SUCCESS')->sum('total_harga');
            // $success = number_format($chart1, 0, '', '.');
            // $chart2 = Transaction::where('status', 'PENDING')->sum('total_harga');
            // $pending = number_format($chart2, 0, '', '.');
            // $chart3 = Transaction::where('status', 'PROSES')->sum('total_harga');
            // $proses = number_format($chart3, 0, '', '.');
            // $chart4 = Transaction::whereNotIn('status', ['SUCCESS','PENDING','PROSES'])->sum('total_harga');
            // $fail = number_format($chart4, 0, '', '.');

            // PIE CHART
            $success = Transaction::where('status', 'SUCCESS')->sum('total_harga');
            $pending = Transaction::where('status', 'PENDING')->sum('total_harga');
            $proses = Transaction::where('status', 'PROSES')->sum('total_harga');
            $fail = Transaction::whereNotIn('status', ['SUCCESS','PENDING','PROSES'])->sum('total_harga');
            $total_kategori = Category::count();
            $total_lokasi = Warehouse::count();
            $total_item = Item::count();
        // dd($total_kategori);

            // Ambil semua warehouse
            $warehouses = \App\Models\Warehouse::all();

            // Untuk setiap warehouse, hitung jumlah item dengan stok > 0
            $warehouse_stocks = [];
            foreach ($warehouses as $warehouse) {
                $item_count = Stock::where('warehouse_id', $warehouse->id)
                    ->where('final_stock', '>', 0)
                    ->count();
                $warehouse_stocks[] = [
                    'name' => $warehouse->name,
                    'item_count' => $item_count,
                ];
            }

            // Ambil item habis (stok 0 di semua warehouse)
            $empty_items = Stock::where('final_stock', '<=', 0)
                ->with('item', 'warehouse')
                ->get();

            // Ambil history harga untuk Micin di Gudang A
            $history_harga_micin_gudang_a = \App\Models\HistoryHarga::with(['item', 'warehouse'])
                ->where('item_id', 1)
                ->where('warehouse_id', 1)
                ->orderBy('created_at', 'asc')
                ->get();

            // Di HomeController.php, tambahkan query untuk mengambil data history harga
            $history_harga = \App\Models\HistoryHarga::with(['item', 'warehouse'])
                ->orderBy('created_at', 'asc')
                ->get()
                ->groupBy(function($row) {
                    return $row->item->name . ' - ' . $row->warehouse->name;
                });

            return view('admin.dashboard.index',[
                'title' => 'Dashboard',
                'products' => $products,
                'data' => $data,
                'total' => $total,
                'user' => User::all()->count(),
                'transaction' => Transaction::where('status', 'SUCCESS')->get()->count(),
                'money' => Transaction::where('status', 'SUCCESS')->sum('total_harga'),
                'success' => $success,
                'pending' => $pending,
                'proses' => $proses,
                'fail' => $fail,
                'total_kategori' => $total_kategori,
                'total_lokasi' => $total_lokasi,
                'total_item' => $total_item,
                'warehouse_stocks' => $warehouse_stocks,
                'empty_items' => $empty_items,
                'history_harga' => $history_harga,
                'history_harga_micin_gudang_a' => $history_harga_micin_gudang_a,
            ]);
        }
        elseif (auth()->user()->hasRole('customer')) {
            if (empty($tr) || $tr == NULL) {
                return redirect()->route('fe.alamat');
            } else {
                return redirect()->route('fe.index');
            }
        }
        else {
            return redirect()->route('fe.index');
        }
    }
}
