@extends('layouts.app')

@section('title', 'Registrasi Pendaftar')
@section('content')
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="auth-card p-4">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Registrasi Pendaftar</h2>
                            <p class="text-muted">Daftar akun untuk mengikuti SPMB Online</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                                    required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="hp" class="form-label">Nomor HP/WhatsApp *</label>
                                <input type="text" class="form-control" id="hp" name="hp" value="{{ old('hp') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password *</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">Daftar Sekarang</button>
                            </div>

                            <div class="text-center">
                                <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection