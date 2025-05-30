@extends('layouts.adm.base')
@section('title', 'Laporan Transaksi')
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="card-title">Laporan Transaksi</h3>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.laporan_transaksi.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i> Buat Laporan Bulan Kemarin</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 table-responsive">
                            <table id="tabelLaporanTransaksi" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="20%">No</th>
                                        <th class="text-center">Nama Laporan</th>
                                        <th class="text-center" style="width: 20%">Download laporan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($model as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>Laporan Transaksi Bulan {{ $row::convertBulan($row->bulan) }} - {{ $row->tahun }}</td>
                                            <td>
                                                <a href="{{ route('admin.laporan_transaksi.download', $row->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </td>
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
        $(document).ready(function() {
            $('#tabelLaporanTransaksi').DataTable();
        });
    </script>
@endpush
