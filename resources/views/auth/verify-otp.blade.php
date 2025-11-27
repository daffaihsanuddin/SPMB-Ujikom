@extends('layouts.app')

@section('title', 'Verifikasi OTP')
@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth-card p-4">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Verifikasi OTP</h2>
                        <p class="text-muted">Masukkan kode OTP yang dikirim ke email Anda</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>{!! session('success') !!}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>{!! session('warning') !!}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @php
                        $registrationData = Session::get('pending_registration');
                    @endphp

                    @if($registrationData)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Kode OTP telah dikirim ke: <strong>{{ $registrationData['email'] }}</strong>
                        <br><small>Kode berlaku selama 10 menit</small>
                        <br><small><strong>Data Anda akan disimpan setelah OTP berhasil diverifikasi</strong></small>
                    </div>
                    @endif

                    <!-- Form Verifikasi OTP -->
                    <form method="POST" action="{{ route('verification.verify') }}" id="otpForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="otp" class="form-label">Kode OTP (6 digit)</label>
                            <input type="text" class="form-control text-center fs-4 fw-bold" 
                                   id="otp" name="otp" required maxlength="6" 
                                   pattern="[0-9]{6}" placeholder="123456"
                                   value="{{ old('otp') }}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <div class="form-text text-center">
                                Masukkan 6 digit kode verifikasi
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Verifikasi & Simpan Data
                            </button>
                        </div>
                    </form>

                    <!-- Form Terpisah untuk Kirim Ulang OTP -->
                    <form method="POST" action="{{ route('verification.resend') }}" id="resendForm">
                        @csrf
                        <div class="text-center">
                            <p class="mb-2">Tidak menerima kode?</p>
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-redo me-1"></i>Kirim Ulang OTP
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('register') }}" class="text-muted" onclick="return confirm('Data registrasi Anda akan hilang. Yakin ingin kembali?')">
                            <i class="fas fa-arrow-left me-1"></i>Kembali ke halaman pendaftaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const otpInput = document.getElementById('otp');
        const otpForm = document.getElementById('otpForm');
        const resendForm = document.getElementById('resendForm');
        
        // Auto focus on OTP input
        if (otpInput) {
            otpInput.focus();
            
            // Auto submit when 6 digits are entered
            otpInput.addEventListener('input', function() {
                if (this.value.length === 6) {
                    otpForm.submit();
                }
            });
        }

        // Handle resend form submission
        if (resendForm) {
            resendForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Mengirim...';
                submitBtn.disabled = true;
                
                // Submit the form
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: new URLSearchParams(new FormData(this))
                })
                .then(response => response.text())
                .then(html => {
                    // Create temporary element to parse response
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    // Check if there's an alert in the response
                    const alert = tempDiv.querySelector('.alert');
                    if (alert) {
                        // Show alert message
                        const newAlert = alert.cloneNode(true);
                        document.querySelector('.auth-card').insertBefore(newAlert, document.querySelector('#otpForm'));
                        
                        // Auto remove alert after 5 seconds
                        setTimeout(() => {
                            if (newAlert.parentNode) {
                                newAlert.parentNode.removeChild(newAlert);
                            }
                        }, 5000);
                    }
                    
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    
                    // Show error message
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger';
                    errorAlert.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Gagal mengirim ulang OTP. Silakan coba lagi.';
                    document.querySelector('.auth-card').insertBefore(errorAlert, document.querySelector('#otpForm'));
                    
                    setTimeout(() => {
                        if (errorAlert.parentNode) {
                            errorAlert.parentNode.removeChild(errorAlert);
                        }
                    }, 5000);
                });
            });
        }
    });
</script>

<style>
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
@endsection