<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Notifications\VerificationOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'hp' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate OTP first (before saving to database)
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Log::info('Generated OTP for new registration: ' . $otp . ' - Email: ' . $request->email);

        // Store registration data in session (NOT in database yet)
        $registrationData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'hp' => $request->hp,
            'password' => $request->password,
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10)->timestamp,
            'created_at' => now()->timestamp
        ];

        Session::put('pending_registration', $registrationData);

        try {
            // Test email connection first
            $this->testEmailConnection();

            // Send OTP notification using temporary data
            $this->sendOtpEmail($request->email, $request->nama, $otp);

            Log::info('OTP email sent successfully to: ' . $request->email);

            return redirect()->route('verification.otp')
                ->with('success', 'Registrasi berhasil! Kami telah mengirim kode OTP ke email Anda.')
                ->with('debug_otp', config('app.debug') ? $otp : null);

        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());

            return redirect()->route('verification.otp')
                ->with('warning', 'Registrasi berhasil! Namun kami mengalami kendala mengirim email. 
                        Silakan catat kode OTP Anda: <strong>' . $otp . '</strong>')
                ->with('debug_info', 'Error: ' . $e->getMessage());
        }
    }

    private function testEmailConnection()
    {
        try {
            Mail::raw('Test Connection', function ($message) {
                $message->to(config('mail.from.address'))
                    ->subject('Test Connection SPMB');
            });
        } catch (\Exception $e) {
            throw new \Exception('Email connection failed: ' . $e->getMessage());
        }
    }

    private function sendOtpEmail($email, $nama, $otp)
    {
        try {
            Mail::send('emails.verification-otp', [
                'nama' => $nama,
                'otp' => $otp,
                'expires_in' => 10
            ], function ($message) use ($email, $nama) {
                $message->to($email)
                    ->subject('Kode Verifikasi OTP - SPMB Online');
            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to send OTP email: ' . $e->getMessage());
        }
    }

    public function showOtpVerificationForm()
    {
        if (!Session::has('pending_registration')) {
            return redirect()->route('register')
                ->with('error', 'Sesi registrasi tidak valid. Silakan daftar kembali.');
        }

        $registrationData = Session::get('pending_registration');

        // Check if OTP is expired
        if (now()->timestamp > $registrationData['otp_expires_at']) {
            Session::forget('pending_registration');
            return redirect()->route('register')
                ->with('error', 'Kode OTP telah kedaluwarsa. Silakan daftar kembali.');
        }

        $debugOtp = config('app.debug') ? $registrationData['otp'] : null;

        return view('auth.verify-otp', compact('debugOtp'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        // Debug: Log input OTP
        Log::info('OTP Verification Attempt', [
            'otp_input' => $request->otp,
            'has_session' => Session::has('pending_registration'),
            'session_data' => Session::get('pending_registration')
        ]);

        if (!Session::has('pending_registration')) {
            Log::warning('No pending registration session found');
            return redirect()->route('register')
                ->with('error', 'Sesi registrasi telah kedaluwarsa. Silakan daftar kembali.');
        }

        $registrationData = Session::get('pending_registration');

        // Check if OTP is expired
        if (now()->timestamp > $registrationData['otp_expires_at']) {
            Session::forget('pending_registration');
            Log::warning('OTP expired for email: ' . $registrationData['email']);
            return redirect()->route('register')
                ->with('error', 'Kode OTP telah kedaluwarsa. Silakan daftar kembali.');
        }

        // Verify OTP
        if ($request->otp !== $registrationData['otp']) {
            Log::warning('OTP mismatch for email: ' . $registrationData['email'] . ' - Expected: ' . $registrationData['otp'] . ' - Got: ' . $request->otp);
            return back()->withErrors([
                'otp' => 'Kode OTP tidak valid. Silakan coba lagi.',
            ])->withInput();
        }

        // OTP verified successfully - NOW save to database
        try {
            DB::beginTransaction();

            Log::info('Creating user in database for email: ' . $registrationData['email']);

            // : Hapus email_verified_at dari data yang akan disimpan
            $userData = [
                'nama' => $registrationData['nama'],
                'email' => $registrationData['email'],
                'hp' => $registrationData['hp'],
                'password_hash' => Hash::make($registrationData['password']),
                'role' => 'pendaftar',
                'aktif' => true,
                // 'email_verified_at' => now(), // HAPUS BARIS INI
            ];

            // Create user in database
            $pengguna = Pengguna::create($userData);

            DB::commit();

            Log::info('User registered successfully: ' . $pengguna->email . ' - ID: ' . $pengguna->id);

            // Clear session
            Session::forget('pending_registration');

            // Auto login after verification
            Auth::login($pengguna);

            Log::info('User logged in successfully: ' . $pengguna->email);

            return redirect()->route('pendaftar.dashboard')
                ->with('success', 'Verifikasi berhasil! Akun Anda telah aktif. Selamat datang di SPMB Online!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create user after OTP verification: ' . $e->getMessage());
            Log::error('Error details: ' . $e->getFile() . ':' . $e->getLine());

            return back()->withErrors([
                'otp' => 'Terjadi kesalahan sistem. Silakan coba lagi. Error: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function resendOtp(Request $request)
    {
        // Debug: Log resend attempt
        Log::info('OTP Resend Attempt', [
            'has_session' => Session::has('pending_registration'),
            'ajax' => $request->ajax()
        ]);

        if (!Session::has('pending_registration')) {
            $message = 'Sesi registrasi tidak valid. Silakan daftar kembali.';
            Log::warning($message);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 400);
            }
            return redirect()->route('register')
                ->with('error', $message);
        }

        $registrationData = Session::get('pending_registration');

        try {
            // Generate new OTP
            $newOtp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Update session with new OTP
            $registrationData['otp'] = $newOtp;
            $registrationData['otp_expires_at'] = now()->addMinutes(10)->timestamp;
            Session::put('pending_registration', $registrationData);

            Log::info('New OTP generated for email: ' . $registrationData['email'] . ' - OTP: ' . $newOtp);

            // Send new OTP notification
            $this->sendOtpEmail($registrationData['email'], $registrationData['nama'], $newOtp);

            Log::info('OTP resent successfully to: ' . $registrationData['email']);

            $successMessage = 'Kode OTP baru telah dikirim ke email Anda.';

            // Add debug info in development
            if (config('app.debug')) {
                $successMessage .= ' [DEBUG OTP: ' . $newOtp . ']';
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }

            return back()->with('success', $successMessage);

        } catch (\Exception $e) {
            Log::error('Failed to resend OTP: ' . $e->getMessage());

            $errorMessage = 'Gagal mengirim OTP. Silakan coba lagi.';

            // In development, show more details
            if (config('app.debug')) {
                $errorMessage .= ' Error: ' . $e->getMessage();
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return back()->with('error', $errorMessage);
        }
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cari pengguna berdasarkan email
        $pengguna = Pengguna::where('email', $request->email)->first();

        // Check if user exists
        if (!$pengguna) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.',
            ])->onlyInput('email');
        }

        // Check if account is active
        if (!$pengguna->aktif) {
            return back()->withErrors([
                'email' => 'Akun Anda belum aktif. Silakan hubungi administrator.',
            ])->onlyInput('email');
        }

        // Check password manually karena kita menggunakan password_hash bukan password
        if (!Hash::check($request->password, $pengguna->password_hash)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        // Manual login karena kita menggunakan tabel custom
        Auth::login($pengguna);

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, ' . $user->nama . '!');
            case 'verifikator_adm':
                return redirect()->route('verifikator.dashboard')
                    ->with('success', 'Selamat datang, ' . $user->nama . '!');
            case 'keuangan':
                return redirect()->route('keuangan.dashboard')
                    ->with('success', 'Selamat datang, ' . $user->nama . '!');
            case 'kepsek':
                return redirect()->route('kepsek.dashboard')
                    ->with('success', 'Selamat datang, ' . $user->nama . '!');
            case 'pendaftar':
                return redirect()->route('pendaftar.dashboard')
                    ->with('success', 'Selamat datang, ' . $user->nama . '!');
            default:
                return redirect()->route('home');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}