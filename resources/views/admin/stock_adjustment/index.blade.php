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
                        <div class="card-body p-3 table-responsive">
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
                                        <th class="text-center">Dibuat Oleh</th>
                                        <th class="text-center">Tanggal Dibuat</th>
                                        <th class="text-center">Diperbarui Oleh</th>
                                        <th class="text-center">Tanggal Diperbarui</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($model as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->item->name }}</td>
                                            <td>{{ $row->warehouse->name }}</td>
                                            <td>{{ floatval($row->quantity) }}</td>
                                            <td>{{ $row->item->unit }}</td>
                                            <td>{{ $row->description }}</td>
                                            <td>{{ date('d-m-Y H:i', strtotime($row->stockTransaction->date)) }}</td>
                                            <td>{{ $row->createdBy ? $row->createdBy->firstname . ' ' . $row->createdBy->lastname : ' ' }}</td>
                                            <td>{{ !empty($row->created_at) ? \Carbon\Carbon::parse($row->created_at)->translatedFormat('d F Y H:i:s') : ' ' }}</td>
                                            <td>{{ $row->updatedBy ? $row->updatedBy->firstname . ' ' . $row->updatedBy->lastname : ' ' }}</td>
                                            <td>{{ !empty($row->updated_at) ? \Carbon\Carbon::parse($row->updated_at)->translatedFormat('d F Y H:i:s') : ' ' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center">Tidak ada data</td>
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
    <script>
         $(document).ready(function() {
            @if (count($model) > 0)
                $('#tabelStock').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true
                });
            @endif
        });
    </script>
@endpush
