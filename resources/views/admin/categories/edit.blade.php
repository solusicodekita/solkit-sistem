@extends('layouts.adm.base')
@section('title', trans('menu.category.title'))
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="card-title">Form Edit Kategori</h3>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.category.index') }}" class="btn btn-primary"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form id="formKategori" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="name">Nama Kategori</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Ketikkan Nama Kategori" autocomplete="off"
                                        value="{{ $category->name }}">
                                    <input type="text" class="form-control" name="id" id="id" hidden
                                        autocomplete="off" value="{{ $category->id }}">
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        placeholder="Ketikkan Slug" autocomplete="off" value="{{ $category->slug }}">
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-success" onclick="update(event)">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('name').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    </script>
    @include('admin.categories.script')
@endpush
