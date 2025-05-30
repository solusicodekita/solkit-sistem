@extends('layouts.adm.base')
@section('title', 'Create Stock Opname')
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="card-title">Form Tambah Stok Opname Awal</h3>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.stock.index') }}" class="btn btn-primary"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form id="formStock" method="POST" action="{{ route('admin.stock.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="item_id">Item <span class="text-danger">*</span></label>
                                    <select class="form-control ubahSelect" name="item_id" id="item_id"
                                        onchange="cekStokAkhir()">
                                        <option value="">-- Pilih Item --</option>
                                        @foreach ($item as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="warehouse_id">Lokasi Item <span class="text-danger">*</span></label>
                                    <select class="form-control ubahSelect" name="warehouse_id" id="warehouse_id"
                                        onchange="cekStokAkhir()">
                                        <option value="">-- Pilih Lokasi Item --</option>
                                        @foreach ($warehouse as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="initial_stock">Stock Awal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control desimal" name="initial_stock"
                                        id="initial_stock" readonly value="0" autocomplete="off">
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="final_stock">Stock Akhir <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control desimal" name="final_stock" id="final_stock"
                                        placeholder="Ketikkan Stock Akhir" autocomplete="off">
                                </div>
                                <hr>
                                <button type="button" class="btn btn-success" id="btnSimpan" onclick="validasi()">
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
        $(document).ready(function() {
            $('.ubahSelect').select2({
                placeholder: '-- Pilih Item --',
                allowClear: false
            });
        });

        // Fungsi untuk memvalidasi input hanya menerima angka desimal
        $(".desimal").keypress(function(e) {
            var charCode = (e.which) ? e.which : event.keyCode;
            var value = $(this).val();
            if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46) {
                return false;
            }
            // Memastikan hanya ada satu titik
            if (charCode == 46 && value.indexOf('.') !== -1) {
                return false;
            }
            return true;
        });

        function validasi() {
            var item_id = $('#item_id').val();
            var warehouse_id = $('#warehouse_id').val();
            var initial_stock = $('#initial_stock').val();
            var final_stock = $('#final_stock').val();

            if (item_id == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Item wajib diisi!',
                });
                return false;
            }

            if (warehouse_id == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Lokasi wajib diisi!',
                });
                return false;
            }

            if (initial_stock == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Stok Awal wajib diisi!',
                });
                return false;
            }

            if (final_stock == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Stok Akhir wajib diisi!',
                });
                return false;
            }

            $('#formStock').submit();
        }

        function cekStokAkhir() {
            let item_id = $('#item_id').val();
            let warehouse_id = $('#warehouse_id').val();

            if (item_id != '' && warehouse_id != '') {
                $.ajax({
                    url: "{{ route('admin.stock.cekStokAkhir') }}",
                    type: 'GET',
                    data: {
                        item_id: item_id,
                        warehouse_id: warehouse_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status == 1) {
                            let stokAkhir = parseFloat(response.stokAkhir);
                            if (stokAkhir % 1 === 0) {
                                $('#initial_stock').val(parseInt(stokAkhir));
                            } else {
                                $('#initial_stock').val(stokAkhir);
                            }
                            $('#btnSimpan').prop('disabled', false);
                        } else if (response.status == 2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.msg,
                                timer: 3000,
                                showConfirmButton: false
                            });
                            $('#initial_stock').val('0');
                            $('#btnSimpan').prop('disabled', true);
                        } else {
                            $('#initial_stock').val('0');
                            $('#btnSimpan').prop('disabled', false);
                        }
                    }
                });
            }
        }
    </script>
@endpush
