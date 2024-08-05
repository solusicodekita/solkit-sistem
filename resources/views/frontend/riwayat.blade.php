@extends('layouts.fe.base')
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    function mdlPembayaran(id) {
        $('#mdlPembayaran').modal('show');
        $('#titlePembayaran').html('Upload bukti pembayaran');
        $('#bodyPembayaran').html('');
        $.ajax({
            url: "{{ route('fe.mdlRiwayat', ['id' => '']) }}/" + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#bodyPembayaran').html(response.html);
                $('#footerPembayaran').html(
                    '<button class="btn btn-danger btn-hover-scale me-5" type="button" onclick="upload('+id+')">Upload</button>' +
                    '<button class="btn btn-light btn-hover-scale me-5" data-bs-dismiss="modal" type="button">Cancel</button>'
                );
            }
        });
    }

    function upload(id) {
        let myForm = document.getElementById('formUpload');
        let formData = new FormData(myForm);
        
        $.ajax({
            type: 'POST',
            url: "{{ route('fe.upload') }}",
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
</script>

@endsection

@section('content')

@include('layouts.fe.navbar.subnav')

<!-- Masthead-->
<header class="masthead">
    <div class="container">
        <div class="row">
            @include('layouts.fe.navbar.sidebar')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #000;">Pesanan Saya</h5>
                        <p class="card-text" style="color: #000;">Riwayat belanja Anda</p>
                        <nav>
                            <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                                <button class="nav-link border-0 border-bottom-primary active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Instant Order</button>
                                <button class="nav-link border-0 border-bottom-primary" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Katering</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                @forelse ($instan as $item)
                                <div class="row mt-5">
                                    <div class="col-md-2">
                                        <img src="{{ asset('frontend/assets/img/menu/instant.png') }}" class="img-fluid p-1" alt="logo">
                                    </div>
                                    <div class="col-md-7">
                                        <p class="card-text" style="color: #000;">
                                            {{ $item->kode_transaksi }}
                                            <br>
                                            {{ $item->total_harga == NULL ? 'Rp.0' : __('Rp.').number_format($item->total_harga,2,',','.') }}
                                            <br>
                                            Note : <b>{{ $item->note == NULL ? '-' : $item->note }}</b>
                                        </p>
                                        <p class="text-muted">{{ $item->created_at }}</p>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        {{-- @if ($item->status == 'PENDING')
                                                        <button class="btn btn-sm rounded btn-outline-secondary mb-2">{{ $item->status }}</button>
                                        @elseif ($item->status == 'PROSES')
                                        <button class="btn btn-sm rounded btn-outline-warning mb-2">{{ $item->status }}</button>
                                        @elseif ($item->status == 'SUCCESS')
                                        <button class="btn btn-sm rounded btn-outline-success mb-2">{{ $item->status }}</button>
                                        @else
                                        <button class="btn btn-sm rounded btn-outline-danger mb-2">{{ $item->status }}</button>
                                        @endif --}}
                                        @if ($item->payment_status == 1)
                                        <form action="{{ route('midtrans_pays') }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                                            <button type="button" class="btn btn-sm rounded btn-outline-warning" onclick="mdlPembayaran('{{ $item->id }}')">Menunggu Pembayaran</button>
                                            <!-- <button type="submit" class="btn btn-sm rounded btn-outline-warning">Menunggu Pembayaran</button> -->
                                        </form>
                                        @elseif ($item->payment_status == 2)
                                        <form action="{{ route('fe.invoices') }}" method="GET">
                                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-sm rounded btn-outline-success">Sudah Dibayar</button>
                                        </form>
                                        @elseif ($item->payment_status == 3)
                                        <form action="{{ route('midtrans_pays') }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-sm rounded btn-outline-danger" disabled>Kadaluarsa</button>
                                        </form>
                                        @else
                                        <form action="{{ route('midtrans_pays') }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-sm rounded btn-outline-danger" disabled>Proses Dibatalkan</button>
                                        </form>
                                        @endif
                                        {{-- <button class="btn btn-sm rounded btn-outline-primary">Dalam Proses</button> --}}
                                    </div>
                                </div>
                                @empty
                                <div class="text-center fw-bold mt-5">Tidak Ada Riwayat Pesanan Instan!</div>
                                @endforelse
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                @forelse ($katering as $item)
                                <div class="row mt-5">
                                    <div class="col-md-2">
                                        <img src="{{ asset('frontend/assets/img/menu/catering.png') }}" class="img-fluid p-2" alt="logo">
                                    </div>
                                    <div class="col-md-7">
                                        <p class="card-text" style="color: #000;">
                                            {{ $item->kode_transaksi }}
                                            <br>
                                            {{ $item->total_harga == NULL ? 'Rp.0' : __('Rp.').number_format($item->total_harga,2,',','.') }}
                                            <br>
                                            {{ $item->note == NULL ? '' : $item->note }}
                                        </p>
                                        <p class="text-muted">{{ $item->created_at }}</p>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        {{-- @if ($item->status == 'PENDING')
                                                        <button class="btn btn-sm rounded btn-outline-secondary">{{ $item->status }}</button>
                                        @elseif ($item->status == 'PROSES')
                                        <button class="btn btn-sm rounded btn-outline-warning">{{ $item->status }}</button>
                                        @elseif ($item->status == 'SUCCESS')
                                        <button class="btn btn-sm rounded btn-outline-success">{{ $item->status }}</button>
                                        @else
                                        <button class="btn btn-sm rounded btn-outline-danger">{{ $item->status }}</button>
                                        @endif --}}
                                        @if ($item->payment_status == 1)
                                        <form action="{{ route('midtrans_pays') }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                                            <button type="button" class="btn btn-sm rounded btn-outline-warning" onclick="mdlPembayaran('{{ $item->id }}')">Menunggu Pembayaran</button>
                                        </form>
                                        @elseif ($item->payment_status == 2)
                                        <form action="{{ route('fe.invoices') }}" method="GET">
                                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-sm rounded btn-outline-success">Sudah Dibayar</button>
                                        </form>
                                        @elseif ($item->payment_status == 3)
                                        <form action="{{ route('midtrans_pays') }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-sm rounded btn-outline-danger" disabled>Kadaluarsa</button>
                                        </form>
                                        @else
                                        <form action="{{ route('midtrans_pays') }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-sm rounded btn-outline-danger" disabled>Kadaluarsa</button>
                                        </form>
                                        @endif
                                        {{-- <button class="btn btn-sm rounded btn-outline-primary">Dalam Proses</button> --}}
                                    </div>
                                </div>
                                @empty
                                <div class="text-center fw-bold mt-5">Tidak Ada Riwayat Pesanan Katering!</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="modal fade" id="mdlPembayaran" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-success" id="titlePembayaran"></h3>
                <!--begin::Close-->
                <!--end::Close-->
            </div>
            <div class="modal-body" id="bodyPembayaran" style="overflow-y:auto;">

            </div>
            <div class="modal-footer" id="footerPembayaran">

            </div>
        </div>
    </div>
</div>
@include('layouts.fe.modal.menu')
@include('layouts.fe.modal.profile')

@endsection