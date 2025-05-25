@extends('layouts.adm.base')
@section('title', 'Menu Stock')
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="card-title">Riwayat Stok Opname</h3>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.stock.create') }}" class="btn btn-primary"><i
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
                                        <th class="text-center">Stok Awal</th>
                                        <th class="text-center">Stok Akhir</th>
                                        <th class="text-center">Satuan</th>
                                        <th class="text-center">Tanggal Opname</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($model as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->item->name }}</td>
                                            <td>{{ $row->warehouse->name }}</td>
                                            <td>{{ $row->initial_stock == 0 ? '0' : rtrim(number_format($row->initial_stock, 2, ',', '.'), ',00') }}
                                            </td>
                                            <td>{{ $row->final_stock == 0 ? '0' : rtrim(number_format($row->final_stock, 2, ',', '.'), ',00') }}
                                            </td>
                                            <td>{{ $row->item->unit }}</td>
                                            <td>{{ date('d-m-Y H:i', strtotime($row->date_opname)) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data</td>
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
