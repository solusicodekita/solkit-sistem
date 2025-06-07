@extends('layouts.adm.base')
@section('title', 'Lokasi')
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="card-title">Tabel Lokasi</h3>
                                </div>
                                <div class="col-auto">
                                    <a href="{{  route('admin.warehouse.create')  }}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="15%" class="text-center">Kode</th>
                                        <th width="20%" class="text-center">Nama Lokasi</th>
                                        <th width="20%" class="text-center">Dibuat Oleh</th>
                                        <th width="20%" class="text-center">Diperbarui Oleh</th>
                                        <th width="20%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->code }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->createdBy ? $item->createdBy->firstname . ' ' . $item->createdBy->lastname : ' ' }}</td>
                                            <td>{{ $item->updatedBy ? $item->updatedBy->firstname . ' ' . $item->updatedBy->lastname : ' ' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.warehouse.edit', $item->id) }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                                <button onclick="hapus('{{ $item->id }}')" class="btn btn-outline-danger"><i
                                                        class="fas fa-trash"></i></button>
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
    @include('admin.warehouses.script')
@endpush
