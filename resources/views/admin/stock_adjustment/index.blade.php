@extends('layouts.adm.base')
@section('title', 'Adjustment Stock')
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="card-title">Adjustment Stock</h3>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.adjustment_stock.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <table id="tabelStock" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Item</th>
                                        <th class="text-center">Lokasi Item</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Satuan / Unit</th>
                                        <th class="text-center">Alasan Adjust</th>
                                        <th class="text-center">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($model as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->item->name }}</td>
                                            <td>{{ $row->warehouse->name }}</td>
                                            <td>{{ floatval($row->quantity) }}</td>
                                            <td>{{ $row->item->unit }}</td>
                                            <td>{{ $row->description }}</td>
                                            <td>{{ date('d-m-Y H:i', strtotime($row->stockTransaction->date)) }}</td>
                                        </tr>
                                    @endforeach
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
    <script>
        
    </script>
@endpush
