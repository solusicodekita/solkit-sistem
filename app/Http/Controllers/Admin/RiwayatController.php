<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $day = Carbon::now()->format('d');
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        
        $query = Transaction::with('customer');

        // Apply filters
        if ($request->has('type') && $request->type) {
            if ($request->type == 'all') {
                $query->where(function($q) {
                    $q->where('type', 'instan')
                      ->orWhere('type', 'katering');
                });
            } else {
                $query->where('type', $request->type);
            }
        }
        

        if ($request->has('tgl') && $request->tgl) {
            $selectedDate = Carbon::parse($request->tgl);
            $query->whereDate('created_at', $selectedDate);
        } elseif ($request->day) {
            $query->whereDate('created_at', $day);
        } elseif ($request->month) {
            $query->whereMonth('tgl_penjemputan', $month);
        } elseif ($request->year) {
            $query->whereYear('tgl_penjemputan', $year);
        } else {
            $query->where('status', 'SUCCESS');
        }

        $data['data'] = $query->latest('id')->get();
        
        $total = $data['data']->sum('total_harga');
        $typekatering = $data['data']->where('type', 'katering')->count();
        $typeinstan = $data['data']->where('type', 'instan')->count();

        return view('admin.riwayat.index', compact('data', 'total', 'typekatering', 'typeinstan', 'day', 'month', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
