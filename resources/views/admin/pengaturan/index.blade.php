@extends('layouts.adm.base')
@section('title', 'Profil')
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="card-title">Profil</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="name">Nama Pengguna</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Ketikkan Nama Pengguna" autocomplete="off"
                                    value="{{ $model->firstname . ' ' . $model->lastname }}" readonly>
                            </div>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Ketikkan Username" autocomplete="off" value="{{ $model->username }}"
                                    readonly>
                            </div>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email"
                                    placeholder="Ketikkan Email" autocomplete="off" value="{{ $model->email }}" readonly>
                            </div>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <label for="phone">No. Telepon</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    placeholder="Ketikkan Phone" autocomplete="off" value="{{ $model->phone }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="card-title">Ubah Password</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form id="formPassword" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="new_password">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="new_password" id="new_password"
                                            placeholder="Masukkan password baru" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text h-100" onclick="togglePassword('new_password')"
                                                style="cursor: pointer;">
                                                <i class="fa fa-eye" id="eye-new_password"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="new_password_confirmation"
                                            id="new_password_confirmation" placeholder="Konfirmasi password baru" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text h-100"
                                                onclick="togglePassword('new_password_confirmation')"
                                                style="cursor: pointer;">
                                                <i class="fa fa-eye" id="eye-new_password_confirmation"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <small id="password-match" class="form-text text-danger" style="display: none;">
                                        Password tidak sama!
                                    </small>
                                </div>
                                <div class="form-group text-end">
                                    <button type="submit" class="btn btn-primary" id="submit-btn" disabled
                                        onclick="simpan(event)">Ubah Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('admin.pengaturan.script')
@endpush
