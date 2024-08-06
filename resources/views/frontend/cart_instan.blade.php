@extends('layouts.fe.base')
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    function mdlPembayaranInstan(id) {
        $('#mdlPembayaranInstan').modal('show');
        $('#titlePembayaranInstan').html('Upload bukti pembayaran');
        $('#bodyPembayaranInstan').html('');
        $.ajax({
            url: "{{ route('fe.mdlCartInstan', ['id' => '']) }}/" + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response.html);
                $('#bodyPembayaranInstan').html(response.html);
                $('#footerPembayaranInstan').html(
                    '<button class="btn btn-danger btn-hover-scale me-5" type="button" onclick="uploadInstan(' + id + ')">Upload</button>' +
                    '<button class="btn btn-light btn-hover-scale me-5" data-bs-dismiss="modal" type="button">Cancel</button>'
                );
            }
        });
    }

    function uploadInstan(id) {
        let total_harga = $("#total_harga").val();
        let type = $("#type").val();
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        let formData = new FormData();
        formData.append('_token', csrfToken); // Sertakan token CSRF
        formData.append('id', id);
        formData.append('total_harga', total_harga);
        formData.append('type', type);
        $.ajax({
            type: 'POST',
            url: "{{ route('fe.uploadInstan') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                location.reload();
            },
            error: function(request, status, error) {
                errorMessage(request);

            }
        });
    }

    function simpanQty() {
        let myForm = document.getElementById('check-form');
        let formData = new FormData(myForm);
        $.ajax({
            type: 'POST',
            url: "{{ route('fe.check') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                alert('Data Berhasil Diubah');
                window.location.reload(true); 

            },
            error: function(request, status, error) {
                errorMessage(request);

            }
        });
    }
</script>

@endsection
@section('content')

@include('layouts.fe.navbar.subnav')

<!-- Masthead-->
<header class="masthead">
    <div class="container">
        <div class="card">
            <div class="card-body row">
                <h5 class="col-md-10 card-title" style="color: #000;">Pengiriman</h5>
                <a data-bs-toggle="modal" data-bs-target="#alamat" class="col-md-12 card-text text-decoration-underline" style="color: #000;">{{ $adr->address->title }}</a>
                <p class="col-md-12 card-text" style="color: #000;">{{ $adr->address->address. ', ' .$adr->address->provinsi. ', ' .$adr->address->kabupaten. ', ' .$adr->address->kecamatan. ', ' .$adr->address->pos }}</p>
                <form class="input-group mb-3" action="{{ route('fe.update_note', $adr->id) }}" method="POST">
                    <span class="input-group-text" id="note"><i class="far fa-sticky-note"></i></span>
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{ $adr->id }}">
                    <input type="hidden" name="type" value="{{ $adr->type }}">
                    <input type="text" name="note" class="form-control" placeholder="Tambahkan catatan pengiriman" aria-label="Note" aria-describedby="note" value="{{ $adr->note == NULL ? '' : $adr->note }}">
                    {{-- <button class="input-group-text" type="submit">Submit</button> --}}
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Category Section-->
<section class="page-section category" id="category">
    <div class="container">
        <div class="card mb-5">
            <div class="card-header">
                <a href="{{ route('fe.resto_instan') }}" class="btn btn-sm btn-danger">Tambah Pesanan?</a>
            </div>
            <div class="card-body">
                <h5 class="card-title" style="color: #000;">Pesanan</h5><label for="" style="color: red;">* Tolong Pesanan Tidak Melebihi Lebih Dari Jumlah Yang Tersedia</label>
                <div class="card border-0 mt-2">
                    <div class="row g-0">
                        <form id="check-form" action="" method="POST">
                            @csrf
                            @forelse ($items as $item)
                            <div class="col-md-2 p-3">
                                <img src="{{ asset('frontend/assets/img/product') . "/" . $item->product->thumbnail }}" class="img-fluid rounded-start" alt="Thumbnail">
                            </div>
                            <div class="col-md-10">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->product->name }}</h5>
                                    <p class="card-text">{{ $item->product->body }}</p>
                                    <p class="card-text">Jumlah  yang Tersedia : <b>{{ $item->product->stok }}</b></p>
                                    <div class="row align-items-center">
                                        <p class="card-text col-md-8"><b>{{ __('Rp.').number_format($item->product->price,2,',','.') }}</b></p>
                                        <div class="col-md-4 d-flex justify-content-end">
                                            <div class="row btn-group" role="group">
                                                <input type="number" name="itemQty[]" class="jmlqty border border-primary text-center" style="height: 36px;" min="1" value="{{ $item->qty }}">
                                                <input type="hidden" name="idItem[]" value="{{ $item->id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @empty
                            <div class="col-12 text-center">Maaf, Data Belum Tersedia!</div>
                            @endforelse
                        </form>

                        <button class="btn btn-primary btn-hover-scale me-5" type="button" onclick="simpanQty()">Simpan Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-5">
            <div class="card-body">
                <h5 class="card-title" style="color: #000;">Ringkasan Pembayaran</h5>
                <div class="row">
                    <div class="col-md-10">Total Harga</div>
                    <div class="col-md-2">{{ __('Rp.').number_format($total,2,',','.') }}</div>
                </div>
                <div class="row">
                    <div class="col-md-10">Ongkos Kirim</div>
                    <div class="col-md-2">{{ __('Rp.').number_format($total*(5/100),2,',','.') }}</div>
                </div>
                <!-- <div class="row">
                            <div class="col-md-10">Ongkos Kirim</div>
                            <div class="col-md-2">Rp.0</div>
                        </div> -->
                <hr style="color:#000;opacity:unset;">
                <div class="row fw-bold">
                    <div class="col-md-10">Total Harga</div>
                    <div class="col-md-2">{{ __('Rp.').number_format($total+($total*(5/100)),2,',','.') }}</div>
                </div>
            </div>
        </div>
        <div class="row fw-bold mb-5">
            <div class="col-md-10">
                Total
                <h5>{{ __('Rp.').number_format($total+($total*(5/100)),2,',','.') }}</h5>
            </div>
            <div class="col-md-2">
                <form class="modal-body row" action="{{ route('fe.pay', $adr->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{ $adr->id }}">
                    <input type="hidden" name="total_harga" id="total_harga" value="{{ $total+($total*(5/100)) }}">
                    <input type="hidden" name="type" id="type" value="{{ $adr->type }}">
                    <button type="submit" class="btn btn-outline-dark" {{ \Setting::getDisable() }} {{ $total+($total*(5/100)) == 0 ? 'disabled' : '' }}>Pembayaran</button>
                </form>
                <!-- <button type="button" class="btn btn-outline-dark" onclick="mdlPembayaranInstan('{{ $adr->id }}')">Pembayaran</button> -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="mdlPembayaranInstan" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-success" id="titlePembayaranInstan"></h3>
                    <!--begin::Close-->
                    <!--end::Close-->
                </div>
                <div class="modal-body" id="bodyPembayaranInstan" style="overflow-y:auto;">

                </div>
                <div class="modal-footer" id="footerPembayaranInstan">

                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.fe.modal.menu')
@include('layouts.fe.modal.jamBuka')
@include('layouts.fe.modal.address')

@endsection