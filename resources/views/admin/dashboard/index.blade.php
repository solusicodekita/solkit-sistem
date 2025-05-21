@extends('layouts.adm.base')
@section('title','Dashboard')

@section('content')
<style>
    .dashboard-card {
        border-radius: 18px;
        box-shadow: 0 6px 32px rgba(26,35,126,0.10);
        background: #fff;
        padding: 2rem 2rem 1.5rem 2rem;
        margin-bottom: 2rem;
        transition: box-shadow 0.2s, transform 0.2s;
        min-height: 160px;
        position: relative;
        overflow: hidden;
    }
    .dashboard-card:hover {
        box-shadow: 0 12px 40px rgba(26,35,126,0.18);
        transform: translateY(-4px) scale(1.02);
    }
    .dashboard-card .icon-bg {
        position: absolute;
        top: -20px;
        right: -20px;
        font-size: 5.5rem;
        color: rgba(255,255,255,0.18);
        z-index: 0;
        pointer-events: none;
    }
    .dashboard-card .icon-main {
        font-size: 2.5rem;
        margin-right: 1.2rem;
        color: #fff;
        z-index: 2;
    }
    .dashboard-card .card-title {
        color: #fff;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 0.2rem;
        z-index: 2;
    }
    .dashboard-card .card-value {
        font-size: 2.1rem;
        font-weight: bold;
        color: #fff;
        z-index: 2;
    }
    .dashboard-card .card-desc {
        color: #fff;
        font-size: 1rem;
        margin-top: 1.2rem;
        z-index: 2;
        font-weight: 500;
    }
    /* Gradient backgrounds for each card */
    .card-user { background: linear-gradient(120deg,#1976d2 60%,#1a237e 100%); }
    .card-transaction { background: linear-gradient(120deg,#00bcd4 60%,#1976d2 100%); }
    .card-income { background: linear-gradient(120deg,#43a047 60%,#ffc107 100%); }
</style>
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="dashboard-card card-user">
            <span class="icon-bg"><i class="fa-solid fa-users"></i></span>
            <div class="d-flex align-items-center" style="z-index:2;position:relative;">
                <div class="icon-main"><i class="fa-solid fa-users"></i></div>
                <div>
                    <div class="card-title">Data User</div>
                    <div class="card-value">2</div>
                </div>
            </div>
            <div class="card-desc">Tampilkan Data <i class="fa fa-arrow-right"></i></div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="dashboard-card card-transaction">
            <span class="icon-bg"><i class="fa-solid fa-cart-shopping"></i></span>
            <div class="d-flex align-items-center" style="z-index:2;position:relative;">
                <div class="icon-main"><i class="fa-solid fa-cart-shopping"></i></div>
                <div>
                    <div class="card-title">Data Transaction</div>
                    <div class="card-value">0</div>
                </div>
            </div>
            <div class="card-desc">Tampilkan Data <i class="fa fa-arrow-right"></i></div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="dashboard-card card-income">
            <span class="icon-bg"><i class="fa-solid fa-dollar-sign"></i></span>
            <div class="d-flex align-items-center" style="z-index:2;position:relative;">
                <div class="icon-main"><i class="fa-solid fa-dollar-sign"></i></div>
                <div>
                    <div class="card-title">Data Income</div>
                    <div class="card-value">Rp.0,00</div>
                </div>
            </div>
            <div class="card-desc">Tampilkan Data <i class="fa fa-arrow-right"></i></div>
        </div>
    </div>
</div>
@endsection