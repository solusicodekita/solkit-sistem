@extends('layouts.adm.base')
@section('title', 'Menu Stok Masuk')
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="card-title">Riwayat Stok Masuk</h3>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.in_stock.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <table id="tabelStock" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal Transaksi</th>
                                        <th class="text-center">Item - Jumlah - Lokasi</th>
                                        <th class="text-center">Total Transaksi</th>
                                        <th class="text-center">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($model as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td style="text-align: left;">
                                                <ul>
                                                    @foreach ($row->stockTransactionDetails as $item)
                                                        <li>{{ $item->item->name }} - {{ rtrim(number_format($item->quantity, 2, ',', '.'), ',00') }} {{ $item->item->unit }} - {{ $item->warehouse->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>Rp {{ number_format($row->total_harga_keseluruhan, 2, ',', '.') }}</td>
                                            <td>{{ $row->description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
