@extends('layouts.adm.base')
@section('title','Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="dashboard-card" style="background:linear-gradient(135deg,#1976d2 60%,#1a237e 100%);color:#fff;">
            <div class="d-flex align-items-center">
                <div style="font-size:2.5rem;margin-right:1rem;"><i class="fa-solid fa-users"></i></div>
                <div>
                    <div class="card-title">Data User</div>
                    <div class="card-value">2</div>
                </div>
            </div>
            <div class="card-desc mt-2">Tampilkan Data <i class="fa fa-arrow-right"></i></div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="dashboard-card" style="background:linear-gradient(135deg,#00bcd4 60%,#1976d2 100%);color:#fff;">
            <div class="d-flex align-items-center">
                <div style="font-size:2.5rem;margin-right:1rem;"><i class="fa-solid fa-cart-shopping"></i></div>
                <div>
                    <div class="card-title">Data Transaction</div>
                    <div class="card-value">0</div>
                </div>
            </div>
            <div class="card-desc mt-2">Tampilkan Data <i class="fa fa-arrow-right"></i></div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="dashboard-card" style="background:linear-gradient(135deg,#43a047 60%,#ffc107 100%);color:#fff;">
            <div class="d-flex align-items-center">
                <div style="font-size:2.5rem;margin-right:1rem;"><i class="fa-solid fa-dollar-sign"></i></div>
                <div>
                    <div class="card-title">Data Income</div>
                    <div class="card-value">Rp.0,00</div>
                </div>
            </div>
            <div class="card-desc mt-2">Tampilkan Data <i class="fa fa-arrow-right"></i></div>
        </div>
    </div>
</div>
@endsection